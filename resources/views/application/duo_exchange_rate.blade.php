


<table class="table table-bordered table-striped" id="consumer" style="margin-top: 10px;">

    <thead>

    <tr>

        <th>#</th>
        <th>From</th>
        <th>To</th>
        <th>Buy</th>
        <th>Midrate</th>
        <th>Sell</th>

        <th>Date</th>
        <th>Created By</th>
        <th>Last Updated By</th>

    </tr>
    </thead>

    <tbody>

    <?php  $i = 1;?>
    @foreach($result as $row)
        <tr>

            <td>{{$i}}</td>
            <td>{{$row->currency_from}}</td>
            <td>{{$row->currency_to}}</td>
            <td>{{$row->buy}}</td>
            <td>{{$row->midrate}}</td>
            <td>{{$row->sell}}</td>

            <th>{{$row->created_at}}</th>
            <td>{{$row->first_name.' '.$row->last_name}}</td>
            <td>{{$row->first_name.' '.$row->last_name}}</td>


        </tr>

        <?php  $i++;?>

    @endforeach




    </tbody>
</table>
