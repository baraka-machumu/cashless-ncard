
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

        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Roles</h4>
                    <div class="ml-auto text-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Merchant</li>
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

                    <button type="button" data-toggle="modal" data-target="#create-role-modal" class="btn btn-cyan btn-sm" id="previous">New Role</button>


                    {{--</div>--}}

                </div>

                <div class="col-lg-12 table-margin-top">


                    <table class="table table-bordered table-striped">

                        <thead>
                        <tr>

                            <th>#</th>
                            <th>Role Name</th>
                            <th>Created Date</th>
                            <th>Actions</th>

                        </tr>
                        </thead>

                        <tbody>

                        <?php  $i =1;?>
                        @foreach($roles as $role)

                            <tr>

                                <td>{{$i}}</td>

                                <td>{{$role['name']}}</td>
                                <td>{{$role['created_at']}}</td>

                                <td>
                                    <a  href="{{route('access-role-edit',$role['id'])}}" class="btn btn-success edit-roles"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger  disabled-role" id="{{ $role['id']}}"><i class="fa fa-trash"></i></a>

                                </td>

                            </tr>
                            <?php  $i++;?>

                        @endforeach


                        </tbody>
                    </table>

                </div>

            </div>

        </div>

        @include('roles.role_disable')

        @include('roles.create')
{{--        @include('roles.edit')--}}



    @stop
