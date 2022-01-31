<?php


namespace App\Http\Controllers\Merchant;


use App\AccountNumberHistory;
use App\Http\Controllers\Controller;
use App\Merchant;
use App\NcardCommsionPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MerchantActionsController extends  Controller
{

    public  function  updateAccountNumber(Request  $request){


        $accountNo  = $request->accountNo;
        $tin =  $request->tin;


        $merchant = Merchant::where(['tin'=>$tin])->first();

        $checkAccountNo  = Merchant::query()->select('account_number')->where(['account_number'=>$accountNo])->first();

        if ($checkAccountNo){

            Session::flash('alert-danger','This Account Number Already Exists');

            return  redirect('merchants/'.$tin);
        }

        if (!$merchant){

            return back();
        }


        $ahistory  = new AccountNumberHistory();

        $ahistory->tin = $tin;
        $ahistory->account_number  =  $merchant->account_number;
        $ahistory->current_account_number  = $accountNo;
        $ahistory->reason  = 'Expired';
        $successH = $ahistory->save();


        if (!$successH){

            return  back();

        }

        $merchant->account_number  = $accountNo;
        $success   = $merchant->save();

        if ($success){

            Session::flash('alert-success','Successful updated');

            return  redirect('merchants/'.$tin);

        }

        else {

            Session::flash('alert-danger','Failed to update');

            return  redirect('merchants/'.$tin);
        }

    }


    public  function  setCommission(Request $request,$tin){

        $percentage  =  $request->percentage;

        $commission  = new NcardCommsionPolicy();

        $commission->percentage  =  $percentage/100;
        $commission->merchant_tin  =  $tin;
        $commission->created_by_id =  Auth::user()->id;
        $success = $commission->save();

        if ($success){

            Session::flash('alert-success','Successful updated');

            return  redirect('merchants/'.$tin);

        }

        else {

            Session::flash('alert-danger','Failed to update');

            return  redirect('merchants/'.$tin);
        }

    }
}
