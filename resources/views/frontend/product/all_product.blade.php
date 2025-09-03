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
      <center>
      <h4><b>@lang("frontend.title2")</b></h4><br>
      <h5 style="float: left; margin-left: 1%;"><b><i class="fa fa-list"></i> @lang("frontend.categorytitle")</b></h5><br>
      <hr>
      <?php
        $cl = 0;
        $loc = app()->getLocale();
      ?>
      <div class="bagcat" style="width: 97%;">
        @foreach($catprod as $c)
          @if($cl < 3)
            @if($cl == 0)
              <div class="row">
                <div class="col-lg-2"></div>
            @endif
                <div class="col-lg-3">
                  <?php
                    $catprodname = "";
                    if($loc == "ch"){
                      $catprodname = $c->nama_kategori_chn;
                    }elseif($loc == "in"){
                      $catprodname = $c->nama_kategori_in;
                    }else{
                      $catprodname = $c->nama_kategori_en;
                    }

                    if($catprodname == NULL){
                      $catprodname = $c->nama_kategori_en;
                    }

                    $urlprodcat = url('/front_end/category_product/').'/'.$c->id;
                  ?>
                  <div class="col-lg-12 cat">
                    <a href="{{$urlprodcat}}">
                      {{$catprodname}}
                    </a>
                  </div>
                </div>
            @if($cl == 2)
                <!-- <div class="col-lg-1"></div> -->
              </div>
            @endif
            <?php if($cl == 2){ $cl = 0; }else{ $cl++; } ?>
          @endif
        @endforeach
      </div><br>
      <h5 style="float: left; margin-left: 1%;"><b><i class="fa fa-fire"></i> @lang("frontend.hotlisttitle")</b></h5><br>
      <hr>
      <table class="" style="width: 90%; padding: 20px;">
        <tbody>
          <?php
          $co = 0;
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
      </table>
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