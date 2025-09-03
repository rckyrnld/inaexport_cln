<!-- ############ Main END-->
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
</div>
<!-- Footer -->

{{-- <div class="content-footer white " id="content-footer">
    <div class="d-flex p-3">

    </div>
</div> --}}
</div>
<!-- ############ Content END-->

<!-- ############ LAYOUT END-->
</div>
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
<!-- Argon JS -->
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
{{-- <script src="{{ asset('css/dashboard/js/argon.js?v=1.2.0') }}"></script> --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if(Request::segment(2) != "chatting" && Request::segment(1) != "br_pw_chat" && Request::segment(1) != "br_chat" ){ ?>
    Pace.on("done", function() {
        $('#page_overlay').delay(300).fadeOut(600);
    });
    <?php } ?>

    function closenotif(x) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('bacanotif/') }}/' + x, {
            _token: token
        }, function(data) {

        });
    }
    $(document).ready(function() {
        $('body').on('click', '#toggle', function(event) {
            if ($('#drop').hasClass('show')) {
                $('#drop').removeClass("show");
            } else {
                $('#drop').addClass("show");
            }
            event.preventDefault();
        });
        // var url = '{{ Request::segment(1) }}';
        // var url2 = '{{ Request::segment(2) }}';
        var color = '#53A6FA';

        // if(url == 'profildoc' || url == 'profil') {
        // 	$('a[href$="/'+url+'"]').parent().parent().parent().attr('class', 'active')
        // 	$('a[href$="/'+url+'"]').parent().css('background-color', '#FFE4C4')
        // } else if (url2 == 'contact') {
        //   $('a[href$="/'+url2+'"]').parent().parent().parent().attr('class', 'active')
        // 	$('a[href$="/'+url2+'"]').parent().css('background-color', '#FFE4C4')
        // }
        // if (url2 != '') {
        //     $('a.nav-link[href$="/' + url2 + '"]:first').parent().parent().parent().attr('class', 'active nav-item nav-with-child nav-item-expanded')
        //     $('a.nav-link[href$="/' + url2 + '"]:first').parent().css('background-color', color)
        // } else if (url != '') {
        //     $('a.nav-link[href$="/' + url + '"]:first').parent().parent().parent().attr('class', 'active nav-item nav-item-expanded')
        //     $('a.nav-link[href$="/' + url + '"]:first').parent().css('background-color', color)
        // }

        var full_url = '{{ url::current() }}';
        // console.log(' Full : '+full_url);
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
            // console.log(data);
            if (data > 0) {
                $(".nav-link-text:contains('Inquiry/Buying Request')").html(
                    'Inquiry/Buying Request <span class="badge badge-danger jumlah_notif">' + data +
                    '</span>');
            }
        });
    });

    var NavWithChild = (function() {

        // Variables

        var $nav = $('.nav-item.nav-with-child');
        setTimeout(function() {
            $nav.each(function(index, each) {

                $(each).on('click', function(event) {
                    if ($(each).is('.nav-item-expanded')) {
                        $(each).removeClass('nav-item-expanded')

                    } else {
                        $(each).addClass('nav-item-expanded')
                    }
                })
            });
        }, 300)

    })();
</script>

<!-- ############ SWITHCHER START-->
<!--
<div id="setting">
  <div class="setting dark-white rounded-bottom" id="theme">
    <a href="#" data-toggle-class="active" data-target="#theme" class="dark-white toggle">
      <i class="fa fa-gear text-primary fa-spin"></i>
    </a>
    <div class="box-header">
      <a href="https://themeforest.net/item/apply-web-application-admin-template/21072584?ref=flatfull" class="btn btn-xs rounded danger float-right">BUY</a>
      <strong>Theme Switcher</strong>
    </div>
    <div class="box-divider"></div>
    <div class="box-body">
      <p id="settingLayout">
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedAside">
          <i></i>
          <span>Fixed Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedContent">
          <i></i>
          <span>Fixed Content</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="folded">
          <i></i>
          <span>Folded Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="container">
          <i></i>
          <span>Boxed Layout</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="ajax">
          <i></i>
          <span>Ajax load page</span>
        </label>
        <label class="pointer my-1 d-block" data-toggle="fullscreen" data-plugin="screenfull" data-target="fullscreen">
          <span class="ml-1 mr-2 auto">
            <i class="fa fa-expand d-inline"></i>
            <i class="fa fa-compress d-none"></i>
          </span>
          <span>Fullscreen mode</span>
        </label>
      </p>
    
      <div class="row no-gutters">
        <div class="col">
          <p>Brand</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="brand" value="dark-white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="brand" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col mx-2">
          <p>Aside</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="aside" value="white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="aside" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col">
          <p>Themes</p>
          <div class="clearfix">
            <label class="radio radio-inline ui-check">
              <input type="radio" name="bg" value="">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline ui-check ui-check-color">
              <input type="radio" name="bg" value="dark">
              <i class="dark"></i>
            </label>
          </div>
        </div>
      </div>
      
      
    </div>
  </div>
</div>
-->
<!-- ############ SWITHCHER END-->


</body>

</html>
