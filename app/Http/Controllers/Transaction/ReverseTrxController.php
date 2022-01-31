<?php


namespace App\Http\Controllers\Transaction;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReverseTrxController extends  Controller
{

    public  function  index(){

        $result  = null;

        return view('reverse.index',compact('result'));

    }

    public  function  get(){

        $result  =  array();

        return view('reverse.index',compact('result'));

    }

        public  function  reverse(Request  $request){

        return redirect('trx-reverse');

    }

    public  function  trxReverseLogs(){

    }


}
