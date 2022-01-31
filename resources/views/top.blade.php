@extends('layouts.master')

@section('content')


    <div class="col-md-12" style="margin-top: 20px;">

        @include('partials.error_message')

        <form method="post" action="{{url('top')}}">

            @csrf

            <label>Card Number</label>

            <input type="text" name="card">


            <label>Start Date</label>

            <input type="date" name="start_date"  >

            <label>End Date</label>

            <input type="date" name="end_date"  >


            <button type="submit" class="btn btn-primary">Get</button>
        </form>


        @if($res)


            <form method="post" action="{{url('top-user')}}">

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
                    <th>previous_balance</th>

                </tr>
                </thead>
                <tbody>
                @foreach($tx as $index=>$row)

                <tr>

                    <th>{{$index}}</th>
                    <th>{{$row->card_number}}</th>
                    <th>{{$row->amount}}</th>
                    <th>{{$row->prev}}</th>

                </tr>

                @endforeach
                </tbody>

            </table>


            <table class="table table-bordered" style="margin-top: 10px;">

                <thead>

                <tr>
                    <th colspan="6" style="background-color: #0d374a; color: white;"> Ticket Engine Transactions  Total Amount - <?php echo $sum ?></th>
                </tr>

                <tr>
                    <th>No</th>
                    <th>PhoneNumber</th>
                    <th>EventName</th>
                    <th>TicketRef</th>
                    <th>Amount</th>
                    <th>PaidDate</th>

                </tr>
                </thead>
                <tbody>
                @foreach($engine as $index=>$row)

                    <tr>

                        <th>{{$index}}</th>
                        <th>{{$row->PhoneNumber}}</th>
                        <th>{{$row->EventName}}</th>
                        <th>{{$row->TicketRef}}</th>
                        <th>{{$row->Amount}}</th>
                        <th>{{$row->PaidDate}}</th>

                    </tr>

                @endforeach
                </tbody>

            </table>


        @endif
    </div>
@endsection
