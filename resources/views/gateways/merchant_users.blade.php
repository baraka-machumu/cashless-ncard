
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Merchant Users</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Merchant Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">

                {{--<div class="col-md-3">--}}

                <a  href="{{url('merchants/users/form')}}" class="btn btn-cyan btn-sm" id="previous">New Users</a>


                {{--</div>--}}

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        {{--<th>Email</th>--}}
                        {{--<th>Location</th>--}}
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>
                    <tr>

                        <td>{{1}}</td>
                        <td>{{'Donald'}}</td>
                        <td>{{'Dop'}}</td>
                        <td>{{'Male'}}</td>
                        {{--<td>{{'info@nssf.or.tz'}}</td>--}}
                        {{--<td>{{'Location'}}</td>--}}
                        <td>
                            <a href="{{url('merchants/users/edit')}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <a href="{{url('merchants/users/1/show')}}" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                        </td>

                    </tr>

                    <tr>

                        <td>{{1}}</td>
                        <td>{{'Donald'}}</td>
                        <td>{{'Dop2'}}</td>
                        <td>{{'Female'}}</td>
                        {{--<td>{{'info@danube.co.z'}}</td>--}}
                        {{--<td>{{'Location'}}</td>--}}
                        <td>

                            <a href="{{url('merchants/users/edit')}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <a href="{{url('merchants/users/1/show')}}" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                        </td>


                    </tr>



                    </tbody>
                </table>

            </div>

        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="create-merchant-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <form method="post" action="#">
                                    <div class="card-body">

                                        <div class="row">


                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="fname">Merchant Name</label>
                                                    <input type="text" class="form-control" id="fname" placeholder="Merchant Name">

                                                </div>

                                                <div class="form-group">

                                                    <label for="telephone_number">Telephone Number</label>
                                                    <input type="text" class="form-control" id="telephone_number" placeholder="Telephone Number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="region">Region</label>
                                                    <input type="text" class="form-control" id="region" placeholder="Region">

                                                </div>

                                                <div class="form-group">

                                                    <label for="location">Location</label>
                                                    <input type="text" class="form-control" id="location" placeholder="Location">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="registration_number">Registration Number</label>
                                                    <input type="text" class="form-control" id="registration_number" placeholder="Registration Number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="email">Email</label>
                                                    <input type="text" class="form-control" id="email" placeholder="Email">

                                                </div>

                                                <div class="form-group">

                                                    <label for="district">District</label>
                                                    <input type="text" class="form-control" id="district" placeholder="District">

                                                </div>

                                                {{--<div class="form-group">--}}

                                                    {{--<button type="submit" style="margin-top: 28px;" class="btn btn-success" name="edit-merchant">Update</button>--}}
                                                {{--</div>--}}

                                            </div>

                                        </div>

                                    </div>
                                </form>
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
    </div>



@stop