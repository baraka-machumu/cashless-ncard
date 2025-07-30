

<table class="table table-bordered table-striped">

    <tbody>
    <tr>
        <th>Old status</th><td>{{$result->old_status}}</td>
    </tr>
    <tr>
        <th>New status</th><td>{{$result->new_status}}</td>
    </tr>
    <tr>
        <th>First name</th><td>{{$result->first_name}}</td>
    </tr>
    <tr>
        <th>Last name</th><td>{{$result->last_name}}</td>
    </tr>
    <tr>
        <th>Created by</th><td>{{$result->u_first_name.' '.$result->u_last_name}}</td>
    </tr>
    <tr>
        <th>Created date</th><td>{{$result->created_at}}</td>
    </tr>
    </tbody>
</table>
