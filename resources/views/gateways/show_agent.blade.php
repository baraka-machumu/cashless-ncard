
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span>BT</span>
                </div>
                <h4 class="page-title">Baraka toe's Profile</h4>
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

        <div class="col-lg-12 show-user-details-2">

            <span>Info</span>

        </div>

        <div class="row">


            <div class="col-lg-6">

                <table class="table table-striped">

                    <tbody>

                    <tr>
                       <th>First Name</th>
                        <td>Baraka</td>

                    </tr>
                    <tr>
                        <th>Middle Name</th>
                        <td>T</td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>Toe</td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td>Male</td>
                    </tr>
                    <tr>

                        <th>Date of Birth</th>
                        <td>08/09/2000</td>
                    </tr>


                    </tbody>
                </table>

            </div>

            <div class="col-lg-6">


                {{--<div class="col-md-12">--}}

                        <table class="table table-striped">

                            <tbody>

                            <tr>
                                <th> Agent Number</th>
                                <td>33434</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>barakatoe@gmail.com</td>
                            </tr>


                            <tr>
                                <th>Region</th>
                                <td>Dar es salaam</td>
                            </tr>

                            <tr>
                                <th>District</th>
                                <td>Temeke</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td>Mikoroshini</td>
                            </tr>
                            </tbody>
                        </table>
                <div class="form-group">

                    <a  href="{{url()->previous()}}" style="margin-top: 28px;" class="btn btn-success" name="edit-merchant">Edit</a>
                    <a  href="{{url()->previous()}}" style="margin-top: 28px;" class="btn btn-info" name="edit-merchant">Back</a>

                </div>

                {{--</div>--}}


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