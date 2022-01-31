<?php


namespace App\Http\Controllers\AdvancedSettings;


use App\Http\Controllers\Controller;
use App\NcardCollectionAccount;

class NcardCollectionAccountController extends Controller
{


    public  function  index(){

        $account  = NcardCollectionAccount::query()
            ->select('name','id','created_at','account_number','type','amount','last_received_date')
            ->get();

        return view('advanced_settings.index',compact('account'));

    }


}
