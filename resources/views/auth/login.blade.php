<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">


<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:13:46 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Inaexport | Inaexport</title>
    <meta name="description" content="">
    <meta name="title" content="InaExport">
    <meta name="description"
        content="InaExport as a media product digital promotion superior export products from Indonesian business people, so they can more easily reach out to foreign buyers.">
    <meta name="keywords"
        content="inaexport, exporter, importer, buying request, inquiry, kemendag, trade, promotion, products, business, indonesia">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('front/assets/img/logo/kemendag.png') }}">

    <!-- CSS 
    ========================= -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('assets') }}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />

    <!-- build:css ../assets/css/app.min.css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}">
    <!-- jQuery -->
    <script src="{{ url('assets') }}/libs/jquery/dist/jquery.min.js"></script>
    <style>
        .f-text {
            font-size: 14px;
        }

        .flat {
            border-radius: 0px;
        }

        .td-none {
            text-decoration: none;
        }

        a {
            color: #306ba1;
        }

        a:hover {
            color: #6ca130;
        }

        /* .container .row {
            background-image: url('./assets/assets/versi 1/bg innaexport4.png') !important;
            background-size: cover;
            position: relative;
            display: flex;
            height: 100vh;
            right: 8vh;
        } */

        .login-form {
            background-color: #fff;
            height: 47vh;
            width: 43vh;
            border-radius: 5px;
            /* position: absolute; */
            /* top: 18vh; */
            /* left: 120vh; */
            right: 0vh;
            bottom: 0;
            box-shadow: 3px 3px 20px #D5BFBF;
            padding: 18px;
        }

        .container {
            width: 100% !important;
            padding-right: 15px !important;
            padding-left: 15px !important;
            margin-right: auto !important;
            margin-left: auto !important;
        }

        .content {
            padding: 3rem 0 !important;
            width: 450px;
        }

        @media (min-width: 768px) {
            .order-md-2 {
                -webkit-box-ordinal-group: 3;
                -ms-flex-order: 2;
                order: 2;
            }

        }

        @media (min-width: 768px) {
            .col-md-6 {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%;
            }

        }

        .col-md-6 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        img {
            vertical-align: middle !important;
            border-style: none !important;
        }

        .content .contents,
        .content .bg {
            width: 100% !important;
        }

        @media (min-width: 768px) {
            .col-md-6 {
                -webkit-box-flex: 0 !important;
                -ms-flex: 0 0 50% !important;
                flex: 0 0 50% !important;
                max-width: 50% !important;
            }

        }

        .row {
            display: -webkit-box !important;
            display: -ms-flexbox !important;
            display: flex !important;
            -ms-flex-wrap: wrap !important;
            flex-wrap: wrap !important;
            margin-right: -15px !important;
            margin-left: -15px !important;
        }

        .justify-content-center {
            -webkit-box-pack: center !important;
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }

        .col-md-8 {
                {
                position: relative;
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
            }
        }

        .container-login::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(255, 255, 255, .9);
        }

        .container-login {
            background: url('{{ asset('assets/assets/versi 1/bg innaexport4.png') }}');
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 50px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            z-index: 1;

        }
    </style>

</head>

<body class="container-login">
    <!-- login start -->
    {{-- <section>
        <div class="mt-5">
            <a href="{{ url('/') }}"><img src="{{ asset('front/assets/img/logo/logonew-200.png') }}"
                    class="mx-auto d-block" alt="Logo Inaexport"></a>
            <p class="text-center f-text pt-2">Sign in to Inaexport or <a href="{{ url('createnewaccount') }}">create
                    an
                    account</a></p>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 order-md-2">
                            <img src="{{ asset('assets/assets/versi 1/bg innaexport4.png') }}" alt="Image"
                                class="img-fluid">
                        </div>
                        <div class="col-md-6 contents">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="login-form">
                                        <form class="form-horizontal" id="formlogin" method="POST"
                                            action="{{ route('loginei.login') }}">
                                            {{ csrf_field() }}
                                            <br>
                                            <div class="mb-3">
                                                <label for="txtemail"
                                                    class="form-label text-center">@lang("login.forms.email")</label>
                                                <input type="email" class="form-control flat input" name="email2"
                                                    id="txtemail"
                                                    style="border-radius: 5px; background-color: #E4E4E4;">
                                                @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong style="color: red; font-weight: lighter;">{{
                                                        $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtpassword" class="form-label"
                                                    stye="justify-content: center;">@lang("login.forms.password")</label>
                                                <input type="password" class="form-control flat input" name="password2"
                                                    id="txtpassword"
                                                    style="border-radius: 5px; background-color: #E4E4E4;">
                                                @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <input type="hidden" id="gRecaptchaResponse" name="gRecaptchaResponse">
                                            <button type="button" class="g-recaptcha form-control btn btn-success"
                                                data-sitekey="{{ config('recaptcha.site_key_recaptcha_v3') }}"
                                                data-callback='onSubmit' data-action='submit'
                                                style="border-radius: 5px;">@lang("login.btn")</button>
                                            <p class="text-start mt-2"><a href="{{ url('forget_a') }}"
                                                    class="td-none">@lang("login.forms.fp") ?</a>
                                            <p>
                                        </form>
                                        <hr>
                                        <p class="text-center" style="font-size:12px;">Copyright © 2019-2021
                                            Inaexport. All
                                            rights
                                            reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> --}}
    <div class="content">
        <div class="container">
            <div class="row">
                {{-- <div class="col-md-6 order-md-2 my-auto">
                    <img src="{{ asset('assets/assets/versi 1/bg innaexport4.png') }}" style="object-position: 60px;"
                        alt="Image" class="img-fluid">
                </div> --}}
                <div class="col-lg-12 contents">
                    <div class="row justify-content-end">
                        <div class="">
                            <div class="mb-4" style="width: 43vh;">
                                <a href="{{ url('/') }}"><img src="{{ asset('front/assets/img/logo/logonew-200.png') }}"
                                        class="mx-auto d-block" alt="Logo Inaexport" style="margin-top: -4rem"></a>
                                <p class="text-center f-text pt-2">Sign in to Inaexport or <a
                                        href="{{ url('createnewaccount') }}">create
                                        an
                                        account</a></p>

                            </div>
                            <div class="login-form">

                                <form class="form-horizontal" id="formlogin" method="POST"
                                    action="{{ route('loginei.login') }}">
                                    {{ csrf_field() }}
                                    <br>
                                    <div class="mb-3">
                                        <label for="txtemail"
                                            class="form-label text-center">@lang("login.forms.email")</label>
                                        <input type="email" class="form-control flat input" name="email2" id="txtemail"
                                            style="border-radius: 5px; background-color: #E4E4E4;">
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong style="color: red; font-weight: lighter;">{{ $errors->first('email')
                                                }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtpassword" class="form-label"
                                            stye="justify-content: center;">@lang("login.forms.password")</label>
                                        <input type="password" class="form-control flat input" name="password2"
                                            id="txtpassword" style="border-radius: 5px; background-color: #E4E4E4;">
                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <input type="hidden" id="gRecaptchaResponse" name="gRecaptchaResponse">
                                    <button type="button" class="g-recaptcha form-control btn btn-success"
                                        data-sitekey="{{ config('recaptcha.site_key_recaptcha_v3') }}"
                                        data-callback='onSubmit' data-action='submit'
                                        style="border-radius: 5px;">@lang("login.btn")</button>
                                    <p class="text-start mt-2"><a href="{{ url('forget_a') }}"
                                            class="td-none">@lang("login.forms.fp") ?</a>
                                    <p>
                                        <input type="hidden" name="redirect" value="{{ Request::get('redirect') }}">
                                </form>
                                <hr>
                                <p class="text-center" style="font-size:12px;">Copyright © 2019-2021
                                    Inaexport. All
                                    rights
                                    reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--login end -->
</body>

</html>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key_recaptcha_v3') }}">
</script>

<script type="text/javascript">
    $(function() {
        $('.input').keypress((e) => {

            // Enter key corresponds to number 13
            if (e.which === 13) {
                $('.input').submit();
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

</script>
<script>
    function check() {
        email2 = $('#email2').val();
        password2 = $('#password2').val();
        if (!isEmptyM(email2) && !isEmptyM(password2)) {
            $.post("{{ route('login.check_status') }}", {
                '_token': '{{ csrf_token() }}',
                'email2': email2,
                // 'password2': password2,
            }, function(response) {
                var res = JSON.parse(response);
                //console.log(res);
                if (res == 'status2') {
                    var r = confirm("Aktivasi Akun Anda?");
                    // var status = 0;
                    // $('#status').val(0);
                    if (r == true) {
                        $.post("{{ route('login.change_status') }}", {
                            '_token': '{{ csrf_token() }}',
                            'email': email2,
                        }, function(response) {

                        });
                        document.getElementById("formlogin").submit();
                    }
                } else if (res == 'status0') {
                    alert('wait for admin to verified your account first')
                }
                // else if(res == 'statusoke'){
                //     // $('#status').val(1);
                //     console.log('testing');
                //     document.getElementById("formlogin").submit();
                // }
                else {
                    document.getElementById("formlogin").submit();
                }
            });
        } else {
            alert('please fill the email and password field first');
        }

    }

    function isEmptyM(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }
</script>