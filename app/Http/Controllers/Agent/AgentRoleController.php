<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AgentRoleController extends Controller
{


    public  function  index($agent_code){

        $roles  =  DB::table('pos_permissions')->get();

        $permission  =  DB::select('call GetAgentPermissionSP(?)',array($agent_code));

        return view('agents.roles',compact('roles','agent_code','permission'));

    }


    public  function  save(Request  $request){

        $agentcode  =  $request->agent_code;
        $role  =  $request->role;

        try {

            DB::beginTransaction();

            for ($i=0; $i<sizeof($role); $i++){

                DB::select('call SaveAgentPermissionSP(?,?)',array($agentcode,$role[$i]));

            }

            DB::commit();

            Session::flash('alert-success','Successful saved');

            return  redirect('agents/roles/'.$agentcode);

        }

        catch (\Exception $exception){

            Session::flash('alert-danger','Processing error.'.$exception->getMessage());

            return  redirect('agents/roles/'.$agentcode);

        }


    }


    public  function  delete(Request  $request,$agentcode){

        $posid  =  $request->posId;

        try {

            DB::beginTransaction();

            DB::select('call DisableAgentPermissionSP(?,?)',array($agentcode,$posid));

            DB::commit();

            Session::flash('alert-success','Successful updated');

            return  redirect('agents/roles/'.$agentcode);

        }

        catch (\Exception $exception){

            Session::flash('alert-danger','Processing error.'.$exception->getMessage());

            return  redirect('agents/roles/'.$agentcode);

        }


    }

}
