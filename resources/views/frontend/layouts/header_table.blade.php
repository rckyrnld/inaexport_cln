<!DOCTYPE html>

    <html class="no-js" lang="{{ app()->getLocale() }}">
    <!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:13:46 GMT -->
    <head>

    <!-- google analytics tag -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172016689-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-172016689-1');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{$pageTitle}}</title>
    {{-- <meta name="description" content="">--}}
    <meta name="title" content="InaExport">
    <meta name="description" content="InaExport as a media product digital promotion superior export products from Indonesian business people, so they can more easily reach out to foreign buyers.">
    <meta name="keywords" content="inaexport, exporter, importer, buying request, inquiry, kemendag, trade, promotion, products, business, indonesia">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('front/assets/img/logo/kemendag.png')}}">

    <!-- CSS 
    ========================= -->
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="{{url('assets')}}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />-->
    <script src="https://kit.fontawesome.com/928bae4c26.js" crossorigin="anonymous"></script>

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset('front/assets/css/plugins.css')}}">

    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="{{url('assets')}}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{url('assets')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" type="text/css" />
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('front/assets/css/style.css')}}">
    <?php $font1 = url('/')."/front/assets/fonts/MYRIADPRO-REGULAR.woff";
    ?>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('front/assets/img/iconkemendag.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/css/dash.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/css/argon.css?v=1.2.0') }}" type="text/css">

    <!-- build:js scripts/app.min.js -->
    <!-- jQuery -->
{{--    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">--}}
{{--        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">--}}
    <script src="{{url('assets')}}/libs/jquery/dist/jquery.min.js"></script>
{{--    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>--}}
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <!-- InputMask -->
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <!-- Bootstrap -->
    <script src="{{url('assets')}}/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="{{url('assets')}}/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- core -->
    <script src="{{url('assets')}}/libs/pace-progress/pace.min.js"></script>
    <script src="{{url('assets')}}/libs/pjax/pjax.js"></script>
    <script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js"></script>

    <script src="{{url('assets')}}/html/scripts/lazyload.config.js"></script>
    <script src="{{url('assets')}}/html/scripts/lazyload.js"></script>
    <script src="{{url('assets')}}/html/scripts/plugin.js"></script>
    <script src="{{url('assets')}}/html/scripts/nav.js"></script>
    <script src="{{url('assets')}}/html/scripts/scrollto.js"></script>
    <script src="{{url('assets')}}/html/scripts/toggleclass.js"></script>
    <script src="{{url('assets')}}/html/scripts/theme.js"></script>
    <script src="{{url('assets')}}/html/scripts/ajax.js"></script>
    <script src="{{url('assets')}}/html/scripts/app.js"></script>
    <script src="{{url('assets/dist/dropzone.js')}}"></script>
    <link href="{{url('assets/dist/basic.css')}}" rel="stylesheet" />
    
    <!-- <script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js" ></script> -->
    <script src="{{url('assets')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js" ></script>

    <script src="{{url('assets')}}/html/scripts/plugins/datatable.js" ></script>

    <script src="{{ url('/') }}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>

    <script type="text/javascript"></script>

    <script>
        <?php
            if(isset($jenisnya)){
            $loc = app()->getLocale(); 
        ?>
            $(document).ready(function () {
                var jenis = "{{$jenisnya}}";
                if(jenis == "eksportir"){
                    $('#products').removeClass('active');
                    $('#set_products').removeClass('active');
                    $('#eksportir').addClass('active');
                    $('#set_eksportir').addClass('active');
                }else{
                    $('#eksportir').removeClass('active');
                    $('#set_eksportir').removeClass('active');
                    $('#products').addClass('active');
                    $('#set_products').addClass('active');
                }
            });
        <?php
            }
        ?>
    </script>

<style type="text/css">
    html, body{
        min-height: 100% !important;
        height: 100% !important;
    }

    .a-custom:hover{
        text-decoration: none;
    }

    .a-custom span:hover{
        color: #2FB4C2 !important;
    }
    .img-profil-header{
        width: 50px;
        height: 50px;
        border-radius: 50%
    }
    .header-span{
        padding-left: 10px;
        color: #ff8d00; 
        font-size: 18px;
    }

   
    .nav-pills .nav-link:hover, .nav-pills .nav-link.active{
        font-weight: 500;
        color: #ff8d00;
    }
    .nav-pills .nav-link {
        font-weight: 500;
        color: #007bff;
    }
    @font-face {
            font-family: 'Myriad-pro';
            src: url('{{$font1}}') format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        .nav-link.active {
            color: #000;
            font-weight: bold;
            border-bottom: 1px solid #000;
        }

        .main-header .navbar .nav>li>a>.label {
        position: absolute;
        top: 9px;
        right: 7px;
        text-align: center;
        font-size: 9px;
        padding: 2px 3px;
        line-height: .9;
    }

    .bg-yellow, .callout.callout-warning, .alert-warning, .label-warning, .modal-warning .modal-body {
        background-color: #f39c12 !important;
    }
    .list-lang{
        display: none;
        position: absolute;
        transition: all 0.5s ease;
        margin-top: 3px;
        border-radius: 5px;
        left: 0;
        background-color: #fff;
        width: 100%;
        text-align: left;
        padding: 3px 8px 6px 8px;
        z-index: 100;
        background-color: #fff;
    }
    .lang-option > img {
        height: 16px; 
        width: 24px; 
        margin-right: 7px; 
    }
    a.visit-lang:hover, a.visit-lang:hover > .lang-option{
        text-decoration: none;
        background-color: #f4f4f4;
    }
    .title-lang{
        color: black; font-size: 13px;
    }

    .product_tab_button.nav div a.active, .product_tab_button.nav div a:hover {
        text-decoration: none;
        font-weight: 500;
        font-size: 16px!important;
        font-family: 'Myriad-pro';
        color: #4497e5!important;
    }

    .product_tab_button.nav div a {
        font-size: 16px!important;
        color: black;
    }

    .btn-usermenu {
    color: #000;
    background-color: #fff;
    border-color: #fff;
    font-size: 14px;
    }

    .btn-usermenu:hover {
    color: #000;
    background-color: #fff;
    border-color: #6f6f6f;
    }
    .nav-link {
        margin-right: 20px;
    }

    
</style>

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

        // ::-webkit-resizer {
        //     background: #111;
        // }

        ::-webkit-scrollbar-track {
            background-color: #fff;
        }

    </style>

<body>
    @include('menu_history')
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
                                <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                                @if (Request::segment(2) != null)
                                    <li class="breadcrumb-item active" aria-current="page">{!! Request::segment(1) !!} /
                                        {!! Request::segment(2) !!}</li>
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
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" id="toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder" src="{{ url('/assets/assets/images/team-1.jpg') }}">
                                    </span>
                                 {{-- <div class="media-body  ml-2  d-none d-lg-block">
                                        <span
                                            class="mb-0 text-sm  font-weight-bold">{{ Auth::user() != '' ? Auth::user()->name : (Auth::guard('eksmp') != '' ? Auth::guard('eksmp')->user()->email : '') }}</span>
                                    </div> --}}
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right " id="drop">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="{{ url('br_importir_add') }}" class="dropdown-item"
                                    target="_blank">
                                    <i class="ni ni-planet"></i>
                                    <span>Inquiry</span>
                                </a>
                                {{-- <a href="{{ url('perusahaan/' . (Auth::user() != '' ? Auth::user()->name : (Auth::guard('eksmp') != '' ? Auth::guard('eksmp')->user()->email : ''))) }}" --}}
                                <a href="{{ url('profile') }}"
                                    class="dropdown-item" target="_blank">
                                    <i class="ni ni-circle-08"></i>
                                    <span>View Profile</span>
                                </a>
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
                    <div class="row align-items-center py-4">
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
                    @yield('card-dashboard')
                </div>
            </div>
        </div>
    <!--header area end-->

<script type="text/javascript">
    $(document).ready(function(){
        $('html').click(function() {
            $('.list-lang').css('display', 'none');
        });

        $('.btn-select-lang').on('click', function(event){
            event.stopPropagation();
            var visible = $('.list-lang').css('display');
            if(visible == 'none'){
                $('.list-lang').css('display', 'block');
            } else {
                $('.list-lang').css('display', 'none');
            }                
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>