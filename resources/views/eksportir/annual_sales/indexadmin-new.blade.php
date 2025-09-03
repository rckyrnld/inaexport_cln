@include('frontend.layouts.header')
<?php
$loc = app()->getLocale();
if ($loc == "ch") {
    $lct = "chn";
} else if ($loc == "in") {
    $lct = "in";
} else {
    $lct = "en";
}
?>

<style>
    #catlist {
        font-size: 12px;
        color: #000;
    }

    .list-group-item {
        background-color: #e9e9ff;
        border: none;
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

    /*.list-me:hover{
        background-color: #DDEFFD;
    }*/

    .caption-btn {
        float: right;
        margin-right: 0px;
    }
</style>

<div style="background-image:url('./assets/assets/versi 1/Asset 23 (1).png')!important;">

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                        <ul>
                            <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                            {{-- <li><a href="{{url('/perusahaan')}}">@lang('frontend.home.eksporter')</a></li> --}}
                            @if($catActive == NULL)
                            {{-- <li><a href="{{url('/perusahaan')}}">@lang('frontend.liseksportir.default')</a></li>
                            @else --}}
                            <?php echo $catActive; ?>
                            @endif
                            <li>Our Suppliers</li>
                        </ul>
                    </div>
                </div>
                <div class="col-7">
                    <form method="GET" action="{{url('/suppliers')}}" id="formsupp">
                        <div class="input-group flex-nowrap" style="margin-top: 7px">
                            <?php
                            if (isset($search_eks)) {
                                $carieks = $search_eks;
                            } else {
                                $carieks = "";
                            }

                            if (isset($get_cat_eks)) {
                                $caricateks = $get_cat_eks;
                            } else {
                                $caricateks = "";
                            }
                            ?>
                            <input style="border-top-left-radius: 15px; border-bottom-left-radius:15px" type="text" class="form-control" placeholder="Search supplier" style="border-radius: 0px;" name="cari_eksportir" value="{{$carieks}}" id="cari_eksportir">
                            <input type="hidden" name="lctnya" value="{{$lct}}" id="lctnya">
                            <input type="hidden" name="cat_eks" value="{{$caricateks}}" id="cat_eks">
                            <input type="hidden" name="sorteks" id="sorteks" value="">
                            <button style="font-weight:bold; background-color: #ffe300; color: #1d7bff; border-top-right-radius: 15px; border-bottom-right-radius:15px" class="btn" type="submit" name="search" id="search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!--breadcrumbs area end-->

    <!-- search area start -->
    {{-- <div class="col-lg-12" style="padding-top: 50px; padding-bottom: 20px;">
        <div class="row justify-content-md-center">
            <div class="col-lg-8 justify-content-md-center">
            
            </div>
        </div>
    </div> --}}
    <!-- search area end -->

    <!--shop  area start-->
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner" style="background : #e9e9ff !important">
                            <div class="widget_list widget_categories" style="background : #e9e9ff; !important">
                                <h2>@lang('frontend.liseksportir.category')</h2>
                                <?php
                                if ($loc == "ch") {
                                    $srchcatlang = "搜索类别";
                                } else if ($loc == "in") {
                                    $srchcatlang = "Cari Kategori";
                                } else {
                                    $srchcatlang = "Enter a keyword to search product";
                                }
                                ?>
                                <input type="text" class="form-control" id="cari_kategori" name="cari_kategori" placeholder="{{$srchcatlang}}" style="    border: 1
                                px
                                 solid rgb(170, 170, 170); font-size: 12px; border-radius:10px; background: #d1d1e5; color:#000">
                                <br>
                                <div class="list-group list-group-flush" style="background : #e9e9ff; !important" id="catlist">
                                    @foreach($categoryutama as $cu)
                                    <?php
                                    $catprod1 = getCategoryLevel(1, $cu->id, "");
                                    $nk = "nama_kategori_" . $lct;
                                    if ($cu->$nk == NULL) {
                                        $nk = "nama_kategori_en";
                                    }
                                    ?>
                                    @if(count($catprod1) == 0)
                                    <a href="{{url('/perusahaan-kategori/'.$cu->id.'/'.slugifyTitle($cu->$nk))}}" class="list-group-item">{{$cu->$nk}}</a>
                                    @else
                                    <a onclick="openCollapse('{{$cu->id}}')" href="#menus{{$cu->id}}" class="list-group-item" data-toggle="collapse" data-parent="#MainMenu"> {{$cu->$nk}} <i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop{{$cu->id}}"></i></a>
                                    <div class="collapse" id="menus{{$cu->id}}">
                                        @foreach($catprod1 as $cat1)
                                        <a href="{{url('/perusahaan-kategori/'.$cat1->id.'/'.slugifyTitle($cat1->$nk))}}" class="list-group-item">{{$cat1->$nk}}</a>
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
                        <div class="col-2" style="text-align: right;">
                            <div class="breadcrumb_content">
                                <select name="shorteks" id="shorteks" style="border: none;" onchange="sortBy(this.value, '{{$bgn}}')">
                                    <option value="" @if(isset($sortingby)) @if($sortingby=="" ) selected @endif @endif>@lang('frontend.liseksportir.default')</option>
                                    <option value="asc" @if(isset($sortingby)) @if($sortingby=="asc" ) selected @endif @endif>@lang('frontend.liseksportir.eksporternm')</option>
                                </select>
                            </div>
                        </div>
                        @if(isset($urlsorting))
                        <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url($urlsorting)}}" id="formcateks">
                            {{ csrf_field() }}
                            <input type="hidden" name="sortekscat" id="sortekscat" value="">
                        </form>
                        @endif


                        <div class="col-8" style="text-align: right;">
                            <div class="breadcrumb_content">
                                <div class="page_amount">
                                    <p>
                                        @if($loc == "ch")
                                        <b>找到{{$coeksporter}}个出口商</b>
                                        @elseif($loc == "in")
                                        <b>{{$coeksporter}} Eksportir</b> ditemukan
                                        @else
                                        <b>{{$coeksporter}} Exporter</b> Found
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-2" style="text-align: right;">
                            <div class="breadcrumb_content">
                                <div class="shop_toolbar_btn">
                                    <button data-role="grid_4" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3"></button>
                                    <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip" title="List"></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row shop_wrapper">
                        @foreach($eksporter as $eks)
                        <?php
                        //Image
                        $img1 = $eks->foto_profil;

                        if ($img1 == NULL) {
                            $isimg1 = '/front/assets/icon/icon log.png';
                        } else {
                            $image1 = 'uploads/Profile/Eksportir/' . $eks->id_user . '/' . $img1;
                            if (file_exists($image1)) {
                                $isimg1 = '/uploads/Profile/Eksportir/' . $eks->id_user . '/' . $img1;
                            } else {
                                $isimg1 = '/front/assets/icon/icon log.png';
                            }
                        }

                        ?>
                        <div class="col-lg-3 col-md-4 col-12 ">
                            <div class="single_product" style="padding-bottom: 0px; margin-bottom: 10px;">
                                <div class="product_content grid_content" style="margin-top: 0px;">
                                    <div class="eksporter-logo" style="height: 160px;">
                                        <center>
                                            <?php
                                            $num_char = 40;
                                            $eksn = $eks->company;
                                            if (strlen($eksn) > 40) {
                                                $cut_text = substr($eksn, 0, $num_char);
                                                if ($eksn[$num_char - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                    $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                    $cut_text = substr($eksn, 0, $new_pos);
                                                }
                                                $eksnama = $cut_text . '...';
                                            } else {
                                                $eksnama = $eksn;
                                            }

                                            $param = $eks->id_user . '-' . getCompanyName($eks->id_user);
                                            ?>
                                            <a href="{{url('/front_end/list_perusahaan/view/'.$param)}}" class="a-eksporter" title="{{$eksn}}">
                                                <!-- <img src="{{url('/')}}{{$isimg1}}" alt="" class="eksporter_img"> -->
                                                <br>
                                                <span class="name-eksporter" style="margin-top:5px"><b>{{$eksnama}}</b></span>
                                            </a>
                                        </center>
                                    </div>
                                    <div class="eksporter-product" style="overflow-y: auto;">
                                        <div class="list-group" style="font-size: 12px;height: 150px;">
                                            <?php
                                            $productnya = getProductbyEksportir($eks->id_user, 3, null, $lct);
                                            ?>
                                            @if(count($productnya) == 0)
                                            <a href="#" class="list-group-item" style="padding: 0px; margin-bottom: 10px;">
                                                <table border="0" style="width: 100%;">
                                                    <tr>
                                                        <td width="100%">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </a>
                                            <a href="#" class="list-group-item" style="padding: 0px; margin-bottom: 10px;">
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
                                            <a href="#" class="list-group-item" style="padding: 0px; margin-bottom: 10px;">
                                                <table border="0" style="width: 100%;">
                                                    <tr>
                                                        <td width="100%">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </a>
                                            @else
                                            @foreach($productnya as $p)
                                            <?php
                                            $imgnya = $p->image_1;

                                            if ($imgnya == NULL) {
                                                $isimgnya = '/image/noimage.jpg';
                                            } else {
                                                $image1 = 'uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                if (file_exists($image1)) {
                                                    $isimgnya = '/uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                } else {
                                                    $isimgnya = '/image/noimage.jpg';
                                                }
                                            }
                                            ?>
                                            <a href="{{url('/front_end/product/'.$p->id)}}" class="list-group-item" style="padding: 0px; margin-bottom: 10px;" title="{{getProductAttr($p->id, 'prodname', $lct)}}" onclick="GoToProduct('{{$p->id}}', event, this)">
                                                <table border="0" style="width: 100%;">
                                                    <tr>
                                                        <td width="30%">
                                                            <img src="{{url('/')}}{{$isimgnya}}" alt="" class="product_image">
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
                                                            @if(!empty(Auth::guard('eksmp')->user()))
                                                            @if(Auth::guard('eksmp')->user()->status == 1)
                                                            <br>
                                                            Price :
                                                            <?php
                                                            if (is_numeric($p->price_usd)) {
                                                                echo '$ ' . number_format($p->price_usd, 0, ",", ".");
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
                                                            @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- <div class="row" style="width: 100%;">
                                                            <div class="col-md-4">
                                                                <img src="{{url('/')}}{{$isimgnya}}" alt="" class="product_image">    
                                                            </div>
                                                            <div class="col-md-8">
                                                                
                                                            </div>
                                                        </div> -->
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="eksporter-detail" style="border-top: 1px solid #DDEFFD; padding: 4%;">
                                        <center>
                                            <a href="{{url('/front_end/list_perusahaan/view/'.$param)}}" class="btn" style="border-radius: 15px; background-color: #ffe300; 
                                        
                                                color:#1d7bff;
                                                font-size : 14px;
                                                font-weight : bold;
                                                width : 150 px;">@lang('frontend.liseksportir.moredetail')</a>
                                            {{-- @lang('frontend.liseksportir.moredetail')&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i> --}}
                                            </a>
                                        </center>
                                    </div>
                                </div>
                                <div class="product_content list_content" style="margin-top: 0px; margin-bottom: 0px;">
                                    <div class="left_caption" style="width: 250px; height: 100%;">
                                        <div class="eksporter-logo2">
                                            <center>
                                                <!-- <a href="{{url('/front_end/list_perusahaan/view/'.$param)}}" class="a-eksporter"> -->
                                                    <!-- <img src="{{url('/')}}{{$isimg1}}" alt="" class="eksporter_img"> -->
                                                    <br>
                                                    <span class="name-eksporter">
                                                        <?php
                                                        $text = $eks->company;
                                                        echo wordwrap($text, 20, "<br>\n");
                                                        ?>
                                                    </span>
                                                </a>
                                            </center>
                                        </div>
                                    </div>
                                    <div class="right_caption">
                                        <div class="eksporter-product" style="height: auto; width: 70%;">
                                            <div class="list-group" style="font-size: 12px;">
                                                <?php
                                                $productnya = getProductbyEksportir($eks->id_user, 3, null, $lct);
                                                ?>
                                                @if(count($productnya) == 0)
                                                <a href="#" class="list-group-item" style="padding: 0px; margin-bottom: 10px; width: 100%;">
                                                    <table border="0" style="width: 100%;">
                                                        <tr>
                                                            <td width="30%">&nbsp;</td>
                                                            <td width="70%">
                                                                <br><br>
                                                                <center>
                                                                    - @lang('frontend.liseksportir.prodnotfound') -
                                                                </center>
                                                                <br><br>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </a>
                                                @else
                                                @foreach($productnya as $p)
                                                <?php
                                                $imgnya = $p->image_1;

                                                if ($imgnya == NULL) {
                                                    $isimgnya = '/image/noimage.jpg';
                                                } else {
                                                    $image1 = 'uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                    if (file_exists($image1)) {
                                                        $isimgnya = '/uploads/Eksportir_Product/Image/' . $p->id . '/' . $imgnya;
                                                    } else {
                                                        $isimgnya = '/image/noimage.jpg';
                                                    }
                                                }
                                                ?>
                                                <a href="{{url('/front_end/product/'.$p->id)}}" class="list-group-item list-me" style="padding: 0px; margin-bottom: 10px;" title="{{getProductAttr($p->id, 'prodname', $lct)}}" onclick="GoToProduct('{{$p->id}}', event, this)">
                                                    <table border="0" style="width: 100%;">
                                                        <tr>
                                                            <td width="30%">
                                                                <img src="{{url('/')}}{{$isimgnya}}" alt="" class="product_image">
                                                            </td>
                                                            <td width="70%" style="padding-left: 10px;">
                                                                <b>
                                                                    <?php
                                                                    // $num_char = 15;
                                                                    $text = getProductAttr($p->id, 'prodname', $lct);
                                                                    // if(strlen($text) > 15){
                                                                    //     $cut_text = substr($text, 0, $num_char);
                                                                    //     if ($text{$num_char - 1} != ' ') {
                                                                    //         $new_pos = strrpos($cut_text, ' ');
                                                                    //         $cut_text = substr($text, 0, $new_pos);
                                                                    //     }
                                                                    //     echo $cut_text;
                                                                    // }else{
                                                                    echo $text;
                                                                    // }
                                                                    ?>
                                                                </b>
                                                                @if(!empty(Auth::guard('eksmp')->user()))
                                                                @if(Auth::guard('eksmp')->user()->status == 1)
                                                                <br>
                                                                Price :
                                                                <?php
                                                                if (is_numeric($p->price_usd)) {
                                                                    echo '$ ' . number_format($p->price_usd, 0, ",", ".");
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
                                    </div>
                                    <div class="caption-btn">
                                        <div class="eksporter-detail">
                                            <center>
                                                <a href="{{url('/front_end/list_perusahaan/view/'.$param)}}" class="btn" style="border-radius: 15px; background-color: #ffe300; 
                                                    color:#1d7bff;
                                                    font-size : 14px;
                                                    font-weight : bold;
                                                    width : 150 px;">@lang('frontend.liseksportir.moredetail')</a>
                                                {{-- @lang('frontend.liseksportir.moredetail')&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i> --}}
                                                </a>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <br>
                    @if($coeksporter > 12)
                    <!-- <div class="shop_toolbar t_bottom"> -->
                    <div class="pagination justify-content-center" style="float: center;">
                        <!--  <ul>
                                <li class="current">1</li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="next"><a href="#">next</a></li>
                                <li><a href="#">>></a></li>
                            </ul> -->
                        {{ $eksporter->links('vendor.pagination.bootstrap-4') }}
                        {{ $eksporter->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
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
    <section style="background-color: #e5e5e5; padding-top: 30px; padding-bottom: 70px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="padding-bottom: 30px;">
                    <p style="font-size: 24px; font-weight:bold; text-align: center; color: #001466">OUR PARTNERS</p>
                </div>
                <div class="col-lg-4">
                    <a href="https://exim.kemendag.go.id/"><img src="{{ URL::asset('front/assets/icon/Logo_Exim.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                </div>
                <div class="col-lg-4">
                    <?php
                    if (Auth::guard('eksmp')->user()) {
                        if (Auth::guard('eksmp')->user()->id_role == 2) {
                            ?>
                            <a href="http://inatrims.kemendag.go.id/index.php/main/negara_djpen"><img src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                        <?php
                            } else {
                                ?>
                            <a href="http://inatrims.kemendag.go.id/"><img src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                        <?php
                            }
                        } else {
                            ?>
                        <a href="http://inatrims.kemendag.go.id/"><img src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-lg-4">
                    <a href="http://tr.apec.org/"><img src="{{ URL::asset('front/assets/icon/Logo_Apec.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                </div>
            </div>
        </div>


    </section>
    <!-- official partner end -->
    <!-- Plugins JS -->
    <script src="{{asset('front/assets/js/plugins.js')}}"></script>
    @include('frontend.layouts.footer')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
            $("#cari_kategori").keyup(function() {
                var isi = this.value;
                $.ajax({
                    url: "{{route('front.eksportir.getCategory')}}",
                    type: 'get',
                    data: {
                        name: isi,
                        loc: "{{$lct}}"
                    },
                    success: function(response) {
                        $("#catlist").html("");
                        // console.log(response);
                        $("#catlist").html(response);
                    }
                });
            });
        });

        function sortBy(val, jenis) {
            if (jenis == "list") {
                $('#sorteks').val(val);
                $('#formseksportir').submit();
            } else {
                $('#sortekscat').val(val);
                $('#formcateks').submit();
            }
        }

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
                url: "{{route('product.hot')}}",
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
    </script>