
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span>{{mb_strtoupper(substr($agent->name,0,2))}}</span>

                </div>
                <h4 class="page-title">{{strtoupper($agent->name)}}'s Profile</h4>
                <div class="ml-auto text-right">

                    <nav aria-label="breadcrumb">
                        {{--<button type="button"  class="btn btn-cyan btn-sm topup-agent" id="{{$agent->agent_code}}">Top up Agent</button>--}}

                        {{--<a href="{{route('topup-form',$agent->agent_code)}}" class="btn btn-success">Top up</a>--}}

                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">

        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
            @endif
        @endforeach

        <div class="col-lg-12 show-user-details-2">

            <div class="pull-left">

                <span style="text-align: start">Info</span>
            </div>

            <div class="pull-right">
                <h5  style="font-style: italic; text-align: end; font-size: 13px; margin-bottom: 50px;">
                    Available balance {{number_format($agent->current_balance,1,'.',',')}}</h5>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th>Name</th>
                        <td>{{$agent->name}}</td>

                    </tr>

                    <tr>
                        <th>Agent Code</th>
                        <td>{{$agent->code}}</td>

                    </tr>

                    <tr>
                        <th>Tin Number</th>
                        <td>{{$agent->tin}}</td>

                    </tr>

                    <tr>
                        <th>Phone Number</th>
                        <td>{{$agent->phone_number}}</td>

                    </tr>


                    <tr>
                        <th>Created Date</th>
                        <td>{{$agent->created_at}}</td>

                    </tr>


                    </tbody>
                </table>


            </div>

            <div class="col-lg-6">

                <table class="table table-striped">

                    <tbody>


                    <tr>
                        <th>current_balance</th>
                        <td>{{$agent->current_balance}}</td>

                    </tr>




                    </tbody>
                </table>


            </div>


        </div>

    </div>


@stop

@section('js')

@stop
