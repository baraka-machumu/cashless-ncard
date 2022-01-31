
@extends('layouts.master')


@section('content')




    <div class="container-fluid">


        <div class="row">

            <div class="col-lg-12">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px; height: 40px;">

                       <p style="line-height: 40px;"> Agent deposits</p>
                    </div>
                </div>


                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach


                <form method="post" action="{{url('tx-deposits/agents')}}">

                    {{csrf_field()}}

                    <div class="col-md-6" style="margin-top: 8px;">

                        <input type="text" name="search_option_query" placeholder="Enter phone number or agent code" class="form-control" required>

                        <br>

                        <button class="btn btn-info">Search</button>

                    </div>
                </form>

            </div>


            @include('agent_deposits.all')


        </div>

    </div>


@stop


@section('js')

    <script>
        $('#agents-all').dataTable();

    </script>


@stop
