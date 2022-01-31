
@extends('layouts.master')


@section('content')


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
                            <form method="get" action="{{url('reports/getTransactionReportDaily-collection')}}">

                                {{csrf_field()}}

                                <div class="row">


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


                @if($is_result)

                    <div class="col-lg-12 table-margin-top">

                        <form method="post"  action="{{url('reports/getTransactionReportDaily-collection')}}">

                            @csrf
                            <input type="hidden" name="a_start_date" class="form-control" value="{{$_GET['start_date']}}">
                            <input type="hidden" name="a_end_date" class="form-control" value="{{$_GET['end_date']}}" >

                            <input type="hidden"  name="data" value="{{json_encode($result)}}">
                            <button type="submit" class="btn btn-info" style="margin-top: 10px; margin-bottom: 10px;">Export</button>
                        </form>
                        <table class="table table-bordered" id="data-tbl">
                            <thead>

                            <tr>
                                <th>Merchant ID</th>
                                <th>Merchant Name</th>

                                <th>Total Collection</th>
                            </tr>

                            </thead>

                            <tbody>

                            @foreach($result as $row)

                                <tr>
                                    <td>{{$row->merchantTin}}</td>
                                    <td>{{$row->name}}</td>

                                    <td>{{number_format($row->amount,0,'.',',')}}</td>

                                </tr>

                            @endforeach

                          </tbody>
                        </table>
                    </div>

                @endif
            </div>

        </div>




@stop


@section('js')

    <script>

        $('#agent-summary').select2();
        $('#data-tbl').dataTable();

    </script>


@stop
