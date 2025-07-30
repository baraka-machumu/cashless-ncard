<?php

namespace App\Http\Controllers\Wallet;

use App\ConsumerWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class NcardDestroyController extends Controller
{


    public  function  index(){

        $accounts = DB::table('ncard_destro_accounts')
            ->select('account_number','id','name','amount','created_at')->get();
        return view('wallets.destroy_account',compact('accounts'));
    }
}
