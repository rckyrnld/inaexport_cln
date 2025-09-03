@include('frontend.layouts.header')
@php
$loc = app()->getLocale();
if ($loc == 'ch') {
    $lct = 'chn';
} elseif ($loc == 'in') {
    $lct = 'in';
} else {
    $lct = 'en';
}

if (empty(Session::get('gl')) || Session::get('gl') == 0) {
    $deflist = 0;
} else {
    $deflist = 1;
}
@endphp

<style>
    #catlist {
        font-size: 12px;
        color: #000;
    }

    .list-group-item {
        background-color: #e9e9ff;
        border: none;
        margin-bottom: -16px;
    }

    body {
        style="background-image:url('./assets/assets/versi 1/Asset 23 (1).png')!important;background-repeat: no-repeat;"
    }

    .eksporter-logo {
        padding: 5% 1% 5% 1%;
        /* background-color: #e9e9ff; */
        border-radius: 10px 10px 0px 0px;
        height: auto;
    }

    .eksporter-product {
        padding: 5% 1% 5% 1%;
    }

    /*.eksporter-product .list-group{
        height: 150px;
    }*/

    .eksporter-product .list-group-item {
        background-color: white;
    }

    .eksporter-logo2 {
        padding: 5% 1% 5% 1%;
        background-color: #e9e9ff;
        border-radius: 10px 0px 0px 10px;
        height: 100%;
    }

    .a-eksporter {
        text-decoration: none;
        color: black;
        height: auto;
    }

    @media only screen and (max-width: 767px) {
        .a-eksporter {
            height: auto;
        }
    }

    .a-eksporter:hover {
        text-decoration: none;
        /*color: #DDEFFD;*/
    }

    .eksporter_img {
        /* border-radius: 50%; */
        width: 50%;
    }

    .name-eksporter {
        font-size: 13px;
        text-align: left;
    }

    .single_product {
        padding: 0px;
    }

    .eksporter-detail:hover {
        background-color: #e9e9ff;
    }

    .eksporter-detail a:hover {
        text-decoration: none;
    }

    .eksporter-product .list-group a:hover {
        background-color: #e9e9ff;
    }

    .list-group-flush .list-group-item {
        padding-left: 0px;
    }

    .col-without-padding {
        padding-right: 0px !important;
        padding-left: 0px !important;
    }

    .search {
        border-left: 2px solid #1a70bb;
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
        height: 40px;
    }

    @media only screen and (max-width: 477px) {
        .custom-product {
            right: 0px;
            width: 93%
        }

    }

    @media only screen and (min-width: 478px) and (max-width: 767px) {
        .custom-product {
            right: 35px;
            width: 93%
        }

    }

    @media only screen and (max-width: 767px) {
        .custom-left-section {
            border-radius: 10px !important;
        }

    }

</style>

<div>

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                        <ul>
                            <li><a href="{{ url('/') }}">@lang('frontend.proddetail.home')</a></li>
                            @if ($catActive == null)
                                {{ $catActive }}
                            @endif
                            <li>Our Suppliers</li>
                        </ul>
                    </div>
                </div>
                <div class="col-7">
                    <form method="GET" action="{{ url('/suppliers') }}" id="formsupp">
                        <div class="input-group flex-nowrap" style="margin-top: 7px">
                            @php
                                if (isset($search_eks)) {
                                    $carieks = $search_eks;
                                } else {
                                    $carieks = '';
                                }
                                
                                if (isset($get_cat_eks)) {
                                    $caricateks = $get_cat_eks;
                                } else {
                                    $caricateks = '';
                                }
                            @endphp
                            <input type="text" class="form-control search" placeholder="Search supplier" style=""
                                name="cari_eksportir" value="{{ $carieks }}" id="cari_eksportir">
                            <input type="hidden" name="lctnya" value="{{ $lct }}" id="lctnya">
                            <input type="hidden" name="cat_eks" value="{{ $caricateks }}" id="cat_eks">
                            <input type="hidden" name="sorteks" id="sorteks" value="">
                            <button
                                style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                                class="btn input-group-text search" type="submit" name="search"
                                id="search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner" style="background : #e9e9ff !important">
                            <div class="widget_list widget_categories" style="background : #e9e9ff; !important">
                                <h2>@lang('frontend.liseksportir.category')</h2>
                                @php
                                    if ($loc == 'ch') {
                                        $srchcatlang = '搜索类别';
                                    } elseif ($loc == 'in') {
                                        $srchcatlang = 'Cari Kategori';
                                    } else {
                                        $srchcatlang = 'Enter a keyword to search product';
                                    }
                                @endphp
                                <input type="text" class="form-control" id="cari_kategori" name="cari_kategori"
                                    placeholder="{{ $srchcatlang }}"
                                    style="border: 1px solid rgb(170, 170, 170); font-size: 12px; border-radius:10px; background: #d1d1e5; color:#000">
                                <br>
                                <div class="list-group list-group-flush" style="background : #e9e9ff; font-size:14px;"
                                    id="catlist">
                                    @foreach ($categoryutama as $cu)
                                        @php
                                            $catprod1 = getCategoryLevel(1, $cu->id, '');
                                            $nk = 'nama_kategori_' . $lct;
                                            if ($cu->$nk == null) {
                                                $nk = 'nama_kategori_en';
                                            }
                                        @endphp
                                        @if (count($catprod1) == 0)
                                            <a href="{{ url('/perusahaan-kategori/' . $cu->id . '/' . slugifyTitle($cu->$nk)) }}"
                                                class="list-group-item">{{ $cu->$nk }}</a>
                                        @else
                                            <a onclick="openCollapse('{{ $cu->id }}')"
                                                href="#menus{{ $cu->id }}" class="list-group-item"
                                                data-toggle="collapse" data-parent="#MainMenu"> {{ $cu->$nk }} <i
                                                    class="fa fa-chevron-down caret-down" aria-hidden="true"
                                                    style="float: right; margin-right: -10px;margin-top: 3px !important;"
                                                    id="fontdrop{{ $cu->id }}"></i></a>
                                            <div class="collapse" id="menus{{ $cu->id }}">
                                                @foreach ($catprod1 as $cat1)
                                                    <a href="{{ url('/perusahaan-kategori/' . $cat1->id . '/' . slugifyTitle($cat1->$nk)) }}"
                                                        class="list-group-item">{{ $cat1->$nk }}</a>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                </div>


                <div class="col-lg-9 col-md-12">
                    <div class="mb-15 row">
                        <div class="col-md-12">
                            <img src="{{ asset('assets/assets/versi 1/Asset 29 (1).png') }}" class="d-block w-100 rounded"
                                alt="...">
                        </div>


                        <div class="col-2" style="text-align: right;">
                            <div class="breadcrumb_content">
                                <select name="shorteks" id="shorteks" style="border: none;"
                                    onchange="sortBy(this.value, '{{ $bgn }}')">
                                    <option value="" @if (isset($sortingby)) @if ($sortingby == '') selected @endif @endif>@lang('frontend.liseksportir.default')
                                    </option>
                                    <option value="asc" @if (isset($sortingby)) @if ($sortingby == 'asc') selected @endif @endif>
                                        @lang('frontend.liseksportir.eksporternm')</option>
                                </select>
                            </div>
                        </div>
                        @if (isset($urlsorting))
                            <form class="form-horizontal" enctype="multipart/form-data" method="GET"
                                action="{{ url($urlsorting) }}" id="formcateks">
                                {{ csrf_field() }}
                                <input type="hidden" name="sortekscat" id="sortekscat" value="">
                            </form>
                        @endif


                        <div class="col-8" style="text-align: right;">
                            <div class="breadcrumb_content">
                                <div class="page_amount">
                                    <p>
                                        @if ($loc == 'ch')
                                            <b>找到{{ $coeksporter }}个出口商</b>
                                        @elseif($loc == 'in')
                                            <b>{{ $coeksporter }} Eksportir</b> ditemukan
                                        @else
                                            <b>{{ $coeksporter }} Exporter</b> Found
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-2" style="text-align: right;">
                            <div class="breadcrumb_content">
                                <div class="shop_toolbar_btn">
                                    <button data-role="grid_3" onclick="inigrid()" type="button" class="btn-grid-3"
                                        data-toggle="tooltip" title="Grid"></button>
                                    <button data-role="grid_list" onclick="inilist()" type="button"
                                        class="active btn-list" data-toggle="tooltip" title="List"></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row shop_wrapper grid_list">
                        @foreach ($eksporter as $eks)
                            @php
                                $kategori = getKategoriDetail($eks->id_user);
                            @endphp
                            <div class="col-12">
                                <div class="single_product"
                                    style="padding-bottom: 0px; margin-bottom: 10px; min-height: 160px;">
                                    <div class="product_content grid_content" style="margin-top: 0px;">
                                        <div class="eksporter-logo"><!-- SafariGlutony -->
                                            <center>
                                                @php
                                                    $num_char = 40;
                                                    $eksn = $eks->company;
                                                    if (strlen($eksn) > 40) {
                                                        $cut_text = substr($eksn, 0, $num_char);
                                                        if ($eksn[$num_char - 1] != ' ') {
                                                            // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                            $cut_text = substr($eksn, 0, $new_pos);
                                                        }
                                                        $eksnama = $cut_text . '...';
                                                    } else {
                                                        $eksnama = $eksn;
                                                    }
                                                    
                                                    $param = $eks->id_user . '-' . getCompanyName($eks->id_user);
                                                @endphp
                                                <a href="{{ url('/front_end/list_perusahaan/view/' . $param) }}"
                                                    class="a-eksporter" title="{{ $eksn }}">
                                                    <span class="name-eksporter"
                                                        style="margin-top:5px"><b>{{ $eksnama }},{{ $eks->nmbadanusaha }}</b></span>
                                                </a>
                                                <br>
                                            </center>
                                            <span class="pl-2">
                                                <i class="fas fa-map-marker-alt"
                                                    aria-hidden="true"></i>&nbsp;&nbsp;{{ $eks->city }}
                                            </span>
                                            <br />
                                            <span class="pl-2">
                                                <i class="fas fa-list" aria-hidden="true"></i>&nbsp;&nbsp;
                                                @php
                                                    $nk = 'nama_kategori_' . $loc;
                                                    if ($cu->$nk == null) {
                                                        $nk = 'nama_kategori_en';
                                                    }
                                                    if (!empty($kategori)) {
                                                        foreach ($kategori as $key => $k) {
                                                            if ($key == 0) {
                                                                echo $k->$nk;
                                                            } else {
                                                                echo ', ' . $k->$nk;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            </span>
                                        </div>
                                        <div class="eksporter-product">
                                            <div class="list-group" style="font-size: 12px;height: 150px;">
                                                @php
                                                    $productnya = getProductbyEksportir($eks->id_user, 2, null, $lct);
                                                @endphp
                                                @if (count($productnya) == 0)
                                                    
											   <?php 
													 $querprod = DB::table('csc_product_single')->where('status',2)->where('id_itdp_company_user',$eks->id_user)->limit(2)->get();
													 $jml = count($querprod) > 0 ? 12 / count($querprod) : 12;
													 foreach ($querprod as $p){ ?>
                                                        <?php //echo count($querprod)." jpr ";
                                                        $imgnya = $p->image_1;
                                                        // echo $imgnya." jajaja";
                                                        if ($imgnya == null) {
                                                            $isimgnya = '/image/noimage.jpg';
                                                        } else {
                                                            $image1 = 'uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                            if (file_exists($image1)) {
                                                                $isimgnya = '/uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                            } else {
                                                                $isimgnya = '/image/noimage.jpg';
                                                            }
                                                        } ?>
														 <a href="{{ url('/front_end/product/' . $p->id) }}"
                                                            class="list-group-item"
                                                            style="padding: 0px; margin-bottom: 10px;"
                                                            title="{{ getProductAttr($p->id, 'prodname', $lct) }}"
                                                            onclick="GoToProduct('{{ $p->id }}', event, this)">
                                                            <table border="0" style="width: 100%;">
                                                                <tr>
                                                                    <td width="30%">
                                                                        <img src="{{ url('/') }}{{ $isimgnya }}"
                                                                            alt="" class="product_image" style="height:75px!important;">
                                                                    </td>
                                                                    <td width="70%" style="padding-left: 10px;">
                                                                        <b>
                                                                            <?php
                                                                            $num_char = 15;
                                                                            $text = getProductAttr($p->id, 'prodname', $lct);
                                                                            if (strlen($text) > 15) {
                                                                                $cut_text = substr($text, 0, $num_char);
                                                                                if ($text[$num_char - 1] != ' ') {
                                                                                    $new_pos = strrpos($cut_text, ' ');
                                                                                    $cut_text = substr($text, 0, $new_pos);
                                                                                }
                                                                                echo $cut_text;
                                                                            } else {
                                                                                echo $text;
                                                                            }
                                                                            ?>
                                                                        </b>
                                                                        @if (!empty(Auth::guard('eksmp')->user()))
                                                                            @if (Auth::guard('eksmp')->user()->status == 1)
                                                                                <br>
                                                                                <label style="margin-top: -30px; background-color: #1b00ff; opacity: 50%; color:white;">Price :
                                                                                <?php
                                                                                if (is_numeric($p->price_usd)) {
                                                                                    echo '$ ' . number_format($p->price_usd, 0, ',', '.');
                                                                                } else {
                                                                                    $num_char2 = 15;
                                                                                    $text2 = $p->price_usd;
                                                                                    if (strlen($text2) > 15) {
                                                                                        $cut_text = substr($text, 0, $num_char2);
                                                                                        if ($text2[$num_char2 - 1] != ' ') {
                                                                                            $new_pos = strrpos($cut_text, ' ');
                                                                                            $cut_text = substr($text2, 0, $new_pos);
                                                                                        }
                                                                                        echo $cut_text;
                                                                                    } else {
                                                                                        echo $text2;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                </label>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- <div class="row" style="width: 100%;">
                                                            <div class="col-md-4">
                                                                <img src="{{ url('/') }}{{ $isimgnya }}" alt="" class="product_image">    
                                                            </div>
                                                            <div class="col-md-8">
                                                                
                                                            </div>
                                                        </div> -->
                                                        </a>
													<?php }
														
                                                        ?>
											   <!--<a href="#" class="list-group-item"
                                                        style="padding: 0px; margin-bottom: 10px;">
                                                        <table border="0" style="width: 100%;">
                                                            <tr>
                                                                <td width="100%">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </a>
                                                    <a href="#" class="list-group-item"
                                                        style="padding: 0px; margin-bottom: 10px;">
                                                        <table border="0" style="width: 100%;">
                                                            <tr>
                                                                <td width="100%">
                                                                    <center>
                                                                        - @lang('frontend.liseksportir.prodnotfound') -
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </a> 
                                                    <a href="#" class="list-group-item"
                                                        style="padding: 0px; margin-bottom: 10px;">
                                                        <table border="0" style="width: 100%;">
                                                            <tr>
                                                                <td width="100%">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </a>-->
                                                @else
                                                    @foreach ($productnya as $p)
                                                        @php
                                                            //echo "ddddd";
                                                            $imgnya = $p->image_1;
                                                            
                                                            if ($imgnya == null) {
                                                                $isimgnya = '/uploads/Eksportir_Product/Image/131604/image_1.jpg';
                                                            } else {
                                                                $image1 = 'uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                                if (file_exists($image1)) {
                                                                    $isimgnya = '/uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                                } else {
                                                                    $isimgnya = '/uploads/Eksportir_Product/Image/131604/image_1.jpg';
                                                                }
                                                            }
                                                        @endphp
                                                        <a href="{{ url('/front_end/product/' . $p->id) }}"
                                                            class="list-group-item"
                                                            style="padding: 0px; margin-bottom: 10px;"
                                                            title="{{ getProductAttr($p->id, 'prodname', $lct) }}"
                                                            onclick="GoToProduct('{{ $p->id }}', event, this)">
                                                            <table border="0" style="width: 100%;">
                                                                <tr>
                                                                    <td width="30%">
                                                                        <img src="{{ url('/') }}{{ $isimgnya }}"
                                                                            alt="" class="product_image"
                                                                            style="height:75px!important;">
                                                                    </td>
                                                                    <td width="70%" style="padding-left: 10px;">
                                                                        <b>
                                                                            @php
                                                                                $num_char = 15;
                                                                                $text = getProductAttr($p->id, 'prodname', $lct);
                                                                                if (strlen($text) > 15) {
                                                                                    $cut_text = substr($text, 0, $num_char);
                                                                                    if ($text[$num_char - 1] != ' ') {
                                                                                        $new_pos = strrpos($cut_text, ' ');
                                                                                        $cut_text = substr($text, 0, $new_pos);
                                                                                    }
                                                                                    echo $cut_text;
                                                                                } else {
                                                                                    echo $text;
                                                                                }
                                                                            @endphp
                                                                        </b>
                                                                        @if (!empty(Auth::guard('eksmp')->user()))
                                                                            @if (Auth::guard('eksmp')->user()->status == 1)
                                                                                <br>
                                                                                <label
                                                                                    style="margin-top: -30px; background-color: #1b00ff; opacity: 50%; color:white;">Price
                                                                                    :
                                                                                    @php
                                                                                        if (is_numeric($p->price_usd)) {
                                                                                            echo '$ ' . number_format($p->price_usd, 0, ',', '.');
                                                                                        } else {
                                                                                            $num_char2 = 15;
                                                                                            $text2 = $p->price_usd;
                                                                                            if (strlen($text2) > 15) {
                                                                                                $cut_text = substr($text, 0, $num_char2);
                                                                                                if ($text2[$num_char2 - 1] != ' ') {
                                                                                                    $new_pos = strrpos($cut_text, ' ');
                                                                                                    $cut_text = substr($text2, 0, $new_pos);
                                                                                                }
                                                                                                echo $cut_text;
                                                                                            } else {
                                                                                                echo $text2;
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                </label>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="eksporter-detail"
                                            style="border-top: 1px solid #DDEFFD; padding: 4%; margin-top:22px">
                                            <center>
                                                <a href="{{ url('/front_end/list_perusahaan/view/' . $param) }}"
                                                    class="btn" style="border-radius: 15px; background-color: #ffe300; 
                                                color:#1d7bff;
                                                font-size : 14px;
                                                font-weight : bold;
                                                width : 150 px;">@lang('frontend.liseksportir.moredetail')</a>
                                                </a>
                                            </center>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 product_content list_content mx-0 my-0 px-0 py-0">
                                        <div class="col-lg-4 px-0 py-0 custom-left-section"
                                            style="background-color: #E9E9FF;border-radius: 10px 0 0 10px; min-height:100%;">
                                            <div class="px-2 mt-3">
                                                <a href="{{ url('/front_end/list_perusahaan/view/' . $param) }}"
                                                    class="a-eksporter">
                                                    <span class="name-eksporter">
                                                        <h4
                                                            style="text-transform: uppercase; font-size:14px;!important">
                                                            &nbsp;&nbsp;&nbsp;
                                                            @php
                                                                $text = $eks->company;
                                                                echo $text . ' , ' . $eks->nmbadanusaha;
                                                            @endphp
                                                        </h4>
                                                    </span>
                                                </a>
                                                <span class="pl-2">
                                                    <i class="fas fa-map-marker-alt"
                                                        aria-hidden="true"></i>&nbsp;&nbsp;{{ $eks->city }}
                                                </span>
                                                <br />
                                                <span class="pl-2">
                                                    <i class="fas fa-list" aria-hidden="true"></i>&nbsp;&nbsp;
                                                    @php
                                                        $nk = 'nama_kategori_' . $loc;
                                                        if ($cu->$nk == null) {
                                                            $nk = 'nama_kategori_en';
                                                        }
                                                        if (!empty($kategori)) {
                                                            foreach ($kategori as $key => $k) {
                                                                if ($key == 0) {
                                                                    echo $k->$nk;
                                                                } else {
                                                                    echo ', ' . $k->$nk;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 px-0 py-0">
                                            @php
                                                $productnya = getProductbyEksportir($eks->id_user, 2, null, $lct);
                                            @endphp
                                            @if (count($productnya) == 0)
                                                @php
                                                    
                                                    $querprod = DB::table('csc_product_single')
                                                        ->where('status', 2)
                                                        ->where('id_itdp_company_user', $eks->id_user)
                                                        ->limit(2)
                                                        ->get();
                                                    
                                                    $offset = '';
                                                    if (count($querprod) == 0) {
                                                        $offset = 'offset-lg-8';
                                                    } elseif (count($querprod) == 1) {
                                                        $offset = 'offset-lg-4';
                                                    }
                                                @endphp
                                                <div class="container">
                                                    <div class="row align-items-center">
                                                        <div class="{{ $offset }} col-lg-4 col-sm-12 my-lg-auto my-sm-3 py-2 custom-product order-sm-1 order-xs-1 order-lg-3"
                                                            style="float:left; padding: 3vw;">
                                                            <center>
                                                                <a href="{{ url('/front_end/list_perusahaan/view/' . $param) }}"
                                                                    class="btn"
                                                                    style="border-radius: 15px; background-color: #ffe300; 
                                                        color:#1d7bff;
                                                        font-size : 14px;
                                                        font-weight : bold;">@lang('frontend.liseksportir.moredetail')</a>
                                                                {{-- @lang('frontend.liseksportir.moredetail')&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i> --}}
                                                                </a>
                                                            </center>
                                                        </div>
                                                        @foreach ($querprod as $key => $p)
                                                            @php
                                                                $imgnya = $p->image_1;
                                                                // echo $imgnya." jajaja";
                                                                if ($imgnya == null) {
                                                                    $isimgnya = '/image/noimage.jpg';
                                                                } else {
                                                                    $image1 = 'uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                                    if (file_exists($image1)) {
                                                                        $isimgnya = '/uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                                    } else {
                                                                        $isimgnya = '/image/noimage.jpg';
                                                                    }
                                                                }
                                                            @endphp
                                                            <div class="col-lg-4 col-sm-12 py-2 custom-product order-sm-3 order-xs-3 order-lg-2"
                                                                style=" float:left" data-toggle="tooltip"
                                                                title="{{ getProductAttr($p->id, 'prodname', $lct) }}">
                                                                <a href="{{ url('/front_end/product/' . $p->id) }}"
                                                                    onclick="GoToProduct('{{ $p->id }}', event, this)">
                                                                    <div class="card text-center"
                                                                        style="background: #e8e8e4">
                                                                        <img class="card-img-top product_image my-auto"
                                                                            src="{{ url('/') }}{{ $isimgnya }}"
                                                                            alt="{{ getProductAttr($p->id, 'prodname', $lct) }}"
                                                                            style="max-height: 150px !important; object-fit: contain; background: #e8e8e4">

                                                                        @if (!empty(Auth::guard('eksmp')->user()))
                                                                            @if (Auth::guard('eksmp')->user()->status == 1)
                                                                                {{-- <br> --}}
                                                                                <label
                                                                                    style="margin-top: -30px; background-color: #1b00ff; opacity: 50%; color:white;">Price
                                                                                    :
                                                                                    @php
                                                                                        if (is_numeric($p->price_usd)) {
                                                                                            echo '$ ' . number_format($p->price_usd, 0, ',', '.');
                                                                                        } else {
                                                                                            $num_char2 = 15;
                                                                                            $text2 = $p->price_usd;
                                                                                            if (strlen($text2) > 15) {
                                                                                                $cut_text = substr($text, 0, $num_char2);
                                                                                                if ($text2[$num_char2 - 1] != ' ') {
                                                                                                    $new_pos = strrpos($cut_text, ' ');
                                                                                                    $cut_text = substr($text2, 0, $new_pos);
                                                                                                }
                                                                                                echo $cut_text;
                                                                                            } else {
                                                                                                echo $text2;
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                </label>
                                                                            @endif
                                                                        @endif

                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach


                                                    </div>
                                                </div>
                                            @else
                                                @php
                                                    $jml = count($productnya) == 1 ? 4 : (count($productnya) > 1 ? 8 / count($productnya) : 4);
                                                    $offset = '';
                                                    if (count($productnya) == 1) {
                                                        $offset = 'offset-lg-4';
                                                    } elseif (count($productnya) == 0) {
                                                        $offset = 'offset-lg-8';
                                                    }
                                                @endphp
                                                <div class="container">
                                                    <div class="row align-items-center">
                                                        <div class="{{ $offset }} col-lg-4 col-sm-12 my-lg-auto my-sm-3 py-2 custom-product order-sm-1 order-xs-1 order-lg-3"
                                                            style="float:left; padding: 3vw;">
                                                            <center>
                                                                <a href="{{ url('/front_end/list_perusahaan/view/' . $param) }}"
                                                                    class="btn"
                                                                    style="border-radius: 15px; background-color: #ffe300; 
                                                        color:#1d7bff;
                                                        font-size : 14px;
                                                        font-weight : bold;">@lang('frontend.liseksportir.moredetail')</a>
                                                                </a>
                                                            </center>
                                                        </div>
                                                        @foreach ($productnya as $key => $p)
                                                            @php
                                                                $imgnya = $p->image_1;
                                                                // echo $imgnya." jajaja";
                                                                if ($imgnya == null) {
                                                                    $isimgnya = '/image/noimage.jpg';
                                                                } else {
                                                                    $image1 = 'uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                                    if (file_exists($image1)) {
                                                                        $isimgnya = '/uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                                    } else {
                                                                        $isimgnya = '/image/noimage.jpg';
                                                                    }
                                                                }
                                                            @endphp
                                                            <div class="col-lg-{{ $jml }} col-sm-12 py-2 custom-product order-sm-3 order-xs-3 order-lg-2"
                                                                style="float:left" data-toggle="tooltip"
                                                                title="{{ getProductAttr($p->id, 'prodname', $lct) }}">
                                                                <a href="{{ url('/front_end/product/' . $p->id) }}"
                                                                    onclick="GoToProduct('{{ $p->id }}', event, this)">
                                                                    <div class="card text-center"
                                                                        style="background: #e8e8e4">
                                                                        <img class="card-img-top product_image my-auto"
                                                                            src="{{ url('/') }}{{ $isimgnya }}"
                                                                            alt="{{ getProductAttr($p->id, 'prodname', $lct) }}"
                                                                            style="max-height: 150px !important;object-fit: contain; background: #e8e8e4;">
                                                                        {{-- <div class="card-body"> --}}
                                                                        {{-- <h5 class="card-title" style="color: #1d7bff"> --}}
                                                                        @if (!empty(Auth::guard('eksmp')->user()))
                                                                            @if (Auth::guard('eksmp')->user()->status == 1)
                                                                                {{-- <br> --}}
                                                                                <label
                                                                                    style="margin-top: -30px; background-color: #1b00ff; opacity: 50%; color:white;">Price
                                                                                    :
                                                                                    @php
                                                                                        if (is_numeric($p->price_usd)) {
                                                                                            echo '$ ' . number_format($p->price_usd, 0, ',', '.');
                                                                                        } else {
                                                                                            $num_char2 = 15;
                                                                                            $text2 = $p->price_usd;
                                                                                            if (strlen($text2) > 15) {
                                                                                                $cut_text = substr($text, 0, $num_char2);
                                                                                                if ($text2[$num_char2 - 1] != ' ') {
                                                                                                    $new_pos = strrpos($cut_text, ' ');
                                                                                                    $cut_text = substr($text2, 0, $new_pos);
                                                                                                }
                                                                                                echo $cut_text;
                                                                                            } else {
                                                                                                echo $text2;
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                </label>
                                                                            @endif
                                                                        @endif
                                                                        {{-- </h5> --}}
                                                                        {{-- </div> --}}
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                        
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <br>
                    @if ($coeksporter > 12)
                        <!-- <div class="shop_toolbar t_bottom"> -->
                        <div class="pagination justify-content-center pb-3" style="float: center;">
                            {{ $eksporter->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('front/assets/js/plugins.js') }}"></script>
    @include('frontend.layouts.footer')

    <script type="text/javascript">
        $(document).ready(function() {
            var deflist = '{{ $deflist }}';
            if (deflist == 0) {
                $('.btn-list').trigger('click');
            } else {
                $('.btn-grid-3').trigger('click');
            }
            $("#cari_kategori").keyup(function() {
                var isi = this.value;
                $.ajax({
                    url: "{{ route('front.eksportir.getCategory') }}",
                    type: 'get',
                    data: {
                        name: isi,
                        loc: "{{ $lct }}"
                    },
                    success: function(response) {
                        $("#catlist").html("");
                        $("#catlist").html(response);
                    }
                });
            });
        });

        function sortBy(val, jenis) {
            var a = '{{ url('') }}';
            if (val == "asc") {
                window.location.href = a + '/suppliers?sorteks=asc';
            } else {
                window.location.href = a + '/suppliers?sorteks=new';
            }
        }

        function openCollapse(col) {
            $('div').not('#menus' + col).removeClass('show');
            if ($("#fontdrop" + col).hasClass("fa-chevron-down")) {
                $('#fontdrop' + col).removeClass('fa-chevron-down');
                $('#fontdrop' + col).addClass('fa-chevron-up');
            } else {
                $('#fontdrop' + col).removeClass('fa-chevron-up');
                $('#fontdrop' + col).addClass('fa-chevron-down');
            }

            $('i.caret-down').not('#fontdrop' + col).removeClass('fa-chevron-up');
            $('i.caret-down').not('#fontdrop' + col).addClass('fa-chevron-down');

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

        function inilist() {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.get('{{ URL::to('change_lg/') }}/0', {
                _token: token
            }, function(data) {
                console.log('change grid');
            })
        }

        function inigrid() {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.get('{{ URL::to('change_lg/') }}/1', {
                _token: token
            }, function(data) {
                console.log('change grid');
            })
        }
    </script>
