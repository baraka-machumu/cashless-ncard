
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Consumers</h4>
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

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="consumer">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Telephone</th>
                        <th>Registration Source</th>
                        <th>Wallet Id</th>
                        <th>Card Number</th>

                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php  $i = 1;?>
                    @foreach($consumers as $consumer)
                    <tr>

                        <td>{{$i}}</td>
                        <td>{{$consumer->first_name}}</td>
                        <td>{{$consumer->last_name}}</td>
                        <td>{{$consumer->phone_number}}</td>
                        <td>
                            @if($consumer->agent_code==null)
                                <span style="color:#0b94db; "> {{'Self Registration'}}</span>
                            @else
                                {{$consumer->agent_code}}
                            @endif
                        </td>
                        <td>{{$consumer->wallet_id}}</td>
                        <input type="hidden" value="{{$consumer->first_name.' '.$consumer->last_name}}" id="{{'c-'.$consumer->wallet_id}}">
                        <td>
                            @if($consumer->card_number==null)
                                <span style="color:#db5c13; "> {{'No Card Assigned'}}</span>
                                @else
                                {{$consumer->card_number}}
                                @endif
                        </td>

                        <td>
                            {{--<a href="{{url('merchants/edit')}}" class="btn btn-success"><i class="fa fa-edit"></i></a>--}}
                            @if($consumer->status_id==1)
                                <a href="#" class="btn btn-danger disable-consumer" id="{{$consumer->wallet_id}}" ><i class="fa fa-trash"></i></a>

                            @elseif($consumer->status_id==0)
                                <a href="#" class="btn btn-cyan enable-consumer" id="{{$consumer->wallet_id}}" ><i class="fa fa-toggle-on"></i></a>

                            @endif
                            <a href="{{route('consumers.show',$consumer->wallet_id)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            {{--<a href="{{url('merchants/users')}}" class="btn btn-info"><i class="fa fa-users"></i></a>--}}

                        </td>

                    </tr>

                    <?php  $i++;?>

                    @endforeach




                    </tbody>
                </table>

            </div>

        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="create-merchant-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="#">

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Create Merchant</h5>
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
                                                <div class="form-group">

                                                    <label for="fname">Merchant Name</label>
                                                    <input type="text" class="form-control" id="fname" placeholder="Merchant Name">

                                                </div>

                                                <div class="form-group">

                                                    <label for="telephone_number">Telephone Number</label>
                                                    <input type="text" class="form-control" id="telephone_number" placeholder="Telephone Number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="region">Region</label>
                                                    <input type="text" class="form-control" id="region" placeholder="Region">

                                                </div>

                                                <div class="form-group">

                                                    <label for="location">Location</label>
                                                    <input type="text" class="form-control" id="location" placeholder="Location">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="registration_number">Registration Number</label>
                                                    <input type="text" class="form-control" id="registration_number" placeholder="Registration Number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="email">Email</label>
                                                    <input type="text" class="form-control" id="email" placeholder="Email">

                                                </div>

                                                <div class="form-group">

                                                    <label for="district">District</label>
                                                    <input type="text" class="form-control" id="district" placeholder="District">

                                                </div>

                                                {{--<div class="form-group">--}}

                                                    {{--<button type="submit" style="margin-top: 28px;" class="btn btn-success" name="edit-merchant">Update</button>--}}
                                                {{--</div>--}}

                                            </div>

                                        </div>

                                    </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
        </form>

    </div>


    {{--MODEL EDIT--}}

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-consumer-disable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="{{url('consumers/account/disable')}}">

            {{csrf_field()}}
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Account Status for <span id="consumer-name-disable" style="font-size: 12px; margin-left: 4px;"></span></h5>
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

                                    <p>Are you sure you want to disable this consumer?</p>

                                </div>

                                <input type="hidden" id="consumer-id-to-disable" name="consumer_wallet">

                            </div>

                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Diasble</button>
                    </div>

                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-consumer-enable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="{{url('consumers/account/enable')}}">

            {{csrf_field()}}
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Account Status  <span id="consumer-name"></span></h5>
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

                                    <p>Are you sure you want to Enable this consumer?</p>

                                </div>

                                <input type="hidden" id="consumer-id-to-enable" name="consumer_wallet">

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


@stop

@section('js')

    <script>

        $('#consumer').dataTable();

    </script>

    @stop
