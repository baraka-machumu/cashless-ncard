

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
           <th>Ticket Ref</th>
           <th>TicketNo</th>
           <th>BatchRef</th>
           <th>Price</th>
           <th>ncard Reference</th>
           <th>Category Code</th>

       </tr>
       </thead>

       <tbody>

       @foreach($result as $index=>$row)

           <tr>
               <td>{{$index+1}}</td>
               <td>{{$row->TicketRef}}</td>
               <td>{{$row->TicketNo}}</td>
               <td>{{$row->BatchRef}}</td>
               <td>{{$row->Price}}</td>
               <td>{{$row->ncard_reference}}</td>
               <td>{{$row->CategoryCode}}</td>

           </tr>

           @endforeach

       </tbody>
   </table>


@section('js')

    <script>

        $('#r-cards-table').dataTable();

    </script>
    @stop
