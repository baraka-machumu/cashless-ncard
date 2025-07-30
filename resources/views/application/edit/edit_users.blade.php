
<div class="col-lg-12 table-margin-top">

    <table class="table table-bordered table-striped">

        <tbody>

        <tr>
            <th>First name</th> <td>{{$result['user']->first_name}}</td>
        </tr>
        <tr>
            <th>Initial name</th> <td>{{$result['user']->middle_name}}</td>
        </tr>
        <tr>
            <th>Last name</th> <td>{{$result['user']->last_name}}</td>
        </tr>
        <tr>
            <th>Phone number</th> <td>{{$result['user']->phone_number}}</td>
        </tr>
        <tr>
            <th>Created at</th><td>{{$result['user']->created_at}}</td>
        </tr>

        <tr>
            <th>Branch name</th><td>{{$result['user']->branch_name}}</td>
        </tr>
        <tr>
            <th>Role Action Type</th><td>{{$result['user']->role_action}}</td>
        </tr>

        </tbody>
    </table>


    <table class="table table-bordered table-striped">

        <thead>

        <tr>

            <th>No</th>
            <th>Name</th>

        </tr>
        </thead>

        <tbody>

        @foreach($result['role'] as $index=>$row)

            <tr>
                <td>{{$index+1}}</td>
                <td>{{$row->name}}</td>
            </tr>

        @endforeach
        </tbody>

    </table>



</div>
