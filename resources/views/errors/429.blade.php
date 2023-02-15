@extends('layouts.master_login')

@section('content')

    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">

            <div class="user_card usr-screen" style="margin-top: 80px; background-color: white;">
                {{--<form method="post" action="{{url('login')}}">--}}

                <div>

                    <h4 style="text-align: center">ACCOUNT LOCKED</h4>
                    <p style="text-align: center">{{auth()->user()->email}}</p>
                    <hr>
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                        @endif
                    @endforeach

                    <p>Your account will be allowed after {{$time}} Minute(s)</p>

                </div>

            </div>
        </div>
    </div>
@endsection


