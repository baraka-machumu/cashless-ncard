
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Merchant Users</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Merchant Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach
                {{--<div class="col-md-3">--}}

                <button type="button" data-toggle="modal" data-target="#create-merchant-user-modal" class="btn btn-cyan btn-sm" id="previous">New Merchant</button>


                {{--</div>--}}

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>


                    @foreach($users as $user)
                    <tr>

                        <td>{{1}}</td>
                        <td>{{$user->first_name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone_number}}</td>

                        {{--<td>{{'info@nssf.or.tz'}}</td>--}}
                        {{--<td>{{'Location'}}</td>--}}
                        <td>
                            <a href="#" class="btn btn-success edit-merchant-user" id="{{$user->id}}"><i class="fa fa-edit"></i></a>
                            <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <a href="{{url('merchants/users/1/show')}}" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                        </td>

                    </tr>

                        @endforeach


                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <input type="hidden" id="url" url="{{'merchants/users/get-merchant-users-data/'}}">

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="create-merchant-user-modal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <form method="post" action="{{url('merchants/users/store',$id)}}">

                                    {{csrf_field()}}
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-5">
                                                <div class="form-group">

                                                    <label for="mu-first-name">First Name</label>
                                                    <input type="text" class="form-control" id="mu-first-name" name="first_name" placeholder="First Name">

                                                </div>
                                                <div class="form-group">

                                                    <label for="mu-last-name">Last Name</label>
                                                    <input type="text" class="form-control" id="mu-last-name" name="last_name" placeholder="Last Name">

                                                </div>

                                                <div class="form-group">

                                                    <label for="mu-email">Email</label>
                                                    <input type="text" class="form-control" name="email" id="mu-email" placeholder="Email">

                                                </div>


                                                <div class="form-group">

                                                    <label for="mu-user-profile">Role Profile</label>
                                                    <select type="text" class="form-control mu-user-profile" name="user_profile" id="mu-user-profile">
                                                    </select>

                                                </div>

                                            </div>
                                            <div class="col-md-5">

                                                <div class="form-group">

                                                    <label for="mu-middle-name">Middle Name</label>
                                                    <input type="text" class="form-control" name="middle_name" id="mu-middle-name" placeholder="Middle Name">

                                                </div>

                                                <div class="form-group">

                                                    <label for="mu-gender">Gender</label>
                                                    <select type="text" class="form-control" id="mu-gender" name="gender" >

                                                        @foreach($genders as $gender)

                                                            <option value="{{$gender['id']}}">{{$gender['name']}}</option>
                                                            @endforeach
                                                    </select>

                                                </div>

                                                <div class="form-group">

                                                    <label for="mu-phone-number">Phone Number</label>
                                                    <input type="text" class="form-control" name="phone_number" id="mu-phone-number" placeholder="Phone Number">

                                                </div>

                                                <div class="form-group">

                                                    <button type="submit" style="margin-top: 28px;" class="btn btn-success" name="">Save</button>
                                                    <button type="button" style="margin-top: 28px;" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    {{--// edit merchant user--}}


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="edit-merchant-user-modal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel"><i>Edit <span id="span-name"></span></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <form method="post" action="{{url('merchants/users/update',$id)}}">

                                    {{csrf_field()}}
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-5">
                                                <div class="form-group">

                                                    <label for="edit-mu-first-name">First Name</label>
                                                    <input type="text" class="form-control" id="edit-mu-first-name" name="first_name" placeholder="First Name">

                                                </div>
                                                <div class="form-group">

                                                    <label for="edit-mu-last-name">Last Name</label>
                                                    <input type="text" class="form-control" id="edit-mu-last-name" name="last_name" placeholder="Last Name">

                                                </div>

                                                <div class="form-group">

                                                    <label for="edit-mu-email">Email</label>
                                                    <input type="text" class="form-control" name="email" id="edit-mu-email" placeholder="Email">

                                                </div>


                                                <div class="form-group">

                                                    <label for="edit-mu-user-profile">Role Profile</label>
                                                    <select type="text" class="form-control mu-user-profile" name="user_profile" id="edit-mu-user-profile">

                                                        @foreach($profiles as $profile)

                                                            <option value="{{$profile['id']}}"> {{$profile['name']}}</option>

                                                            @endforeach
                                                    </select>

                                                </div>

                                            </div>
                                            <div class="col-md-5">

                                                <div class="form-group">

                                                    <label for="edit-mu-middle-name">Middle Name</label>
                                                    <input type="text" class="form-control" name="middle_name" id="edit-mu-middle-name" placeholder="Middle Name">

                                                </div>

                                                <div class="form-group">

                                                    <label for="edit-mu-gender">Gender</label>
                                                    <select type="text" class="form-control" id="edit-mu-gender" name="gender" >

                                                        @foreach($genders as $gender)

                                                            <option value="{{$gender['id']}}">{{$gender['name']}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="form-group">

                                                    <label for="edit-mu-phone-number">Phone Number</label>
                                                    <input type="text" class="form-control" name="phone_number" id="edit-mu-phone-number" placeholder="Phone Number">

                                                </div>

                                                <input type="hidden" name="muser_id" id="m-user-id">


                                                <div class="form-group">

                                                    <button type="submit" style="margin-top: 28px;" class="btn btn-success" name="">Save</button>
                                                    <button type="button" style="margin-top: 28px;" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


@stop