
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span>{{strtoupper(mb_substr($name, 0, 2, 'utf-8'))}}</span>
                </div>
                <h4 class="page-title">{{$name}}</h4>
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

            <span>Role Info</span>

        </div>

        <div class="row">


            <div class="col-lg-12">

                <table class="table table-striped">

                    <thead>

                   <tr>
                       <th>#</th>
                       <th>Full Name</th>
                       <th>Role</th>
                       <th>Status</th>

                   </tr>


                    </thead>

                    <tbody>


                    @foreach($userstoroles as $userstorole)

                        <tr>

                            <td>1</td>
                            <td>{{$userstorole->email}}</td>
                            <td>{{$userstorole->phone_number}}</td>

                            <td>Active</td>

                        </tr>


                        @endforeach
                    </tbody>
                </table>

                <a href="{{url()->previous()}}" class="btn btn-info">Back</a>

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