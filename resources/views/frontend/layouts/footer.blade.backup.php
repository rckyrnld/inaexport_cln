<!--shipping area start-->
<!-- <section class="shipping_area" style="background-color: #ddeffd;">
        <div class="container">
            <div class=" row">
                <div class="col-12">
                    <div class="shipping_inner">
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{asset('front/assets/img/perlindungan_konsumen.png')}}" alt="">
                                <h2>Perlindungan Konsumen</h2>
                                <p>Jaminan perlindungan keamanan kepada konsumen & supplier</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{asset('front/assets/img/pengiriman.png')}}" alt="">
                                <h2>Jaminan Pengiriman</h2>
                                <p>Uang dikembalikan 100% jika barang tidak dikirimkan</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{asset('front/assets/img/pembayaran.png')}}" alt="">
                                <h2>Pembayaran Aman</h2>
                                <p>Pilihan metode pembayaran yang beragam, cepat dan aman</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{asset('front/assets/img/respon.png')}}" alt="">
                                <h2>Respon Cepat</h2>
                                <p>Pelayanan komunikasi 24jam/hari Solusi komunikasi cepat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!--shipping area end-->
<style type="text/css">
    .footer-child{ font-size: 14px; color: grey; line-height: 20px; }
    .third-child{ font-size: 14px; color: grey; }
    .third-child:hover, .third-child:active{ text-decoration: none; }
</style>
<?php
    $loc = app()->getLocale(); 
    if(empty($loc)){ $loc = 'en'; } 
?>
    <section class="call_to_action" style="padding-top:40px;padding-bottom:40px;">
        <div class="container">
            <div class="row counters">

                <div class="col-lg-2 col-sm-12 col-12">
                    <ul class="list-group list-group-horizontal-sm">
                        <li>
                            <img src="{{asset('front/assets/img/exporters.png')}}" alt="" style="width: 33px;margin-left: 10%; float:left">
                            <span class="counters_number" style="margin-right: 20%; text-align:left">{{getCountData('itdp_company_users')}}</span><br>
                            <span class="counters_text" style="margin-left: 20px; text-align: left;">
                            @if($loc == 'ch')
                            出口商
                            @elseif($loc == 'in')
                            Eksportir
                            @else
                            Indonesian Exporters
                            @endif
                            </span>
                        </li>
                    </ul>
                   <!-- <ul class="list-group list-group-horizontal-sm">
                        <li>
                            <img src="{{asset('front/assets/img/exporters.png')}}" alt="" style="width: 20%;margin-left: 20%;">
                            <span class="counters_number" style="margin-right: 20%;float:right">{{getCountData('itdp_company_users')}}</span>
                        </li>
                         <li>
                            <p class="counters_text"  style="font-size: 18px; text-align: center">
							
                                @if($loc == 'ch')
                                出口商
                                @elseif($loc == 'in')
                                Eksportir
                                @else
                                Indonesian Exporters
                                @endif 
                            </p>
                        </li>
                    </ul>-->
                    <br>
                </div>

                <div class="col-lg-2 col-sm-12 col-12">
                    <ul class="list-group list-group-horizontal-sm ">
                        <li>
                            <img src="{{asset('front/assets/img/products.png')}}" alt="" style="width:35px; margin-left: 10%; float: left;">
                            <span class="counters_number" style="margin-right:20%; text-align: left">{{getCountData('csc_product_single')}}</span><br>
                            <span class="counters_text" style="margin-left:20px; text-align: left">
                            @lang('frontend.home.product')
                            </span>
                        </li>
                    </ul>
                    <!--<ul class="list-group list-group-horizontal-sm ">
                        <li>
                            <img src="{{asset('front/assets/img/products.png')}}" alt="" style="width: 20%; margin-left: 20%;">
                            <span class="counters_number" style="margin-right:20%;float: right">{{getCountData('csc_product_single')}}</span>
                        </li>
                        <li>
                            <p class="counters_text" style="font-size: 18px;text-align: center">@lang('frontend.home.product')</p>
                        </li>
                    </ul>-->
                </div>

                

                <div class="col-lg-4 col-sm-12 col-12 ">
                    <ul class="list-group list-group-horizontal-sm" >
                        <!-- style="margin-left:18%;margin-right:18%;" -->
                        <li style="margin-left:18%;margin-right:18%;">
                            <img src="{{asset('front/assets/img/representative.png')}}" alt="" style="width: 30px;margin-left: 10%; float:left">
                            <span class="counters_number" style="margin-right: 20%;text-align:left">{{getCountData('itdp_admin_users')}}</span><br>
                            <!-- <span class="counters_text" style="margin-right: 23%; font-size: 18px; float: right;"> -->
                            <span class="counters_text" style="margin-left: 20px; text-align: left;">
                            @if($loc == 'ch')
                            海外贸易代表
                            @elseif($loc == 'in')
                            Perwakilan Dagang Luar Negeri
                            @else
                            Overseas Trade Representative 
                            @endif
                            </span>
                        </li>
                    </ul>   
                    <br>
                </div>

                <div class="col-lg-2 col-sm-12 col-12 ">
                    <ul class="list-group list-group-horizontal-sm" >
                        <li>
                            <img src="{{asset('front/assets/img/events.png')}}" alt="" style="width: 35px;;margin-left: 10%; float:left">
                            <span class="counters_number" style="margin-right: 20%;text-align:left">{{getCountData('event_detail')}}</span><br>
                            <span class="counters_text" style="margin-left: 20px;text-align: left;">
                            @if($loc == 'ch')
                            国际活动
                            @elseif($loc == 'in')
                            Pameran Internasional
                            @else
                            International Events
                            @endif
                            </span>
                        </li>
                    </ul>   
                    <!--<ul class="list-group list-group-horizontal-sm">
                        <li>
                            <img src="{{asset('front/assets/img/events.png')}}" alt="" style="width: 20%;margin-left: 20%;">
                            <span class="counters_number" style="margin-right: 20%;float:right">{{getCountData('event_detail')}}</span>
                        </li>
                        <li >
                            <p class="counters_text" style="font-size: 18px;text-align: center;">
                                @if($loc == 'ch')
                                事件
                                @elseif($loc == 'in')
                                Acara
                                @else
                                Events
                                @endif
                            </p>
                        </li>
                    </ul>-->
                    <br>
                </div>

                <div class="col-lg-2 col-sm-12 col-12 ">
                    <ul class="list-group list-group-horizontal-sm">
                        <li>
                            <img src="{{asset('front/assets/img/researchcorner.png')}}" alt="" style="width: 35px;margin-left: 10%; float:left">
                            <span class="counters_number" style="margin-right: 20%;text-align:left">{{getCountData('csc_research_corner')}}</span><br>
                            <!-- <span class="counters_text" style="margin-right: 23%; font-size: 18px; float: right;"> -->
                            <span class="counters_text" style="margin-left: 20px; text-align: left;">
                            @if($loc == 'ch')
                            市场调查
                            @elseif($loc == 'in')
                            Riset Pasar
                            @else
                            Market Research
                            @endif
                            </span>
                        </li>
                    </ul>   
                    <br>
                </div>
    
            </div>
        </div>
    </section>

<!--footer area start-->
<footer class="footer_widgets" style="background-color:white">
        <div class="container">
            <div class="footer_top">
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-md-12">
                        <div class="widgets_container widget_menu">
                            <h3><span style="color: #096bd8">@lang("footer.foot.contact")</span> <span style="color: #ff8d00">@lang("footer.foot.with-us")</span></h3>
                            <div class="footer_menu">
                                <ul>
                                    <li style="font-size: 14px; font-weight: 600;">@lang("footer.foot.directorate")</li>
                                    <li class="footer-child" style="">@lang("footer.foot.ministry")</li>
                                    <li>
                                        <table border="0">
                                            <tr>
                                                <td width="7%"><img src="{{asset('front/assets/icon/icon_lokasi_3.png')}}"></td>
                                                <td class="footer-child" style="padding-left: 5px;">Jl. M.I. Ridwan Rais No.5, RT.7/RW.1, Gambir, Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110, Indonesia</td>
                                            </tr>
                                            <tr>
                                                <td><img src="{{asset('front/assets/icon/icon_phone_3.png')}}"></td>
                                                <td class="footer-child" style="padding-left: 5px;">+62 21 385 8171</td>
                                            </tr>
                                            <tr>
                                                <td><img src="{{asset('front/assets/icon/icon_idk_3.png')}}"></td>
                                                <td class="footer-child" style="padding-left: 5px;">+62 21 385 8171</td>
                                            </tr>
                                            <tr>
                                                <td><img src="{{asset('front/assets/icon/icon_email_3.png')}}"></td>
                                                <td class="footer-child" style="padding-left: 5px;">mail@inaexport.id</td>
                                            </tr>
											<tr>
                                                <td><img src="{{asset('front/assets/icon/icon_clock_3.png')}}"></td>
                                                <td class="footer-child" style="padding-left: 5px;">
												
								
								<?php 
									$loc = app()->getLocale(); 
									if($loc == "ch"){
										$jo = "营业时间 : 08:00 - 16:00 WIB";
									}else if($loc == "in"){
										$jo = "Jam Operasional : 08:00 - 16:00 WIB";
									}else{
										$jo = "Operational hour : 08:00 - 16:00 WIB";
									}
								echo $jo;
								?>
												</td>
                                            </tr>
                                        </table>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-md-6">
                        <div class="widgets_container widget_menu">
                            <h3><span style="color: #096bd8">@lang("footer.foot.about")</span> <span style="color: #ff8d00">@lang("footer.foot.membership")</span></h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="{{url('/about/')}}" class="third-child">@lang("footer.tentangkami")</a></li>
                                    <li><a href="{{url('/contact-us/')}}" class="third-child">@lang("footer.hubungikami")</a></li>
                                    <li><a href="{{url('/front_end/ticketing_support')}}" class="third-child">@lang("footer.bantuan")</a></li>
                                    <li><a href="{{url('/faq/')}}" class="third-child">FAQ</a></li>
                                    <li><a href="http://tradexpoindonesia.com" class="third-child">@lang("footer.foot.trade-expo")</a></li>
                                    @if(Auth::guard('eksmp')->user()) {{userGuide($loc,  Auth::guard('eksmp')->user()->id_role)}} @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-md-6">
                        <div class="widgets_container widget_menu">
                            <h3><span style="color: #096bd8">@lang("footer.foot.our")</span> <span style="color: #ff8d00">@lang("footer.foot.service")</span></h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="{{url('/front_end/event/')}}" class="third-child">@lang("footer.foot.event")</a></li>
                                    <li><a href="{{url('/front_end/training/')}}" class="third-child">@lang("footer.foot.training")</a></li>
                                    <li><a href="{{url('/front_end/research-corner/')}}" class="third-child">@lang("footer.foot.research")</a></li>
                                    <li><a href="{{url('/front_end/list_product/')}}" class="third-child">@lang("footer.foot.inquiry")</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" >
                        <div class="footer_logo" align="center" style="/*position: absolute; bottom: 0; right: 0;  left: 0; */">
                            <div class="widgets_container contact_us" >
							<!--
                                <a href="http://inatrade.kemendag.go.id" target="_BLANK"><img src="{{asset('front/assets/img/logo/inatrade_.png')}}" alt="" width="100%"></a>
                                <a href="http://exim.kemendag.go.id" target="_BLANK"><img src="{{asset('front/assets/img/logo/logo-alt-01x.png')}}" alt="" style="width:95%!important;height:55px!important;"></a>
								<br><br>
							-->
								<table width="100%">
                                    <tr>
                                        <td width="50%" style="padding: 10px;">    
                                            <a target="_blank" href="http://exim.kemendag.go.id"><img src = "{{asset('front/assets/icon/Logo_Exim.png')}}" ></a>
                                        </td>
                                        <td width="50%" style="padding: 10px;">
                                            <!--<a target="_blank" href="http://inatrims.kemendag.go.id/"><img src = "{{asset('front/assets/icon/Logo_Inatrims.png')}}" ></a>-->
					    <?php
                                            if(Auth::guard('eksmp')->user()) {
                                            if(Auth::guard('eksmp')->user()->id_role == 2) {
                                            ?>
                                            <a target="_blank" href="http://inatrims.kemendag.go.id/index.php/main/negara_djpen"><img src = "{{asset('front/assets/icon/Logo_Inatrims.png')}}" ></a>
                                            <?php
                                            }
                                            else {
                                                ?>
                                                <a target="_blank" href="http://inatrims.kemendag.go.id/"><img src = "{{asset('front/assets/icon/Logo_Inatrims.png')}}" ></a>
                                                <?php
                                            }

                                                }
                                                else {
                                                    ?>
                                                    <a target="_blank" href="http://inatrims.kemendag.go.id/"><img src = "{{asset('front/assets/icon/Logo_Inatrims.png')}}" ></a>
                                                <?php
                                                }
                                                ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100%" colspan="2"  align="center">
                                            <a target="_blank" href="http://tr.apec.org/"><img width="50%" src = "{{asset('front/assets/icon/Logo_Apec.png')}}" ></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="right"><a href="https://play.google.com/store/apps/details?id=com.maxxima.kemendagmobile" target="_BLANK"><img src="{{asset('front/assets/icon/android.svg')}}" alt="" width="100%"></a></td>
                                        <td width="50%" align="left"><a href="https://apps.apple.com/us/app/inaexport/id1497480318" target="_BLANK"><img src="{{asset('front/assets/icon/ios.svg')}}" alt="" width="100%"></a></td>
                                    </tr>
								</table>
								<br>
								<p>@lang("footer.cc") &copy; <?php echo date("Y"); ?> </p>
								
                                
                                
                                <!--<img src="{{asset('front/assets/img/logo/asian-japan-centre.png')}}" alt="" width="100%"> -->
								
                            </div>
							
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="widgets_container contact_us">
                            <div class="footer_logo" align="center">
                                <table width="100%">
                                    <tr>
                                        <td width="50%" align="right"><a href="https://play.google.com/store/apps/details?id=com.maxxima.kemendagmobile" target="_BLANK"><img src="{{asset('front/assets/icon/android.svg')}}" alt="" width="100%"></a></td>
                                        <td width="50%" align="left"><a href="https://apps.apple.com/us/app/inaexport/id1497480318" target="_BLANK"><img src="{{asset('front/assets/icon/ios.svg')}}" alt="" width="100%"></a></td>
                                    </tr>
								</table>
								<br>
                                <p>@lang("footer.cc") &copy; <?php echo date("Y"); ?> </p> 
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="footer_bottom">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="copyright_area">
                           <!-- <p>@lang("footer.cc") &copy; <?php echo date("Y"); ?> </p> -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--footer area end-->
<!-- JS
============================================ -->

    <!-- Plugins JS -->
    <!-- <script src="{{asset('front/assets/js/plugins.js')}}"></script> -->
    <!-- Main JS -->
    <script src="{{asset('front/assets/js/main.js')}}"></script>
	<script>
function closenotif(x){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("bacanotif/")}}/'+x,{_token:token},function(data){
			
		 });
}
</script>
    <script type="text/javascript">
        function ce(){
            var a = $('#lang').val();
            var url = '<?php  echo url('locale/') ?>/'+a;
            window.open(url,'myWindow');
        }
    </script>
</body>


<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:14:17 GMT -->
</html>