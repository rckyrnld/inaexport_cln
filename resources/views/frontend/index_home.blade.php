@include('frontend.layouts.header')
<!--slider area start-->
<style type="text/css">
    .row-menu{
        margin-top: 10%;
        margin-bottom: 10%;
    }

    .product_tab_button.nav li{
      margin: 2% 0 1% 0;
    }

    .product_tab_button.nav li a{
      color: black;
    }

    .product_tab_button.nav li a.active, .product_tab_button.nav li a:hover{
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }

    /*.categories_menu_toggle > ul > li > a:hover, .categories_menu_toggle > ul > li > a:active{
        background-color: #ddeffd;
        text-decoration: none;
        color: #007bff;
    }*/
</style>
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
    }else if($loc == "in"){
        $lct = "in";
    }else{
        $lct = "en";
    }
?>
    <!--menu & category start-->
    <section class="slider_section mb-50" style="margin-bottom: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="categories_menu">
                        <div class="categories_title">
                            <h2 class="categori_toggle">@lang('frontend.home.popcategory')</h2>
                        </div>
                        <div class="categories_menu_toggle">
                            <ul>
                                @foreach($categoryutama as $cu)
                                    <?php
                                        $catprod1 = getCategoryLevel(1, $cu->id, "");
                                        $nk = "nama_kategori_".$lct; 
                                        if($cu->$nk == NULL){
                                            $nk = "nama_kategori_en";
                                        }
                                    ?>
                                    @if(count($catprod1) == 0)
                                        <li><a href="{{url('/front_end/list_product/category/'.$cu->id)}}">{{$cu->$nk}}</a></li>
                                    @else
                                        <li class="menu_item_children categorie_list"><a href="{{url('/front_end/list_product/category/'.$cu->id)}}">{{$cu->$nk}} <i class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu">
                                                @foreach($catprod1 as $key => $c1)
                                                  @if($key < 19)
                                                    <?php
                                                        $catprod2 = getCategoryLevel(2, $cu->id, $c1->id);
                                                        $nk = "nama_kategori_".$lct; 
                                                        if($c1->$nk == NULL){
                                                            $nk = "nama_kategori_en";
                                                        }
                                                    ?>
                                                    <li class="menu_item_children"><a href="{{url('/front_end/list_product/category/'.$c1->id)}}" style="text-transform: capitalize !important;">{{$c1->$nk}}</a></li>
                                                  @endif
                                                @endforeach
                                                @if(count($catprod1) > 19)
                                                <li class="menu_item_children"><a href="{{url('/front_end/list_product')}}" style="text-transform: capitalize !important;"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;@lang('frontend.home.morecategory')</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                                <li id="cat_toggle"><a href="{{url('/front_end/list_product')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;@lang('frontend.home.morecategory')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="row-menu">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{url('/')}}"><img src="{{asset('front/assets/icon/inquiry.png')}}" alt="" class="img-menu"></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('/br_importir')}}"><img src="{{asset('front/assets/icon/buying_request.png')}}" alt="" class="img-menu"></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('/front_end/ticketing_support')}}"><img src="{{asset('front/assets/icon/ticketing.png')}}" alt="" class="img-menu"></a>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{url('/front_end/event')}}"><img src="{{asset('front/assets/icon/event.png')}}" alt="" class="img-menu"></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('/front_end/training')}}"><img src="{{asset('front/assets/icon/training.png')}}" alt="" class="img-menu"></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('/front_end/research-corner')}}"><img src="{{asset('front/assets/icon/research_corner.png')}}" alt="" class="img-menu"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--menu & category end-->
    
    <!--buyer & seller start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <div class="row">
                          <div class="col-md-6">
                            <center>
                              <img src="{{asset('front/assets/icon/icon_buyer.png')}}" alt="" style="width: 20%;">
                              <span style="font-size: 27px; color: #37791C;">FOR BUYER</span>
                            </center>
                          </div>
                          <div class="col-md-6">
                            <center>
                              <img src="{{asset('front/assets/icon/icon_seller.png')}}" alt="" style="width: 20%;">
                              <span style="font-size: 27px; color: #EA8125;">FOR INDONESIA EXPORTER</span>
                            </center>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--buyer & seller start-->

    <!--category product start-->
    <section class="product_area mb-50" style="background-color: #ddeffd;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title" style="margin-bottom: 0px;">
                        <ul class="product_tab_button nav" role="tablist" style="background-color: inherit;">
                            <?php
                                $numb = 1;
                            ?>
                            @foreach($categoryutama as $cut)
                            <?php
                                $cls = "";
                                if($numb == 1){
                                    $cls = "active";
                                }
                            ?>
                            <li>
                                <?php
                                    $nkat = "nama_kategori_".$lct; 
                                    if($cut->$nkat == NULL){
                                        $nkat = "nama_kategori_en";
                                    }

                                    $num_char = 20;
                                    $textkat = $cut->$nkat;
                                    if(strlen($textkat) > 20){
                                        $cut_text = substr($textkat, 0, $num_char);
                                        if ($textkat{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                            $cut_text = substr($textkat, 0, $new_pos);
                                        }
                                        $kategorinya = $cut_text . '...';
                                    }else{
                                        $kategorinya = $textkat;
                                    }
                                ?>
                                <a class="{{$cls}}" data-toggle="tab" href="#tabke{{$numb}}" role="tab" aria-controls="tabke{{$numb}}" aria-selected="true" title="{{$textkat}}" onclick="openTab('tabke{{$numb}}')">
                                    <img src="{{asset('front/assets/img/kategori/agriculture.png')}}" alt="">
                                    {{$kategorinya}}
                                </a>
                            </li>
                            <?php $numb++; ?>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--category product end-->

    <!--product category start-->
    <section class="product_area mb-50">
        <div class="container">
            <div class="tab-content" id="tabing-product">
                <?php
                    $numbe = 1;
                ?>
                @foreach($categoryutama as $cuta)
                    <?php
                        if($numbe == 1){
                            $clsnya = "active";
                        }else{
                            $clsnya = "";
                        }
                    ?>
                    <div class="tab-pane fade show {{$clsnya}}" id="tabke{{$numbe}}" role="tabpanel">
                        <div class="product_carousel product_column5 owl-carousel">
                            @foreach($product as $p)
                            <?php
                                $cat1 = getCategoryName($p->id_csc_product, $lct);
                                $cat2 = getCategoryName($p->id_csc_product_level1, $lct);
                                $cat3 = getCategoryName($p->id_csc_product_level2, $lct);

                                if($cat3 == "-"){
                                    if($cat2 == "-"){
                                        $categorynya = $cat1;
                                    }else{
                                        $categorynya = $cat2;
                                    }
                                }else{
                                    $categorynya = $cat3;
                                }

                                $img1 = $p->image_1;
                                $img2 = $p->image_2;

                                if($img1 == NULL){
                                    $isimg1 = '/image/noimage.jpg';
                                }else{
                                    $image1 = 'uploads/Eksportir_Product/Image/'.$p->id.'/'.$img1; 
                                    if(file_exists($image1)) {
                                      $isimg1 = '/uploads/Eksportir_Product/Image/'.$p->id.'/'.$img1;
                                    }else {
                                      $isimg1 = '/image/noimage.jpg';
                                    }  
                                }

                                if($img2 == NULL){
                                    $isimg2 = '/image/noimage.jpg';
                                }else{
                                    $image2 = 'uploads/Eksportir_Product/Image/'.$p->id.'/'.$img2; 
                                    if(file_exists($image2)) {
                                      $isimg2 = '/uploads/Eksportir_Product/Image/'.$p->id.'/'.$img2;
                                    }else {
                                      $isimg2 = '/image/noimage.jpg';
                                    }  
                                }
                            ?>
                                <div class="single_product">
                                    <div class="product_name">
                                        <h3><a href="{{url('front_end/product/'.$p->id)}}">{{getProductAttr($p->id, 'prodname', $lct)}}</a></h3>
                                        <p class="manufacture_product"><a href="#">{{$categorynya}}</a></p>
                                    </div>
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{url('front_end/product/'.$p->id)}}"><img src="{{url('/')}}{{$isimg1}}" alt=""></a>
                                        <a class="secondary_img" href="{{url('front_end/product/'.$p->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a>
                                        <div class="label_product">
                                            <!-- <span class="label_sale">-57%</span> -->
                                        </div>

                                        <!-- <div class="action_links">
                                            <ul>
                                                <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"> <span class="lnr lnr-magnifier"></span></a></li>
                                                <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><span class="lnr lnr-heart"></span></a></li>
                                                <li class="compare"><a href="compare.html" title="compare"><span class="lnr lnr-sync"></span></a></li>
                                            </ul>
                                        </div> -->
                                    </div>
                                    <div class="product_content">
                                        <div class="product_footer d-flex align-items-center">
                                            <div class="price_box">
                                                @if(is_numeric($p->price_usd))
                                                    <span class="regular_price">
                                                        $ {{$p->price_usd}}
                                                    </span>
                                                @else
                                                    <span class="regular_price" style="font-size: 13px;">
                                                        {{$p->price_usd}}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="add_to_cart">
                                                <a href="cart.html" title="add to cart"><span class="lnr lnr-cart"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <?php $numbe++; ?>
                @endforeach
            </div>
        </div>
    </section>
    <!--product category end-->

<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
@include('frontend.layouts.footer')
<script type="text/javascript">
    // $(document).ready(function () {
        
    // })
    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#'+tabname).addClass('active');
    }
</script>