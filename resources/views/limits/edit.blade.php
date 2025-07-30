@extends('layouts.master')
@section('stylesheets')
    <style>
        .limit-boarder{
            border: solid 1px #a0aec0;
        }
        #sub-btn{
            margin-top: 28px;
        }
    </style>
@stop

@section('content')
    <x-header-page code="L" title="Limit Classes" ></x-header-page>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach
                @cannot('maker')
                    <a  href="{{url('limits-class/create')}}"
                        class="btn btn-cyan btn-sm" id="previous">New Limit Class</a>
                @endcan
            </div>
            <div class="col-md-12">
                <form method="post" name="form-class-save" action="{{url('limits-class/store')}}">
                    @csrf
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Class Name</label>
                                <input type="text" class="form-control" name="class_name" id="name" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="maxvalue">Max Amount Per Account</label>
                                <input type="text" class="form-control"  name="balance_limit" required
                                       id="maxvalue">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="maxvalue">Total Transaction Value Per Day</label>
                                <input type="text" class="form-control"  name="total_debit_per_day" required
                                       id="maxvalue">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="maxvalue">Debit Limit Per Transaction</label>
                                <input type="text" class="form-control" value="{{$limit->debit_limit}}"  name="debit_limit" required
                                       id="maxvalue">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="maxvalue">Credit Limit Per Transaction</label>
                                <input type="text" class="form-control"  name="credit_limit" value="{{$limit->credit_limit}}" required
                                       id="maxvalue">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="maxvalue">Limit Type</label>
                                <select class="form-control" name="limit_type" required>
                                    <option>---select type---</option>
                                    @foreach($types as $row)
                                        <option id="{{$row->code}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="sub-btn">Save</button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <div class="row col-md-12" id="add-rule-content">
            </div>
        </div>
    </div>
@stop

@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>

    </script>
@stop
