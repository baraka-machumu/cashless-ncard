

<table class="table table-bordered table-striped">


    <tbody>

        <tr>
            <th>New Card Number</th><td>{{$result->masked_card}}</td>
        </tr>

        <tr>
            <th>Currency</th><td>{{$result->currency}}</td>
        </tr>

        <tr>
            <th>Old Card Number</th><td>{{$result->masked_old_card}}</td>
        </tr>
        <tr>
            <th>Created date</th><td>{{$result->created_at}}</td>
        </tr>

        <tr>
            <th>Customer</th> <td>{{$app->account}}</td>
        </tr>


    </tbody>
</table>
