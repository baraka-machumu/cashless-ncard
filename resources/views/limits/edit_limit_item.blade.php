@extends('layouts.master')

@section('stylesheets')
    <style>


        .limit-boarder{

            border: solid 1px #a0aec0;
        }

    </style>
@stop

@section('content')

    <x-header-page short-h="U" title="Update Limit Rule" ></x-header-page>

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


            <div class="col-md-12">

                <form method="post" action="{{url('limits/update',[$id,$limitClass->id])}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 limit-boarders">
                            <div class="form-group "><label for="min">Maximum Daily Amount</label>
                                <input type="text" class="form-control" name="max_daily" value="{{$limit->max_daily}}" id="min" >
                            </div>
                            <div class="form-group">
                                <label for="min">Maximum Number of Transactions</label>
                                <input type="text" class="form-control" name="max_daily_no" value="{{$limit->daily_tx_no}}" id="min" >
                            </div>
                        </div>
                        <div class="col-md-4 limit-boarders">
                            <div class="form-group">
                                <label for="min">Maximum Weekly Amount</label>
                                <input type="text" class="form-control" name="max_weekly" value="{{$limit->max_weekly}}" id="min" >
                            </div>
                            <div class="form-group">
                                <label for="min">Maximum Number of Transactions</label>
                                <input type="text" class="form-control" name="max_weekly_no" value="{{$limit->weekly_tx_no}}" id="min" >

                            </div>
                        </div>

                        <div class="col-md-4 limit-boarders">
                            <div class="form-group">
                                <label for="min">Maximum Monthly Amount</label>
                                <input type="text" class="form-control" name="max_monthly"  value="{{$limit->max_monthly}}" id="min" >
                                <input type="hidden" name="limitTypeCode" value="C001">
                            </div>
                            <div class="form-group">

                                <label for="min">Maximum Number of Transactions</label>
                                <input type="text" class="form-control" name="max_monthly_no" value="{{$limit->monthly_tx_no}}" id="min" >

                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">

                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Update</button>

                                <a href="{{url('limits-class',$limitClass->id)}}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>

@stop
