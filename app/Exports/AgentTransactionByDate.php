<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgentTransactionByDate implements FromCollection, WithHeadings
{

    use Exportable;

    protected $data;

    function __construct($data) {
        $this->data = $data;

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return (collect($this->data));
    }


    public function headings(): array
    {

        return [
            'Agent Code',
            'Amount',
            'Previous Balance',
            'Current Balance<',
            'Created',
            'Created by',
            'Reference'
        ];

    }
}
