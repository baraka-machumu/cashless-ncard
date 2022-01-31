<?php


namespace App\Helper;


class PermissionList
{

    public  const  MANAGE_USER=100;
    public  const  MANAGE_MERCHANT=200;
    public  const  MANAGE_AGENT=300;
    public  const  PUSH_PAYMENTS=400;
    public  const  CUSTOMER_CARE=500;
    public  const  FINANCE_ACTIVITY=600;
    public  const  AUDIT_ACTIVITY=700;
    public  const  MANAGE_CONSUMER=800;
    public  const  MANAGE_SERVICE_ROLE_PERMISSION=900;
    public  const  MANAGE_CARD_POS=1000;

    public  const  CAN_VIEW_TRANSACTION  = 1200;
    public  const  VIEW_REPORT  = 1400;
    public  const  MANAGE_WALLETS  = 1300;
    public  const  MANAGE_TOPUP  = 1500;
    public  const  UPDATE_AGENT  = 1600;
    public  const  UPDATE_CONSUMER  = 1700;
    public  const  TRANSFER_REVENUE  = 1800;
    public  const  PUSH_PAYMENT  = 1900;
    public  const  RECONCILE  = 2000;
    public  const  LOW_ACCOUNT = 3000;
    public  const  MANAGE_CONSUMER_CREDO = 4000;

    public  const  CUSTOMER_REFUND  = 5000;

    public  static function  canManagement(){

//        if ()
    }
}
