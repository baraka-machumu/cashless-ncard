<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportMerchantCollection implements FromCollection, WithHeadings
{

    use Exportable;

    protected $tin,$start_date,$end_date;

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
        $result  =  DB::select('call GetMerchantCollectionRecSP(?,?,?)',array($this->start_date,$this->end_date,$this->tin));
        return (collect($result));
    }


    public function headings(): array
    {

        return [

            'Wallet ID',
            'Total Amount',
            'Reference',
            'Date',
            'Wallet Type'
        ];

    }
}
