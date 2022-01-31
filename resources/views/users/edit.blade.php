
@extends('layouts.master')


@section('stylesheets')
    <style>

        .checkbox-custom {

            height: 15px;
            width: 60px;
            margin-left: 0;
        }

        .perm-role-span {
            height: 10px;
            width: 70px;
            margin-left: 0;
            margin-top: -2px;
        }
        .rol-perm-list{

            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        ul {
            list-style-type: none;
        }
        . .rol-perm-list li {

            list-style-type: none;
        }
    </style>
@stop

@section('content')


    <div class="container-fluid">
        <div class="row">
            {{--            <div class="col-md-12 modal-background" style="margin-left: 15px;">--}}
            {{--                <h4>New User</h4>--}}
            {{--            </div>--}}

            <div class="col-md-12">

                @include('partials.error_message')

                <div class="col-md-12">
                    <table class="table table-striped table-bordered  modal-background" id="table" >

                        <tbody>

                        <tr>

                            <td colspan="12" style="background-color: #1C729E;color: white;">Edit user</td>

                        </tr>

                        </tbody>

                    </table>

                </div>
            </div>


        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <form method="post" action="{{url('access/users/update',$id)}}">

                        {{csrf_field()}}

                        <div class="card-body">

                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control"  value="{{$user->first_name}}" name="first_name" id="first_name" placeholder="First Name">

                                    </div>
                                    <div class="form-group">

                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" value="{{$user->last_name}}" name="last_name" id="last_name" placeholder="Last Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="email">Email</label>
                                        <input type="text" class="form-control"  value="{{$user->email}}" name="email" id="email" placeholder="Email">

                                    </div>



                                    {{--                                    <div class="form-group">--}}

                                    {{--                                        <button type="submit" style="margin-top: 28px;" class="btn btn-success" name="">Save</button>--}}
                                    {{--                                        <a  href="{{url()->previous()}}" style="margin-top: 28px;" class="btn btn-info" name="edit-merchant">--}}
                                    {{--                                            <i class="fa fa-backward" aria-hidden="true"></i>--}}
                                    {{--                                        </a>--}}

                                    {{--                                    </div>--}}

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" value="{{$user->middle_name}}" name="middle_name" id="middle_name" placeholder="Middle Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="gender">Gender</label>
                                        <select class="select2 form-control custom-select gender" name="gender"  id="gender" style="width: 100%; height:36px;">

                                            <option></option>
                                            @foreach($genders as $gender)

                                                <option value="{{$gender['id']}}"

                                                        @if($gender['id']==$user->gender_id)

                                                        selected

                                                    @endif
                                                >{{$gender['name']}}</option>

                                            @endforeach



                                        </select>
                                    </div>

                                    <div class="form-group">

                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" value="{{$user->phone_number}}" name="phone_number" id="phone_number" placeholder="Phone Number">

                                    </div>


                                </div>



                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="col-md-4" style="margin: 0;">

                                <ul class="rol-perm-list">
                                    @foreach($roles as  $index=>$role)

                                        @if($index<7)
                                            <li>
                                            <span class="perm-role-span"><input type="checkbox" name="role[]" class="checkbox-custom" value="{{$role->id}}"


                                                                                @foreach($userRoles as $ur)

                                                                                @if($role->id==$ur->role_id)

                                                                                checked
                                                                                @endif
                                                    @endforeach


                                                > {{$role->name}} </span>
                                            </li>

                                        @endif
                                    @endforeach

                                </ul>
                            </div>

                            <div class="col-md-4">

                                <ul class="rol-perm-list">
                                    @foreach($roles as  $index=>$role)

                                        @if($index>=7)

                                            <li>
                                            <span class="perm-role-span"><input type="checkbox" name="role[]" class="checkbox-custom" value="{{$role->id}}"


                                                                                @foreach($userRoles as $ur)

                                                                                @if($role->id==$ur->role_id)

                                                                                checked
                                                                                @endif
                                                    @endforeach


                                                > {{$role->name}} </span>
                                            </li>

                                        @endif
                                    @endforeach

                                </ul>
                            </div>


                            <div class="col-md-6">

                                <div class="form-group">

                                    <a href="{{url('access/users')}}" class="btn btn-info">Back</a>

                                    <button class="btn btn-success" type="submit">Update</button>
                                </div>

                            </div>



                        </div>



                    </form>
                </div>


            </div>
        </div>

    </div>


@stop
