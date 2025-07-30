

<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th>Amount</th><td>{{number_format($result->amount,2,'.',',')}} ({{$result->currency}})</td>
            <th>Date</th><td>{{$result->created_at}}</td>
        </tr>
        <tr>
            <th>Reference Number</th><td>{{$result->reference_number}}</td>
            <th>Status</th><td>{{$result->status}}</td>
        </tr>
        <tr>
            <th>Full Name</th><td>{{$result->first_name.' '.$result->first_name}}</td>
            <th>channel</th><td>{{$result->channel}}</td>
        </tr>
        <tr>
            <th>Wallet ID</th><td>{{$result->wallet_id}}</td>
            <th>Card Number</th><td>

                <span id="cardNo-Id">{{$result->card_number}}</span>
                <a class="action" href="#" style="margin-left: 15px;">Unmask</a>
                <input type="hidden"  id="pan" value="{{$result->enc_card}}">
                <input type="hidden"  id="actionTxt" value="unmask">

            </td>
        </tr>
    <tr>
        <th>Adjustment Type</th> <td>{{$result->adjustment_type}}</td>
        <th>Description</th><td>{{$result->desc}}</td>
    </tr>
    </tbody>
</table>
