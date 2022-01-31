<?php

namespace App\Http\Controllers\Recon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReconcilliationController extends Controller
{

    public  function  getReconByDate(Request $request){

        return view('recon.recon_by_date');
    }

    public  function getTodayRecon(){

        return view('recon.recon_today');

    }

    public  function  requestControlNumber(){

    }

    public  function  pushMerchantPayment(){

    }
}
