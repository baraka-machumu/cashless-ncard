
@extends('layouts.master')


@section('content')
    @can('view-report')

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                        <span class="page-title">View Transactions Log</span>
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
                                {{csrf_field()}}
                                <div class="row">

                                    <div class="col-md-12">

                                        <table class="table table-bordered table-striped">

                                            <tbody>

                                            <tr>
                                                <th>Reference number</th><td>{{$result->ref_no}}</td>
                                            </tr>

                                            <tr>
                                                <th>Amount</th><td>{{$result->amount}}</td>
                                            </tr>
                                            <tr>
                                                <th>Created Date</th><td>{{$result->created_at}}</td>
                                            </tr>

                                            <tr>
                                                <th>Initiator</th><td>{{$result->fullname}}</td>
                                            </tr>

                                            <tr>
                                                <th>Response code</th><td>{{$result->response_code}}</td>
                                            </tr>

                                            </tbody>

                                        </table>

                                        @if($result->response_code!=300)

                                            <button class="btn btn-success" data-toggle="modal" data-target="#reprocess-modal">Re-Process</button>

                                        @endif
                                        <a class="btn btn-info" href="{{url('agents',[$result->agent_code])}}">Back</a>

                                    </div>
                                </div>

                            <hr/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @include('transactions.agents.reprocess')
@stop
@section('js')
    <script>
        $('#agent-summary').select2();
        $('#trans').dataTable();
    </script>
@stop
