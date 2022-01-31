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
            <table class="table table-bordered" style="background-color: #1C729E; color: white;">

                <tbody>
                <tr>
                    <td>Total Cards</td> <td>{{count($cards)}}</td>
                </tr>
                </tbody>
            </table>

            <div class="col-md-5">

                <form method="post" action="{{url('reset-pos')}}">

                    {{csrf_field()}}

                    <div class="row" style="width:100%">
                        <div class="col-md-12" style="float: left;">

                            <div class="form-group">
                                <select class="form-control">

                                    @foreach($cards as $row)
                                        <option value="{{$row->card_number}}">{{$row->card_number}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-info">Reset</button>

                            </div>
                        </div>

                    </div>
                </form>

            </div>
            <div class="col-md-5">

                <form method="post" action="{{url('cards/card-upload')}}"  enctype="multipart/form-data">

                    {{csrf_field()}}

                    <div class="row" style="width:100%">
                        <div class="col-md-12" style="float: left;">

                            <div class="form-group">

                                <input type="file" name="file">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-info">Upload</button>

                            </div>
                        </div>

                    </div>
                </form>

            </div>
            <table class="table table-bordered table-striped" id="all-cards">

                <thead>

                <tr>
                    <th>No</th>
                    <th>Card Number</th>
                    <th>Status</th>
                </tr>

                </thead>


                <tbody>

                    @foreach($cards as $index=>$row)
                        <tr>

                        <td>{{$index+1}}</td>
                        <td>{{$row->card_number}}</td>
                        <td>

                            @if($row->status_id==1)

                                Active
                                @else

                                Not Active

                            @endif

                        </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
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
