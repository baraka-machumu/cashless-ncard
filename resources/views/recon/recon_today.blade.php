
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px; height: 50px; ">
                    <h4 class="page-title" style="line-height: 50px;">Ticket Engine and Ncard Recon</h4>

                </div>
            </div>
            <div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach
            </div>
            <div class="col-md-12">
                <div class="card">
                    <form method="post" action="{{url('reconciliation/check')}}"  enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tin">Merchant</label> <br>
                                        <select  required  class="select2 form-control region" id="tin" name="tin" style="width: 100%; height:36px;">
                                            <option></option>
                                            @foreach($merchants as $row)
                                                <option value="{{$row->tin}}">{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="mname">Date</label>
                                        <input type="date" required    class="form-control" id="mname" name="date" >
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <button class="btn btn-primary form-control"  type="submit">Check</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if($is_result)
                        <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td colspan="2">Ticket Engine Service</td>
                                    </tr>
                                    <tr>
                                        <th>Total Local Tnx</th><td>{{$data->TotalLocalTnx}}</td>
                                    </tr>

                                    <tr>
                                        <th>Total Local Amount</th><td>{{number_format($data->TotalLocalAmount,2,'.',',')}}</td>
                                    </tr>

                                    <tr>
                                        <th>Total Live Tnx-Col</th><td>{{$data->TotalLiveTnxCol}}</td>
                                    </tr>

                                    <tr>
                                        <th>Total Live Amount-Col</th><td>{{number_format($data->TotalLiveAmountCol,2,'.',',')}}</td>
                                    </tr>


                                    <tr>
                                        <th>Total Staging Tnx</th><td>{{$data->TotalStagingTnx}}</td>
                                    </tr>

                                    <tr>
                                        <th>Total Direct Purchase Tnx</th><td>{{$data->TotalDirectPurchaseTnx}}</td>
                                    </tr>


                                    <tr>
                                        <th>Total Staging Amount</th><td>{{number_format($data->TotalStagingAmount,2,'.',',') }}</td>
                                    </tr>


                                    <tr>
                                        <th>Total Direct Purchase Amount</th><td>{{number_format($data->TotalDirectPurchaseAmount,2,'.',',')}}</td>
                                    </tr>


                                    <tr>
                                        <th>DashBoard Collection Tnx</th><td>{{$data->DashBoardCollectionTnx}}</td>
                                    </tr>

                                    <tr>
                                        <th>DashBoard Collection Amount</th><td>{{number_format($data->DashBoardCollectionAmount,2,'.',',')}}</td>
                                    </tr>


                                </table>

                            </div>
                            <div class="col-md-6">

                                <table class="table table-bordered table-striped">

                                    <tr>
                                        <td colspan="2">Ncard System</td>
                                    </tr>
                                    <tr>
                                        <th>Total Ncard Reusable Tnx</th><td>{{$ncard_res->ATotal}}</td>
                                    </tr>

                                    <tr>
                                        <th>Total Ncard Reusable Amount</th><td>{{number_format($ncard_res->AAmount,2,'.',',')}}</td>
                                    </tr>

                                    <tr>
                                        <th>Total Ncard Direct Purchase Tnx</th><td>{{$ncard_res->cTotal}}</td>
                                    </tr>

                                    <tr>
                                        <th>Total Ncard Direct Purchase Money</th><td>{{number_format($ncard_res->cAmount,2,'.',',')}}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop
