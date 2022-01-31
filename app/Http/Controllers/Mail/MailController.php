<?php

namespace App\Http\Controllers\Mail;

use App\Jobs\SendMailJob;
use App\Jobs\SendMailNotification;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public static  function sendMail($imei_no,$password,$email){

        SendMailJob::dispatch($imei_no,$password,$email);

    }

    public static  function sendMailMessage($email,$message){


        SendMailNotification::dispatch($email,$message);

    }
}
