<?php

namespace App;

use App\Helper\PermissionList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{


    public function roles()
    {
        return $this->belongsToMany('App\Role','role_permissions')->with('users');
    }

    /*check if user has permission to create payment of verification.*/

    public  static function finance()
    {

        return self::getPermission(PermissionList::FINANCE_ACTIVITY);

    }

    public  static function customerRefund()
    {
        return self::getPermission(PermissionList::CUSTOMER_REFUND);


    }
    public  static function managerUser()
    {

        return self::getPermission(PermissionList::MANAGE_USER);

    }

    public  static function managerMerchant()
    {

        return self::getPermission(PermissionList::MANAGE_MERCHANT);

    }
    public  static function managerAgent()
    {

        return self::getPermission(PermissionList::MANAGE_AGENT);

    }

    public  static function managerConsumer()
    {

        return self::getPermission(PermissionList::MANAGE_CONSUMER);

    }
    public  static function customercare()
    {

        return self::getPermission(PermissionList::CUSTOMER_CARE);

    }
    public  static function lowAccount()
    {

        return self::getPermission(PermissionList::LOW_ACCOUNT);

    }
    public  static function manageCardPos()
    {

        return self::getPermission(PermissionList::MANAGE_CARD_POS);

    }
    public  static function manageServiceRolePerm()
    {

        return self::getPermission(PermissionList::CUSTOMER_CARE);

    }

    public  static function viewTransaction()
    {

        return self::getPermission(PermissionList::CAN_VIEW_TRANSACTION);

    }

    public  static function managerWallet()
    {

        return self::getPermission(PermissionList::MANAGE_WALLETS);

    }
    public  static function viewReport()
    {

        return self::getPermission(PermissionList::VIEW_REPORT);

    }
    public  static function agentToup()
    {

        return self::getPermission(PermissionList::MANAGE_TOPUP);

    }
    public  static function agentUpdate()
    {

        return self::getPermission(PermissionList::UPDATE_AGENT);

    }

    public  static function consumerUpdate()
    {

        return self::getPermission(PermissionList::UPDATE_CONSUMER);

    }
    public  static function transferRevenue()
    {

        return self::getPermission(PermissionList::TRANSFER_REVENUE);

    }

    public  static function reconcile()
    {

        return self::getPermission(PermissionList::RECONCILE);

    }


    public  static  function  manageConsumerCredentials(){

        return self::getPermission(PermissionList::MANAGE_CONSUMER_CREDO);

    }
    /*get permission by code.*/

    public  static  function getPermission($permissionCode){

        $user  = \App\User::with('roles')->where('id','=',Auth::user()->id)->first();

        $found  =  0;
        foreach ($user['roles'] as $perm){
            foreach ($perm['permissions'] as $permission){

                if ($permission->id ==$permissionCode){

                    $found = 1;
                }

            }
        }

        if ($found===1){

            return true;

        }

        return false;
    }

}
