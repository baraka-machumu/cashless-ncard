
@extends('layouts.master')


@section('content')

    <div class="container-fluid">


        <div class="row">
            <div class="col-md-12">

                <h4>Merchant Reports</h4>

                {{--</div>--}}

            </div>
            <div class="col-md-12 table-margin-top">

                <table class="table table-striped table-bordered table-condensed">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>Action</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i =1;?>
                    @foreach($reports as $report)
                        <tr>

                            <td>{{$i}}</td>
                            <td>{{$report->name}}</td>
                            <td><a href="{{url('reports/consumer-report',$report->id)}}" class="btn btn-cyan"><i class="fa fa-eye"></i></a>

                        </tr>
                        <?php $i++;?>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@stop
