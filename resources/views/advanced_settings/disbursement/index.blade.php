
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">N-CARD DISBURSEMENT ACCOUNTS</h4>
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

                <a  href="{{url('access/users/create')}}" class="btn btn-cyan btn-sm" id="previous">New Account</a>


                {{--</div>--}}

            </div>

            <div class="col-lg-12 table-margin-top">

                <table class="table table-bordered table-striped" id="users-table">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>Amount</th>
                        <th>Type</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php  $index =1;?>

                    @foreach($account  as $row)

                        <tr>

                            <td>{{$index}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->account_number}}</td>
                            <td>{{number_format($row->total_balance,2,'.',',')}}</td>
                            <td>{{$row->type}}</td>


                        </tr>
                        <?php  $index++;?>

                    @endforeach


                    </tbody>
                </table>

            </div>

        </div>

    </div>


@stop


@section('js')


    <script>

        $(function () {


        })
    </script>

@stop
