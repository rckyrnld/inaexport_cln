@include('headerlog')
  
  <div id="content-body" style="background-color: #c5e1f8 ; color: black" >
  <center><br><img style="height:70px!Important;" src="{{ asset('front/assets/img/logo/logonew-200.png') }}" alt="." ></center>
    <div class="py-1 text-center w-100">
	
	<h3><b>@lang("login.title2")</b></h3>
	
	<br>
      <div class="mx-auto" style="width:400px;background: white; border-radius: 0px;">
	  <br>
	  <!-- <h5>LOGIN</h5> -->
	  <div class="wrap-login100" style="padding-left : 30px; padding-right : 30px; font-size:12px;">
	  
	   <form class="form-horizontal" method="POST" action="{{ url('updatepass2/'.$ri) }}">
           {{ csrf_field() }}
           <h4>@lang("login.lbl4")</h4><br>
             <div class="form-group">
		<input type="hidden" name="ida" value="<?php echo $ri; ?>">
               <input id="password" type="password" placeholder="password" class="form-control" name="password" style="color: #000000" value="" required="" autofocus="">

        </div>
		
		
		<br>
		<div class="form-group">
		<center><button style="width: 100%;" type="submit" class="btn primary">@lang("login.btn3")</button></center>
		</div>
			<br>
          </form>
        

      </div>
	  
		
      </div>
	  <br><br>
    </div>
  </div>
@include('footerlog')