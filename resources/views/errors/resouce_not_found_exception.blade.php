@extends('layouts.master')


@section('content')


    <div class="container-fluid">

        <div class="col-md-12">

            <div class="alert alert-danger" role="alert">

                <p>{{$message}}</p>
            </div>

            <a href="{{url()->previous()}}" class="btn btn-info"><i class="fa fa-backward"></i></a>

        </div>

    </div>


@stop