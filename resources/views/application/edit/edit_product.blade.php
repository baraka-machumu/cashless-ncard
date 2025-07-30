
<div class="col-lg-12 table-margin-top">

    <table class="table table-bordered table-striped">

        <tbody>
        <tr>
            <th>Name</th> <td>{{$result->product_name}}</td>
            <th>Created date </th> <td>{{$result->created_at}} </td>
        </tr>
        <tr>
            <th>Bin number</th> <td>{{$result->bin_number}}</td>
            <th>Currency</th> <td>{{$result->currency_name}}</td>
        </tr>
        <tr>
            <th>Issuance Fee</th> <td>{{$result->issuance_fee}}</td>
            <th>Status</th> <td>{{$result->status}}</td>

        </tr>
        <tr>
            <th>Minimum Balance</th><td>{{$result->min_balance}}</td>
        </tr>
        </tbody>
    </table>


</div>
