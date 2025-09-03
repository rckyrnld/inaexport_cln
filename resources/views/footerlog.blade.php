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
<!--
    <section class="call_to_action">
        <div class="container">
            <div class="row counters">

                <div class="col-lg-4 col-6 text-center">
                    <ul class="list-group list-group-horizontal-sm justify-content-center">
                        <li>
                            <img src="{{asset('front/assets/img/exporters.png')}}" alt="" style="width: 20%;">
                            <span class="counters_number">{{getCountData('itdp_company_users')}}</span>
                        </li>
                         <li style="padding-left: 20%;">
                            <p class="counters_text" style="font-size: 18px;">
							
                                @if($loc == 'ch')
                                出口商
                                @elseif($loc == 'in')
                                Eksportir
                                @else
                                Exporters
                                @endif 
                            </p>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <ul class="list-group list-group-horizontal-sm justify-content-center">
                        <li>
                            <img src="{{asset('front/assets/img/events.png')}}" alt="" style="width: 20%;">
                            <span class="counters_number">{{getCountData('event_detail')}}</span>
                        </li>
                        <li style="padding-left: 20%;">
                            <p class="counters_text" style="font-size: 18px;">
                                @if($loc == 'ch')
                                事件
                                @elseif($loc == 'in')
                                Acara
                                @else
                                Events
                                @endif
                            </p>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <ul class="list-group list-group-horizontal-sm justify-content-center">
                        <li>
                            <img src="{{asset('front/assets/img/products.png')}}" alt="" style="width: 20%;">
                            <span class="counters_number">{{getCountData('csc_product_single')}}</span>
                        </li>
                        <li style="padding-left: 20%;">
                            <p class="counters_text" style="font-size: 18px;">@lang('frontend.home.product')</p>
                        </li>
                    </ul>
                </div>
    
            </div>
        </div>
    </section>
	-->

<!--footer area start-->
<footer class="footer_widgets mt-50">
<!--
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
                                                <td width="5%"><img src="{{asset('front/assets/icon/icon_lokasi.png')}}"></td>
                                                <td class="footer-child" style="padding-left: 5px;">Jl. M.I. Ridwan Rais No.5, RT.7/RW.1, Gambir, Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110, Indonesia</td>
                                            </tr>
                                            <tr>
                                                <td><img src="{{asset('front/assets/icon/icon_phone.png')}}"></td>
                                                <td class="footer-child" style="padding-left: 5px;">+62 21 385 8171</td>
                                            </tr>
                                            <tr>
                                                <td><img src="{{asset('front/assets/icon/icon_idk.png')}}"></td>
                                                <td class="footer-child" style="padding-left: 5px;">+62 21 385 8171</td>
                                            </tr>
                                            <tr>
                                                <td><img src="{{asset('front/assets/icon/icon_email.png')}}"></td>
                                                <td class="footer-child" style="padding-left: 5px;">csm@kemendag.go.id</td>
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
                                    <li><a href="#" class="third-child">DGNED CSC</a></li>
                                    <li><a href="#" class="third-child">@lang("footer.foot.trade-expo")</a></li>
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
                    <div class="col-lg-3 col-md-6">
                        <div class="widgets_container contact_us">
                            <div class="footer_logo" align="center">
                                <img src="{{asset('front/assets/img/logo/inatrade.png')}}" alt="" width="100%">
                                <img src="{{asset('front/assets/img/logo/asian-japan-centre.png')}}" alt="" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="copyright_area">
                            <p>@lang("footer.cc") &copy; <?php echo date("Y"); ?> </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                    </div>
                </div>
            </div>
        </div>
		-->
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
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', layout:google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
        }
        function ce(){
            var a = $('#lang').val();
            var url = '<?php  echo url('locale/') ?>/'+a;
            window.open(url,'myWindow');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


</body>


<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:14:17 GMT -->
</html>