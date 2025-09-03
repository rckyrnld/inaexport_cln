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
      <table class="table" style="width: 90%; padding: 20px;">
        <thead>
          <th colspan="5">
            <h5><b>@lang("frontend.prodtitle")</b></h5>
            <div style="float: right; margin-top: -30px;">
              <a href="{{ url('front_end/all_product') }}" class="btn btn-default btn-sm">@lang("frontend.moreproduct")</a>
            </div>
          </th>
        </thead>
        <tbody>
          <?php
          $co = 0;
          $loc = app()->getLocale();
        ?>
        @foreach($product as $p)
          @if($co < 5)
            @if($co == 0)
            <tr>
            @endif
            <td width="20%">
              <?php
                if($loc == "ch"){
                  $nameprod = $p->prodname_chn;
                }elseif($loc == "in"){
                  $nameprod = $p->prodname_in;
                }else{
                  $nameprod = $p->prodname_en;
                }

                if($nameprod == NULL){
                  $nameprod = $p->prodname_en;
                }
              ?>
              <a type="button" class="btn btn-default" style="width: 220px; background: white; height: 250px; max-height: 250px; max-width: 100%; padding: 10px;" title="{{$nameprod}}" href="{{url('front_end/product')}}/{{$p->id}}">
                <?php
                  $img = "";
                  if($p->image_1 != NULL){
                    $img = $p->image_1;
                  }else if($p->image_2 != NULL){
                    $img = $p->image_2;
                  }else if($p->image_3 != NULL){
                    $img = $p->image_3;
                  }else if($p->image_4 != NULL){
                    $img = $p->image_4;
                  }

                  if($img == ""){
                    $isimg = '/image/noimage.jpg';
                  }else{
                    $image = 'uploads/Eksportir_Product/Image/'.$p->id.'/'.$img; 
                    if(file_exists($image)) {
                      $isimg = '/uploads/Eksportir_Product/Image/'.$p->id.'/'.$img;
                    }else {
                      $isimg = '/image/noimage.jpg';
                    }  
                  }
                ?>
                <img src="{{url('/')}}{{$isimg}}" style="width: 200px; height: 200px;">
                <?php
                  $num_char = 25;
                  $text = $nameprod;
                  if(strlen($text) > 25){
                      $cut_text = substr($text, 0, $num_char);
                      if ($text{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                          $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                          $cut_text = substr($text, 0, $new_pos);
                      }
                      $nameprodnya =  $cut_text . '...';
                  }else{
                      $nameprodnya =  $text;
                  }
                ?>
                <br><b>
                  {{$nameprodnya}}
                </b>
              </a>
            </td>
            @if($co == 4)
            </tr>
            @endif
            <?php if($co == 4){ $co = 0;}else{ $co++; } ?>
          @endif
        @endforeach
        </tbody>
      </table><br>
    </center>
    <div align="left" style="padding-left: 5%">
      <table class="table" style="width: 20%; padding: 20px;">
        <thead>
          <tr>
            <th><h5><b>@lang("frontend.service-title")</b></h5></th>
          </tr>
        </thead>
        <tbody>
          @foreach($service as $nomor => $data)
          <?php
            if($loc == "ch"){
              $name = $data->nama_chn;
            }elseif($loc == "in"){
              $name = $data->nama_ind;
            }else{
              $name = $data->nama_en;
            }

            if($name == NULL){
              $name = $data->nama_en;
            }
          ?>
          <tr>
            <td>
              <a href="{{url('/front_end/service-detail', $data->id)}}">
                <div style="height:100%;width:100%">
                  {{$name}}
                </div>
              </a>
            </td>
          </tr>
            @endforeach
        </tbody>
      </table>
    </div>
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