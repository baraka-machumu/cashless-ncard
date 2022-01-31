
@extends('layouts.master')


@section('content')

        @can('view-report')

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                        <span class="page-title">Get Agent Transactions Summary</span>

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

                            <form method="get" action="{{url('reports/agent-transactions')}}">

                                {{csrf_field()}}


                                <div class="row">

                                    <div class="col-md-4 form-group">

                                        <select name="agent_code"  class="form-control" id="agent-summary">

                                            <option value="" selected disabled>--select agent--</option>

                                            @foreach($agents as $row)

                                                <option value="{{$row->agent_code}}">{{$row->first_name.'  '.$row->last_name}}</option>

                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
{{--                                        @dd($start_date)--}}
                                        @if($start_date)

                                            <input type="date" name="start_date"  value="{{$start_date}}" class="form-control" placeholder="Start date">

                                        @else

                                            <input type="date" name="start_date"   class="form-control" placeholder="Start date">

                                        @endif
                                    </div>

                                    <div class="col-md-4">

                                        @if($start_date)
                                            <input type="date" name="end_date" value="{{$end_date}}" class="form-control" placeholder="End date">

                                        @else
                                            <input type="date" name="end_date" class="form-control" placeholder="End date">

                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <button class="btn btn-info" type="submit">Search</button>
                                            <a href="{{url('reports/agent-summary')}}" class="btn btn-cyan">Refresh</a>

                                        </div>
                                    </div>

                                </div>
                            </form>

                            @if($result)

{{--                                <div class="form-row">--}}

                                    <form method="post" action="{{url('reports/agent-transactions-export')}}">

                                        {{csrf_field()}}

                                        <input type="hidden" name="a_start_date"  value="{{$start_date}}" >
                                        <input type="hidden" name="a_end_date"  value="{{$end_date}}">

                                        <div style="float: right">

                                            <button type="submit" class="btn btn-info pull-right" style="float: right">EXPORT EXCEL</button>

                                        </div>

                                    </form>
{{--                                    <a href="{{url('#')}}" class="btn btn-info pull-right" style="float: right">EXPORT EXCEL</a>--}}

                                    <table class="table table-bordered" id="trans">

                                        <thead>
                                        <tr>
                                            <th>Agent Code</th>
                                            <th>amount (TZS)</th>
                                            <th>recipient_id</th>
                                            {{--                                    <th>Customer Phone #</th>--}}
                                            <th>terminal_device</th>
                                            {{--                                    <th>transaction_type</th>--}}
                                            {{--                                    <th>created_at</th>--}}

                                            <th>Action</th>
                                        </tr>

                                        </thead>

                                        <tbody>

                                        @foreach($result as $row)


                                            <tr>

                                                <td>{{$row->agent_code}}</td>
                                                <td>{{number_format($row->amount,2,'.',',')}}</td>
                                                <td>{{$row->recipient_id}}</td>
                                                {{--                                        <td>{{$row->customer_phone_number}}</td>--}}
                                                <td>{{$row->terminal_device}}</td>
                                                {{--                                        <td>{{$row->transaction_type}}</td>--}}
                                                {{--                                        <td>{{$row->created_at}}</td>--}}

                                                <td>
                                                    <form method="get" action="{{url('reports/agent-transactions',[$row->agent_code])}}" class="btn btn-info ">

                                                        <input type="hidden" name="a_start_date" value="{{$start_date}}">
                                                        <input type="hidden" name="a_end_date" value="{{$end_date}}">

                                                        <button type="submit" class="btn btn-sm btn-info">View</button>

                                                    </form>
                                                </td>

                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>

{{--                                </div>--}}
                                @endif



                        </div>

                    </div>


                </div>

                <div class="col-lg-12 table-margin-top">

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
