<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ExportRevenueDataAllMerchant implements  FromView,WithTitle,ShouldAutoSize,WithEvents
{

    public  $data;
    public  $date_from;
    public  $date_to;

    /**
     * @param $data
     * @param $date_from
     * @param $date_to
     */

    public function __construct($data, $date_from, $date_to)
    {
        $this->data = $data;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }


    public function view(): View
    {

        $dataRevenue =   $this->data;
        $date_from = $this->date_from;
        $date_to = $this->date_to;

        return view('reports.revenue_by_all_merchant',compact('dataRevenue','date_from','date_to'));

    }


    public function title(): string
    {

        return 'TX Summary Report ';

    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('/assets/images/ncard_logo.png'));
        $drawing->setHeight(90);

        return $drawing;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

            },
        ];
    }
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

}
