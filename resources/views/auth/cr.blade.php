@include('headerlog')
  <style>
	 #content-bodys {
        font-family: 'Lato', sans-serif !important;
    }
  </style>
  <div id="content-bodys" class="product_area">
    <div class="py-1 text-center w-100 pt-5">
	  <p style="font-size: 30px; font-weight: bold;">@lang("login.title3")</p>
	  <!--<h6>@lang("login.title2")</h6> -->
	  <div class="container pt-4">
		<div class="row">
			<div class="col-lg-6 pb-4">
				<div class="row justify-content-end">
					<div class="col-lg-8">
					<a href="{{url('registrasi_penjual')}}" style="text-decoration: none;"><img src="{{url('assets')}}/assets/images/cr_eks2.png" alt="." ><p style="font-size:22px; background-color: #fff; color: red;">@lang("login.a4")</p></a>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="row justify-content-start">
					<div class="col-lg-8">
					<a href="{{url('register_buyer')}}" style="text-decoration: none;"><img src="{{url('assets')}}/assets/images/cr_imp2.png" alt="." ><p style="font-size:22px; background-color: #fff; color: red;">@lang("login.a5")</p></a>
					</div>
				</div>
			</div>
		</div>
	  </div>
    </div>
  </div>

@include('footerlog')
