
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px; height: 50px; ">
                    <h4 class="page-title" style="line-height: 50px;">Cash out for merchant</h4>

                </div>
            </div>
            <div class="col-md-12">

                @include('partials.error_message')
                <div class="card">

                    <form method="get" action="{{url('Fund/transfer-to-merchant')}}">

                        {{csrf_field()}}

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">

                                    <label>Merchant Name</label>

                                    <select class="form-control" name="tin" REQUIRED>

                                        <option value="">--select merchant--</option>

                                        @foreach($merchant as $row)

                                            <option value="{{$row->tin}}" >{{$row->name}}</option>
                                        @endforeach
                                    </select>


                                </div>
                                <div class="col-md-4">

                                    <label>Action type</label>

                                    <select class="form-control" name="action" required>

                                        <option value="">--select action--</option>

                                        <option value="1">Auto Request</option>
                                        <option value="2">Manual Request</option>

                                    </select>


                                </div>
                                <div class="col-md-1">
                                    <button name="check" style="margin-top: 25px;" type="submit" class=" btn btn-primary">Check</button>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                @if($result)

                    <h5 style="color: #1a93ca">Commission For  {{$tin}}  is {{$commission*100}} </h5>

                    <table class="table table-bordered">

                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Send Date</th>
                            <th>Payment Date</th>
                            <th>Amount</th>
                            <th>Commission</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Message</th>
                            <th>Action</th>

                        </tr>
                        </thead>

                        @foreach($rev as $index=>$row)

                            <tr>

                                <td>{{$index+1}}</td>
                                <td>{{$row->mdate}}</td>
                                <td>{{$row->trx_date}}</td>
                                <td>{{number_format($row->amount,2,'.',',')}}</td>
                                <th>{{number_format(($row->amount)/(1-$commission)*$commission,2,'.',',')}}</th>
                                <th>{{number_format(($row->amount)/(1-$commission),2,'.',',')}}</th>


                                <td>
                                    @if($row->status!=200)

                                        <span style="color: white;" class="badge bg-danger">
                                    Not Paid</span>
                                    @else
                                        <span style="color: #1b4584">Paid</span>
                                    @endif

                                </td>
                                <td>
                                    @if($row->message==null)

                                        <span>Network Error,Time-Out</span>
                                    @else

                                    {{$row->message}}</td>

                                @endif

                                <td>

                                    <a href="{{url('Fund/view-transfer-status',[$row->tx_reference,$row->merchant_tin])}}" class="btn btn-primary">

                                        view
                                    </a>

                                </td>


                            </tr>

                        @endforeach
                    </table>



                @endif


            </div>
        </div>

    </div>

    @include('cash_out.cash_out_modal')

@stop


@section('js')

    <script>
        $(function (){

            $('.btn-cash-out').on('click', function (){

                let date     =  this.id;

                $('#date-c').val(date);

                $('#cash-out-modal').modal('show');
            });

        });
    </script>


@endsection
