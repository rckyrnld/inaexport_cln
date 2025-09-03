@include('frontend.layout.header')
<?php
  $loc = app()->getLocale();
  if(Auth::user()){
    $for = 'admin';
    $message = '';
  } else if(Auth::guard('eksmp')->user()){
    if(Auth::guard('eksmp')->user()->id_role == 2){
      $for = 'eksportir';
      $message = '';
    } else {
      $for = 'importir';
        if($loc == "ch"){
          $message = "您无权加入";
        }elseif($loc == "in"){
          $message = "Anda Tidak Memiliki Akses untuk Bergabung!";
        }else{
          $message = "You do not Have Access to Join!";
        }
    }
  } else {
    $for = 'non user';
      if($loc == "ch"){
        $message = "请先登录";
      }elseif($loc == "in"){
        $message = "Silahkan Login Terlebih Dahulu!";
      }else{
        $message = "Please Login to Continue!";
      }
  }

?>
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
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-divider m-0"></div>
          <div class="box-header bg-light">
            <!-- Header Title -->
          </div>
          <div class="box-body bg-light">
            <h4> @lang("training.title")</h4><hr>
            <form action="{{url('frontend/training/search')}}" method="get">
              <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-3">
                  <input type="text" class="form-control" name="cari" placeholder="@lang('training.cari')" value="{{ old('cari') }}" autocomplete="off">
                </div>
                <div class="col-md-1">
                  <button type="submit" class="btn btn-primary" name="button">
                    <span class="fa fa-search"></span>
                  </button>
                </div>
              </div>
            </form>
            <div class="col-md-14"><br>
              @foreach($data as $num => $val)
                @if($loc == "ch")
                <div class="box">
                  <div class="box-body">
                    <b>{{$val->training_chn}}</b><hr>
                    <div class="row">
                      <div class="col-md-4">
                        <i>{{date("Y/m/d", strtotime($val->start_date))}} - {{date("Y/m/d", strtotime($val->end_date))}}</i>
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-2">
                        <b>@lang("training.lokasi")</b>
                      </div>
                      <div class="col-md-4">
                        : {{$val->location_chn}}
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-2">
                        <b>@lang("training.topic")</b>
                      </div>
                      <div class="col-md-4">
                        : {{$val->topic_chn}}
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-2">
                        <b>@lang("training.durasi")</b>
                      </div>
                      <div class="col-md-4">
                        : {{$val->duration}} 日
                      </div>
                      <div class="col-md-4"></div>
                      <div class="col-md-2">
												@if($for == "admin" || $for == "eksportir")
												<?php $id = cekid(Auth::guard('eksmp')->user()->id) ?>
												<?php $cek = checkJoin($val->id, $id->id) ?>
		                      @if($cek == 0)
													<form action="{{route('training.join')}}" method="post">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<input type="hidden" name="id_training_admin" value="{{$val->id}}">
														<button type="submit" name="button" class="btn btn-primary btn-sm"> 参加</button>
													</form>
													@else
														<button class="btn btn-success btn-sm"> 参加</button>
													@endif
												@else
													<a href="{{url('login')}}" type="submit" name="button" class="btn btn-primary btn-sm"> 参加</a>
												@endif
                      </div>
                    </div><br>
                  </div>
                </div>
                @elseif($loc == "in")
                <div class="box">
                  <div class="box-body">
                    <b>{{$val->training_in}}</b><hr>
                    <div class="row">
                      <div class="col-md-4">
                        <i>{{date("Y/m/d", strtotime($val->start_date))}} - {{date("Y/m/d", strtotime($val->end_date))}}</i>
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-2">
                        <b>@lang("training.lokasi")</b>
                      </div>
                      <div class="col-md-4">
                        : {{$val->location_in}}
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-2">
                        <b>@lang("training.topic")</b>
                      </div>
                      <div class="col-md-4">
                        : {{$val->topic_in}}
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-2">
                        <b>@lang("training.durasi")</b>
                      </div>
                      <div class="col-md-4">
                        : {{$val->duration}} Days
                      </div>
                      <div class="col-md-4"></div>
                      <div class="col-md-2">
												@if($for == "admin" || $for == "eksportir")
												<?php $id = cekid(Auth::guard('eksmp')->user()->id) ?>
												<?php $cek = checkJoin($val->id, $id->id) ?>
												@if($cek == 0)
												<form action="{{route('training.join')}}" method="post">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="id_training_admin" value="{{$val->id}}">
													<button type="submit" name="button" class="btn btn-primary btn-sm"> {{$id}} Join Now</button>
												</form>
												@else
													<button class="btn btn-success btn-sm"> Joined</button>
												@endif
												@else
													<a href="{{url('login')}}" type="submit" name="button" class="btn btn-primary btn-sm"> Join Now</a>
												@endif
                      </div>
                    </div><br>
                  </div>
                </div>
                @elseif($loc == "en")
                <div class="box">
                  <div class="box-body">
                    <b>{{$val->training_en}}</b><hr>
                    <div class="row">
                      <div class="col-md-4">
                        <i>{{date("Y/m/d", strtotime($val->start_date))}} - {{date("Y/m/d", strtotime($val->end_date))}}</i>
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-2">
                        <b>@lang("training.lokasi")</b>
                      </div>
                      <div class="col-md-4">
                        : {{$val->location_en}}
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-2">
                        <b>Topic</b>
                      </div>
                      <div class="col-md-4">
                        : {{$val->topic_en}}
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-2">
                        <b>Duration</b>
                      </div>
                      <div class="col-md-4">
                        : {{$val->duration}} {{$val->param}}
                      </div>
                      <div class="col-md-4"></div>
                      <div class="col-md-2">
												@if($for == "admin" || $for == "eksportir")
												<?php $id = cekid(Auth::guard('eksmp')->user()->id) ?>
												<?php $cek = checkJoin($val->id, $id->id) ?>
												@if($cek == 0)
												<form action="{{route('training.join')}}" method="post">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="id_training_admin" value="{{$val->id}}">
													<button type="submit" name="button" class="btn btn-primary btn-sm"> Join Now</button>
												</form>
												@else
													<button class="btn btn-success btn-sm"> Joined</button>
												@endif
												@else
													<a href="{{url('login')}}" type="submit" name="button" class="btn btn-primary btn-sm"> Join Now</a>
												@endif
                      </div>
                    </div><br>
                  </div>
                </div>
                @endif
              @endforeach
            </div>
            {{ $data->render("pagination::bootstrap-4") }}
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>

<!-- ############ SWITHCHER START-->
<div id="setting">
  <div class="setting dark-white rounded-bottom" id="theme">
    <a href="#" data-toggle-class="active" data-target="#theme" class="dark-white toggle">
      <i class="fa fa-gear text-primary fa-spin"></i>
    </a>
    <div class="box-header">
      <a href="https://themeforest.net/item/apply-web-application-admin-template/21072584?ref=flatfull" class="btn btn-xs rounded danger float-right">BUY</a>
      <strong>Theme Switcher</strong>
    </div>
    <div class="box-divider"></div>
    <div class="box-body">
      <p id="settingLayout">
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedAside">
          <i></i>
          <span>Fixed Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedContent">
          <i></i>
          <span>Fixed Content</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="folded">
          <i></i>
          <span>Folded Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="container">
          <i></i>
          <span>Boxed Layout</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="ajax">
          <i></i>
          <span>Ajax load page</span>
        </label>
        <label class="pointer my-1 d-block" data-toggle="fullscreen" data-plugin="screenfull" data-target="fullscreen">
          <span class="ml-1 mr-2 auto">
            <i class="fa fa-expand d-inline"></i>
            <i class="fa fa-compress d-none"></i>
          </span>
          <span>Fullscreen mode</span>
        </label>
      </p>
      <p>Colors:</p>
      <p>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="primary">
          <i class="primary"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="accent">
          <i class="accent"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="warn">
          <i class="warn"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="info">
          <i class="info"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="success">
          <i class="success"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="warning">
          <i class="warning"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="danger">
          <i class="danger"></i>
        </label>
      </p>
      <div class="row no-gutters">
        <div class="col">
          <p>Brand</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="brand" value="dark-white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="brand" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col mx-2">
          <p>Aside</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="aside" value="white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="aside" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col">
          <p>Themes</p>
          <div class="clearfix">
            <label class="radio radio-inline ui-check">
              <input type="radio" name="bg" value="">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline ui-check ui-check-color">
              <input type="radio" name="bg" value="dark">
              <i class="dark"></i>
            </label>
          </div>
        </div>
      </div>
      <p>Demos</p>
      <div class="text-md">
        <a href="dashboard.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">0</a>
        <a href="dashboard.1.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark-white" class="no-ajax badge light">1</a>
        <a href="dashboard.2.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=white" class="no-ajax badge light">2</a>
        <a href="dashboard.3.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">3</a>
        <a href="dashboard.4.html?folded=true&amp;bg=&amp;aside=dark" class="no-ajax badge light">4</a>
        <a href="dashboard.5.html?folded=true&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">5</a>
        <a href="dashboard.6.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">6</a>
        <a href="dashboard.7.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">7</a>
        <a href="dashboard.8.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">8</a>
        <a href="rtl.html?folded&amp;bg=" class="no-ajax badge light">RTL</a>
      </div>
    </div>
  </div>
</div>
<!-- ############ SWITHCHER END-->

@include('frontend.layout.footer')
