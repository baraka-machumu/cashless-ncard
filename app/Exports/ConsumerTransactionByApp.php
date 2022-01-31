<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConsumerTransactionByApp implements FromCollection, WithHeadings
{

    use Exportable;

    protected $agent_code,$start_date,$end_date,$tin;

    function __construct($start_date,$end_date,$tin) {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->tin = $tin;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
//        dd($this->end_date);

        $result= DB::select('call GetConsumerTransactionByMobileApp(?,?,?,?)',array($this->start_date,$this->end_date,$this->tin,1000));


        return (collect($result));
    }


    public function headings(): array
    {

        return [

            'Wallet ID',
            'Recipient ID',
            'Reference',
            'Date',
            'Transaction Type',
            'Total Amount',
            'Card Number',
            'Device Id'

        ];

    }
}
