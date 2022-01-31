
@extends('layouts.master')


@section('content')

    @can('agent-topup')

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                        <span class="page-title">Get Merchant Transaction</span>

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
                            <form method="get" action="{{url('reports/merchant-collection/get-data')}}">

                                {{csrf_field()}}

                                <div class="row">

                                    <div class="col-md-4 form-group">

                                        <select name="tin"  class="form-control" id="tin">

                                            <option value="" selected disabled>--select merchant--</option>

                                            @foreach($merchants as $row)

                                                <option value="{{$row->tin}}">{{$row->name}}</option>

                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <input type="date" name="start_date" class="form-control" placeholder="Start date">
                                    </div>

                                    <div class="col-md-4">

                                        <input type="date" name="end_date" class="form-control" placeholder="End date">

                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <button class="btn btn-info" type="submit">Search</button>
                                            <a href="{{url('reports/mno-collection')}}" class="btn btn-cyan">Refresh</a>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>


                                </div>
                            </form>
                            <hr/>

                        </div>

                    </div>


                </div>


                @if($operation)

                    <div class="col-lg-12 table-margin-top">

                        <form method="post"  action="{{url('reports/merchant-collection/export-data')}}">

                            @csrf
                            <input type="hidden" name="a_start_date" class="form-control" value="{{$_GET['start_date']}}">
                            <input type="hidden" name="a_end_date" class="form-control" value="{{$_GET['end_date']}}" >
                            <input type="hidden" name="a_tin" class="form-control" value="{{$_GET['tin']}}">

                            <button type="submit" class="btn btn-primary">Export to excel</button>
                        </form>
                        <table class="table table-bordered" id="data-tbl">
                            <thead>

                            <tr>
                                <th>No</th>
                                <th>Wallet Id</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>

                            </thead>

                            <tbody>
                            @foreach($result as $index=>$row)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$row->consumer_wallet_id}}</td>
                                    <td>{{$row->amount}}</td>
                                    <td>{{$row->created_at}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @endif
            </div>

        </div>

    @endcan


@stop


@section('js')

    <script>

        $('#agent-summary').select2();
        $('#data-tbl').dataTable();

    </script>


@stop
