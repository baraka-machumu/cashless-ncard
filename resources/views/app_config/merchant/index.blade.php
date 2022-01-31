
@extends('layouts.master')


@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Merchant application layout</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page"></li>
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


            </div>

            <div class="col-lg-12 table-margin-top">


             <div class="card">

                 <div class="col-md-12">
                     <div class="form-group">

                         <label>Screen Type</label>

                         <select type="text" name="screen_type" id="screen-type" class="form-control">

                             <option selected disabled>--select --</option>
                             <option value="SCREEN">SCREEN</option>
                             <option value="DIALOG">DIALOG</option>

                         </select>

                     </div>
                 </div>

                 <form method="post" action="{{url('merchants/config',$merchantTin)}}">

                     @csrf

                     <div class="card-body">

{{--                             <div class="row">--}}

                                 <div class="screen form-row">

                                     <div class="col-md-6">

                                         <div class="form-group">

                                             <label>Node Type</label>

                                             <select type="text" name="type" class="form-control">
                                                 <option value="PARENT">PARENT</option>
                                                 <option value="CHILD">CHILD</option>

                                             </select>

                                         </div>
                                         <div class="form-group">

                                             <label>Screen</label>
                                             <input type="text" name="screen" class="form-control">

                                         </div>

                                         <div class="form-group">

                                             <label>api</label>
                                             <input type="text" name="api" class="form-control">

                                         </div>

                                         <div class="form-group">

                                             <label>on_tap</label>
                                             <input type="text" name="on_tap" class="form-control">

                                         </div>
                                     </div>

                                     <div class="col-md-6">
                                         <div class="form-group">

                                             <label>layout</label>
                                             <input type="text" name="layout" class="form-control">

                                         </div>

                                         <div class="form-group">

                                             <label>api_method</label>
                                             <input type="text" name="api_method" class="form-control">

                                         </div>

                                         <div class="form-group">

                                             <label>column</label>
                                             <input type="text" name="column" class="form-control">

                                         </div>
                                     </div>

                                 </div>

                                 <div class="dialog form-row">
                                     <div class="col-md-12">

                                         <div class="form-group">

                                             <label>Node Type</label>

                                             <select type="text" name="type" class="form-control">
                                                 <option value="PARENT">PARENT</option>
                                                 <option value="CHILD">CHILD</option>

                                             </select>

                                         </div>
                                         <div class="form-group">

                                             <label>Screen</label>
                                             <input type="text" name="screen" class="form-control">

                                         </div>

                                     </div>

                                     <div class="col-md-12">
                                         <div class="form-group">

                                             <label>Title</label>
                                             <input type="text" name="title" class="form-control">

                                         </div>

                                         <div class="form-group">

                                             <label>Sub title</label>
                                             <input type="text" name="subtitle" class="form-control">

                                         </div>

                                         <div class="form-group">

                                             <label>max_lenth</label>
                                             <input type="text" name="max_lenth" class="form-control">

                                         </div>
                                         <div class="form-group">

                                             <label>Input Type</label>
                                             <input type="text" name="input_type" class="form-control">

                                         </div>
                                     </div>

                                 </div>

                                 <div class="form-group">

                                     <button class="btn btn-success">Save</button>
                                 </div>
{{--                             </div>--}}


                     </div>


                 </form>

             </div>

            </div>

        </div>

    </div>



@stop



@section('js')

    <script>


        $('.screen').hide();
        $('.dialog').hide();


        $('#screen-type').change( function (evt){


            let value =   $('#screen-type').val();

           if (value=='DIALOG'){

               $('.dialog').show();
               $('.screen').hide();

           }

           else {
               $('.screen').show();
               $('.dialog').hide();

           }


        })  ;

        $('#merchant-index').dataTable();

    </script>


@stop
