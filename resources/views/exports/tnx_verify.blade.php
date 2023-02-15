<table>
    <thead>
    <tr>
        <th>REFNO</th>
        <th>PHONENO</th>
        <th>AMOUNT</th>
        <th>CHANNEL_REF_NO</th>
        <th>TNX_DATE</th>
        <th>CHANNEL</th>
        <th>STATUS</th>

    </tr>
    </thead>
    <tbody>
    @foreach($tnx_verify as $row)
        <tr>
            <td>{{ $row->ref_number }}</td>
            <td>{{ $row->phone_number }}</td>
            <td>{{ $row->amount }}</td>
            <td>{{ $row->channel_ref_no }}</td>
            <td>{{ $row->tnx_date }}</td>
            <td>{{ $row->channel }}</td>

            <td>
                @if($row->status=='SUCCESSFUL')
                    <p style="color: darkgreen">{{$row->status}}</p>
                @else
                    <p style="color: red">{{$row->status}}</p>

                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
