<?php


namespace App\Http\Controllers\AdvancedSettings;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApiManagerController extends Controller
{

    public  function  index(){

        $res  =  DB::select('call GetApiSP');

        return view('advanced_settings.api',compact('res'));

    }

    public  function  store(){

        $res  =  DB::select('call  saveApiSP');

        return redirect('advanced-settings/api');

    }
}
