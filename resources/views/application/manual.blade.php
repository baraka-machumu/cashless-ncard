
<div class="col-lg-12 table-margin-top">

    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>Created Date</th> <td>{{$result->created_at}}</td>
        </tr>
        <tr>
            <th>Amount</th> <td>{{$result->amount}}</td>
        </tr>
        <tr>
            <th>Currency</th> <td>{{$result->currency}}</td>
        </tr>
        <tr>
            <th>Card number</th> <td>
                <span id="cardNo-Id">{{stringToSecret($result->masked_pan)}}</span>
                <a class="action" href="#" style="margin-left: 15px;">Unmask</a>
                <input type="hidden"  id="pan" value="{{encrypt($result->pan)}}">
                <input type="hidden"  id="actionTxt" value="unmask">
            </td>
        </tr>
        <tr>
            <th>Transaction date</th> <td>{{$result->tnx_date}}</td>
        </tr>
        <tr>
            <th>RRN</th> <td>{{$result->rrn}}</td>
        </tr>

        <tr>
            <th>Action type</th> <td> <span style="font-size: 18px;" class="badge badge-danger" >{{$result->type_name}}</span></td>
        </tr>
        <tr>
            <th>Status</th><td>{{$result->status}}</td>
        </tr>
        </tbody>
    </table>


</div>
