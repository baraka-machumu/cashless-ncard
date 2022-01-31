@extends('layouts.master')


@section('content')



    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Fee Charges</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Fee Charges</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Management Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
            @endif
        @endforeach
        <div class="row">

            <div class="col-lg-12">

                <button type="button" data-toggle="modal" data-target="#create-charges-modal"
                        class="btn btn-cyan btn-sm" id="previous">New Charges
                </button>


            </div>


            <div class="container-fluid table-margin-top">
                <table class="table table-striped table-bordered table-condensed" id="#datatable">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Minimum</th>
                        <th>Maximum</th>
                        <th>Fee charge</th>
                        <th>Action</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i = 1;?>
                    @foreach($charges as $charge)
                        <tr>

                            <td>{{$i}}</td>
                            <td>{{$charge->min}}</td>
                            <td>{{$charge->max}}</td>
                            <td>{{$charge->fee_charge}}</td>
                            <td>
                                <a href="#" class="btn btn-success "><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn btn-cyan"><i class="fa fa-eye"></i></a>
                                <a href="#" class="btn btn-warning"><i class="fa fa-trash"></i></a></td>

                        </tr>
                        <?php $i++;?>
                    @endforeach
                    </tbody>
                </table>


            </div>

        </div>
    </div>


@stop
