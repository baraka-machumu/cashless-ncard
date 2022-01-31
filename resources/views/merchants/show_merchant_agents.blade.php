
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Merchant Agents</h4>
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

                <div class="col-md-3">

{{--                <a href="{{url('merchants/create')}}" class="btn btn-cyan btn-sm" id="previous">New Merchant</a>--}}
                </div>

            </div>

            <div class="col-lg-12 table-margin-top">

                <?php $i= 1;?>
                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Merchant</th>
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>

                    @foreach($merchantAgents as $merchantAgent)
                    <tr>

                        <td>{{$i}}</td>
                        <td>{{$merchantAgent->first_name}}</td>
                        <td>{{$merchantAgent->last_name}}</td>
                        <td>{{$merchantAgent->phone_number}}</td>
                        <td>{{$merchantAgent->email}}</td>
                        <td>{{$merchantAgent->tin}}</td>
                        <td>

                            <a href="{{url('merchants/edit-user',$merchantAgent->tin)}}"   class="btn btn-cyan btn-sm"><i class="fa fa-edit"></i> Edit</a>

                        </td>

                    </tr>
                    <?php $i++;?>

                    @endforeach

                    </tbody>
                </table>

                <a  href="{{url()->previous()}}" class="btn btn-info"> back</a>

            </div>

        </div>

    </div>

@stop
