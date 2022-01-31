
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span>{{mb_strtoupper(substr($profile->name,0,1))}}</span>
                </div>
                <h4 class="page-title">{{$profile->name}}</h4>

                <div class="ml-auto text-right">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        {{--<div class="col-lg-12 show-user-details-2">--}}

            {{--<span>Prifile  Info</span>--}}

        {{--</div>--}}

        <div class="row">


            <div class="col-lg-12">

                <button id="{{$profile->id}}" class="btn btn-success profile-btn"> Add permission</button>

                <table class="table table-striped">

                    <thead>

                   <tr>
                       <th>#</th>
                       <th>Permission Name</th>

                       <th>Status</th>
                       <th>Actions</th>

                   </tr>


                    </thead>

                    <tbody>


                    <?php $i = 1;?>
                    @foreach($profilePermissions as $profilePermission)

                        @if($profilePermission->status_id===1)

                            <?php  $status ='Active'?>

                            @else
                            <?php  $status ='Inactive'?>


                        @endif
                        <tr>

                        <td>{{$i}}</td>
                        <td>{{$profilePermission->permission_name}}</td>
                        <td>{{$status}}</td>
                            <td><a href=""><i class="fa fa-trash"></i></a></td>

                    </tr>
                        <?php $i++;?>

                        @endforeach


                    </tbody>
                </table>

                <a href="{{url()->previous()}}" class="btn btn-info">Back</a>

            </div>



        </div>

    </div>

    <!-- Modal  profile permissions-->
    <div class="modal fade bd-example-modal-lg" id="assign-permissions-profile-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="{{url('access/assign/permission')}}">

            {{csrf_field()}}

            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Create Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">


                                            <div class="col-md-12">

                                                <div class="form-group">


                                                    <input type="hidden" value="" class="profile_id" name="profile_id">
                                                    <table class="table table-bordered">

                                                        <thead>

                                                        <tr>
                                                            <th>select</th>
                                                            <th>Permission Name</th>

                                                        </tr>
                                                        </thead>

                                                        <tbody>

                                                        @foreach($permissions as $permission)

                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" value="{{$permission['id']}}" name="permissions[]">

                                                                </td>

                                                                <td>{{$permission['name']}}</td>

                                                            </tr>

                                                            @endforeach


                                                        </tbody>

                                                    </table>

                                                </div>


                                            </div>


                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>

    </div>

@stop