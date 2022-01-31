<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportMnoTrnx implements FromCollection, WithHeadings
{

    use Exportable;

    protected $mno_id,$start_date,$end_date;

    function __construct($mno_id,$start_date,$end_date) {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->mno_id = $mno_id;

    }

    /**
     * @return Collection
     */
    public function collection()
    {
//        dd($this->end_date);
        $result  =  DB::select('call GetMnoDepositsTrnxByDateSP(?,?,?)',array($this->mno_id,$this->start_date,$this->end_date));
        return (collect($result));
    }


    public function headings(): array
    {

        return [

            'Total Amount',
            'CHANNEL',
            'Wallet ID',
            'created_at',
            'transaction_date',
            'phone_number',
            'source_ref',
            'ncard_reference'

        ];

    }
}
