@include('frontend.layouts.header')
<!--slider area start-->
<style type="text/css">
    .categories_menu_toggle>ul>li ul.categories_mega_menu>li {
        width: 80%;
        padding: 0px 0px 0px 15px
    }

    .categories_menu_toggle>ul>li ul.categories_mega_menu>li>a {
        text-transform: none !important;
    }

    .row-menu {
        margin-top: 10%;
        margin-bottom: 10%;
    }

    .product_tab_button.nav div {
        margin: 2% 0 1% 0;
    }

    .product_tab_button.nav div a {
        font-size: 12px;
        color: #34b1e5;
        font-family: 'Myriad-pro';
    }

    .product_tab_button.nav div a.active,
    .product_tab_button.nav div a:hover {
        text-decoration: none;
        font-weight: 500;
        font-size: 12px;
        font-family: 'Myriad-pro';
        color: #fe8f00;
    }

    .for-act {
        text-decoration: none;
        opacity: 0.7;
    }

    .box-cu {
        width: 100%;
        background-color: white;
        border-radius: 20px;
        padding-right: 5%;
        padding-left: 5%;
        padding-top: 3%;
        padding-bottom: 1px;
    }

    .button_form {
        width: auto;
    }

    .href-name {
        color: black;
    }

    .href-name:hover {
        text-decoration: none;
    }

    .href-company {
        text-transform: capitalize;
        font-size: 11px;
        font-family: 'Open Sans', sans-serif;
        /*color: black;*/
    }

    .href-company:hover {
        text-decoration: none;
        color: black !important;
    }

    .href-category {
        text-transform: capitalize;
        font-size: 11px !important;
        font-family: 'Open Sans', sans-serif;
    }

    .href-category:hover {
        text-decoration: none;
        /*color: #2777d0 !important;*/
    }

    .single_product:hover {
        box-shadow: 0 0 15px rgba(178, 221, 255, 1);
    }

    select:required:invalid {
        color: gray !important;
    }

    option[value=""][disabled] {
        display: none !important;
    }

    option {
        color: black !important;
    }

    .container-fluid {
        padding-left: 24px !important;
        padding-right: 24px !important;
    }

    @media only screen and (max-width: 767px) {
        .categories_menu_toggle>ul>li>a {
            /*line-height: 35px;*/
            /*padding: 0;*/
            color: #ffffff;
        }

        #why_inaexport .imageWhy {
            display: none;
        }

        #why_inaexport .TextWhy {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        #inaexport_fact .mobileClass {
            flex: 0 0 50%;
            max-width: 50%;
        }

        #our_product .mobileClass1 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        #our_product .mobileClass2 {
            margin: 5px;
        }

        #our_product .mobileClass3 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media only screen and (max-width: 1199px) and (min-width: 992px) {
        .categories_menu_toggle>ul>li>a {
            color: #ffffff;
        }

        #why_inaexport .imageWhy {
            display: none;
        }

        #why_inaexport .TextWhy {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        #inaexport_fact .mobileClass {
            flex: 0 0 50%;
            max-width: 50%;
        }

        #our_product .mobileClass1 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        #our_product .mobileClass2 {
            margin: 5px;
        }

        #our_product .mobileClass3 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

</style>

<style>
    #companyspecialevent_wrapper {
        width: 100% !important;
    }

    #companyspecialevent {
        width: 100% !important;
    }

</style>

<style>
    .hoveraja {
        position: relative;
        width: 50%;
    }

    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
    }

    .hoveraja:hover .image {
        opacity: 0.3;
    }

    .hoveraja:hover .middle {
        opacity: 1;
    }

    .text {
        color: white;
        font-size: 12px;
        padding: 10px 22px;
    }

    /* .numberbg {
    background: url({{ URL::asset('assets/assets/home/export-containers.jpg') }}) no-repeat center center fixed;
    background-size: cover;
    
    } */

    .txtbg {
        background: rgba(0, 0, 0, 0.3);
        color: #fff;
    }

    .py-2 span {
        font-weight: bold;
    }

    .product {
        background-color: #ffe300;
        border-radius: 14px;
        color: #1d7bff;
        font-size: 14px;
        font-weight: bold;
        width: 150 px;

    }

    .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 100%;
    }

    .card.mb-2.text-center {
        transition: transform .2s;
    }

    .card.mb-2.text-center:hover {
        transform: scale(1.05);
    }

    .carousel-indicators li,
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(100%);
    }

    .a {
        font-size: 12px;
    }

    .carousel-indicators .active {
        background-color: black !important;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        height: 25px;
        width: 25px;
    }

    .carousel-control-next-icon:after {
        content: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
    }

    .carousel-control-prev-icon:after {
        content: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
    }

    .mobileClass3:hover{
        cursor: pointer;
    }

</style>


<?php
$loc = app()->getLocale();
if ($loc == 'ch') {
    $lct = 'chn';
    $by = '通过';
    $order = '最小订购量 : ';
} elseif ($loc == 'in') {
    $lct = 'in';
    $by = 'Oleh';
    $order = 'Min Order : ';
} else {
    $lct = 'en';
    $by = 'By';
    $order = 'Min Order : ';
}

$imgarray = ['agriculture', 'apparel', 'automotive', 'jewelry', 'health_beauty', 'electrics', 'furniture', 'industrial_parts', 'gift_card', 'food'];
?>

<!-- main image start -->
{{-- Mulai Disini --}}
<div class="container" style="padding: 5vh 15px 4vh 15px;">
    <div class="row">
        <div class="col-lg-12">
            <section style=" margin-bottom: 0px; padding-top: 15px;">
                <div class="breadcrumbs_area">
                    <div style="margin-top: -20px; padding-left:0px;padding-right:0px;">
                        <div id="carouselExampleIndicators" class="carousel slide" data-interval="3000"
                            data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($slide as $status => $slideshow)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $status }}"
                                        @if ($status == 0) class="active" @else @endif }}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($slide as $status => $slideshow)
                                    <div class="carousel-item {{ $status == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('image/slide/' . $slideshow->nama) }}"
                                            class="d-block w-100" alt="..." style="border-radius:10px;">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- main image end -->

                <!--Event Special start-->
                @if (isset($checkevent))

                    <!-- <div class="container-fluid"> -->
                    <!-- <p> -->
                    @if (count($checkevent) > 0)
                        @foreach ($checkevent as $event)
                            <a href="{{ url('front_end/list_product/categoryeks/' . $event->id) }}">
                                <img style="width:100%; max-width: 100%;heigth:231px"
                                    src="{{ asset('uploads/banner/') }}/{{ $event->file }}" alt="">
                                <!-- <img class="img-fluid" style="width:100%; max-width: 100%;heigth:231px" src="{{ asset('uploads/banner/') }}/{{ $event->file }}" alt=""> -->
                            </a>
                        @endforeach
                    @endif
                    <!-- </p> -->

                    {{-- <img style="max-width: 100%;min-width: 100%;heigth:231px" src="{{asset('uploads/banner/')}}/{{$checkevent->file}}" data-show-id="{{$checkevent->id}}" data-toggle="modal"  data-target="#modal-special-event" alt=""> --}}

        </div>
    </div>
    </section>
    @endif
</div>
</div>
</div>
<!--Event Special end-->

<!-- mengapa inaexport start -->
<div id="why_inaexport" class="container">
    <section {{-- style="background-color:rgba(0,0,0,0.1); background-size:cover; padding-bottom: 30px; padding-top: 30px; "> --}} {{-- style="background-image:url('./assets/assets/versi 1/Asset 23 (1).png')!important; background-color:rgba(0,0,0,0.1); background-size:cover; padding-bottom: 30px; padding-top: 30px; " --}}>

        <div class="col-lg-12" style="padding-top:0px; padding-bottom: 10px;">
            <div class="row">
                <div class="col-12">
                    {{-- <p style="font-size:15px; color: #1d7bff"><b>About Us</b></p> --}}
                    {{-- <p style="font-size:24px; text-align:left; color: #001466" class="py-2">WHY DO
                            BUSINESS WITH <span> INDONESIA SUPPLIER? </span></p> --}}
                    <p style="font-size:24px; text-align:center; color: #001466" class="py-2"><span>@lang('frontend.home.why_inaexport')</span></p>
                </div>
                {{-- <div class="col-5" style="text-align:right;">
                        <a class="btn"
                        style="text-align:right;font-size: 14px; background-size: 16px; background-color: #ffe300; border-radius: 20px;color:#1d7bff"
                        href="{{ url('/about') }}"><b>About Inaexport</b></a>
                    </div> --}}
                <div class="col-12">&nbsp;</div>
                <div class="col-1 imageWhy">
                    <img src="{{ asset('assets/assets/images/why_01.png') }}" alt="" style="">
                </div>
                <div class="col-3 TextWhy">
                    <p><b><span style="font-size: 16px;"></i>@lang('frontend.home.verified_supplier')</span></b> <br>
                        @lang('frontend.home.verified_supplier_note') </p>
                </div>
                <div class="col-1 imageWhy">
                    <img src="{{ asset('assets/assets/images/why_02.png') }}" alt="" style="">
                </div>
                <div class="col-3 TextWhy">
                    <p><b><span style="font-size: 16px;">@lang('frontend.home.sustainable_trade')</span></b> <br>
                        @lang('frontend.home.sustainable_trade_note')</p>
                </div>
                <div class="col-1 imageWhy">
                    <img src="{{ asset('assets/assets/images/why_03.png') }}" alt="" style="">
                </div>
                <div class="col-3 TextWhy">
                    <p><b><span style="font-size: 16px;">@lang('frontend.home.diverse_products')</span></b> <br>
                        @lang('frontend.home.diverse_products_note') </p>
                    <p>
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- mengapa inaexport end -->

<!-- Inaexport Fact -->
<div id="inaexport_fact" class="container" style="padding-top: 4vh; padding-bottom: 0px;">
    <section style="padding-top:0px; background-color: #fff;">
        <div class="row"
            style="margin:0px auto; padding: 0px auto;background-color:#fff!important; /* background-image:url('./assets/assets/home/export-containers.jpg')!important; background-size: cover;border-radius:10px; */">
            <div class="col-12 txtbg" align="center"
                style="padding-bottom: 25px;border-radius:10px;background-color:#fff!important;">
                <div class="col-12" style="padding-top: 5px; padding-bottom: 25px;">
                    <p style="text-align:center; font-size: 24px;color:#001466"><b>@lang('frontend.home.whats_in_inaexport')</b></p>
                </div>
                <div class="col-lg-12 row">

                    <div class="col-12"></div>
                    <div class="col text-center mobileClass rounded-left" style="padding: 25px 0px 25px 0px;background: #375BB7;">
                        <a href="{{ url('/suppliers') }}">
                            {{-- <div class="border border-white"
                        style="border-radius: 100%; background-border: #fff; width:140px; height:140px; background-color:#ff1470; text-align: center; padding-bottom: 12px;"> --}}
                            <!--<img src="{{ asset('front/assets/img/exporters.png') }}" alt="" style="width: 33px;margin-left: 10%; float:left">-->
                            <br>
                            <span class="counters_number">
                                <?php echo number_format(getCountData('itdp_company_users'), '0'); ?>
                                <!--{{ getCountData('itdp_company_users') }}-->
                            </span><br>
                            <span class="counters_text" style="font-size: 20px">
                                @if ($loc == 'ch')
                                    出口商
                                @elseif($loc == 'in')
                                    Supplier
                                @else
                                    Suppliers
                                @endif
                            </span>
                            {{-- </div> --}}
                        </a>
                    </div>
                    <div class="col text-center mobileClass" style="padding: 25px 0px 25px 0px;background: #142F67;">
                        <a href="{{ url('/products') }}">
                            {{-- <div class="border border-white"
                        style="border-radius: 100%; width:140px; height:140px; background-color:#002e80; text-align: center; padding-bottom: 12px;"> --}}
                            <!--<img src="{{ asset('front/assets/img/products.png') }}" alt="" style="width:35px; margin-left: 10%; float: left;">-->
                            <br>
                            <span class="counters_number">
                                <?php echo number_format(getCountData('csc_product_single'), '0'); ?>
                                <!--{{ getCountData('csc_product_single') }}-->
                            </span><br>
                            <span class="counters_text" style="font-size: 20px">
                                @lang('frontend.home.product')
                            </span>
                            {{-- </div> --}}
                        </a>
                    </div>
                    <div class="col text-center mobileClass" style="padding: 25px 0px 25px 0px;background: #A70606;">
                        {{-- <a href="#"> --}}
                        {{-- <div class="border border-white"
                        style="border-radius: 100%; width:140px; height:140px; background-color:#ff8021; text-align: center; padding-bottom: 12px;"> --}}
                        <!--<img src="{{ asset('front/assets/img/representative.png') }}" alt="" style="width: 30px;margin-left: 10%; float:left">-->
                        <a href="{{ url('/front_end/research-corner') }}">
                            {{-- <div class="border border-white"
                        style="border-radius: 100%; width:140px; height:140px; background-color:#ff6206; text-align: center; padding-bottom: 12px;"> --}}
                            <!--<img src="{{ asset('front/assets/img/researchcorner.png') }}" alt="" style="width: 35px;margin-left: 10%; float:left">-->
                            <br>
                            <span class="counters_number">
                                <?php echo number_format(getCountData('csc_research_corner'), '0'); ?>
                                <!--{{ getCountData('csc_research_corner') }}-->
                            </span><br>
                            <!-- <span class="counters_text" style="margin-right: 23%; font-size: 18px; float: right;"> -->
                            <span class="counters_text" style="font-size: 20px">
                                @if ($loc == 'ch')
                                    市场调查
                                @elseif($loc == 'in')
                                    Informasi Pasar
                                @else
                                    Market Information
                                @endif
                            </span>
                            {{-- </div> --}}
                        </a>
                        {{-- </div> --}}
                        {{-- </a> --}}
                    </div>
                    <div class="col text-center mobileClass" style="padding: 25px 0px 25px 0px;background: #CA3403;">
                        <a href="{{ url('/front_end/event') }}">
                            {{-- <div class="border border-white"
                        style="border-radius: 100%; width:140px; height:140px; background-color:#007f50; text-align: center; padding-bottom: 12px;"> --}}
                            <!--<img src="{{ asset('front/assets/img/events.png') }}" alt="" style="width: 35px;;margin-left: 10%; float:left">-->
                            <br>
                            <span class="counters_number">
                                <?php echo number_format(getCountData('event_detail'), '0'); ?>
                                <!--{{ getCountData('event_detail') }}-->
                            </span><br>
                            <span class="counters_text" style="font-size: 20px">
                                @if ($loc == 'ch')
                                    国际活动
                                @elseif($loc == 'in')
                                    Pameran
                                @else
                                    Events
                                @endif
                            </span>
                            {{-- </div> --}}
                        </a>
                    </div>
                    <div class="col text-center mobileClass rounded-right" style="padding: 25px 0px 25px 0px;background: #D4D400;">
                        <br>
                        <span class="counters_number">
                            <?php echo number_format(getCountData('itdp_admin_users'), '0'); ?>
                            <!--{{ getCountData('itdp_admin_users') }}-->
                        </span><br>
                        <!-- <span class="counters_text" style="margin-right: 23%; font-size: 18px; float: right;"> -->
                        <span class="counters_text" style="font-size: 20px">
                            @if ($loc == 'ch')
                                海外贸易代表
                            @elseif($loc == 'in')
                                Perwakilan
                            @else
                                Representative
                            @endif
                        </span>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--rfq start-->
<section class="breadcrumbs_area"
    style=" padding-top: 0;padding-bottom: 3%; background-image:url('./assets/assets/versi 1/Asset 16 (1).png')!important;background-size:cover;">
    <div class="container">
        <div class="col-12" style="padding: 0">
            <div class="row">
                <div class="col-md-6">
                    <div style="padding:5px;">
                        <br>
                        <p style="font-size:18px; color: #001466"><b>TRADE INQUIRY</b></p>
                        <p style="font-size:22px; color: #001466">Partner directly with <span
                                style="font-weight: bold">Indonesian Supplier</span>
                            <br>Send your inquiries or ask for trade inquiries
                        </p>
                        <br>
                        {{-- <p style="font-size:20px; color: #001466">@lang("login.lbl6") <br> @lang("login.lbl7")
                                @lang("login.lbl8")</p> --}}
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5" style="padding-top:40px;">
                    <div class="box-cu">
                        <form class="form-horizontal" method="POST" action="{{ url('br_importir_next') }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <h5><b style="font-size: 16px;">@lang("login.forms.by1")</b></h5>
                            <br>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>
                                        <b>@lang('login.forms.by2')</b>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" style="color:black;font-size: 13px;" value="" name="subyek"
                                        id="subyek" class="form-control" placeholder="@lang('login.forms.by2')?">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>
                                        <b> @lang("login.forms.by4")</b>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <textarea style="color:black; font-size: 13px;" value="" name="spec" id="spec"
                                        class="form-control" placeholder="@lang('login.forms.by4')"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group col-md-6">
                                    <label><b> @lang("login.forms.by5")</b></label>
                                    <input style="color:black; font-size: 13px;" type="text" name="eo" id="eo"
                                        class="form-control order" placeholder="@lang('login.forms.by5')">
                                </div>
                                <div class="form-group col-md-6">
                                    <label><b> @lang("login.forms.by15")</b></label>
                                    <select class="form-control" style="font-size:12px;height: 34px !important;"
                                        name="neo" id="neo">
                                        <option value="" disabled selected>@lang("login.forms.by14")</option>
                                        <option value="Dozen">Dozen</option>
                                        <option value="Grams">Grams</option>
                                        <option value="Kilograms">Kilograms</option>
                                        <option value="Liters">Liters</option>
                                        <option value="Meters">Meters</option>
                                        <option value="Packs">Packs</option>
                                        <option value="Pairs">Pairs</option>
                                        <option value="Pieces">Pieces</option>
                                        <option value="Sets">Sets</option>
                                        <option value="Tons">Tons</option>
                                        <option value="Unit">Unit</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                                <div class="col-md-12">
                                    <label>
                                        <b>@lang("login.forms.by6") <span id="fob">(FOB)</span></b>
                                    </label>
                                </div>
                                <div class="col-md-7">
                                    <input style="color:black; font-size: 13px;" type="text" value="" name="tp" id="tp"
                                        class="form-control amount" placeholder="@lang('login.forms.by6')">
                                </div>
                                <div class="col-md-5">
                                    <label><b>USD</b></label>
                                    <select style="font-size:12px;height: 31px;" class="form-control d-none" disabled
                                        name="ntp" id="ntp">
                                        {{-- <option value="" disabled selected>@lang("login.forms.by14")</option> --}}
                                        {{-- <option value="SAR">Arab Saudi Riyal(SAR)</option>
                                        <option value="BND">Brunei Dollar(BND)</option>
                                        <option value="CNY">China Yuan(CNY)</option>
                                        <option value="IQD">Dinar Irak(IQD)</option>
                                        <option value="AED">Dirham Uni Emirat Arab(AED)</option> --}}
                                        {{-- <option value="USD">Dollar Amerika Serikat(USD)</option> --}}
                                        <option value="USD" selected>USD</option>
                                        {{-- <option value="AUD">Dollar Australia(AUD)</option>
                                        <option value="HKD">Dollar Hong Kong(HKD)</option>
                                        <option value="SGD">Dollar Singapura(SGD)</option>
                                        <option value="TWD">Dollar Taiwan Baru(TWD)</option>
                                        <option value="EUR">Euro(EUR)</option>
                                        <option value="PHP">Peso Filipina(PHP)</option>
                                        <option value="GBP">Pound Sterling(GBP)</option>
                                        <option value="MYR">Ringgit Malaysia(MYR)</option>
                                        <option value="INR">Rupee India(INR)</option>
                                        <option value="IDR">Rupiah Indonesia(IDR)</option>
                                        <option value="THB">Thai Baht(THB)</option>
                                        <option value="VND">Vietnam Dong(VND)</option>
                                        <option value="KRW">Won Korea(KRW)</option>
                                        <option value="JPY">Yen Jepang(JPY)</option> --}}

                                    </select>
                                </div>
                            </div> -->
                            <br>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div align="left">
                                        <button type="submit"
                                            style="border-radius:12px;font-size:14px; background-color: #ffe300;color:#1d7bff"
                                            class="btn button_form rounded">
                                            <b>
                                                @if ($loc == 'ch')
                                                    立即发布购买请求
                                                @elseif($loc == 'in')
                                                    Kirim Permintaan Pembelian
                                                @else
                                                    Post Trade Inquiry
                                                @endif
                                            </b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--rfq end-->

<!-- our products start old-->
{{-- <section style="padding-top: 50px; padding-bottom: 100px;">
    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">
        <div class="container">
            <div class="row">
                <li class="carousel-control-prev" type="button" data-bs-target="#multi-item-example"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </li>
                <li class="carousel-control-next" type="button" data-bs-target="#multi-item-example"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </li>


                <div class="carousel-indicators" style="margin-bottom:-80px;">
                    <li type="button" data-bs-target="#multi-item-example" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></li>
                    <li type="button" data-bs-target="#multi-item-example" data-bs-slide-to="1" aria-label="Slide 2">
                    </li>
                </div>


                <div class="col-lg-12">
                    <p style="font-size: 24px; font-weight: bold; text-align:center; color:rgba(0, 0, 0, 0.767)"
                        class="py-2">OUR PRODUCTS</p>
                </div>

                <div class="col-lg-12" style="padding-bottom: 16px;">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-8 justify-content-md-center">
                        </div>
                    </div>
                </div>

                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        @foreach ($categoryutama2 as $c)
                            <div class="col-md-4" style="float:left">
                            @php $p = $c->banner ? $c->banner : 'Asset 49 (1).png' @endphp
                                <div class="card mb-2 text-center" style="/* border-radius: 20px">
                                    <img class="card-img-top"
                                        src="{{ URL::asset('assets/assets/versi 1/' . $p) }} "
                                        alt="Agriculture" style="width: 100%">
                                    <div class="card-body">
                                        <h4 class="card-title" style="color: #1d7bff">
                                            <b>{{ $c->nama_kategori_en }}</b></h4>
                                        <p style="text-align: justify;">{{ $c->description }}</p>
                                        <a href="{{ url('/kategori/' . $c->id . '/' . strtolower($c->nama_kategori_en) . '') }}"
                                            class="btn product">See Products</a>
                                    </div>
                                </div>
                            </div>
                        @if ($loop->iteration == 3)
                    </div>
                    <div class="carousel-item">
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section> --}}
<!-- our products end old-->

<!-- our products start -->
<section id="our_product" style="padding-top: 0px; padding-bottom: 0px;">
    <div class="container">
        <div class="row">
            {{-- <div class="col-lg-12">
                <p style="font-size: 24px; font-weight: bold; text-align:center; color:rgba(0, 0, 0, 0.767)"
                    class="py-2">OUR PRODUCTS</p>
            </div> --}}
            <div class="col-lg-12" style="padding-top:20px; padding-bottom: 10px;">
                @forelse ($categoryutama2 as $c)
                    <?php
                    $p = $c->banner ? URL::asset('assets/assets/versi 1') . '/' . $c->banner : URL::asset('assets/assets/versi 1/Asset 49 (1).png');
                    $detil = getDetailProduct($c->id_product);
                    ?>
                    <div class="row" style="padding-bottom:15px;">
                        <div class="col-12">
                            <p style="font-size:18px; text-align:left; color: #001466" class="py-2"
                                class="third-child">
                                <b>{{ $c->nama_kategori_en }}</b>
                                <a href="{{ url('/kategori/' . $c->id . '/' . strtolower($c->nama_kategori_en) . '') }}"
                                    style="font-size:16px;color:#00bd17"><b>View All</b></a>
                            </p>
                        </div>
                        <div class="col-4 mobileClass1 px-0 py-3" align="center">
                            <a href="{{ url('/kategori/' . $c->id . '/' . strtolower($c->nama_kategori_en) . '') }}">
                                <img src="{{ $p }}"
                                    style="border-radius: 10px;width:95%;object-fit: cover;height:260px;">
                            </a>
                        </div>
                        <div class="col-8 mobileClass1 d-flex align-items-center">
                            <div class="row mobileClass2 w-100">
                                @foreach ($detil as $row)
                                    @php
                                        $p = $row->banner ? URL::asset('assets/assets/versi 1') . '/' . $row->banner : URL::asset('assets/assets/versi 1/Asset 49 (1).png');
                                    @endphp

                                    <div class="col-lg-4 col-sm-12 mobileClass3 px-1 py-1"
                                        style="">
                                        <a
                                            href="{{ url('/kategori/' . $row->id . '/' . strtolower($row->nama_kategori_en) . '') }}"></a>
                                        <div style="background-image:url('{{ $p }}');background-size:cover;padding:25px;height:130px;border-radius: 10px;">
                                            <span
                                                style="font-size:12px; text-align:left; color: #001466;background-color:white;padding:5px;border-radius:5px;"
                                                class="py-2" class="third-child"
                                                style="color:#fff;"><b>{{ $row->nama_kategori_en }}</b></span>
                                            <p style="font-size:12px; color: #1d7bff">
                                                <b></b>
                                            </p><br>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Data masih kosong</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- our products end -->

<!-- What's in InaEpxort start -->
<section
    style="background-image:url('./assets/assets/versi 1/Asset 23 (1).png')!important; background-size:cover; padding-top: 30px; ">
    <div class="container">
        <div class="row">
            <p style="font-size:30px; text-align:left; color: #001466;padding:15px;" class="py-2"><b>InaExport
                    News</b><br>
                <span style="font-size:23px; font-weight:200">Our stories, latest updates and exclusive news. Find
                    anything you want to know about us.</span>
            </p>
        </div>
        <div class="row">

            <div class="col-lg-6" style="padding-right: -50px">
                <br>
                @if ($artikel->count())
                    <div
                        style="border-radius: 10px;height: 568px;width: 568px;background-color: #e8e8e4;justify-content: center;display:table-cell;vertical-align:middle;text-align:center;">
                        <img src="{{ asset('uploads/News/' . $artikel[0]->gambar) }}" class="img-responsive"
                            style="border-radius: 10px;object-fit:cover;background-color:#e8e8e4;">

                    </div>
                    <p style="font-size:22px; text-align:left; color: #001466"><br><b><i class="fa fa-newspaper-o"></i>
                            NEWS</b></p>
                    <p><a style="font-size:30px; text-align:left; color: #001466" class="py-2"
                            href="{{ route('detail-artikel', $artikel[0]->judul_seo) }}" class="third-child"
                            style="color:#fff;"><b>{{ $artikel[0]->judul }}</b></a></p>
                    <p style="font-size:15px; color: #1d7bff"><b><?php echo date('d M Y', strtotime($artikel[0]->tanggal)); ?></b></p>
                @else
                    <p>Data masih kosong</p>
                @endif
            </div>

            <div class="col-lg-6" style="padding-top:20px; padding-bottom: 10px;">
                @forelse ($news as $row)
                    <div class="row" style="padding-bottom:10px;">
                        <div class="col-6 col-lg-5 d-flex justify-content-end">
                            <div
                                style="border-radius: 10px;height: 200px;width: 200px;background-color: #e8e8e4;display: table-cell;vertical-align:middle;text-align:center;position: relative;">
                                <img src="{{ asset('uploads/News/' . $row->gambar) }}" class="img-responsive"
                                    style="border-radius: 10px;position: absolute;top: 0;bottom: 0;left: 0;right: 0;margin: auto;">
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('detail-artikel', $row->judul_seo) }}"
                                style="font-size:18px; text-align:left; color: #001466" class="py-2"
                                class="third-child" style="color:#fff;"><b>{{ $row->judul }}</b></a>
                            <p style="font-size:12px; color: #1d7bff"><b><?php echo date('d M Y', strtotime($row->tanggal)); ?></b></p><br>
                        </div>
                    </div>
                @empty
                    <p>Data masih kosong</p>
                @endforelse
            </div>

            {{-- <div class="col-lg-3" style="padding-top:20px; padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-12">
                            <img  src="{{ URL::asset('assets/assets/berita/Asset 1.jpg') }}" style="border-radius: 10px; width:90%">
                            <a style="font-size:18px; text-align:left; color: #001466" class="py-2" href="https://www.kemendag.go.id/id/photo/kemendag-lepas-ekspor-salak-pondoh-dari-yogya-ke-kamboja" 
                                class="third-child" style="color:#fff;"><b>Kemendag Lepas Ekspor Salak Pondoh dari Yogya ke Kamboja</b></a>
                                <p style="font-size:12px; color: #1d7bff"><b>October 07,2021. Category: headline</b></p><br>
                        </div>
                        <div class="col-12">
                            <img  src="{{ URL::asset('assets/assets/berita/Asset 1.jpg') }}" style="border-radius: 10px; width:90%">
                            <a style="font-size:18px; text-align:left; color: #001466" class="py-2" href="https://www.kemendag.go.id/id/photo/kemendag-lepas-ekspor-salak-pondoh-dari-yogya-ke-kamboja" 
                                class="third-child" style="color:#fff;"><b>Kemendag Lepas Ekspor Salak Pondoh dari Yogya ke Kamboja</b></a>
                                <p style="font-size:12px; color: #1d7bff"><b>October 07,2021. Category: headline</b></p>
                        </div>
                    </div>
                </div> --}}
        </div>
    </div>
    </div>
</section>
<!-- mengapa inaexport end -->

<!-- official partner start -->
<section class="mb-20" style="background-color: #fff; padding-top: 30px; padding-bottom: 20px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style="padding-bottom: 30px;">
                <p style="font-size: 24px; font-weight:bold; text-align: center; color: #001466">USEFUL LINK</p>
            </div>
            <div class="col-md">
                <a href="https://exim.kemendag.go.id/" target="_blank"><img
                        src="{{ URL::asset('front/assets/icon/Logo_Exim_New.png') }}"
                        class="img-fluid mx-auto d-block" style="height: 87px;"></a>
            </div>
            <div class="col-md">
                <?php
                        if(Auth::guard('eksmp')->user()) {
                            if(Auth::guard('eksmp')->user()->id_role == 2) {
                                ?>
                <a href="http://inatrims.kemendag.go.id/index.php/main/negara_djpen" target="_blank"><img
                        src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}"
                        class="img-fluid mx-auto d-block" style="height: 87px;"></a>
                
                <?php
                            }
                            else {
                                ?>
                <a href="http://inatrims.kemendag.go.id/" target="_blank"><img
                        src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}"
                        class="img-fluid mx-auto d-block" style="height: 87px;"></a>
                <?php
                            }
                        }
                        else {
                            ?>
                <a href="http://inatrims.kemendag.go.id/" target="_blank"><img
                        src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}"
                        class="img-fluid mx-auto d-block" style="height: 87px;"></a>
                <?php
                        }
                    ?>
            </div>
            <div class="col-md">
                <a href="http://tr.apec.org/" target="_blank"><img
                        src="{{ URL::asset('front/assets/icon/Logo_Apec.png') }}" class="img-fluid mx-auto d-block"
                        style="height: 87px;"></a>
            </div>
            <div class="col-md">
                <a href="http://tradexpoindonesia.com/" target="_blank"><img
                        src="{{ URL::asset('front/assets/icon/trade_xpo.png') }}" class="img-fluid mx-auto d-block"
                        style="height: 87px;"></a>
            </div>
            <div class="col-md">
                <a href="https://ftacenter.kemendag.go.id/" target="_blank"><img
                        src="{{ URL::asset('front/assets/icon/fta.png') }}" class="img-fluid mx-auto d-block"
                        style="height: 87px;"></a>
            </div>
        </div>
    </div>

</section>
<!-- official partner end -->

</section>
<!-- official partner end -->

<!-- news start 
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="padding-bottom: 30px;">
                    <p style="font-size: 24px; font-weight: bold; text-align:center; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #e3e3e3;" class="py-2"><a href="{{ url('/news') }}">NEWS</a></p>
                </div>
                @foreach ($news as $key => $ns)
                <div class="col-lg-4 col-md-4 card">
                    <div class="card-body">
                        <h5 class="card-title"><b><?php //echo $ns->judul;
?></b></h5>
                        <div class="card-text">
                        <?php //echo $ns->isi_artikel;
                        ?>
                        </div>
                        <a href="{{ url('getnews/' . $ns->id . '/' . $ns->judul_seo) }}" style="color:#ff0000;">Read More <i class="fas fa-chevron-circle-right"></i></a>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </section>
news end -->

</div>
<!-- Plugins JS -->
<script src="{{ asset('front/assets/js/plugins.js') }}"></script>
<link rel="stylesheet" href="{{ url('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
    type="text/css" />
<script src="{{ url('assets') }}/libs/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="{{ url('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

@include('frontend.layouts.footer')
<script type="text/javascript">
    $('.order').inputmask({
        alias: "decimal",
        digits: 0,
        repeat: 36,
        digitsOptional: false,
        decimalProtect: true,
        groupSeparator: ".",
        placeholder: '0',
        radixPoint: ",",
        radixFocus: true,
        autoGroup: true,
        autoUnmask: false,
        onBeforeMask: function(value, opts) {
            return value;
        },
        removeMaskOnSubmit: true
    });
    $('.amount').inputmask({
        alias: "decimal",
        digits: 0,
        repeat: 36,
        digitsOptional: false,
        decimalProtect: true,
        groupSeparator: ".",
        placeholder: '0',
        radixPoint: ",",
        radixFocus: true,
        autoGroup: true,
        autoUnmask: false,
        onBeforeMask: function(value, opts) {
            return value;
        },
        removeMaskOnSubmit: true
    });

    $(function() {

        $("#companyspecialevent").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": '{!! route('bannercompanyfront.getdata') !!}',
                "dataType": "json",
                "type": "GET",
                "data": {
                    _token: '{{ csrf_token() }}',
                    id: $('#idbannernya').val(),
                }
            },
            "columns": [
                // {data: 'no'},
                {
                    data: 'no'
                },
                {
                    data: 'company'
                },

            ],
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                infoPostFix: "",
                search: "Cari:",
                url: "",
                infoThousands: ".",
                loadingRecords: "Sedang memproses...",
                paginate: {
                    first: "<<",
                    last: ">>",
                    next: "Selanjutnya",
                    previous: "Sebelum"
                },
                aria: {
                    sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                    sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                }
            }
        });
    });

    // $(function() {
    //     $('#modal-special-event').on('show.bs.modal', function(e) {
    //         idbanner = $(e.relatedTarget).data('show-id');
    //         $('#idbannernya').val(idbanner);
    //     });
    // });

    $(document).ready(function() {
        if (window.innerWidth <= 900) {
            $(".menu_item_children.next").on('click', function() {
                var href = $("a", this).attr('href');
                // window.location.href = href;
                // ada masalah dalam javascript template
            });
        }
    });

    // function modalspecialevent(a){
    //     var token = $('meta[name="csrf-token"]').attr('content');
    // 	$.get('{{ URL::to('ambilbroad3/') }}/'+a,{_token:token},function(data){
    //         $("#isibroadcast").html(data);
    //         calldata();
    //     })
    // }

    // function calldata(){
    //     var id = $('#id_laporan').val();
    //     $.ajax({
    //         method: "POST",
    //         url: "{!! url('getdatapiliheksportir') !!}",
    //         data:{_token: '{{ csrf_token() }}',id_laporan:id}
    //     })
    //     .done(function(data){
    //         $.each(data, function(i, val){
    //             $('#companyspecialevent').DataTable().row.add([val.company,'<div class="checkbox"><input class="eksportir" name="eksportir" type="checkbox" value="'+val.id+'"></div>']).draw();

    //             // $('#tabelpiliheksportir').DataTable().row.add([val.company]).draw();
    //         });
    //     });


    // }

    function openTab(tabname) {
        $('.tab-pane.product').removeClass('active');
        $('.tabnya').removeClass('active');
        $('#' + tabname).addClass('active');
    }

    function formatAmountNoDecimals(number) {
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(number)) {
            number = number.replace(rgx, '$1' + '.' + '$2');
        }
        return number;
    }

    function GoToProduct(id, e, obj) {
        e.preventDefault();
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('product.hot') }}",
            type: 'post',
            data: {
                '_token': token,
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response == 'ok') {
                    location.href = obj.href;
                }
            }
        });
    }

    <?php
    $tipe = '';
    $message = '';
    $login = 'non user';
    ?>

    function checkfirst() {
        <?php
        if (Auth::guard('eksmp')->user()) {
            if (Auth::guard('eksmp')->user()->id_role == 2) {
                $tipe = 'eksportir';
                $login = 'eksportir';
                $message = '';
            } else {
                $login = 'importir';
                $for = 'importir';
                if ($loc == 'ch') {
                    $message = '仅适用于印尼公司';
                } elseif ($loc == 'in') {
                    $message = 'Hanya untuk perusahaan Indonesia';
                } else {
                    $message = 'Only for Indonesian companies';
                }
            }
        } else {
            $login = 'non user';
            $for = 'non user';
            if ($loc == 'ch') {
                $message = '请先登录';
            } elseif ($loc == 'in') {
                $message = 'Silahkan Login Terlebih Dahulu.';
            } else {
                $message = 'Please Login to Continue.';
            }
        }
        ?>

        var tipe = '{{ $tipe }}';
        var message = '{{ $message }}';
        var login = '{{ $login }}';
        console.log(tipe);
        console.log(message);
        console.log(login);
        if (login != 'eksportir' && tipe != 'eksportir') {
            alert("{{ $message }}");
            if (login == 'non user') {
                window.location.href = "{{ url('/login') }}";
            }
        } else {
            $('#buttoncurris')[0].click();
        }

        // if()
    }

    function formatAmount(number) {

        // remove all the characters except the numeric values
        number = number.replace(/[^0-9]/g, '');

        // set the default value
        if (number.length == 0) number = "0.00";
        else if (number.length == 1) number = "0.0" + number;
        else if (number.length == 2) number = "0." + number;
        else number = number.substring(0, number.length - 2) + '.' + number.substring(number.length - 2, number.length);

        // set the precision
        number = new Number(number);
        number = number.toFixed(2); // only works with the "."

        // change the splitter to ","
        number = number.replace(/\./g, '');

        // format the amount
        x = number.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';

        return formatAmountNoDecimals(x1) + x2;
    }

    $('#neo').change(function() {
        $('#fob').html('(FOB/' + $('#neo').val() + ')')
    });

    $(".mobileClass3").click(function() {
        window.location = $(this).find("a").attr("href");
        return false;
    });
</script>
