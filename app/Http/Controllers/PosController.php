<?php

namespace App\Http\Controllers;

use App\Pos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PosController extends Controller
{

    public  function  index(){

        $pos  = DB::table('agent_pos')
            ->leftJoin('pos','agent_pos.imei_no','=','pos.imei_no')
            ->get();

//        return re
        return view('pos.index',compact('pos'));
    }
    public  function  reset($imei_no){

        try{

            DB::beginTransaction();
            DB::table('pos')->where(['imei_no'=>$imei_no])->update(['status_id'=>0]);

            DB::table('agent_pos')->where(['imei_no'=>$imei_no])->delete();

            DB::commit();

            Session::flash('alert-success','successful reset');

        } catch (\Exception $exception){

            DB::rollBack();
            Session::flash('alert-danger','Invalid pos number');

        }

        return redirect('pos');
    }
    public  function  resetStatus(Request $request){

        $imei_no   =  $request->imei_no_search;
        try{

            DB::beginTransaction();

            DB::table('pos')->where(['imei_no'=>$imei_no])->update(['status_id'=>0]);


            DB::commit();

            Session::flash('alert-success','successful reset');

        } catch (\Exception $exception){

            DB::rollBack();
            Session::flash('alert-danger','Failed');

        }

        return redirect('pos');
    }
    public  function  store(Request $request){
        $imei_no  = $request->pos;
        $imei_no_search  = $request->imei_no_search;
        if (isset($_POST['imei-search'])){

            if (empty($imei_no_search)){
                Session::flash('alert-danger','Imei number is required');
                return back();
            }

            $check  =  Pos::query()->where(['imei_no'=>$imei_no_search])->first();
            if (!$check){
                Session::flash('alert-danger','Not Found');
                return back();
            }

            return view('pos.reset',compact('imei_no_search'));
        }


        if (empty($imei_no)){
            Session::flash('alert-danger','Imei number is required');
            return back();
        }

        if (!is_numeric($imei_no)){

            if(strlen($imei_no)>30){

                Session::flash('alert-danger','Invalid pos number');
                return back();
            }

        }

        else{

            if(strlen($imei_no)<15){

                Session::flash('alert-danger','Invalid pos number');
                return back();
            }
        }
        $check  =  Pos::query()->where(['imei_no'=>$imei_no])->first();

        if ($check){

            Session::flash('alert-danger','Pos Exist');
            return back();
        }



        $pos  = new Pos();
        $pos->imei_no  =  $imei_no;
        $pos->save();
        Session::flash('alert-success','Successful added');

        return redirect('pos');


    }
}
