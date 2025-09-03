@include('headerlog')
  
  <div id="content-body" style="background-color: #c5e1f8 ; color: black" >
  <div class="py-1 text-center w-100">
	
	<br>
      <div class="mx-auto" style="width:400px;background: white; border-radius: 0px;">
	  <br>
	  <!-- <h5>LOGIN</h5> -->
	  <div class="wrap-login100" style="padding-left : 30px; padding-right : 30px; font-size:12px;">
	  
	   <form class="form-horizontal" method="POST" action="{{ url('resetpass') }}">
           {{ csrf_field() }}
           <p style="font-size: 16px; text-align: left;">@lang("login.lbl10")</p>
           
		<center><a href="{{ url('/login') }}" style="width: 100%; color: #ffffff;" type="submit" class="btn btn-primary">@lang("login.btn5")</a></center>
		</div>
			<br>
          </form>
        

      </div>
	  
		
      </div>
	  <br><br>
    </div>
  </div>
  
@include('footerlog')