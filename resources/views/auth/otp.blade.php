@extends('layouts.master_login')

@section('content')

    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">

            <div class="user_card usr-screen" style="margin-top: 80px; background-color: white;">
                {{--<form method="post" action="{{url('login')}}">--}}

                <div>

                    <h4 style="text-align: center">Provide OTP</h4>
                    <hr>
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                        @endif
                    @endforeach

                    <form method="post" action="{{url('auth/verify-otp')}}">
                        {{csrf_field()}}

                        <div class="form-group">

                            <label>OTP</label>

                            <input type="text" name="otp" class="form-control"
                                   required placeholder="Enter OTP">

                        </div>
                        <div class="form-group" style="margin-bottom: 20px;">

                            <button class="btn btn-info" style="width: 45%; margin-bottom: 15px; float: left; margin-right:5%">Submit</button>
                            <a class="btn btn-info" href="{{url('auth/otp/resend')}}" style="width: 45%; margin-bottom: 15px; float: left; margin-left: 5%;">Resend Token</a>

                            <br>
                            <p>Return
                                <a href="#" style="margin-top: 20px; font-size: 18px; text-decoration: underline;" onclick="$('#logout-form').submit();" class=""><b>Home</b></a>
                            </p>


                        </div>

                    </form>

                    <form method="post" action="{{url('logout')}}" id="logout-form">

                        @csrf

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection


