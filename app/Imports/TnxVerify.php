<?php

namespace App\Imports;

use App\TransactionVerify;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TnxVerify implements ToModel,WithHeadingRow
{

    /**
     * @param array $row
     *
     * @return TransactionVerify
     * @throws \Exception
     */

    public function model(array $row)
    {
        return new TransactionVerify([
            'channel'     => @$row["channel"],
            'ref_number'    => @$row["reference"],
            'phone_number'    => @$row["phone_number"],
            'amount'=>@$row["amount"],
            'channel_ref_no'=> @preg_replace('/\s+/', '', $row["transaction_id"]),
            'tnx_date'=>date('Y-m-d',strtotime(@$row["date"]))
        ]);
    }
}
