<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('css/login/images/icons/favicon.ico') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('css/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('css/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/css/main.css') }}">
    <!--===============================================================================================-->
    <!-- jQuery -->
    <script src="{{ url('assets') }}/libs/jquery/dist/jquery.min.js"></script>
</head>

<body style="background-color: #666666;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-more"
                    style="background-image: url('{{ asset('assets/assets/images/container.jpg') }}');">
                </div>
                <form class="login100-form validate-form" id="formlogin" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="text-center col-lg-12 mb-5">
                             <a href="{{ url('/') }}"><img src="{{ asset('front/assets/img/logo/logonew-200.png') }}"
                                style="" alt="Image" class="img-fluid"></a>
                        </div>
                    </div>
                    <span class="login100-form-title p-b-43">
                        Welcome Back! Please Login to continue
                    </span>


                    @if ($errors->has('email') || $errors->has('password'))
                        <span class="help-block">
                            <strong
                                style="font-family: 'Lato', sans-serif !important;">{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <div class="wrap-input100">
                        <input class="input100 input" type="text" name="email" value="{{ old('email') }}" required
                            autofocus>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Email</span>
                    </div>


                    <div class="wrap-input100">
                        <input class="input100 input" type="password" name="password">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>
                    <div class="container-login100-form-btn">
                        <div class="d-flex justify-content-between mt-n5"></div>
                        <div id="captcha-ex"></div>
                        <br>
                    </div>
                    <br>
                    <div class="container-login100-form-btn">
                        <input type="hidden" id="gRecaptchaResponse" name="gRecaptchaResponse">
                        <button type="button" class="g-recaptcha form-control login100-form-btn"
                            data-sitekey="{{ config('recaptcha.site_key_recaptcha_v3') }}" data-callback='onSubmit'
                            data-action='submit' style="border-radius: 5px;">@lang("login.btn")</button>
                    </div>
                    <input type="hidden" name="redirect" value="{{ Request::get('redirect') }}">
                </form>


            </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key_recaptcha_v3') }}">
    </script>

    <script type="text/javascript">
        $(function() {
            $('.input').keypress((e) => {

                // Enter key corresponds to number 13
                if (e.which === 13) {
                    $('.g-recaptcha').click();
                }
            })
        })
        $('#formlogin').submit(function() {
            // we stoped it
            event.preventDefault();
            // needs for recaptacha ready
            grecaptcha.ready(function() {
                // do request for recaptcha token
                // response is promise with passed token
                grecaptcha.execute("{{ config('recaptcha.site_key_recaptcha_v3') }}", {
                    action: 'create_comment'
                }).then(function(token) {
                    // add token to form
                    $('form').prepend('<input type="hidden" name="token" value="' + token + '">');
                    $('form').prepend('<input type="hidden" name="action" value="create_comment">');
                    // submit form now
                    $('form').unbind('submit').submit();
                });;
            });
        });

        function verifyCaptcha(result) {
            if (result !== "") {
                $('#formlogin').submit();
            } else {
                alert('please submit your captha')
            }
        }
    </script>
    <script>
        function onSubmit(token) {
            document.getElementById("formlogin").submit();
        }
    </script>

    <!--===============================================================================================-->
    <script src="{{ asset('css/login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('css/login/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('css/login/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('css/login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('css/login/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('css/login/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('css/login/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('css/login/vendor/countdowntime/countdowntime.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('css/login/js/main.js') }}"></script>

</body>

</html>
