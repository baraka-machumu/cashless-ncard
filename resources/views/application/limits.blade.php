
<div class="col-lg-12 table-margin-top">

    <table class="table table-bordered table-striped">

        <tbody>

        <tr>
            <th>Name</th> <td>{{$result->class_name}}</td>
        </tr>
        <tr>
            <th>Class Code</th> <td>{{$result->class_code}}</td>
        </tr>
        <tr>
            <th>Maximum Account Can Hold</th> <td>{{number_format($result->max_hold_amount,2,'.',',')}}</td>
        </tr>

        <tr>
            <th>Class Currency </th> <td>{{$result->currency}}</td>
        </tr>
        <tr>
            <th>Created Date</th> <td>{{$result->created_at}}</td>
        </tr>

        </tbody>
    </table>

    <h4>Associated Limits  Rules</h4>
    <table class="table table-bordered" id="datatable">

        <thead>

        <tr>
            <th>No.</th>
            <th>Limit name</th>
            <th>Limit code</th>
            <th>Max daily</th>
            <th>Max weekly</th>
            <th>Max monthly</th>
            <th>Created  at</th>

        </tr>
        </thead>

        <tbody>


        @foreach($limits as $index=>$row)

            <tr>
                <td>{{$index+1}}</td>
                <td>{{$row->limit_code_name}}</td>
                <td>{{$row->limit_code}}</td>
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
                    <span>Transaction :  {{$row->weekly_tx_no}}</span>


                </th>
                <td>{{$row->created_at}}</td>


            </tr>

        @endforeach

        </tbody>
    </table>


</div>
