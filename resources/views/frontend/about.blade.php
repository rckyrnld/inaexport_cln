<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Bethany - v4.7.0
  * Template URL: https://bootstrapmade.com/bethany-free-onepage-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

@include('frontend.layouts.header')
<!-- Kontent 1-->
<style>
    ul.a {
        list-style-type: disc;
        /* list-style-position: inside; */
    }

    .text {
        color: white;
        font-size: 12px;
        padding: 10px 22px;
    }

    .numberbg {
        background-image: linear-gradient(180deg, #04135E, #182C8E);
        border-radius: 16px;
    }

    .txtbg {
        /* background: rgba(0, 0, 0, 0.3); */
        background: url('./assets/assets/home/about-bg.png');
        background-size: cover;
        color: #fff;
        border-radius: 16px;
    }

    body {
        font-family: "Open Sans", sans-serif;
        color: #444444;
    }

    a {
        color: #009970;
        text-decoration: none;
    }

    a:hover {
        color: #00cc95;
        text-decoration: none;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Raleway", sans-serif;
    }

    /*--------------------------------------------------------------
 # About
 --------------------------------------------------------------*/
    .about .content h2 {
        font-weight: 700;
        font-size: 48px;
        line-height: 60px;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .about .content h3 {
        font-weight: 500;
        line-height: 32px;
        font-size: 24px;
    }

    .about .content h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 30px 0;
    }

    .about .content ul {
        list-style: none;
        padding: 0;
    }

    .about .content ul li {
        padding: 40px 30px;
        position: relative;
    }

    .about .content ul i {
        font-size: 20px;
        color: #009970;
        padding: 40px 30px;
    }

    .about .content p:last-child {
        margin-bottom: 0;
    }

    /*--------------------------------------------------------------
 # Why Us
 --------------------------------------------------------------*/
    .why-us .content {
        padding: 30px;
        background: #009970;
        border-radius: 4px;
        color: #fff;
        padding: 40px 30px;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
    }

    .why-us .content h3 {
        font-weight: 700;
        font-size: 34px;
        margin-bottom: 30px;
    }

    .why-us .icon-boxes .icon-box {
        text-align: left;
        border-radius: 10px;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
        padding: 40px 30px;
        width: 100%;
        transition: 0.3s;
    }

    .why-us .icon-boxes .icon-box i {
        font-size: 40px;
        color: #009970;
        margin-bottom: 30px;
    }

    .why-us .icon-boxes .icon-box h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 30px 0;
    }

    .scroll-box {
        overflow-y: scroll;
        height: 47.5%;
        padding: 1rem;
    }

    .btnright {
        float: right;
    }

    .section-bg .icon-boxes .icon-box {
        text-align: left;
        border-radius: 10px;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
        padding: 40px 30px;
        width: 100%;
        transition: 0.3s;
    }

    .section-bg .icon-boxes .icon-box i {
        font-size: 40px;
        color: #009970;
        margin-bottom: 30px;
    }

    .section-bg .icon-boxes .icon-box h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 30px 0;
    }

    .section-bg .icon-box:hover {
        box-shadow: 0 0 15px rgba(194, 216, 255, 1);
        background-color: #E5FFF8;
    }

</style>
<!-- <div class="container" style="padding-bottom: 30px;">
    <div class="row">
        <div class="col-lg-12 col-12" style="padding-top: 30px; padding-bottom: 10px; height: 100%;">
   <p><span style="font-size: 18px;"><b>@lang("frontend.about")</b></span></p>
   <p style="text-align : justify">@lang("frontend.about-det.1")</p>
   <p style="text-align : justify">@lang("frontend.about-det.2")</p>
   <ul class="a" >
    <li>
     <p style="text-align : justify">
      @lang("frontend.about-det.4")
     </p>
    </li>
    <li >
     <p style="text-align : justify">
     @lang("frontend.about-det.4")
     </p>
    </li>
    <li>
     <p style="text-align : justify">
    @lang("frontend.about-det.5")
     </p>
    </li>
   </ul>
  </div>
 </div>-->
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
//echo "about";
?>
<div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-5">
                <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>@lang('frontend.home.about_inaexport')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container pb-4" style="border-bottom: 1px solid #e3e3e3;">
    {{-- <div class="col-lg-12" style="border-bottom: 1px solid #e3e3e3;">
        <div class="row breadcrumb_content">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>About Inaexport</li>
            </ul>
        </div>
    </div> --}}
    <div class="row pt-4">
        <div class="col-lg-12 col-12 mt-4">
            <div class="container">
                <div class="row numberbg" style="margin:0px auto; padding: 0px auto;">
                    <div class="col-lg-12 txtbg" style="padding-bottom: 50px;">
                        <div class="col-12" style="padding-top: 50px; padding-bottom: 60px;">
                            <p style="text-align:center; font-size: 40px;"><b>@lang('frontend.home.about_inaexport_2')</b>
                            </p>
                        </div>
                        <!-- inaexport numbers start -->
                        <div class="col-lg-12 row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10" style="text-align: center; padding-bottom: 15px;">
                                <p style="text-align:center;"><span
                                        style="font-size: 26px;">@lang('frontend.home.about_inaexport_note')</span></p>
                            </div>
                            <div class="col-lg-1"></div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <section id="why-us" class="why-us" style="height: 350px">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="icon-boxes d-flex flex-column justify-content-left">
                                <p style="text-align:center; color:#001466; font-size:25px">
                                    <span>@lang('frontend.home.platform_goals')</span>
                                </p>
                                <br />
                                <div class="col-lg-12 d-flex align-items-stretch">
                                    <div class="icon-boxes d-flex flex-column justify-content-left">
                                        <div class="row" style="padding: 0 64px 0 64px">
                                            <div class="col-xl-4 d-flex align-items-stretch">
                                                <div class="icon-box mt-4 mt-xl-0">
                                                    <p style="text-align:center; font-size:20px; color:#001466;">
                                                        <span>@lang('frontend.home.platform_goals_to_connect')</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 d-flex align-items-stretch">
                                                <div class="icon-box mt-4 mt-xl-0">
                                                    <p style="text-align:center; font-size:20px; color:#001466;">
                                                        <span>@lang('frontend.home.platform_goals_to_promote')</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 d-flex align-items-stretch">
                                                <div class="icon-box mt-4 mt-xl-0">
                                                    <p style="text-align:center; font-size:20px; color:#001466;">
                                                        <span>@lang('frontend.home.platform_goals_to_provide')</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-xl-6 d-flex align-items-stretch">
                                        <div class="icon-box mt-4 mt-xl-0" style="background: #009970; color: #fff">
                                            <i class="bx bx-receipt"></i>
                                            <ul class="a" style="text-align:justify;">
                                                <h4>Verified Suppliers</h4>
                                                <li>Inaexport ensures that each company registered in Inaexport.id has
                                                    been verified and legally registered in the official Indonesian
                                                    government institution.</li>
                                                <li>Only certified companies and those who comply with export
                                                    compliances are eligible to be listed in Inaexport.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 d-flex align-items-stretch">
                                        <div class="icon-box mt-4 mt-xl-0">
                                            <i class="bx bx-cube-alt"></i>
                                            <ul class="a" style="text-align:justify;">
                                                <h4>Sustainable Trade</h4>
                                                <li>Inaexport members are encouraged to actively participate in
                                                    sustainable trade practices and produce sustainable products.</li>
                                                <li>The Indonesian government continues to encourage the implementation
                                                    of sustainability aspects proclaimed by the UN to be applied to
                                                    suppliers of Inaexport members and to encourage Inaexport members to
                                                    obtain various certificates, both national and international, which
                                                    comply with sustainable trade.</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300" >
										<div class="icon-box mt-4 mt-xl-0" style="background: #009970; color: #fff">
											<i class="bx bx-images"></i>
											<h4>Diverse Products</h4>
											<li>With its vast and abundant fertile soile and forest and marine resources, Indonesia is a major key producer of a wide variety of agri and aquaculture, mining, and forestry products. The agricultural sector is an important source of income and employment. Indonesia has a population of approximately 265 million, of which 120 million live in rural areas, and 50 million of them are economically active in agriculture.</li>
											<li>Currently, Indonesia offers a wide variety of products to the world, ranging from products based on natural resources such as agricultural products, mining products, either in the form of raw materials or in processed form. </li>
											<li>In addition, Indonesia also produces industrial products such as processed food products, textile products, electronic products, automotive products and other manufacturing products.</li>
											<li>What is equally important is that Indonesia is also known as a producer of handy craft products and one of the best furniture producer in the world, which is proven that these products can be accepted in various markets around the world.</li>
											<li>With progressive technology, Indonesians are also able to produce high-tech products that are in demand of many countries, such as airplanes, weaponry products, trains and others.</li>
										</div>
									</div>
                                </div> --}}
                            </div><!-- End .content-->
                        </div>
                        {{-- <div class="col-lg-4 d-flex align-items-stretch">
                            <div class="content scroll-box">
                                <h4 style="font-size: 20px">Diverse Products</h4>
                                <br>
                                <ul class="a" style="text-align:justify;">
                                    <li>With its vast and abundant fertile soil, forest, and marine resources, Indonesia
                                        is a major key producer of a wide variety of agriculture, aquaculture, mining,
                                        and forestry products. The agricultural sector is an important source of income
                                        and employment. Indonesia has a population of approximately 265 million, of
                                        which 120 million live in rural areas, and 50 million of them are economically
                                        active in agriculture.</li>
                                    <li>Currently, Indonesia offers a wide variety of products to the world, ranging
                                        from products based on natural resources such as agricultural products and
                                        mining products, either in the form of raw materials or in processed form.</li>
                                    <li>In addition, Indonesia also produces industrial products such as processed food
                                        products, textile products, electronic products, automotive products, and other
                                        manufacturing products.</li>
                                    <li>What is equally important is that Indonesia is also recognized as producer of
                                        handicraft products and one of the best furniture producers in the world, which
                                        proves that these products can be accepted in various markets around the world.
                                    </li>
                                    <li>With progressive technology, Indonesians are also able to produce high-tech
                                        products that are in demand of many countries, such as airplanes, weaponry,
                                        trains, and others.</li>
                                </ul>
                            </div>
                        </div> --}}

                    </div>
                    <br>
                </div>
                <p style="text-align:center; font-size:20px; color:#001466;">
                    <span>@lang('frontend.home.through_this_platform')</span>
                </p>
                <br>
            </section><!-- End Why Us Section -->
            <!-- Inaexport Fact -->
            <div id="inaexport_fact" class="container" style="padding-top: 4vh; padding-bottom: 0px;">
                <section style="padding-top:0px; background-color: #fff;">
                    <div class="row"
                        style="margin:0px auto; padding: 0px auto;background-color:#fff!important; /* background-image:url('./assets/assets/home/export-containers.jpg')!important; background-size: cover;border-radius:10px; */">
                        <div class="col-12" align="center"
                            style="padding-bottom: 25px;border-radius:10px;background-color:#fff!important;">
                            <div class="col-12" style="padding-top: 5px; padding-bottom: 25px;">
                                <p style="text-align:center; font-size: 24px;">@lang('frontend.home.whats_in') <b
                                        style="color:#001466">@lang('frontend.home.inaexport')</b></p>
                            </div>
                            <div class="col-lg-12 row">

                                <div class="col-12"></div>
                                <div class="col text-center mobileClass rounded-left"
                                    style="padding: 25px 0px 25px 0px;background: #375BB7;">
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
                                <div class="col text-center mobileClass"
                                    style="padding: 25px 0px 25px 0px;background: #142F67;">
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
                                <div class="col text-center mobileClass"
                                    style="padding: 25px 0px 25px 0px;background: #A70606;">
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

                                </div>
                                <div class="col text-center mobileClass"
                                    style="padding: 25px 0px 25px 0px;background: #CA3403;">
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
                                <div class="col text-center mobileClass rounded-right"
                                    style="padding: 25px 0px 25px 0px;background: #D4D400;">
                                    {{-- <a href="#"> --}}
                                    {{-- <div class="border border-white"
                                    style="border-radius: 100%; width:140px; height:140px; background-color:#ff8021; text-align: center; padding-bottom: 12px;"> --}}
                                    <!--<img src="{{ asset('front/assets/img/representative.png') }}" alt="" style="width: 30px;margin-left: 10%; float:left">-->
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
                                    {{-- </div> --}}
                                    {{-- </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <br>
            <div class="col-lg-12 col-12 mt-4" style="float: right;z-index:1;">
                <div class="row">
                    <div class="col-lg-12 ">
                        <a href="{{ url('/suppliers') }}" class="btn btn-primary my-3" style="border-radius: 5px;"><i
                                class="fas fa-search"></i>&nbsp; Find Inaexport Suppliers</a>
                    </div>
                </div>
            </div>
            <!-- ======= About Section ======= -->
            <section id="about" class="about section-bg">
                <div class="container" data-aos="fade-up">
                    <div class="col-lg-12 col-12 mt-4">
                        <div class="container pt-3">
                            {{-- <p style="text-align:center;"><span style="color: #012750; font-size: 25px;"><b>ABOUT
                                        INAEXPORT</b></span></p>
                            <hr>
                            <p style="text-align:center;"><span style="font-size: 15px;"><b>Inaexport is the official
                                        B2B directories platform of the Directorate General
                                        of National Export Development, Ministry of Trade of the Republic of Indonesia,
                                        which was developed at the end of 2019.</b></span></p>
                            <br> --}}
                            <p style="text-align: center;"><span
                                    style="color: #007bff; font-size: 20px;"><b>@lang('frontend.home.are_you_buyer')</b></span>
                                <br>
                            <div class="col-lg-12 d-flex align-items-stretch"
                                style="background: #F5F5F5 ; padding: 40px 30px;">
                                <div class="d-flex flex-column justify-content-left">
                                    <div class="row">
                                        <div class="col-xl-4 d-flex align-items-stretch">
                                            <div class="mt-4 mt-xl-0">
                                                <p style="text-align:justify;">
                                                    <span>@lang('frontend.home.use_inaexport_platform')
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 d-flex align-items-stretch">
                                            <div class="mt-4 mt-xl-0">
                                                <p style="text-align:justify;">
                                                    <span>@lang('frontend.home.after_submitting_inquiry')</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 d-flex align-items-stretch">
                                            <div class="mt-4 mt-xl-0">
                                                <p style="text-align:justify;">
                                                    <span>@lang('frontend.home.to_able_submit')</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </p>
                            <a href="{{ url('/createnewaccount?reg=buyer') }}" class="btn btn-primary my-2 btnright"
                                style="border-radius: 8px;"><i class="fas fa-clipboard-list"></i>&nbsp; Register as
                                Buyers</a>
                            <br>
                            <br>
                            <p class="pt-3" style="text-align: center"><span
                                    style="color: #007bff; font-size: 20px;"><b>@lang('frontend.home.are_you_supplier')</b></span>
                                <br>
                            <div class="col-lg-12 d-flex align-items-stretch">
                                <div class="d-flex flex-column justify-content-left">
                                    <div class="row">
                                        <br>
                                        <div class="col-xl-6 d-flex align-items-stretch">
                                            <div class="mt-4 mt-xl-0">
                                                <ul class="a" style="text-align:justify;">
                                                    <p style="text-align:justify;"><span>
                                                            <li>@lang('frontend.home.for_those_indonesian_companies')
                                                            </li>
                                                        </span></p>
                                                </ul>
                                                {{-- <p style="text-align:justify;"><span><li>For those of you Indonesian companies who have met the export requirements and compliances, you can register your company profile in Inaexport.id platform and be found by buyers worldwide.</li></span></p> --}}
                                            </div>
                                        </div>
                                        <div class="col-xl-6 d-flex align-items-stretch">
                                            <div class="mt-4 mt-xl-0">
                                                <ul class="a" style="text-align:justify;">
                                                    <p style="text-align:justify;"><span>
                                                            <li>@lang('frontend.home.through_inaexport_platform')</li>
                                                        </span></p>
                                                </ul>
                                                {{-- <p style="text-align:justify;"><span><li>Through Inaexport platform, your company profile and products can be accessed online by buyers and trade representatives worldwide. Make sure to display detailed information about your company, such as product images, summary of company profile, and your product specifications.</li></span></p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-lg-12 d-flex align-items-stretch">
                                <div class="d-flex flex-column justify-content-left">
                                    <div class="row">
                                        <div class="col-xl-6 d-flex align-items-stretch">
                                            <div class="mt-4 mt-xl-0">
                                                <ul class="a" style="text-align:justify;">
                                                    <p style="text-align:justify;"><span>
                                                            <li>@lang('frontend.home.as_registered_member_inaexport_access_buyer')</li>
                                                        </span></p>
                                                </ul>
                                                {{-- <p style="text-align:justify;"><span><li>As registered member of Inaexport, you will have access to buyers’ inquiries and will be able to communicate directly with the buyers and representative of Ministry of Trade (Indonesian trade attaché, ITPC).</li></span></p> --}}
                                            </div>
                                        </div>
                                        <div class="col-xl-6 d-flex align-items-stretch">
                                            <div class="mt-4 mt-xl-0">
                                                <ul class="a" style="text-align:justify;">
                                                    <p style="text-align:justify;"><span>
                                                            <li>@lang('frontend.home.as_registered_member_inaexport_access_trade_news')</li>
                                                        </span></p>
                                                </ul>
                                                {{-- <p style="text-align:justify;"><span><li>As registered member of Inaexport, you will have access to the trade news and market reports from representatives of the Ministry of Trade, the Embassy of the Republic of Indonesia and from the Consul General of the Republic of Indonesia in respective countries. And be the first one to receive update about trade statistics, workshops, training, and trade show participation.</li></span></p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </p>
                            <a href="{{ url('/createnewaccount?reg=exporter') }}"
                                class="btn btn-primary my-2 btnright" style="border-radius: 8px;"><i
                                    class="fas fa-clipboard-list"></i>&nbsp; Register as
                                Indonesian Suppliers</a>
                        </div>
                    </div>
                </div>
            </section><!-- End About Section -->
            <br>
        </div>
    </div>
</div>

@include('frontend.layouts.footer')


</html>
