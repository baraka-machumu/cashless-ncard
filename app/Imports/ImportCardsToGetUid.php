<?php

namespace App\Imports;

use App\Card;
use App\CardTmpUid;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportCardsToGetUid implements ToCollection , WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
            $result  = DB::table('cards')->select('card_uid')->where(['card_number'=>$row['card_number']])->first();
            if(!$result) {
                continue;
            }
            CardTmpUid::create([
                'card_number' =>  str_replace("'", "", $row['card_number']) ,
                'card_uid' => $result->card_uid,
            ]);
        }
    }


}
