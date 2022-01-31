
@extends('layouts.master')


@section('content')


    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                    <span class="page-title">All cards registered by {{$agent_code}} </span>

                    <span class="pull-right" style="  float: right">Total cards :  <b style="font-size: 18px;">{{count($result)}}</b></span>
                </div>
            </div>

            <div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach


                <div class="form-row">

                    <div class="col-md-12" style="margin-top: 8px;">
                        <a href="{{url('reports/agent-summary')}}" class="btn btn-cyan" style="margin-bottom: 10px;">Back</a>
                        <table class="table table-bordered" id="all-reg-cards">

                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone number</th>
                                <th>Card number</th>
                                <th>Date</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($result as $row)

                                <tr>
                                    <td>{{$row->first_name}}</td>
                                    <td>{{$row->last_name}}</td>
                                    <td>{{$row->phone_number}}</td>
                                    <td>{{$row->card_number}}</td>
                                    <td>{{$row->registered_date}}</td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>


                    </div>

                </div>


            </div>

            <div class="col-lg-12 table-margin-top">

            </div>

        </div>

    </div>



@stop


@section('js')

    <script>

        $('#all-reg-cards').dataTable();

    </script>


@stop
