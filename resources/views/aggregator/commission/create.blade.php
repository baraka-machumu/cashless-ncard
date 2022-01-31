
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 1px solid #cdd1d3; margin-top: 5px; height: 50px; ">

                        <h4 class="page-title" style="line-height: 50px;">Create New Commision</h4>

                    </div>
                </div>
            </div>
            <div class="col-md-12">

                @include('partials.error_message')

                <div class="card">
                    <form method="post" action="{{route('agg-commission.save',[$code])}}">

                        {{csrf_field()}}
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="name"> percentage</label>
                                        <input type="text" class="form-control" id="name"
                                               value="{{old('percentage')}}" name="percentage" placeholder="Enter percentage">

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="name"> Tin</label>

                                        <select name="trx_type" required class="form-control">

                                            <option value="">--select transaction type---</option>
                                            @foreach($transaction_type_codes as $row)

                                                <option value="{{$row->code}}">{{$row->name}}</option>

                                            @endforeach

                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12 form-group text-right">
                                    <hr/>
                                    <a  href="{{url('agents')}}" class="btn btn-info">Back</a>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>


            </div>
        </div>

    </div>


@stop
