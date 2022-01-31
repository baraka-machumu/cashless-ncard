
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span>{{mb_strtoupper(substr($merchant->name,0,1))}}</span>
                </div>
                <h4 class="page-title">{{$merchant->name}}'s Profile</h4>
                <div class="ml-auto text-right">

                    <nav aria-label="breadcrumb">
                        <input type="hidden" value="{{$merchant->name}}" id="merchant-name">

                        <input type="hidden" id="merchant-type" value="{{$merchant->merchant_type}}">

                        @if($merchant->status_id===1)
                            <a href="#" class="btn btn-warning disable-merchant"  id="{{$merchant->tin}}">Deactivate </a>

                        @else
                            <a href="#" class="btn btn-info enable-merchant"  id="{{$merchant->tin}}">Activate </a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{--<div class="col-md-12">--}}
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
            @endif
        @endforeach
        {{--</div>--}}

        <div class="col-lg-12 show-user-details-2">


            <div class="pull-left">

                <span style="text-align: start">Info</span>
            </div>

            <div class="pull-right">
                <h5  style="font-style: italic; text-align: end; font-size: 10px; margin-bottom: 40px;"> Total money earned </h5>


            </div>

        </div>

        <div class="row">


            <div class="col-md-6">

                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th>Merchant Name</th>
                        <td>{{$merchant->name}}</td>

                    </tr>

                    <tr>
                        <th>Merchant Tin</th>
                        <td>{{$merchant->tin}}</td>
                    </tr>
                    <tr>
                        <th>Merchant Account Number</th>
                        <td>
                            <form action="{{url('merchants/update-account')}}" method="post">

                                @csrf

                                <input type="text" class="form-control" name="accountNo" value="{{$merchant->account_number}}" id="accountNo" style="margin-bottom: 10px;">

                                <input type="hidden" name="tin" value="{{$merchant->tin}}">

                                <button class="btn btn-primary" id="edit-acc" type="button"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger" id="edit-close" type="button"><i class="fa fa-window-close"></i></button>

                                <button class="btn btn-secondary" type="submit" id="update-acc">Update</button>
                            </form>


                        </td>
                    </tr>
                    <tr>
                        <th>Merchant Phone Number</th>
                        <td>{{$merchant->phone_number}}</td>
                    </tr>
                    <tr>
                        <th>Merchant Type</th>

                        <td>{{$merchant->merchant_type}}</td>
                    </tr>

                    </tbody>
                </table>

                {{--button to open modal for adding pos--}}
                <a  class="btn btn-success" id="add-agent-pos" data-toggle="modalss" href="#add-pos-modal88"><i class="fa fa-plus-square"></i> Pos</a>
                <a  class="btn btn-info  pull-right"  href="{{url('merchants/users',$merchant->tin)}}"><i class="fa fa-plus-square"></i>Syetem  Users</a>

                <table class="table table-striped" id="pos-merchant">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Pos Number</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Actions</th>


                    </tr>
                    </thead>

                    <tbody>

                    <?php $i=1;?>
                    @foreach($merchant_pos as $pos)

                        <tr>
                            <th>#</th>
                            <th>{{$pos->imei_no}}</th>
                            <th>{{$pos->name}}</th>
                            <th>{{$pos->location}}</th>
                            <th>
                                {{--                                <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>--}}
                                <a href="#" class="btn btn-success add-merchant-agent-user-btn" id="{{$pos->imei_no}}" ><i class="fa fa-user-plus"></i></a>
                                <a href="{{url("merchants/agent",['imei_no'=>$pos->imei_no])}}" class="btn btn-success" id="{{$pos->imei_no}}" ><i class="fa fa-eye"></i></a>

                            </th>


                        </tr>
                        <?php $i++;?>

                    @endforeach
                    </tbody>



                </table>

            </div>

            <div class="col-md-6">

                <table class="table table-striped  dataTable">

                    <tbody>


                    <tr>
                        <th>Email</th>
                        <td>{{$merchant->email}}</td>
                    </tr>

                    <tr>
                        <th>Region</th>
                        <td>{{$merchant->rname}}</td>
                    </tr>

                    <tr>
                        <th>District</th>
                        <td>{{$merchant->dname}}</td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td>{{$merchant->location}}</td>
                    </tr>

                    <tr style="background-color:#1C729E;">
                        <td colspan="2" style="color: white;">Commission</td>
                    </tr>

                    @if(!$commission)
                    <tr>

                        <td>No Commission Set</td>

                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#merchant-commission-modal">Set commission</button>
                        </td>
                    </tr>

                    @endif

                    @if($commission)
                        <tr>

                            <th>Commission Percentage</th> <td>{{$commission->percentage}}</td>
                        </tr>

                    @endif

                    </tbody>
                </table>


                {{--button to open modal for adding pos--}}
                <a  class="btn btn-success" id="add-merchant-service-btn" data-toggle="modalss" href="#add-pos-modal88"><i class="fa fa-plus-square"></i> Service</a>

                <table class="table table-striped">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i=1;?>
                    @foreach($merchantServices as $row)


                        <tr>
                            <th>#</th>
                            <th>{{$row->name}}</th>
                            {{--                            <th>{{  $merchantService->price ?? 'No price specified' }}</th>--}}

                            <th>
                                <a href="{{route('merchant-products',[$merchant->tin,$row->id])}}" class="btn btn-success">products <i class="fa fa-plus"></i></a>

                                <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>

                            </th>


                        </tr>
                        <?php $i++;?>

                    @endforeach
                    </tbody>


                </table>

            </div>

        </div>

    </div>


    {{--    modal for adding merchant pos agent users--}}

    @include('merchants.add_posmerchant_agent_user')
    @include('merchants.add_merchant_services')

    <!-- Modal for adding pos-->
    <div class="modal fade bd-example-modal-lg" id="add-pos-modal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header h4-background">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Pos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-body">

                                    <div class="row">


                                        <div class="col-md-6">

                                            <div class="form-group" id="s">

                                                <label for="service" id="add-label-warning">Select Pos </label> <br>

                                                <select class="form-control custom-select pos" name="imei_no"  id="add-pos-imei" style="width: 100%; height:36px;">
                                                    <option></option>

                                                </select>

                                            </div>

                                            <div class="form-group ifis-udart">

                                                <label for="mregion">Region</label> <br>
                                                <select type="text" data-validation="required" data-validation-error-msg-required="Merchant name required"  class="select2 form-control region" id="mregions" name="region" style="width: 100%; height:36px;">
                                                    <option></option>

                                                    @foreach($regions as $region)

                                                        <option value="{{$region['id']}}">{{$region['name']}}</option>

                                                    @endforeach

                                                </select>

                                            </div>
                                            <div class="form-group ifis-udart" >

                                                <label for="district">District</label> <br>

                                                <select  data-validation="required" data-validation-error-msg-required="Merchant name required" class="select2 form-control custom-select district" name="district"  id="mdistricts" style="width: 100%; height:36px;">


                                                </select>


                                            </div>


                                            <div class="form-group">

                                                <div class="form-group" >

                                                    <label for="add-pos-location">Location</label> <br>

                                                    <input type="text"  data-validation="required" data-validation-error-msg-required="location name required" class=" form-control" name="location"  id="add-pos-location" style="width: 100%; height:36px;">
                                                    {{--                                                        @foreach($stations as $station)--}}

                                                    {{--                                                            <option></option>--}}
                                                    {{--                                                            <option value="{{$station->id}}">{{$station->station_name}}</option>--}}

                                                    {{--                                                        @endforeach--}}

                                                    {{--                                                    </select>--}}

                                                </div>

                                            </div>
                                            <div class="form-group">

                                                <button type="button" id="btn-add-posto-table" class="btn btn-cyan mdi mdi-plus"></button>
                                                {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                                                <button  id="btn-form-submit-addpos"  type="submit" class="btn btn-success">Save</button>

                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <form id="add-pos-form" method="post" action="{{url('merchants/add-pos-tomerchant')}}">
                                                {{csrf_field()}}
                                                {{--{{ method_field('POST') }}--}}
                                                <input type="hidden" value="{{$merchant->tin}}" name="tin">
                                                <label class="err-warning-table"></label>

                                                <table id="table-pos-added"   class="table table-striped" style="margin-top: 10px;">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Pos Number</th>
                                                        <th>Location</th>
                                                        <th>Action</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody id="add-pos-tr">

                                                    </tbody>
                                                </table>


                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    {{--MODEL EDIT--}}

    @include('merchants.enable_modal')
    <!-- Modal -->

    {{--disable p--}}

    @include('merchants.disable_modal')
    @include('merchants.commission_modal')

@stop

@section('js')

    <script>

        $(function () {

            let editBtn  = $('#edit-acc');

            $('#accountNo').prop('disabled',true)

            editBtn.show();

            $('#update-acc').hide();

            let closeBtn  =  $('#edit-close')

            closeBtn.hide()

            editBtn.click( function (){

                editBtn.hide();
                closeBtn.show();

                $('#accountNo').prop('disabled',false)
                $('#update-acc').show();

            });


            closeBtn.click( function (){

                editBtn.show();
                $('#edit-close').hide();

                $('#accountNo').prop('disabled',true)
                $('#update-acc').hide();

            });

            $('#pos-merchant').dataTable();

        })

z


    </script>
@stop
