@include('headerlog')


<!--slider area start-->
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
    }else if($loc == "in"){
        $lct = "in";
    }else{
        $lct = "en";
    }
?>
<style>

  .table-striped > tbody > tr:nth-child(odd) {
    background-color: white!important;
    background-clip: padding-box!important;
}
.table-striped > tbody > tr:nth-child(even) {
    background-color: white!important;
    background-clip: padding-box!important;
}
.table-bordered td, .table-bordered th {
    border: transparent;
}
h4 h6 h3{

}
.form-control {
    border-radius: 0px;
}
.product_area {
    font-family: 'Lato', sans-serif !important;
}

  </style>
  
    <!--product area start-->
    <section class="product_area" style="background-color:#ddeffd">
        <div class="container">
    
            <div class="tab-content" id="tabing-product">
			<!--<center><br><img style="height:70px!Important;" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ></center> -->
			
             <div class="py-1 text-center w-100 pt-5">
	
	        <!--<h3 style=" font-family: 'Lato', sans-serif !important;"><b>@lang("login.title2")</b></h3>
	        <h6 style=" font-family: 'Lato', sans-serif !important;">@lang("login.title4")</h6><br>-->
			
		        <div class="mx-auto col-lg-4" style="background: white; border-radius: 0px;">
	  <!-- <h5>LOGIN</h5> -->
	  <div class="wrap-login100 pt-4" style="padding-left : 30px; padding-right : 30px; font-size:15px;">
	  
	   <form class="form-horizontal" id="formlogin" method="POST" action="{{ route('loginei.login') }}">
           {{ csrf_field() }}
           <p class="text-left" style=" font-family: 'Lato', sans-serif !important; font-size: 24px;">@lang("login.lbl3")</p>
             <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" align="left">
			 <label style=" font-family: 'Lato', sans-serif !important;">@lang("login.forms.email")</label>
               <input type="email" placeholder="Email" class="form-control" name="email2" id="email2" style="color: #000000;font-family: 'Lato', sans-serif !important;" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong style="font-family: 'Lato', sans-serif !important;">{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
			 
            <div class="form-group" align="left">
			<label style=" font-family: 'Lato', sans-serif !important;">@lang("login.forms.password")</label>
              <input type="password" class="form-control" name="password2" placeholder="Password" id="password2" required style="color: #000000;font-family: 'Lato', sans-serif !important;">

                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
            </div>      
             <div class="form-group">
			 <!--<div class="form-group col-sm-3 captcha" align="left" id="captcha">
                            <span>{!!captcha_img()!!}</span>
                        </div> -->
			<table width="100%">
				<tr>
				<td width="50%"></td>
				<td width="50%" align="right"><a href="{{url('forget_a')}}" style="font-size: 14px; font-family: 'Lato', sans-serif !important;">@lang("login.forms.fp")</a></td>
				</tr>
			</table>
				
			</div>
			<div class="form-group pb-4">
{{--            <button style="width: 100%;" type="submit" class="btn btn-primary">@lang("login.btn")</button>--}}
            <button style="width: 100%;   font-family: 'Lato', sans-serif !important;" type="button" class="btn btn-primary" onclick="check()">@lang("login.btn")</button>
            <hr>
			<label style="font-size: 14px; font-family: 'Lato', sans-serif !important;">@lang("login.forms.r1")</label> <a href="{{url('pilihregister')}}" style="font-size: 14px; font-family: 'Lato', sans-serif !important;">@lang("login.forms.r2")</a>
			</div>
          </form>

      </div>
		
      </div>
            </div>
        </div>
    </section>
    <!--product area end-->

@include('footerlog')
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script>
    function check() {
        email2 = $('#email2').val();
        password2 = $('#password2').val();
        if(!isEmptyM(email2) && !isEmptyM(password2)){
            $.post("{{ route('login.check_status') }}",
                {
                    '_token': '{{csrf_token()}}',
                    'email2': email2,
                    // 'password2': password2,
                }, function (response) {
                    var res = JSON.parse(response);
                    //console.log(res);
                    if(res == 'status2'){
                        var r = confirm("Aktivasi Akun Anda?");
                        // var status = 0;
                        // $('#status').val(0);
                        if (r == true) {
                            $.post("{{ route('login.change_status') }}",
                                {
                                    '_token': '{{csrf_token()}}',
                                    'email' : email2,
                                }, function (response) {

                                });
                            document.getElementById("formlogin").submit();
                        }
                    }else if( res == 'status0'){
                        alert('wait for admin to verified your account first')
                    }
                    // else if(res == 'statusoke'){
                    //     // $('#status').val(1);
                    //     console.log('testing');
                    //     document.getElementById("formlogin").submit();
                    // }
                    else{
                        document.getElementById("formlogin").submit();
                    }
                });
        }else{
            alert('please fill the email and password field first');
        }

    }

    function isEmptyM(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }
</script>
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script>
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad/")}}/'+a,{_token:token},function(data){
			$("#isibroadcast").html(data);
			
		 })
}
function t1(){
	$('#t2').html('');
	$('#t3').html('');
	var t1 = $('#category').val();
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilt2/")}}/'+t1,{_token:token},function(data){
			$("#t2").html(data);
			$("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
			 $('.select2').select2();
			
		 })
}
function t2(){
	$('#t3').html('');
	var t2 = $('#t2s').val();
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilt3/")}}/'+t2,{_token:token},function(data){
			$("#t3").html(data);
			 $('.select2').select2();
			
		 })
}
function nv(){
	var a = $('#staim').val();
	if(a == 2){
		$('#sh1').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id;?>"><?php echo $qr->nama_template;?></option><?php } ?></select></div></div>')
	}else{
		$('#sh1').html(' ');
		$('#sh2').html(' ');
	}
}
function ketv(){
	var a = $('#template_reject').val();
	if(a == 1){
		$('#sh2').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>')
	}
}
$(document).ready(function () {
        $('.select2').select2();
});
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
<script>
    {{--var msg = '{{Session::get('alert')}}';--}}
    {{--var exist = '{{Session::has('alert')}}';--}}
    {{--if(exist){--}}
    {{--    alert(msg);--}}
    {{--}--}}

    </script>
<script type="text/javascript">
    // $(document).ready(function () {
        
    // })
    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#'+tabname).addClass('active');
    }
</script>