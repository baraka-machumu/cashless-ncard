<?php

namespace App\Http\Controllers\access;

use App\Role;
use App\User;

use App\ConsumerWallet;
use function Couchbase\defaultDecoder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ErrorController extends Controller
{


    public  function  errorLogin(){

        return view('error.login_access');

    }


    public  function  accessDenied(){

        return view('error.access_denied');

    }



    public static function  UnknowResource($modal,$modalId,$id)
    {

        $captureWalletIdException = $modal::where($modalId, $id)->first();

        if (!$captureWalletIdException) {

            return false;

        }  else {

            return  true;
        }
    }
}
