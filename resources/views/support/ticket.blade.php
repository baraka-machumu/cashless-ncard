
@extends('layouts.master')

@section('stylesheets')
    <style>

        .checkbox-custom {

            height: 15px;
            width: 60px;
            margin-left: 0;
        }

        .perm-role-span {
            height: 10px;
            width: 70px;
            margin-left: 0;
            margin-top: -2px;
        }
        .rol-perm-list{

            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        ul {
            list-style-type: none;
        }
        . .rol-perm-list li {

            list-style-type: none;
        }
    </style>
@stop

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Customer Queries</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Merchant</li>
                        </ol>
                    </nav>
                </div>
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

            <div class="col-lg-12 table-margin-top">

                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <td>Ticket Number </td><td>{{$result['TicketNo']}}</td>
                    </tr>
                    <tr>

                        <td>Ticket Reference </td><td>{{$result['TicketRef']}}</td>
                    </tr>
                    <tr>
                        <td>Ticket Category </td><td>{{$result['TicketCategoryName']}}</td>
                    </tr>
                    <tr>
                        <td>Ticket Amount </td><td>{{$result['Amount']}}</td>
                    </tr>
                    <tr>
                        <td>Ticket Paid date </td><td>{{$result['PaidDate']}}</td>

                    </tr>

                    <tr>
                        <td>Number Of Attempt </td><td>{{$result['NoAttempt']}}</td>

                    </tr>

                    <tr>
                        <td>Last Attempted Date </td><td>{{$result['LastAttemptDate']}}</td>

                    </tr>
                    <tr>
                        <td>Is Validated </td><td>

                            @if($result['IsValidated']==false)

                                NO
                                @else

                                YES
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <td>Validation Time </td><td>{{$result['ValidatedDate']}}</td>
{{--                        <td>Validation Time </td><td>{{date('Y-m-d H:i:s ',strtotime($result['ValidatedDate']))}}</td>--}}

                    </tr>

                    <tr>
                        <td colspan="2" style="background-color: #1C729E; color: white;">Attempts</td>
                    </tr>

@if(empty($result['Attempts'][0]))
    <tr>
        <td colspan="2"  style="color: firebrick">No Attempts</td>
    </tr>

    @else
                    @foreach($result['Attempts'] as $row)

                        <tr>
                            <td>AttemptDate </td><td>{{$row['AttemptDate']}}</td>
                            <td>TicketCategory </td><td>{{$row['TicketCategory']}}</td>
                            <td>LastValidatedDate </td><td>{{$row['LastValidatedDate']}}</td>
                            <td>ValidatePoint </td><td>{{$row['ValidatePoint']}}</td>

                        </tr>
                    @endforeach


                    @endif
                    </tbody>
                </table>



            </div>

        </div>

    </div>

@stop
