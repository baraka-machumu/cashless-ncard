<table class="table table-bordered table-striped" id="datatable">

    <thead>
    <tr>

        <th>#</th>
        <th>Application Name</th>
        <th>Maker</th>
        <th>Checker</th>
        <th>Created Date</th>
        <th>Action Status</th>
        <th>Description/Account</th>
        <th>Card</th>
        <th>Wallet</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Actions</th>

    </tr>
    </thead>

    <tbody>

    <?php  $i =1;?>
    @foreach($application as $row)

        <tr>

            <td>{{$i}}</td>

            <td>{{$row->application_name}}</td>
            <th>{{$row->first_name.' '.$row->middle_name.' '.$row->last_name}}</th>
            <td></td>
            <td>{{$row->created_at}}</td>
            <td>{{$row->action_status}}</td>
            <td>{{$row->account}}</td>
            <td><span class="cardNo-Id">{{$row->card_number}} </span><a class="action" href="#" style="margin-left: 15px;">Unmask</a>
                <input type="hidden"  class="actionTxt" value="unmask"> <input type="hidden" class="pan" value="{{$row->enc_card}}"></td>


            <td>{{$row->wallet_id}}</td>
            <td>
                @if($row->service=='02')
                    DEBIT
                @else

                    CREDIT
                @endif
            </td>
            <td>{{number_format($row->amount,2,'.',',') }} ({{$row->currency}})</td>

            <td>

                <a  href="{{url('applications/view',[$row->id,$row->application_type])}}" class="btn btn-info"><i class="fa fa-eye"></i></a>

            </td>

        </tr>
        <?php  $i++;?>

    @endforeach


    </tbody>
</table>

