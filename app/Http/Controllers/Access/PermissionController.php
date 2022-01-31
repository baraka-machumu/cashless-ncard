<?php

namespace App\Http\Controllers\access;

use App\Http\Controllers\DashboardController;
use App\Permission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
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
        $permissions =  Permission::all()->toArray();
        return view('permissions.index',compact('permissions'));

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
        return view('permissions.create_permission');

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
        $name  =  $request->get('name');
        $code  =  $request->get('code');

        $permission =  new Permission();

        $permission->name =  $name;
        $permission->pcoe  =  $code;

        $success = $permission->save();

        if ($success){

            Session::flash('alert-success', $name.' Permission Successful created');

        } else {

            Session::flash('alert-danger', $name.' Permission Failed to be saved');


        }

        return redirect('access/permissions');

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
        $permission =  Permission::find($id);

        $name =  $permission['name'];

        $userstoroles  = DashboardController::getAccessToUserInfo($id);

        return view('permissions.show_permission_details',compact('userstopermission','name'));


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

        return view('permissions.edit_permission');

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
        //
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


    public  function  getPermissionData($id){

        if (!Gate::allows('manage-service-role-perm')) {

            return view('errors.login_access');

        }
        $name  = Permission::find($id);

        return $name['name'];
    }



    public  function  permissionUpdate(Request $request){

        if (!Gate::allows('manage-service-role-perm')) {

            return view('errors.login_access');

        }

        $id  =  $request->get('pid');
        $name =  $request->get('name');
        $code =  $request->get('code');

        $permission = Permission::find($id);

        $permission->name =  $name;
        $permission->pcode =  $code;

        $success =  $permission->save();

        if ($success){

            Session::flash('alert-success', $name.' Permission Successful updated');

        } else {

            Session::flash('alert-danger', $name.' Permission Successful updated');


        }

        return redirect('access/permissions');


    }
}
