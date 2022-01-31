<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReporttypeController extends Controller
{
    public function editProfile()
    {
        $report_types = DB::table('report_types')->get('description');
        return view('reports.index', compact($report_types));
    }
}
