
@extends('layouts.master')


@section('content')






    <div class="container-fluid">



        <div class="row">



            {{--column--}}
            {{--<a href="{{url('success')}}" style="display: inline-block;">--}}
                <div class="col-md-3 col-lg-3 col-xlg-3">
                    <a href="{{url('consumer-transactions/deposits')}}" style="display: block;">
                    <div class="card card-hover">
                        <div class="box bg-success text-center">
                            <h1 class="font-light text-white"><i class="mdi mdi-sale"></i></h1>
                            <h6 class="text-white">All consumer deposits</h6>
                        </div>
                    </div>
                    </a>

                </div>
            {{--</a>--}}

            {{--column--}}
                <div class="col-md-3 col-lg-3 col-xlg-3">
                    <a href="{{url('consumer-transactions/payments')}}" style="display: block;">

                    <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-currency-usd"></i></h1>
                        <h6 class="text-white">All Consumer Payments</h6>
                    </div>
                </div>
                    </a>
            </div>



        </div>


        <div class="col-lg-12 show-user-details-2">


                <span class="pull-left">Payments Transactions Info for <b>{{$fullName}}</b></span>

            <span style="float: right">Total Payments {{$totalDeposits}}</span>


        </div>

        <div class="row">


            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>

                        <th>Full Name</th>
                        <th>Wallet Id</th>
                        <th>Amount</th>

                        <th>Reference</th>
                        <th>Status</th>
                        <th>Date</th>

                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $i=1;?>

                    @foreach($deposits as $deposit)

                        <?php   $status  =  '';?>

                        @if($deposit->status=='0')
                           <?php  $status  =  'Failed';?>

                            @elseif($deposit->status=='1')
                            <?php  $status  =  'Success';?>


                        @elseif($deposit->status=='2')
                            <?php  $status  =  'Pending';?>


                        @endif

                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$deposit->first_name.' '.$deposit->last_name}}</td>

                        <td>{{$deposit->consumer_wallet_id}}</td>
                        <td>{{$deposit->amount}}</td>
                        <td>{{$deposit->reference}}</td>

                        <td>{{$status}}</td>
                        <td>{{$deposit->created_at}}</td>

                        {{--<td style="color: #c43007">{{'Failed'}}</td>--}}

                        <td>
                            <a href="{{route('roles.show',$deposit->consumer_wallet_id)}}" data-toggle="modal" data-target="#show-consumer-modal" class="btn btn-warning"><i class="fa fa-eye"></i></a>


                        </td>

                    </tr>

                        <?php $i++;?>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </div>



    {{--MODEL EDIT--}}

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-consumer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="#">

            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 show-user-details" style="margin-bottom: 10px;">

                            <span>Details for Baraka toe</span>

                        </div>
                        <div class="row">


                            <div class="col-lg-6">


                                <table class="table table-striped">


                                    <tbody>

                                    <tr>
                                        <th>Full Name</th>
                                        <td>Baraka Toe</td>

                                    </tr>

                                    <tr>
                                        <th>Merchant</th>
                                        <td>Danube</td>
                                    </tr>
                                    <tr>
                                        <th>Service</th>
                                        <td>Shopping</td>
                                    </tr>


                                    </tbody>
                                </table>

                            </div>


                            <div class="col-lg-6">


                                <table class="table table-striped">


                                    <tbody>


                                    <tr>
                                        <th>Gateway</th>
                                        <td>Tigo pesa</td>
                                    </tr>

                                    <tr>
                                        <th>Amount</th>
                                        <td>49000</td>
                                    </tr>

                                    <tr>
                                        <th>Date</th>
                                        <td>2019-09-09 3:40:00</td>
                                    </tr>


                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Reverse Transaction</button>
                    </div>


                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>




@stop