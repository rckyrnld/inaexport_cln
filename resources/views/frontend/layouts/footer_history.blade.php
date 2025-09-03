<footer class="footer my-auto">
    <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6 pl-4">
            <div class="copyright text-center  text-lg-left  text-muted pl-4">
                &copy; 2021 <a href="#" class="font-weight-bold ml-1" target="_blank">Inaexport</a>
            </div>
        </div>
        {{-- <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                    <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                    <a href="https://www.creative-tim.com/presentation" class="nav-link"
                        target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md"
                        class="nav-link" target="_blank">MIT License</a>
                </li>
            </ul>
        </div> --}}
    </div>
</footer>
<!--shipping area start-->
<!-- <section class="shipping_area" style="background-color: #ddeffd;">
        <div class="container">
            <div class=" row">
                <div class="col-12">
                    <div class="shipping_inner">
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{ asset('front/assets/img/perlindungan_konsumen.png') }}" alt="">
                                <h2>Perlindungan Konsumen</h2>
                                <p>Jaminan perlindungan keamanan kepada konsumen & supplier</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{ asset('front/assets/img/pengiriman.png') }}" alt="">
                                <h2>Jaminan Pengiriman</h2>
                                <p>Uang dikembalikan 100% jika barang tidak dikirimkan</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{ asset('front/assets/img/pembayaran.png') }}" alt="">
                                <h2>Pembayaran Aman</h2>
                                <p>Pilihan metode pembayaran yang beragam, cepat dan aman</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{ asset('front/assets/img/respon.png') }}" alt="">
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
<!-- Argon Scripts -->
<!-- Core -->
{{-- <script src="{{ asset('css/dashboard/vendor/jquery/dist/jquery.min.js') }}"></script> --}}
{{-- <script src="{{ asset('css/dashboard/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script> --}}
<script src="{{ asset('css/dashboard/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('css/dashboard/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('css/dashboard/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
<!-- Optional JS -->
{{-- <script src="{{ asset('css/dashboard/vendor/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('css/dashboard/vendor/chart.js/dist/Chart.extension.js') }}"></script> --}}
<script>
    $('.sidenav-toggler').click(function() {
        $("body").toggleClass("nav-open");
    })


    $(function() {
         setTimeout(function(){
             $("#toggle").on('click', function(event) {
                $('#drop').toggleClass('show')
             }); 
        }, 500);
    })
</script>
<!-- Argon JS -->
{{-- <script src="{{ asset('css/dashboard/js/argon.js?v=1.2.0') }}"></script> --}}
<style type="text/css">
    .footer-child {
        font-size: 14px;
        color: grey;
        line-height: 20px;
    }

    .third-child {
        font-size: 14px;
        color: grey;
    }

    .third-child:hover,
    .third-child:active {
        text-decoration: none;
    }

    .small {
        width: 200% !important;
    }

</style>
<?php
$loc = app()->getLocale();
if (empty($loc)) {
    $loc = 'en';
}
?>

<!--footer area start-->

<!--footer area end-->
<!-- JS
    ============================================ -->

<!-- Plugins JS -->
<!-- <script src="{{ asset('front/assets/js/plugins.js') }}"></script> -->
<!-- Main JS -->
<script src="{{ asset('front/assets/js/main.js') }}"></script>
<script>
    function closenotif(x) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('bacanotif/') }}/' + x, {
            _token: token
        }, function(data) {

        });
    }
    $(document).ready(function() {
        var color = '#53A6FA';
        var full_url = '{{ url::current() }}';
        console.log(' Full : ' + full_url);
        if ($('a.nav-link[href="' + full_url + '"]:first').parent().parent().parent().attr('class') !=
            'nav-with-child') {
            $('a.nav-link[href="' + full_url + '"]:first').parent().parent().parent().attr('class',
                'active nav-item nav-with-child nav-item-expanded')
            $('a.nav-link[href="' + full_url + '"]:first').parent().css('background-color', color)
        } else {
            $('a.nav-link[href="' + full_url + '"]:first').parent().parent().parent().attr('class',
                'active nav-item nav-with-child nav-item-expanded')
            $('a.nav-link[href="' + full_url + '"]:first').parent().css('background-color', color)
        }

        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('inquiry/countdata') }}', {
            _token: token
        }, function(data) {
            console.log(data);
            if (data > 0) {
                $(".nav-link-text:contains('History Inquiry')").html('History Inquiry (' + data + ')');
            }
        });
    });
</script>
<script type="text/javascript">
    function ce() {
        var a = $('#lang').val();
        var url = '<?php echo url('locale/'); ?>/' + a;
        window.open(url, 'myWindow');
    }
</script>
</body>


<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:14:17 GMT -->

</html>
