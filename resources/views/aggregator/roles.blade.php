
@extends('layouts.master')
@section('stylesheets')
    <style>

        .checkbox-custom {

            height: 15px;
            width: 60px;
            margin-left: 0;
        }

        .perm-role-span {
            height: 10px;
            width: 70px;
            margin-left: 0;
            margin-top: -2px;
        }
        .rol-perm-list{

            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        ul {
            list-style-type: none;
        }
        . .rol-perm-list li {

            list-style-type: none;
        }
    </style>
@stop


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Agent Permission</h4>
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

                {{--<div class="col-md-3">--}}

               <a href="#" class="btn btn-cyan btn-sm" id="" data-toggle="modal" data-target="#assign-permission">Assign Permission</a>

                    <hr/>


            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="agents-all">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Permission Name</th>
                        <th>Permission Code</th>

                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php $i=1;?>
                    @foreach($permission as $row)
                        <tr>

                            <td>{{$i}}</td>
                            <td>{{$row->pname}}</td>

                            <td>{{$row->pos_permission_id}}</td>

                            <td>{{$row->status_name}}</td>

                            <td style="width: 300px;">

                                <a href="#" id="{{$agent_code}}"  data-id="{{ $agent_code}}" class="btn btn-success edit-agent-modal"><i class="fa fa-edit"></i></a>
                                <a href="#" id="{{$row->pos_permission_id}}"  data-toggle="modal" data-target="#delete-permission" class="btn btn-danger delete-permission"><i class="fa fa-trash"></i></a>



                            </td>

                        </tr>
                        <?php $i++;?>

                    @endforeach


                    </tbody>
                </table>

            </div>

        </div>

    </div>



    @include('agents.assign-permission-modal')

    @include('agents.delete-permission-modal')




@stop


@section('js')

    <script>
        $('#agents-all').dataTable();


        $('.delete-permission').on('click', function (){

            let id   = this.id;
            $('#posId').val(id);

            $('#delete-permission').modal('show');

        });


    </script>


    @stop
