@extends('layouts.master')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Adjustment List</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Merchant</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    @endif
                @endforeach

                @can('debit-adjustment')
                <a href="#" class="btn btn-cyan btn-sm" id="ad" data-toggle="modal" data-target="#adjustment">New Adjustment</a>

                    @endcan
            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="agents-all">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Amount</th>
                        <th>Full name</th>
                        <th>Card number</th>
                        <th>Created date</th>
                        <th>Status</th>
                        <th>Agent Code</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;?>
                    @foreach($data as $row)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$row->amount}}</td>
                            <td>{{$row->full_name}}</td>
                            <td>{{$row->card_number}}</td>
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->sname}}</td>
                            <td>{{$row->agent_code}}</td>
                            <td>
                                @if(in_array($row->status,[1,2]))
                                    <span class="badge badge-orange">Completed</span>
                                @else
                                    @can('approve-adjustment')
                                    <button class="btn btn-info adj-btn" id="{{$row->id}}">Approve</button>
                                    @endcan
                                @endif

                            </td>
                        </tr>
                            <?php $i++;?>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('adjustment.ad')
    @include('adjustment.approve')
@stop

@section('js')
    <script>
        $(function (e) {
            $('#agent').hide()
            $('#ncard-d').hide()
            $(document).on('click','.adj-btn',function (r) {
                let $row = $(this).closest('tr');
                // Extract data from the row
                let i = $row.find('td:nth-child(1)').text();
                let amount = $row.find('td:nth-child(2)').text();
                let full_name = $row.find('td:nth-child(3)').text();
                let card_number = $row.find('td:nth-child(4)').text();
                let created_at = $row.find('td:nth-child(5)').text();
                let sname = $row.find('td:nth-child(6)').text();
                // Use the data to populate the modal
                $('#adId').val(this.id);
                $('#amountTx').text(amount);
                $('#adFullName').text(full_name);
                $('#adCard').text(card_number);
                $('#adjustment-app').modal('show');

            })

            $('#source').on('change',function (e) {
                let source = $('#source').val();
                if(source==='AG'){
                    $('#agent').show()
                    $('#ncard-d').hide()
                }else{
                    $('#agent').hide()
                    $('#ncard-d').show()
                }
            })
        })
    </script>
@stop
