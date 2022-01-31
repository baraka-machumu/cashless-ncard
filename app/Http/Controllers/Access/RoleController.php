<?php

namespace App\Http\Controllers\access;

use App\Audit\Audit;
use App\Http\Controllers\DashboardController;
use App\Permission;
use App\Role;
use App\RolePermission;
use App\User;
use foo\bar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Gate::allows('manage-service-role-perm')) {

            return view('errors.login_access');

        }

        $roles =  Role::all()->toArray();

        $permissions  = Permission::query()->get();

        return view('roles.index',compact('roles','permissions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('manage-service-role-perm')) {

            return view('errors.login_access');

        }

        return view('roles.create_role');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Gate::allows('manage-service-role-perm')) {

            return view('errors.login_access');

        }

        $role_name  =  $request->get('role_name');
        $permission  =  $request->permission;

        DB::beginTransaction();
        try {
            $role = new Role();

            $role->name = $role_name;

            $role->save();

//            return  response()->json($role);

            foreach ($permission as $key => $value) {

                $rolePermission = new RolePermission();

                $rolePermission->permission_id = $value;
                $rolePermission->role_id = $role->id;

                $rolePermission->save();

            }

            DB::commit();

            Session::flash('alert-success', $role_name . ' Role successful created');
            return redirect('access/roles');

        }
        catch(\Exception $exception) {

            DB::rollBack();
            Session::flash('alert-danger','Failed to save role '.$exception->getMessage());

            return  back();

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('manage-service-role-perm')) {

            return view('errors.login_access');

        }
        $role =  Role::find($id);

        $name =  $role['name'];

        $userstoroles  = DashboardController::getAccessToUserInfo($id);

        return view('roles.show_role_details',compact('userstoroles','name'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (!Gate::allows('manage-service-role-perm')) {

            return view('errors.login_access');

        }
        $role  =  Role::query()->where(['id'=>$id])->first();

        $permissions  = Permission::query()->get();

        $rolePermissions =   RolePermission::query()->where(['role_id'=>$id])->get();

        return view('roles.edit',compact('role','rolePermissions','permissions'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        return 89789;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public  function getRoleData($id){

        if (!Gate::allows('manage-service-role-perm')) {

            return view('errors.login_access');

        }
        $name  = Role::find($id);

        return $name['name'];

    }


    public  function  roleUpdate(Request $request, $id){
        if (!Gate::allows('manage-service-role-perm')) {

            return view('errors.login_access');

        }

        $name =  $request->get('roleName');

        $role = Role::find($id);

            DB::beginTransaction();
        try {

            $role->name = $name;

            $success = $role->save();
            $permission = $request->permission;

            RolePermission::where('role_id', $id)->delete();

            foreach ($permission as $key => $value) {

                $rolePermission = new RolePermission();

                $rolePermission->permission_id = $value;
                $rolePermission->role_id = $id;

                $rolePermission->save();
            }


            DB::commit();
            Session::flash('alert-success', $name . ' Role Successful updated');
            return redirect('access/roles');

        }  catch(\Exception $ex) {

            DB::rollBack();
            Session::flash('alert-danger', 'Failed to update ');


        }



    }


}
