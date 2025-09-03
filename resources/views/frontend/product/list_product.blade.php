@include('frontend.layouts.header')
<?php

//test
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

if (empty(Session::get('gl')) || Session::get('gl') == 0) {
    $deflist = 0;
} else {
    $deflist = 1;
}
?>
<style>
    #catlist {
        font-size: 14px;
        color: #000;
    }

    .select2-results__options {
        font-size: 12px !important;
    }

    .select2-selection__rendered {
        font-size: 12px !important;
    }

    .list-group-item {
        background-color: #e9e9ff;
        border: none;
        margin-bottom: -16px;
    }

    .hover-none:hover,
    .hover-none:active {
        color: #007bff !important;
        cursor: context-menu;
        text-decoration: none;
    }

    .href-name {
        color: black;
    }

    .href-name:hover {
        text-decoration: none;
    }

    .href-company {
        text-transform: capitalize;
        font-size: 14px;
        font-family: 'Open Sans', sans-serif;
        /*color: black;*/
    }

    .href-company:hover {
        text-decoration: none;
        color: black !important;
    }

    .href-category {
        text-transform: capitalize;
        font-size: 14px !important;
        font-family: 'Open Sans', sans-serif;
    }

    .href-category:hover {
        text-decoration: none;
        /*color: #2777d0 !important;*/
    }

    .single_product:hover {
        box-shadow: 0 0 15px rgba(178, 221, 255, 1);
    }

    .cat-prod:hover {
        text-decoration: none;
    }

    #delete_cat {
        margin-left: 10px;
        font-size: 12px;
        color: #c4a6a6;
        cursor: pointer;
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

    .breadcrumbs_area>li+li:before {
        content: "\3E"
    }

    .select2-container--default .select2-selection--single {
        font-size: 12px;
        border-radius: 10px;
        background: #d1d1e5;
        color: #000
    }

    .form-range {
        color: #71b841;
    }

    .slidecontainer {
        width: 100%;
    }

    .slider {
        -webkit-appearance: none;
        width: 100%;
        height: 5px;
        background: #8ac359;
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
    }

    .slider:hover {
        opacity: 1;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 5px;
        height: 20px;
        background: #70b741;
        cursor: pointer;
    }

    .slider::-moz-range-thumb {
        width: 20px;
        height: 25px;
        background: #70b741;
        cursor: pointer;
    }

    .list-group-flush .list-group-item {
        padding-left: 0px;
    }

    .col-without-padding {
        padding-right: 0px !important;
        padding-left: 0px !important;
        display: flex;
    }

    .select2 {
        width: 100% !important;
    }

    .search {
        border-left: 2px solid #1a70bb;
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
        height: 40px;
    }

</style>

<!--breadcrumbs area start-->
<div class="breadcrumbs_area" style="background-color:#FFFFFF">
    @if (isset($page))
        @if (isset($banner))
            <!-- <div class="container-fluid" style="padding-left: 0px;padding-right: 0px;"> -->
            <div class="container" style="padding-left: 0px;padding-right: 0px;">
                <p>
                    <img style="width:100%; max-width: 100%;heigth:231px"
                        src="{{ asset('uploads/banner/') }}/{{ $banner->file }}" alt="">
                    <!-- <img class="img-fluid" style="width:100%; max-width: 100%;heigth:231px" src="{{ asset('uploads/banner/') }}/{{ $banner->file }}" alt=""> -->
                </p>
            </div>
        @endif
    @endif
</div>
<!--breadcrumbs area end-->

{{-- <div style="background-image:url('./assets/assets/versi 1/Asset 23 (1).png')!important;"> --}}
<div>
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-12 pt-sm-2">
                    <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                        <ul>
                            <li><a href="{{ url('/') }}">@lang('frontend.proddetail.home')</a></li>
                            @if ($catActive == null)
                                {{-- <li><a href="{{url('kategori')}}">@lang('frontend.proddetail.default')</a></li>
                            @else --}}
                                <?php echo $catActive; ?>
                            @endif
                            <li>Our Products</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 col-sm-12 pb-sm-2">
                    <form method="GET" action="{{ url('/products') }}" id="formsprod">
                        <div class="input-group flex-nowrap" style="margin-top: 7px">
                            <input style="" type="text" class="form-control search"
                                placeholder="@lang('frontend.home.cariproduct')" style="border-radius: 0px;"
                                name="cari_produk" value="{{ isset($cari_produk) ? $cari_produk : '' }}"
                                id="cari_produk">
                            <input type="hidden" name="lctnya" value="{{ isset($lct) ? $lct : '' }}" id="lctnya">
                            <input type="hidden" name="eks_prod" value="{{ isset($getEks) ? $getEks : '' }}"
                                id="eks_prod">
                            <input type="hidden" name="hl_prod" value="{{ isset($hl_sort) ? $hl_sort : '' }}"
                                id="hl_prod">
                            <input type="hidden" name="cari_catnya" value="{{-- (isset($get_id_cat)) ? $get_id_cat : '' --}}" id="cari_catnya">
                            <input type="hidden" name="sort_prod"
                                value="{{ isset($sortbyproduct) ? $sortbyproduct : '' }}" id="sort_prod">
                            <button
                                style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                                class="btn" type="submit" name="search" id="search" title="Search"
                                class="input-group-text submit">&nbsp;Search&nbsp;</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--shop  area start-->
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">

                    <!--sidebar widget start-->
                    <aside class="sidebar_widget" style="border-radius: 20px;">
                        <div class="widget_inner" style="background : #e9e9ff !important">
                            <div class="widget_list widget_categories" style="background : #e9e9ff; !important">
                                <h2>@lang('frontend.liseksportir.category')</h2>
                                <?php
                                if ($loc == 'ch') {
                                    $srchcatlang = '搜索类别';
                                } elseif ($loc == 'in') {
                                    $srchcatlang = 'Cari Kategori';
                                } else {
                                    $srchcatlang = 'Enter a keyword to search product';
                                }
                                ?>
                                @if (isset($page))
                                    <input type="text" class="form-control" id="cari_kategori" name="cari_kategori"
                                        disabled placeholder="{{ $srchcatlang }}"
                                        style="    border: 1
                                    px
                                     solid rgb(170, 170, 170); font-size: 12px; border-radius:10px; background: #d1d1e5; color:#000">
                                @else
                                    <input type="text" class="form-control" id="cari_kategori" name="cari_kategori"
                                        placeholder="{{ $srchcatlang }}"
                                        style="    border: 1
                                    px
                                     solid rgb(170, 170, 170); font-size: 12px; border-radius:10px; background: #d1d1e5; color:#000">
                                @endif
                                <br>
                                <div class="list-group list-group-flush" id="catlist">
                                    @foreach ($categoryutama as $cu)
                                        <?php
                                        $catprod1 = getCategoryLevelNew(1, $cu->id, '');
                                        $nk = 'nama_kategori_' . $lct;
                                        if ($cu->$nk == null) {
                                            $nk = 'nama_kategori_en';
                                        }
                                        ?>
                                        @if (count($catprod1) == 0)
                                            @if (isset($page))
                                                <a class="list-group-item">{{ $cu->$nk }}</a>
                                            @else
                                                <a href="{{ url('/kategori/' . $cu->id . '/' . slugifyTitle($cu->nama_kategori_en) . '/') }}"
                                                    class="list-group-item">{{ $cu->$nk }}</a>
                                            @endif
                                        @else
                                            <div class="list-group-item">
                                                @if (isset($page))
                                                    <a class="cat-prod"> {{ $cu->$nk }}</a><a><i
                                                            class="fa fa-chevron-down" aria-hidden="true"
                                                            style="float: right; margin-right: -10px; margin-top: 3px !important"
                                                            id="fontdrop{{ $cu->id }}"></i></a>
                                                @else
                                                    <a class="cat-prod"
                                                        href="{{ url('/kategori/' . $cu->id . '/' . slugifyTitle($cu->nama_kategori_en) . '/') }}">
                                                        {{ $cu->$nk }}</a><a
                                                        onclick="openCollapse(' {{ $cu->id }}')"
                                                        href="#menus{{ $cu->id }}" data-toggle="collapse"
                                                        data-parent="#MainMenu"><i class="fa fa-chevron-down"
                                                            aria-hidden="true"
                                                            style="float: right; margin-right: -10px; margin-top: 3px !important;"
                                                            id="fontdrop{{ $cu->id }}"></i></a>
                                                @endif
                                            </div>
                                            <div class="collapse" id="menus{{ $cu->id }}">
                                                @foreach ($catprod1 as $cat1)
                                                    <?php
                                                    $catprod2 = getCategoryLevelNew(2, $cu->id, $cat1->id);
                                                    $nk = 'nama_kategori_' . $lct;
                                                    if ($cat1->$nk == null) {
                                                        $nk = 'nama_kategori_en';
                                                    }
                                                    ?>
                                                    @if (count($catprod2) == 0)
                                                        <a href="{{ url('/kategori/' . $cat1->id . '/' . slugifyTitle($cat1->$nk) . '/') }}"
                                                            class="list-group-item"
                                                            style="margin-left: 10px;">{{ $cat1->$nk }}</a>
                                                    @else
                                                        <div class="list-group-item" style="margin-left: 10px;">
                                                            <a class='cat-prod'
                                                                href="{{ url('/kategori/' . $cat1->id . '/' . slugifyTitle($cat1->$nk) . '/') }}">
                                                                {{ $cat1->$nk }} </a>
                                                            <a onclick="openCollapse('{{ $cat1->id }}')"
                                                                href="#menus{{ $cat1->id }}" data-toggle="collapse"
                                                                data-parent="#SubMenu"><i class="fa fa-chevron-down"
                                                                    aria-hidden="true"
                                                                    style="float: right; margin-right: -10px; margin-top: 3px !important;"
                                                                    id="fontdrop{{ $cat1->id }}"></i></a>
                                                        </div>
                                                        <div class="collapse" id="menus{{ $cat1->id }}">
                                                            @foreach ($catprod2 as $cat2)
                                                                <?php
                                                                $catprod2 = getCategoryLevelNew(2, $cu->id, $cat1->id);
                                                                $nk = 'nama_kategori_' . $lct;
                                                                if ($cat2->$nk == null) {
                                                                    $nk = 'nama_kategori_en';
                                                                }
                                                                ?>
                                                                <a href="{{ url('/kategori/' . $cat2->id . '/' . slugifyTitle($cat2->$nk) . '/') }}"
                                                                    class="list-group-item"
                                                                    style="margin-left: 20px;">{{ $cat2->$nk }}</a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!--sidebar widget end-->

                    {{-- <!--filter by order start -->
                    <aside class="sidebar_widget" style="margin-top:-30px; margin-bottom:20px; margin-left:10px; margin-right:10px">
                        <label for="customRange2" class="form-label"><b>Filter By Order</b></label>
                        <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                        <span>Min order</span>
                    </aside>
                    <!--filter by order end --> --}}



                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner" style="background : #e9e9ff !important">
                            <div class="widget_list widget_categories" style="background : #e9e9ff !important">
                                <!-- <h2>Highlight</h2> -->
                                <h2>@lang('frontend.listprod.advanced')</h2>
                                {{-- <h2 style="margin-bottom: 0px; font-size: 14px;">@lang('frontend.home.product')</h2>
                                
                                @if (isset($page))
                                    <input type="text" class="form-control" id="cari_advance" name="cari_advance" disabled placeholder="@lang('frontend.home.cariproduct')" style="    border: 1
                                    px
                                     solid rgb(170, 170, 170); font-size: 12px;margin-bottom: 20px; border-radius:10px; background: #d1d1e5; color:#000">
                                @else
                                    <input type="text" class="form-control" id="cari_advance" name="cari_advance" placeholder="@lang('frontend.home.cariproduct')" style="    border: 1
                                    px
                                     solid rgb(170, 170, 170); font-size: 12px;margin-bottom: 20px; border-radius:10px; background: #d1d1e5; color:#000">
                                @endif --}}
                                <h2 style="margin-bottom: 0px; font-size: 14px;">@lang('research-corner.kategori')</h2>

                                @if (isset($page))
                                    <select class="form-control" id="cari_cat_advance" name="cari_cat_advance"
                                        disabled placeholder="@lang('frontend.home.caricategory')"
                                        style="    border: 1
                                    px
                                     solid rgb(170, 170, 170); font-size: 12px;margin-bottom: 20px; border-radius:10px; background: #d1d1e5; color:#000;">
                                        <option></option>
                                    </select>
                                @else
                                    <select class="form-control" id="cari_cat_advance" name="cari_cat_advance"
                                        placeholder="@lang('frontend.home.caricategory')"
                                        style="    border: 1
                                    px
                                     solid rgb(170, 170, 170); font-size: 12px;margin-bottom: 20px; border-radius:10px; background: #d1d1e5; color:#000">
                                        <option></option>
                                    </select>
                                @endif
                                <!-- <input type="text" class="form-control"> -->
                                <h2 style="margin-top: 20px; margin-bottom: 20px; font-size: 15px;">
                                    @lang('frontend.listprod.highlight')</h2>
                                <?php
                                $checkedna = '';
                                $checkedhot = '';
                                $hlsortnya = '';
                                if (isset($hl_sort)) {
                                    if (strstr($hl_sort, '|')) {
                                        $hlist = explode('|', $hl_sort);
                                    } else {
                                        $hlist = [$hl_sort];
                                    }
                                
                                    for ($k = 0; $k < count($hlist); $k++) {
                                        if ($hlist[$k] == 'new') {
                                            $checkedna = 'checked="true"';
                                        }
                                        if ($hlist[$k] == 'hot') {
                                            $checkedhot = 'checked="true"';
                                        }
                                    }
                                
                                    $hlsortnya = $hl_sort;
                                }
                                ?>
                                <ul id="highlightlist" style="margin-bottom: 0px;">
                                    <li>
                                        @if (isset($page))
                                            <input type="checkbox" name="inlineRadioOptions" value="hot"
                                                id="exampleRadios1" class="check_hl"
                                                onclick="getProduct(this.value, this.checked)" disabled
                                                {{ $checkedhot }}>
                                        @else
                                            <input type="checkbox" name="inlineRadioOptions" value="hot"
                                                id="exampleRadios2" class="check_hl"
                                                onclick="getProduct(this.value, this.checked)" {{ $checkedhot }}>
                                        @endif
                                        <a href="#" class="hover-none">@lang('frontend.listprod.hotprod')
                                            ({{ $countHot }})</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                        @if (isset($page))
                                            <input type="checkbox" name="inlineRadioOptions" value="new"
                                                id="exampleRadios1" class="check_hl"
                                                onclick="getProduct(this.value, this.checked)" disabled
                                                {{ $checkedna }}>
                                        @else
                                            <input type="checkbox" name="inlineRadioOptions" value="new"
                                                id="exampleRadios2" class="check_hl"
                                                onclick="getProduct(this.value, this.checked)" {{ $checkedna }}>
                                        @endif
                                        <a href="#" class="hover-none">@lang('frontend.listprod.newarrival')
                                            ({{ $countNew }})</a>
                                        <span class="checkmark"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="widget_list widget_categories">
                                <h2 style="margin-bottom: 0px;">@lang('frontend.proddetail.bymanufacture')</h2>
                                <?php
                                if ($loc == 'ch') {
                                    $srchmanlang = '搜索制造商';
                                } elseif ($loc == 'in') {
                                    $srchmanlang = 'Cari Produsen';
                                } else {
                                    $srchmanlang = 'Search Manufacturer';
                                }
                                ?>
                                @if (isset($page))
                                    <input type="text" class="form-control" id="cari_manufacture"
                                        placeholder="{{ $srchmanlang }}"
                                        style="     border: 1
                                px
                                 solid rgb(170, 170, 170); font-size: 12px;margin-bottom: 20px; border-radius:10px; background: #d1d1e5 " disabled>
                                @else
                                    <input type="text" class="form-control" id="cari_manufacture"
                                        placeholder="{{ $srchmanlang }}"
                                        style="    border: 1
                                px
                                 solid rgb(170, 170, 170); font-size: 12px;margin-bottom: 20px; border-radius:10px; background: #d1d1e5">
                                @endif
                                <ul id="manufacturlist">
                                    @foreach ($manufacturer as $man)
                                        <?php
                                        $checkednya = '';
                                        $prodbyeks = '';
                                        if (isset($getEks)) {
                                            if (strstr($getEks, '|')) {
                                                $eks = explode('|', $getEks);
                                            } else {
                                                $eks = [$getEks];
                                            }
                                        
                                            for ($k = 0; $k < count($eks); $k++) {
                                                if ($man->id == $eks[$k]) {
                                                    $checkednya = 'checked="true"';
                                                }
                                            }
                                        
                                            $prodbyeks = $getEks;
                                        }
                                        ?>
                                        <li>
                                            @if (isset($page))
                                                <input type="checkbox" value="{{ $man->id }}"
                                                    onclick="getProductbyEksportir(this.value, this.checked)" disabled
                                                    {{ $checkednya }}>
                                            @else
                                                <input type="checkbox" value="{{ $man->id }}"
                                                    onclick="getProductbyEksportir(this.value, this.checked)"
                                                    {{ $checkednya }}>
                                            @endif
                                            <a href="#" class="hover-none">{{ $man->company }}
                                                ({{ $man->jml_produk }})</a>
                                            <span class="checkmark"></span>
                                        </li>
                                    @endforeach
                                    <li>
                                        @if (isset($page))
                                            <a style="color: #007bff;">@lang('frontend.proddetail.listcompany')</a>
                                        @else
                                            <a
                                                href="{{ url('front_end/list_perusahaan') }}">@lang('frontend.proddetail.listcompany')</a>
                                        @endif
                                    </li>
                                </ul>
                                <hr>
                                <button
                                    style="font-weight:bold; background-color: #ffe300; color: #1d7bff; border-radius: 15px;"
                                    class="btn" type="submit" name="search" id="search"
                                    form="formsprod">Search</button>
                            </div>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                </div>

                <div class="col-lg-9 col-md-12">
                    @if (count($product) == 0)
                        <center>Product Not Found</center>
                    @else
                        <div class="mb-15 row">
                            <!-- <img src="{{ asset('assets/assets/versi 1/Asset 30 (3).png') }}" class="d-block w-100" alt="..."> -->
                            {{-- <div class="col-md-12"> --}}
                            <div style="display: flex;">
                                @if (isset($desc))
                                    @if (!empty($desc->banner))
                                        <div class="col-12 col-without-padding">
                                            <img src="{{ asset('assets/assets/versi 1/' . $desc->banner) }}"
                                                style="margin-left:-1px!important;flex-shrink: 0;min-width: 100%;max-height: 339.33px"
                                                class="rounded" alt="...">
                                        </div>
                                    @else
                                        <div class="col-8 col-without-padding">
                                            <img src="{{ asset('assets/assets/versi 1/Asset 30 (2).png') }}"
                                                class="d-block w-100 rounded-left" alt="...">
                                        </div>
                                        <div class="col-4 col-without-padding"
                                            style="justify-content: center;overflow: hidden;">
                                            <img src="{{ asset('assets/assets/versi 1/Asset 30-(2).png') }}"
                                                class="rounded-right"
                                                style="margin-left:-1px!important;flex-shrink: 0;min-width: 100%;"
                                                alt="...">
                                        </div>
                                    @endif
                                @else
                                    <div class="col-8 col-without-padding">
                                        <img src="{{ asset('assets/assets/versi 1/Asset 30 (2).png') }}"
                                            class="d-block w-100 rounded-left" alt="...">
                                    </div>
                                    <div class="col-4 col-without-padding"
                                        style="justify-content: center;overflow: hidden;">
                                        <img src="{{ asset('assets/assets/versi 1/Asset 30-(2).png') }}"
                                            class="rounded-right"
                                            style="margin-left:-1px!important;flex-shrink: 0;min-width: 100%;"
                                            alt="...">
                                    </div>
                                @endif
                            </div>

                            @if (isset($desc))
                                <div class="col-12 justify-content"
                                    style="background-color: #e9e9ff !important; border-radius: 15px; margin: 16px 0 16px 0; padding: 16px;">
                                    <h3>{{ $desc->{'nama_kategori_' . $loc} }}</h3>
                                    {{-- <br/> --}}
                                    {{-- <b> --}}
                                    "{{ $desc->description }}"
                                    {{-- </b> --}}
                                </div>
                            @endif
                            <div class="col-2" style="text-align: right;">
                                <div class="breadcrumb_content">
                                    @if (isset($page))
                                        <select name="sortbyproduct" id="sortbyproduct" style="border: none;"
                                            class="sortproductnya" disabled>
                                            <option value="default"
                                                @if (isset($sortbyproduct)) @if ($sortbyproduct == 'default') selected @endif
                                                @endif>
                                                @lang('frontend.liseksportir.default')</option>
                                            <option value="new"
                                                @if (isset($sortbyproduct)) @if ($sortbyproduct == 'new') selected @endif
                                                @endif>
                                                @lang('frontend.liseksportir.newest')</option>
                                            @if (!empty(Auth::guard('eksmp')->user()))
                                                @if (Auth::guard('eksmp')->user()->status == 1)
                                                    <option value="lowhigh"
                                                        @if (isset($sortbyproduct)) @if ($sortbyproduct == 'lowhigh') selected @endif
                                                        @endif>
                                                        @lang('frontend.proddetail.pricelh')</option>
                                                    <option value="highlow"
                                                        @if (isset($sortbyproduct)) @if ($sortbyproduct == 'highlow') selected @endif
                                                        @endif>
                                                        @lang('frontend.proddetail.pricehl')</option>
                                                @endif
                                            @endif
                                            <option value="asc"
                                                @if (isset($sortbyproduct)) @if ($sortbyproduct == 'asc') selected @endif
                                                @endif>
                                                @lang('frontend.liseksportir.prodnm')</option>
                                        </select>
                                    @else
                                        <select name="sortbyproduct" id="sortbyproduct" style="border: none;"
                                            class="sortproductnya">
                                            <option value="default"
                                                @if (isset($sortbyproduct)) @if ($sortbyproduct == 'default') selected @endif
                                                @endif>
                                                @lang('frontend.liseksportir.default')</option>
                                            <option value="new"
                                                @if (isset($sortbyproduct)) @if ($sortbyproduct == 'new') selected @endif
                                                @endif>
                                                @lang('frontend.liseksportir.newest')</option>
                                            @if (!empty(Auth::guard('eksmp')->user()))
                                                @if (Auth::guard('eksmp')->user()->status == 1)
                                                    <option value="lowhigh"
                                                        @if (isset($sortbyproduct)) @if ($sortbyproduct == 'lowhigh') selected @endif
                                                        @endif>
                                                        @lang('frontend.proddetail.pricelh')</option>
                                                    <option value="highlow"
                                                        @if (isset($sortbyproduct)) @if ($sortbyproduct == 'highlow') selected @endif
                                                        @endif>
                                                        @lang('frontend.proddetail.pricehl')</option>
                                                @endif
                                            @endif
                                            <option value="asc"
                                                @if (isset($sortbyproduct)) @if ($sortbyproduct == 'asc') selected @endif
                                                @endif>
                                                @lang('frontend.liseksportir.prodnm')</option>
                                        </select>
                                    @endif
                                </div>
                            </div>

                            <div class="col-8" style="text-align: right;">
                                <div class="breadcrumb_content">
                                    <div class="page_amount">
                                        <p>
                                            @if ($loc == 'ch')
                                                <b>找到5206个产品</b>
                                            @elseif($loc == 'in')
                                                <b>{{ $coproduct }} Produk</b> ditemukan
                                            @else
                                                <b>{{ $coproduct }} Products</b> Found
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 grid_list_btn" style="text-align: right;">
                                <div class="breadcrumb_content">
                                    <div class="shop_toolbar_btn">
                                        <button data-role="grid_3" onclick="inigrid()" type="button"
                                            class="active btn-grid-3" data-toggle="tooltip" title="3"
                                            id="grid"></button>
                                        <button data-role="grid_list" onclick="inilist()" type="button"
                                            class="btn-list" data-toggle="tooltip" title="List"
                                            id="list"></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row shop_wrapper">

                            @foreach ($product as $pro)
                                <?php
                                //new or not
                                $dis = 'display: none;';
                                $dis2 = 'display: none;';
                                if (date('Y', strtotime($pro->created_at)) == date('Y')) {
                                    if (date('m', strtotime($pro->created_at)) == date('m')) {
                                        $dis = '';
                                    }
                                }
                                if (in_array($pro->id, $hot_product)) {
                                    $dis2 = '';
                                }
                                
                                //category
                                $cat1 = getCategoryName($pro->id_csc_product, $lct);
                                $cat2 = getCategoryName($pro->id_csc_product_level1, $lct);
                                $cat3 = getCategoryName($pro->id_csc_product_level2, $lct);
                                // dd($pro->id_csc_product);
                                if ($cat3 == '-') {
                                    if ($cat2 == '-') {
                                        $categorynya = $cat1;
                                        $idcategory = $pro->id_csc_product;
                                    } else {
                                        $categorynya = $cat2;
                                        $idcategory = $pro->id_csc_product_level1;
                                    }
                                } else {
                                    $categorynya = $cat3;
                                    $idcategory = $pro->id_csc_product_level2;
                                }
                                
                                //Image
                                $img1 = $pro->image_1;
                                $img2 = $pro->image_2;
                                
                                if ($img1 == null) {
                                    $isimg1 = '/image/notAvailable.png';
                                } else {
                                    $image1 = 'uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img1;
                                    if (file_exists($image1)) {
                                        $isimg1 = '/uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img1;
                                    } else {
                                        $isimg1 = '/image/notAvailable.png';
                                    }
                                }
                                
                                $cekImage = explode('.', $img1);
                                $sizeImg = 210;
                                $padImg = '0px';
                                if ($cekImage[count($cekImage) - 1] == 'png') {
                                    $sizeImg = 190;
                                    $padImg = '10px 5px 0px 5px';
                                }
                                $minorder = '-';
                                $minordernya = '-';
                                if ($pro->minimum_order != null) {
                                    $minorder = $pro->minimum_order;
                                    if (strlen($minorder) > 30) {
                                        $cut_desc = substr($minorder, 0, 30);
                                        if ($minorder[30 - 1] != ' ') {
                                            $new_pos = strrpos($cut_desc, ' ');
                                            $cut_desc = substr($minorder, 0, $new_pos);
                                        }
                                        $minordernya = $cut_desc . '...';
                                    } else {
                                        $minordernya = $minorder;
                                    }
                                }
                                
                                $satuan = $pro->unit;
                                
                                $ukuran = '340px';
                                if (!empty(Auth::guard('eksmp')->user())) {
                                    if (Auth::guard('eksmp')->user()->status == 1) {
                                        $ukuran = '355px';
                                    }
                                }
                                
                                if ($img2 == null) {
                                    $isimg2 = '/image/notAvailable.png';
                                } else {
                                    $image2 = 'uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img2;
                                    if (file_exists($image2)) {
                                        $isimg2 = '/uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img2;
                                    } else {
                                        $isimg2 = '/image/notAvailable.png';
                                    }
                                }
                                ?>
                                <div class="col-lg-4 col-md-4 col-12 ">
                                    <div class="single_product"
                                        style="border-radius: 10px!Important;height: {{ $ukuran }}; background-color: #fff9; padding: 0px !important;">
                                        <?php
                                        //cut prod name
                                        $num_char = 29;
                                        $prodn = getProductAttr($pro->id, 'prodname', $lct);
                                        if (strlen($prodn) > 29) {
                                            $cut_text = substr($prodn, 0, $num_char);
                                            if ($prodn[$num_char - 1] != ' ') {
                                                $new_pos = strrpos($cut_text, ' ');
                                                $cut_text = substr($prodn, 0, $new_pos);
                                            }
                                            $prodnama = $cut_text . '...';
                                        } else {
                                            $prodnama = $prodn;
                                        }
                                        
                                        //cut company
                                        $num_charp = 25;
                                        // $compname = getCompanyName($pro->id_itdp_company_user);
                                        if (getBadanUsahaEksportir($pro->id_itdp_company_user) != '') {
                                            $compname = getCompanyName($pro->id_itdp_company_user) . ', ' . getBadanUsahaEksportir($pro->id_itdp_company_user);
                                        } else {
                                            $compname = getCompanyName($pro->id_itdp_company_user);
                                        }
                                        if (strlen($compname) > 25) {
                                            $cut_text = substr($compname, 0, $num_charp);
                                            if ($compname[$num_charp - 1] != ' ') {
                                                $new_pos = strrpos($cut_text, ' ');
                                                $cut_text = substr($compname, 0, $new_pos);
                                            }
                                            $companame = $cut_text . '...';
                                        } else {
                                            $companame = $compname;
                                        }
                                        
                                        $num_chark = 32;
                                        if (strlen($categorynya) > 32) {
                                            $cut_text = substr($categorynya, 0, $num_chark);
                                            if ($categorynya[$num_chark - 1] != ' ') {
                                                $new_pos = strrpos($cut_text, ' ');
                                                $cut_text = substr($categorynya, 0, $new_pos);
                                            }
                                            $category = $cut_text . '...';
                                        } else {
                                            $category = $categorynya;
                                        }
                                        $param = $pro->id_itdp_company_user . '-' . getCompanyName($pro->id_itdp_company_user);
                                        ?>
                                        {{-- Content Product --}}
                                        <p
                                            style="margin-left: 10px; margin-top: 3px; margin-bottom: 5px; position: absolute;">
                                            <a href="{{ url('/kategori/' . $idcategory . '/' . slugifyTitle($categorynya) . '/') }}"
                                                title="{{ $categorynya }}"
                                                class="href-category">{{ $category }}</a>
                                        </p>
                                        <div class="pro-type"
                                            style="{{ $dis }};@if ($dis != '' && $deflist == 1) ; left: 68% !important; @else ; left: 87% !important; @endif ">
                                            <span class="pro-type-content">
                                                @if ($loc == 'ch')
                                                    新
                                                @elseif($loc == 'in')
                                                    BARU
                                                @else
                                                    NEW
                                                @endif
                                            </span>
                                        </div>
                                        <div class="hot-type"
                                            style="{{ $dis2 }} @if ($dis != '' && $deflist == 1) ; left: 75%; @else ; left: 90%; @endif">
                                            <span class="hot-type-content">
                                                @if ($loc == 'ch')
                                                    热
                                                @elseif($loc == 'in')
                                                    POPULAR
                                                @else
                                                    POPULAR
                                                @endif
                                            </span>
                                        </div>

                                        <div class="product_thumb" align="center"
                                            style="background-color: #e8e8e4; height: 210px; border-radius: 0px 0px 0px 0px; margin-top: 30px;">
                                            <a class="primary_img"
                                                href="{{ url('/produk/' . slugifyTitle($categorynya) . '/' . $pro->id . '/' . slugifyTitle($pro->prodname_en)) }}"
                                                onclick="GoToProduct('{{ $pro->id }}', event, this)"><img
                                                    src="{{ url('/') }}{{ $isimg1 }}" alt=""
                                                    style="vertical-align: middle; height: {{ $sizeImg }}px; border-radius: 0px 0px 0px 0px; padding: {{ $padImg }}"></a>
                                            <!-- <a class="secondary_img" href="{{ url(slugifyTitle($categorynya) . '/' . $pro->id . '/' . slugifyTitle($pro->prodname_en)) }}"><img src="{{ url('/') }}{{ $isimg2 }}" alt=""></a> -->
                                        </div>

                                        <div class="product_name grid_name" style="padding: 0px 13px 0px 13px;">

                                            <h3>
                                                <a href="{{ url('/produk/' . slugifyTitle($categorynya) . '/' . $pro->id . '/' . slugifyTitle($pro->prodname_en)) }}"
                                                    title="{{ $prodn }}" class="href-name"
                                                    onclick="GoToProduct('{{ $pro->id }}', event, this)"><b>{{ $prodnama }}</b></a>
                                            </h3>
                                            <span style="font-size: 12px; font-family: 'Open Sans', sans-serif; ">


                                                {{ $order }}<span
                                                    title="{{ $minorder }}">{{ number_format((float) $minordernya) }}
                                                    {{ $satuan }}</span><br>
                                                <a href="{{ url('perusahaan/' . slugifyTitle($param)) }}"
                                                    title="{{ $compname }}" class="href-company"><span
                                                        style="color: black;">{{ $by }}</span>&nbsp;&nbsp;{{ $companame }}</a>
                                            </span>
                                        </div>
                                        <div class="product_content list_content" style="width: 100%;">
                                            <div class="left_caption">
                                                <div class="product_name">
                                                    <h3>
                                                        <a href="{{ url('/produk/' . slugifyTitle($categorynya) . '/' . $pro->id . '/' . slugifyTitle($pro->prodname_en)) }}"
                                                            title="{{ $prodn }}" class="href-name"
                                                            style="font-size: 15px !important;"
                                                            onclick="GoToProduct('{{ $pro->id }}', event, this)"><b>{{ $prodn }}</b></a>
                                                    </h3>
                                                    <h3>
                                                        <a href="{{ url('perusahaan/' . slugifyTitle($param)) }}"
                                                            title="{{ $compname }}" class="href-company"><span
                                                                style="color: black;">by</span>&nbsp;&nbsp;{{ $compname }}</a>
                                                    </h3>
                                                </div>
                                                <div class="product_desc">
                                                    <?php
                                                    $proddesc = getProductAttr($pro->id, 'product_description', $lct);
                                                    $num_desc = 200;
                                                    if (strlen($proddesc) > $num_desc) {
                                                        $cut_desc = substr($proddesc, 0, $num_desc);
                                                        if ($proddesc[$num_desc - 1] != ' ') {
                                                            $new_pos = strrpos($cut_desc, ' ');
                                                            $cut_desc = substr($proddesc, 0, $new_pos);
                                                        }
                                                        $product_desc = $cut_desc . ' ...';
                                                    } else {
                                                        $product_desc = $proddesc;
                                                    }
                                                    $product_desc = preg_replace('/(<[^>]+) style=".*?"/i', '$1', strip_tags($product_desc, '<p></p><br><i><b><u><hr>'));
                                                    $capacitynya = '-';
                                                    if ($pro->capacity != null) {
                                                        if ($loc == 'ch') {
                                                            $capacitynya = '库存 ' . $pro->capacity . ' 件';
                                                        } elseif ($loc == 'in') {
                                                            $capacitynya = $pro->capacity . ' dalam persediaan';
                                                        } else {
                                                            $capacitynya = $pro->capacity . ' in stock';
                                                        }
                                                    }
                                                    ?>
                                                    <?php echo $product_desc; ?>
                                                </div>
                                            </div>
                                            <div class="right_caption">
                                                <div class="text_available">
                                                    <p>
                                                        @lang('frontend.available'):
                                                        <span>{{ $capacitynya }}</span>
                                                    </p>
                                                </div>
                                                <div class="price_box">
                                                    @if (!empty(Auth::guard('eksmp')->user()))
                                                        @if (Auth::guard('eksmp')->user()->status == 1)
                                                            <span class="current_price">
                                                                @if (is_numeric($pro->price_usd))
                                                                    $
                                                                    {{ number_format($pro->price_usd, 0, ',', '.') }}
                                                                @else
                                                                    <span style="font-size: 13px;">
                                                                        {{ $pro->price_usd }}
                                                                    </span>
                                                                @endif
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- End of Content Product --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <br>
                    @if ($coproduct > 12)
                        <!-- <div class="shop_toolbar t_bottom"> -->
                        <div class="pagination justify-content-center mb-5" style="float: center;">
                            <!--  <ul>
                                <li class="current">1</li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="next"><a href="#">next</a></li>
                                <li><a href="#">>></a></li>
                            </ul> -->
                            {{-- {{ $product->links }} --}}
                            {!! str_replace('/?', '?', $product->links('pagination::bootstrap-4')) !!}

                        </div>
                        <!-- </div> -->
                    @endif
                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                </div>
            </div>
        </div>
    </div>
    <!--shop  area end-->

    <!-- official partner start -->
    {{-- <section style="background-color: #e5e5e5; padding-top: 30px; padding-bottom: 70px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style="padding-bottom: 30px;">
                <p style="font-size: 24px; font-weight:bold; text-align: center; color: #001466">OUR PARTNERS</p>
            </div>
            <div class="col-lg-4">
                <a href="https://exim.kemendag.go.id/" target="_blank"><img src="{{ URL::asset('front/assets/icon/Logo_Exim.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
            </div>
            <div class="col-lg-4"> --}}
    <?php
    // if(Auth::guard('eksmp')->user()) {
    //     if(Auth::guard('eksmp')->user()->id_role == 2) {
    ?>
    {{-- <a href="http://inatrims.kemendag.go.id/index.php/main/negara_djpen" target="_blank"><img src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a> --}}
    <?php
    // }
    // else {
    ?>
    {{-- <a href="http://inatrims.kemendag.go.id/" target="_blank"><img src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a> --}}
    <?php
    //     }
    // }
    // else {
    ?>
    {{-- <a href="http://inatrims.kemendag.go.id/" target="_blank"><img src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a> --}}
    <?php
    // }
    ?>
    {{-- </div>
            <div class="col-lg-4">
                <a href="http://tr.apec.org/" target="_blank"><img src="{{ URL::asset('front/assets/icon/Logo_Apec.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
            </div>
        </div>
    </div>

   
</section> --}}
    <!-- official partner end -->

    <!-- Plugins JS -->
    <script src="{{ asset('front/assets/js/plugins.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    @include('frontend.layouts.footer')
    <script type="text/javascript">
        $(document).ready(function() {

            var deflist = <?php echo $deflist; ?>;
            if (deflist == 0) {
                $('.btn-list').trigger('click');
            } else {
                $('.btn-grid-3').trigger('click');
            }

            var timer

            $('.hover-none').bind('click', function(e) {
                e.preventDefault();
            });

            $('#cari_cat_advance').change(function(event) {
                // if (event.keyCode == 13 || event.which == 13) {
                // $('#cari_product').val(this.value);
                var searchCat = $('#cari_cat_advance').val() + '|searchByName';
                $('#cari_catnya').val(searchCat);
                // $('#formsprod').submit();
                // }
            });

            $('#cari_cat_advance').select2({
                placeholder: '{{ $srchcatlang }}',
                allowClear: true,
                ajax: {
                    url: "{{ route('front.all-category') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama_kategori_en,
                                    id: item.nama_kategori_en
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $("#cari_kategori").on('keyup', function() {
                var isi = this.value;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('front.product.getCategory') }}",
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
                }, 1000);

            });

            $('#grid').on('click', function() {
                $('.product_thumb').css({
                    "margin-top": "30px",
                    "border-radius": "0px 0px 0px 0px"
                });

                $('.pro-type').css({
                    "left": "68%"
                })
                $('.hot-type').css({
                    "left": "75%"
                })
            })

            $('#list').on('click', function() {
                $('.product_thumb').css({
                    "margin-top": "60px",
                    "border-radius": "0px 0px 0px 0px"
                });
                $('.pro-type').css({
                    "left": "87%"
                })
                $('.hot-type').css({
                    "left": "90%"
                })
            });

            $("#cari_manufacture").keyup(function() {
                var isi = this.value;
                var searchProd = $('#cari_product').val();
                var catProd = $('#cari_catnya').val();
                var cekEks = $('#eks_prod').val();
                var lct = "{{ $lct }}";
                if (isi != '') {
                    var datanya = {
                        "name": isi,
                        "lang": lct,
                        "ceked": cekEks
                    };
                } else {
                    var datanya = {
                        "name": isi,
                        "searchnya": searchProd,
                        "catnya": catProd,
                        "lang": lct,
                        "ceked": cekEks
                    };
                }
                $.ajax({
                    url: "{{ route('front.product.getManufactur') }}",
                    type: 'get',
                    data: datanya,
                    success: function(response) {
                        $("#manufacturlist").html("");
                        $("#manufacturlist").html(response);
                    }
                });
            });

            $('#delete_cat').on('click', function() {
                var delete_cat = $('#cari_catnya').val();
                var cekSearch = $('#cari_product').val();
                //DOM with search box
                // if(cekSearch.indexOf(',') !== -1){
                //     var cat = cekSearch.split(',');
                //     cat = cat.map(function(val){
                //         value = val.trim();
                //         return value.toLowerCase();
                //     })
                //     var cat2 = [cat[0]];
                //     for(var i=0; i<cat.length; i++){
                //         if(cat[i] == 'hot' || cat[i] == 'new'){
                //             cat2.push(cat[i]);
                //         }
                //     }
                //     searchnya = cat2.join(", ");
                //     $('#cari_product').val(searchnya);
                // }
                //End of DOM
                if (delete_cat.indexOf('|') !== -1) {
                    var pecah = delete_cat.split('|');
                    pecah.pop();
                    hasil = pecah.join("|");
                } else {
                    hasil = '';
                }
                $('#cari_catnya').val(hasil);
                $('#formsprod').submit();
            });

            $("#sortbyproduct").on('change', function() {
                $('#sort_prod').val(this.value);
                $('#formsprod').submit();
            });

            $(".check_eks").on('change', function() {
                if (this.checked) {
                    var arrisi = [];
                    $.each($("input[name='checkexp']:checked"), function() {
                        arrisi.push($(this).val());
                    });
                }

                if (arrisi.length != 0) {
                    var isinya = "";
                    for (var i = arrisi.length - 1; i >= 0; i--) {
                        if (isinya == "") {
                            isinya += arrisi[i];
                        } else {
                            isinya += '|' + arrisi[i];
                        }
                    }
                    // alert(isinya);
                    $('#eks_prod').val(isinya);
                    $('#formsprod').submit();
                }
            });

            $(".check_hl").on('change', function() {
                if (this.checked) {
                    var arrisi = [];
                    $.each($("input[name='checkhl']:checked"), function() {
                        arrisi.push($(this).val());
                    });
                }

                if (arrisi.length != 0) {
                    var isinya = "";
                    for (var i = arrisi.length - 1; i >= 0; i--) {
                        if (isinya == "") {
                            isinya += arrisi[i];
                        } else {
                            isinya += '|' + arrisi[i];
                        }
                    }

                    $('#hl_prod').val(isinya);
                    $('#formsprod').submit();
                }
            });

            $('.hover-none').on('click', function(e) {
                e.preventDefault();
            })

            const isMobile = navigator.userAgentData.mobile; //resolves true/false
            if (isMobile) {
                $('.btn-grid-3').click();
            }
        })

        function openCollapse(col) {
            if ($("#fontdrop" + col).hasClass("fa-chevron-down")) {
                $('#fontdrop' + col).removeClass('fa-chevron-down');
                $('#fontdrop' + col).addClass('fa-chevron-up');
            } else {
                $('#fontdrop' + col).removeClass('fa-chevron-up');
                $('#fontdrop' + col).addClass('fa-chevron-down');
            }
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

        function getProduct(val, checked) {
            var isinya = "";
            var cekSearch = $('#cari_product').val();
            var isi = $('#hl_prod').val();
            // //DOM with search box
            // if(cekSearch.indexOf(',') !== -1){
            //     var pecah = cekSearch.split(',');
            //     pecah = pecah.map(function(val){
            //         value = val.trim();
            //         return value.toLowerCase();
            //     })
            //     if (pecah.includes(val)) {
            //         var searchnya = pecah.filter(function(e) { return e !== val });
            //         searchnya = searchnya.join(", ");
            //         $('#cari_product').val(searchnya);
            //     }
            // }
            // //end of DOM
            if (checked) {
                if (isi == "") {
                    isinya = val;
                } else {
                    isinya = isi + '|' + val;
                }
            } else {
                if (isi == "") {
                    isinya = "";
                } else {
                    var checkstring = isi.includes("|");
                    if (checkstring) {
                        var isibar = isi.split('|');
                        var isin = $.inArray(val, isibar);
                        isibar.splice(isin, 1);
                        isinya = isibar[0];
                    } else {
                        isinya = "";
                    }
                }
            }

            $('#hl_prod').val(isinya);
            if ($('#cari_advance').val() == '' && $('#cari_cat_advance').val() == '') {
                $('#formsprod').submit();
            }
        }

        function getProductbyEksportir(val, checked) {
            var isinya = "";
            var isi = $('#eks_prod').val();
            var cekSearch = $('#cari_product').val();
            // //DOM with search box
            // if(cekSearch.indexOf('-') !== -1){
            //     var pecah = cekSearch.split('-');
            //     if(cekSearch.indexOf(',') !== -1){
            //         searchnya = pecah[0];
            //         pecah = pecah[1].toString();
            //         pecah = pecah.split(',');
            //         pecah.splice(0,1);
            //         searchnya += ',' + pecah.join(",");
            //         $('#cari_product').val(searchnya);

            //     } else {
            //         pecah.splice(1,1);
            //         searchnya = pecah.join("");
            //         $('#cari_product').val(searchnya);
            //     }
            // }
            // //end of DOM
            if (checked) {
                if (isi == "") {
                    isinya = val;
                } else {
                    // var stringcheck = isi.includes("|");
                    // if(stringcheck){
                    //     var pisah = isi.split('|');
                    //     var isismntra = "";
                    //     for (var i = pisah.length - 1; i >= 0; i--) {
                    //         if(isismntra == ""){
                    //             $isinya += pisah[i];
                    //         }else{
                    //             $isinya += '|'+pisah[i];
                    //         }
                    //     }
                    // }else{
                    isinya = isi + '|' + val;
                    // }
                }
            } else {
                if (isi == "") {
                    isinya = "";
                } else {
                    var checkstring = isi.includes("|");
                    if (checkstring) {
                        var isibar = isi.split('|');
                        // var isin = $.inArray(val, isibar);
                        if (isibar.includes(val)) {
                            isibar = isibar.filter(function(e) {
                                return e !== val
                            });
                            isinya = isibar.join("|");
                        }
                        // isibar.splice(isin, 1);
                        // isinya = isibar[0]; 
                    } else {
                        isinya = "";
                    }
                }
            }

            $('#eks_prod').val(isinya);
            if ($('#cari_advance').val() == '' && $('#cari_cat_advance').val() == '') {
                $('#formsprod').submit();
            }
        }

        function stopProcess(e) {
            e.preventDefault();
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
