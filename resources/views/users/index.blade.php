
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Users</h4>
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

                <a  href="{{url('access/users/create')}}" class="btn btn-cyan btn-sm" id="previous">New User</a>


                {{--</div>--}}

            </div>

            <div class="col-lg-12 table-margin-top">

                <table class="table table-bordered table-striped" id="users-table">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>FullName</th>
                        <th>Email</th>
                        <th>Date Created</th>
                        <th>Status</th>
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php  $i =1;?>
                    @foreach($users as $user)

                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$user['first_name'].' '.$user['first_name']}}</td>
                            <td>{{$user['email']}}</td>
                            <td>{{date('Y-m-d H:i:s',strtotime($user['created_at']))}}</td>
                            <td>
                                @if($user['status']==1)
                                    <span class="badge badge-success">ACTIVE</span>
                                @else
                                    <span class="badge badge-danger">INACTIVE</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('access-user-edit',$user['id'])}}" class="btn btn-success edit-roles"><i class="fa fa-edit"></i></a>
                                @if($user['status']==1)
                                    <a href="#" class="btn btn-danger user-status" id="{{$user['id']}}">
                                        <i class="fa fa-trash"></i></a>
                                @else
                                    <a href="#" class="btn btn-danger user-status-activate" id="{{$user['id']}}">
                                        <i class="fa fa-check-circle"></i>
                                    </a>
                                @endif
                                <a href="{{url('access/users/view',$user['id'])}}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                            </td>

                        </tr>

                        <?php  $i++;?>

                    @endforeach

                    </tbody>
                </table>

            </div>

        </div>

    </div>

    @include('users.activate')

    @include('users.disabled')

@stop


@section('js')


    <script>

        $(function () {

            alert(33)
        })
    </script>

@stop
