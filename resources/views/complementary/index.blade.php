
@extends('layouts.master')


@section('content')

    @can('agent-topup')

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                        <span class="page-title">Complementary</span>
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
                            <form method="get" action="{{url('reports/agent-transactions')}}">

                                {{csrf_field()}}

                                <div class="row">

                                    <div class="col-md-4 form-group">

                                        <select name="agent_code"  class="form-control" id="agent-summary">

                                            <option value="" selected disabled>--select service provider--</option>

{{--                                            @foreach($agents as $row)--}}

{{--                                                <option value="{{$row->agent_code}}">{{$row->first_name.'  '.$row->last_name}}</option>--}}

{{--                                            @endforeach--}}

                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">

                                        <select name="agent_code"  class="form-control" id="agent-summary">

                                            <option value="" selected disabled>--select merchant service--</option>

                                            {{--                                            @foreach($agents as $row)--}}

                                            {{--                                                <option value="{{$row->agent_code}}">{{$row->first_name.'  '.$row->last_name}}</option>--}}

                                            {{--                                            @endforeach--}}

                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">

                                        <select name="agent_code"  class="form-control" id="agent-summary">

                                            <option value="" selected disabled>--select event--</option>

                                            {{--                                            @foreach($agents as $row)--}}

                                            {{--                                                <option value="{{$row->agent_code}}">{{$row->first_name.'  '.$row->last_name}}</option>--}}

                                            {{--                                            @endforeach--}}

                                        </select>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button class="btn btn-info btn-block" type="submit">Search</button>
                                        </div>
                                    </div>


                                </div>
                            </form><hr/>
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

                                @foreach($results as $row)


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
