@include('frontend.layout.header')
<style type="text/css">
  #tablenya td:first-child{
    padding-left: 10%; text-align: left !important; font-weight: bold; width: 40%;
  }
  #tablenya td{
    text-align: left !important; padding-left: 10%;
  }
</style>
<div class="d-flex flex-column flex" style="">
	<div class="light bg pos-rlt box-shadow" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
    <div class="mx-auto">
    	<table border="0" width="100%">
      	<tr>
      	<td width="30%" style="font-size:13px;padding-left:10px"><img height="30px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ><b>&nbsp;&nbsp;&nbsp; Ministry Of Trade</b></td>
      	<td width="30%"></td>
      	<td width="40%" align="right" style="padding-right:10px;">
        	<a href="{{ url('locale/en') }}"><img width="20px" height="15px" src="{{asset('negara/en.png')}}"></a>&nbsp;
        	<a href="{{ url('locale/in') }}"><img width="20px" height="15px" src="{{asset('negara/in.png')}}"></a>&nbsp;
        	<a href="{{ url('locale/ch') }}"><img width="20px" height="15px" src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
        	<a href="{{url('login')}}"><font color="white"><i class="fa fa-sign-in"></i> @lang("frontend.lbl3")</font></a>
      	</td>
      	</tr>
    	</table>
    </div>
  </div>
  <div id="content-body">
    <div class="py-5 text-center w-100">
      <h4><b>@lang("frontend.title2")</b></h4><br>
      <center>
      <div class="container">
        <div class="box" style="padding: 20px;">
        <?php
          $loc = app()->getLocale();
          if($loc == "ch"){
            $lct = "chn";
          }elseif($loc == "in"){
            $lct = "ind";
          }else{
            $lct = "en";
          }
        ?>
          <div class="row">
            <div class="col-lg-12">
              <?php
                $lct = "";
                if($loc == "ch"){
                  $lct = "chn";
                }elseif($loc == "in"){
                  $lct = "ind";
                }else{
                  $lct = "en";
                }
              ?>
              <table class="table" style="padding: 5px; width: 60%;" id="tablenya">
                <thead>
                  <tr>
                    <th colspan="2">
                      <center><h6><b>@lang("service.title")</b></h6></center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>@lang("service.nama")</td>
                    <td>{{getServiceAttr($data->id, 'nama', $lct)}}</td>
                  </tr>
                  <tr>
                    <td>@lang("service.bidang")</td>
                    <td>{{getServiceAttr($data->id, 'bidang', $lct)}}</td>
                  </tr>
                  <tr>
                    <td>@lang("service.skill")</td>
                    <td>{{getServiceAttr($data->id, 'skill', $lct)}}</td>
                  </tr>
                  <tr>
                    <td>@lang("service.pengalaman")</td>
                    <td>{{getServiceAttr($data->id, 'pengalaman', $lct)}}</td>
                  </tr>
                  <tr>
                    <td>@lang("service.link")</td>
                    <td>{{getServiceAttr($data->id, 'link', '')}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <a href="{{url('front_end/')}}" class="btn btn-danger" style="float: right;">BACK</a><br><br>
        </div>
      </div>
      </center>
        <div class="px-3">
         {{--  <div>
            <a href="#" class="btn btn-block indigo text-white mb-2">
              <i class="fa fa-facebook float-left"></i>
              Sign in with Facebook
            </a>
            <a href="#" class="btn btn-block red text-white">
              <i class="fa fa-google-plus float-left"></i>
              Sign in with Google+
            </a>
          </div> --}}
          {{-- <div class="my-3 text-sm">
            OR
          </div> --}}
         
		  
          <div class="my-4">
           <!-- <a href="{{ route('password.request') }}" class="text-primary _600">Forgot password?</a> -->
          </div>
          <div>
           <!-- Do not have an account? 
            <a href="{{url('register')}}" class="text-primary _600">Sign up</a> -->
          </div>
        </div>
		
      </div>
    </div>
  </div>
</div>

@include('frontend.layout.footer')