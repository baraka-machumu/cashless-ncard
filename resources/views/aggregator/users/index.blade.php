







@extends('layouts.master')


@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Aggregator</h4>
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

                <a href="{{url('aggregators/users/create',[$agent_code])}}" class="btn btn-cyan btn-sm" id="previous">New Aggregator User</a>

                <hr/>

                <form class="row" method="post" action="{{url('agents/get-by-phonenumber')}}">

                    {{csrf_field()}}

                    <div class="col-md-8">
                        <input type="text" name="phone_number" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-info btn-block">Search by phone number</button>
                    </div>
                </form>

                <hr/>

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="agents-all">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Agent Code</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        {{--                        <th>Status</th>--}}
                        <th>Actions</th>
                    </tr>

                    </thead>

                    <tbody>




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
