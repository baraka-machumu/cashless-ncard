
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Services</h4>
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

                <button type="button" data-toggle="modal" data-target="#create-merchant-modal" class="btn btn-cyan btn-sm" id="previous">New Service</button>


                {{--</div>--}}

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>

                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>


                    <?php $i=1; ?>
                    @foreach($services as $service)

                    <tr>
                        <td>{{$i}}</td>

                        <td>{{$service['name']}}</td>


                        <td>
                            <a href="{{url('services/edit')}}" data-toggle="modal" data-target="#edit-service-modal"  class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <a href="" class="btn btn-danger disabled"><i class="fa fa-trash"></i></a>
                            <a href="" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                        </td>


                    </tr>

                    <?php $i++; ?>

                    @endforeach


                    </tbody>
                </table>

            </div>

        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="create-merchant-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="{{route('services.store')}}">

            {{csrf_field()}}
        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Create Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-body">

                                        <div class="row">


                                            <div class="col-md-12">

                                                <div class="form-group">

                                                    <label for="service_name">Service Name</label>
                                                    <input type="text" class="form-control" name="service_name" id="service_name" placeholder="Service Name">

                                                </div>

                                            </div>


                                        </div>

                                    </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
        </form>

    </div>


    {{--MODEL EDIT--}}


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="edit-service-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="#">

            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">


                                            <div class="col-md-12">

                                                <div class="form-group">

                                                    <label for="service_name">Service Name</label>
                                                    <input type="text" class="form-control" id="service_name" value="{{'SHOPING'}}" placeholder="Service Name">

                                                </div>
                                                <div class="form-group">

                                                    <label for="fname">Merchant Name</label>
                                                    <input type="text" class="form-control" id="fname" value="{{'NSSF'}}" placeholder="Merchant Name">

                                                </div>


                                            </div>


                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>

    </div>




@stop