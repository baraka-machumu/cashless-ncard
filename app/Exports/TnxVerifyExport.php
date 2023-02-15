<?php

namespace App\Exports;

use App\TransactionVerify;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TnxVerifyExport implements  FromView
{

    public function view(): View
    {
        return view('exports.tnx_verify', [
            'tnx_verify' => TransactionVerify::all()
        ]);
    }
}
