
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12" style="margin-bottom: 10px;">

                <a href="{{url('consumers/getall/deposits',1)}}" class="btn btn-info">All deposits</a>
                <a href="{{route('transactions.history',1)}}" class="btn btn-success">All Payments</a>

            </div>
        </div>

        <div class="col-lg-12 show-user-details-2">

            <span>Consumer deposits Info</span>

        </div>

        <div class="row">


            <div class="col-lg-12 table-margin-top">

                <table class="table table-striped table-bordered">

                    <tbody>
                    <tr>
                        <th>Full Name</th>
                        <td>{{$consumerInfo->first_name.' '.$consumerInfo->last_name}}</td>
                    </tr>
                    <tr>
                        <th>Wallet Id</th>
                        <td>{{$consumerInfo->wallet_id}}</td>
                    </tr>
                    <tr>
                        <th>Available Balance</th>
                        <td>{{$consumerInfo->amount}}</td>
                    </tr>

                    </tbody>

                </table>

                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>

                        <th>Full Name</th>

                        <th>Balance</th>
                        <th>Wallet Id</th>

                        <th>Gateway Id</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>


                    @foreach($deposits as $deposit)
                    <tr>

                        <td>{{1}}</td>

                        <td>{{$deposit['consumerWallet']['consumer']->first_name}}</td>
                        <td>{{$deposit->amount}}</td>
                        <td>{{$deposit->consumer_wallet_id}}</td>
                        <td>{{$deposit->gateway_id}}</td>


                        <td>
                            <a href="{{route('roles.show',1)}}" data-toggle="modal" data-target="#show-consumer-modal" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                            <a href="{{route('transactions.history',1)}}" class="btn btn-info"><i class="fa fa-history"></i></a>


                        </td>

                    </tr>

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