

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
                <h4 class="page-title">Roles</h4>
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

            <div class="col-md-12">
                <div class="card">


                    <form method="post" action="{{url('access/roles/update',$role->id)}}" >
                        {{ csrf_field() }}

                        <div class="card-body">

                            <div class="row">


                                <div class="col-md-12">
                                    <div class="form-group">

                                        <input type="text" class="form-control" name="roleName" value="{{$role->name}}">

                                    </div>

                                </div>

                                <div class="col-md-12">

                                    <table class="table table-striped table-bordered" id="table">

                                        <tbody>

                                        <tr>

                                            <td colspan="12" style="background-color: #31a4ba;color: white;">Select Permissions</td>

                                        </tr>

                                        </tbody>

                                    </table>
                                </div>

                                <div class="col-md-12">

                                    <ul class="rol-perm-list">
                                        @foreach($permissions as  $index=>$permission)

                                            @if($index<6)
                                                <li>
                                        <span class="perm-role-span"><input  type="checkbox" name="permission[]" class="checkbox-custom" value="{{$permission->id}}"

                                                                             @foreach($rolePermissions as $rolep)

                                                                             @if($permission->id==$rolep->permission_id)

                                                                             checked
                                                    @endif
                                                @endforeach

                                            > {{$permission->name}} </span>
                                                </li>

                                            @endif
                                        @endforeach

                                    </ul>
                                </div>

                                <div class="col-md-6">

                                    <ul class="rol-perm-list">
                                        @foreach($permissions as  $index=>$permission)

                                            @if($index>=6)

                                                <li>
                                        <span class="perm-role-span"><input type="checkbox" name="permission[]" class="checkbox-custom" value="{{$permission->id}}"
                                                                            @foreach($rolePermissions as $rolep)

                                                                            @if($permission->id==$rolep->permission_id)

                                                                            checked
                                                    @endif
                                                @endforeach

                                            > {{$permission->name}} </span>
                                                </li>

                                            @endif
                                        @endforeach

                                    </ul>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-12">

                            <div class="col-md-6" style="float: left">
                                <a href="{{url('access/roles')}}" class="btn btn-info">Back</a>

                                <button type="submit" class="btn btn-success">Update</button>


                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



@stop

