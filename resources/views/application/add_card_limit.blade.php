
<div class="col-lg-12 table-margin-top">

    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>Created Date</th> <td>{{$result[0]->created_at}}</td>
        </tr>
        <tr>
            <th>Customer</th> <td>{{$result[0]->fullname}}</td>
        </tr>
        <tr>
            <th>Currency</th> <td>{{$result[0]->currency}}</td>
        </tr>
        <tr>
            <th>Card number</th> <td>{{$result[0]->card_number}}</td>
        </tr>
        </tbody>
    </table>

    <h4>Associated Limits  Rules</h4>
    <table class="table table-bordered" id="datatable">

        <thead>

        <tr>
            <th>No.</th>
            <th>Limit code</th>
            <th>Max daily</th>
            <th>Max weekly</th>
            <th>Max monthly</th>
            <th>Created  at</th>

        </tr>
        </thead>

        <tbody>


        @foreach($result as $index=>$row)

            <tr>
                <td>{{$index+1}}</td>
                <td>{{$row->service_name}}</td>
                <td>
                    <span>Amount:  {{$row->max_daily}}</span><br>
                    <hr>
                    <span>Transactions :  {{$row->daily_tx_no}}</span>
                </td>
                <td>
                    <span>Amount:  {{$row->max_weekly}}</span><br>
                    <hr>
                    <span>Transactions :  {{$row->weekly_tx_no}}</span>
                </td>
                <th>
                    <span>Amount:  {{$row->max_monthly}}</span><br>
                    <hr>
                    <span>Transaction :  {{$row->monthly_tx_no}}</span>
                </th>
                <td>{{$row->created_at}}</td>
            </tr>

        @endforeach

        </tbody>
    </table>


</div>
