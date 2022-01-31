<?php

namespace App\Imports;

use App\Card;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportCards implements ToCollection , WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {

            Card::create([
                'card_uid'=>$row['card_uid'],
                'card_number'=>str_replace(' ','',$row['card_number'])
            ]);
        }
    }


}
