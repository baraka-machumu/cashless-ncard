

@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Agent</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Merchant</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach

                {{--<div class="col-md-3">--}}

                <a href="{{url('agents/create')}}" class="btn btn-cyan btn-sm" id="previous">New Agent</a>

                <hr/>

                <form class="row" method="post" action="{{url('agents/get-by-phonenumber')}}">

                    {{csrf_field()}}

                    <div class="col-md-8">
                        <input type="text" name="phone_number" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-info btn-block">Search by phone number</button>
                    </div>
                </form>

                <hr/>

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="agents-all">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Agent Code</th>
                        <th>Pos</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php $i=1;?>
                    @foreach($agents as $agent)
                        <tr>

                            <td>{{$i}}</td>
                            <td>{{$agent->first_name.' '.$agent->last_name}}</td>
                            <td>{{$agent->agent_code}}</td>
                            <td>{{$agent->imei_no}}</td>
                            <td>{{$agent->phone_number}}</td>
                            <td>{{$agent->email}}</td>
                            <td>{{$agent->sname}}</td>

                            <td style="width: 250px;">
                                <a href="#" id="{{$agent->agent_code}}"  data-id="{{ $agent->agent_code}}" class="btn btn-success edit-agent-modal"><i class="fa fa-edit"></i></a>

                                @if($agent->status_id==1)
                                    <a href="#" class="btn btn-danger disable-agent" id="{{$agent->agent_code}}" ><i class="fa fa-trash"></i></a>

                                @elseif($agent->status_id==0)
                                    <a href="#" class="btn btn-cyan enable-agent" id="{{$agent->agent_code}}" ><i class="fa fa-toggle-on"></i></a>

                                @endif
                                <a href="{{url('agents/roles',$agent->agent_code)}}" id="{{ $agent->agent_code}}"   class="btn btn-warning"><i class="fa fa-bars"></i></a>

                                <a href="{{url('agents',$agent->agent_code)}}" class="btn btn-info"><i class="fa fa-users"></i></a>

                            </td>

                        </tr>
                        <?php $i++;?>

                    @endforeach


                    </tbody>
                </table>

            </div>

        </div>

    </div>


    {{--MODEL EDIT--}}

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-agent-disable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="{{url('agents/account/disable')}}">

            {{csrf_field()}}
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Account Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{--<div class="col-md-12 show-user-details" style="margin-bottom: 10px;">--}}

                        {{--<span>Details for Baraka toe</span>--}}

                        {{--</div>--}}
                        <div class="row">


                            <div class="col-lg-12">

                                <div class="alert alert-warning">

                                    <p>Are you sure you want to disable this agent?</p>

                                </div>

                                <input type="hidden" id="agent-id-to-disable" name="agent_code">

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Disable</button>

                    </div>
                </div>
            </div>
        </form>

    </div>


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-agent-enable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="{{url('agents/account/enable')}}">

            {{csrf_field()}}
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Account Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{--<div class="col-md-12 show-user-details" style="margin-bottom: 10px;">--}}

                        {{--<span>Details for Baraka toe</span>--}}

                        {{--</div>--}}
                        <div class="row">


                            <div class="col-lg-12">

                                <div class="alert alert-warning">

                                    <p class="text-center">Are you sure you want to Enable this agent?</p>

                                </div>

                                <input type="hidden" id="agent-id-to-enable" name="agent_code">

                            </div>



                        </div>

                    </div>


                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Enable</button>
                    </div>
                </div>
            </div>
        </form>

    </div>



    {{--MODEL create agent--}}

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-create-agent-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="{{route('agents.store')}}">

            {{csrf_field()}}
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-headagents.shower modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Create Agent</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{--<div class="col-md-12 show-user-details" style="margin-bottom: 10px;">--}}

                        {{--<span>Details for Baraka toe</span>--}}

                        {{--</div>--}}
                        <div class="row">


                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="middle_name">Agent Code</label>
                                    <input type="text" class="form-control"  required name="agent_code" id="agent_code" placeholder="Agent Code">

                                </div>
                                <div class="form-group">
                                    <label for="mname">First Name</label>
                                    <input type="text" data-validation="required" data-validation-error-msg-required="No first name provided"  class="form-control" id="first_name" name="first_name" placeholder="First Name">

                                </div>

                                <div class="form-group">

                                    <label for="last_name">Last Name</label>
                                    <input type="text" data-validation="required" data-validation-error-msg-required="No last name provided"  required class="form-control" name="last_name" id="last_name" placeholder="Last Name">

                                </div>

                                <div class="form-group">

                                    <label for="service">Gender</label> <br>

                                    <select data-validation="required" data-validation-error-msg-required="No gender provided"  class="select2 form-control custom-select gender" name="gender" required  id="service" style="width: 100%; height:36px;">
                                        <option></option>
                                        @foreach($genders as $gender)

                                            <option value="{{$gender['id']}}">{{$gender['name']}}</option>

                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">

                                    <label for="regions">Region</label> <br>
                                    <select data-validation="required" data-validation-error-msg-required="No region provided"  type="text" class="select2 form-control region" id="regions"  required name="region" style="width: 100%; height:36px;">
                                        <option></option>

                                        @foreach($regions as $region)

                                            <option value="{{$region['id']}}">{{$region['name']}}</option>

                                        @endforeach

                                    </select>

                                </div>





                            </div>
                            <div class="col-md-5">
                                <div class="form-group">

                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" data-validation="required" data-validation-error-msg-required="No middle name provided"  class="form-control" name="middle_name" id="middle_name" placeholder="Middle Name">

                                </div>

                                <div class="form-group">

                                    <label for="email">Email</label>
                                    <input type="text" data-validation="required" data-validation-error-msg-required="No email provided"  class="form-control" id="email" name="email" placeholder="Email">

                                </div>
                                <div class="form-group">

                                    <label for="location">Location</label>
                                    <input type="text" required data-validation="required" data-validation-error-msg-required="No location provided"  class="form-control" name="location" id="location" placeholder="Location">

                                </div>
                                <div class="form-group">

                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" required data-validation="required" data-validation-error-msg-required="No phone number provided"  class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number">

                                </div>
                                <div class="form-group">

                                    <label for="districts">District</label> <br>

                                    <select required  data-validation="required" data-validation-error-msg-required="No district provided"  class="select2 form-control custom-select district" name="district_id"  id="district" style="width: 100%; height:36px;">


                                    </select>


                                </div>
                                <div class="form-group">

                                    <label for="phone_number">Pin (put only four digit)</label>
                                    <input type="text" required data-validation="required" data-validation-error-msg-required="No phone number provided"  class="form-control" name="pin" id="phone_number" placeholder=pin>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">save</button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    @include('agents.edit_agent_modal')

@stop


@section('js')

    <script>
        $('#agents-all').dataTable();

    </script>


@stop
