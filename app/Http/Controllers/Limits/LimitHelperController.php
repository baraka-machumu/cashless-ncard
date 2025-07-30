<?php

namespace App\Http\Controllers\Limits;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LimitHelperController extends Controller
{

    public  function  getCurrencyPerClassCode($class_code){

    return    response()->json(DB::select('call GETCurrencyByClass(?)',array($class_code))[0]);

    }

}
