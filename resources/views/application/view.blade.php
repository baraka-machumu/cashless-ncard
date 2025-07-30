@extends('layouts.master')


@section('content')

    <x-header-page short-h="{{substr($app->application_name,0,1)}}" title="{{$app->application_name}}"></x-header-page>

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

            <div class="col-lg-12 table-margin-top">

                @can('checker')

                    <button type="button" class="btn btn-primary" data-target="#approve-ex-modal" data-toggle="modal">
                        Approve
                    </button>
                @endcan
                @can('checker')
                    <button type="button" class="btn btn-danger" data-target="#reject-ex-modal" data-toggle="modal">
                        Reject
                    </button>
                @endcan

                @can('maker')

                    <button type="button" class="btn btn-warning" data-target="#cancel-ex-modal"
                            data-toggle="modal">Cancel
                    </button>
                @endcan

                <p style="line-height: 20px; font-size: 16px; margin-top: 10px; margin-bottom: 10px;">
                    Maker: {{$app->first_name.' '.$app->middle_name.' '.$app->last_name}}</p>

                <div style="margin-top: 10px;"></div>
                @if($app_type=='EX001')
                    @include('application.duo_exchange_rate')
                @elseif($app_type=='USR001')
                    @include('application.user_data')
                @elseif($app_type=='RL001')
                    @include('application.roles_data')
                @elseif($app_type=='CC001')
                    @include('application.currency_types')
                @elseif($app_type=='CS001')
                    @include('application.charge_data')
                @elseif($app_type=='PR001')
                    @include('application.products')
                @elseif($app_type=='LM001')
                    @include('application.limits')
                @elseif($app_type=='CR001')
                    @include('application.card_reg')
                @elseif($app_type=='ECI001')
                    @include('application.card_reg')
                @elseif($app_type=='ENC001' or $app_type=='DISC001' or $app_type=='BLC001' or $app_type=='PNR001')
                    @include('application.change_card_status')

                @elseif($app_type=='ADDC001')
                    @include('application.add_new_card')
                @elseif($app_type=='RPC001')
                    @include('application.replace_card')
                @elseif($app_type=='CCS001')
                    @include('application.customer_status')
                @elseif($app_type=='ADJUST001')
                    @include('application.adjustment')
                @elseif($app_type=='PRESET001')
                    @include('application.password_reset')
                @elseif($app_type=='LOC001')
                    @include('application.add_card_limit')
                @elseif($app_type=='CDP002')
                    @include('application.period')
                @elseif($app_type=='MRL002')
                    @include('application.manual')
                @elseif($app_type=='LVY001')
                    @include('application.levy')
                @elseif($app_type=='MRCLR002')
                    @include('application.clearm')
                @elseif($app_type=='NF001')
                    @include('application.no_fund_fee_services')
                @elseif($app_type=='AUSR001')
                    @include('application.api_users')
                @endif
            </div>
        </div>
        <a href="{{url('applications/'.$type)}}" class="btn btn-info">Back</a>
    </div>
    @include('application.approve_model')
    @include('application.reject_model')
    @include('application.cancel_model')
@stop

@section('js')

    <script src="{{asset('/assets/js/app_main_resource.js')}}"></script>

    {{--    @if($app_type=='ADJUST001')--}}
    {{--        <script>--}}
    {{--            $(function (e) {--}}

    {{--                let urlAction  = '{{url('cards/mask-unmask-action')}}'--}}
    {{--                maskUnmaskFromTbl(urlAction);--}}
    {{--            })--}}
    {{--        </script>--}}
    {{--    @else--}}
    <script>
        $(function (e) {

            let urlAction = '{{url('cards/mask-unmask-action')}}'
            maskUnmask(urlAction);
        })
    </script>
    {{--    @endif--}}
@stop
