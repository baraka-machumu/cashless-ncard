@extends('layouts.master')

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Aggregator Commission</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Merchant</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach

                {{--<div class="col-md-3">--}}

                <a href="{{url('aggregators/set-commission-new',[$code])}}" class="btn btn-cyan btn-sm" id="previous">Set New commission</a>


                <hr/>

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="agents-all">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>percentage</th>

                        <th>transaction_type_code</th>
                        <th>transaction_type_name</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($result as $index=>$row)

                        <tr>

                            <td>{{$index+1}}</td>
                            <td>{{$row->percentage}}</td>
                            <td>{{$row->transaction_type_code}}</td>

                            <td>{{$row->name}}</td>

                        </tr>

                    @endforeach



                    </tbody>
                </table>

            </div>

        </div>

    </div>

@stop

@section('js')

    <script>
        $('#agents-all').dataTable();

    </script>


@stop
