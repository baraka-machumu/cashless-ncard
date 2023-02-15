@extends('layouts.master_login')

@section('content')

    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">

            <div class="user_card usr-screen" style="margin-top: 80px; background-color: white;">
                {{--<form method="post" action="{{url('login')}}">--}}

                <div>

                    <h4 style="text-align: center">SESSION LOCKED</h4>
                    <p style="text-align: center">{{auth()->user()->email}}</p>
                    <hr>
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                        @endif
                    @endforeach

                    <form method="post" action="{{url('unlock')}}">
                        {{csrf_field()}}

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                {{--<label for="email">Email</label>--}}
                                <input type="password"  name="password" id="login-password2w" required class="form-control input_userw" value="" placeholder="password">
                            </div>
                            <small class="text-danger">{{ $errors->first('password') }}</small>
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


