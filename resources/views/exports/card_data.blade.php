<table>
    <thead>
    <tr>
        <th>CARD_NUMBER</th>
        <th>CARD_UID</th>
    </tr>
    </thead>
    <tbody>
    @foreach($card_data as $row)
        <tr>
            <td>'{{ number_format($row['card_number'], 0, '', '') }}</td>
            <td>{{ $row->card_uid }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
