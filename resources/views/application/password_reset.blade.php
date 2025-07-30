

<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th>First Name</th><td>{{$result->first_name}}</td>
            <th>Last Name</th><td>{{$result->last_name}}</td>
        </tr>
        <tr>
            <th>Phone Number</th><td>{{$result->phone_number}}</td>
            <th>Email</th><td>{{$result->email}}</td>
        </tr>
        <tr>
            <th>Create Date</th><td>{{$result->created_at}}</td>
            <th>Created By</th><td>{{$result->u_first_name.' '.$result->u_last_name}}</td>
        </tr>
    </tbody>
</table>
