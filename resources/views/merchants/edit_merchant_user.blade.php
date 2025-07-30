
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <div class="user-details-round-icon">
                        <span>{{mb_strtoupper(substr('Edit Merchant User',0,1))}}</span>
                    </div>
                    <h4 class="page-title">Edit Merchant User</h4>

                </div>
            </div>
        </div>


            <form action="{{url('merchant/update-user',$id)}}" method="post">

                {{csrf_field()}}

                <div class="row">

                    <div class="col-md-12">

                        <div class="form-group" id="s">

                            <label for="merchant-agent-fname" >First Name </label> <br>

                            <input type="text" name="first_name" value="{{$merchantAgent->first_name}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12">

                        <div class="form-group" id="s">

                            <label for="merchant-agent-lname" >Last Name </label> <br>

                            <input type="text" name="last_name"  value="{{$merchantAgent->last_name}}" class="form-control" required>

                        </div>

                    </div>
                    <div class="col-md-12">


                        <div class="form-group" id="s">

                            <label for="merchant-agent-phone_number" >Phone number </label> <br>

                            <input type="text" name="phone_number"  value="{{$merchantAgent->phone_number}}"  required class="form-control">

                        </div>
                    </div>

                    <div class="form-group">

                        <div>
                            <button class="btn btn-info btn-sm" style="margin-left: 15px;">Save</button>
                        </div>

                    </div>


                </div>
            </form>

    </div>


@stop
