
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12 h4-background">
                <h4>Edit Merchant</h4>

            </div>
            <div class="col-md-12">


                <div class="card">

                        {{csrf_field()}}

                        <div class="row">


                         <form action="{{url('merchant.users.update')}}" method="post">

                             {{csrf_field()}}
                             <div class="col-md-12">

                                 <div class="form-group" id="s">

                                     <label for="merchant-agent-fname" >First Name </label> <br>

                                     <input type="text" name="first_name" value="{{$merchantAgent->first_name}}" class="form-control" required>
                                 </div>

                                 <div class="form-group" id="s">

                                     <label for="merchant-agent-lname" >Last Name </label> <br>

                                     <input type="text" name="last_name"  value="{{$merchantAgent->last_name}}" class="form-control" required>

                                 </div>

                                 {{--                                        <div class="form-group" id="s">--}}

                                 {{--                                            <label for="merchant-agent-email" >Email </label> <br>--}}

                                 {{--                                            <input type="text" name="email[]"  value="{{$$merchantAgent->email}}" class="form-control">--}}
                                 {{--                                        </div>--}}

                                 <div class="form-group" id="s">


                                     <label for="merchant-agent-phone_number" >Phone number </label> <br>

                                     <input type="text" name="phone_number"  value="{{$merchantAgent->phone_number}}"  required class="form-control">

                                 </div>

                                 <div class="form-group">

                                     <div>

                                         <button class="btn btn-info btn-sm">Save</button>
                                     </div>

                                 </div>


                             </div>

                         </form>

                        </div>

                    </form>
                </div>


            </div>
        </div>

    </div>


@stop
