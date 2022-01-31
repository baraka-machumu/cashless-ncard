
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 1px solid #cdd1d3; margin-top: 5px; height: 50px; ">

                        <h4 class="page-title" style="line-height: 50px;">Create New Merchant Aggregator</h4>

                    </div>
                </div>
            </div>
            <div class="col-md-12">

                @include('partials.error_message')
                <div class="card">
                    <form method="post" action="{{url('merchant-Aggregators/save')}}">

                        {{csrf_field()}}
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name"> Name</label>
                                        <input type="text" class="form-control" id="name"  value="{{old('name')}}" name="name" placeholder="Enter Name">

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="tin">Tin Number</label>
                                        <input type="text" class="form-control"  value="{{old('tin')}}"  name="tin" id="tin" placeholder="Agent Code">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="email">Email</label>
                                        <input type="text" class="form-control"   value="{{old('email')}}" id="email" name="email" placeholder="Email">

                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="regions">Region</label> <br>
                                        <select type="text" class="select2 form-control region" id="regions" name="region" style="width: 100%; height:36px;">
                                            <option></option>

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
                                        <input type="text" class="form-control"  value="{{old('location')}}"  name="location" id="location" placeholder="Location">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" value="{{old('phone_number')}}"  name="phone_number" id="phone_number" placeholder="Phone Number">

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
