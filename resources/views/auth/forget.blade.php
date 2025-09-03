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
           <p style="font-size: 20px; text-align: left;">@lang("login.lbl4")</p>
           <p style="font-size: 14px; text-align: left;">@lang("login.lbl9")</p>
            <!-- <div class="form-group">
            <select class="form-control" id="id_role" name="id_role" style="color:black;" >
				<option value="1">Exporter/Importer</option>
				<option value="2">Atdag / ITPC</option>
			</select>
        </div> -->
		
		<div class="form-group">
				<input type="hidden" name="id_role" id="id_role" value="1">
               <input id="email" type="email" placeholder="Email" class="form-control" name="email" style="color: #000000" value="" required="" autofocus="">
        {{-- <label>{{Request::url()}}</label> --}}
        {{-- <label>{{url()->previous()}}</label> --}}
        </div>
		<div class="form-group">
		<center><button style="width: 100%;" type="submit" class="btn btn-primary">@lang("login.btn2")</button></center>
		</div>
			<br>
          </form>
        

      </div>
	  
		
      </div>
	  <br><br>
    </div>
  </div>
  
@include('footerlog')