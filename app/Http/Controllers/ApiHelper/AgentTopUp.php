<?php

    namespace App\Http\Controllers\ApiHelper;

    use App\AgentDeposit;
    use App\AgentWallet;
    use App\Bank;
    use App\BankBranch;
    use App\TxDeposit;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Validator;

    class AgentTopUp
    {

        public static function storeTopup($data){

            $channel  =  'T-PESA';

            $txDeposit = new TxDeposit();

            Log::channel('tx-agent-deposit')->error('Payload from mno : '.json_encode($data));

            DB::beginTransaction();
            try {
                $txDeposit->payload = json_encode($data);
                $txDeposit->topup_type = 'CONSUMER';

                $txDeposit->save();

                $walletId = $data->wallet_id;

                $reference = $data->reference;
                $amount = $data->amount;
                $bank = null;
                $branch = null;

                $deposit = new AgentDeposit();

                $deposit->agent_wallet_id = $walletId;
                $deposit->amount = $amount;
                $deposit->reference = $reference;

                if ($channel == 'OTHER') {

                    $deposit->bank = $bank;
                    $deposit->branch = $branch;
                }

                $deposit->channel = $channel;

                $deposit->save();

                $wallet = AgentWallet::where('agents_code', $walletId)->first();

                $amount = $wallet->amount + $amount;

                DB::table('agent_wallets')->where(['agents_code' => $walletId])->update(['amount' => $amount]);

                DB::table('agent_deposits')->where('reference', $reference)->update(['status' => 1]);

                DB::commit();

                Log::channel('tx-deposit')->info('Successful top up consumer : '.$walletId);

                return response()->json(['resultcode' => '0', 'message' => 'Confirmed '.$data->reference.' You have Successful Debited your N card  with walletId '.$walletId]);

            } catch (\Exception $exception){
                Log::channel('tx-deposit')->error('Can\'t top up agent : '.$exception->getMessage());
                DB::rollBack();

                return response()->json(['resultcode' => '1','message' => 'Failed To Debit agent '.$exception->getMessage()]);

            }

        }

    }
