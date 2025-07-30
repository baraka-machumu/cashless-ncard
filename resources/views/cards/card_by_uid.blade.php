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

            <div class="col-md-12" style="margin-bottom: 20px;">

                <a href="{{url('cards-info/download')}}" class=""> Get template</a>
            </div>

            <div class="col-md-5">
                <form method="post" action="{{url('cards-info/save')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row" style="width:100%">
                        <div class="col-md-12" style="float: left;">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="file"   aria-label="Recipient's username" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Save File</button>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>

            </div>


            <div class="col-md-12">
                <form method="post" action="{{url('cards-info/export')}}">
                    @csrf
                 <button class="btn btn-primary">Download Data</button>

                </form>
            </div>
            <table class="table table-bordered table-striped" id="all-cards">

                <thead>

                <tr>
                    <th>No</th>
                    <th>Card Number</th>
                    <th>Carduid</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($cards as $index=>$row)
                        <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$row->card_number}}</td>
                        <td>{{substr($row->card_uid,0,3).'**'.substr($row->card_uid,6,2)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop`

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
