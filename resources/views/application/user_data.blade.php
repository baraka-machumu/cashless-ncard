

<table class="table table-bordered table-striped">


    <tbody>


        <tr>
            <th>First name</th><td>{{$result->first_name}}</td>
        </tr>
        <tr>
            <th>Middle name</th><td>{{$result->middle_name}}</td>
        </tr>

        <tr>
            <th>Last name</th><td>{{$result->last_name}}</td>
        </tr>
        <tr>
            <th>Gender</th><td>{{$result->gender_name}}</td>
        </tr>
        <tr>
            <th>Email</th><td>{{$result->email}}</td>
        </tr>

        <tr>
            <th>Phone number</th><td>{{$result->phone_number}}</td>
        </tr>
        <tr>
            <th>Created date</th><td>{{$result->created_at}}</td>
        </tr>
        <tr>
            <th>Branch</th><td>{{$result->branch}}</td>
        </tr>

        <tr>
            <th>Role Action Type</th><td>{{$result->role_action}}</td>
        </tr>

    </tbody>
</table>


<table class="table table-bordered table-striped">


 <tbody>

 <tr>
     <td>Role(s)</td>
 </tr>
 @foreach($roles as $row)

     <tr>
         <td>{{$row->role_name}}</td>
     </tr>

 @endforeach
 </tbody>
</table>
