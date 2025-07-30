
@extends('layouts.master')


@section('content')

    <x-header-page short-h="{{substr($app->application_name,0,1)}}" title="{{$app->application_name}}" ></x-header-page>


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

            {{--            <div class="col-lg-12 table-margin-top">--}}

            <div class="col-md-12">


                @can('checker')
                    <button type="button" class="btn btn-primary" data-target="#approve-ex-modal" data-toggle="modal" >Approve</button>

                    <button type="button" class="btn btn-danger" data-target="#reject-ex-modal" data-toggle="modal" >Reject</button>

                @endcan
                <p style="line-height: 20px; font-size: 16px; margin-top: 10px; margin-bottom: 10px;">Maker: {{$app->first_name.' '.$app->middle_name.' '.$app->last_name}}</p>
            </div>

            <div style="margin-top: 10px;"></div>
            @if($app_type=='UPLM001')

                @include('application.edit.edit_limit_class')

            @elseif($app_type=='UPLMI001')
                @include('application.edit.edit_limit_item')
            @elseif($app_type=='UPCS001')
                @include('application.edit.edit_charges')
            @elseif($app_type=='UPUS001')
                @include('application.edit.edit_users')
            @elseif($app_type=='UPRL001')
                @include('application.edit.edit_roles')

            @elseif($app_type=='UPPR001')
                @include('application.edit.edit_product')
            @elseif($app_type=='UPLOC001')
                @include('application.add_card_limit')

            @elseif($app_type=='UPLVY001')
                @include('application.levy')
            @endif

        </div>

        <a href="{{url('applications/'.$type)}}" class="btn btn-info">Back</a>

    </div>

    @include('application.edit.approve_model')
    @include('application.edit.reject_model')

@stop

@section('js')


@stop
