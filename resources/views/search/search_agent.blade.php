
@extends('layouts.master')


@section('content')






    <div class="container-fluid">



        <div class="row">



        </div>


        <div class="col-lg-12 show-user-details-2">

            <span>Advanced Search for agent</span>

        </div>

        <div class="row">

            <div class="col-lg-12 table-margin-top">


                <form method="post" action="#">

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Merchant's Name" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            {{--<span >--}}

                            {{--</span >--}}

                            <button class="input-group-text btn btn-success" id="basic-addon2" style="background-color: #1C729E">

                                <i class="fa fa-search" style="color: white;"></i>
                            </button>
                        </div>
                    </div>
                </form>


            </div>

            {{--<div class="row">--}}

                <div class="col-lg-12">

                    <span>Results</span>

                </div>

            {{--</div>--}}



        </div>

    </div>






@stop