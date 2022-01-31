<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('public/assets/images/ncard.ico')}}">

    <link rel="shortcut icon" type="image/x-icon"  href="{{asset('public/assets/images/ncard.ico')}}">

    <!-- Custom CSS -->
    <link href="{{asset('public/assets/css/select2.min.css')}}" rel="stylesheet">

    <link href="{{asset('public/assets/css/datatables.css')}}" rel="stylesheet">


    <link href="{{asset('public/assets/css/style.min.css')}}" rel="stylesheet">




    <link href="{{asset('public/assets/css/float-chart.css')}}" rel="stylesheet">

    <link href="{{asset('public/assets/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/custom.css')}}" rel="stylesheet">

    <link href="{{asset('public/assets/css/typeahead.min.css')}}" rel="stylesheet">


    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

    <!-- {{--<link href="../../assets/libs/flot/css/float-chart.css" rel="stylesheet">--}} -->
    <!-- Custom CSS -->

    @yield('stylesheets')
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>



    <style>

        .loading {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 2;
            cursor: pointer;
        }

        .loading img{

            width: 50px;
            height: 50px;
            /*margin-left: 50%;*/
            margin-top: 20%;
            float: left;
        }

        .loading span{

            width: 100px;
            height: 50px;
            display: block;
            /*margin-left: 20%;*/
            margin-top: 20%;
            /*line-height: 40%;*/
            color: white;
            float: left;

        }

        .inner-load{

            margin-left: 35%;

        }
        ::placeholder {
            color: red;
            opacity: 1; /* Firefox */
        }

        :-ms-input-placeholder { /* Internet Explorer 10-11 */
            color: red;
        }

        ::-ms-input-placeholder { /* Microsoft Edge */
            color: red;
        }
    </style>
</head>
<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<div id="main-wrapper">
    @include('partials.header')
    @include('partials.sidebar')
    <div class="page-wrapper">

        @yield('content')

    </div>
</div>

<!-- All Jquery -->\
<!-- ============================================================== -->
<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>


<script src="{{asset('public/assets/js/admin.js')}}"></script>

<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('public/assets/js/popper.min.js')}}"></script>
<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>



<script src="{{asset('public/assets/js/perfect-scrollbar.jquery.min.js')}}"></script>
{{--<script src="../../assets/extra-libs/sparkline/sparkline.js"></script>--}}
<!--Wave Effects -->
<script src="{{asset('public/assets/js/waves.min.js')}}"></script>


{{--<script src="../../dist/js/waves.min.js"></script>--}}
<!--Menu sidebar -->
<script src="{{asset('public/assets/js/sidebarmenu.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{asset('public/assets/js/typeahead.min.js')}}"></script>

<script src="{{asset('public/assets/js/custom.min.js')}}"></script>

<script src="{{asset('public/assets/js/select2.full.min.js')}}"></script>
<script src="{{asset('public/assets/js/select2.min.js')}}"></script>

<script src="{{asset('public/assets/js/formValidation.js')}}"></script>
<script src="{{asset('public/assets/js/customization.js')}}"></script>
<script src="{{asset('public/assets/js/second_customization_file.js')}}"></script>

<script src="{{asset('public/assets/js/merchant_users.js')}}"></script>
<script src="{{asset('public/assets/js/agents.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
<script src="{{asset('public/assets/js/validatorForm.min.js')}}"></script>

<script src="{{asset('public/assets/js/consumer-live-data.js')}}"></script>

<script src="{{asset('public/assets/js/datatables.min.js')}}"></script>


<script type="text/javascript">


    let district_url  =  '{{url('districts/get-all')}}';


    let  agentGetAllPos=   '{{url('agents/getall/pos')}}';


$("#viewParams").change(function() {

if ($(this).val() == "1") {
$('#viewParamsDiv').show();


} else {
$('#viewParamsDiv').hide();

    $('.uncheck').prop('checked',false);

}
});
$("#viewParams").trigger("change");

    $("#viewParams2").change(function() {
        if ($(this).val() == "1") {
            $('#viewParamsDiv2').show();

        } else {
            $('#viewParamsDiv2').hide();

        }
    });
    $("#viewParams2").trigger("change");

    $('#users-table').dataTable();

</script>


@yield('js')
</body>
</html>
