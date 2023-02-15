@extends('layouts.master_login')

@section('content')

    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">

            <div class="user_card usr-screen" style="margin-top: 80px; background-color: white;">
                {{--<form method="post" action="{{url('login')}}">--}}

                <div>

                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                        @endif
                    @endforeach

                    <div class="col-md-12">

                        @include('partials.error_message')


                        <div class="col-md-12 p-t-10" style="margin-top: 20px;">
                            <h5 style="color: black; font-weight: bold; text-align: center;">MULTIPLE SESSION DETECTED!</h5>

                            <hr>
                        </div>


                        <div class="m-b-30">
                            <div style="color: black;text-align: center;">{{\Illuminate\Support\Facades\Auth::user()->email}}</div>
                        </div>
                        <div class="form-group">
                            <div style="color: #e60000; padding: 14px; background-color: white; font-weight: bold;">
                                You have an active login session on another device. You can only have one active login session.
                            </div>
                        </div>

                        <form action="{{url('/logout-others-device')}}" method="post">

                            {{csrf_field()}}
                            <div class="form-group">

                                <button class="btn btn-info" style="width: 100%;">CONTINUE ON THIS DEVICE</button>
                                <span>* This will log you out on other device</span>

                            </div>
                        </form>

                        <form method="post" action="{{url('logout-this-device')}}" >
                            {{csrf_field()}}
                            <div class="form-group">

                                <button class="btn btn-info" style="width: 100%;">LOGOUT THIS DEVICE</button>

                            </div>
                        </form>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


