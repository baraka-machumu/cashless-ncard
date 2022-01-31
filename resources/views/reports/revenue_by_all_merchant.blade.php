
<table>
    <thead>

    <tr>

        <th colspan="3">N-CARD MERCHANT REVENUE SUMMARY REPORT</th>

    </tr>

    <tr>
        <th  colspan="3" style="font-weight: bold">From Date : {{$date_from }} </th>


    </tr>

    <tr>
        <th   colspan="3" style="font-weight: bold">To Date : {{$date_to}}</th>

    </tr>
    <tr>
        <th style="font-weight: bold">Name</th>
        <th style="font-weight: bold">Merchant ID</th>
        <th style="font-weight: bold">Amount</th>
    </tr>
    </thead>
    <tbody>

    <?php $sum  = 0; ?>
    @foreach($dataRevenue as $row)
        <tr>
            <td>{{ $row->name }}</td>
            <td>{{ $row->merchantTin }}</td>
            <td>{{ number_format($row->amount ,2,'.',',')}}</td>

        </tr>

        <?php  $sum  =  $sum+ $row->amount;?>

    @endforeach


    <tr>
        <th style="font-weight: bold;" colspan="2">Total </th> <td style="font-weight: bold;">{{number_format($sum ,2,'.',',')}}</td>

    </tr>
    </tbody>
</table>
