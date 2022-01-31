




@extends('layouts.master')



@section('content')


    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
    <div class="card">
        <form class="row" method="post" action="{{url('aggregators/users/store')}}">

            {{csrf_field()}}

        <div class="card-body">

            <div class="row">

                    <div class="col-md-6">

                        <input type="hidden" name="agent_code" value="{{$agent_code}}" >
                        <div class="form-group">

                            <label for="mname">Full Name</label>
                            <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required"  class="form-control" id="mname" name="fullname" >

                        </div>

                        <div class="form-group">

                            <label for="telephone_number">Telephone Number</label>
                            <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="phone_number" id="telephone_number">

                        </div>


                    </div>
                    <div class="col-md-6">
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

                        <button type="button" class="btn btn-info" d>Back</button>
                        <button type="submit" class="btn btn-success">Save</button>


                    </div>

            </div>


        </div>

        </form>
    </div>
            </div>
        </div>
    </div>

@endsection
