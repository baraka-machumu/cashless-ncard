<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditLogs
{
    public  static  function  saveLogs($desc,$actionTo,$actionType,$accountAffected=null){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os=BrowserUtils::get_os($user_agent);
        $browser  = BrowserUtils::get_browser_name($user_agent);
        DB::select('call SaveInternalLogsSPV2(?,?,?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$accountAffected,$actionTo,$actionType,$browser,$os));
    }

}
