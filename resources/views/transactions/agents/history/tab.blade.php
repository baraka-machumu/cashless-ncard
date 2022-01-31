@extends('layouts.master')


@section('content')


    <div class="container-fluid">

       <p class="h4-background" style="height: 30px;">
           Agent transactions
       </p>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="deposit-tab" data-toggle="tab" href="#deposit" role="tab" aria-controls="deposit" aria-selected="true">All deposits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">All payments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="failed-tab" data-toggle="tab" href="#failed" role="tab" aria-controls="failed" aria-selected="false">Failed deposits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="reversed-tab" data-toggle="tab" href="#reversed" role="tab" aria-controls="reversed" aria-selected="false">Reversed deposits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="reversed-tab" data-toggle="tab" href="#reversed" role="tab" aria-controls="reversed" aria-selected="false">Failed payments</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="reversed-tab" data-toggle="tab" href="#reversed" role="tab" aria-controls="reversed" aria-selected="false">Reversed payments</a>
            </li>

        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">

              @include('transactions.agents.history.deposits',['paymentPerAgent'=>$paymentPerAgent,'depositPerAgent'=>$depositPerAgent,'agent_code'=>$agent_code])

            </div>
            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">

                @include('transactions.agents.history.payments',['paymentPerAgent'=>$paymentPerAgent,'depositPerAgent'=>$depositPerAgent,'agent_code'=>$agent_code])


            </div>
            <div class="tab-pane fade" id="failed" role="tabpanel" aria-labelledby="failed-tab">

                {{--@include('transactions.agents.failed_deposits',$failedPayments)--}}

            </div>
            <div class="tab-pane fade" id="reversed" role="tabpanel" aria-labelledby="reversed-tab">

                {{--@include('transactions.agents.reversed_deposits',$reversedPayments)--}}


            </div>
        </div>

        <script>
            $(function () {
                $('#myTab li:last-child a').tab('show')
            })
        </script>

    </div>


@stop