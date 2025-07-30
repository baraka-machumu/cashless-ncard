<table class="table table-bordered table-striped" id="datatable">

    <thead>
    <tr>

        <th>#</th>
        <th>Fullname</th>
        <th>Created Date</th>
        <th>Action Status</th>
        <th>Card</th>
        <th>Wallet</th>
        <th>Amount</th>
    </tr>
    </thead>

    <tbody>

    <?php  $i =1;?>
    @foreach($result as $row)

        <tr>

            <td>{{$i}}</td>

            <th>{{$row->first_name.' '.$row->last_name}}</th>
            <td>{{$row->created_at}}</td>
            <td>{{$row->status}}</td>
            <td>{{\App\Helper\CardHelpers::getMaskedPan(\App\Helper\CardHelpers::getDecryptedCard($row->card_number))}}</td>
            <td>{{$row->wallet_id}}</td>
            <td>{{number_format($row->amount,2,'.',',') }} ({{$row->short_code}})</td>


        </tr>
        <?php  $i++;?>

    @endforeach


    </tbody>
</table>
