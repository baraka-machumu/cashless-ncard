

@extends('layouts.master')

@section('stylesheets')
    <style>


        .limit-boarder{

            border: solid 1px #a0aec0;
        }
    </style>
@stop

@section('content')

    <x-header-page short-h="L" title="Limit Classes" ></x-header-page>

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

                <form method="post" action="{{url('limits-class/store')}}">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="name">Class Name</label>
                                <input type="text" class="form-control" name="class_name" id="name" >

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="code">Class Code</label>
                                <input type="text" class="form-control"  name="class_code" id="code"
                                       >

                            </div>

                        </div>

                        <div class="col-12"  style="margin-bottom: 20px;">

                            <div class="col-md-12" style="border: solid 1px grey">

                                <span>Configurations</span>

                            </div>
                        </div>

                        <div class="col-md-12">

                            <div class="form-group">

                                <label for="maxvalue">Max Amount Per Account</label>
                                <input type="text" class="form-control"  name="max_account_value"
                                       id="maxvalue"  >
                            </div>

                        </div>


                        <div class="col-md-12">

                            <div class="form-group" >

                                <span style="font-size: 17px; color: #3b5998; text-decoration: underline">Withdraw Limit</span>

                            </div>

                        </div>

                        <div class="col-md-4 limit-boarder">
                            <div class="form-group "><label for="min">Maximum Daily Credit (Amount)</label>
                                <input type="text" class="form-control" name="max_daily[]" id="min" >
                            </div>
                            <div class="form-group">
                                <label for="min">Tx Number</label>
                                <input type="text" class="form-control" name="max_daily_no[]" id="min" >
                            </div>
                        </div>
                        <div class="col-md-4 limit-boarder">
                            <div class="form-group">
                                <label for="min">Maximum Weekly Credit (Amount)</label>
                                <input type="text" class="form-control" name="max_weekly[]" id="min" >
                            </div>
                            <div class="form-group">
                                <label for="min">Tx Number</label>
                                <input type="text" class="form-control" name="max_weekly_no[]" id="min" >

                            </div>
                        </div>

                        <div class="col-md-4 limit-boarder">
                            <div class="form-group">
                                <label for="min">Maximum Monthly Credit(Amount)</label>
                                <input type="text" class="form-control" name="max_monthly[]" id="min" >
                                <input type="hidden" name="limitTypeCode[]" value="C001">
                            </div>
                            <div class="form-group">

                                <label for="min">Tx Number</label>
                                <input type="text" class="form-control" name="max_monthly_no[]" id="min" >

                            </div>
                        </div>

                        {{-- deposits limits goes herr  --}}

                        <div class="col-md-12">

                            <div class="form-group" >

                                <span style="font-size: 17px; color: #3b5998 ;text-decoration: underline">
                                    Deposit Limit</span>


                            </div>

                        </div>

                        <div class="col-md-4 limit-boarder">

                            <div class="form-group ">

                                <label for="min">Maximum Daily Deposit</label>
                                <input type="text" class="form-control" name="max_daily[]" id="min" >

                            </div>
                            <div class="form-group">

                                <label for="min">Tx Number</label>
                                <input type="text" class="form-control" name="max_daily_no[]" id="min" >

                            </div>
                        </div>

                        <div class="col-md-4 limit-boarder">

                            <div class="form-group">

                                <label for="min">Maximum Weekly Deposit</label>
                                <input type="text" class="form-control" name="max_weekly[]" id="min" >

                            </div>
                            <div class="form-group">

                                <label for="min">Tx Number</label>
                                <input type="text" class="form-control" name="max_weekly_no[]" id="min" >

                            </div>
                        </div>

                        <div class="col-md-4 limit-boarder">

                            <div class="form-group">

                                <label for="min">Maximum Monthly Deposit</label>
                                <input type="text" class="form-control" name="max_monthly[]" id="min" >

                                <input type="hidden" name="limitTypeCode[]" value="D001">
                            </div>
                            <div class="form-group">

                                <label for="min">Tx Number</label>
                                <input type="text" class="form-control" name="max_monthly_no[]" id="min" >

                            </div>
                        </div>

                        {{--    payments limits goes here  --}}

                        <div class="col-md-12">

                            <div class="form-group" >

                                <span style="font-size: 17px; color: #3b5998;text-decoration: underline">Payment Limit</span>

                            </div>

                        </div>

                        <div class="col-md-4 limit-boarder">

                            <div class="form-group ">

                                <label for="min">Maximum Daily Payment</label>
                                <input type="text" class="form-control" name="max_daily[]" id="min" >

                            </div>
                            <div class="form-group">

                                <label for="min">Tx Number</label>
                                <input type="text" class="form-control" name="max_daily_no[]" id="min" >

                            </div>
                        </div>

                        <div class="col-md-4 limit-boarder">

                            <div class="form-group">

                                <label for="min">Maximum Weekly Payment</label>
                                <input type="text" class="form-control" name="max_weekly[]" id="min" >

                            </div>
                            <div class="form-group">

                                <label for="min">Tx Number</label>
                                <input type="text" class="form-control" name="max_weekly_no[]" id="min" >

                            </div>
                        </div>

                        <div class="col-md-4 limit-boarder">

                            <div class="form-group">

                                <label for="min">Maximum Monthly Payment</label>
                                <input type="text" class="form-control" name="max_monthly[]" id="min" >

                                <input type="hidden" name="limitTypeCode[]" value="P001">

                            </div>
                            <div class="form-group">

                                <label for="min">Tx Number</label>
                                <input type="text" class="form-control" name="max_monthly_no[]" id="min" >

                            </div>
                        </div>
                        <div class="col-md-12">

                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Save</button>

                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>

@stop
