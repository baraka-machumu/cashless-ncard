@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach
            </div>
            <table class="table table-bordered" style="background-color: #1C729E; color: white;">

                <tbody>
                <tr>
                    <td>Total POS</td> <td>{{count($pos)}}</td>
                </tr>
                </tbody>
            </table>

            {{--            @include('partials.error_message')--}}
            <div class="col-md-12">

                <form method="post" action="{{url('pos/store')}}">

                    {{csrf_field()}}

                    <div class="row" style="width:100%">
                        <div class="col-3" style="float: left;">

                            <label>Add pos</label>
                            <div class="form-group">

                                <input type="text" name="pos" class="form-control">

                            </div>

                        </div>
                        <div class="col-md-3" style="margin-top: 30px;">
                            <div class="form-group">
                                <button class="btn btn-info" type="submit">Save</button>

                            </div>

                        </div>

                        <div class="col-5" style="float: right;">

                            <label>Pos Advanced search</label>

                            <div class="form-group">

                                <input type="text" name="imei_no_search" class="form-control" >

                            </div>

                        </div>

                        <div class="col-md-1" style="margin-top: 30px;">
                            <div class="form-group">
                                <button class="btn btn-info" name="imei-search" type="submit">Search</button>

                            </div>
                        </div>

                    </div>
                </form>


            </div>
            <div class="col-md-5">


            </div>
            <table class="table table-bordered table-striped" id="all-cards">

                <thead>

                <tr>
                    <th>No</th>
                    <th>Imei Number</th>
                    <td>Agent code</td>
                    <th>Status</th>
                    <td>Action</td>
                </tr>

                </thead>


                <tbody>

                @foreach($pos as $index=>$row)
                    <tr>

                        <td>{{$index+1}}</td>
                        <td>{{$row->imei_no}}</td>
                        <td>{{$row->agent_code}}</td>
                        <td>

                            @if($row->status_id==1)

                                Active
                            @else

                                Not Active

                            @endif

                        </td>

                        <td>
                            <a href="{{url('pos/reset',[$row->imei_no])}}" class="btn btn-primary">reset</a>
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>

    </div>
@stop

@section('js')
    <script>

        // $('#trans-filter').select2();

        $('.card-select').select2({
            placeholder: "Select card",
            allowClear: true
        });

        $('#all-cards').dataTable();
    </script>

@stop
