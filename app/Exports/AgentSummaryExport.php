<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class AgentSummaryExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $agent_code,$start_date,$end_date;

    function __construct($agent_code,$start_date,$end_date) {
        $this->agent_code = $agent_code;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {

        if ($this->agent_code!='default'){
            $result= DB::select('call GetAgentSummarySp(?,?,?)',array($this->agent_code,$this->start_date,$this->end_date));
        }
        else {
            $result= DB::select('call GetAgentSummarySp(?,?,?)',array(null,$this->start_date,$this->end_date));
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Total Card Sold',
            'Agent Code',
            'Fullname',
            'Phone Number',
        ];
    }
}
