
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

                     <div class="card-body">

                         <div class="row">

                             <div class="col-md-6">

                                 <table class="table table-bordered">
                                     <tbody>

                                     <tr>
                                         <th>screen</th><td>{{$config->screen}}</td>
                                     </tr>


                                     <tr>
                                         <th>layout</th><td>{{$config->layout}}</td>
                                     </tr>


                                     <tr>
                                         <th>api</th><td>{{$config->api}}</td>
                                     </tr>


                                     </tbody>
                                 </table>
                             </div>
                             <div class="col-md-6">

                                 <table class="table table-bordered">

                                 <tbody>

                                     <tr>
                                         <th>on_tap</th><td>{{$config->on_tap}}</td>
                                     </tr>


                                     <tr>
                                         <th>column</th><td>{{$config->column}}</td>
                                     </tr>




                                     </tbody>
                                 </table>



                             </div>

                             <a href="{{url('')}}" class="btn btn-info">Edit</a>
                         </div>

                     </div>

             </div>

            </div>

        </div>

    </div>



@stop



@section('js')

    <script>
        $('#merchant-index').dataTable();

    </script>


@stop
