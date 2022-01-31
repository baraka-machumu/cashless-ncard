

<table class="table table-bordered" style="margin-top: 10px;">

    <tbody>

    <tr>
        <td>Total </td> <td style="font-weight: bold; font-size: 17px;">{{count($result)}}</td>
    </tr>

    </tbody>
</table>

   <table class="table table-bordered table-striped" id="r-cards-table">

       <thead>
       <tr>

           <th>#</th>
          <th>Card Number</th>
           <th>Wallet Number</th>
           <th>First Name</th>
           <th>Last Name</th>
           <th>Phone Number</th>
           <th>Registered By</th>
           <th>Registered Date</th>

       </tr>
       </thead>

       <tbody>

       @foreach($result as $index=>$row)

           <tr>
               <td>{{$index+1}}</td>
               <td>{{$row->card_number}}</td>
               <td>{{$row->consumer_wallet_id}}</td>
               <td>{{$row->first_name}}</td>
               <td>{{$row->last_name}}</td>
               <td>{{$row->phone_number}}</td>
               <td>{{$row->agent_code}}</td>
               <td>{{$row->createdDate}}</td>

           </tr>

           @endforeach

       </tbody>
   </table>


@section('js')

    <script>

        $('#r-cards-table').dataTable();

    </script>
    @stop
