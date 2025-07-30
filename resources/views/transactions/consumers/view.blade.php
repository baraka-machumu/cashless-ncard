
@extends('layouts.master')

@section('content')
    @can('view-report')

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    <div class="user-details-round-icon">
                        <span>C</span>
                    </div>
                    <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                        <span class="page-title">Consumer Transactions</span>
                    </div>
                </div>
                <div class="col-lg-12">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                        @endif
                    @endforeach
                    <div class="form-row">
                        <div class="col-md-12" style="margin-top: 8px;">
                            <hr/>
                            <form method="post" action="{{url('View-Transactions/consumer-get-trx')}}">
                                {{csrf_field()}}
                                <div class="row">

                                    <div class="col-md-3 form-group">
                                        <input type="date" name="start_date" value="{{old('start_date')}}" class="form-control" placeholder="Start date">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="date" name="end_date" value="{{old('end_date')}}" class="form-control" placeholder="End date">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <input type="text" name="account" value="{{old('account')}}" class="form-control" placeholder="Card or wallet id">
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <select name="tnx_type"  class="form-control" id="agent-tnx">
                                            <option value="" selected disabled>--select type--</option>
                                            <option value="C">CREDIT</option>
                                            <option value="D">DEBIT</option>
                                            <option value="ALL">ALL</option>

                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button class="btn btn-info" type="submit" name="_xt-get">Search</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </form>
                            <hr/>

                            <div class="col-md-6">
                                <table class="table table-bordered table-striped" id="trans">

                                    <tbody>

                                    <tr>
                                        <th>Wallet ID</th><td>{{$res->walletId}}</td>
                                    </tr>
                                    <tr>
                                        <th>System reference</th><td>{{$res->ncard_reference}}</td>
                                    </tr>
                                    <tr>
                                        <th>Terminal</th><td>{{$res->terminal_device}}</td>
                                    </tr>
                                    <tr>
                                        <th>Fullname</th><td>{{$res->fullname}}</td>
                                    </tr>



                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-bordered table-striped" id="trans">

                                    <tbody>

                                    <tr>
                                        <th>Email</th><td>{{$res->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>Current balance</th><td>{{$res->consumer_current_balance}}</td>
                                    </tr>


                                    <tr>
                                        <th>Previous balance</th><td>{{$res->consumer_previous_balance}}</td>
                                    </tr>
                                    <tr>
                                        <th>Transaction amount</th><td>{{$res->amount}}</td>
                                    </tr>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@stop
@section('js')
    <script>
        $('#agent-summary').select2();
        $('#trans').dataTable();
    </script>
@stop
