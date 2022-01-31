<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgentTransaction implements FromCollection, WithHeadings
{

    use Exportable;

    protected $agent_code,$start_date,$end_date;

    function __construct($start_date,$end_date,$agent_code=null) {
        $this->agent_code = $agent_code;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
//        dd($this->end_date);
        $result= DB::select('call GetAgentTransactionByDateSP(?,?,?)',array(null,$this->start_date,$this->end_date));

        return (collect($result));
    }


    public function headings(): array
    {

        return [

            'Agent Code',
            'Total Transaction',
            'Total Amount',
            'Recipient ID',
            'Date',
            'Terminal device ID'
        ];

    }
}
