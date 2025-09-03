@include('headerlog')
<link href="{{asset('')}}/js/tagsinput.css" rel="stylesheet" type="text/css">
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
</style>
<div id="content-bodys" class="product_area" style="color: black">
    <div class="py-1 w-100">
        <div class="text-center pt-4 pb-4">
            <h3><b>@lang("login.title3")</b></h3>
            <h6>@lang("login.title5") <a href="{{url('login')}}">@lang("login.btn")</a></h6>
        </div>
        <div class="mx-auto col-lg-6" style="background: white; border-radius: 0px;">
            <br>
            <!-- <h5>LOGIN</h5> -->
        <!--<h5><center><b>@lang("register2.title")</b></center></h5>-->
            <div class="wrap-login100" style="padding-left : 40px; padding-right : 40px; font-size:14px;">
                <form class="form-horizontal" method="POST" action="{{ url('simpan_rpenjual') }}">
                    {{ csrf_field() }}
                    <p><h6>Account Information</h6></p>
                    <hr>

                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("login.forms.prov")</label>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <select class="form-control" name="prov" id="prov">
                                <option value="">- Choose Province -</option>
                                <?php
                                $qc = DB::select("select id,province_en from mst_province order by province_en asc");
                                foreach($qc as $cq){
                                ?>
                                <option value="<?php echo $cq->id; ?>"><?php echo $cq->province_en; ?></option>

                                <?php } ?>
                            </select>
                        </div>


                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("login.forms.city")</label>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <input type="text" name="city" id="city" class="form-control" style=" color: black; ">
                        </div>


                    </div>
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
                            <label><font color="red">*</font> @lang("register2.forms.email")</label>
                            &nbsp;&nbsp;&nbsp;<span id="cekmail"></span>

                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <input type="text" onkeyup="cekmail()" name="email" id="email" class="form-control"
                                   style=" color: black; " required>
                        </div>


                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register2.forms.password")</label>

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
                            <label><font color="red">*</font> @lang("register2.forms.company")</label>


                        </div>
						 <div class="form-group col-sm-2" align="left">
						<select id="badanusaha" name="badanusaha" class="form-control" required>
															<option>-</option>
															<?php
															$bns = DB::select("select * from eks_business_entity");
															foreach($bns as $val){
															?>
															<option value="<?php echo $val->nmbadanusaha; ?>"><?php echo $val->nmbadanusaha; ?></option>
															<?php } ?>
														</select>
						</div>
                        <div class="form-group col-sm-6" align="left">
                            <input style="text-transform:uppercase" type="text" name="company" id="company" class="form-control" style=" color: black; "
                                   required>
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
{{--                    <div class="form-row">--}}
{{--                        <div class="form-group col-sm-4" align="left">--}}
{{--                            <label><font color="red">*</font> @lang("register2.forms.username")</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-sm-8" align="left">--}}
{{--                            <input type="text" name="username" id="username" class="form-control"--}}
{{--                                   style=" color: black; " required>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register2.forms.phone")</label>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" value="+62" class="form-control" disabled style="padding: .105rem .20rem; " >
                                </div>
                                <div class="col-md-10"><input type="text" name="phone" id="phone" class="form-control " style=" color: black;"></div>
                            </div>
                           <!-- <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10"><span><label style="font-size: 12px;">Contoh : 87780733154</label></span></div>
                            </div> -->
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label>@lang("register2.forms.fax")</label>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control" value="+62" disabled  style="padding: .105rem .20rem; " >
                                </div>
                                <div class="col-md-10">
                                    <input type="text" name="fax" id="fax" class="form-control" style=" color: black;">
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10"><span><label style="font-size: 12px;">Contoh : 8342</label></span></div>
                            </div> -->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label>@lang("register2.forms.website")</label>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <input type="text" name="website" id="website" onkeyup="cekwebsite()" class="form-control" style=" color: black; ">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label>@lang("register.forms.postcode")</label>
                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <input type="text" name="postcode" id="postcode" class="form-control"
                                   style=" color: black; ">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label>@lang("register.forms.address")</label>

                        </div>
                        <div class="form-group col-sm-8" align="left">
                            <textarea name="alamat" id="alamat" class="form-control" style=" color: black; "></textarea>
                        </div>


                    </div>


                    {{--		<div class="form-row">--}}


                    {{--							<div class="form-group col-sm-4" align="left">--}}
                    {{--                                <label><font color="red">*</font> Verification Code</label>--}}
                    {{--							</div>--}}
                    {{--							<div class="form-group col-sm-2" align="left">--}}
                    {{--                                 <img style="height:20px!Important;" src="{{url('assets')}}/assets/images/captcha.jfif" alt="." >--}}
                    {{--                            </div>--}}
                    {{--							<div class="form-group col-sm-4" align="left">--}}
                    {{--                                 <input type="text" class="form-control" name="chp" id="chp">--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> Verification Code</label>
                        </div>
                        <div class="form-group col-sm-4 captcha" align="left" id="captcha">
                            <span>{!!captcha_img()!!}</span>
                        </div>
                        <div class="form-group col-sm-1" align="left">
                            <button type="button" class="btn btn-success" style="height: 70px; border-radius: 0px;"
                                    id="refresh"><i class="fa fa-refresh"></i></button>
                        </div>
                        <div class="form-group col-sm-3" align="left">
                            <input type="text" class="form-control" style="height: 70px;" name="captchainput"
                                   id="captchainput">
                        </div>
                    </div>

                    <div class="form-row" align="left">

                        <div class="form-group col-sm-12"><br>
                            <!--<input type="checkbox" name="ckk" id="ckk"> I agree to the Term & Condition and have read and understood the Privacy Policy.<br>-->
                            <div class="form-check pb-4">
                                <input type="checkbox" class="form-check-input" name="ckk2" id="ckk2"> <label
                                        class="form-check-label" for="ckk2">Sign up for newsletter.</label>
                            </div>
                            <!--<center>-->

                            <p>By creating an account, you agree to the Term & Condition and have read and understood
                                the Privacy Policy. </p>
                            <a class="btn btn-danger" onclick="simpanpenjual()"><font
                                        color="white">&nbsp;&nbsp;&nbsp;@lang("register.submit")
                                    &nbsp;&nbsp;&nbsp;</font></a>
                        <!-- <button style="width: 100%;" class="btn btn-success" style="border-color: #4CAF50;"><font color="white">&nbsp;&nbsp;&nbsp;@lang("register.submit")&nbsp;&nbsp;&nbsp;</font></button> -->
                            <br><br><br>
                            <!--</center>-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--<p class="text-center pt-4">@lang("login.title8")</p>-->

</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2e899e; color:white;"><h6>Attention</h6>
                <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <h5>
                    <center><br>
                        <img style="height:80px!important;" src="{{url('assets')}}/assets/images/mail.png"
                             alt="."><br><br>
                        @lang("register2.modal")
                    </center>
                </h5>
                <h5 style="padding-left: 50px;">
                    <ol>
                        <li>NPWP (Mandatory)</li>
                        <li>TDP (Optional)</li>
                        <li>SIUP (Optional)</li>
                        <li>NIB (Mandatory)</li>
                    </ol>
                </h5><br>
				<h5>Jika Anda tidak mendapat email dari Inaexport dalam beberapa menit, cek folder spam/junk Anda.</h5>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                <a href="{{url('login')}}" type="button" class="btn btn-danger">Close</a>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('')}}/js/tagsinput.js"></script>
<script>

    $('#refresh').click(function () {
        $.ajax({
            type: 'GET',
            url: 'refreshcaptcha',
            success: function (data) {
                console.log(data);
                $(".captcha span").html(data);
            }
        });
    });

    function refresh() {
        $.ajax({
            type: 'GET',
            url: 'refreshcaptcha',
            success: function (data) {
                console.log(data);
                $(".captcha span").html(data);
            }
        });
    }

    function cekmail() {
        var m = $('#email').val();
		var carikoma = m.search(",");
		if(carikoma != "-1"){
			$('#email').val("");
		}
		var carispa = m.search(" ");
		if(carispa != "-1"){
			$('#email').val("");
		}
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{URL::to("cekmail/")}}/' + m, {_token: token}, function (data) {
            if (data == 0) {
                $('#cekmail').html("<font color='green'>( Available )</font>");

            } else {
                $('#cekmail').html("<font color='red'>( Not Available ! )</font>");
                alert("Sorry The Mail Has Been Used");
                $('#email').val("");
            }


        })
        //alert(m);
        //$('#cekmail').html("<font color='red'>( Has Been Used ! )</font>");
    }

    function cekwebsite(){
        var m = $('#website').val();
        var carikoma = m.search(",");
		if(carikoma != "-1"){
			$('#website').val("");
		}
        var carispa = m.search(" ");
		if(carispa != "-1"){
			$('#email').val("");
		}
    }

    function simpanpenjual() {
        var badanusaha = $('#badanusaha').val();
        var company = $('#company').val();
        // var username = $('#username').val();
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
        $.ajax({
            type: "POST",
            url: '{{url('/captchaValidate')}}',
            data: {
                captcha: captcha,
                _token: '{{csrf_token()}}'
            },
            success: function (data) {
                if (data.jawab == 'gagal') {
                    alert("Incorrect captcha code");
                    $('#captchainput').val('');
                } else {
                    simpanpenjual2();
                }
            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);

            },
        });
    }

    function simpanpenjual2() {
        var badanusaha = $('#badanusaha').val();
        var company = $('#company').val();
        // var username = $('#username').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var fax = $('#fax').val();
        var website = $('#website').val();
        var password = $('#password').val();
        var kpassword = $('#kpassword').val();
        var city = $('#city').val();
        var prov = $('#prov').val();
        var postcode = $('#postcode').val();
        var alamat = $('textarea#alamat').val();
        var chp = $('#chp').val();
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

        console.log(company);
        // console.log(username);
        console.log(email);
        console.log(phone);
        console.log(password);
        console.log(prov);
        console.log(city);
        console.log(alamat);
        console.log(chp);

        console.log("end");

        // console.log(fax);
        // console.log(website);
        //
        // console.log(kpassword);
        //
        //
        // console.log(postcode);


        if (password == kpassword) {
            // if (company == "" || username == "" || email == "" || phone == "" || password == "" || city == "" || prov == "" || chp == "") {
            if (company == "" || email == "" || phone == "" || password == "" || city == "" || prov == "" || chp == "") {
                alert("Please complete the field !")
                refresh();
                $('#captchainput').val('');
            } else {
                /*
                $.post('{{url('/simpan_rpenjual')}}',{company:company,username:username,email:email,phone:phone,fax:fax,password:password,city:city,prov:prov,postcode:postcode,alamat:alamat,_token:token},function (data) {
		 	
		 });
		*/
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
                {
                    $.ajax({
                        type: "POST",
                        url: '{{url('/simpan_rpenjual')}}',
                        data: {
                            badanusaha: badanusaha,
                            company: company,
                            // username: username,
                            email: email,
                            website: website,
                            phone: phone,
                            fax: fax,
                            password: password,
                            city: city,
                            prov: prov,
                            postcode: postcode,
                            alamat: alamat,
                            _token: '{{csrf_token()}}',
                            ckk2send: ckk2send
                        },
                        success: function (data) {
                            console.log(data);
                        },
                        error: function (data, textStatus, errorThrown) {
                            console.log(data);
                        },
                    });

                    $('#badanusaha').val('');
                    $('#company').val('');
                    // $('#username').val('');
                    $('#website').val('');
                    $('#email').val('');
                    $('#phone').val('');
                    $('#fax').val('');
                    $('#password').val('');
                    $('#kpassword').val('');
                    $('#city').val('');
                    $('#prov').val('');
                    $('#postcode').val('');
                    $('#alamat').val('');
                    $('#captchainput').val('');
                    $("#myModal").modal("show");
                }else{
                    alert("You have entered an invalid email address!");
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
</script>

@include('footerlog')