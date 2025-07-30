<?php

namespace App\Http\Controllers\Adjustment;

use App\AgentDeposit;
use App\AgentWallet;
use App\Helper\RandomGenerator;
use App\Http\Controllers\Controller;
use App\NcardDestroAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdjustmentController extends Controller
{
    public  function  index(){

        $data  =   DB::select('call PortalGetAllAdjustmentSP');

        $agents = DB::table('agents')->select('agent_code','first_name','last_name')->get();

        $source  = DB::table('destroy_fund_source')->select('code','name')->get();

        $distro_account  =  DB::table('ncard_destro_accounts')->select('account_number','name')->get();

        return view('adjustment.index',compact('data','agents','source','distro_account'));

    }


    public  function  save(Request  $request){


        $amount  = $request->get('amount');
        $ref  = $request->get('ref');
        $created_by  = Auth::user()->id;
        $card_number  = $request->get('card_number');

        $consumer  = DB::table('consumer_cards')
            ->select('consumers_wallet_id','consumer_id')
        ->where('card_number','=',$card_number)->first();
        if (!$consumer){

            Session::flash('alert-danger','No record found');
            return  redirect('adjustment');
        }
        $wallet_id= $consumer->consumers_wallet_id;
        $consumer_id = $consumer->consumer_id;

        $desc  = $request->get('desc');


        /**
         * This procedure record and approve and reject the adujustment
         * `PortalManageDebitAdjustmentSP`(amountTnx DECIMAL(10,2),refNo VARCHAR(20),createdBy INT(11),
        cardNo VARCHAR(20),walletId VARCHAR(15),customerId BIGINT,descriptionMessage VARCHAR(255),itemId BIGINT
         * ,operation VARCHAR(10))
         */

        $result  = DB::select('CALL PortalManageDebitAdjustmentSP (?,?,?,?,?,?,?,?,?,?,?)',[
            $amount,null,$created_by,$card_number,$wallet_id,$consumer_id,$desc,null,
            'MAKER',$request->account_number,$request->source
        ]);
        $error  = 'success';
        if ($result[0]->status_code!='300'){
            $error  = 'danger';
        }

        Session::flash('alert-'.$error,''.$result[0]->message);
        return  redirect('adjustment');

    }

    public  function  approve(Request  $request){

        if (!Gate::allows('approve-adjustment')){
           // Session::flash('alert-danger','No Access');
            //return  redirect('adjustment');
        }

        $created_by  = Auth::user()->id;
        $id  =  $request->adId;

        if (DB::table('adjustment')->select('id')->where(['id'=>$id,'created_by'=>$created_by])->first()){
//            Session::flash('alert-danger','You cannot approve This request.');
//            return  redirect('adjustment');
        }

        DB::beginTransaction();
        try {
            $result  = DB::select('CALL PortalManageDebitAdjustmentSP (?,?,?,?,?,?,?,?,?,?,?)',[
                null,null,$created_by,null,null,null,'Approved',$id,'CHECKER',null,null
            ]);
            $error  = 'success';
            if ($result[0]->status_code!='300'){
                $error  = 'danger';
                Session::flash('alert-'.$error,''.$result[0]->message);
                DB::rollBack();
                return  redirect('adjustment');
            }

            $account  =  DB::table('adjustment')->select('source_account','source')->where(['id'=>$id])->first();
            $desc  = "Creation of  debit adjustment ";
            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$result[0]->agent_code,'Adjustment','CREATION'));
            if ($account->source=='ND'){
//                dd($account);
                $ncardDistAccount  = NcardDestroAccount::query()->where(['account_number'=>$account->source_account])->first();
                $ncardDistAccount->amount  = $ncardDistAccount->amount+$result[0]->amount;
                $successN = $ncardDistAccount->save();
                $agent_code = $account->source_account;

                if (!$successN){
                    DB::rollBack();
                    Session::flash('alert-danger','Failed to save record');
                    return  redirect('adjustment');
                }

            }else{
                $agent_code  = $result[0]->agent_code;
                $agent  = AgentWallet::where(['agents_code'=>$agent_code])->first();
                $reference  =  RandomGenerator::referenceNumber($agent_code);
                $channel_reference = time().'-'.$reference;
                $amount = $result[0]->amount;
                $previousBalance =  $agent->amount;
                $currentBalance = $previousBalance+$amount;
                $agentDeposit  =  new AgentDeposit();
                $agentDeposit->agent_wallet_id =  $agent_code;
                $agentDeposit->amount =  $amount;
                $agentDeposit->tx_channel_reference =  $channel_reference;
                $agentDeposit->previous_balance=  $previousBalance;
                $agentDeposit->current_balance  =  $currentBalance;
                $agentDeposit->reference  = $reference;
                $agentDeposit->created_by  = Auth::user()->id;
                $agentDeposit->source_wallet_number  =  '008008';

                $agentSuccess=$agentDeposit->save();

                if (!$agentSuccess){
                    DB::rollBack();
                    Session::flash('alert-danger','Failed to save record');
                    return  redirect('adjustment');
                }

                $agent->amount  =  $currentBalance;
                $agent->previous_balance =  $previousBalance;
                $agent=$agent->save();

                if (!$agent){
                    DB::rollBack();
                    Session::flash('alert-danger','Failed to update wallet');
                    return  redirect('adjustment');
                }
            }


            Log::channel('tx-agent-deposit')->error('Successful top up : '.$agent_code);
            $desc  = 'processing  adjustment for account '>$agent_code;
            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agent_code,'ADJUST','VIEW'));

            DB::commit();
            $desc  = "Approve debit adjustment ";
            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agent_code,'Adjustment','APPROVE'));
            Session::flash('alert-success','Successful saved');
            return  redirect('adjustment');
        }catch (\Throwable $exception){

            DB::rollBack();
            Log::error('ADJUST-ERROR',['MESSAGE'=>$exception]);
            Session::flash('alert-danger','Server error');
            return  redirect('adjustment');
        }

    }
}
