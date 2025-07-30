<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th>Card Number</th><td>
                <span id="cardNo-Id">{{stringToSecret($result->masked_card)}}</span>
                <a class="action" href="#" style="margin-left: 15px;">Unmask</a>
                <input type="hidden"  id="pan" value="{{encrypt($result->card_number)}}">
                <input type="hidden"  id="actionTxt" value="unmask">
            </td>
        </tr>
        <tr>
            <th>Currency</th><td>{{$result->currency}}</td>
        </tr>
        <tr>
            <th>Created date</th><td>{{$result->created_at}}</td>
        </tr>
    <tr>
        <th>Customer</th> <td>{{$app->account}}</td>
    </tr>
    </tbody>
</table>
