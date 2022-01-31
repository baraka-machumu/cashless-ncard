@extends('layouts.master_login')

@section('content')

    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">

            <div class="user_card" style="margin-top: 80px; background-color: white;">
                {{--<form method="post" action="{{url('login')}}">--}}


                <div class="d-flex justify-content-center" >
                    <div class="brand_logo_container">
                        <img src="{{asset('public/assets/images/ncard_logo.png')}}" class="brand_logo" alt="Logo">
{{--                        <h2>N CARD</h2>--}}

                    </div>

                </div>

                <div class="justify-content-center form_container" >

                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                        @endif
                    @endforeach

                    <form method="post" action="{{url('login')}}">
                        {{csrf_field()}}



                        <div class="form-group {{ $errors->has('email') ? 'errors' : '' }}">

                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                {{--<label for="email">Email</label>--}}

                                <input type="text" value="{{old('email')}}" name="email" id="login-email" class="form-control input_user"  placeholder="email">

                            </div>
                            <small class="text-danger">{{ $errors->first('email') }}</small>


                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                {{--<label for="email">Email</label>--}}

                                <input type="password"  name="password" id="login-password" class="form-control input_user" value="" placeholder="password">

                            </div>
                            <small class="text-danger">{{ $errors->first('password') }}</small>


                        </div>


                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" name="button"  id="login-btn" class="btn login_btn">Login</button>
                    </div>
                    <div class="mt-4">

                        <div class="d-flex justify-content-center links">
                            <a href="#">Forgot your password?</a>
                        </div>
                    </div>

                    </form>

                </div>


                {{--</form>--}}

            </div>
        </div>
    </div>
@endsection

@section('css')

    <style>

    </style>

@stop
