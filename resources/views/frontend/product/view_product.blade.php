@include('frontend.layout.header')

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
        ?>
          <div class="row">
            <div class="col-lg-5">
              <div id="demo" class="carousel slide" data-ride="carousel">

                <!-- Indicators -->
                <ul class="carousel-indicators">
                  <li data-target="#demo" data-slide-to="0" class="test active"></li>
                  <li data-target="#demo" data-slide-to="1" class="test"></li>
                  <li data-target="#demo" data-slide-to="2" class="test"></li>
                  <li data-target="#demo" data-slide-to="3" class="test"></li>
                </ul>
                <!-- The slideshow -->
                <?php
                  $img1 = "image/noimage.jpg";
                  $img2 = "image/noimage.jpg";
                  $img3 = "image/noimage.jpg";
                  $img4 = "image/noimage.jpg";
                  if($data->image_1 != NULL){
                    $imge1 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_1;
                    if(file_exists($imge1)) {
                      $img1 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_1;
                    }
                  }
                  if($data->image_2 != NULL){
                    $imge2 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_2;
                    if(file_exists($imge2)) {
                      $img2 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_2;
                    }
                  }
                  if($data->image_3 != NULL){
                    $imge3 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_3;
                    if(file_exists($imge3)) {
                      $img3 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_3;
                    }
                  }
                  if($data->image_4 != NULL){
                    $imge4 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_4;
                    if(file_exists($imge4)) {
                      $img4 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_4;
                    }
                  }
                ?>
                <div class="carousel-inner" style="border: 1px solid gray;">
                  <div class="carousel-item active">
                    <img src="{{url('/')}}/{{$img1}}" style="width: 300px; height: auto;">
                  </div>
                  <div class="carousel-item">
                    <img src="{{url('/')}}/{{$img2}}" style="width: 300px; height: auto;">
                  </div>
                  <div class="carousel-item">
                    <img src="{{url('/')}}/{{$img3}}" style="width: 300px; height: auto;">
                  </div>
                  <div class="carousel-item">
                    <img src="{{url('/')}}/{{$img4}}" style="width: 300px; height: auto;">
                  </div>
                </div>
                
                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                  <i class="fa fa-chevron-left" aria-hidden="true" style="color: black;"></i>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                  <i class="fa fa-chevron-right" aria-hidden="true" style="color: black;"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-7">
              <?php
                $lct = "";
                if($loc == "ch"){
                  $lct = "chn";
                }elseif($loc == "in"){
                  $lct = "in";
                }else{
                  $lct = "en";
                }
              ?>
              <table class="table" style="padding: 5px;">
                <thead>
                  <tr>
                    <th colspan="2">
                      <center><h6><b>{{getProductAttr($data->id, 'prodname', $lct)}}</b></h6></center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="20%">
                      @lang("product.exporter")
                    </td>
                    <td width="80%">
                      <b>{{getCompanyName($data->id_itdp_company_user)}}</b>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      @lang("product.code")
                    </td>
                    <td>{{getProductAttr($data->id, 'code', $lct)}}</td>
                  </tr>
                  <tr>
                    <td>
                      @lang("product.category")
                    </td>
                    <td>
                      <?php
                        $cat1 = getCategoryName($data->id_csc_product, $lct);
                        $cat2 = getCategoryName($data->id_csc_product_level1, $lct);
                        $cat3 = getCategoryName($data->id_csc_product_level2, $lct);

                        if($cat1 == "-"){
                          echo $cat1;
                        }else{
                          if($cat2 == "-"){
                            echo $cat1;
                          }else{
                            if($cat3 == "-"){
                              echo $cat1." > ".$cat2;
                            }else{
                              echo $cat1." > ".$cat2." > ".$cat3;
                            }
                          }
                        }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      @lang("product.color")
                    </td>
                    <td>{{getProductAttr($data->id, 'color', $lct)}}</td>
                  </tr>
                  <tr>
                    <td>
                      @lang("product.size")
                    </td>
                    <td>{{getProductAttr($data->id, 'size', $lct)}}</td>
                  </tr>
                  <tr>
                    <td>
                      @lang("product.rawmaterial")
                    </td>
                    <td>{{getProductAttr($data->id, 'raw_material', $lct)}}</td>
                  </tr>
                  <tr>
                    <td>
                      @lang("product.capacity")
                    </td>
                    <td>{{getProductAttr($data->id, 'capacity', '')}}</td>
                  </tr>
                  <tr>
                    <td>
                      @lang("product.minorder")
                    </td>
                    <td>{{getProductAttr($data->id, 'minimum_order', '')}}</td>
                  </tr>
                  <tr>
                    <td>
                      @lang("product.prodesc")
                    </td>
                    <td><?php echo getProductAttr($data->id, 'product_description', $lct); ?></td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <center>
                        <a href="{{url('front_end/inquiry_product')}}/{{$data->id}}" class="btn btn-primary"><i class="fa fa-envelope" aria-hidden="true"></i> @lang('product.inquiry')</a>
                      </center>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
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