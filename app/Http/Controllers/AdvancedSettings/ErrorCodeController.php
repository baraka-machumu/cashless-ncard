<?php


namespace App\Http\Controllers\AdvancedSettings;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ErrorCodeController extends Controller
{

    public  function  index(){

        $res  =  DB::select('call GetErrorCodeSP');

        return view('advanced_settings.error_codes',compact('res'));

    }

    public  function  store(){

        $res  =  DB::select('call  saveErrorCodeSP');

        return redirect('advanced-settings/error-codes');

    }
}
