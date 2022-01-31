
@extends('layouts.master')


@section('content')

    <div class="container-fluid">

        <div class="row">

            {{--<div class="col-md-12" style="margin-bottom: 10px;">--}}

                {{--<a href="{{url('consumers/getall/deposits',1)}}" class="btn btn-info">All deposits</a>--}}
                {{--<a href="{{route('transactions.history',1)}}" class="btn btn-success">All Payments</a>--}}

            {{--</div>--}}
        </div>

        <div class="col-lg-12 show-user-details-2">

            <span>NCARD  Wallet Info</span>

        </div>

        <div class="row">


            <div class="col-lg-12 table-margin-top">

           <table class="table table-bordered table-striped">

               <tbody>

               <tr>
                   <td>N CARD consumer balance</td> <td>{{$consumerBalance}} TZS</td>
               </tr>
               <tr>
                   <td>N CARD active wallet</td> <td>{{$active_card}}</td>
               </tr>


               <tr>
                   <td>N CARD inactive wallet</td> <td>{{$inactive_card}}</td>
               </tr>


               </tbody>
           </table>

            </div>

        </div>

    </div>




@stop



@section('js')

    <script>
        $('#consumer-wallet').dataTable();

    </script>

    @stop
