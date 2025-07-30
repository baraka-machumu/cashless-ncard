<?php

namespace App\Exports;

use App\CardTmpUid;
use App\TransactionVerify;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CardUidExport implements  FromView
{

    public function view(): View
    {
        return view('exports.card_data', [
            'card_data' => CardTmpUid::all()
        ]);
    }
}
