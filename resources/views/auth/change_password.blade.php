@extends('layouts.master_login')

@section('content')

    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">

            <div class="user_card" style="margin-top: 80px; background-color: white;">
                {{--<form method="post" action="{{url('login')}}">--}}

                <div>

                    <h4 style="text-align: center">Change Password</h4>
                    <hr>
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                        @endif
                    @endforeach

                    <form method="post" action="{{url('auth/change-password')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="email">Old Password</label>
                            <input type="password" required name="old_password" id="login-email2" class="form-control input_userw" >

                        </div>
                        <div class="form-group">
                            <label for="email">New Password</label>
                            <input type="password"  name="password" id="login-password2w" required class="form-control input_userw" value="" placeholder="password">
                        </div>

                            <div class="form-group">
                                <label for="email">Confirm Password</label>
                                <input type="password"  name="confirm_password" id="login-confirm_password" required class="form-control input_userw">
                            </div>
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="button"  id="login-btn2" class="btn login_btn">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection


