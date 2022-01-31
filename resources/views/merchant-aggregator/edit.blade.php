
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="col-md-12">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                @endif
            @endforeach
        </div>
        <div class="col-lg-12 show-user-details-2">


            <div class="pull-left">

                <span style="text-align: start">Edit Agent Info</span>
            </div>

            <div class="pull-right">


            </div>

        </div>

        <div class="row">

            <div class="col-md-12">


                <div class="card">
                    <form method="post" action="{{route('agents.update',$agent->agent_code)}}">

                        {{csrf_field()}}
                        @method('PUT')

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="mname">First Name</label>
                                        <input type="text" data-validation="required" data-validation-error-msg-required="First name can not be empty"  class="form-control" id="first_name" value="{{$agent->first_name}}" name="first_name" placeholder="First Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="last_name">Last Name</label>
                                        <input type="text" data-validation="required" data-validation-error-msg-required="Last name can not be empty"  class="form-control" value="{{$agent->last_name}}" name="last_name" id="last_name" placeholder="Last Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="service">Gender</label> <br>

                                        <select  data-validation="required" data-validation-error-msg-required="Gender can not be empty" class="select2 form-control custom-select gender" name="gender"  id="service" style="width: 100%; height:36px;">
                                            <option></option>
                                            @foreach($genders as $gender)

                                                <option value="{{$gender['id']}}" {{$gender['id']==$agent->gender_id ? 'selected' : ''}}>{{$gender['name']}}</option>

                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group">

                                        <label for="regions">Region</label> <br>
                                        <select data-validation="required" data-validation-error-msg-required="Region can not be empty" class="select2 form-control region" id="regions" name="region" style="width: 100%; height:36px;">
                                            <option></option>

                                            @foreach($regions as $region)

                                                <option value="{{$region['id']}}" {{$region['id']==$region_id ? 'selected' : ''}}>{{$region['name']}}</option>

                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="form-group">

                                        <label for="phone_number">Phone Number</label>
                                        <input data-validation="required" data-validation-error-msg-required="Phone number can not be empty" type="text" class="form-control" value="{{$agent->phone_number}}" name="phone_number" id="phone_number" placeholder="Phone Number">

                                    </div>



                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">

                                        <label for="middle_name">Middle Name</label>
                                        <input data-validation="required" data-validation-error-msg-required="Middle name can not be empty" type="text" class="form-control" value="{{$agent->middle_name}}" name="middle_name" id="middle_name" placeholder="Middle Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="email">Email</label>
                                        <input data-validation="email" data-validation-error-msg-required="Email can not be empty" type="text" class="form-control" value="{{$agent->email}}" id="email" name="email" placeholder="Email">

                                    </div>
                                    <div class="form-group">

                                        <label for="location">Location</label>
                                        <input data-validation="required" data-validation-error-msg-required="Location can not be empty" type="text" class="form-control" value="{{$agent->location}}" name="location" id="location" placeholder="Location">

                                    </div>
                                    <div class="form-group">

                                        <label for="districts">District</label> <br>

                                        <select data-validation="required" data-validation-error-msg-required="District can not be empty" class="select2 form-control custom-select district" name="district_id"  id="district" style="width: 100%; height:36px;">

                                            <option></option>

                                            @foreach($districts as $district)

                                                <option value="{{$district['id']}}" {{$district['id']==$agent->district_id ? 'selected' : ''}}>{{$district['name']}}</option>

                                            @endforeach

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