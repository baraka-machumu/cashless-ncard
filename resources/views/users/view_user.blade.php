
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">View Users</h4>
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

            </div>

            <div class="col-lg-6 table-margin-top">

                <table class="table table-bordered table-striped">

                    <tbody>

                    <tr style="background-color: #31a4ba; color: white;"><td colspan="2">User Info</td></tr>
                    <tr><th>First Name</th><td>{{$user->first_name}}</td></tr>
                    <tr><th>Last Name</th><td>{{$user->last_name}}</td></tr>
                    <tr><th>Email</th><td>{{$user->email}}</td></tr>
                    <tr><th>Phone Number</th><td>{{$user->phone_number}}</td></tr>
                    <tr><th>Status</th><td>{{$user->sname}}</td></tr>

                    </tbody>
                </table>

                <a href="{{url('access/users')}}" class="btn btn-info">Back</a>
                <a href="#" class="btn btn-danger" id="user-reset-password"  data-toggle="modal" data-target="#user-reset-password-modal">Reset</a>

            </div>


            <div class="col-lg-6 table-margin-top">

                <table class="table table-bordered table-striped">

                    <tbody>


                    <tr  style="background-color: #31a4ba; color: white;"><td colspan="2">Roles</td></tr>

                    @foreach($roles as $index=>$row)

                        <tr><th>{{$index+1}}</th><td>{{$row->rname}}</td></tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


        </div>

    </div>

    @include('users.reset')

@stop

@section('js')

    <script>

        // $('#user-reset-password').click( function () {
        //
        //     $('#user-reset-password-modal').modal('show');
        // });

    </script>

    @stop
