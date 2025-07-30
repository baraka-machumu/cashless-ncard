@extends('layouts.master')

@section('stylesheets')
    <style>

        .checkbox-custom {

            height: 15px;
            width: 60px;
            margin-left: 0;
        }

        .perm-role-span {

            height: 10px;
            width: 70px;
            margin-left: 0;
            margin-top: -2px;

        }

        .rol-perm-list{

            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        ul {
            list-style-type: none;
        }
        . .rol-perm-list li {

            list-style-type: none;
        }
    </style>
@stop

@section('content')

    <x-header-page short-h="V" title="View Limit Class" ></x-header-page>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach

                    <a href="{{url('limits-class')}}" class="btn btn-primary">Back</a>
            </div>


            <div class="col-lg-12 table-margin-top">

                <table class="table table-bordered table-striped">

                    <tbody>

                    <tr>
                        <th>Name</th> <td>{{$limitClass->class_name}}</td>
                    </tr>
                    <tr>
                        <th>Class Code</th> <td>{{$limitClass->class_code}}</td>
                    </tr>
                    <tr>
                        <th>Maximum Account Can Hold</th> <td>{{number_format($limitClass->max_hold_amount,2,'.',',')}}</td>
                    </tr>

                    <tr>
                        <th>Class Currency </th> <td>{{$limitClass->currency}}</td>
                    </tr>
                    <tr>
                        <th>Created Date</th> <td>{{$limitClass->created_at}}</td>
                    </tr>

                    </tbody>
                </table>

                <h4>Associated Limits  Rules</h4>
                <table class="table table-bordered" id="datatable">

                    <thead>

                    <tr>
                        <th>No</th>
                        <th>Limit name</th>
                        <th>Limit code</th>
                        <th>Max daily</th>
                        <th>Max weekly</th>
                        <th>Max monthly</th>
                        <th>Created  at</th>
                        <th>Action</th>

                    </tr>
                    </thead>

                    <tbody>


                    @foreach($limits as $index=>$row)

                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$row->limit_code_name}}</td>
                            <td>{{$row->limit_code}}</td>
                            <td>

                                <span>Amount:  {{$row->max_daily}}</span><br>
                                <hr>
                                <span>Transactions :  {{$row->daily_tx_no}}</span>

                            </td>

                            <td>

                                <span>Amount:  {{$row->max_weekly}}</span><br>
                                <hr>
                                <span>Transactions :  {{$row->weekly_tx_no}}</span>


                            </td>
                            <th>
                                <span>Amount:  {{$row->max_monthly}}</span><br>
                                <hr>
                                <span>Transaction :  {{$row->weekly_tx_no}}</span>


                            </th>
                            <td>{{$row->created_at}}</td>
                            <td>
                                <a href="{{route('edit-limit',[$row->id])}}" class="btn btn-cyan fa fa-edit"></a>
                            </td>

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

        $('#datatable').DataTable();

    </script>
@stop
