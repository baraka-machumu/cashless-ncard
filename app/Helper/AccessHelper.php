<?php


namespace App\Helper;


use Illuminate\Support\Facades\Auth;

class AccessHelper
{

    public  static  function checkIfHasPermission($permId){

        $user  = \App\User::with('roles')->where('id','=',Auth::user()->id)->first();

        $found  =  'false';
        foreach ($user['roles'] as $perm){
            foreach ($perm['permissions'] as $permission){
                if ($permission->id ==$permId){

                    $found = 'true';

                }

            }
        }

        return $found;
    }
}
