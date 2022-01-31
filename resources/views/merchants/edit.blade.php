
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12 h4-background">
                <h4>Edit {{$merchants->name}} Merchant</h4>

            </div>
            <div class="col-md-12">

                <div class="card">
                    <form method="post" action="{{route('merchants.update',$merchants->tin)}}">

                        {{csrf_field()}}
                        @method('PUT')
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="mname">Merchant Name</label>
                                        <input type="text" class="form-control" id="mname" value="{{$merchants->name}}" name="name" placeholder="Merchant Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="telephone_number">Telephone Number</label>
                                        <input type="text" class="form-control" value="{{$merchants->phone_number}}" name="telephone" id="telephone_number" placeholder="Telephone Number">

                                    </div>

                                    <div class="form-group">

                                        <label for="mregion">Region</label> <br>
                                        <select type="text" class="select2 form-control region" id="mregion" name="region" style="width: 100%; height:36px;">
                                            <option></option>

                                            @foreach($regions as $region)


                                                <option value="{{$region['id']}}"  {{$region['id']==$region_id ? 'selected' : ''}} >{{$region['name']}}</option>

                                            @endforeach

                                        </select>

                                    </div>
                                    <div class="form-group">

                                        <label for="district">District</label> <br>

                                        <select class="select2 form-control custom-select district" name="district"  id="mdistrict" style="width: 100%; height:36px;">

                                            @foreach($districts as $district)


                                                <option value="{{$district['id']}}"  {{$district['id']==$merchants->district_id ? 'selected' : ''}} >{{$district['name']}}</option>

                                            @endforeach

                                        </select>


                                    </div>

                                    <div class="form-group">

                                        <label for="mbank">Bank Name</label> <br>

                                        <select class="select2 form-control custom-select district" name="bank"  id="mbank" style="width: 100%; height:36px;">
                                            <option></option>
                                            @foreach($banks as $bank)

                                                <option value="{{$bank['id']}}" {{$bank['id']==$bank_id ? 'selected' : ''}}>{{$bank['name']}}</option>

                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="form-group">

                                        <label for="service">Service Name</label> <br>

                                        <select class="select2 form-control custom-select service" name="service"  id="service" style="width: 100%; height:36px;">
                                            <option></option>
                                            @foreach($services as $service)

                                                <option value="{{$service['id']}}" {{$service['id']==$merchants->service_id ? 'selected' : ''}}>{{$service['name']}}</option>

                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">

                                        <label for="mtin">Tin Number</label>
                                        <input type="text" class="form-control" value="{{$merchants->tin}}" name="tin" id="tin" placeholder="Registration Number">

                                    </div>

                                    <div class="form-group">

                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" value="{{$merchants->email}}" id="email" name="email" placeholder="Email">

                                    </div>
                                    <div class="form-group">

                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" value="{{$merchants->location}}" name="location" id="location" placeholder="Location">

                                    </div>
                                    <div class="form-group">

                                        <label for="maccount">Account</label>
                                        <input type="text" class="form-control" value="{{$merchants->account_number}}"  name="account" id="account" placeholder="Account">

                                    </div>

                                    <div class="form-group">

                                        <label for="mbranch-name">Bank Branch Name</label> <br>

                                        <select class="select2 form-control custom-select mbranch-name" name="branch"  id="mbranch" style="width: 100%; height:36px;">
                                            @foreach($bank_branches as $branch)

                                                <option value="{{$branch['id']}}" {{$branch['id']==$merchants->branch_id ? 'selected' : ''}}>{{$branch['name']}}</option>

                                            @endforeach
                                        </select>


                                    </div>
                                    <div class="form-group">

                                        <button type="submit" style="margin-top: 28px;" class="btn btn-success">Update</button>
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
