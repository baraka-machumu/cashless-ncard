@extends('layouts.master')

@section('stylesheets')
    <style>


    </style>
@stop

@section('content')

    <x-header-page code="C" title="Limit Class" ></x-header-page>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach
                @cannot('maker')
                    <a  href="{{url('limits-class/create')}}"
                        class="btn btn-cyan btn-sm" id="previous">New Limit Class</a>
                @endcan
            </div>
            <table class="table table-bordered" id="datatable">

                <thead>

                <tr>
                    <th>No</th>
                    <th>Class Name</th>
                    <th>Account Limit</th>
                    <th>Daily Limit</th>
                    <th>Credit Limit</th>
                    <th>Debit Limit</th>
                    <th>Created Date</th>
                    <th>Action</th>

                </tr>
                </thead>

                <tbody>


                @foreach($limits as $index=>$row)

                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$row->class_name}}</td>
                        <th>{{$row->balance_limit}}</th>
                        <th>{{$row->daily_limit}}</th>
                        <th>{{$row->credit_limit}}</th>
                        <th>{{$row->debit_limit}}</th>
                        <td>{{$row->created_at}}</td>
                        <td>
                            <a href="{{url('limits-class',[$row->id])}}" class="btn btn-primary">view</a>
                            <a href="{{route('limits-class-edit',[$row->id])}}" class="btn btn-primary">Edit</a>

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

        $('#datatable').DataTable();

    </script>
@stop
