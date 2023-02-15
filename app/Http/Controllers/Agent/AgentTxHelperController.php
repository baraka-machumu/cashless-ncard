<?php

namespace App\Http\Controllers\Agent;

use App\AgentDeposit;
use App\AgentWallet;
use App\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AgentTxHelperController extends Controller
{

    public  function  reprocess(Request  $request,$agent_code){

        $agent  = AgentWallet::where(['agents_code'=>$agent_code])->first();

        $tx  =  DB::select('call PortalViewAgentLogsTnxById(?)',[$request->tx_id])[0];


        $payload  = [
            'agent_code'=>$agent_code,
            'super_agent'=>'123456',
            'slip_path'=>$agent_code,
            'amount'=>$tx->amount,
            'date'=>$tx->created_at,
            'source_wallet'=>'123456',
            'refNo'=>$tx->ref_no,
            'RETRYTNX'=>1
        ];

        $result  =  ApiHelper::sendAgentTopup($payload);

        DB::table('agent_topup_request_logs')
            ->where(['ref_no'=>$tx->ref_no,'agent_code'=>$agent_code])
            ->update(['response_dump'=>json_encode($result),
                'response_code'=>$result->status_code,
            ]);
        $response_ref_number = null;
        if ($result->status_code=='300'){
            $response_ref_number=$result->data->OutTrxRefNo;
        }
        if ($result->status_code=='02'){
            $response_ref_number=$result->data->OutTrxRefNo;
        }

        DB::beginTransaction();

        try {

            $previousBalance =  $agent->amount;
            $currentBalance = $previousBalance+$tx->amount;

            DB::table('agent_topup_request_logs')
                ->where(['ref_no'=>$tx->ref_no,'agent_code'=>$agent_code])
                ->update(['response_dump'=>json_encode($result),
                    'response_code'=>300,
                    'response_ref_number'=>$response_ref_number
                ]);

            $deposit  =  new AgentDeposit();
            $deposit->agent_wallet_id =  $agent_code;
            $deposit->amount =  $tx->amount;
            $deposit->tx_channel_reference =  $tx->user_ref_number;
            $deposit->previous_balance=  $previousBalance;
            $deposit->current_balance  =  $currentBalance;
            $deposit->reference  = $tx->ref_no;
            $deposit->created_by  = Auth::user()->id;
            $deposit->save();

            $agent->amount  =  $currentBalance;
            $agent->previous_balance =  $previousBalance;
            $agent->save();
            DB::commit();
            Session::flash('alert-success','Successful saved');
            return redirect('agents/'.$agent_code);

        }catch (\Throwable $exception){

            Log::error('REPROCESS-ERROR',['MESSAGE'=>$exception]);
            Session::flash('alert-danger','Server error');
            return back();
        }
    }

}
