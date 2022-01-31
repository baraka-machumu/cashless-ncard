@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach
            </div>


            <div class="col-md-12">
                <form method="post"  action="{{url('pos/reset-status')}}">

                    {{csrf_field()}}

                    <p>Record Found, reset now</p>
                    <br>

                    <input type="text"  readonly class="form-control" name="imei_no_search" value="{{$imei_no_search}}">

                    <br>
                    <button class="btn btn-info">reset to normal</button>

                </form>
            </div>
        </div>

    </div>
@stop

@section('js')
    <script>

        // $('#trans-filter').select2();

        $('.card-select').select2({
            placeholder: "Select card",
            allowClear: true
        });

        $('#all-cards').dataTable();
    </script>

@stop
