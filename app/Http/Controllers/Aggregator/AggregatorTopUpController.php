<?php


namespace App\Http\Controllers\Aggregator;


use App\AgentDeposit;
use App\AgentWallet;
use App\AggregatorWallet;
use App\Helper\RandomGenerator;
use App\Http\Controllers\Agent\TpesaNcardFund;
use App\Http\Controllers\Controller;
use App\TpesaRequestTopup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AggregatorTopUpController extends Controller
{

    public  function  topup(Request $request){

        Log::channel('tx-agent-deposit')->error('request'.json_encode($request));

        $agent_code =  $request->agent_code;


        $amount =  $request->amount ;
        $sourceAccount =  $request->accountFrom;

        $channel_reference  = RandomGenerator::referenceNumber($agent_code);

        $timestamp  =  Carbon::now('Africa/Nairobi')->format('Y-m-d h:i:s');

        $timestamp  = date('Y-m-d\TH:i:s'.'\Z');

        $ncardResponse  =  TpesaNcardFund::saveAggregatorTopup($amount,$channel_reference,$agent_code,$timestamp,$sourceAccount,null);

        if ($ncardResponse['code']!=TpesaNcardFund::SUCCESS){

            Session::flash('alert-danger',' '.$ncardResponse['message']);

            return redirect('/aggregators/view/'.$agent_code);

        }

        try{

            DB::beginTransaction();

            $agent =     AggregatorWallet::where(['aggregator_code'=>$agent_code])->first();

            if (!$agent){

                Session::flash('alert-danger','agent does not exist');

                return back();

            }

            $previousBalance =  $agent->current_balance;


            $agentDeposit  =  new AgentDeposit();

//            $reference  =  RandomGenerator::referenceNumber($agent_code);

            $tx  =  DB::select('call AASaveAggregatorDepositsSP(?,?,?,?)',array($agent_code,$amount,$previousBalance,Auth::user()->id));


            if ($tx[0]->status_code!=300){

                Session::flash('alert-danger',''.$tx[0]->message);

                return redirect('/aggregators/view/'.$agent_code);

            }

            Log::channel('tx-agent-deposit')->error('Successful top up : '.$agent_code.' With reference id '.$channel_reference);

            $desc  = "Top up aggregator from browser.";

            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$agent_code,'AGGREGATOR','TOP-UP'));

            $tpesaResponse  =  TpesaRequestTopup::query()->where(['reference'=>$channel_reference])->first();

            if ($tx[0]->status_code==300){

                $tpesaResponse->deposit_id  =  $tx[0]->deposit_id;
                $tpesaResponse->save();
                DB::commit();

            }

            Session::flash('alert-success','successful saved');

            return redirect('/aggregators/view/'.$agent_code);

        }

        catch (\Throwable $exception){

            Log::error($exception->getMessage());
            Log::error($exception);

            Log::channel('tx-agent-deposit')->error('Server error top up agent : '.json_encode($exception));

            Session::flash('alert-danger','could not credit agent '.$exception->getMessage());

            return redirect('/aggregators/view/'.$agent_code);

        }

    }

}
