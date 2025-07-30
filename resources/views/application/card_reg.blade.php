
<table class="table table-bordered table-striped">
    <tbody>
    <tr>
        <th>First Name</th><td>{{$result->first_name}}</td>
        <th>country</th><td>{{$result->country}}</td>
    </tr>
    <tr>
        <th>Initial Name</th><td>{{$result->initial_name}}</td>
        <th>City</th><td>{{$result->city}}</td>
    </tr>
    <tr>
        <th>Last Name</th><td>{{$result->last_name}}</td>
        <th>Address</th><td>{{$result->address}}</td>
    </tr>
    <tr>
        <th>Phone number</th><td>{{$result->phone_number}}</td>
        <th>Branch</th><td>{{$result->branch_name}}</td>
    </tr>
    </tbody>

</table>

<table class="table table-bordered table-striped">
    <tbody>
    <tr>
        <th>Created Date</th><td>{{$result->created_at}}</td>
        <th>Email</th><td>{{$result->email}}</td>
    </tr>
    <tr>
        <th>Date of Birth</th><td>{{$result->dob}}</td>
        <th>Title</th><td>{{$result->title}}</td>
    </tr>
    <tr>
        <th>Identity Card</th><td>{{$result->id_card}}</td>
        <th>Id Type</th> <td>{{$result->id_type}}</td>

    </tr>
    @if($app_type=='CR001')
        <tr>
            <th>Card number</th><td>
                <span id="cardNo-Id">{{stringToSecret($result->card_number)}}</span>
                <a class="action" href="#" style="margin-left: 15px;">Unmask</a>
                <input type="hidden"  id="pan" value="{{encrypt($result->pan)}}">
                <input type="hidden"  id="actionTxt" value="unmask">
            </td>
        </tr>
    @endif
    </tbody>

</table>
