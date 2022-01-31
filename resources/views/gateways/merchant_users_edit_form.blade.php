
@extends('layouts.master')


@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="margin-left: 15px;">
                <h4>Edit User</h4>
            </div>

        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <form method="post" action="#">
                        <div class="card-body">

                            <div class="row">


                                <div class="col-md-5">
                                    <div class="form-group">

                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" id="first_name" placeholder="First Name">

                                    </div>
                                    <div class="form-group">

                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" id="middle_name" placeholder="Middle Name">

                                    </div>
                                    <div class="form-group">

                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="view_all">
                                            <label class="custom-control-label" for="view_all">View All</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="edit_all">
                                            <label class="custom-control-label" for="edit_all">Edit All</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="transaction">
                                            <label class="custom-control-label" for="transaction">Transaction</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="view_all">
                                            <label class="custom-control-label" for="view_all">View All</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="edit_all">
                                            <label class="custom-control-label" for="edit_all">Edit All</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="transaction">
                                            <label class="custom-control-label" for="transaction">Transaction</label>
                                        </div>



                                    </div>





                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">

                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" placeholder="Last Name">

                                    </div>
                                    <div class="form-group">

                                        <label for="gender">Gender</label>
                                        <input type="text" class="form-control" id="gender" placeholder="Gender">

                                    </div>

                                    <div class="form-group">

                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="view_all">
                                            <label class="custom-control-label" for="view_all">View All</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="edit_all">
                                            <label class="custom-control-label" for="edit_all">Edit All</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="transaction">
                                            <label class="custom-control-label" for="transaction">Transaction</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="view_all">
                                            <label class="custom-control-label" for="view_all">View All</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="edit_all">
                                            <label class="custom-control-label" for="edit_all">Edit All</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="transaction">
                                            <label class="custom-control-label" for="transaction">Transaction</label>
                                        </div>



                                    </div>


                                    <div class="form-group">

                                        <button type="submit" style="margin-top: 28px;" class="btn btn-success" name="edit-merchant">Update</button>
                                        <a  href="{{url()->previous()}}" style="margin-top: 28px;" class="btn btn-warning" name="edit-merchant">Cancel</a>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </form>
                </div>


            </div>
        </div>

    </div>


@stop