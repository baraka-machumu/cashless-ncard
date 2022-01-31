
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">


            <div class="col-md-12">

                <div class="col-md-6">


                    <div class="col-md-12" style="margin-left: 20px; height: 30px; line-height: 30px; background-color: #1C729E">
                        <p style="color: white;">General Filter</p>
                    </div>


                </div>
            </div>

            <div class="col-md-12">


                <div class="card">
                    <form method="get" action="{{url('filter/get-data')}}">

                        {{csrf_field()}}
                        <div class="card-body">


                            <div class="col-md-3" style="float: left;">

                                <label>Merchant</label>
                                <select class="form-control trans-filter" name="merchant">

                                    <option value="">--select merchant--</option>
                                    <option value="all">All</option>

                                    @foreach($merchants as $row)

                                        <option value="{{$row->tin}}">{{$row->name}}</option>
                                    @endforeach

                                </select>

                            </div>
                            <div class="col-md-3" style="float: left;">

                                <label>Filter Type</label>
                                <select class="form-control trans-filter" id="filterPeriod" name="filterPeriod">

                                    <option value="">--select period--</option>

                                    @foreach($filterPeriod as $row)

                                        <option value="{{$row['id']}}">{{$row['description']}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-3" style="float: left">
                                <div class="form-group">

                                    <label for="middle_name">Start date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" placeholder="Start Date">

                                </div>
                            </div>


                            <div class="col-md-3" style="float: left">
                                <div class="form-group">

                                    <label for="middle_name">End date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" placeholder="End Date">

                                </div>
                            </div>

                            <div class="col-md-3" style="float: left;">

                                <label>Filter Type</label>
                                <select class="form-control trans-filter"  name="filterType">

                                    <option value="">--select type--</option>

                                    @foreach($filterType as $row)

                                        <option value="{{$row['id']}}">{{$row['description']}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-3" style="float: left; margin-top: 30px;">

                                <button class="btn btn-info" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>

                      @if($result)

                        @include('general_filter.registered_cards.registered_card')

                        @endif


                </div>


            </div>
        </div>

    </div>


@stop


@section('js')

    <script>
        $('.trans-filter').select2();

        $('#filterPeriod').change(function(){

            let periodType  =  $('#filterPeriod').val();

            if(periodType==100){

                $('#start_date').prop('disabled',false);
                $('#end_date').prop('disabled',false);

            }
            if(periodType==200){

                $('#start_date').prop('disabled',true);
                $('#end_date').prop('disabled',true);

            }

            if(periodType==300){

                $('#start_date').prop('disabled',true);
                $('#end_date').prop('disabled',true);

            }

            if(periodType==400){

                $('#start_date').prop('disabled',true);
                $('#end_date').prop('disabled',true);

            }
        });
    </script>
@stop
