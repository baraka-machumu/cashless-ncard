<?php


namespace App\Http\Controllers\Charge;


use App\Charge;
use App\Http\Controllers\Controller;

class ChargesController extends  Controller
{

    public  function  index(){


        $data  =  Charge::query()->select('name','amount','description','code','created_at')->get();

        return view('advanced_settings.charges.index',compact('data'));

    }

}
