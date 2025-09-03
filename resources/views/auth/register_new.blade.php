@include('headerlog')
<link href="{{ asset('') }}/js/tagsinput.css" rel="stylesheet" type="text/css">
<style>
    .badge {
        font-size: 95% !important;
    }

    .form-control {
        font-size: 13px;
        border-radius: 0px;
    }

    #content-bodys {
        font-family: 'Lato', sans-serif !important;
    }
    .loader {
        position: fixed;
        left: 50%;
        top: 50%;
        z-index: 2;
        width: 120px;
        height: 120px;
        margin: -76px 0 0 -76px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    .select2{
        width:100%!important;
    }

    .grey_loading {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: grey;
        z-index: 1;
        opacity: 0.5;
    }
    @keyframes spin {
        from {
          transform: rotate(0deg);
        }
        to {
          transform: rotate(360deg);
        }
      }
</style>

<div id='grey_loading' class="grey_loading" style="display: none;"></div>
<div id='loader' class="loader" style="display: none;"></div>


<div id="content-bodys" class="product_area" style="color: black">
    <div class="py-1 w-100">
        <div class="text-center pt-4 pb-4">
            <h3><b>@lang("login.title3")</b></h3>
            <h6>@lang("login.title5") <a href="{{ url('login') }}">@lang("login.btn")</a></h6>
        </div>
        <div class="mx-auto col-lg-6" style="background: white; border-radius: 0px;">
            <br>
            <div class="wrap-login100" style="padding-left : 40px; padding-right : 40px; font-size:14px;">
                <form class="form-horizontal" method="POST" action="{{ url('simpan_rpenjual') }}" id="formRegister">
                    {{ csrf_field() }}
                    <p><h6>Account Information</h6></p>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label>
                                <font color="red">*</font> @lang("login.forms.type")
                            </label>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <input type="radio" name="acc_type" value="seller" id="seller" @if(isset($_GET['reg'])) @if($_GET['reg'] == 'exporter') checked @endif @else checked @endif>
                            <label for="seller"> Supplier
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="acc_type" value="buyer" id="buyer" @if(isset($_GET['reg'])) @if($_GET['reg'] == 'buyer') checked @endif @endif>
                            <label for="buyer"> Buyer
                        </div>
                    </div>
                    <!-- @include('auth.register.penjual') -->

                    <div id="form_penjual" style="display: block;">
                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("login.forms.prov")
                                </label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <select class="form-control select2" name="prov" id="prov_seller">
                                    <option value="">- Choose Provinsi -</option>
                                    <?php
                                    $qc = DB::select("select id,province_en from mst_province order by province_en asc");
                                    foreach($qc as $cq){
                                    ?>
                                    <option value="<?php echo $cq->id; ?>"><?php echo $cq->province_en; ?></option>

                                    <?php } ?>
                                </select>
                            </div>


                        </div>
                        <!-- <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label><font color="red">*</font> @lang("login.forms.city")</label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="city" id="city_seller" class="form-control" style=" color: black; ">
                            </div>


                        </div> -->
                        <!-- <div class="form-row">

                                            <div class="form-group col-sm-4" align="left">
                                                <label>&nbsp; Account Type</label>
                                            </div>
                                            <div class="form-group col-sm-5" align="left">
                                                <input type="radio" name="Supplier" checked> Supplier &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="Buyer" disabled> Buyer

                                            </div>
                                        </div> -->
                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register2.forms.email")
                                </label>
                                &nbsp;&nbsp;&nbsp;<span id="cekmail_seller"></span>

                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" onblur="cekmail_seller()" name="email" id="email_seller"
                                    class="form-control" style=" color: black; " required>
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register2.forms.password")
                                </label>

                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="password" name="password" id="password_seller" class="form-control"
                                    style=" color: black; " required>
                                <input type="checkbox" onclick="lihatpass()" >&nbsp;Show Password
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register.forms.re-password")
                                </label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="password" name="kpassword" id="kpassword_seller" class="form-control"
                                    style=" color: black; ">
                                <input type="checkbox" onclick="lihatpassulang()" >&nbsp;Show Password
                            </div>


                        </div>


                        <br>
                        <p>
                        <h6>Business Information</h6>
                        </p>
                        <hr>


                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register2.forms.company")
                                </label>


                            </div>
                            <div class="form-group col-sm-2" align="left">
                                <input type="text" id="nama_badan" style="display: none;" name="nama_badan">
                                <select id="badanusaha_seller" name="badanusaha" class="form-control" required>
                                    <option>-</option>
                                    <?php
                                                                $bns = DB::select("select * from eks_business_entity");
                                                                foreach($bns as $val){
                                                                ?>
                                    <option value="<?php echo $val->id; ?>"><?php echo $val->nmbadanusaha; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-6" align="left">
                                <input style="text-transform:uppercase" type="text" name="company" id="company_seller"
                                    class="form-control" style=" color: black; " required>
                            </div>


                        </div>
                        <!-- <div class="form-row">

                            <div class="form-group col-sm-4" align="left">
                                <label> &nbsp;Product Interest </label>

                            </div>

                            <div class="form-group col-sm-8" align="left">
                                <input type="text" data-role="tagsinput" class="form-control" value="">
                            </div>
                        </div> -->
                        {{-- <div class="form-row"> --}}
                        {{-- <div class="form-group col-sm-4" align="left"> --}}
                        {{-- <label><font color="red">*</font> @lang("register2.forms.username")</label> --}}
                        {{-- </div> --}}
                        {{-- <div class="form-group col-sm-8" align="left"> --}}
                        {{-- <input type="text" name="username" id="username_seller" class="form-control" --}}
                        {{-- style=" color: black; " required> --}}
                        {{-- </div> --}}
                        {{-- </div> --}}
                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> PIC (Name)
                                </label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="pic" id="pic_seller" class="form-control"
                                    style=" color: black; ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register2.forms.phone")
                                </label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" value="+62" class="form-control" disabled
                                            style="padding: .105rem .20rem; ">
                                    </div>
                                    <div class="col-md-10"><input type="text" name="phone" id="phone_seller"
                                            class="form-control " style=" color: black;"></div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10"><span><label style="font-size: 12px;">Contoh : 87780733154</label></span></div>
                                </div> -->
                            </div>
                        </div>

                        <!-- <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>@lang("register2.forms.fax")</label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" value="+62" disabled  style="padding: .105rem .20rem; " >
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="fax" id="fax_seller" class="form-control" style=" color: black;">
                                    </div>
                                </div> -->
                        <!-- <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10"><span><label style="font-size: 12px;">Contoh : 8342</label></span></div>
                                </div> -->
                        <!-- </div>
                        </div> -->
                        <!-- <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>@lang("register2.forms.website")</label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="website" id="website_seller" onkeyup="cekwebsite()" class="form-control" style=" color: black; ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>@lang("register.forms.postcode")</label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="postcode" id="postcode_seller" class="form-control"
                                    style=" color: black; ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label>@lang("register.forms.address")</label>

                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <textarea name="alamat" id="alamat_seller" class="form-control" style=" color: black; "></textarea>
                            </div>


                        </div> -->
                    </div>
                    <div id="form_pembeli" style="display: block;">
                        <div class="form-row">

                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("login.forms.ct")
                                </label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <select class="form-control select2" name="country" id="country">
                                    <option value="">- Choose Country -</option>
                                    <?php
                                    $qc = DB::select("select id,country from mst_country where Upper(country) != 'INDONESIA' order by country asc");
                                    foreach($qc as $cq){
                                    ?>
                                    <option value="<?php echo $cq->id; ?>"><?php echo $cq->country; ?></option>

                                    <?php } ?>
                                </select>
                            </div>
                            
                        </div>
                        <!-- <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label><font color="red">*</font> @lang("login.forms.city")</label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="city" id="city" class="form-control" style=" color: black; ">
                            </div>


                        </div> -->
                        <!-- <div class="form-row">

                                            <div class="form-group col-sm-4" align="left">
                                                <label>&nbsp; Account Type</label>
                                            </div>
                                            <div class="form-group col-sm-5" align="left">
                                                <input type="radio" name="Supplier" disabled> Supplier &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="Buyer" checked> Buyer

                                            </div>
                                        </div> -->

                        <div class="form-row">

                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register.forms.email")
                                </label>&nbsp;&nbsp;&nbsp;<span id="cekmail"></span>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="email" id="email" class="form-control"
                                    style=" color: black; " required onblur="cekmail()">

                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register.forms.password")
                                </label>

                            </div>

                            <div class="form-group col-sm-8" align="left">
                                <input type="password" name="password" id="password" class="form-control"
                                    style=" color: black; " required>
                                <input type="checkbox" onclick="lihatpassBuyer()" >&nbsp;Show Password
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register.forms.re-password")
                                </label>

                            </div>

                            <div class="form-group col-sm-8" align="left">
                                <input type="password" name="kpassword" id="kpassword" class="form-control"
                                    style=" color: black; ">
                                <input type="checkbox" onclick="lihatpassulangBuyer()" >&nbsp;Show Password
                            </div>

                        </div>


                        <br>
                        <p>
                        <h6>Business Information</h6>
                        </p>
                        <hr>

                        <div class="form-row">

                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register.forms.company")
                                </label>

                            </div>


                            <div class="form-group col-sm-8" align="left">
                                <input style="text-transform:uppercase" type="text" name="company" id="company"
                                    class="form-control" style=" color: black; " required>

                            </div>

                        </div>
                        <!--<div class="form-row">

                            <div class="form-group col-sm-4" align="left">
                                <label> &nbsp;Product Interest </label>

                            </div>

                            <div class="form-group col-sm-8" align="left">
                                <input type="hidden" data-role="tagsinput" class="form-control" value="">

                            </div>

                        </div> -->
                        <div class="form-row">

                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font>@lang("register.forms.username")
                                </label>

                            </div>

                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="username" id="username" class="form-control"
                                    style=" color: black; " required>
                            </div>

                        </div>


                        <div class="form-row">


                            <div class="form-group col-sm-4" align="left">
                                <label>
                                    <font color="red">*</font> @lang("register.forms.phone")
                                </label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="phone" id="phone" class="form-control"
                                    style=" color: black; ">
                            </div>
                        </div>
                        {{-- <div class="form-row">


                            <div class="form-group col-sm-4" align="left">
                                <label>&nbsp;@lang("register.forms.fax")</label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="fax" id="fax" class="form-control" style=" color: black; ">
                            </div>
                        </div>
                        <div class="form-row">


                            <div class="form-group col-sm-4" align="left">
                                <label>&nbsp;@lang("register.forms.website")</label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="website" id="website" onkeyup="cekwebsite()" class="form-control" style=" color: black; ">
                            </div>
                        </div>

                        <div class="form-row">


                            <div class="form-group col-sm-4" align="left">
                                <label>&nbsp;@lang("register.forms.postcode")</label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <input type="text" name="postcode" id="postcode" class="form-control"
                                    style=" color: black; ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-4" align="left">
                                <label><font color="red">*</font> @lang("register.forms.address")</label>
                            </div>
                            <div class="form-group col-sm-8" align="left">
                                <textarea name="alamat" id="alamat" class="form-control" style=" color: black; "></textarea>
                            </div>
                        </div> --}}
                        {{-- <div class="form-row"> --}}
                        {{-- <div class="form-group col-sm-4" align="left"> --}}
                        {{-- <label><font color="red">*</font> Verification Code</label> --}}
                        {{-- </div> --}}
                        {{-- <div class="form-group col-sm-2" align="left"> --}}
                        {{-- <img style="height:20px!Important;" src="{{url('assets')}}/assets/images/captcha.jfif" --}}
                        {{-- alt="."> --}}
                        {{-- </div> --}}
                        {{-- <div class="form-group col-sm-4" align="left"> --}}
                        {{-- <input type="text" class="form-control" name="chp" id="chp"> --}}
                        {{-- </div> --}}
                        {{-- </div> --}}
                    </div>
                    <div class="form-row">
                        <div class="d-flex justify-content-between mt-n5"></div>
                        <div id="captcha-ex"></div>
                        <br>
                    </div>
                    <div class="form-row" align="left">
                        <div class="form-group col-sm-12"><br>
                            <p>By creating an account, you agree to the Term & Condition and have read and understood
                                the Privacy Policy. </p>
                            <a id="submit_btn" onclick="simpanpenjual(grecaptcha.getResponse(widget))" class="btn btn-danger">
                                <font color="white">&nbsp;&nbsp;&nbsp;@lang("register.submit")
                                    &nbsp;&nbsp;&nbsp;</font>
                            </a>
                            <br><br><br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('auth.register.modal')

<script src="{{ asset('') }}/js/tagsinput.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        var radios = document.getElementsByName('acc_type');
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                if (radios[i].value == 'buyer') {
                    $('#formRegister').attr('action', '{{ url('simpan_rpembeli') }}');
                    $('#form_penjual').hide();
                    $('#form_pembeli').show();
                    $('#submit_btn').attr('onclick', 'simpanpembeli(grecaptcha.getResponse(widget))');
                } else if (radios[i].value == 'seller') {
                    $('#formRegister').attr('action', '{{ url('simpan_rpenjual') }}');
                    $('#form_penjual').show();
                    $('#form_pembeli').hide();
                    $('#submit_btn').attr('onclick', 'simpanpenjual(grecaptcha.getResponse(widget))');
                }
            }
        }

    });
    function lihatpass() {
        var x = document.getElementById("password_seller");
        if (x.type == "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function lihatpassulang() {
        var x = document.getElementById("kpassword_seller");
        if (x.type == "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }function lihatpassBuyer() {
        var x = document.getElementById("password");
        if (x.type == "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function lihatpassulangBuyer() {
        var x = document.getElementById("kpassword");
        if (x.type == "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    $("#badanusaha_seller").change(function() {
        var get_namaPt = $(this).find("option:selected").text();
        console.log(get_namaPt)
        $("#nama_badan").val(get_namaPt)
    });
</script>
<script type="text/javascript">
    $('#refresh').click(function() {
        refresh()
    });

    function refresh() {
        $.ajax({
            type: 'GET',
            url: 'refreshcaptcha',
            success: function(data) {
                console.log(data);
                $(".captcha span").html(data);
            }
        });
    }

    function cekmail() {
        var m = $('#email').val();
        var carikoma = m.search(",");
        if (carikoma != "-1") {
            $('#email').val("");
        }
        var carispa = m.search(" ");
        if (carispa != "-1") {
            $('#email').val("");
        }
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('cekmail/') }}/' + m, {
            _token: token
        }, function(data) {
            if (data == 0) {
                $('#cekmail').html("<font color='green'>(Available)</font>");

            } else {
                $('#cekmail').html("<font color='red'>(Already used)</font>");
                $('#email').val("");
                alert("The email has been used. Try another one");
            }


        })
        //alert(m);
        //$('#cekmail').html("<font color='red'>( Has Been Used ! )</font>");
    }

    function cekmail_seller() {
        var m = $('#email_seller').val();
        var carikoma = m.search(",");
        if (carikoma != "-1") {
            $('#email_seller').val("");
        }
        var carispa = m.search(" ");
        if (carispa != "-1") {
            $('#email_seller').val("");
        }
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('cekmail/') }}/' + m, {
            _token: token
        }, function(data) {
            if (data == 0) {
                $('#cekmail_seller').html("<font color='green'>(Available)</font>");

            } else {
                $('#cekmail_seller').html("<font color='red'>(Already used)</font>");
                $('#email_seller').val("");
                alert("The email has been used. Try another one");
            }


        })
        // alert(m);
        // $('#cekmail').html("<font color='red'>( Has Been Used ! )</font>");
    }

    function cekwebsite() {
        var m = $('#website').val();
        var carikoma = m.search(",");
        if (carikoma != "-1") {
            $('#website').val("");
        }
        var carispa = m.search(" ");
        if (carispa != "-1") {
            $('#email').val("");
        }
    }

    var verifyCallback = function(response) {
            alert(response);
        }
        var widget;
        var widget2;
        var widget3;
        var onloadCallback = function() {
            widget = grecaptcha.render('captcha-ex', {
                'sitekey': "{{config('recaptcha.site_key_recaptcha')}}",
                'theme': 'light'
            });
        }

    function simpanpenjual(result) {
        var nama_badan = $('#nama_badan').val();
        var badanusaha = $('#badanusaha_seller').val();
        var company = $('#company_seller').val();
        // var username = $('#username').val();
        var email = $('#email_seller').val();
        var phone = $('#phone_seller').val();
        var fax = $('#fax_seller').val();
        var website = $('#website_seller').val();
        var password = $('#password_seller').val();
        var kpassword = $('#kpassword_seller').val();
        var city = $('#city_seller').val();
        var country = $('#country_seller').val();
        var postcode = $('#postcode_seller').val();
        var alamat = $('#alamat_seller').val();
        var captcha = $('#captchainput').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        if (result !== "") {
                // console.log("submit");
                // $('#formRegister').submit();
                simpanpenjual2();
            } else {
                // Swal.fire({
                //     icon: 'error',
                //     text: 'Harap isi Captcha terlebih dahulu!',
                //     showConfirmButton: true,
                // });
                alert('please submit your captha')
            }
    }

    function simpanpenjual2() {
        var nama_badan = $('#nama_badan').val();
        var badanusaha = $('#badanusaha_seller').val();
        var company = $('#company_seller').val();
        // var username = $('#username').val();
        var email = $('#email_seller').val();
        var phone = $('#phone_seller').val();
        var fax = $('#fax_seller').val();
        var website = $('#website_seller').val();
        var password = $('#password_seller').val();
        var kpassword = $('#kpassword_seller').val();
        var city = $('#city_seller').val();
        var prov = $('#prov_seller').val();
        var postcode = $('#postcode_seller').val();
        var alamat = $('textarea#alamat_seller').val();
        var chp = $('#chp').val();
        var pic = $('#pic_seller').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        if ($("#ckk2").prop('checked') == true) {
            var ckk2send = 1;
        } else {
            var ckk2send = 0;
        }
        if ($("#ckk").prop('checked') == true) {
            var ckksend = 1;
        } else {
            var ckksend = 0;
        }

        // console.log(company);
        // console.log(username);
        // console.log(email);
        // console.log(phone);
        // console.log(password);
        // console.log(prov);
        // console.log(city);
        // console.log(alamat);
        // console.log(chp);

        // console.log("end");

        // console.log(fax);
        // console.log(website);
        //
        // console.log(kpassword);
        //
        //
        // console.log(postcode);


        if (password == kpassword) {
            // if (company == "" || username == "" || email == "" || phone == "" || password == "" || city == "" || prov == "" || chp == "") {
            if (company == "" || email == "" || phone == "" || password == "" || city == "" || prov == "" || chp ==
                "") {
                alert("Please complete the field !")
                refresh();
                $('#captchainput').val('');
            } else {
                /*
                $.post('{{ url('/simpan_rpenjual') }}',{company:company,username:username,email:email,phone:phone,fax:fax,password:password,city:city,prov:prov,postcode:postcode,alamat:alamat,_token:token},function (data) {

		 });
		*/
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                    $.ajax({
                        type: "POST",
                        url: '{{ url('/simpan_rpenjual') }}',
                        data: {
                            nama_badan:nama_badan,
                            badanusaha: badanusaha,
                            company: company,
                            pic: pic,
                            email: email,
                            website: website,
                            phone: phone,
                            fax: fax,
                            password: password,
                            city: city,
                            prov: prov,
                            postcode: postcode,
                            alamat: alamat,
                            _token: '{{ csrf_token() }}',
                            ckk2send: ckk2send
                        },
                        beforeSend: function() {
                            $("#grey_loading").show();
                            $("#loader").show();
                        },
                        success: function(data) {
                            console.log(data);
                            $("#myModal_suplier").modal("show");
                        },
                        complete: function(data) {
                            $("#grey_loading").hide();
                            $("#loader").hide();
                            console.log(data);
                        },
                        error: function(data, textStatus, errorThrown) {
                            console.log(data);
                            $("#myModal_error_seller").modal("show");
                        },
                    });

                    $('#badanusaha_seller').val('');
                    $('#company_seller').val('');
                    // $('#username').val('');
                    $('#website_seller').val('');
                    $('#email_seller').val('');
                    $('#phone_seller').val('');
                    $('#fax_seller').val('');
                    $('#password_seller').val('');
                    $('#kpassword_seller').val('');
                    $('#city_seller').val('');
                    $('#prov_seller').val('');
                    $('#postcode_seller').val('');
                    $('#alamat_seller').val('');
                    $('#captchainput_seller').val('');
                } else {
                    alert("You have entered an invalid email address!");
                    $('#email_seller').val('');
                    refresh();
                    $('#captchainput').val('');
                }

            }
        } else {
            alert("Incorrect password");
            $('#password_seller').val('');
            $('#kpassword_seller').val('');
            refresh();
            $('#captchainput').val('');
        }
    }

    function simpanpembeli(result) {
        var company = $('#company').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var fax = $('#fax').val();
        var website = $('#website').val();
        var password = $('#password').val();
        var kpassword = $('#kpassword').val();
        var city = $('#city').val();
        var country = $('#country').val();
        var postcode = $('#postcode').val();
        var alamat = $('#alamat').val();
        var captcha = $('#captchainput').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        // $.ajax({
        //     type: "POST",
        //     url: '{{ url('/captchaValidate') }}',
        //     data: {
        //         captcha: captcha,
        //         _token: '{{ csrf_token() }}'
        //     },
        //     success: function(data) {
        //         // console.log(data);
        //         if (data.jawab == 'gagal') {
        //             alert("Incorrect captcha code");
        //             $('#captchainput').val('');
        //         } else {
        //             simpanpembeli2();
        //         }
        //     },
        //     error: function(data, textStatus, errorThrown) {
        //         console.log(data);
        //     },
        // });
        if (result !== "") {
                // console.log("submit");
                // $('#formRegister').submit();
                simpanpembeli2();
            } else {
                // Swal.fire({
                //     icon: 'error',
                //     text: 'Harap isi Captcha terlebih dahulu!',
                //     showConfirmButton: true,
                // });
                alert('please submit your captha')
            }
    }

    function simpanpembeli2() {
        var company = $('#company').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var fax = $('#fax').val();
        var website = $('#website').val();
        var password = $('#password').val();
        var kpassword = $('#kpassword').val();
        var city = $('#city').val();
        var country = $('#country').val();
        var postcode = $('#postcode').val();
        var alamat = $('#alamat').val();
        var chp = $('#chp').val();
        if ($("#ckk2").prop('checked') == true) {
            var ckk2send = 1;
        } else {
            var ckk2send = 0;
        }
        if ($("#ckk").prop('checked') == true) {
            var ckksend = 1;
        } else {
            var ckksend = 0;
        }

        var token = $('meta[name="csrf-token"]').attr('content');
        if (password == kpassword) {
            if (company == "" || email == "" || phone == "" || password == "" || country == "" || city == "" ||
                alamat == "" || chp == "") {
                alert("Please complete the field")
                refresh();
                $('#captchainput').val('');
            } else {
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                    $.ajax({
                        type: "POST",
                        url: '{{ url('/simpan_rpembeli') }}',
                        data: {
                            company: company,
                            email: email,
                            username: username,
                            website: website,
                            phone: phone,
                            fax: fax,
                            password: password,
                            city: city,
                            country: country,
                            postcode: postcode,
                            alamat: alamat,
                            _token: '{{ csrf_token() }}',
                            ckk2send: ckk2send
                        },
                         beforeSend: function() {
                            $("#grey_loading").show();
                            $("#loader").show();
                        },
                        success: function(data) {
                            console.log(data);
                            $("#myModal_buyer").modal("show");
                        },
                        complete: function(data) {
                            $("#grey_loading").hide();
                            $("#loader").hide();
                            console.log("complete");
                        },
                        error: function(data, textStatus, errorThrown) {
                            console.log(data);
                            $("#myModal_error").modal("show");
                        },
                    });
                    $('#company').val('');
                    $('#username').val('');
                    $('#website').val('');
                    $('#email').val('');
                    $('#phone').val('');
                    $('#fax').val('');
                    $('#password').val('');
                    $('#kpassword').val('');
                    $('#city').val('');
                    $('#country').val('');
                    $('#postcode').val('');
                    $('#alamat').val('');
                    $('#chp').val('');
                    // $('#captchainput').val('');
                } else {
                    alert("Invalid email address");
                    $('#email').val('');
                    refresh();
                    $('#captchainput').val('');
                }
            }
        } else {
            alert("Incorrect password");
            $('#password').val('');
            $('#kpassword').val('');
            refresh();
            $('#captchainput').val('');

        }
    }

    function cekwebsite() {
        var m = $('#website').val();
        var carikoma = m.search(",");
        if (carikoma != "-1") {
            $('#website').val("");
        }
        var carispa = m.search(" ");
        if (carispa != "-1") {
            $('#email').val("");
        }
    }

    document.querySelectorAll('input[name="acc_type"]').forEach((elem) => {
        elem.addEventListener("change", function(event) {
            var item = event.target.value;
            console.log(item);
            if (item == 'buyer') {
                $('#formRegister').attr('action', '{{ url('simpan_rpembeli') }}');
                $('#form_penjual').hide();
                $('#form_pembeli').show();
                $('#submit_btn').attr('onclick', 'simpanpembeli(grecaptcha.getResponse(widget))');
            } else if (item == 'seller') {
                $('#formRegister').attr('action', '{{ url('simpan_rpenjual') }}');
                $('#form_penjual').show();
                $('#form_pembeli').hide();
                $('#submit_btn').attr('onclick', 'simpanpenjual(grecaptcha.getResponse(widget))');
            }
        });
    });

    $(function() {
        const urlSearchParams = new URLSearchParams(window.location.search);
        const params = Object.fromEntries(urlSearchParams.entries());
        const param_reg = params.reg
        if(param_reg == 'buyer'){
            $("#buyer").prop('checked')
        }else{
            $("#seller").prop('checked', true)
        }
    })
</script>

@include('footerlog')
