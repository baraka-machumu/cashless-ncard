@extends('layouts.master')
@section('content')

    <div class="container-fluid">

        <div class="row">

        </div>

        <div class="col-lg-12 show-user-details-2">

            <span>Destroy Wallet Info</span>

        </div>

        <div class="row">

            <div class="col-lg-12 table-margin-top">
                <table class="table table-bordered table-striped" id="consumer-wallet">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Balance</th>
                        <th>Account code</th>
                        <td>Created Date</td>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i= 1;?>
                    @foreach($accounts as $row)
                        <tr>

                            <td>{{$i}}</td>

                            <td>{{$row->name}}</td>
                            <td>{{$row->amount}}</td>
                            <td>{{$row->account_number}}</td>
                            <td>{{$row->created_at}}</td>

                        </tr>
                            <?php $i++;?>

                    @endforeach


                    </tbody>
                </table>

            </div>

        </div>

    </div>


@stop



@section('js')

    <script>
        $('#consumer-wallet').dataTable();

    </script>

@stop
