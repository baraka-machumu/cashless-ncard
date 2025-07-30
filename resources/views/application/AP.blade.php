<table class="table table-bordered table-striped" id="datatable">

    <thead>
    <tr>

        <th>#</th>
        <th>Application Name</th>
        <th>Maker</th>
        <th>Checker</th>
        <th>Created Date</th>
        <th>Action Status</th>
        <th>Description/Account</th>
        <th>Actions</th>

    </tr>
    </thead>

    <tbody>

    <?php  $i =1;?>
    @foreach($application as $row)

        <tr>

            <td>{{$i}}</td>

            <td>{{$row->application_name}}</td>
            <th>{{$row->first_name.' '.$row->middle_name.' '.$row->last_name}}</th>
            <td></td>
            <td>{{$row->created_at}}</td>
            <td>{{$row->action_status}}</td>
            <td>{{$row->account}}</td>
            <td>

                <a  href="{{url('applications/view',[$row->id,$row->application_type])}}" class="btn btn-info"><i class="fa fa-eye"></i></a>

            </td>

        </tr>
        <?php  $i++;?>

    @endforeach


    </tbody>
</table>
