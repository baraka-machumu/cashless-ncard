

<table class="table table-bordered table-striped">


    <tbody>


        <tr>
            <th>Role name</th><td>{{$result->name}}</td>
        </tr>
        <tr>
            <th>Created date</th><td>{{$result->created_at}}</td>
        </tr>


    </tbody>
</table>


<table class="table table-bordered table-striped">


 <tbody>

 <tr>
     <td>Permission(s)</td>
 </tr>
 @foreach($permission as $index=>$row)

     <tr>
         <td><span style="margin-right: 3px;">{{$index+1}} . </span> {{$row->p_name}}</td>
     </tr>

 @endforeach
 </tbody>
</table>
