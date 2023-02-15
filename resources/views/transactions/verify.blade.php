
@extends('layouts.master')


@section('content')
    @can('view-report')

        <div class="container-fluid">
            <div class="row">

                <x-header-page code="V" title="Verify Transaction" ></x-header-page>

                <div class="col-lg-12">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                        @endif
                    @endforeach
                    <div class="form-row col-md-12" style="margin-top: 20px;">

                        <form class="form-inline" method="post" action="{{url('tnx-recon/verify')}}" enctype="multipart/form-data">
                            @csrf
                            <label class="sr-only" for="inlineFormInputGroupUsername2">File</label>
                            <div class="input-group mb-2 mr-sm-2">

                                <input type="file" name="tnx" class="form-control">

                            </div>
                            <button type="submit" style="width: 200px;" class="btn btn-primary mb-2">Submit</button>
                        </form>


                        @if(!empty($res))
                        <form class="form-inline" method="post" action="{{url('tnx-recon/check-status')}}" >
                            @csrf
                            <button type="submit" style="width: 200px; margin-left: 10px;" class="btn btn-info mb-2">Check status</button>
                        </form>
                        @endif
                        @if(!empty($res))
                            <form class="form-inline" method="post" action="{{url('tnx-recon/download')}}" >
                                @csrf
                                <button type="submit" style="width: 200px; margin-left: 10px;" class="btn btn-success mb-2">Download</button>
                            </form>
                        @endif
                        <table class="table table-striped table-bordered">

                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Phone Number</th>
                                <th>CardNo</th>
                                <th>Transaction Date</th>
                                <th>Reference</th>
                                <th>Amount</th>
                                <th>Channel</th>
                                <th>Status</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($res as $index=>$row)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$row->phone_number}}</td>
                                    <td>{{$row->ref_number}}</td>
                                    <td>{{$row->tnx_date}}</td>
                                    <td>{{$row->channel_ref_no}}</td>
                                    <td>{{$row->amount}}</td>
                                    <td>{{$row->channel}}</td>
                                    <td>

                                        @if($row->status=='SUCCESSFUL')
                                        <span class="badge badge-success">{{$row->status}}</span>

                                        @else
                                            <span class="badge badge-danger">{{$row->status}}</span>

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@stop
@section('js')
    <script>

    </script>
@stop
