@include('header')
<link href="{{asset('')}}/js/tagsinput.css" rel="stylesheet" type="text/css">
<style>
    .badge {
        font-size: 95% !important;
    }
    .form-control{
        font-size: 13px;
        border-radius: 0px;
    }
    #content-bodys {
        font-family: 'Lato', sans-serif !important;
    }
</style>
<div id="content-bodys" class="product_area" style="color: black">
    <div class="py-1 w-100">
        <div class="mx-auto col-lg-6"
             style="background: white; border-radius: 0px;">
            <br>
            <!-- <h5>LOGIN</h5> -->
            <!--<h5>
                <center><b>@lang("register.title")</b></center>
            </h5>-->
            <div class="wrap-login100" style="padding-left : 40px; padding-right : 40px; font-size:14px;">
                <form class="form-horizontal" method="POST" action="{{ route('savebuyer') }}">
                    {{ csrf_field() }}
                    <p><h6>Account Information</h6></p>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("login.forms.city")</label>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <input type="text" name="city" id="city" class="form-control" style=" color: black; ">
                        </div>


                    </div>

                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.email")
                            </label>&nbsp;&nbsp;&nbsp;<span id="cekmail"></span>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <input type="text" name="email" id="email" class="form-control" style=" color: black; "
                                   required onkeyup="cekmail()">

                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.password")</label>

                        </div>

                        <div class="form-group col-sm-8" align="left">
                            <input type="password" name="password" id="password" class="form-control"
                                   style=" color: black; " required>

                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.re-password")</label>

                        </div>

                        <div class="form-group col-sm-8" align="left">
                            <input type="password" name="kpassword" id="kpassword" class="form-control"
                                   style=" color: black; ">

                        </div>

                    </div>


                    <br>
                    <p><h6>Business Information</h6></p>
                    <hr>

                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.company") </label>

                        </div>

                        <div class="form-group col-sm-8" align="left">
                            <input type="text" name="company" id="company" class="form-control" style=" color: black; "
                                   required>

                        </div>

                    </div>
                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label> &nbsp;Product Interest </label>

                        </div>

                        <div class="form-group col-sm-8" align="left">
                            <input type="text" data-role="tagsinput" class="form-control" value="">

                        </div>

                    </div>
                    <div class="form-row">


                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.phone")</label>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <input type="text" name="phone" id="phone" class="form-control" style=" color: black; ">
                        </div>
                    </div>
                    <div class="form-row">


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
                            <input type="text" name="website" id="website" class="form-control" style=" color: black; ">
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
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> Verification Code</label>
                        </div>
                        <div class="form-group col-sm-3 captcha" align="left" id="captcha">
                            <span>{!!captcha_img()!!}</span>
                        </div>
                        <div class="form-group col-sm-1" align="left">
                            <button type="button" class="btn btn-success" style="height: 34px; border-radius: 0px;" id="refresh"><i class="fa fa-refresh"></i></button>
                        </div>
                        <div class="form-group col-sm-4" align="left">
                            <input type="text" class="form-control" style="height: 34px;" name="captchainput" id="captchainput">
                        </div>
                    </div>





                    <div class="form-row" align="left">

                        <div class="form-group col-sm-12"><br>
                            <!--<input type="checkbox" name="ckk" id="ckk"> I agree to the Term & Condition and have read
                            and understood the Privacy Policy.<br>
                            <div class="form-check pb-4">
                                <input type="checkbox"  class="form-check-input" name="ckk2" id="ckk2"> 
                                <label class="form-check-label" for="ckk2">Sign up for newsletter.</label>
                            </div>-->
                            <!--<center>-->
                            <p>By creating an account, you agree to the Term & Condition and have read and understood the Privacy Policy. </p>
                                <a onclick="simpanpembeli()" class="btn btn-danger"><font color="white">&nbsp;&nbsp;&nbsp;@lang("register.submitbuyer")
                                        &nbsp;&nbsp;&nbsp;</font></a>
                            <!-- <button style="width: 100%;" class="btn btn-success" style="border-color: #4CAF50;"><font color="white">&nbsp;&nbsp;&nbsp;@lang("register.submit")&nbsp;&nbsp;&nbsp;</font></button> -->
                            <!--</center>-->
                            <br><br><br>
                        </div>
                    </div>

                </form>


            </div>


        </div>
    </div>
    <!--<p class="text-center pt-4">@lang("login.title8")</p>-->
</div>
<script src="{{asset('')}}/js/tagsinput.js"></script>
<script>

    $('#refresh').click(function(){
        refresh()
    });

    function refresh(){
        $.ajax({
            type:'GET',
            url:'refreshcaptcha',
            success:function(data){
                console.log(data);
                $(".captcha span").html(data);
            }
        });
    }

    function cekmail() {
        var m = $('#email').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{URL::to("cekmail/")}}/' + m, {_token: token}, function (data) {
            if (data == 0) {
                $('#cekmail').html("<font color='green'>( Available )</font>");

            } else {
                $('#cekmail').html("<font color='red'>( Has Been Used ! )</font>");
                $('#email').val("");
                alert("Sorry The Mail Has Been Used");
            }


        })
        //alert(m);
        //$('#cekmail').html("<font color='red'>( Has Been Used ! )</font>");
    }


    function simpanpembeli(){
        var company = $('#company').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var fax = $('#fax').val();
        var website = $('#website').val();
        var password = $('#password').val();
        var kpassword = $('#kpassword').val();
        var city = $('#city').val();
        // var country = $('#country').val();
        var postcode = $('#postcode').val();
        var alamat = $('#alamat').val();
        var captcha = $('#captchainput').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: '{{url('/captchaValidate')}}',
            data: {
                captcha : captcha,
                _token: '{{csrf_token()}}'
            },
            success: function (data) {
                // console.log(data);
                if(data.jawab == 'gagal'){
                    alert("Incorrect captcha code");
                    $('#captchainput').val('');
                }
                else{
                    simpanpembeli2();
                }
            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);
            },
        });
    }

    function simpanpembeli2() {
        var company = $('#company').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var fax = $('#fax').val();
        var website = $('#website').val();
        var password = $('#password').val();
        var kpassword = $('#kpassword').val();
        var city = $('#city').val();
        // var country = $('#country').val();
        var postcode = $('#postcode').val();
        var alamat = $('#alamat').val();
        var chp = $('#chp').val();
        if($("#ckk2").prop('checked') == true){
            var ckk2send = 1;
        }else{
            var ckk2send = 0;
        }
        if($("#ckk").prop('checked') == true){
            var ckksend = 1;
        }else{
            var ckksend = 0;
        }

        var token = $('meta[name="csrf-token"]').attr('content');
        if (password == kpassword) {
            if (company == "" || email == "" || phone == "" || password == "" || city == "" || alamat == "" || chp == "") {
                alert("Please complete the field !")
                refresh();
                $('#captchainput').val('');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{route('savebuyer')}}",
                    data: {
                        company: company,
                        email: email,
                        website: website,
                        phone: phone,
                        fax: fax,
                        password: password,
                        city: city,
                        postcode: postcode,
                        alamat: alamat,
                        _token: '{{csrf_token()}}',
                        ckk2send : ckk2send
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (data, textStatus, errorThrown) {
                        console.log(data);

                    },
                });
                $('#company').val('');
                $('#website').val('');
                $('#email').val('');
                $('#phone').val('');
                $('#fax').val('');
                $('#password').val('');
                $('#kpassword').val('');
                $('#city').val('');
                $('#postcode').val('');
                $('#alamat').val('');
                $('#chp').val('');
                window.location.href = "{{url('verifyimportir')}}";
            }
        } else {
            alert("Incorrect password");
            $('#password').val('');
            $('#kpassword').val('');
            refresh();
            $('#captchainput').val('');

        }
    }
</script>

@include('footerlog')