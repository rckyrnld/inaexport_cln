@include('frontend.layouts.header')
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
    }else if($loc == "in"){
        $lct = "in";
    }else{
        $lct = "en";
    }

    //get category
    $cat1 = getCategoryName($data->id_csc_product, $lct);
    $cat2 = getCategoryName($data->id_csc_product_level1, $lct);
    $cat3 = getCategoryName($data->id_csc_product_level2, $lct);

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
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                            @if($data->id_csc_product == NULL)
                            <li><a href="{{url('/front_end/list_product')}}">@lang('frontend.proddetail.dafault')</a></li>
                            @else
                                @if($cat1 == "-")
                                    <li><a href="{{url('/front_end/list_product')}}">@lang('frontend.proddetail.dafault')</a></li>
                                @else
                                    @if($cat2 == "-")
                                        <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level1)}}">{{$cat1}}</a></li>
                                    @else
                                        @if($cat3 == "-")
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product)}}">{{$cat1}}</a></li>
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level1)}}">{{$cat2}}</a></li>
                                        @else
                                             <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product)}}">{{$cat1}}</a></li>
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level1)}}">{{$cat2}}</a></li>
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level2)}}">{{$cat3}}</a></li>
                                        @endif
                                    @endif
                                @endif
                            @endif
                            <li>@lang('inquiry.form')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{url($url)}}" id="formnya">
  {{ csrf_field() }}
  <div id="content-body">
    <div class="py-5 w-100">
      <center><h4><b>@lang("frontend.title2")</b></h4><br></center>
      <div class="container">
        <div class="box" style="padding: 20px;">
        <?php
          $loc = app()->getLocale();
          $lct = "";
          if($loc == "ch"){
            $lct = "chn";
          }elseif($loc == "in"){
            $lct = "in";
          }else{
            $lct = "en";
          }
        ?>
          <br>
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
              <h5><b>@lang('inquiry.form')</b></h5>
            </div>
          </div><br><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.prodname')</b></label>
            <div class="col-md-7">
              <input type="hidden" name="id_product" id="id_product" value="{{$data->id}}">
              <input type="hidden" name="type" id="type" value="importir">
              <b>{{getProductAttr($data->id, 'prodname', $lct)}}</b>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.category')</b></label>
            <div class="col-md-7">
              <b>
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
              </b>
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{url('/')}}/{{$img1}}" data-zoom-image="{{url('/')}}/{{$img1}}" alt="big-1">
                            </a>
                        </div>

                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img1}}" data-zoom-image="{{url('/')}}/{{$img1}}">
                                        <img src="{{url('/')}}/{{$img1}}" alt="zo-th-1" />
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img2}}" data-zoom-image="{{url('/')}}/{{$img2}}">
                                        <img src="{{url('/')}}/{{$img2}}" alt="zo-th-1" />
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img3}}" data-zoom-image="{{url('/')}}/{{$img3}}">
                                        <img src="{{url('/')}}/{{$img3}}" alt="zo-th-1" />
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img4}}" data-zoom-image="{{url('/')}}/{{$img4}}">
                                        <img src="{{url('/')}}/{{$img4}}" alt="zo-th-1" />
                                    </a>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                      <!-- <h1>{{getProductAttr($data->id, 'prodname', $lct)}}</h1>
                        <div class="price_box">
                            <span class="current_price">
                                @if(is_numeric($data->price_usd))
                                    $ {{$data->price_usd}}
                                @else
                                    {{$data->price_usd}}
                                @endif
                            </span>
                        </div> -->
                        <div class="product_desc">
                            <table border="0" cellpadding="10" cellspacing="10" style="width: 100%; font-size: 14px;">
                              <tbody>
                                <tr>
                                  <td width="30%">@lang('inquiry.prodname')</td>
                                  <td width="60%">
                                    <input type="hidden" name="id_product" id="id_product" value="{{$data->id}}">
                                    <input type="hidden" name="type" id="type" value="importir">
                                    <b>{{getProductAttr($data->id, 'prodname', $lct)}}</b>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.category')</td>
                                  <td width="60%">
                                    <?php
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
                                  <td width="30%">@lang('inquiry.kos')</td>
                                  <td width="60%">
                                    <select class="form-control" name="kos" id="kos" style="font-size: 14px;">
                                      <option value="" style="display: none;"> - @lang('inquiry.selectkos') - </option>
                                      <option value="offer to sell">@lang('inquiry.ots')</option>
                                      <option value="offer to buy">@lang('inquiry.otb')</option>
                                      <option value="consultation">@lang('inquiry.consul')</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.company')</td>
                                  <td width="60%">
                                    <span style="color: #326BA2; text-transform: capitalize;">{{getCompanyName($data->id_itdp_company_user)}}</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.subject')</td>
                                  <td width="60%">
                                    <input type="text" name="subject" class="form-control" id="subject" autocomplete="off" style="font-size: 14px;">
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%" style="vertical-align: top;">@lang('inquiry.msg')</td>
                                  <td width="60%">
                                    <textarea class="form-control" id="messages" name="messages" style="font-size: 14px;" rows="5"></textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.file')</td>
                                  <td width="60%">
                                    <div class="input-group mb-3">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="filedo" name="filedo" style="font-size: 14px;">
                                        <label class="custom-file-label" for="inputGroupFile01" id="labfiledo"> - @lang('inquiry.choose') - </label>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.duration')</td>
                                  <td width="60%">
                                    <select class="form-control" name="duration" id="duration" style="font-size: 14px;">
                                      <option value="" style="display: none;"> - @lang('inquiry.selectduration') - </option>
                                      <option value="1 week">@lang('inquiry.v1w')</option>
                                      <option value="2 weeks">@lang('inquiry.v2w')</option>
                                      <option value="3 weeks">@lang('inquiry.v3w')</option>
                                      <option value="1 month">@lang('inquiry.v1m')</option>
                                      <option value="2 months">@lang('inquiry.v2m')</option>
                                      <option value="3 months">@lang('inquiry.v3m')</option>
                                      <option value="4 months">@lang('inquiry.v4m')</option>
                                      <option value="5 months">@lang('inquiry.v5m')</option>
                                      <option value="6 months">@lang('inquiry.v6m')</option>
                                    </select>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                        <!-- <div class="product_variant quantity">
                            <label>@lang('frontend.proddetail.minorder')</label>
                            <input type="text" name="minorder" value="{{$data->minimum_order}}" readonly>

                        </div><br> -->
                        <div class="">
                            <center>
                                <a href="{{url('/front_end/list_product')}}" class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.cancel')</a>
                                <button type="button" class="btn btn-primary" id="btnsubmit"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.submit')</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.kos')</b></label>
            <div class="col-md-4">
              <select class="form-control" name="kos" id="kos">
                <option value="" style="display: none;"> - @lang('inquiry.selectkos') - </option>
                <option value="offer to sell">@lang('inquiry.ots')</option>
                <option value="offer to buy">@lang('inquiry.otb')</option>
                <option value="consultation">@lang('inquiry.consul')</option>
              </select>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.company')</b></label>
            <div class="col-md-7">
              <b>{{getCompanyName($data->id_itdp_company_user)}}</b>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.subject')</b></label>
            <div class="col-md-4">
              <input type="text" name="subject" class="form-control" id="subject" autocomplete="off">
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.msg')</b></label>
            <div class="col-md-7">
              <textarea class="form-control" id="messages" name="messages"></textarea>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.file')</b></label>
            <div class="col-md-4">
              <input type="file" name="filedo" class="form-control" id="filedo">
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.duration')</b></label>
            <div class="col-md-4">
              <select class="form-control" name="duration" id="duration">
                <option value="" style="display: none;"> - @lang('inquiry.selectduration') - </option>
                <option value="1 week">@lang('inquiry.v1w')</option>
                <option value="2 weeks">@lang('inquiry.v2w')</option>
                <option value="3 weeks">@lang('inquiry.v3w')</option>
                <option value="1 month">@lang('inquiry.v1m')</option>
                <option value="2 months">@lang('inquiry.v2m')</option>
                <option value="3 months">@lang('inquiry.v3m')</option>
                <option value="4 months">@lang('inquiry.v4m')</option>
                <option value="5 months">@lang('inquiry.v5m')</option>
                <option value="6 months">@lang('inquiry.v6m')</option>
              </select>
            </div>
            <div class="col-md-1"></div>
          </div><br><br>
          <div class="row">
            <div class="col-md-11">
              <div style="float: right;">
                <a class="btn btn-danger" href="{{url('/')}}">@lang('inquiry.cancel')</a>
                <button type="button" class="btn btn-primary" id="btnsubmit">@lang('inquiry.submit')</button>
              </div>
            </div>
          </div><br>
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
    </form>
  </div>
</div>
  </form>

<?php
  $alertkos = "";
  $alertsubject = "";
  $alertmsg = "";
  $alertfile = "";
  $alertdurasi = "";

  if($loc == "ch"){
    $alertkos = "主题种类为空，请填写！";
    $alertsubject = "主题为空，请填写！";
    $alertmsg = "留言为空，请填写！";
    $alertfile = "文件为空，请填写！";
    $alertdurasi = "期限为空，请填写！";    
  }else if($loc == "in"){
    $alertkos = "Jenis Subjek kosong, silahkan isi!";
    $alertsubject = "Subjek kosong, silahkan isi!";
    $alertmsg = "Pesan kosong, silahkan isi!";
    $alertfile = "File kosong, silahkan isi!";
    $alertdurasi = "Durasi kosong, silahkan isi!";
  }else{
    $alertkos = "Kind of Subject is empty, please fill in!";
    $alertsubject = "Subject is empty, please fill in!";
    $alertmsg = "Messages is empty, please fill in!";
    $alertfile = "File is empty, please fill in!";
    $alertdurasi = "Duration is empty, please fill in!";
  }
?>
    <!--product details end-->
<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
@include('frontend.layouts.footer')
<script type="text/javascript">
  $(function(){
    CKEDITOR.replace('messages');
  });
    $(document).ready(function(){
        //Upload File
        $("#filedo").on('change', function() {
            if(this.value != ""){
              var val = this.value;
              var v = val.split('\\');
              $('#labfiledo').html(v[v.length - 1]);
            }else{
                alert('The file cannot be uploaded');
            }
        });

  $(document).ready(function () {
    // location.reload();
    $('#btnsubmit').on('click', function () {
      var data = CKEDITOR.instances.messages.getData();
      
      if ($('#kos').val() == "") {
          alert("<?php echo $alertkos; ?>");
      }else if ($('#subject').val() == "") {
          alert("<?php echo $alertsubject; ?>");
      }else if (data == "") {
          alert("<?php echo $alertmsg; ?>");
      }else if ($('#filedo').val() == "") {
          alert("<?php echo $alertfile; ?>");
      }else if ($('#duration').val() == "") {
          alert("<?php echo $alertdurasi; ?>");
      }else {
          $('#formnya').submit();
          // alert("Sukses");//tinggal buat action inquiry nya
      }
        $('#btnsubmit').on('click', function () {
          
          if ($('#kos').val() == "") {
              alert("<?php echo $alertkos; ?>");
          }else if ($('#subject').val() == "") {
              alert("<?php echo $alertsubject; ?>");
          }else if ($('#messages').val() == "") {
              alert("<?php echo $alertmsg; ?>");
          }else if ($('#filedo').val() == "") {
              alert("<?php echo $alertfile; ?>");
          }else if ($('#duration').val() == "") {
              alert("<?php echo $alertdurasi; ?>");
          }else {
              $('#formnya').submit();
          }
        });
    });
  });
</script>

@include('frontend.layout.footer')