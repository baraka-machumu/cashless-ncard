
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span>{{mb_strtoupper(substr($consumer->first_name,0,1).''.substr($consumer->last_name,0,1))}}</span>
                </div>
                <h4 class="page-title">{{$consumer->first_name.' '.$consumer->last_name}}'s Profile</h4>
                <div class="ml-auto text-right">

                    <nav aria-label="breadcrumb">
                        <input type="hidden" value="{{$consumer->first_name.' '.$consumer->last_name}}" id="{{'c-'.$consumer->wallet_id}}">

                        @if($consumer->status_id===1)
                            <a href="#" class="btn btn-warning disable-consumer"  id="{{$consumer->wallet_id}}">Deactivate </a>
                        @else
                            <a href="#" class="btn btn-info enable-consumer"  id="{{$consumer->wallet_id}}">Activate </a>
                        @endif
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
            <div class="row">
                <div class="pull-left col-md-6" style="display: inline-block;padding: 5px;">

                    <span style="text-align: start">Info</span>
                </div>

                <div class="pull-right col-md-6"  style="display: inline-block;padding: 10px;">
                    <h5  style="font-style: italic; text-align: end; font-size: 10px; margin-bottom: 40px;"> Available balance {{number_format($consumer->amount,2)}}</h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>First Name</th>
                        <td>{{$consumer->first_name}}</td>

                    </tr>

                    <tr>
                        <th>Last Name</th>
                        <td>{{$consumer->last_name}}</td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td>{{$consumer->gname}}</td>
                    </tr>
                    <tr>

                        <th>Date of Birth</th>
                        <td>{{$consumer->dob}}</td>
                    </tr>
                    <tr>

                        <th>Total Payments</th>
                        <td>{{$payments}}</td>
                    </tr>

                    </tbody>
                </table>

                {{--button to open modal for adding pos--}}
                <a  class="btn btn-success" id="add-agent-pos" data-toggle="modalss" href="#add-pos-modal88">Transactions</a>

                <a  class="btn btn-danger reset-password" id=""  href="#add-pos">Reset password</a>


            </div>

            <div class="col-lg-6">

                {{--<div class="col-md-12">--}}

                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th> Agent Number</th>
                        <td>{{$consumer->agent_code}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$consumer->email}}</td>
                    </tr>


                    <tr>
                        <th>Location</th>
                        <td>{{$consumer->location}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{$consumer->sname}}</td>
                    </tr>

                    <tr>
                        <th>Total Deposits</th>
                        <td>{{$deposits}}</td>
                    </tr>

                    </tbody>
                </table>
                <div class="form-group">

                    {{--<a href="{{route('agents.edit',$consumer->agent_code)}}" id="{{ $consumer->agent_code}}"   class="btn btn-success"><i class="fa fa-edit"></i></a>--}}
                    <a  href="{{url()->previous()}}" style="margin-top: 0px;" class="btn btn-info" name="edit-merchant">Back</a>

                </div>

                {{--</div>--}}


            </div>

        </div>

    </div>

    {{--MODEL EDIT--}}

    <!-- Modal -->
    @include('consumers.consumer_disable')

    <!-- Modal -->

    @include('consumers.consumer_enable')

    @include('consumers.resend')

@stop


@section('js')

    <script>

        $('.reset-password').click( function () {

            let phone  = this.id;//$(this).attr('id');

            $('#consumer-phone-number').val(phone);

            $('#show-resend-modal').modal('show');


        });

    </script>

@stop
