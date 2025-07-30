
<div class="col-lg-12 table-margin-top">

    <table class="table table-bordered table-striped">

        <tbody>

        <tr>
            <th>Name</th> <td>{{$result->name}}</td>
        </tr>
        <tr>
            <th>Max daily</th> <td>{{$result->max_daily}}</td>
        </tr>
        <tr>
            <th>Daily Number</th> <td>{{$result->daily_tx_no}}</td>
        </tr>
        <tr>
            <th>Max weekly</th> <td>{{number_format($result->max_weekly,2,'.',',')}}</td>
        </tr>

        <tr>
            <th>Weekly number</th> <td>{{$result->weekly_tx_no}}</td>
        </tr>

        <tr>
            <th>Max monthly</th> <td>{{$result->max_monthly}}</td>
        </tr>

        <tr>
            <th>Monthly Number</th> <td>{{$result->monthly_tx_no}}</td>
        </tr>


        </tbody>
    </table>


</div>
