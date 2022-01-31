
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-12 show-user-details-2">

                <div class="pull-left">

                    <span style="text-align: start">Create Agent</span>
                </div>


            </div>
            <div class="col-md-12">


                <div class="card">
                    <form method="post" action="{{route('agents.store')}}">

                        {{csrf_field()}}
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="middle_name">Agent Code</label>
                                        <input type="text" class="form-control" name="agent_code" id="agent_code" placeholder="Agent Code">

                                    </div>
                                    <div class="form-group">
                                        <label for="mname">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="service">Gender</label> <br>

                                        <select class="select2 form-control custom-select gender" name="gender"  id="service" style="width: 100%; height:36px;">
                                            <option></option>
                                            @foreach($genders as $gender)

                                                <option value="{{$gender['id']}}">{{$gender['name']}}</option>

                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group">

                                        <label for="regions">Region</label> <br>
                                        <select type="text" class="select2 form-control region" id="regions" name="region" style="width: 100%; height:36px;">
                                            <option></option>

                                            @foreach($regions as $region)

                                                <option value="{{$region['id']}}">{{$region['name']}}</option>

                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="form-group">

                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number">

                                    </div>



                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">

                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Middle Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">

                                    </div>
                                    <div class="form-group">

                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" name="location" id="location" placeholder="Location">

                                    </div>
                                    <div class="form-group">

                                        <label for="districts">District</label> <br>

                                        <select class="select2 form-control custom-select district" name="district_id"  id="district" style="width: 100%; height:36px;">


                                        </select>


                                    </div>

                                    <div class="form-group">

                                        <button type="submit" style="margin-top: 28px;" class="btn btn-success">Save</button>
                                        <a  href="{{url()->previous()}}" style="margin-top: 28px;" class="btn btn-info" name="edit-merchant"><i class="fa fa-backward"></i></a>

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
