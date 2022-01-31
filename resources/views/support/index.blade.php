
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
                <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px; margin-bottom: 10px; height: 50px; ">
                    <p class="page-title" style="line-height: 50px;">Welcome to customer support window

                    </p>
                </div>

                <form method="get" action="{{url('support/customer-search')}}">
                    <div class="row" id="query-window">

                        <div class="col-md-4" >
                            <div class="form-group">

                                <label>Card Number</label>
                                <input type="text" class="form-control" value="{{old('cardNo')}}" name="cardNo">

                            </div>
                        </div>
                        <div class="col-md-3" >
                            <div class="form-group">
                                <label>Wallet ID</label>

                                <input type="text"  value="{{old('walletNo')}}" class="form-control" name="walletNo">

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">

                                <label>Phone Number</label>

                                <input type="text" value="{{old('phoneNo')}}" class="form-control" name="phoneNo">

                            </div>
                        </div>

                        <div class="col-md-2">

                            <div class="form-group" style=" margin-top: 30px;">

                                <button type="submit" class="btn btn-cyan mdi mdi-search-web">Search Customer</button>
                            </div>
                        </div>
                    </div>
                </form>


                <table class="table table-bordered">

                    <tbody>
                    <tr>
                        <td style="background-color: #1a93ca; color: white;">Ticket Data</td>
                    </tr>
                    </tbody>
                </table>

                <form method="get" action="{{url('support/customer-ticket-by-phone')}}">
                    <div class="row" id="query-window">

                                            <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Phone Number</label>

                                                    <input type="text" value="{{old('phoneNo')}}" class="form-control" name="phoneNo">

                                                </div>
                                            </div>

                        <div class="col-md-5 form-group">
                            <div class="form-group">
                                <label>Event</label>

                            <select id="eventCode" name="eventCode" class="form-control eventCode">



                            </select>
                            </div>

                        </div>

                    <div class="col-md-2">

                        <div class="form-group" style=" margin-top: 30px;">

                            <button type="submit" class="btn btn-cyan mdi mdi-search-web">Search Ticket By Phone Number</button>
                        </div>
                    </div>
                    </div>
                </form>


                @if($resultP)

                    <div class="col-lg-12 table-margin-top">

                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <td>Ticket Number </td><td>{{$resultP['TicketNo']}}</td>
                            </tr>
                            <tr>

                                <td>Ticket Reference </td><td>{{$resultP['TicketRef']}}</td>
                            </tr>
                            <tr>
                                <td>Ticket Category </td><td>{{$resultP['TicketCategoryName']}}</td>
                            </tr>
                            <tr>
                                <td>Ticket Amount </td><td>{{$resultP['Amount']}}</td>
                            </tr>
                            <tr>
                                <td>Ticket Paid date </td><td>{{$resultP['PaidDate']}}</td>

                            </tr>

                            <tr>
                                <td>Number Of Attempt </td><td>{{$resultP['NoAttempt']}}</td>

                            </tr>

                            <tr>
                                <td>Last Attempted Date </td><td>{{$resultP['LastAttemptDate']}}</td>

                            </tr>
                            <tr>
                                <td>Is Validated </td><td>

                                    @if($resultP['IsValidated']==false)

                                        NO
                                    @else

                                        YES
                                    @endif
                                </td>

                            </tr>

                            <tr>
                                <td>Validation Time </td><td>{{$resultP['ValidatedDate']}}</td>
                                {{--                        <td>Validation Time </td><td>{{date('Y-m-d H:i:s ',strtotime($result['ValidatedDate']))}}</td>--}}

                            </tr>

                            <tr>
                                <td colspan="2" style="background-color: #1C729E; color: white;">Attempts</td>
                            </tr>

                            @if(empty($resultP['Attempts'][0]))
                                <tr>
                                    <td colspan="2"  style="color: firebrick">No Attempts</td>
                                </tr>

                            @else
                                @foreach($resultP['Attempts'] as $row)

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


                @endif

                @if($result)

                    <p>If problem is huge submit to technical team using below  button</p>

                    <div class="row">

                        <div class="col-6">

                            <form method="get">
                                <div class="row">

                                    <div class="col-4" >
                                        <div class="form-group">

                                            <label>Ticket number</label>

                                            <input type="text" value="{{old('phoneNo')}}" readonly class="form-control" name="phoneNo">

                                        </div>
                                    </div>

                                    <div class="col-4" style=" margin-top: 30px;">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="button"> submit to technical
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </form>

                        </div>

                        @if($walletDetails)
                            <div class="col-6">

                                <form method="get"  action="{{url('Ticket-Engine/get-ticket-by-card')}}">

                                    <div class="form-row">

                                        <div class="col-md-4 form-group">
                                            <input  type="text"  class="form-control"  value="{{$walletDetails->card_number}}" name="consumer_card_number" readonly>

                                        </div>
                                        <div class="col-md-5 form-group">

                                            <select id="eventCode" name="eventCode" class="form-control eventCode">


                                            </select>

                                        </div>
                                        <div class=" col-md-3 form-group" >

                                            <button class="btn btn-primary" type="submit"> Check Ticket
                                            </button>
                                        </div>

                                    </div>
                                </form>

                            </div>

                        @endif
                    </div>




                    @if(!empty($walletDetails))
                        <div class="col-md-12 result-window" >


                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td>card_number</td><td>
                                        @if(!$walletDetails->card_number)
                                            NO CARD ASSIGNED
                                        @else
                                            {{$walletDetails->card_number}}
                                        @endif
                                    </td>
                                    @can('manage-consumer-credentials')

                                    <td>

                                        <button class="btn btn-danger" data-toggle="modal" data-target="#show-card-disable-modal">Disable card</button>

                                    </td>

                                        @endcan
                                </tr>
                                <tr>
                                    <td>card status</td><td colspan="2">

                                        @if(!$walletDetails->status_name)
                                            N/A
                                        @else
                                            {{$walletDetails->status_name}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>wallet_id</td><td colspan="2">{{$walletDetails->wallet_id}}</td>
                                </tr>
                                <tr>
                                    <td><b>balance</b></td><td colspan="2"><b style="font-size: 17px;">{{$walletDetails->balance}}</b></td>
                                </tr>
                                <tr>
                                    <td>wallet_status</td><td>{{$walletDetails->wallet_status}}</td><td>

                                        @can('manage-consumer-credentials')

                                        <button class="btn btn-danger" data-toggle="modal" data-target="#show-account-disable-modal">
                                            Disable wallet</button>

                                            @endcan
                                    </td>
                                </tr>
                                <tr>
                                    <td>email</td><td colspan="2">{{$walletDetails->email}}</td>
                                </tr>
                                <tr>

                                    <td>first_name</td><td colspan="2">{{$walletDetails->first_name}}</td>
                                </tr>

                                <tr>

                                    <td>Phone number</td><td colspan="2">{{$walletDetails->phone_number}}</td>
                                </tr>
                                <tr>
                                    <td>last_name</td><td colspan="2">{{$walletDetails->last_name}}</td>
                                </tr>
                                <tr>

                                    <td>source</td><td colspan="2">{{$walletDetails->agent_code}}</td>
                                </tr>

                                <tr>

                                    <td>Registered date</td><td colspan="2">{{$walletDetails->created_at}}</td>
                                </tr>
                                <tr>

                                    <td>Registered date</td><td colspan="2">{{$walletDetails->created_at}}</td>
                                </tr>
                                <tr>

                                    <td>Agent Fullname</td><td colspan="2">{{$agentName}}</td>
                                </tr>

                                </tbody>
                            </table>


                            @can('manage-consumer-credentials')
                            <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px;">

                                <p>Password and pin management</p>

                                <form method="post" action="{{url('consumers/pin-reset')}}">
                                    {{csrf_field()}}
                                    <div class="col-md-12">
                                        <input type="hidden"  name="wallet_id" value="{{$walletDetails->wallet_id}}">
                                        <div class="form-group">

                                            <input type="text"  readonly class="form-control" placeholder="Enter pin" name="pin" >
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info">Reset pin</button>
                                        </div>
                                    </div>
                                </form>

                                <form method="post" action="{{url('consumers/password-reset')}}">
                                    {{csrf_field()}}
                                    <div class="col-md-12">
                                        <input type="hidden"  name="wallet_id" value="{{$walletDetails->wallet_id}}">
                                        <div class="form-group">

                                            <input type="text"  class="form-control" placeholder="Enter password" name="password" >
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info">Reset password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @endcan

                        </div>
                        <div class="col-md-12 result-window" >

                            <p>   Latest five deposits</p>

                            <table class="table table-bordered">

                                <thead>

                                <tr>
                                    <th>NO</th>
                                    <th>ncard_reference</th>
                                    <th>amount</th>
                                    <th>created_at</th>
                                    <th>current_balance</th>
                                    <th>previous_balance</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($consumerDeposits as $index=>$row)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$row->ncard_reference}}</td>
                                        <td>{{$row->amount}}</td>
                                        <td>{{$row->created_at}}</td>
                                        <td>{{$row->current_balance}}</td>
                                        <td>{{$row->previous_balance}}</td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="col-md-12 result-window">

                            <p>   Latest five payments</p>
                            <table class="table table-bordered">
                                <thead>

                                <tr>
                                    <th>NO</th>
                                    <th>reference</th>
                                    <th>amount</th>
                                    <th>created_at</th>
                                    <th>current_balance</th>
                                    <th>previous_balance</th>
                                    <th>phone_number</th>
{{--                                    <th>Total</th>--}}
                                </tr>
                                </thead>

                                <tbody>
                                <?php $sum  = 0; ?>
                                @foreach($consumerPayments as $index=>$row)

                                    <?php $sum  =  $sum+$row->amount ?>
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$row->reference}}</td>
                                        <td>{{$row->amount}}</td>
                                        <td>{{$row->created_at}}</td>
                                        <td>{{$row->current_balance}}</td>
                                        <td>{{$row->previous_balance}}</td>
                                        <td>{{$row->phone_number}}</td>



                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="2">Total</td>
                                    <td><strong>{{$sum}}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        @include('wallets.actions.disable_account_modal')
                        @include('wallets.actions.disable_card_modal')

                    @else
                        <table class="table table-bordered">
                            <tbody>
                            <tr><td>No data found</td></tr>
                            </tbody>
                        </table>
                    @endif
                @endif

            </div>

        </div>

    </div>

@stop


@section('js')

    <script>
        $(function (){

            let event  =  '{{url('active-event')}}';

            console.log('sss'+event)

            $('.eventCode').html('')

            $.get(event, function (data){

                let events =   data.result;

                console.log(events)

                $('.eventCode').append('<option></option>');

                $('.eventCode').append('<option value="" selected disabled>--select event--</option>')
                for (let i=0; i<events.length; i++){

                    let tr = '<option value="'+events[i].EventCode+'">'+events[i].EventName+'</option>';

                    $('.eventCode').append(tr);

                }

            });

        });
    </script>
@stop
