
@extends('layouts.master')


@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="margin-left: 15px;">
                <h4>Edit Merchant</h4>
            </div>

        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <form method="post" action="#">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="fname">First Name</label>
                                        <input type="text" class="form-control" id="fname" placeholder="Merchant Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="telephone_number">Last Number</label>
                                        <input type="text" class="form-control" id="telephone_number" placeholder="Telephone Number">

                                    </div>

                                    <div class="form-group">

                                        <label for="gender">Gender</label>
                                        <input type="text" class="form-control" id="gender" placeholder="Gender">

                                    </div>

                                    <div class="form-group">

                                        <label for="location">Date of Birth</label>
                                        <input type="text" class="form-control" id="location" placeholder="Date of Birth">

                                    </div>

                                    <div class="form-group">

                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" id="location" placeholder="Location">

                                    </div>
                                    <div class="form-group">

                                        <button type="submit"  class="btn btn-success" name="edit-merchant">Update</button>
                                        <a  href="{{url()->previous()}}"  class="btn btn-warning" name="edit-merchant">Cancel</a>

                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="registration_number">Agent Number</label>
                                        <input type="text" class="form-control" id="registration_number" placeholder="Agent Number">

                                    </div>

                                    <div class="form-group">

                                        <label for="email">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" placeholder="Phone Number">

                                    </div>
                                    <div class="form-group">

                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="Email">

                                    </div>
                                    <div class="form-group">

                                        <label for="region">Region</label>
                                        <input type="text" class="form-control" id="region" placeholder="Region">

                                    </div>
                                    <div class="form-group">

                                        <label for="district">District</label>
                                        <input type="text" class="form-control" id="district" placeholder="District">

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