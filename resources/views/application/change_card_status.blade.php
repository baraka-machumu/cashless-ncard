<table class="table table-bordered table-striped">

    <tbody>

        <tr>
            <th>First name</th><td>{{$result->first_name}}</td>
        </tr>

        <tr>
            <th>Last name</th><td>{{$result->last_name}}</td>
        </tr>

        <tr>
            <th>Old status</th><td>{{$result->old_status}}</td>
        </tr>
        <tr>
            <th>New status</th><td>{{$result->new_status}}</td>
        </tr>
        <tr>
            <th>Card</th><td>
                <span id="cardNo-Id">{{stringToSecret($result->masked_pan)}}</span>
                <a class="action" href="#" style="margin-left: 15px;">Unmask</a>
                <input type="hidden"  id="pan" value="{{encrypt($result->card_number)}}">
                <input type="hidden"  id="actionTxt" value="unmask">
            </td>
        </tr>

        <tr>
            <th>action</th><td>{{$result->action}}</td>
        </tr>

    </tbody>
</table>


