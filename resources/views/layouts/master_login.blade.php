<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">
    <title>NCARD | Login</title>
    <!-- Custom CSS -->
    <link href="{{asset('public/assets/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/login.css')}}" rel="stylesheet">

    <link href="{{asset('public/assets/css/float-chart.css')}}" rel="stylesheet">

    <link href="{{asset('public/assets/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/custom.css')}}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

    {{--<link href="../../assets/libs/flot/css/float-chart.css" rel="stylesheet">--}}
    <!-- Custom CSS -->

    {{--<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements--}}
    @yield('stylesheets')
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
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
    {{--<div class="page-wrapper page-login">--}}

        @yield('content')

    {{--</div>--}}
</div>

<!-- All Jquery -->
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
<script src="{{asset('public/assets/js/custom.min.js')}}"></script>
<script src="{{asset('public/assets/js/formValidation.js')}}"></script>


@yield('scripts')
</body>
</html>
