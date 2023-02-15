<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ConsumerSearchController extends Controller
{

    public  function  search(Request  $request){
        if (!Gate::allows('manage-consumer')) {

            return redirect('error-access');

        }

        $column = 'phone_number';
        $search =  $request->phone_number;

        if (!empty($request->phone_number)){

            $column  = 'phone_number';

            $search =  $request->phone_number;
        }
        if (!empty($request->walletId)){

            $column  = 'wallet_id';

            $search =  $request->walletId;
        }

        if (!empty($request->Fullname)){

            $column  = 'first_name';

            $search =  $request->Fullname;
        }

        $consumers= DB::table('consumer_wallets')
            ->select('consumer_cards.card_number','consumers.status_id','consumer_wallets.wallet_id','consumers.agent_code','consumers.phone_number','consumers.first_name','consumers.last_name')
            ->join('consumers', 'consumers.id', '=', 'consumer_wallets.consumers_id')
            ->leftJoin('consumer_cards', 'consumer_cards.consumers_wallet_id', '=', 'consumer_wallets.wallet_id')
            ->where([$column=>$search])
            ->get();


        return view('consumers.index',compact('consumers'));

    }



}
