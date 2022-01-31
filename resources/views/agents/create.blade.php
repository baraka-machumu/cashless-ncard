
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px; height: 50px; ">
                    <h4 class="page-title" style="line-height: 50px;">Create Agent</h4>

                </div>
            </div>
            <div class="col-md-12">

                @include('partials.error_message')
                <div class="card">
                    <form method="post" action="{{route('agents.store')}}">

                        {{csrf_field()}}
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mname">First Name</label>
                                        <input type="text" class="form-control" pattern="[A-Za-z]*"  required id="first_name"  value="{{old('first_name')}}" name="first_name" placeholder="First Name">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" pattern="[A-Za-z]*"  value="{{old('middle_name')}}"  name="middle_name" id="middle_name" placeholder="Middle Name">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" pattern="[A-Za-z]*"  required value="{{old('last_name')}}"  name="last_name" id="last_name" placeholder="Last Name">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="middle_name">Agent Code</label>
                                        <input type="text" class="form-control" required  value="{{old('agent_code')}}"  name="agent_code" id="agent_code" placeholder="Agent Code">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="email">Email</label>
                                        <input type="text" class="form-control"  required  value="{{old('email')}}" id="email" name="email" placeholder="Email">

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="email">Pin</label>
                                        <input type="text" class="form-control"  required  value="{{old('pin')}}" id="email" name="pin" placeholder="Pin">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="regions">Region</label> <br>
                                        <select type="text" class="select2 form-control region" required id="regions" name="region" style="width: 100%; height:36px;">
                                            <option value="" selected disabled>--select region  ---</option>

                                            @foreach($regions as $region)

                                                <option value="{{$region['id']}}">{{$region['name']}}</option>

                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="districts">District</label> <br>

                                        <select class="select2 form-control custom-select district" name="district_id"  id="district" style="width: 100%; height:36px;">


                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" required pattern="[A-Za-z]*"  value="{{old('location')}}"  name="location" id="location" placeholder="Location">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="service">Gender</label> <br>

                                        <select class="select2 form-control custom-select gender" required name="gender"  id="service" style="width: 100%; height:36px;">
                                            <option value="" selected disabled>--select gender --</option>
                                            @foreach($genders as $gender)

                                                <option value="{{$gender['id']}}">{{$gender['name']}}</option>

                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" value="{{old('phone_number')}}"  required name="phone_number" id="phone_number" placeholder="Phone Number">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="phone_number">Top Up Source</label>
                                        <select type="text" class="form-control"  name="top_up_source" id="top_up_source" >

                                            <option value="" selected disabled>--select source--</option>
                                            @foreach($top_source as $row)

                                                <option value="{{$row->code}}">{{$row->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12 form-group text-right">
                                    <hr/>
                                    <a  href="{{url('agents')}}" class="btn btn-info">Back</a>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>


            </div>
        </div>

    </div>


@stop
