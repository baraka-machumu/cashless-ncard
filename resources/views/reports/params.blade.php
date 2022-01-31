
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="col-lg-12 show-user-details-2">

            <span>Supply parameter to get report</span>

        </div>
        <div class="row">

            <div class="col-md-12">


                <form  action="{{url('reports/consumer-report',$report_id)}}" method="post">
                    {{csrf_field()}}

                    <div class="col-md-4">
                    @foreach($params as $param)

                        <div class="form-group">

                            <label for="{{$param->name}}">{{$param->description}}</label>
                            <input type="text" class="form-control" name="params[{{$param->name}}]" id="{{$param->name}}">

                        </div>

                    @endforeach

                        <div class="form-group">

                            <button type="submit" class="btn btn-success">Get Report</button>


                        </div>

                        <a href="{{url()->previous()}}" class="btn btn-info"><i class="fa fa-backward"></i></a>

                    </div>


                </form>


            </div>

        </div>

    </div>
@stop

