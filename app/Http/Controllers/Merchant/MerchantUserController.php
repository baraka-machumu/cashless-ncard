<?php


namespace App\Http\Controllers\Merchant;


use App\Http\Controllers\Controller;
use App\MerchantUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function GuzzleHttp\Promise\queue;

class MerchantUserController extends Controller
{

    public  function  index($tin){

        $users   = MerchantUser::query()->where(['merchant_tin'=>$tin])->get();

        return view('merchants.user.index',compact('users','tin'));

    }

    public  function  store(Request  $request,$tin){

        $users   = new MerchantUser();

        $users->name  = $request->fullname;
        $users->password  = Hash::make($request->password);
        $users->phone_number  = $request->phone_number;
        $users->email  = $request->email;
        $users->merchant_tin  =  $tin;
        $users->save();

        return  redirect('merchants/users/'.$tin);


    }


    public  function  edit($tin,$user_id){

    }

    public  function  update(Request  $request,$tin){

        $users   =  MerchantUser::query()->first();

        $users->name  = $request->fullname;
//        $users->password  = $request->password;
        $users->phone_number  = $request->phone_number;
        $users->email  = $request->email;
        $users->merchant_tin  =  $tin;
        $users->save();

        return  redirect('merchants/users/'.$tin);

    }

    public  function  disable($user_id,$tin){

        return  redirect('merchants/users/'.$tin);

    }

    public  function  enable($user_id,$tin){

        return  redirect('merchants/users/'.$tin);

    }
}
