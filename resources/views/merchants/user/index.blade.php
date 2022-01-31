
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Merchant  Users</h4>
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

                <div class="col-md-3">

                    <a href="#" class="btn btn-cyan btn-sm" id="previous" data-toggle="modal" data-target="#create-merchant-user-modal">New Merchant User</a>
                    {{--                    <button type="button" data-toggle="modal" data-target="#create-merchant-modal" class="btn btn-cyan btn-sm" id="previous">New Merchant</button>--}}

                </div>

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="merchant-index">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        {{--                        <th>Actions</th>--}}

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i=1; $clickedID='';?>
                    @foreach($users as $row)
                        <tr>

                            <td>{{$i}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->phone_number}}</td>
                            <td>{{$row->email}}</td>



                        </tr>
                        <?php $i++;?>

                    @endforeach


                    </tbody>
                </table>

            </div>

        </div>

    </div>


    <!-- Modal create -->
    <div class="modal fade bd-example-modal-lg" id="create-merchant-user-modal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="{{route('merchants.store.user',$tin)}}" enctype="multipart/form-data" id="form-create-merchant-modal">


            {{csrf_field()}}

            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Create Merchant User</h5>
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

                                                    <label for="mname">Full Name</label>
                                                    <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required"  class="form-control" id="mname" name="fullname" >

                                                </div>

                                                <div class="form-group">

                                                    <label for="telephone_number">Telephone Number</label>
                                                    <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="phone_number" id="telephone_number">

                                                </div>


                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">

                                                    <label for="password">Password</label>
                                                    <input type="text" required data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="password" id="tin" >

                                                </div>

                                                <div class="form-group">

                                                    <label for="email">Email</label>
                                                    <input type="email" required data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" id="email" name="email" >

                                                </div>

                                            </div>

                                            <div class="form-group" style="margin-top: 50px;">

                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Save</button>


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
        </form>

    </div>


    <!-- Modal Edit-->



    @include('merchants.disable_modal')
    @include('merchants.enable_modal')
    @include('merchants.view_merchant_modal')



@stop



@section('js')

    <script>
        $('#merchant-index').dataTable();

    </script>


@stop
