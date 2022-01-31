
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

    {{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">--}}
@stop

@section('content')


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

                <div class="row">
                    <div class="col-md-4" >
                        <div class="form-group">

                            <label>N-CARD ACCOUNT</label>

                            <select type="text" class="form-control" id="accountNumber" name="accountNumber">

                                <option value="" selected disabled>--select account ---</option>
                                @foreach($account as $row)

                                    <option  value="{{$row->wallet_number}}">{{$row->name}}</option>

                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="col-md-2">

                        <div class="form-group" style=" margin-top: 30px;">

                            <button type="button" id="btn-check-balance" class="btn btn-primary mdi mdi-search-web">Check Balance</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    @include('tpesa.check_balance')
@stop


@section('js')

    <script>

        $(function (){

            let urlBalance  =  '{{url('t-pesa/check-balance')}}';

            console.log(urlBalance)
            $('.img-load').hide();

            $('#btn-check-balance').click( function (){

                $('.balance-res').html("")

                $('#show-balance-modal').modal('show');
                $('.img-load').show();

                let accountNumber  =  $('#accountNumber').val();

                $.get(urlBalance+'/'+accountNumber, function (data){
                    console.log('result');
                    console.log(data);

                    if (data.resultcode=='0'){
                        $('.img-load').hide();

                        $('.balance-res').html('Balance is '+data.balance+' TZS')

                    } else {
                        $('.img-load').hide();

                        $('.balance-res').html(data.message)

                    }
                    console.log(data);

                });

            });



        });
    </script>
@stop
