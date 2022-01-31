@extends('layouts.master')

@section('content')




    <div class="container-fluid">

        <div class="row">
        <div class="col-md-12" style="margin-top: 20px;">


            @include('partials.error_message')

            <form method="post" action="{{url('refund/check')}}">

                @csrf

                <div class="com-md-4">

                    <label>Card Number/Card uid</label>

                    <input type="text" name="card" class="form-control" required>

                </div>
                <div class="com-md-4">

                    <label>Start Date</label>

                    <input type="date" name="start_date" class="form-control" >

                </div>

                <div class="com-md-4">

                    <label>End Date</label>

                    <input type="date" name="end_date"  class="form-control">

                </div>

                <div class="col-md-12" style="margin-top: 10px;">

                    <button type="submit" class="btn btn-primary">Get</button>

                </div>
            </form>


            @if($res)


                <form method="post" action="{{url('refund/top-user')}}">

                    @csrf
                    <br><br>
                    <h2>TOP UP</h2>

                    <span>Balance  -  {{$balance->amount}}</span>

                    <table class="table table-bordered">

                        <tbody>
                        <tr>
                            <td>Previous Balance </td><td>{{$balance->previous_balance}}</td>
                        </tr>

                        <tr>
                            <td>Current Top up </td><td>{{$balance->current_topup}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <input type="text" name="card" readonly value="{{$card_number}}">
                    <input type="text" name="wallet_id" readonly value="{{$balance->wallet_id}}">


                    <label>Amount</label>

                    <input type="text" name="amount">


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>


                <table class="table table-bordered" style="margin-top: 10px;">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Card number</th>
                        <th>Amount</th>
                        <th>terminal_device</th>
                        <th>consumer_current_balance</th>
                        <th>consumer_previous_balance</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tx as $index=>$row)

                        <tr>

                            <th>{{$index+1}}</th>
                            <th>{{$row->created_at}}</th>
                            <th>{{$row->amount}}</th>
                            <th>{{$row->terminal_device}}</th>
                            <th>{{$row->consumer_current_balance}}</th>
                            <th>{{$row->consumer_previous_balance}}</th>

                        </tr>

                    @endforeach
                    </tbody>

                </table>


            @endif


    </div>
        </div>
    </div>
@endsection
