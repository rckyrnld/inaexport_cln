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
    <title>{{ isset($pageTitle) == true ? $pageTitle : 'InaExport' }}</title>
    <meta name="title" content="InaExport">
    <meta name="description"
        content="InaExport as a media product digital promotion superior export products from Indonesian business people, so they can more easily reach out to foreign buyers.">
    <meta name="keywords"
        content="inaexport, exporter, importer, buying request, inquiry, kemendag, trade, promotion, products, business, indonesia, ina, Export,InaExport">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="../assets/images/logo.svg">
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

        /* Custom Background
        .bg-custom {
            background-color: #239BAB
        } */

        .dataTables_paginate {
            padding-top: 0.5rem;
        }

        .dataTables_processing {
            /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#ffa84c+0,ff7b0d+100;Orange+3D */
            background: rgb(255, 168, 76);
            /* Old browsers */
            background: -moz-linear-gradient(top, rgba(255, 168, 76, 1) 0%, rgba(255, 123, 13, 1) 100%);
            /* FF3.6-15 */
            background: -webkit-linear-gradient(top, rgba(255, 168, 76, 1) 0%, rgba(255, 123, 13, 1) 100%);
            /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, rgba(255, 168, 76, 1) 0%, rgba(255, 123, 13, 1) 100%);
            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffa84c', endColorstr='#ff7b0d', GradientType=0);
            /* IE6-9 */
            color: white;
            font-weight: bold;
        }

        td {
            color: #525f7f !important;
            font-size: 13px !important;
        }

        .navbar-vertical.navbar-expand-xs .navbar-collaps {
            margin-left: -2rem !important;
        }

        .navbar-vertical.navbar-expand-xs .navbar-nav .nav-link {
            padding: 0.1rem 0.1rem 0.1rem 0.5rem !important;
        }

        .body-dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
        }

    </style>

    @yield('content_style')
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">

    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="{{ url('assets') }}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets') }}/assets/css/app.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets') }}/assets/css/style.css" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{ url('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
        type="text/css" />
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css"> --}}


    {{-- <link rel="icon" type="image/png" href="{{ asset('css/login/images/icons/favicon.ico') }}" /> --}}
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('front/assets/img/iconkemendag.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/css/dash.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/vendor/@fortawesome/fontawesome-free/css/brands.min.css') }}" type="text/css">

    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/css/argon.css?v=1.2.0') }}" type="text/css">

    <!-- build:js scripts/app.min.js -->
    <!-- Highchart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <!-- jQuery -->
    <script src="{{ url('assets') }}/libs/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('css/dashboard/vendor/@fortawesome/fontawesome-free/js/brands.min.js') }}"></script>

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <!-- InputMask -->
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <!-- Bootstrap -->
    <!-- <script src="{{ url('assets') }}/libs/popper.js"></script> -->
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

    <script src="{{ url('assets') }}/libs/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="{{ url('assets') }}/html/scripts/plugins/datatable.js"></script>

    @yield('section_script')

    <script src="https://code.highcharts.com/maps/modules/map.js"></script>
    {{-- <script src="https://code.highcharts.com/maps/highmaps.js"></script> --}}
    <script src="https://code.highcharts.com/mapdata/index.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script src="https://www.highcharts.com/samples/static/jquery.combobox.js"></script>
    <script src="https://code.highcharts.com/mapdata/custom/world.js"></script>

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <script src="{{ url('/') }}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#example1').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });

            $('#example2').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });

            $('#yahoo').DataTable({

            });

            $('.select2').select2();
        });
    </script>

    <style>
        /* Customize website's scrollbar like Mac OS
Not supports in Firefox and IE */

        /* total width */
        ::-webkit-scrollbar {
            background-color: #fff;
            width: 16px;
        }

        /* background of the scrollbar except button or resizer */
        ::-webkit-scrollbar-track {
            background-color: #fff;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #666;
        }

        /* scrollbar itself */
        ::-webkit-scrollbar-thumb {
            background-color: #babac0;
            border-radius: 16px;
            border: 4px solid #fff;
        }

        /* set button(top and bottom of the scrollbar) */
        ::-webkit-scrollbar-button {
            display: none;
        }

        /* ::-webkit-resizer {
            background: #111;
        } */

        ::-webkit-scrollbar-track {
            background-color: #fff;
        }

        .nameco {
            font-size: 16px;
        }

    </style>

</head>

<body style="background-color: #fff !important; ">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    <!-- ############ Aside END-->
    @include('menu2')

    <div class="main-content" id="panel">
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-gradient-info">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Search form -->
                    {{-- <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                        <div class="form-group mb-0">
                            <div class="input-group input-group-alternative input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input class="form-control" placeholder="Search" type="text">
                            </div>
                        </div>
                        <button type="button" class="close" data-action="search-close"
                            data-target="#navbar-search-main" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </form> --}}
                    <div class="col-lg-6 col-md-9 col-sm-9 col-xs-9">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ url('home') }}">Dashboards</a></li>
                                @if (Request::segment(2) != null)
                                    @if (strlen(Request::segment(2)) > 20)
                                        <li class="breadcrumb-item active" aria-current="page">{!! Request::segment(1) !!}
                                        </li>
                                    @else
                                        <li class="breadcrumb-item active" aria-current="page">{!! Request::segment(1) !!} /
                                            {!! Request::segment(2) !!}</li>
                                    @endif
                                @else
                                    <li class="breadcrumb-item active" aria-current="page">{!! Request::segment(1) !!}
                                    </li>
                                @endif
                            </ol>
                        </nav>
                    </div>



                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center  ml-md-auto " style="margin-right: -15px;">
                        <li class="nav-item d-xl-none">
                            <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                                data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <!-- notif -->
                        @php
                            $no = 1;
                            $datanya_notif = getTableNotif(Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id);
                            $data_modal = getTableNotifModal(Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id);
                            $count = countNotif(Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id);
                            
                        @endphp
                        <li class="nav-item dropdown" style="display: none;">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ni ni-bell-55"></i>
                                <span id="jumlah_notif" style="display:none;">{{ $count }}</span>
                                <span class="jumlah_notif"
                                    style="position: absolute;top: -15px;right: 2px;padding: 1px 9px;border-radius: 50%;background: red;color: white;width:22px;">{{ $count }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0">
                                <!-- Dropdown header -->
                                <div class="px-3 py-3">
                                    <h6 class="text-sm text-muted m-0">You have <strong
                                            class="text-primary jumlah_notif">{{ $count }}</strong>
                                        notifications.</h6>
                                </div>
                                <!-- List group -->
                                <div class="body-dropdown-menu">
                                    @foreach ($datanya_notif as $dn)
                                        <div class="list-group list-group-flush">
                                            <?php
                                            if (isset(Auth::guard('eksmp')->user()->id)) {
                                                if (Auth::guard('eksmp')->user()->id_role == 2) {
                                                    $url = url('/chat_admin_eks_imp/' . encrypt($dn->dari_id) . '/' . encrypt($dn->untuk_id) . '?id_notif=' . encrypt($dn->id_notif));
                                                } else {
                                                    $url = url('/chat_admin_eks_imp/' . encrypt($dn->untuk_id) . '/' . encrypt($dn->dari_id) . '?id_notif=' . encrypt($dn->id_notif));
                                                }
                                            } else {
                                                $url = url('/chat_admin_eks_imp/' . encrypt($dn->untuk_id) . '/' . encrypt($dn->dari_id) . '?id_notif=' . encrypt($dn->id_notif));
                                            }
                                            
                                            ?>
                                            <a href="{{ $url }}"
                                                class="list-group-item list-group-item-action">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <!-- Avatar -->
                                                        <!-- <img alt="Image placeholder" src="{{ url('/assets/assets/images/team-1.jpg') }}" class="avatar rounded-circle"> -->
                                                    </div>
                                                    <div class="col ml--2 pb-2" style="font-family: roboto ;  ">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                @php
                                                                    $nama_company = $dn->admin != null ? $dn->admin->nama : ($dn->company != '' ? ($dn->company->profile != null ? $dn->company->profile->company : $dn->company->profile_buyer->company) : '');
                                                                    $hasil_name = strlen($nama_company) > 50 ? substr($nama_company, 0, 50) . '...' : $nama_company;
                                                                @endphp
                                                                <h4 class="mb-0 text-sm">{{ $hasil_name }}
                                                                </h4>
                                                            </div>
                                                            <div class="text-right font-weight-bold"
                                                                style="font-family: roboto ;  ">
                                                                <small>{{ date('d F Y', strtotime($dn->waktu)) }}</small>
                                                            </div>
                                                        </div>
                                                        <p class="text-sm mb-0" style="font-family: roboto ;  ">
                                                            {{ $dn->keterangan }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- View all -->
                                <button data-toggle="modal" data-target="#modal-view-notif"
                                    class="dropdown-item text-center text-primary font-weight-bold py-3">View
                                    all</button>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" id="toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder"
                                            src="{{ url('/assets/assets/images/team-1.jpg') }}">
                                    </span>
                                    {{-- <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user() != '' ? Auth::user()->name : (Auth::guard('eksmp') != '' ? Auth::guard('eksmp')->user()->email : '') }}</span>
                                    </div> --}}
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right " id="drop">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <div class="dropdown-divider"></div>
                                {{-- <a href="{{ url('front_end/ticketing_support/list') }}" class="dropdown-item" --}}
                                {{-- target="_blank"> --}}
                                {{-- <i class="ni ni-user-run"></i> --}}
                                {{-- <span>Support</span> --}}
                                {{-- </a> --}}
                                @if (Auth::guard('eksmp')->user() != null)
                                    <a href="{{ url('perusahaan') . '/' . Auth::guard('eksmp')->user()->id }}"
                                        class="dropdown-item">
                                        <i class="ni ni-circle-08"></i>
                                        <span>View Profile</span>
                                    </a>
                                @elseif(Auth::user()->id_group == 1 || Auth::user()->id_group == 11)

                                @else
                                    <a href="{{ url('editperwakilan') . '/' . Auth::user()->id }}"
                                        class="dropdown-item">
                                        <i class="ni ni-circle-08"></i>
                                        <span>View Profile</span>
                                    </a>
                                @endif

                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item">

                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
        <div class="header bg-gradient-info pb-6">
            <div class="container-fluid">
                <div class="row">
                    <div class="media-body ml-5 d-none d-lg-block" style="margin-top: -0.2rem">
                        <span class="mb-0 text-md font-weight-bold nameco">Welcome,
                            @if (Auth::guard('eksmp')->user() != '')
                                @if (Auth::guard('eksmp')->user()->id_role == '2')
                                    {{ getCompanyName(Auth::guard('eksmp')->user()->id) }}.
                                @elseif(Auth::guard('eksmp')->user()->id_role == '3')    
                                    {{ getCompanyNameImportir(Auth::guard('eksmp')->user()->id) }}.
                                @endif
                            @else
                                @if (Auth::user() != '')
                                    @if (Auth::user()->username != '')
                                        {{ Auth::user()->username }}.
                                    @else
                                        {{ Auth::user()->name }}.
                                    @endif
                                @endif
                            @endif</span>
                    </div>
                </div>
                <div class="header-body">
                    <div class="row align-items-center py-3">
                        {{-- <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Dashboards</a></li>
                        @if (Request::segment(2) != null)
                        <li class="breadcrumb-item active" aria-current="page">{!! Request::segment(1) !!} /
                            {!! Request::segment(2) !!}</li>
                        @else
                        <li class="breadcrumb-item active" aria-current="page">{!! Request::segment(1) !!}
                        </li>
                        @endif
                        </ol>
                        </nav>
                    </div> --}}
                    </div>
                </div>
                @yield('card-dashboard')
            </div>
        </div>
        <input type="hidden" id="jenis_auth" value="<?php echo Auth::user() != '' ? 'admin' : 'company'; ?>">
        <input type="hidden" id="id_admin_satu" value="<?php echo Auth::user() != '' ? Auth::user()->id : ''; ?>">
        <input type="hidden" id="id_company_satu" value="<?php echo Auth::user() != '' ? '' : Auth::guard('eksmp')->user()->id; ?>">
        <div class="container-fluid mt--6">

            @yield('content')
            <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
            <script>
                $(function() {
                    var jenis_auth = $('#jenis_auth').val();
                    var a = ($('#id_admin').val() != undefined) ? $('#id_admin').val() : $('#id_admin_satu').val();
                    // console.log($('#id_admin').val(),$('#id_admin_satu').val());
                    var b = ($('#id_eks_imp').val() != undefined) ? $('#id_eks_imp').val() : $('#id_company_satu').val();
                    var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
                        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                        encrypted: true
                    });
                    // console.log('chat-notif-channel-admin-' + a);

                    if (jenis_auth == 'admin') {
                        var notif_chanel = pusher.subscribe('chat-notif-channel-admin-' + a);
                    } else {
                        var notif_chanel = pusher.subscribe('chat-notif-channel-com-' + b);
                    }
                    notif_chanel.bind('App\\Events\\Notify', function(data) {
                        var jumlah_notif = $('#jumlah_notif').text();
                        $('.jumlah_notif').text(parseInt(jumlah_notif) + 1);
                        console.log(jumlah_notif)
                    })


                })
            </script>
        </div>
    </div>

    @include('auth.register.modal')
</body>
