<?php

namespace App\Http\Controllers\access;

use App\Http\Controllers\DashboardController;
use App\Permission;
use App\Profile;
use App\ProfilePermission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $profiles =  Profile::all()->toArray();

        return view('profiles.index',compact('profiles'));

    }

    /**0
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

        $name  =  $request->get('name');

        $permission =  new Profile();

        $permission->name =  $name;

        $success = $permission->save();

        if ($success){

            Session::flash('alert-success', $name.' Permission Successful created');

        } else {

            Session::flash('alert-danger', $name.' Permission Failed to be saved');


        }

        return redirect('access/profiles');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile =  Profile::find($id);

        $profilePermissions  = DB::table('profile_permissions')
            ->select('permissions.name as permission_name','permissions.status_id')

            ->join('permissions','permissions.id','profile_permissions.permissions_id')
            ->get();

        $permissions =  Permission::all();

        return view('profiles.show_profile_details',compact('permissions','profile','profilePermissions'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

        $name  = Permission::find($id);

        return $name['name'];
    }



    public  function  permissionUpdate(Request $request){



        $id  =  $request->get('pid');
        $name =  $request->get('name');

        $permission = Permission::find($id);

        $permission->name =  $name;

        $success =  $permission->save();

        if ($success){

            Session::flash('alert-success', $name.' Permission Successful updated');

        } else {

            Session::flash('alert-danger', $name.' Permission Successful updated');


        }

        return redirect('access/permissions');


    }


    public  function  assignPermissionToProfile(Request  $request){



        $profile_id  =  $request->profile_id;

        $permissions  =  $request->permissions;


        for ($i=0; $i<sizeof($permissions); $i++)
        {

            $profilePermisssions  =  new ProfilePermission();

            $profilePermisssions->profiles_id =  $profile_id;

            $profilePermisssions->permissions_id =  $permissions[$i];

            $success  = $profilePermisssions->save();
        }


        if ($success){

            Session::flash('alert-success', ' Permission Successful added');

        } else {
            Session::flash('alert-danger', 'Cannot add permision to profile');


        }

        return redirect('access/profiles');



    }
}
