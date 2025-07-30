<?php

namespace App\Http\Controllers;

use App\Pos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $desc  = 'Reset Pos  number '.$imei_no;
            DB::update('call SaveInternalLogsSP(?,?,?,?,?,?)',array(Auth::user()->id,Auth::user()->email,$desc,$imei_no,'POS','RESET'));

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

        try {
            $imei_no  = $request->pos;
            $imei_no_search  = $request->imei_no_search;
            if (isset($_POST['imei-search'])){

                if (empty($imei_no_search)){
                    Session::flash('alert-danger','Imei number is required');
                    return redirect('pos');
                }

                $check  =  Pos::query()->where(['imei_no'=>$imei_no_search])->first();
                if (!$check){
                    Session::flash('alert-danger','Not Found');
                    return redirect('pos');
                }

                return view('pos.reset',compact('imei_no_search'));
            }


            if (empty($imei_no)){
                Session::flash('alert-danger','Imei number is required');
                return redirect('pos');
            }


            if(strlen($imei_no)<15){

                Session::flash('alert-danger','Invalid pos number');
                return redirect('pos');
            }

            $check  =  Pos::query()->where(['imei_no'=>$imei_no])->first();

            if ($check){

                Session::flash('alert-danger','Pos Exist');
                return redirect('pos');
            }



            $pos  = new Pos();
            $pos->imei_no  =  $imei_no;
            $pos->save();
            Session::flash('alert-success','Successful added');

            return redirect('pos');

        }catch (\Throwable $exception){
            Session::flash('alert-success','Server error');

            return redirect('pos');

        }

    }
}
