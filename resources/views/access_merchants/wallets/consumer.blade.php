
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">

            {{--<div class="col-md-12" style="margin-bottom: 10px;">--}}

                {{--<a href="{{url('consumers/getall/deposits',1)}}" class="btn btn-info">All deposits</a>--}}
                {{--<a href="{{route('transactions.history',1)}}" class="btn btn-success">All Payments</a>--}}

            {{--</div>--}}
        </div>

        <div class="col-lg-12 show-user-details-2">

            <span>Consumer Wallet Info</span>

        </div>

        <div class="row">


            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>

                        <th>Full Name</th>

                        <th>Balance</th>
                        <th>Wallet Id</th>

                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php $i= 1;?>
                    @foreach($consumers as $consumer)
                    <tr>

                        <td>{{$i}}</td>

                        <td>{{$consumer->first_name.'  '.$consumer->last_name}}</td>
                        <td>{{$consumer->amount}}</td>
                        <td>{{$consumer->wallet_id}}</td>


                        <td>
                            <a id="{{$consumer->wallet_id}}" href="#" class="btn btn-warning consumer-wallet-modal"><i class="fa fa-eye"></i></a>

                            {{--<a href="{{url('consumers/getall/deposits',$consumer->wallet_id)}}" class="btn btn-info"><i class="fa fa-history"></i></a>--}}


                        </td>

                    </tr>
                    <?php $i++;?>

                        @endforeach


                    </tbody>
                </table>

            </div>

        </div>

    </div>


    @include('wallets.cosnumer_wallet_details_modal');




@stop