
@extends('layouts.master_merchant')

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">

            {{--column--}}
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                        <h6 class="text-white">Dashboard</h6>
                    </div>
                </div>
            </div>

            {{--column--}}
            <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-currency-usd"></i></h1>
                        <h6 class="text-white">Transactions</h6>
                    </div>
                </div>
            </div>


            {{--column--}}
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-currency-usd"></i></h1>
                        <h6 class="text-white">Merchants users</h6>
                    </div>
                </div>
            </div>



        </div>

        {{--row--}}

        <div class="row">

            <div class="col-lg-7">

                <div class="card" style="height: 210px; background-color: #eeeeee">
                    <div class="" style="height: 20px; margin-top: 2px; margin-left: 5px;">
                        <h4 class="card-title">System Tips</h4>
                    </div>
                    <div class="comment-widgets scrollable">
                        <!-- Comment Row -->
                        <div class="d-flex flex-row comment-row m-t-0">
                            <div class="p-2"><img src="{{asset('public/assets/images/tips.png')}}" alt="user" width="30" height="30" class="rounded-circle"></div>
                            <div class="comment-text w-100" style="">
                                <h6 class="font-medium" id="tip-heading">How to Assign Roles</h6>
                                <span class="m-b-15 d-block" id="tips-detail">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                <div class="comment-footer">
                                    <span class="text-muted float-right">July 12, 2019</span>

                                    {{--<button type="button" class="btn btn-danger btn-sm">Delete</button>--}}
                                </div>
                            </div>
                        </div>

                    </div>
                   <div class="col-md-3">
                       <button type="button" class="btn btn-cyan btn-sm" id="previous">Previous</button>
                       <button type="button" class="btn btn-success btn-sm" id="next">Next</button>


                   </div>
                </div>


            </div>

            {{--column--}}
            <div class="col-lg-5">

                <div class="row">

                    <div class="col-lg-6">
                        <div class="bg-dark p-10 text-white text-center box-d" >
                            <i class="fa fa-user m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5">25</h5>
                            <small class="font-light">Total Users</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-dark p-10 text-white text-center box-d">
                            <i class="fa fa-user m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5">25</h5>
                            <small class="font-light">Total Services</small>
                        </div>
                    </div>


                </div>

                <div class="row" style="margin-top: 2px;">
                    <div class="col-lg-6">
                        <div class="bg-dark p-10 text-white text-center box-d">
                            <i class="fa fa-user m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5">25</h5>
                            <small class="font-light">Total Merchants users</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-dark p-10 text-white text-center box-d">
                            <i class="fa fa-user m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5">25</h5>
                            <small class="font-light">Total Roles</small>
                        </div>
                    </div>


                </div>
                <div class="row" style="margin-top: 2px;">
                    <div class="col-lg-6">
                        <div class="bg-dark p-10 text-white text-center box-d">
                            <i class="fa fa-user m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5">25</h5>
                            <small class="font-light">Total Permissions</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-dark p-10 text-white text-center box-d">
                            <i class="fa fa-user m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5">25</h5>
                            <small class="font-light">Total User profiles</small>
                        </div>
                    </div>


                </div>

            </div>

        </div>



    </div>

@stop


@section('css')

<style>
    .box-d{

        height: 600px !important;
    }

</style>
@stop