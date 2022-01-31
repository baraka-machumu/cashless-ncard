

<div class="col-lg-12 table-margin-top">


    <table class="table table-bordered table-striped" id="agents-all">

        <thead>

        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Agent Code</th>
            <th>amount</th>
            <th>reference</th>
            <th>phone_number</th>
            <th>Transaction date</th>
        </tr>

        </thead>

        <tbody>

        <?php $i=1;?>
        @foreach($deposits as $row)
            <tr>

                <td>{{$i}}</td>
                <td>{{$row->first_name.' '.$row->last_name}}</td>
                <td>{{$row->agent_wallet_id}}</td>
                <td>{{$row->amount}}</td>
                <td>{{$row->reference}}</td>
                <td>{{$row->phone_number}}</td>
                <td>{{$row->created_at}}</td>
            </tr>
            <?php $i++;?>

        @endforeach


        </tbody>
    </table>

</div>
