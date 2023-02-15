<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class AgentSummaryExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder, FromCollection, WithHeadings,WithColumnFormatting,ShouldAutoSize
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
            $result= DB::select('call GetAgentSoldCardSp(?,?,?)',array($this->agent_code,$this->start_date,$this->end_date));
        }
        else {
            $result= DB::select('call GetAgentSoldCardSp(?,?,?)',array(null,$this->start_date,$this->end_date));
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Card Number',
            'Agent Code',
            'Fullname',
            'Phone Number',
            'Created Date',
            'Wallet Id',
            'CustomerFullName',
            "CustomerPhone"
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
