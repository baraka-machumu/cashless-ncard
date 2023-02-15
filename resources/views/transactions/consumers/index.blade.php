
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

                            @if($result)
                            <span style="font-weight: bold">@if($tnx_type=='C') CREDIT TRANSACTIONS
                                @elseif($tnx_type=='D') DEBIT TRANSACTIONS @endif -> <?php echo count($result); ?></span>
                            @endif
                            <hr/>

                            <table class="table table-bordered table-striped" id="trans">
                                <thead>
                                <tr>
                                    <th>Agent Code </th>
                                    <th>Amount</th>
                                    <th>Previous Balance</th>
                                    <th>Current Balance</th>
                                    <th>Created</th>
                                    <th>Created by</th>
                                    <th>Reference</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($result as $row)
                                    <tr>
                                        <td>{{$row->agent_code??'N/A'}}</td>
                                        <td>{{number_format($row->amount,0,'.',',')}}</td>
                                        <td>{{number_format($row->previous_balance??0,0,'.',',')}}</td>
                                        <td>{{number_format($row->current_balance??0,0,'.',',')}}</td>
                                        <td>{{$row->created_at??''}}</td>
                                        <td>{{$row->full_name??''}}</td>
                                        <td>{{$row->reference??''}}</td>
                                        <td>
                                            <a href="{{url('view-Transactions/agent-tnx-print',[encrypt($row->id??'')])}}" class="btn btn-info">Print</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
