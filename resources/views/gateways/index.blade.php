
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Gateways</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Gateways</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">

                {{--<div class="col-md-3">--}}

                <button type="button" data-toggle="modal" data-target="#create-gateway-modal" class="btn btn-cyan btn-sm" id="previous">New Gateway</button>


                {{--</div>--}}

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="all-gateways">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Company Name</th>
                        <th>Name</th>

                        <th>Actions</th>


                    </tr>
                    </thead>

                    <tbody>

                    @foreach($gateways as $index=>$row)
                    <tr>

                        <td>{{$index+1}}</td>
                        <td>{{$row->company_name}}</td>
                        <td>{{$row->name}}</td>

                        <td>
                            <a href="#" data-toggle="modal" data-target="#edit-gateway-modal" class="btn btn-success"><i class="fa fa-edit"></i></a>
{{--                            <a href="{{route('agents.show',1)}}" class="btn btn-warning"><i class="fa fa-eye"></i></a>--}}

                        </td>
                    </tr>

                        @endforeach


                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="create-gateway-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Create Gateway</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <form method="post" action="#">
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="company_name">Company Name</label>
                                                    <input type="text" class="form-control" id="company_name" placeholder="Company Name">

                                                </div>

                                                <div class="form-group">

                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" placeholder="Name">

                                                </div>
                                                <div class="form-group">

                                                    <label for="charge_option">Charge Option</label>

                                                    <select id="charge_option" class="form-control">

                                                        <option disabled="disabled">--select charge option--</option>
                                                        <option>Fixed Charge</option>
                                                        <option>Percentage Charge</option>


                                                    </select>
                                                </div>


                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success">Save</button>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="minmum_amount">Minmum Amount</label>
                                                    <input type="text" class="form-control" id="registration_number" placeholder="Agent Number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="maximum_amount">Maximum Amount</label>
                                                    <input type="text" class="form-control" id="maximum_amount" placeholder="Maximum Amount">

                                                </div>

                                                <div class="form-group">

                                                    <label for="amount_percent">Amount/Percentage</label>
                                                    <input type="text" class="form-control" id="amount_percent" placeholder="Amount/Percentage">

                                                </div>


                                                {{--<div class="form-group">--}}

                                                    {{--<button type="submit" style="margin-top: 28px;" class="btn btn-success" name="edit-merchant">Update</button>--}}
                                                {{--</div>--}}

                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    {{--edit model for gateay--}}

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="edit-gateway-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Gateway</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <form method="post" action="#">
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="company_name">Company Name</label>
                                                    <input type="text" class="form-control" id="company_name" placeholder="Company Name" value="{{'Tigo'}}">

                                                </div>

                                                <div class="form-group">

                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" placeholder="Name" value="{{'Tigo pesa'}}">

                                                </div>
                                                <div class="form-group">

                                                    <label for="charge_option">Charge Option</label>

                                                    <select id="charge_option" class="form-control">

                                                        <option disabled="disabled">--select charge option--</option>
                                                        <option>Fixed Charge</option>
                                                        <option>Percentage Charge</option>


                                                    </select>
                                                </div>


                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success">Save</button>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="minmum_amount">Minmum Amount</label>
                                                    <input type="text" class="form-control" value="{{'500'}}" id="registration_number" placeholder="Agent Number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="maximum_amount">Maximum Amount</label>
                                                    <input type="text" class="form-control" value="{{'2500000'}}" id="maximum_amount" placeholder="Maximum Amount">

                                                </div>

                                                <div class="form-group">

                                                    <label for="amount_percent">Amount/Percentage</label>
                                                    <input type="text" class="form-control" id="amount_percent"value="{{'50%'}}" placeholder="Amount/Percentage">

                                                </div>


                                                {{--<div class="form-group">--}}

                                                {{--<button type="submit" style="margin-top: 28px;" class="btn btn-success" name="edit-merchant">Update</button>--}}
                                                {{--</div>--}}

                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


@stop



@section('js')

    <script>

        $('#all-gateways').dataTable();

    </script>
    @stop
