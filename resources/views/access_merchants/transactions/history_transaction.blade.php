
@extends('layouts.master_merchant')

@section('content')

    <div class="container-fluid">

        <div class="row">


        </div>


        <div class="col-lg-12 show-user-details-2">

            <span>Transactions Info for Baraka Toe</span>

        </div>

        <div class="row">

            <div class="col-lg-12 table-margin-top">

                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>

                        <th>Full Name</th>

                        <th>Service</th>
                        <th>Gateway</th>
                        <th>Amount</th>
                        <th>Status</th>

                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>

                        <td>{{1}}</td>

                        <td>{{'Baraka Toe'}}</td>
                        <td>{{'Shopping'}}</td>
                        <td>{{'Tigo pesa'}}</td>
                        <td>{{'20000'}}</td>
                        <td style="color: #1c964f">{{'Success'}}</td>

                        <td>
                            <a href="{{route('roles.show',1)}}" data-toggle="modal" data-target="#show-consumer-modal" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                            <a href="{{route('transactions.history',1)}}" data-toggle="modal" data-target="#show-reverse-modal" class="btn btn-info"><i class="fas fa-undo"></i></a>

                        </td>

                    </tr>

                    <tr>
                        <td>{{1}}</td>

                        <td>{{'Baraka Toe'}}</td>
                        <td>{{'Shopping'}}</td>
                        <td>{{'M-pesa'}}</td>
                        <td>{{'20000'}}</td>
                        <td style="color: #c43007">{{'Failed'}}</td>

                        <td>
                            <a href="{{route('roles.show',1)}}" data-toggle="modal" data-target="#show-consumer-modal" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                            <a href="{{route('transactions.history',1)}}" data-toggle="modal" data-target="#show-reverse-modal" class="btn btn-info"><i class="fas fa-undo"></i></a>

                        </td>

                    </tr>

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


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-reverse-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                            <p>Reverse Transaction for Baraka toe</p>

                        </div>
                        <div class="row">


                            <div class="col-md-6" style="height: 50px;">
                                <span>Are you sure you want to reverse this transaction?</span>


                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Reverse</button>
                    </div>


                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>



@stop