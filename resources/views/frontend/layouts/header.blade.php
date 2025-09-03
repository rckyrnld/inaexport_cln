<!DOCTYPE html>

<html class="no-js" lang="{{ app()->getLocale() }}">
<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:13:46 GMT -->

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

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $pageTitle }}</title>
    {{-- <meta name="description" content=""> --}}
    <meta name="title" content="InaExport">
    <meta name="description"
        content="InaExport as a media product digital promotion superior export products from Indonesian business people, so they can more easily reach out to foreign buyers.">
    <meta name="keywords"
        content="inaexport, exporter, importer, buying request, inquiry, kemendag, trade, promotion, products, business, indonesia">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('front/assets/img/logo/kemendag.png') }}">

    <!-- CSS 
    ========================= -->
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="{{ url('assets') }}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />-->
    <script src="https://kit.fontawesome.com/928bae4c26.js" crossorigin="anonymous"></script>

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins.css') }}">

    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="{{ url('assets') }}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{ url('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
        type="text/css" />
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}">
    <?php $font1 = url('/') . '/front/assets/fonts/MYRIADPRO-REGULAR.woff';
    ?>

    <!-- build:js scripts/app.min.js -->
    <!-- jQuery -->
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css"> --}}
    <script src="{{ url('assets') }}/libs/jquery/dist/jquery.min.js"></script>
    {{-- <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> --}}
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <!-- InputMask -->
    {{-- <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script> --}}
    <!-- Bootstrap -->
    <script src="{{ url('assets') }}/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="{{ url('assets') }}/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- core -->
    <script src="{{ url('assets') }}/libs/pace-progress/pace.min.js"></script>
    <script src="{{ url('assets') }}/libs/pjax/pjax.js"></script>
    <script src="{{ url('assets') }}/libs/datatables/media/js/jquery.dataTables.min.js"></script>


    <script src="{{ url('assets') }}/html/scripts/lazyload.config.js"></script>
    <script src="{{ url('assets') }}/html/scripts/lazyload.js"></script>
    <script src="{{ url('assets') }}/html/scripts/plugin.js"></script>
    <script src="{{ url('assets') }}/html/scripts/nav.js"></script>
    <script src="{{ url('assets') }}/html/scripts/scrollto.js"></script>
    <script src="{{ url('assets') }}/html/scripts/toggleclass.js"></script>
    <script src="{{ url('assets') }}/html/scripts/theme.js"></script>
    <script src="{{ url('assets') }}/html/scripts/ajax.js"></script>
    <script src="{{ url('assets') }}/html/scripts/app.js"></script>
    {{-- <script src="{{ url('assets/dist/dropzone.css') }}"></script> --}}
    <script src="{{ url('assets/dist/dropzone.js') }}"></script>
    <link href="{{ url('assets/dist/basic.css') }}" rel="stylesheet" />

    <!-- <script src="{{ url('assets') }}/libs/datatables/media/js/jquery.dataTables.min.js"></script> -->
    <script src="{{ url('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>

    <script src="{{ url('assets') }}/html/scripts/plugins/datatable.js"></script>


    <script src="{{ url('/') }}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>

    <script type="text/javascript"></script>

    <script>
        <?php
            if(isset($jenisnya)){
            $loc = app()->getLocale(); 
        ?>
        $(document).ready(function() {
            var jenis = "{{ $jenisnya }}";
            if (jenis == "eksportir") {
                $('#products').removeClass('active');
                $('#set_products').removeClass('active');
                $('#eksportir').addClass('active');
                $('#set_eksportir').addClass('active');
            } else {
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
        html,
        body {
            min-height: 100% !important;
            height: 100% !important;
        }

        .a-custom:hover {
            text-decoration: none;
        }

        .a-custom span:hover {
            color: #2FB4C2 !important;
        }

        .img-profil-header {
            width: 50px;
            height: 50px;
            border-radius: 50%
        }

        .header-span {
            padding-left: 10px;
            color: #ff8d00;
            font-size: 18px;
        }


        .nav-pills .nav-link:hover,
        .nav-pills .nav-link.active {
            font-weight: 500;
            color: #ff8d00;
        }

        .nav-pills .nav-link {
            font-weight: 500;
            color: #007bff;
        }

        @font-face {
            font-family: 'Myriad-pro';
            src: url('{{ $font1 }}') format("truetype");
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

        .bg-yellow,
        .callout.callout-warning,
        .alert-warning,
        .label-warning,
        .modal-warning .modal-body {
            background-color: #f39c12 !important;
        }

        .list-lang {
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

        .lang-option>img {
            height: 16px;
            width: 24px;
            margin-right: 7px;
        }

        a.visit-lang:hover,
        a.visit-lang:hover>.lang-option {
            text-decoration: none;
            background-color: #f4f4f4;
        }

        .title-lang {
            color: black;
            font-size: 13px;
        }

        .product_tab_button.nav div a.active,
        .product_tab_button.nav div a:hover {
            text-decoration: none;
            font-weight: 500;
            font-size: 16px !important;
            font-family: 'Myriad-pro';
            color: #4497e5 !important;
        }

        .product_tab_button.nav div a {
            font-size: 16px !important;
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

        li.nav-item {
            display: inline-block;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 35px !important;
        }

        .custom-select,
        .custom-file-control,
        .custom-file-control:before,
        select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
            height: 45px !important;
        }


        .select2-container,
        .select2-dropdown,
        .select2-search,
        .select2-results {
            -webkit-transition: none !important;
            -moz-transition: none !important;
            -ms-transition: none !important;
            -o-transition: none !important;
            transition: none !important;
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

        .header-fix {
            position: fixed;
            z-index: 999;
            width: 100%;
        }

    </style>

<body>
    <?php
    $loc = app()->getLocale();
    if ($loc == 'ch') {
        $lct = 'chn';
    } elseif ($loc == 'in') {
        $lct = 'in';
    } else {
        $lct = 'en';
    }
    ?>

    <!-- Main Wrapper Start -->
    <!--header area start-->
    <header class="header_area header-fix">
        <!--header top start-->
        <nav class="navbar navbar-expand navbar-top" style="height: 40px; background-color: #001466">
            <div class="container">
                <ul class="navbar-nav me-auto">

                </ul>
                <div class="navbar justify-content-end">
                    <ul class="navbar-nav me-auto text-center">
                        <li class="nav-item dropdown">


                            @if (app()->getLocale() == 'in')
                                <a href="#" class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="font-size: 14px; color: white;">
                                    <img src="{{ asset('negara/in.png') }}" width="20" height="20">&nbsp; IND
                                </a>
                            @elseif(app()->getLocale() == 'en')
                                <a href="#" class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="font-size: 14px; color: white;">
                                    <img src="{{ asset('negara/en.png') }}" width="20" height="20">&nbsp; ENG
                                </a>
                            @else
                            {{--<a href="#" class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="font-size: 14px; color: white;">
                                    <img src="{{ asset('negara/ch.png') }}" width="20" height="20">&nbsp; CHN
                                </a>--}}
                            @endif



                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="langDropdown">
                                <li>
                                    <a class="dropdown-item lang-option" href="{{ url('locale/in') }}"
                                        style="font-size: 14px;"><img src="{{ asset('negara/in.png') }}" width=" 20"
                                            height="20">&nbsp; IDN</a>
                                </li>
                                <li>
                                    <a class="   dropdown-item lang-option" href="{{ url('locale/en') }}"
                                        style="font-size: 14px;"><img src=" {{ asset('negara/en.png') }}" width="
                                            20" height="20">&nbsp; ENG</a>
                                </li>
                                {{--<li>
                                    <a class="   dropdown-item lang-option" href="{{ url('locale/ch') }}"
                                        style="font-size: 14px;"><img src=" {{ asset('negara/ch.png') }}" width="20"
                                            height="20">&nbsp; CHN</a>
                                </li>--}}
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>

        <!--header top start-->
        <!--header middel start-->
        <div class="header_middle" style="background-color: #fff;box-shadow: 0 0px 20px 0px grey;">
            <div class="container" style="width: 98% !important;">
                <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-top" style="padding: 5px 0 0 0">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('front/assets/img/logo/logonew.png') }}" alt="" width="180">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center"
                            style="font-size: 14px; white-space:nowrap">
                            <?php
                            // echo $topMenu;
                            // die();
                            $a1 = '';
                            $a2 = '';
                            $a3 = '';
                            $a4 = '';
                            $a5 = '';
                            $a6 = '';
                            $a7 = '';
                            $a8 = '';
                            $a9 = '';
                            if (isset($topMenu)) {
                                if ($topMenu == 'home') {
                                    $a1 = 'active';
                                }
                                if ($topMenu == 'product') {
                                    $a2 = 'active';
                                }
                                if ($topMenu == 'supplier') {
                                    $a3 = 'active';
                                }
                                if ($topMenu == 'about') {
                                    $a4 = 'active';
                                }
                                if ($topMenu == 'service') {
                                    $a5 = 'active';
                                }
                                if ($topMenu == 'news') {
                                    $a6 = 'active';
                                }
                                if ($topMenu == 'contact') {
                                    $a7 = 'active';
                                }
                                if ($topMenu == 'support') {
                                    $a8 = 'active';
                                }
                                if ($topMenu == 'forsuppliers') {
                                    $a9 = 'active';
                                }
                            }
                            ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $a1; ?>" aria-current="page"
                                    href="{{ url('/') }}">@lang("frontend.home.home")</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $a2; ?>" href="{{ url('/products') }}">@lang("frontend.home.our_products")</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $a3; ?>" href="{{ url('/suppliers') }}">@lang("frontend.home.our_suppliers")</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $a4; ?>" href="{{ url('/about') }}">@lang("frontend.home.about_inaexport")</a>
                            </li>
                            <!-- <li class="nav-item">
                            <a class="nav-link <?php echo $a8; ?>" href="{{ route('front.supp') }}">Support</a>
                        </li> -->
                            <li class="nav-item dropdown">
                                <a class="nav-link <?php echo $a5; ?> dropdown-toggle" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @lang("frontend.home.our_services")
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 14px;">
                                    <li><a class="dropdown-item" href="{{ url('/front_end/event') }}">@lang("frontend.home.trade_event")</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ url('/front_end/training') }}">@lang("frontend.home.training")</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ url('/front_end/news') }}">@lang("frontend.home.news")</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ url('/front_end/publication') }}">@lang("frontend.home.publication")</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link <?php echo $a9; ?> dropdown-toggle" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @lang("frontend.home.for_suppliers")
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 14px;">
                                    <li><a class="dropdown-item" href="{{ url('/front_end/curris') }}">@lang("frontend.home.trade_update")</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ url('/front_end/research-corner') }}">@lang("frontend.home.market_information")</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/front_end/event_zoom') }}">@lang("frontend.home.business_matching")</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/front_end/ourinqueris') }}">@lang("frontend.home.trade_inquiry")</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $a7; ?>" href="{{ url('/contact-us') }}">@lang("frontend.home.contact_us")</a>
                            </li>
                            <li class="nav-item">
                                <?php
                        if(Auth::guard('eksmp')->user()) {
                            if(Auth::guard('eksmp')->user()->id_role == 3){
                                $u = "buyer";
                                $user = getCompanyNameImportir(Auth::guard('eksmp')->user()->id);
                            }else if(Auth::guard('eksmp')->user()->id_role == 2){
                                $u = "eksportir";
                                $user = getCompanyName(Auth::guard('eksmp')->user()->id);
                            }
                            ?>
                                <!--<div class="col" style="text-align: left;"><?php //echo $user;
?> | <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>-->

                                <div class="col" class="dropdown">
                                    <button class="btn btn-usermenu dropdown-toggle" type="button" id="dropdownMenuUser"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $user; ?>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuUser"
                                        style="font-size: 14px;">
                                        <?php
                                    if($u=="eksportir") { 
                                        ?>
                                        <li>
                                            <a class="dropdown-item" href="{{ url('/profile_supplier') }}">My
                                                Account</a>
                                        </li>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <li><a class="dropdown-item" href="{{ url('/profile') }}">My Account</a>
                                        </li>
                                        <li style="display: none;">
                                            <a class="dropdown-item"
                                                href="{{ url('/br_importir_add') }}">Inquiry</a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                        {{-- <li><a class="dropdown-item"
                                                href="{{ url('/front_end/history') }}">History</a></li>
                                        <li><a class="dropdown-item" href="{{ url('/trx_list') }}">Transaction</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ url('/front_end/ticketing_support/list') }}">Support</a>
                                        </li> --}}
                                        @if ($u == 'eksportir') <li><a class="dropdown-item" href="{{ url('/br_list') }}">Inquiry Inbox</a></li> @endif
                                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                <?php
                        }
                        elseif (Auth::user() != null) {
                        ?>
                                <div class="col" class="dropdown">
                                    <button class="btn btn-usermenu dropdown-toggle" type="button" id="dropdownMenuUser"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo Auth::user()->name; ?>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuUser"
                                        style="font-size: 14px;">
                                        <!-- <li><a class="dropdown-item"
                                                href="{{ url('/front_end/history') }}">History</a></li> -->
                                        <li><a class="dropdown-item" href="{{ (Auth::user()->id_group == 4) ? url('/home') : url('/dashboard') }}">My Account</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                <?php
                        }
                        else {
                            ?>

                                <div class="col"
                                    style="text-align: center; padding-left: 0; padding-right: 0px;">
                                    <a href="{{ url('/login') }}" class="btn"
                                        style="width: 90px; background-color: #ffe300; border-radius: 20px;color:#1d7bff; font-size: 14px;"><b>Sign
                                            in</b></a>
                                    <span style="color: #1d7bff">or</span>
                                    <a href="{{ url('/createnewaccount') }}" class="btn"
                                        style="width: 90px; background-color: #ffe300; border-radius: 20px;color:#1d7bff; font-size: 14px;"><b>Register</b></a>
                                </div>
                                <?php
                        }
                        ?>
                            </li>
                        </ul>
                </nav>
            </div>
        </div>
    </header>
    <div style="padding-top:110px;"></div>
    <!--header area end-->

    <script type="text/javascript">
        $(document).ready(function() {

            {{-- let cek = "{{!empty(Auth::guard('eksmp')->user()->email) ? Auth::guard('eksmp')->user()->email : 'none'}}"; --}}
            {{-- alert(cek); --}}

            $('html').click(function() {
                $('.list-lang').css('display', 'none');
            });

            $('.btn-select-lang').on('click', function(event) {
                event.stopPropagation();
                var visible = $('.list-lang').css('display');
                if (visible == 'none') {
                    $('.list-lang').css('display', 'block');
                } else {
                    $('.list-lang').css('display', 'none');
                }
            });

            let cek = "{{ Auth::guard('eksmp')->check() ? Auth::guard('eksmp')->user()->email : 'none' }}";
            let url_chat = "{{ config('constants.HELPDESK_URL') }}";

            {{--(function(w, d, s, u) {--}}
            {{--    if (cek != "none") {--}}
            {{--        w.id = 1;--}}
            {{--        w.lang = 'id';--}}
            {{--        w.cName =--}}
            {{--            '{{ Auth::guard('eksmp')->check() ? Auth::guard('eksmp')->user()->email : 'none' }}';--}}
            {{--        w.cEmail =--}}
            {{--            '{{ Auth::guard('eksmp')->check() ? Auth::guard('eksmp')->user()->email : 'none' }}';--}}
            {{--        w.cMessage = 'Halo';--}}
            {{--        w.lcjUrl = u;--}}
            {{--        var h = d.getElementsByTagName(s)[0],--}}
            {{--            j = d.createElement(s);--}}
            {{--        j.async = true;--}}
            {{--        j.src = url_chat + 'js/jaklcpchat.js';--}}
            {{--        h.parentNode.insertBefore(j, h);--}}
            {{--    }--}}
            {{--})(window, document, 'script', url_chat);--}}
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>

</body>

</html>
