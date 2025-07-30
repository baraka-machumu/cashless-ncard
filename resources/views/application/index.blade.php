@extends('layouts.master')
    @section('stylesheets')
    <style>
    </style>
    @stop
    @section('content')
        <x-header-page code="P" title="Pending Application Request" ></x-header-page>
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
                    @if($type=='AD')
                        @include('application.AD')
                    @else
                        @include('application.AP')
                    @endif
                </div>
            </div>
        </div>
    @stop

    @section('js')

        <script>

            $('#datatable').DataTable()
        </script>

        <script src="{{asset('/assets/js/app_main_resource.js')}}"></script>
        <script>
            $(function (e) {

                let urlAction  = '{{url('cards/mask-unmask-action')}}'
                maskUnmaskFromTbl(urlAction);
            })
        </script>
        @stop
