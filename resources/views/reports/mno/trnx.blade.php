
@extends('layouts.master')


@section('content')

    @can('agent-topup')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                    <span class="page-title">Get MNO Transaction</span>

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
                        <form method="get" action="{{url('reports/mno-trnx')}}">

                            {{csrf_field()}}

                            <div class="row">

                                <div class="col-md-4 form-group">

                                    <select name="mno_id"  class="form-control" id="agent-summary">

                                        <option value="" selected disabled>--select mno--</option>

                                        @foreach($mno as $row)

                                            <option value="{{$row->id}}">{{$row->name}}</option>

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
                                        <a href="{{url('reports/mno-trnx')}}" class="btn btn-cyan">Refresh</a>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
{{--                                @if(sizeof($result) > 0)--}}
{{--                                    <div class="col-md-2 text-right">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <a href="{{url('export/agent-summary',[$request_for_export['agent_code'],$request_for_export['start_date'],$request_for_export['end_date']])}}" class="btn btn-primary btn-block" type="submit">Export CSV</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                 @endif--}}

                            </div>
                        </form>
                        <hr/>

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
