







@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Merchant Aggregator</h4>
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

                <a href="{{url('merchant-Aggregators/create')}}" class="btn btn-cyan btn-sm" id="previous">New merchant aggregators</a>

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
                        <th>Merchant Code</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php $i=1;?>
                    @foreach($result as $agent)
                        <tr>

                            <td>{{$i}}</td>
                            <td>{{$agent->name}}</td>
                            <td>{{$agent->code}}</td>
                            <td>{{$agent->phone_number}}</td>
                            <td>{{$agent->email}}</td>
                            <td>{{$agent->location}}</td>

                            <td>
                                <a href="{{url('merchant-Aggregators/view',[$agent->code])}}" class="btn btn-info "><i class="fa fa-eye"></i></a>

                                <a href="{{url('merchant-Aggregators/users')}}" class=" btn btn-info "><i class="fa fa-users"></i></a>
                                <a href="{{url('merchant-Aggregators/set-commission')}}" class="btn btn-primary " ><i class="fa fa-money-bill-alt"></i></a>

                            </td>

                        </tr>
                        <?php $i++;?>

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
