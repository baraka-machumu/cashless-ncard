<?php

namespace App\Http\Controllers\access;

use App\Gender;
use App\Helper\RandomGenerator;
use App\Helper\SmsHelper;
use App\Http\Controllers\DashboardController;
use App\Jobs\SendSmsJob;
use App\Profile;
use App\Role;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }

        $users =  User::all()->toArray();

        return view('users.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }

        $profiles =  Profile::all()->toArray();

        $genders=  Gender::all()->toArray();

        $roles=  Role::query()->get();


        return view('users.create',compact('profiles','genders','roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }

        $user  =  new User();
        $first_name  =  $request->get('first_name');
        $middle_name  =  $request->get('middle_name');
        $last_name  =  $request->get('last_name');
        $gender  =  $request->get('gender');
        $email  =  $request->get('email');
        $phone_number  =  $request->get('phone_number');
        $role  =  $request->get('role');

        try{
        if (!is_numeric($phone_number)){

            Session::flash('alert-danger', 'Phone Number Is Invalid ');

            return back()->withInput();

        }

        $api_token =  Str::random(60);

        $password =  User::generatePassword();

        DB::beginTransaction();
        $user->first_name =  $first_name;
        $user->middle_name =  $middle_name;
        $user->last_name =  $last_name;
        $user->gender_id =  $gender;
        $user->email =  $email;
        $user->phone_number =  $phone_number;
        $user->password    =  Hash::make($password);
        $user->api_token =  $api_token;
        $user->status   =  1; // default status is 1
        $user->created_by  = Auth::user()->id;

        $success = $user->save();

        foreach ($role as $key => $value) {
            $rolePermission = new UserRole();
            $rolePermission->role_id = $value;
            $rolePermission->user_id = $user->id;
            $rolePermission->save();
        }


            $msisdn  = RandomGenerator::addPrefixExtra($phone_number);

            $message = 'Password yako ya kuingia kwenye mfumo ni '.$password;

            DB::commit();

            SmsHelper::sendSms($message,$msisdn);

            Session::flash('alert-success', $first_name.' '.$last_name.'  Successful created');

        } catch(\Exception $ex) {

            DB::rollBack();
            Session::flash('alert-danger','failed  to create user role '.$ex->getMessage());

        }

        return redirect('access/users');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)

    {
        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }

        $user  =  DB::table('users as u')
            ->select('first_name','last_name','middle_name','u.email','u.phone_number','u.status','s.name as sname')
            ->join('status as s','s.id','=','u.status')
            ->where(['u.id'=>$id])
            ->first();
        $roles  = DB::table('user_roles as ur')
            ->select('ur.user_id','ur.role_id','r.name as rname')
            ->join('roles as r','r.id','=','ur.role_id')
            ->where(['ur.user_id'=>$id])->get();

        return view('users.view_user',compact('user','id','roles','id'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }
//
//        $user  = \App\User::with('roles')->where('id','=',Auth::user()->id)->first();
//
//        return response()->json($user['roles']);

        $user  =  User::query()->where(['id'=>$id])->first();

        $profiles =  Profile::all()->toArray();

        $genders=  Gender::all()->toArray();

        $roles=  Role::query()->get();

        $userRoles  =  UserRole::query()->where(['user_id'=>$id])->get();

//        return  response()->json($userRoles);

        return view('users.edit',compact('userRoles','profiles','genders','roles','user','id'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }
        $first_name  =  $request->get('first_name');
        $middle_name  =  $request->get('middle_name');
        $last_name  =  $request->get('last_name');
        $gender  =  $request->get('gender');
        $email  =  $request->get('email');
        $phone_number  =  $request->get('phone_number');
        $role  =  $request->get('role');
        if (!is_numeric($phone_number)){

            Session::flash('alert-danger', 'Phone Number Is Invalid ');

            return back()->withInput();

        }

        $user  =  User::where(['id'=>$id])->first();

        DB::beginTransaction();
        try {

            $user->first_name = $first_name;
            $user->middle_name = $middle_name;
            $user->last_name = $last_name;
            $user->gender_id = $gender;
            $user->email = $email;
            $user->phone_number = $phone_number;

            $user->save();

            UserRole::where(['user_id'=>$id])->delete();
            foreach ($role as $key => $value) {
                $rolePermission = new UserRole();
                $rolePermission->role_id = $value;
                $rolePermission->user_id =$id;
                $rolePermission->save();
            }

            DB::commit();
            Session::flash('alert-success','Update successful');
            return redirect('access/users');

        } catch(\Exception $exception){

            DB::rollBack();
            Session::flash('alert-danger','Update failed');
            return redirect('access/users');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }
      $success = DB::table('users')->where(['id'=>$id])->delete();

      if ($success){
          Session::flash('alert-success','Successful disabled');

      }
       else {
           Session::flash('alert-success','Failed to disable user');

       }


       return  redirect('access/users');
    }

    public function disabledUser(Request $request)
    {
        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }
        $id =  $request->userId;

        $success = DB::table('users')->where(['id'=>$id])->update(['status'=>0]);

        if ($success){
            Session::flash('alert-success','User status changed successful');

        }
        else {
            Session::flash('alert-success','Failed to change user status');

        }


        return  redirect('access/users');
    }
    public function activateUser(Request $request)
    {
        $id =  $request->userId;

        $success = DB::table('users')->where(['id'=>$id])->update(['status'=>1]);

        if ($success){
            Session::flash('alert-success','User status changed successful');

        }
        else {
            Session::flash('alert-success','Failed to change user status');

        }


        return  redirect('access/users');
    }

    public  function getRoleData($id){

        $name  = Role::find($id);

        return $name['name'];

    }


    public  function  roleUpdate(Request $request){
        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }

        $id  =  $request->get('role_id');
        $name =  $request->get('role_name');


        $role  = Role::find($id);

        $role->name =  $name;

        $success =  $role->save();


        if ($success){

            Session::flash('alert-success', $name.' Role Successful updated');

        } else {

            Session::flash('alert-danger', $name.' Role Successful updated');


        }

        return redirect('access/roles');


    }


    public  function  resetPassword(Request $request){
        if (!Gate::allows('manage-user')) {

            return view('errors.login_access');

        }
        $userId  =  $request->userId;

        $user  =  User::query()->where(['id'=>$userId])->first();

        try{

            if (!$user){

                Session::flash('alert-danger', 'Invalid user');

            } else {

                $password  =  User::generatePassword();

                $msisdn  = RandomGenerator::addPrefixExtra($user->phone_number);

                $message = 'Password yako ya kuingia kwenye mfumo ni '.$password;

                $user->password  = Hash::make($password);
                $user->save();

                SmsHelper::sendSms($message,$msisdn);

                Session::flash('alert-success', 'Successful sent');


            }
        }catch (\Exception $exception){

            Session::flash('alert-danger', 'Invalid user');

        }

        return redirect('access/users/view/'.$userId);

    }

}
