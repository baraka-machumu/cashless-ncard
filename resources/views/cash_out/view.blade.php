
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

                                <div class="col-md-6">

                                    <table class="table table-bordered table-striped">

                                        <tbody>

                                        <tr>
                                            <th>Merchant Name</th><td>{{$tx->merchant_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Transaction Date</th><td>{{$tx->trx_date}}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th><td>{{$tx->amount}}</td>
                                        </tr>

                                        <tr>
                                            <th>account_number</th><td>{{$tx->account_number}}</td>
                                        </tr>


                                        </tbody>
                                    </table>

                                    @if($tx->resultcode!='0')

                                        @can('reconcile')
                                        <button type="button" id="repay-btn" class="btn btn-primary">Push To T-pesa</button>

                                        @endcan
                                    @endif

                                </div>
                                <div class="col-md-6">

                                    <table class="table table-bordered table-striped">

                                        <tbody>

                                        <tr>
                                            <th>status</th><td>{{$tx->status}}</td>
                                        </tr>
                                        <tr>
                                            <th>message from t-pesa</th><td>{{$tx->message}}</td>
                                        </tr>
                                        <tr>
                                            <th>resultcode from tpesa</th><td>{{$tx->resultcode}}</td>
                                        </tr>

                                        </tbody>
                                    </table>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>


            </div>
        </div>

    </div>

    @include('cash_out.confirm_cash_out_modal')

@stop


@section('js')

    <script>
        $(function (){

            $('#repay-btn').on('click', function (){


                $('#repay-modal').modal('show');
            });

        });
    </script>


@endsection
