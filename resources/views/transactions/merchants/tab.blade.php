@extends('layouts.master')


@section('content')


    <div class="container-fluid">

       <p class="h4-background" style="height: 30px;">
           Merchant transactions
       </p>
        <ul class="nav nav-tabs" id="consumerTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="true">All payments</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="failed-tab" data-toggle="tab" href="#failed" role="tab" aria-controls="failed" aria-selected="false">Failed Transactions</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="reversed-tab" data-toggle="tab" href="#reversed" role="tab" aria-controls="reversed" aria-selected="false">Reversed Transactions</a>
            </li>
        </ul>



        <div class="tab-content">
            <div class="tab-pane active" id="payments" role="tabpanel" aria-labelledby="payments-tab">

                @include('transactions.merchants.payments',$payments)

            </div>

            <div class="tab-pane fade" id="failed" role="tabpanel" aria-labelledby="failed-tab">

                @include('transactions.merchants.failed_payments',$failedPayments)

            </div>
            <div class="tab-pane fade" id="reversed" role="tabpanel" aria-labelledby="reversed-tab">

                @include('transactions.merchants.reversed_payments',$reversedPayments)


            </div>
        </div>



    </div>







@stop

@section('js')

    <script>
        $(function () {

            $('#merchant-payment').dataTable();
        })
    </script>
    @stop
