<?php

namespace App\Http\Controllers\helper;

use App\Gender;
use App\Http\Controllers\DashboardController;
use App\Profile;
use App\Role;
use App\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class HelperController extends Controller
{


    ///defualt password generator

    public  static function generatePasswod()
    {
        $alphabet = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = random_int(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        array_splice( $pass, random_int(1,count($pass)-1), 0, (array) self::addSpecial()[0]);

        $pas = implode(',', $pass);

        return str_replace(',','',$pas);
    }
    public  static function addSpecial()
    {

        $alphabet = '!#';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 3; $i++) {
            $n = random_int(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);

    }

    ///defualt password generator
    public  static function generateAgentCode()
    {

        $alphabet = '1234567890';
        $code = [];
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $code[] = $alphabet[$n];
        }
        return implode($code);
    }

    ///defualt password generator
    public  static function generatePin()
    {

        $alphabet = '1234567890';
        $code = [];
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 4; $i++) {
            $n = rand(0, $alphaLength);
            $code[] = $alphabet[$n];
        }
        return implode($code);
    }

    public  static  function  apiToken(){

      return   Str::random(60);
    }


}
