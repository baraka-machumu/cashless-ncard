<?php

namespace App\Imports;

use App\ConsumerCard;
use App\ConsumerWallet;
use App\mno_consumer_refund;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ExcelBalance implements  ToCollection,WithHeadingRow,WithValidation
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $row)
        {

//            dd(trim($row['matumizicarduid'],' '));

            $card  = ConsumerCard::query()->where(['card_uid'=>trim($row['matumizicarduid'],' ')])->first();

//            dd($card);

            if ($card){

                mno_consumer_refund::create([

                    'amount' => trim($row['refund'],' '),
                    'card_uid' => trim($row['matumizicarduid'],' '),
                    'wallet_id' => $card->consumers_wallet_id,
                    'phone_number' => trim($row['matumiziphone'],' '),
                    'created_by' => Auth::user()->id,

                ]);

                $wallet  = ConsumerWallet::query()->lockForUpdate()->where(['wallet_id'=>$card->consumers_wallet_id])->first();

                $balance  = trim($row['refund'],' ')+$wallet->amount;

                $wallet->amount  =  $balance;
                $wallet->previous_balance  =  $wallet->amount;
                $wallet->current_topup  =  $balance;
                $wallet->last_payment_datetime  =  Carbon::now('Africa/Nairobi');
                $wallet->save();


            }


        }
    }


    /**
     * @return array
     */
    public function rules(): array
    {
        return  [

            'Refund'=>'required',
            'MatumiziPhone'=>'required',
            'MatumiziCardUID'=>'required',


        ];
    }

}
