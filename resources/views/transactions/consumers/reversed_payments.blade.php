


        <div class="row">


            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Full Name</th>

                        <th>Wallet Id</th>
                        <th>Amount</th>

                        <th>Reference</th>
                        <th>Status</th>
                        <th>Date</th>

                        <th>Actionsvooo</th>
                    </tr>
                    </thead>
                    @if($failedTrans->isEmpty())

                        <?php echo '<tr><td colspan="12"> No Data Found</td></tr>'; ?>
                    @endif
                    <tbody>

                    <?php $i=1; ?>
                    @foreach($failedTrans as $failedTran)

                        <?php  $status  =  '';?>

                        @if($failedTran->status=='0')
                           <?php  $status  =  'Failed';?>

                            @elseif($failedTran->status=='1')
                            <?php  $status  =  'Success';?>


                        @elseif($failedTran->status=='2')
                            <?php  $status  =  'Pending';?>


                        @endif

                    <tr>
                        <td>{{$i}}</td>

                        <td>{{$failedTran->first_name.' '.$failedTran->last_name}}</td>

                        <td>{{$failedTran->consumer_wallet_id}}</td>
                        <td>{{$failedTran->amount}}</td>
                        <td>{{$failedTran->reference}}</td>

                        <td>{{$status}}</td>
                        <td>{{$failedTran->created_at}}</td>

                        {{--<td style="color: #c43007">{{'Failed'}}</td>--}}


                        <td>
                            <a href="{{route('roles.show',1)}}" data-toggle="modal" data-target="#show-consumer-modal" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                            <a href="{{route('deposit.history',$failedTran->consumer_wallet_id)}}" class="btn btn-info"><i class="fa fa-history"></i></a>

                        </td>

                    </tr>
                        <?php $i++; ?>

                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    {{--MODEL EDIT--}}

    <!-- Modal -->
    {{--<div class="modal fade bd-example-modal-lg" id="show-consumer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
        {{--<form method="post" action="#">--}}

            {{--<div class="modal-dialog modal-lg" role="document" >--}}
                {{--<div class="modal-content">--}}
                    {{--<div class="modal-header modal-background">--}}
                        {{--<h5 class="modal-title" id="exampleModalLabel">Transaction</h5>--}}
                        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                            {{--<span aria-hidden="true">&times;</span>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                    {{--<div class="modal-body">--}}
                        {{--<div class="col-md-12 show-user-details" style="margin-bottom: 10px;">--}}

                            {{--<span>Details for Baraka toe</span>--}}

                        {{--</div>--}}
                        {{--<div class="row">--}}


                            {{--<div class="col-lg-6">--}}


                                {{--<table class="table table-striped">--}}


                                    {{--<tbody>--}}

                                    {{--<tr>--}}
                                        {{--<th>Full Name</th>--}}
                                        {{--<td>Baraka Toe</td>--}}

                                    {{--</tr>--}}

                                    {{--<tr>--}}
                                        {{--<th>Merchant</th>--}}
                                        {{--<td>Danube</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<th>Service</th>--}}
                                        {{--<td>Shopping</td>--}}
                                    {{--</tr>--}}


                                    {{--</tbody>--}}
                                {{--</table>--}}

                            {{--</div>--}}


                            {{--<div class="col-lg-6">--}}


                                {{--<table class="table table-striped">--}}
                                    {{----}}
                                    {{--<tbody>--}}

                                    {{--<tr>--}}
                                        {{--<th>Gateway</th>--}}
                                        {{--<td>Tigo pesa</td>--}}
                                    {{--</tr>--}}

                                    {{--<tr>--}}
                                        {{--<th>Amount</th>--}}
                                        {{--<td>49000</td>--}}
                                    {{--</tr>--}}

                                    {{--<tr>--}}
                                        {{--<th>Date</th>--}}
                                        {{--<td>2019-09-09 3:40:00</td>--}}
                                    {{--</tr>--}}


                                    {{--</tbody>--}}
                                {{--</table>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                        {{--<button type="submit" class="btn btn-success">Reverse Transaction</button>--}}
                    {{--</div>--}}


                    {{--<div class="modal-footer">--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</form>--}}

    {{--</div>--}}
