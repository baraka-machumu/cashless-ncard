<?php


namespace App\Http\Controllers\AdvancedSettings;


use App\Http\Controllers\Controller;
use App\NcardCollectionAccount;
use App\NcardDisbursementAccount;

class DisbursementAccountController extends Controller
{

    public  function  index(){

        $account  = NcardDisbursementAccount::query()
            ->select('description as name','id','created_at','wallet_number','type','total_balance')
            ->get();

        return view('advanced_settings.disbursement.index',compact('account'));

    }
}
