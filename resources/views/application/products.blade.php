

<table class="table table-bordered table-striped">


    <tbody>


        <tr>
            <th>Bin number</th><td>{{$result->bin_number}}</td>
            <th>Currency</th><td>{{$result->currency}}</td>

        </tr>

        <tr>
            <th>category</th><td>{{$result->category}}</td>
            <th>Class name</th><td>{{$result->class_name}}</td>

        </tr>

        <tr>
            <th>Product name</th><td>{{$result->product_name}}</td>
            <th>Status</th><td>{{$result->status}}</td>

        </tr>

        <tr>
            <th>Bin length</th><td>{{$result->length}}</td>
            <th>Create date</th><td>{{$result->created_at}}</td>

        </tr>

    <tr>
        <th>Minimum balance</th><td>{{$result->min_balance}}</td>
    </tr>

    </tbody>
</table>
