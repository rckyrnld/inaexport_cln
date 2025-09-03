@include('frontend.layout.header')
<style>
  .atag:hover{
      text-decoration: underline;
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
    <div class="py-5 w-100">
      <center><h4><b>@lang("frontend.title2")</b></h4><br></center>
      <div class="container">
        <div class="box" style="padding: 20px;">
        <?php
          $loc = app()->getLocale();
        ?>
          <div class="row">
            <div class="col-md-11">
              <h5><b>@lang('inquiry.detail')</b></h5>
            </div>
            <div class="col-md-1">
              <a href="{{url('/front_end/inquiry_list')}}" class="btn btn-danger" style="float: right;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> @lang('button-name.back')</a>
            </div>
          </div><br>
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
                </tbody>
              </table>
            </div>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                  <h5><b>@lang('inquiry.titlechat')</b></h5>  
              </div>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                <div class="box" style="max-height: 400px; overflow-y: scroll;overflow-x: hidden; padding: 0px 5px 0px 5px; border: 1px solid rgba(120, 130, 140, 0.5);">
                  <br>
                  <div class="row">
                    <?php
                      $datenya = NULL;
                    ?>
                    @foreach($messages as $msg)
                    @if($msg->sender == $id_user)
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                      @if($datenya == NULL)
                          <?php
                              $datenya = date('d-m-Y', strtotime($msg->created_at));
                          ?>
                          <center>
                              <i>
                                  {{$datenya}}
                              </i>
                          </center><br>
                      @else
                          @if($datenya != date('d-m-Y', strtotime($msg->created_at)))
                              <?php
                                  $datenya = date('d-m-Y', strtotime($msg->created_at));
                              ?>
                              <center>
                                  <i>
                                      {{$datenya}}
                                  </i>
                              </center><br>
                          @endif
                      @endif
                      <div class="row pull-right">
                        <div class="col-md-10">
                          <label class="label" style="background: #FFD54F; border-radius:10px; width:300px; padding: 10px;">
                              <b>@if($loc == "ch") 您 @elseif($loc == "en") You @elseif($loc == "in") Anda @endif</b> :<br>
                              @if($msg->messages == NULL)
                                  <a href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}" target="_blank" class="atag" style="color: red;">{{$msg->file}}</a><br>
                              @else
                                  {{$msg->messages}}<br>
                              @endif
                              <span style="color: #555; float: right;">{{date('H:i',strtotime($msg->created_at))}}</span>
                          </label>
                        </div>
                      </div>
                    </div><br>
                    <div class="col-md-1"></div>
                    @else
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                      @if($datenya == NULL)
                          <?php
                              $datenya = date('d-m-Y', strtotime($msg->created_at));
                          ?>
                          <center>
                              <i>
                                  {{$datenya}}
                              </i>
                          </center><br>
                      @else
                          @if($datenya != date('d-m-Y', strtotime($msg->created_at)))
                              <?php
                                  $datenya = date('d-m-Y', strtotime($msg->created_at));
                              ?>
                              <center>
                                  <i>
                                      {{$datenya}}
                                  </i>
                              </center><br>
                          @endif
                      @endif
                      <div class="row">
                        <div class="col-md-10">
                          <label class="label" style="background: #eee; border-radius:10px; width:300px; padding: 10px;">
                              <b style="text-transform: capitalize;">{{getCompanyName($msg->sender)}}</b> :<br>
                              @if($msg->messages == NULL)
                                  <a href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}" target="_blank" class="atag" style="color: red;">{{$msg->file}}</a><br>
                              @else
                                  {{$msg->messages}}<br>
                              @endif
                              <span style="color: #555; float: right;">{{date('H:i',strtotime($msg->created_at))}}</span>
                          </label>
                        </div>
                      </div>
                    </div><br>
                    <div class="col-md-1"></div>
                    @endif
                    @endforeach
                  </div><br>
                </div>
              </div>
          </div>
          @if($inquiry->status != 3 && $inquiry->status != 4 && $inquiry->status != 5)
          <div class="row">
            <div class="col-md-12">
              <div class="input-group mb-3">
                  <input type="text" class="form-control" name="messages2" value="" id="messages2" autocomplete="off">
                  <div class="input-group-append">
                    <form action="{{route('front.inquiry.fileChat')}}" method="post" enctype="multipart/form-data" id="uploadform2">
                    {{ csrf_field() }}
                      <button type="button" class="btn btn-default" id="uploading2" name="uploading2" style="border-color: rgba(120, 130, 140, 0.5);">
                          <img src="{{asset('image/paperclip.png')}}" width="20px">
                      </button>
                      <input type="file" id="upload_file2" name="upload_file2" style="display: none;" />
                      <input type="hidden" name="sender2" id="sender2" value="{{$id_user}}">
                      <input type="hidden" name="id_inquiry2" id="id_inquiry2" value="{{$inquiry->id}}">
                      <input type="hidden" name="type2" id="type2" value="{{$inquiry->type}}">
                      <input type="hidden" name="receiver2" id="receiver2" value="{{$data->id_itdp_company_user}}">
                    </form>
                  </div>
              </div>
            </div>
          </div><br>
          @endif
        </div>
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

<script>
    $(document).ready(function(){
        //Click Image
        $("#uploading2").click(function() {
            $("input[id='upload_file2']").click();
        });

        //Upload File
        $("#upload_file2").on('change', function() {
            if(this.value != ""){
                $('#uploadform2').submit();
            }else{
                alert('The file cannot be uploaded');
            }
        });

        //Send Message
        $('#messages2').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                var sender = $('#sender2').val();
                var receiver = $('#receiver2').val();
                var id_inquiry = $('#id_inquiry2').val();
                var type = $('#type2').val();
                var msg = this.value;
                
                $.ajax({
                    url: "{{route('eksportir.inquiry.sendChat')}}",
                    type: 'get',
                    data: {from:sender, to:receiver, idinquiry:id_inquiry, messages: msg, file: "", typenya: type},
                    success:function(response){
                        if(response == 1){
                            location.reload();
                        }else{
                            alert("This message is not delivered!");
                            location.reload();
                        }
                    }
                });
            }
            event.stopPropagation();
        });
    })
</script>