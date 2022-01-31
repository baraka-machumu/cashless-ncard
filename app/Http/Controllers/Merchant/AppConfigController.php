<?php


namespace App\Http\Controllers\Merchant;


use App\AppConfig;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\IFTTTHandler;

class AppConfigController extends Controller
{

    public  function  index($merchantTin){

        return view('app_config.merchant.index',compact('merchantTin'));


    }


    public  function  view($merchantTin){

        $config  =   AppConfig::query()->where(['tin'=>$merchantTin])->first();

        return view('app_config.merchant.view',compact('merchantTin','config'));

    }

    public  function  saveJsonColumn(Request  $request,$merchantTin){


        try {

            $config  =  new AppConfig();

            $config->tin =  $merchantTin;
            $config->screen =  $request->screen;
            $config->layout =  $request->layout;
            $config->api =  $request->api;
            $config->api_method =  $request->api_method;
            $config->on_tap  =  $request->on_tap;
            $config->column  = $request->column;

            $config->type  = $request->type;
            $config->title  = $request->title;
            $config->sub_title  = $request->subtitle;
            $config->max_lenth  = $request->max_lenth;
            $config->input_type  = $request->input_type;

            $success =  $config->save();


           if ($success){

               Session::flash('alert-success','Successful-saved');

               return redirect('merchant-app-config/'.$merchantTin);

           }


        }
        catch (\Exception $exception){

            Session::flash('alert-danger','failed '.$exception->getMessage());

            return  back();
        }



    }


}
