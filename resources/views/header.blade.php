<!DOCTYPE html>
<html lang="en">

<head>

    <!-- google analytics tag -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172016689-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-172016689-1');
    </script>

    <meta charset="utf-8" />
    <title>{{$pageTitle}}</title>
    <meta name="title" content="InaExport">
    <meta name="description" content="InaExport as a media product digital promotion superior export products from Indonesian business people, so they can more easily reach out to foreign buyers.">
    <meta name="keywords" content="inaexport, exporter, importer, buying request, inquiry, kemendag, trade, promotion, products, business, indonesia, ina, Export,InaExport">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ asset('front/assets/img/iconkemendag.png') }}">
    <meta name="apple-mobile-web-app-title" content="Flatkit">
    <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" sizes="196x196" href="{{ asset('front/assets/img/iconkemendag.png') }}">


    <!-- corousel -->
    <link rel="stylesheet" href="{{ url('/') }}/css/w3.css">
    <style>
        .mySlides {
            display: none;
        }

        table,
        th,
        tr,
        td {
            text-align: left;
        }

        .nav-item.nav-with-child>.nav-item-child {
            list-style: none;
            height: 0;
            min-height: 0px;
            overflow: hidden !important;
            padding: 0px 1.5rem;
            transition: all 0.5s ease-in-out;
            margin-left: 25px;
        }

        .nav-item.nav-with-child.nav-item-expanded>.nav-item-child {
            padding: 0.5rem 1.5rem;
            position: relative;
            height: auto;
            min-height: 50px;
            display: block;
            transition: all 0.5s ease-in-out;
        }
    </style>
    <!-- style -->
    <!--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
        <script src="custom_tags_input.js"></script>
    -->

    <!-- <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css" type="text/css" /> -->
    <link rel="stylesheet" href="{{ url('assets') }}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />

    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="{{ url('assets') }}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets') }}/assets/css/app.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets') }}/assets/css/style.css" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{ url('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" type="text/css" />


    <!-- Favicon -->
    <link rel="icon" href="{{ asset('front/assets/img/iconkemendag.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/css/dash.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/css/argon.css?v=1.2.0') }}" type="text/css">

    <!-- build:js scripts/app.min.js -->
    <!-- jQuery -->
    <script src="{{ url('assets') }}/libs/jquery/dist/jquery.min.js"></script>
    <!-- Highchart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <!-- InputMask -->
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <!-- Bootstrap -->
    <script src="{{ url('assets') }}/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="{{ url('assets') }}/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- core -->
    <?php if (Request::segment(2) != "chatting" && Request::segment(1) != "br_pw_chat" && Request::segment(1) != "br_chat") { ?>
        <script src="{{ url('assets') }}/libs/pace-progress/pace.min.js"></script>
    <?php } ?>
    <script src="{{ url('assets') }}/libs/pjax/pjax.js"></script>

    {{-- <script src="{{ url('assets') }}/libs/datatables/media/js/jquery.dataTables.min.js"></script> --}}

    <script src="{{ url('assets') }}/html/scripts/lazyload.config.js"></script>
    <script src="{{ url('assets') }}/html/scripts/lazyload.js"></script>
    <script src="{{ url('assets') }}/html/scripts/plugin.js"></script>
    <script src="{{ url('assets') }}/html/scripts/nav.js"></script>
    <script src="{{ url('assets') }}/html/scripts/scrollto.js"></script>
    <script src="{{ url('assets') }}/html/scripts/toggleclass.js"></script>
    <script src="{{ url('assets') }}/html/scripts/theme.js"></script>
    <script src="{{ url('assets') }}/html/scripts/ajax.js"></script>
    <script src="{{ url('assets') }}/html/scripts/app.js"></script>

    {{-- DATA TABLE --}}
    <script src="{{ url('assets') }}/libs/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="{{ url('assets') }}/html/scripts/plugins/datatable.js"></script>

    {{-- FUSION CHART --}}
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script type="text/javascript" src="{{ url('assets') }}/libs/fusion-chart/Maps/fusioncharts.worldwithcountries.js"></script>

    <script type="text/javascript">
        FusionCharts.ready(function() {
            var chartObj = new FusionCharts({
                type: 'maps/world',
                renderAt: 'chart-container',
                width: '600',
                height: '400',
                dataFormat: 'json',
                dataSource: {
                    "chart": {
                        "caption": "Global Population",
                        "theme": "fusion",
                        "formatNumberScale": "0",
                        "numberSuffix": "M"
                    },
                    "colorrange": {
                        "color": [{
                            "minvalue": "0",
                            "maxvalue": "100",
                            "code": "#D0DFA3",
                            "displayValue": "< 100M"
                        }, {
                            "minvalue": "100",
                            "maxvalue": "500",
                            "code": "#B0BF92",
                            "displayValue": "100-500M"
                        }, {
                            "minvalue": "500",
                            "maxvalue": "1000",
                            "code": "#91AF64",
                            "displayValue": "500M-1B"
                        }, {
                            "minvalue": "1000",
                            "maxvalue": "5000",
                            "code": "#A9FF8D",
                            "displayValue": "> 1B"
                        }]
                    },
                    "data": [{
                        "id": "NA",
                        "value": "515"
                    }, {
                        "id": "SA",
                        "value": "373"
                    }, {
                        "id": "AS",
                        "value": "3875"
                    }, {
                        "id": "EU",
                        "value": "727"
                    }, {
                        "id": "AF",
                        "value": "885"
                    }, {
                        "id": "AU",
                        "value": "32"
                    }]
                }
            });
            chartObj.render();
        });
    </script>

    {{-- HIGHCHART --}}
    <script src="http://code.highcharts.com/maps/modules/map.js"></script>
    <script src="https://code.highcharts.com/mapdata/index.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script src="https://www.highcharts.com/samples/static/jquery.combobox.js"></script>
    <script src="http://code.highcharts.com/mapdata/custom/world.js"></script>

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <script src="{{ url('/') }}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#example1').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

            $('#example2').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

            $('#yahoo').DataTable({

            });

            $('.select2').select2();
        });
    </script>


</head>

<body style="background-color: #fff !important; ">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    <!-- ############ Aside END-->
    @include('menu2')

    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header  align-items-center">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="{{ url('/assets/assets/images/logonew.png') }}" class="navbar-brand-img">
                </a>
            </div>
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center  ml-md-auto " >
                <li class="nav-item d-xl-none">
                    <!-- Sidenav toggler -->
                    <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </li>
            </ul>
            @include('menu')