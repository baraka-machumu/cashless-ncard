<?php


namespace App\Http\Controllers\Tpesa;


use App\Http\Controllers\Controller;
use App\Jobs\ProcessTxJob;

class PushTxController extends Controller
{

    public  static function  push(){

    return    ProcessTxJob::dispatch();

    }

}
