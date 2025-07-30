
<div class="col-lg-12 table-margin-top">

    <table class="table table-bordered table-striped">

        <tbody>

        <tr>
            <th>Name</th> <td>{{$result->class_name}}</td>
        </tr>
        <tr>
            <th>Class Code</th> <td>{{$result->class_code}}</td>
        </tr>
        <tr>
            <th>Maximum Account Can Hold</th> <td>{{number_format($result->max_hold_amount,2,'.',',')}}</td>
        </tr>

        <tr>
            <th>Class Currency </th> <td>{{$result->currency}}</td>
        </tr>
        <tr>
            <th>Created Date</th> <td>{{$result->created_at}}</td>
        </tr>

        <tr>
            <th>Status</th> <td>{{$result->status}}</td>
        </tr>

        </tbody>
    </table>


</div>
