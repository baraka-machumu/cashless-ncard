
@extends('layouts.master')


@section('content')


    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12 show-user-details-2">

                <span>Get Transactions Info</span>

            </div>
        </div>

        <div class="row-form">
            <form action="{{url('View-Transactions/consumer-get-trx')}}" method="post">

                @csrf
                <div class="col-md-12">


                    <div class="form-group">
                        <label>Card Number</label>
                        <input class="form-control"  name="card_number" id="card_number" type="text">
                    </div>

                    <div class="form-group">

                        <label>Start Date</label>
                        <input class="form-control"  name="start_date" id="start_date" type="date">
                    </div>

                    <div class="form-group">

                        <label>End Date</label>

                        <input class="form-control"  name="end_date" id="end_date" type="date">

                    </div>
                    <button type="submit" class="btn btn-info" style="margin-top: 10px;">Get</button>

                </div>

            </form>


        </div>

        @if($result)

            <form action="{{url('export/consumer-trnx')}}" method="post">

                <button class="btn"  type="submit">Export</button>

            </form>
            <table class="table table-bordered" style="margin-top: 10px;">

                <thead>

                <tr>
                    <th colspan="6" style="background-color: #0d374a; color: white;"> Transactions For Card Number {{$card_number}} - Total Amount - <?php echo $sum ?></th>
                </tr>

                <tr>
                    <th>No</th>
                    <th>PhoneNumber</th>
                    <th>EventName</th>
                    <th>TicketRef</th>
                    <th>PaymentRef</th>

                    <th>ChannelCode</th>
                    <th>Amount</th>
                    <th>PaidDate</th>

                </tr>
                </thead>
                <tbody>
                @foreach($result as $index=>$row)

                    <tr>

                        <th>{{$index}}</th>
                        <th>{{$row->PhoneNumber}}</th>
                        <th>{{$row->EventName}}</th>
                        <th>{{$row->TicketRef}}</th>
                        <th>{{$row->PaymentRef}}</th>

                        @if($row->ChannelCode==1)

                            <span>N-CARD- AGENT</span>
                        @else
                            <th>{{$row->ChannelCode}}</th>
                        @endif

                        <th>{{$row->Amount}}</th>
                        <th>{{$row->PaidDate}}</th>

                    </tr>

                @endforeach
                </tbody>

            </table>

        @endif
    </div>


@stop

@section('js')

    <script>
        $(function (){

            $('#card_number').on('keydown',function (){

                let cardNumber  = $('#card_number').val();

                console.log(cardNumber);

                let cardNo  = prefix(cardNumber);

                $('#card_number').val(cardNo)


                console.log('formated card number = '+cardNo)



            })


            function  prefix(cardNo){


                if (cardNo.length==1){

                    return  '100000000000000'+cardNo;

                }


                if (cardNo.length==2){

                    return  '10000000000000'+cardNo;

                }

                if (cardNo.length==3){

                    return  '1000000000000'+cardNo;

                }

                if (cardNo.length==4){

                    return  '100000000000'+cardNo;

                }

                if (cardNo.length==5){

                    return  '10000000000'+cardNo;

                }

                if (cardNo.length==6){

                    return  '1000000000'+cardNo;

                }
                if (cardNo.length==7){

                    return  '100000000'+cardNo;

                }
                if (cardNo.length==8){

                    return  '10000000'+cardNo;

                }
                if (cardNo.length==8){

                    return  '1000000'+cardNo;

                }


                return cardNo;

            }
        });
    </script>
@stop
