
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach
            </div>

            <div class="col-md-12 h4-background">
                <h4>Assign Pos to <span>{{' '.$fullname}}</span></h4>

            </div>
            <div class="col-md-12">


                <div class="card">
                    <form method="post" action="{{url('agents/pos/store',$agent_code)}}">

                        {{csrf_field()}}
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="service">Select Pos</label> <br>

                                        <select class="form-control custom-select pos" name="imei_no"  id="pos" style="width: 100%; height:36px;">
                                            <option></option>
                                            @foreach($pos as $po)

                                                <option value="{{$po['imei_no']}}">{{$po['imei_no']}}</option>

                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="form-group">

                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" name="location" id="location" placeholder="Location">

                                    </div>

                                    <div class="form-group">

                                        <button type="submit" style="margin-top: 28px;" class="btn btn-success">Save</button>
                                        <a  href="{{url()->previous()}}" style="margin-top: 28px;" class="btn btn-info disabled" name="edit-merchant"><i class="fa fa-backward"></i></a>

                                    </div>


                                </div>
                                <div class="col-md-5">

                                </div>

                            </div>

                        </div>
                    </form>
                </div>


            </div>
        </div>

    </div>


@stop