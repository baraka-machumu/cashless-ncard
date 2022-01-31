
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span>{{mb_strtoupper(substr($agent->first_name,0,1).''.substr($agent->last_name,0,1))}}</span>
                </div>
                <h4 class="page-title">{{$agent->first_name.' '.$agent->last_name}}'s Profile</h4>
                <div class="ml-auto text-right">

                    <nav aria-label="breadcrumb">
                        {{--<button type="button"  class="btn btn-cyan btn-sm topup-agent" id="{{$agent->agent_code}}">Top up Agent</button>--}}

                        {{--<a href="{{route('topup-form',$agent->agent_code)}}" class="btn btn-success">Top up</a>--}}

                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
            @endif
        @endforeach
        <div class="col-lg-12 show-user-details-2">


            <div class="pull-left">

                <span style="text-align: start">Info</span>
            </div>

            <div class="pull-right">
                <h5  style="font-style: italic; text-align: end; font-size: 12px; margin-bottom: 50px;">
                    Available balance {{number_format($balance,1,'.',',')}}</h5>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th>First Name</th>
                        <td>{{$agent->first_name}}</td>

                    </tr>
                    <tr>
                        <th>Middle Name</th>
                        <td>{{$agent->middle_name}}</td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>{{$agent->last_name}}</td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td>{{$agent->gname}}</td>
                    </tr>
                    <tr>

                        <th>Date of Birth</th>
                        <td>{{$agent->dob}}</td>
                    </tr>

                

                    </tbody>
                </table>

                {{--button to open modal for adding pos--}}

                @can('manage-card-pos')

                    <a  class="btn btn-success" id="add-agent-pos" data-toggle="modalss" href="#add-pos-modal88"><i class="fa fa-plus-square"></i> Add pos</a>

                @endcan
                <table class="table table-striped">

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
                    @foreach($agent_pos as $pos)

                        <tr>
                            <th>#</th>
                            <th>{{$pos->imei_no}}</th>
                            <th>{{$pos->name}}</th>
                            <th>{{$pos->location}}</th>
                            <th>
                                {{--<a href="#" class="btn btn-danger disable-pos-agent" id="{{$pos->imei_no}}"><i class="fa fa-trash"></i></a>--}}

                                @if($pos->status_id==1)
                                    <a href="#" class="btn btn-danger disable-pos-agent" id="{{$pos->imei_no}}" ><i class="fa fa-trash"></i></a>

                                @elseif($pos->status_id==0)
                                    <a href="#" class="btn btn-cyan enable-pos-agent" id="{{$pos->imei_no}}" ><i class="fa fa-toggle-on"></i></a>

                                @endif
                            </th>


                        </tr>
                        <?php $i++;?>

                    @endforeach
                    </tbody>



                </table>

            </div>

            <div class="col-lg-6">


                {{--<div class="col-md-12">--}}


                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th> Agent Number</th>
                        <td>{{$agent->agent_code}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$agent->email}}</td>
                    </tr>

                    <tr>
                        <th>Region</th>
                        <td>{{$agent->rname}}</td>
                    </tr>

                    <tr>
                        <th>District</th>
                        <td>{{$agent->dname}}</td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td>{{$agent->location}}</td>
                    </tr>

                    </tbody>
                </table>
                <div class="form-group">

                    @can('agent-topup')

                        <a href="#" id="{{$agent->agent_code}}"  class="btn btn-warning topup-agent"><i class="fa fa-money-bill-alt"></i></a>

                    @endcan





                    <a  href="{{url()->previous()}}" style="margin-top: 0px;" class="btn btn-info" name="edit-merchant">Back</a>

                    @can('agent-update')

                        <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px;">

                            <p>Password and pin management</p>

                            <form method="post" action="{{url('agents/pin-reset')}}">

                                {{csrf_field()}}

                                <div class="col-md-12">
                                    <input type="hidden"  name="agent_code" value="{{$agent->agent_code}}">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter pin " name="pin" >

                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Reset pin</button>

                                    </div>
                                </div>
                            </form>

                            <form method="post" action="{{url('agents/password-reset')}}">
                                {{csrf_field()}}
                                <div class="col-md-12">
                                    <input type="hidden"  name="agent_code" value="{{$agent->agent_code}}">
                                    <div class="form-group">

                                        <input type="text"  class="form-control" placeholder="Enter password" name="password" >
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Reset password</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    @endcan
                </div>

                {{--</div>--}}


            </div>

        </div>

    </div>

    <!-- Modal -->
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
                                                    {{--<option></option>--}}



                                                </select>

                                            </div>

                                            <div class="form-group">

                                                <label for="location">Location</label>
                                                <input type="text"  class="form-control" name="location" id="add-pos-location" placeholder="Location">

                                            </div>
                                            <div class="form-group">

                                                <button type="button" id="btn-add-posto-table" class="btn btn-cyan mdi mdi-plus"></button>
                                                {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                                                <button  id="btn-form-submit-addpos"  type="submit" class="btn btn-success">Save</button>


                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <form id="add-pos-form" method="post" action="{{url('agents/add-pos-toagent')}}">
                                                {{csrf_field()}}
                                                {{--{{ method_field('POST') }}--}}
                                                <input type="hidden" value="{{$agent->agent_code}}" name="agent_code">
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


    {{--disable pos--}}

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-posagent-disable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="{{url('agents/account/disable-pos')}}">

            {{csrf_field()}}
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Pos Status  <span id="merchant-name"></span></h5>
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

                                    <p>Are you sure you want to Disable this Pos?</p>

                                </div>

                                <input type="hidden" id="pos-id-to-disable" name="imei_no">

                            </div>



                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Disable</button>
                    </div>


                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-posagent-enable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="{{url('agents/account/enable-pos')}}">

            {{csrf_field()}}
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Account Status  <span id="merchant-name"></span></h5>
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

                                    <p>Are you sure you want to Enable this Pos?</p>

                                </div>

                                <input type="hidden" id="pos-id-to-enable" name="imei_no">

                            </div>



                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Enable</button>
                    </div>


                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>

    @include('agents.topup_modal')

@stop

@section('js')

    <script>


        {{--$('#save-agent').click( function (evt) {--}}

        {{--    evt.preventDefault();--}}

        {{--    let agentCode  =  $('#agent_code');--}}
        {{--    let amount  =  $('#amount');--}}
        {{--    let reference  =  $('#reference');--}}
        {{--    console.log('save comment btn clicked');--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}


        {{--    $(".loading").css("display","block");--}}

        {{--    $.post( "{{url('agents/store-topup')}}",--}}
        {{--        {--}}

        {{--            agent_code:agentCode,--}}
        {{--            amount:amount,--}}
        {{--            reference:reference,--}}


        {{--        },--}}
        {{--        function( data ) {--}}
        {{--            $(".loading").css("display","none");--}}

        {{--            if(data.result=='01'){--}}

        {{--                $('.errors').append('<div class="alert alert-danger" role="alert">' + data.message + '</div>');--}}
        {{--                $('.alert-danger').delay(5500).fadeOut();--}}
        {{--                buttonSaveComment.prop('disabled',false);--}}

        {{--            }--}}
        {{--            else {--}}

        {{--                $('.errors').append('<div class="alert alert-success" role="alert">' + data.message + '</div>');--}}

        {{--                window.setTimeout(hide_modal, 5500);--}}

        {{--                $(location).attr('href', url);--}}
        {{--            }--}}

        {{--            // window.location--}}
        {{--            console.log(data);--}}
        {{--            $('.alert-success').delay(4500).fadeOut();--}}

        {{--        },"json").fail(function (data) {--}}

        {{--        $(".loading").css("display","none");--}}

        {{--        $('.errors').append('<div class="alert alert-danger" role="alert">Server Error, could not connect [500]</div>');--}}
        {{--        $('.alert-danger').delay(5500).fadeOut();--}}
        {{--        buttonSaveComment.prop('disabled',false);--}}


        {{--    });--}}
        {{--});--}}


    </script>
@stop
