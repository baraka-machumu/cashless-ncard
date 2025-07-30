
<div class="col-lg-12 table-margin-top">

    <table class="table table-bordered table-striped">

        <tbody>

        <tr>
            <th colspan="2">Role</th>
        </tr>
        <tr>
            <th> name</th> <td>{{$result['role']->name}}</td>
        </tr>
        <tr>
            <th>Created date</th> <td>{{$result['role']->created_at}}</td>
        </tr>
        <tr>
            <th>Created by </th> <td>{{$result['role']->created_at}}</td>
        </tr>

        <tr>

        <th>Permissions</th>
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
        @foreach($result['permissions'] as $index=>$row)

            <tr>
                <td>{{$index+1}}</td>
                <td>{{$row->name}}</td>
            </tr>

        @endforeach
        </tbody>
    </table>


</div>
