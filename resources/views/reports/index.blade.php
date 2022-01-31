@extends('layouts.master')


@section('content')



    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Reports</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Reports</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Configurations</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
            @endif
        @endforeach
        <div class="row">

            <div class="col-lg-12">

                {{--                <a href="{{url('reports/create')}}" class="btn btn-cyan btn-sm" id="previous">New Report</a>--}}
                <button type="button" data-toggle="modal" data-target="#create-report-modal" class="btn btn-cyan btn-sm" id="previous">New Report</button>



            </div>


            <div class="container-fluid table-margin-top">
                <table class="table table-striped table-bordered table-condensed" id="#datatable">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>Report type</th>
                        <th>Report url</th>
                        <th>Action</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i =1;?>
                    @foreach($reports as $report)
                        <tr>

                            <td>{{$i}}</td>
                            <td>{{$report->name}}</td>
                            <td>{{$report->rname}}</td>
                            <td>{{$report->report_url}}</td>
                            <td>
                                <a id="{{$report->id}}" data-id="{{ $report->id}}" href="#" class="btn btn-success edit-reports"><i class="fa fa-edit"></i></a>
                            <a href="{{url('reports/consumer-report',$report->id)}}" class="btn btn-cyan"><i class="fa fa-eye"></i></a>
                                <a href="#" class="btn btn-warning"><i class="fa fa-trash"></i></a> </td>


                        </tr>
                        <?php $i++;?>
                    @endforeach
                    </tbody>
                </table>


            </div>

            {{--            Modal create new report--}}

            <div class="modal fade bd-example-modal-lg" id="create-report-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <form method="post" id="editForm" action="{{url("reports/configuration")}}" >
                    {{csrf_field()}}
                    <div class="modal-dialog modal-md" role="document" >
                        <div class="modal-content">
                            <div class="modal-header modal-background">
                                <h5 class="modal-title" id="exampleModalLabel">Create Report</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">


                                                    <div class="col-md-12">

                                                        <div class="form-group">

                                                            <label for="name">Report Name</label>
                                                            <input type="text" class="form-control" name="name" id="name" placeholder="Report Name">

                                                        </div>
                                                        <div class="form-group">

                                                            <label for="report_types">Report Type</label>

                                                            <select class="form-control" name="report_type"  id="report_types" data-parsley-required="true">
                                                                <option>Select Report type</option>
                                                                @foreach ($report_types as $report_type)
                                                                    {
                                                                    <option value="{{ $report_type->id }}">{{ $report_type->name }}</option>
                                                                    }
                                                                @endforeach
                                                            </select>

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="report_url">Report url</label>
                                                            <input type="text" class="form-control" name="report_url" id="report_url" placeholder="report url">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="viewParams">Does a report has parameter?</label>
                                                            <select class="form-control" id="viewParams" name="has_param">
                                                                @foreach($has_params as $has_param)
                                                                    <option value="{{$has_param->id}}">{{$has_param->description}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group" id="viewParamsDiv">

                                                            <table class="table table-bordered">

                                                                <thead>

                                                                <tr>
                                                                    <th><input type="checkbox" name="params" style="width: 20px; height: 20px;"></th>
                                                                    <th>Select Parameter Name</th>

                                                                </tr>

                                                                <tbody>

                                                                @foreach($params as $param)

                                                                    <tr>
                                                                        <td><input type="checkbox" class="form-control check-params uncheck" value="{{$param->id}}" name="params[]"   style="width: 20px; height: 20px;"></td>
                                                                        <td>{{$param->name}}</td>

                                                                    </tr>

                                                                @endforeach
                                                                </tbody>
                                                                </thead>

                                                            </table>

                                                        </div>

                                                    </div>


                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <!-- Modal Edit-->
    <div class="modal fade bd-example-modal-lg" id="edit-report-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="{{url('reports/configuration/update')}}" >
            {{ csrf_field() }}
            {{--            {{ method_field('PATCH') }}--}}
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Report Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-12">

                                                <div class="form-group">

                                                    <label for="report_name">Report Name</label>
                                                    <input type="text" class="form-control report_name" name="report_name" id="report_name" placeholder="Report Name">

                                                    <input type="hidden" name="report_id"  id="report_id">

                                                </div>

                                                <div class="form-group">

                                                    <label for="report_types">Report Type</label>

                                                    <select class="form-control report_types" name="report_type">
                                                        @foreach ($report_types as $report_type)
                                                            {
                                                            <option value="{{ $report_type->id }}">{{ $report_type->name }}</option>
                                                            }
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="form-group">

                                                    <label for="report_url">Report Url</label>
                                                    <input type="text" class="form-control report_url" name="report_url" id="report_url" placeholder="Report Name">

                                                </div>
                                                <div class="form-group">
                                                    <label for="viewParams2">Does a report has parameter?</label>
                                                    <select class="form-control has_param" id="viewParams2" name="has_param">
                                                        @foreach($has_params as $has_param)
                                                            <option value="{{$has_param->id}}">{{$has_param->description}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group" id="viewParamsDiv2">

                                                    <table class="table table-bordered">

                                                        <thead>

                                                        <tr>
                                                            <th><input type="checkbox" name="params" style="width: 20px; height: 20px;"></th>
                                                            <th>Select Parameter Name</th>

                                                        </tr>

                                                        <tbody>

                                                        @foreach($params as $param)

                                                            <tr>
                                                                <td><input type="checkbox" class="form-control  check-params uncheck" value="{{$param->id}}" name="params[]"   style="width: 20px; height: 20px;"></td>
                                                                <td>{{$param->name}}</td>

                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                        </thead>

                                                    </table>



                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </div>
@stop
