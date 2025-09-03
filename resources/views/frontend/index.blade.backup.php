@include('frontend.layouts.header')
<!--slider area start-->
<style type="text/css">
    .categories_menu_toggle > ul > li ul.categories_mega_menu > li{
        width: 80%;
        padding: 0px 0px 0px 15px
    }

	.categories_menu_toggle > ul > li ul.categories_mega_menu > li > a {
    text-transform: none!important;
	}
    .row-menu{
        margin-top: 10%;
        margin-bottom: 10%;
    }

    .product_tab_button.nav div{
      margin: 2% 0 1% 0;
    }

    .product_tab_button.nav div a{
        font-size: 12px; 
        color: #34b1e5;
        font-family: 'Myriad-pro'; 
    }

    .product_tab_button.nav div a.active, .product_tab_button.nav div a:hover{
        text-decoration: none;
        font-weight: 500;
        font-size: 12px; 
        font-family: 'Myriad-pro'; 
        color: #fe8f00;
    }

    .for-act{
        text-decoration: none;
        opacity: 0.7;
    }

    .box-cu{
        width: 90%;
        background-color: white;
        /*border: 1px solid silver;*/
        border-radius: 20px;
        padding: 3%;
    }

    .button_form{
        width: auto;
    }

    .href-name {
        color: black;
    }

    .href-name:hover {
        text-decoration: none;
    }

    .href-company{
        text-transform: capitalize; 
        font-size: 11px; 
        font-family: 'Open Sans', sans-serif; 
        /*color: black;*/
    }

    .href-company:hover{
        text-decoration: none;
        color: black !important;
    }

    .href-category{
        text-transform: capitalize; 
        font-size: 11px !important; 
        font-family: 'Open Sans', sans-serif; 
    }

    .href-category:hover{
        text-decoration: none;
        /*color: #2777d0 !important;*/
    }
    .single_product:hover{
        box-shadow: 0 0 15px rgba(178,221,255,1); 
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
    .container-fluid{
        padding-left: 0px!important;
        padding-right: 0px!important;
    }

    @media only screen and (max-width: 767px) {
        .categories_menu_toggle > ul > li > a {
            /*line-height: 35px;*/
            /*padding: 0;*/
            color: #ffffff;
        }
    }

    @media only screen and (max-width: 1199px) and (min-width: 992px){
        .categories_menu_toggle > ul > li > a {
            color: #ffffff;
        }
    }


</style>
<style>
	#companyspecialevent_wrapper{
		width: 100%!important;
	}
    #companyspecialevent{
        width: 100%!important;
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
</style>
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
        $by = "通过";
        $order = "最小订购量 : ";
    }else if($loc == "in"){
        $lct = "in";
        $by = "Oleh";
        $order = "Min Order : ";
    }else{
        $lct = "en";
        $by = "By";
        $order = "Min Order : ";
    }

    $imgarray = ['agriculture','apparel','automotive','jewelry','health_beauty','electrics','furniture','industrial_parts','gift_card','food'];
?>
<!-- buat background aja -->
<div style="background-color: #dddee5;!important">
    <!--menu & category start-->
    <section class="slider_section mb-50" style="margin-bottom: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="categories_menu">
                        <div class="categories_title">
                            <h2 class="categori_toggle">@lang('frontend.home.popcategory')</h2>
                        </div>
                        <div class="categories_menu_toggle" style="padding: 0px 0 0px!important;">
                            <ul>
                                @foreach($categoryutama2 as $key => $cu)
                                    <?php
                                        $catprod1 = getCategoryLevel(1, $cu->id, "");
                                        $nk = "nama_kategori_".$lct;
                                        if($cu->$nk == NULL){
                                            $nk = "nama_kategori_en";
                                        }

                                        $textkat = $cu->$nk;
                                        if(strlen($textkat) > 31){
                                            $cut_text = substr($textkat, 0, 31);
                                            if ($textkat[31 - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                $cut_text = substr($textkat, 0, $new_pos);
                                            }
                                            $kategorinya = $cut_text . '...';
                                        }else{
                                            $kategorinya = $textkat;
                                        }
                                        if($cu->logo != null){
                                            $imagenya = asset('uploads/Product/Icon').'/'.$cu->logo;
                                        } else {
                                            $imagenya = asset('front/assets/img/kategori/').'/'.$imgarray[$key].'.png';
                                        }
                                        //nama_kategori_en
                                    ?>
                                    @if(count($catprod1) == 0)
                                        <li><a href="{{url('/kategori/'.$cu->id.'/'.slugifyTitle($cu->nama_kategori_en).'/')}}" title="{{$textkat}}" style="font-size: 13.5px;"><img src="{{$imagenya}}" style="width: 25px; vertical-align: middle;">&nbsp;{{$kategorinya}}</a></li>
                                    @else
                                        <li class="menu_item_children categorie_list"><a href="{{url('/kategori/'.$cu->id.'/'.slugifyTitle($cu->nama_kategori_en).'/')}}" title="{{$textkat}}" ><img src="{{$imagenya}}" style="width: 25px; vertical-align: middle;">&nbsp;{{$kategorinya}} <i class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu" style="width: 160%; margin: 0px; padding: 15px  0px 0px 15px ">
                                                @foreach($catprod1 as $key => $c1)
                                                  @if($key < 19)
                                                    <?php
                                                        $catprod2 = getCategoryLevel(2, $cu->id, $c1->id);
                                                        $nk = "nama_kategori_".$lct;
                                                        if($c1->$nk == NULL){
                                                            $nk = "nama_kategori_en";
                                                        }
                                                    ?>
                                                    <li class="menu_item_children next" style="margin-bottom: 0px; width: 50%;"><a href="{{url('/kategori/'.$c1->id.'/'.slugifyTitle($c1->nama_kategori_en).'/')}}" style="text-transform: capitalize !important; font-weight: lighter;font-size: 13.5px;line-height: 1.5; padding-right: 10px!important;">{{$c1->$nk}}</a></li>
                                                  @endif
                                                @endforeach
                                                @if(count($catprod1) > 19)
                                                <li class="menu_item_children"><a href="{{url('/front_end/list_product')}}" style="text-transform: capitalize !important;font-weight: lighter;font-size: 13.5px!important;line-height: 0.5;padding-top: 5px;"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;@lang('frontend.home.morecategory')</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                                <li id="cat_toggle"><a href="{{url('/kategori')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;@lang('frontend.home.morecategory')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12"><!--Start -->
                    <div class="slider bg_bulet_pink">
                        <div class="container">

                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                        $dasa = DB::select("select * from mst_slide where publish='1' order by id desc");
                                        $ndy = 0;
                                        foreach($dasa as $ds){

                                        ?>
                                        <li data-target="#myCarousel" data-slide-to="<?php echo $ndy ?>" <?php if($ndy == 0){?>class="active" <?php }?>></li>
                                        <?php
                                            $ndy++;
                                            }
                                        ?>
                                    <?php /*<li data-target="#myCarousel" data-slide-to="0" class=""></li>
                                    <li data-target="#myCarousel" data-slide-to="1" class=""></li>
                                    <li data-target="#myCarousel" data-slide-to="2" class="active"></li>*/
                                    ?>
                                </ol>
                                <div class="carousel-inner"  style="height: 372px!Important;">
                                    <?php
                                        $dasa = DB::select("select * from mst_slide where publish='1' order by id desc");
                                        $nds = 1;
                                        foreach($dasa as $ds){
                                            if($nds == 1){
                                            ?>
                                        <div class="carousel-item active" style="height: 372px!Important;">
                                            <a href="<?php echo $ds->link;?>"> <img class="first-slide" src="{{asset('uploads/slider')}}<?php echo "/".$ds->file_img; ?>" alt="First slide" style="height: 372px!Important;"></a>
                                            <?php
                                            }else if($nds==2){
                                                ?>
                                            <div class="carousel-item">
                                                <a href="<?php echo $ds->link;?>"><img class="second-slide" src="{{asset('uploads/slider')}}<?php echo "/".$ds->file_img; ?>" alt="Second slide" style="height: 372px!Important;"></a>
                                            <?php
                                            }else{
                                            ?>
                                                <div class="carousel-item">
                                                    <a href="<?php echo $ds->link;?>"><img class="third-slide" src="{{asset('uploads/slider')}}<?php echo "/".$ds->file_img; ?>" alt="Third slide" style="height: 372px!Important;"></a>
                                            <?php
                                            }
                                            ?>
                                        <div class="container">

                                            <div class="carousel-caption text-left">
                                                <h1-title-slide style="text-shadow: 2px 2px 8px #000000;"><?php echo $ds->keterangan;?></h1-title-slide>
                                                <p style="text-shadow: 2px 2px 8px #000000; margin-top:30px">

                                                </p>
                                                <a class="btn btn-lg link-learn-more" href="<?php echo $ds->link;?>" role="button" target="_self">Visit</a>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                        $nds++;
                                        }
                                        ?>
                                        </div>
                                        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End-->
            </div>
        </div>
    </section>
    <!--menu & category end-->
{{--    <br>--}}
    <!--regis start-->
    <section class="product_area mb-50" style="background-color: #ddeffd; padding: 4%; margin-bottom: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            @if($loc == "in")
                                <span style="font-size: 20px;">
                                    Buat akun Anda dan mulailah <br>berbisnis <span style="color: #007bff;">skala internasional</span>
                                </span><br>
                            @elseif($loc == "ch")
                                <span style="font-size: 20px;">
                                    创建您的帐户并开始从事业务<span style="color: #007bff;">国际规模</span>
                                </span><br>
                            @else
                                <span style="font-size: 20px;">
                                    Create your account and start doing<br> business on <span style="color: #007bff;">an international scale</span>
                                </span><br>
                            @endif
                            <span style="font-size: 18px; color: #007bff;">{{getCountData('itdp_company_users')}}+ </span>
                            @if($loc == "in")
                                <span style="font-size: 18px; color: #666;">pengusaha telah bergabung</span>
                            @elseif($loc == "ch")
                                <span style="font-size: 18px; color: #666;">位企业家加入</span>
                            @else
                                <span style="font-size: 18px; color: #666;">entrepreneurs have joined</span>
                            @endif
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <center>
                                <a href="{{url('/pilihregister')}}" class="btn btn-primary" style="width: 200px; font-size: 18px; border-radius: 30px;">@if($loc == 'ch') 寄存器 @elseif($loc == "in") Daftar @else Register @endif</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--regis end-->

        <!--Event Special start-->
        <?php
        $today = date("Y-m-d");
        // (date('d-m-Y',strtotime($d->end_at))
        $checkevent = DB::table('banner')->where('deleted_at',null)->select('*')->where('ordering','!=', null)->where('status',1)->whereDate('end_at', '>=',"'".$today."'")->orderby('ordering','asc')->get();
        // if(isset($checkevent)){
        //     $checkeksportirnya = DB::table('banner_detail')->where('id_banner',$checkevent->id)->first();
        // }
        
        // echo $checkevent->tosql();
        // echo $checkevent;
        // if(isset($checkevent)){
        //     echo "<div class='row'><div class='col-md-12'><img src='{{asset('asset('/uploads/banner/'.$checkevent->file)')}}'></div></div>";
        // }
    ?>   
    @if(isset($checkevent))
    <section class="special_event_area mb-50" style=" margin-bottom: 0px;">
    <div class="breadcrumbs_area">
        <div class="container" style="padding-left:0px;padding-right:0px;">
        <!-- <div class="container-fluid"> -->
        <!-- <p> -->
            @if(count($checkevent)>0)
                @foreach($checkevent as $event)
                    <a href="{{url('front_end/list_product/categoryeks/'.$event->id)}}" >
                        <img style="width:100%; max-width: 100%;heigth:231px" src="{{asset('uploads/banner/')}}/{{$event->file}}" alt="">
                        <!-- <img class="img-fluid" style="width:100%; max-width: 100%;heigth:231px" src="{{asset('uploads/banner/')}}/{{$event->file}}" alt=""> -->
                    </a>
                @endforeach
            @endif
        <!-- </p> -->

                {{--<img style="max-width: 100%;min-width: 100%;heigth:231px" src="{{asset('uploads/banner/')}}/{{$checkevent->file}}" data-show-id="{{$checkevent->id}}" data-toggle="modal"  data-target="#modal-special-event" alt="">--}}

        </div>
    </div>
    </section>
    <!-- <div id="modal-special-event" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Contributed Company</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            <input type="hidden" id="idbannernya" name="idbannernya" value="{{--{{$checkevent[0]->id}}--}}" >
            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}<br>
                <div class="modal-body">
                    <table id="companyspecialevent" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Company</center></th>
                            </tr>
                        </thead>
                </table>
                
                </div>
            <br>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger" title="cancel">Cancel</button>
            </div>
            </form>
            </div>

        </div>
    </div> -->
    @endif
    
    <!--Event Special end-->


	<div class="breadcrumbs_area">
        <div class="container" style="
    background-color: white;
    /* padding-left: 200px; */
">
<br>
		<center><h4>Service Highlight</h4></center>
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-12 hoveraja">
                                <a href="{{url('/br_importir_all')}}"><img src="{{asset('front/assets/icon/01 inquiry-02.png')}}" alt="" class="image img-menu"></a>
								<div class="middle" style="margin-top: -10px; font-size:14px!Important;">
								<center><p><font color="black"><b></b></font></p></center>
								<div class="text"><a href="{{url('/br_importir_all')}}" class="btn btn-primary" style="width:100px!important;">View</a></div>
								</div>
								<br>
							</div>
                            <div class="col-md-4 col-sm-12 col-12 hoveraja">
                                 <a href="{{url('/br_importir')}}"><img src="{{asset('front/assets/icon/02 buying request-03.png')}}" alt="" class="image img-menu"></a>
								<div class="middle" style="margin-top: -10px; font-size:14px!Important;">
								<center><p><font color="black"><b></b></font></p></center>
								<div class="text"><a href="{{url('/br_importir')}}" class="btn btn-primary" style="width:100px!important;">View</a></div>
								</div>
								<br>
							</div>
                            <div class="col-md-4 col-sm-12 col-12 hoveraja">
                                <!-- <a onclick="checkfirst()"> -->
                                <a href="{{url('/front_end/curris')}}">
                                <img src="{{asset('front/assets/icon/03 current issue-04.png')}}" alt="" class="image img-menu">
                                </a>
								<div class="middle" style="margin-top: -10px; font-size:14px!Important;">
                                <center><p><font color="black"><b></b></font></p></center>
                                <!-- <button onclick="checkfirst()"  class="btn btn-primary" style="width:100px!important;">View</button> -->
                                <div class="text"><a href="{{url('/front_end/curris')}}" class="btn btn-primary" style="width:100px!important;">View</a></div>
                                <a href="{{url('/front_end/curris')}}" id="buttoncurris" style="display: none;"></a>
								</div>
								<br>
							</div>
                           
                        </div>
                        <div class="row">
							 <div class="col-md-4 col-sm-12 col-12 hoveraja">
                                <a href="{{url('/front_end/event')}}"><img src="{{asset('front/assets/icon/04 event-05.png')}}" alt="" class="image img-menu"></a>
								<div class="middle" style="margin-top: -10px; font-size:14px!Important;">
								<center><p><font color="black"><b></b></font></p></center>
								<div class="text"><a href="{{url('/front_end/event')}}" class="btn btn-primary" style="width:100px!important;">View</a></div>
								</div>
								<br>
							</div>
                            <div class="col-md-4 col-sm-12 col-12 hoveraja">
                                <a href="{{url('/front_end/training')}}"><img src="{{asset('front/assets/icon/05 training-06.png')}}" alt="" class="image img-menu"></a>
								<div class="middle" style="margin-top: -10px; font-size:14px!Important;">
								<center><p><font color="black"><b></b></font></p></center>
								<div class="text"><a href="{{url('/front_end/training')}}" class="btn btn-primary" style="width:100px!important;">View</a></div>
								</div>
								<br>
							</div>
                            <div class="col-md-4 col-sm-12 col-12 hoveraja">
                                <a href="{{url('/front_end/research-corner')}}"><img src="{{asset('front/assets/icon/06 research corner-07.png')}}" alt="" class="image img-menu"></a>
								<div class="middle" style="margin-top: -10px; font-size:14px!Important;">
								<center><p><font color="black"><b></b></font></p></center>
								<div class="text"><a href="{{url('/front_end/research-corner')}}" class="btn btn-primary" style="width:100px!important;">View</a></div>
								</div>
								<br>
							</div>
							
							</div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
	
	
<br>



	<!--buyer & seller start-->
	<?php 
	/*
    <div class="breadcrumbs_area" style="">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <div class="row">
                          <div class="col-md-6 col-lg-6 col-12">
                            <center>
                            <?php
                                $url = '/login';
                                if(Auth::guard('eksmp')->user()){
                                    if(Auth::guard('eksmp')->user()->id_role == 2){
                                        $url = '/home';
                                    }else if(Auth::guard('eksmp')->user()->id_role == 3){
                                        $url = '/';
                                    }
                                }
                            ?>
                                @if(Auth::guard('eksmp')->user())
                                @if(Auth::guard('eksmp')->user()->id_role == 3)
                                <a href="{{url($url)}}" class="for-act">
                                @endif
                                @else
                                <a href="{{url($url)}}" class="for-act">
                                @endif
                                  <img src="{{asset('front/assets/icon/fb.png')}}" alt="">
                                @if(Auth::guard('eksmp')->user())
                                @if(Auth::guard('eksmp')->user()->id_role == 3)
                                </a>
                                @endif
                                @else
                                </a>
                                @endif
                            </center>
                          </div>
                          <div class="col-md-6 col-lg-6 col-12">
                            <center>
                                @if(Auth::guard('eksmp')->user())
                                @if(Auth::guard('eksmp')->user()->id_role == 2)
                                <a href="{{url($url)}}" class="for-act">
                                @endif
                                @else
                                <a href="{{url($url)}}" class="for-act">
                                @endif
                                  <img src="{{asset('front/assets/icon/02-for indonesian exporter.png')}}" alt="" >
                                @if(Auth::guard('eksmp')->user())
                                @if(Auth::guard('eksmp')->user()->id_role == 2)
                                </a>
                                @endif
                                @else
                                </a>
                                @endif
                            </center>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	*/ ?>
	
    <!--buyer & seller start-->
	<?php /*
	<br>
	 <!--category product start-->
    <section class="product_area mb-50" style="background-color: #ddeffd;">
        <div class="container">
            <div class="row">
                
            </div>
        </div>
    </section>
	*/ ?>
    <!--category product end-->


    <!--product category start-->
    <section class="product_area mb-50">
        <div class="container" style="background-color:white!important;"><br>
		<center><h4>Popular Product</h4></center>
			<div class="col-12">
                    <div class="section_title" style="margin-bottom: 0px;">
                        <!-- <div class="row product_tab_button nav" role="tablist" style="background-color: inherit; width: 100%">
                            <div class="col-md-2">
                                
                            </div>
                        </div> -->
                        <div class="row product_tab_button nav justify-content-center" role="tablist" style="background-color: inherit; width: 100%">
                            <?php
                                $numb = 1;
                                $warna = ['red','DarkKhaki','orange','SeaGreen','Cyan','blue']
                            ?>
                            @foreach($categoryutama2 as $cut)
                            <?php
                                $cls = "";
                                if($numb == 1){
                                    $cls = "active";
                                }
                            ?>
                            <div class="col-md-2 col-lg-2 col-4" align="center">
                                <?php
                                    $nkat = "nama_kategori_".$lct; 
                                    if($cut->$nkat == NULL){
                                        $nkat = "nama_kategori_en";
                                    }

                                    $num_char = 30;
                                    $textkat = $cut->$nkat;
                                    if(strlen($textkat) > 30){
                                        $cut_text = substr($textkat, 0, $num_char);
                                        if ($textkat[$num_char - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                            $cut_text = substr($textkat, 0, $new_pos);
                                        }
                                        $kategorinya = $cut_text . '...';
                                    }else{
                                        $kategorinya = $textkat;
                                    }
                                ?>


                                <a class="tabnya {{$cls}}" data-toggle="tab" href="#tabke{{$cut->id}}" aria-controls="tabke{{$cut->id}}" aria-selected="true" title="{{$textkat}}" onclick="openTab('tabke{{$cut->id}}')">
{{--                                    <img src="{{asset('front/assets/img/kategori/')}}/{{$imgarray[$numb-1]}}.png" alt="" style="height: 40px">--}}
                                    <div style="border-radius: 50%; display: table-cell; background-color: {{$warna[$numb-1]}}; vertical-align: middle; width: 85px;height: 85px;">
                                        <img src="{{asset('uploads/Product/Icon')}}/{{$cut->logo}}" alt="" style="height: 75px">
                                    </div>
                                        <p>{{$kategorinya}}</p>
                                </a>
                            </div>
                            <?php $numb++; ?>
                            @endforeach
                        </div>
                    </div>

                </div>
            <div class="tab-content" id="tabing-product">
                <?php
                    $numbe = 1;
                ?>
                @foreach($categoryutama2 as $cuta)
                    <?php
                        if($numbe == 1){
                            $clsnya = "active";
                        }else{
                            $clsnya = "";
                        }
                    ?>
                    <div class="tab-pane fade show {{$clsnya}} product" id="tabke{{$cuta->id}}" role="tabpanel">
                        <?php
                            $product = getProductByCategory2($cuta->id);
                        ?>
                        @if(count($product) == 0)
                        <center>
                            <span style="font-size: 15px;">
                                @if($loc == "ch")
                                - 此类别的产品为空 -
                                @elseif($loc == "in")
                                - Produk dalam kategori ini kosong - 
                                @else
                                - Products in this category are empty -
                                @endif
                            </span>
                        </center>
                        @else
                        <div class="product_carousel product_column5 owl-carousel" style="padding-top: 25px;padding-bottom: 25px;">
                                @foreach($product as $key => $p)
                                    <?php
                                        $dis2 = "display: none;";
                                        if(in_array($p->id, $hot_product)){
                                            $dis2 = "";
                                        }
                                        $cat1 = getCategoryName($p->id_csc_product, $lct);
                                        $cat2 = getCategoryName($p->id_csc_product_level1, $lct);
                                        $cat3 = getCategoryName($p->id_csc_product_level2, $lct);

                                        if($cat3 == "-"){
                                            if($cat2 == "-"){
                                                $categorynya = $cat1;
                                                $idcategory = $p->id_csc_product;
                                            }else{
                                                $categorynya = $cat2;
                                                $idcategory = $p->id_csc_product_level1;
                                            }
                                        }else{
                                            $categorynya = $cat3;
                                            $idcategory = $p->id_csc_product_level2;
                                        }

                                        $img1 = $p->image_1;

                                        if($img1 == NULL){
                                            $isimg1 = '/image/notAvailable.png';
                                        }else{
                                            $image1 = 'uploads/Eksportir_Product/Image/'.$p->id.'/'.$img1; 
                                            if(file_exists($image1)) {
                                              $isimg1 = '/uploads/Eksportir_Product/Image/'.$p->id.'/'.$img1;
                                            }else {
                                              $isimg1 = '/image/notAvailable.png';
                                            }  
                                        }
                                        $cekImage = explode('.', $img1);
                                        $sizeImg = 210;
                                        $padImg = '0px';
                                        if($cekImage[(count($cekImage)-1)] == 'png'){
                                            $sizeImg = 190;
                                            $padImg = '10px 5px 0px 5px';
                                        }
                                        $minorder = '-';
                                        $minordernya = '-';
                                        if($p->minimum_order != null){
                                            $minorder = $p->minimum_order;
                                            if(strlen($minorder) > 18){
                                                $cut_desc = substr($minorder, 0, 18);
                                                if ($minorder[18 - 1] != ' ') { 
                                                    $new_pos = strrpos($cut_desc, ' '); 
                                                    $cut_desc = substr($minorder, 0, $new_pos);
                                                }
                                                $minordernya = $cut_desc . '...';
                                            }else{
                                                $minordernya = $minorder;
                                            }
                                        }
                                        $ukuran = '340px';
                                        if(!empty(Auth::guard('eksmp')->user())){
                                            if(Auth::guard('eksmp')->user()->status == 1){
                                                $ukuran = '375px';
                                            }
                                        }
                                    ?>
                                    <div class="single_product" style="border-radius:0px!important; height: {{$ukuran}}; background-color: #fdfdfc; padding: 0px !important;">
                                        <div class="hot-type" style="{{$dis2}}">
                                        <span class="hot-type-content">
                                             @if($loc == "ch")
                                                热
                                            @elseif($loc == "in")
                                                HOT
                                            @else
                                                HOT
                                            @endif
                                        </span>
                                        </div>
                                        <?php
                                            //cut prod name
                                            $num_char = 19;
                                            $prodn = getProductAttr($p->id, 'prodname', $lct);
                                            if(strlen($prodn) > 19){
                                                $cut_text = substr($prodn, 0, $num_char);
                                                if ($prodn[$num_char - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                    $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                    $cut_text = substr($prodn, 0, $new_pos);
                                                }
                                                $prodnama = $cut_text . '...';
                                            }else{
                                                $prodnama = $prodn;
                                            }

                                            //cut company
                                            $num_charp = 25;
                                            $compname = getCompanyName($p->id_itdp_company_user);
                                            if(strlen($compname) > 25){
                                                $cut_text = substr($compname, 0, $num_charp);
                                                if ($compname[$num_charp - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                    $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                    $cut_text = substr($compname, 0, $new_pos);
                                                }
                                                $companame = $cut_text . '...';
                                            }else{
                                                $companame = $compname;
                                            }

                                            $num_chark = 25;
                                            if(strlen($categorynya) > 25){
                                                $cut_text = substr($categorynya, 0, $num_chark);
                                                if ($categorynya[$num_chark - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                    $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                    $cut_text = substr($categorynya, 0, $new_pos);
                                                }
                                                $category = $cut_text . '...';
                                            }else{
                                                $category = $categorynya;
                                            }
                                            $param = $p->id_itdp_company_user.'-'.getCompanyName($p->id_itdp_company_user);
                                        ?>
                                        <div class="product_thumb" align="center" style="background-color: #e8e8e4; height: 210px; border-radius: 0px 0px 0px 0px;">
                                                <a class="primary_img" href="{{url('produk/'.slugifyTitle($categorynya).'/'.$p->id.'/'.slugifyTitle($p->prodname_en))}}" onclick="GoToProduct('{{$p->id}}', event, this)"><img src="{{url('/')}}{{$isimg1}}" alt="" style="vertical-align: middle; height: {{$sizeImg}}px; border-radius: 10px 10px 0px 0px; padding: {{$padImg}}"></a>
                                        </div>
                                        <div class="product_name grid_name" style="padding: 0px 13px 0px 13px;">
                                            <p class="manufacture_product">
                                                <a href="{{url('kategori/'.$idcategory.'/'.slugifyTitle($categorynya))}}" title="{{$categorynya}}" class="href-category">{{$category}}</a>
                                            </p>
                                            <h3>
                                                <a href="{{url('produk/'.slugifyTitle($categorynya).'/'.$p->id.'/'.slugifyTitle($p->prodname_en))}}" title="{{$prodn}}" class="href-name" onclick="GoToProduct('{{$p->id}}', event, this)"><b>{{$prodnama}}</b></a>
                                            </h3>
                                            <span style="font-size: 12px; font-family: 'Open Sans', sans-serif; ">
                                                @if(!empty(Auth::guard('eksmp')->user()))
                                                    @if(Auth::guard('eksmp')->user()->status == 1)
                                                    
                                                        @if(is_numeric($p->price_usd))
                                                            <?php 
                                                                $pricenya = "$ ".number_format($p->price_usd,0,",",".");
                                                                $price = $pricenya;
                                                            ?>
                                                        @else
                                                            <?php 
                                                                $price = $p->price_usd;
                                                                if(strlen($price) > 18){
                                                                    $cut_text = substr($price, 0, 18);
                                                                    if ($price[18 - 1] != ' ') { 
                                                                        $new_pos = strrpos($cut_text, ' ');
                                                                        $cut_text = substr($price, 0, $new_pos);
                                                                    }
                                                                    $pricenya = $cut_text . '...';
                                                                }else{
                                                                    $pricenya = $price;
                                                                }
                                                            ?>
                                                        @endif
                                                    <span style="color: #fd5018;" title="{{$price}}">
                                                      <b>  {{$pricenya}} </b>
                                                    </span>
                                                    <br>
                                                    @endif
                                                @endif

                                                {{$order}}<span title="{{$minorder}}"></span>{{$minordernya}}<br>
                                                <a href="{{url('perusahaan/'.slugifyTitle($param))}}" title="{{$compname}}" class="href-company"><span style="color: black;">{{$by}}</span>&nbsp;&nbsp;{{$companame}}</a>
                                            </span>
                                        </div>
                                        
                                        <div class="product_content list_content">
                                            <div class="left_caption">
                                                <div class="product_name">
                                                    <h3>
                                                        <a href="{{url('produk/'.slugifyTitle($categorynya).'/'.$p->id.'/'.slugifyTitle($p->prodname_en))}}" title="{{$prodn}}" class="href-name" style="font-size: 15px !important;"><b>{{$prodn}}</b></a>
                                                    </h3>
                                                    <h3>
                                                        <a href="{{url('perusahaan/'.slugifyTitle($param))}}" title="{{$compname}}" class="href-company"><span style="color: black;">{{$by}}</span>&nbsp;&nbsp;{{$compname}}</a>
                                                    </h3>
                                                </div>
                                                <div class="product_desc">
                                                    <?php
                                                        $proddesc = getProductAttr($p->id, 'product_description', $lct);
                                                        $num_desc = 350;
                                                        if(strlen($proddesc) > $num_desc){
                                                            $cut_desc = substr($proddesc, 0, $num_desc);
                                                            if ($proddesc[$num_desc - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                                $new_pos = strrpos($cut_desc, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                                $cut_desc = substr($proddesc, 0, $new_pos);
                                                            }
                                                            $product_desc = $cut_desc . '...';
                                                        }else{
                                                            $product_desc = $proddesc;
                                                        }
                                                        $product_desc = strip_tags($product_desc, "<a><br><i><b><u><hr>");
                                                    ?>
                                                    <?php echo $product_desc; ?>
                                                </div>
                                            </div>
                                            <div class="right_caption">
                                                <div class="text_available">
                                                    <p>
                                                        @lang('frontend.available'): 
                                                        @if($loc == "ch")
                                                            <span>库存{{$p->capacity}}件</span>
                                                        @elseif($loc == "in")
                                                            <span>{{$p->capacity}} dalam persediaan</span>
                                                        @else
                                                            <span>{{$p->capacity}} in stock</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="price_box">
                                                    @if(!empty(Auth::guard('eksmp')->user()))
                                                        @if(Auth::guard('eksmp')->user()->status == 1)
                                                        <span class="current_price">
                                                            @if(is_numeric($p->price_usd))
                                                                $ {{number_format($p->price_usd,0,",",".")}}
                                                            @else
                                                                <span style="font-size: 13px;">
                                                                    {{$p->price_usd}}
                                                                </span>
                                                            @endif
                                                        </span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <?php $numbe++; ?>
                @endforeach
            </div>
        </div>
    </section>
    <!--product category end-->
	

    <!--regis start-->
    <section class="breadcrumbs_area" style="padding-top: 4%;padding-bottom: 4%; margin-bottom: 0px;" data-bgimg="{{asset('front/assets/icon/homepage2.png')}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <br>
                            <div style="padding-left:10px;padding-right:10px;">
                                <p style="font-size:20px;"><b>@lang("login.lbl5")</b></p>
                                <p style="font-size:16px;">@lang("login.lbl6") <br> @lang("login.lbl7")
                                <br> @lang("login.lbl8")</p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5" style="padding-top: 20px;">
                            <div class="box-cu">
							<form class="form-horizontal" method="POST" action="{{ url('br_importir_next') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                    <center><h5><b>@lang("login.forms.by1")</b></h5></center>
                                    <br>
                                   <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="text" style="color:black;font-size: 13px;" value="" name="subyek" id="subyek" class="form-control" placeholder="@lang('login.forms.by2')?" required>
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                        <div class="col-md-12">
                                            <select style="font-size: 13px;" class="form-control" name="valid" id="valid" required>
                                                <option value="" disabled selected>@lang("login.forms.by10")</option>
                                                <option value="0">None</option>
                                                <option value="1">Valid within 1 day</option>
                                                <option value="3">Valid within 3 day</option>
                                                <option value="5">Valid within 5 day</option>
                                                <option value="7">Valid within 7 day</option>
                                                <option value="14">Valid within 2 week</option>
                                                <option value="30">Valid within 1 month</option>
                                            </select>
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                        <div class="col-md-12">
                                            <textarea style="color:black; font-size: 13px;" value="" name="spec" id="spec" class="form-control" placeholder="@lang('login.forms.by4')"></textarea>
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                       <div class="col-md-7">
                                           <input style="color:black; font-size: 13px;" type="number" min="1" name="eo" id="eo" class="form-control" placeholder="@lang('login.forms.by5')">
                                       </div>
                                       <div class="col-md-5">
                                           <select class="form-control" name="neo" id="neo" style="font-size: 12px;">
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

                                   <div class="form-group row">
                                       <div class="col-md-7">
                                            <input style="color:black; font-size: 13px;" type="text" value="" name="tp" id="tp" class="form-control amount" placeholder="@lang('login.forms.by6')">
                                        </div>
                                        <div class="col-md-5">
                                            <select  class="form-control" name="ntp" id="ntp" style="font-size: 12px;">
                                                <option value="" disabled selected>@lang("login.forms.by14")</option>
                                                <option value="SAR">Arab Saudi Riyal(SAR)</option>
                                                <option value="BND">Brunei Dollar(BND)</option>
                                                <option value="CNY">China Yuan(CNY)</option>
                                                <option value="IQD">Dinar Irak(IQD)</option>
                                                <option value="AED">Dirham Uni Emirat Arab(AED)</option>
                                                <option value="USD">Dollar Amerika Serikat(USD)</option>
                                                <option value="AUD">Dollar Australia(AUD)</option>
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
                                                <option value="JPY">Yen Jepang(JPY)</option>

                                            </select>
                                        </div>
                                   </div>
                              
                                   <div class="form-group row">
                                      <div class="col-md-12">
                                        <div align="left">
                                            <button type="submit" style="width: 100%;" class="btn btn-danger button_form">
                                                    @if($loc == 'ch')
                                                    立即发布购买请求
                                                    @elseif($loc == 'in')
                                                    Kirim Permintaan Pembelian Sekarang
                                                    @else
                                                    Post Buying Request Now
                                                    @endif 
											<i class="fa fa-arrow-right"></i>
                                            </button>
                                        </div>
                                      </div>
                                   </div>
							</form>
                            </div>
                                <!-- <div class="row">
                                    <div class="col-md-5" style="padding:15px" >
                                        <img src = "{{asset('front/assets/icon/Logo_Exim.png')}}" > 
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5" style="padding:15px">
                                        <img src = "{{asset('front/assets/icon/Logo_Inatrims.png')}}" > 
                                    </div>
                                   
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--regis end-->

</div>
<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
<link rel="stylesheet" href="{{url('assets')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" type="text/css" />
<script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="{{url('assets')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js" ></script>
    

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(function() {

        $('.amount').keyup( function() {
            $(this).val( formatAmount( $( this ).val() ) );
        });

        

    });


    $(function() {
        
        $("#companyspecialevent").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": '{!! route('bannercompanyfront.getdata') !!}',
                "dataType": "json",
                "type": "GET",
                "data": {_token: '{{csrf_token()}}',id : $('#idbannernya').val(),}
            },
            "columns": [
                    // {data: 'no'},
                    {data: 'no'},
                    {data: 'company'},
                    
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

    $(document).ready(function () {
        if(window.innerWidth <= 900){
            $( ".menu_item_children.next" ).on('click', function() {
                var href = $("a", this).attr('href');
                // window.location.href = href;
                // ada masalah dalam javascript template
            });
        } 
    });

    // function modalspecialevent(a){
    //     var token = $('meta[name="csrf-token"]').attr('content');
	// 	$.get('{{URL::to("ambilbroad3/")}}/'+a,{_token:token},function(data){
    //         $("#isibroadcast").html(data);
    //         calldata();
    //     })
    // }

    // function calldata(){
    //     var id = $('#id_laporan').val();
    //     $.ajax({
    //         method: "POST",
    //         url: "{!! url('getdatapiliheksportir') !!}",
    //         data:{_token: '{{csrf_token()}}',id_laporan:id}
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
        $('#'+tabname).addClass('active');
    }

    function formatAmountNoDecimals( number ) {
        var rgx = /(\d+)(\d{3})/;
        while( rgx.test( number ) ) {
            number = number.replace( rgx, '$1' + '.' + '$2' );
        }
        return number;
    }

    function GoToProduct(id, e, obj){
        e.preventDefault();
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{route('product.hot')}}",
            type: 'post',
            data: {'_token':token,id:id},
            dataType: 'json',
            success:function(response){
                if(response == 'ok'){
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
    function checkfirst(){
        <?php
        if(Auth::guard('eksmp')->user()){
            if(Auth::guard('eksmp')->user()->id_role == 2){
              $tipe = 'eksportir';
              $login = 'eksportir';
              $message = '';
            } else { 
                $login = 'importir';
              $for = 'importir';
                if($loc == "ch"){
                  $message = "仅适用于印尼公司";
                }elseif($loc == "in"){
                  $message = "Hanya untuk perusahaan Indonesia";
                }else{
                  $message = "Only for Indonesian companies";
                }
            }
        }else{
            $login = 'non user';
            $for = 'non user';
                if($loc == "ch"){
                  $message = "请先登录";
                }elseif($loc == "in"){
                  $message = "Silahkan Login Terlebih Dahulu!";
                }else{
                  $message = "\Please Login to Continue!";
                }
        }
        ?>

        var tipe = '{{$tipe}}';
        var message = '{{$message}}';
        var login = '{{$login}}';
        console.log(tipe);
        console.log(message);
        console.log(login);
        if(login != 'eksportir' && tipe != 'eksportir' ){
            alert("{{$message}}");
            if(login == 'non user'){
                window.location.href = "{{url('/login')}}";
            }
        }else{
            $('#buttoncurris')[0].click();
        }
        
        // if()
    }

    function formatAmount( number ) {

        // remove all the characters except the numeric values
        number = number.replace( /[^0-9]/g, '' );

        // set the default value
        if( number.length == 0 ) number = "0.00";
        else if( number.length == 1 ) number = "0.0" + number;
        else if( number.length == 2 ) number = "0." + number;
        else number = number.substring( 0, number.length - 2 ) + '.' + number.substring( number.length - 2, number.length );
        
        // set the precision
        number = new Number( number );
        number = number.toFixed( 2 );    // only works with the "."

        // change the splitter to ","
        number = number.replace( /\./g, '' );

        // format the amount
        x = number.split( ',' );
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';

        return formatAmountNoDecimals( x1 ) + x2;
    }
</script>