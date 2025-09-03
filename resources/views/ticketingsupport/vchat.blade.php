@include('frontend.layout.header')
<?php
$loc = app()->getLocale();
if (Auth::user()) {
    $for = 'admin';
    $message = '';
} else if (Auth::guard('eksmp')->user()) {
    if (Auth::guard('eksmp')->user()->id_role == 2) {
        $for = 'eksportir';
        $message = '';
    } else {
        $for = 'importir';
        if ($loc == "ch") {
            $message = "您无权加入";
        } elseif ($loc == "in") {
            $message = "Anda Tidak Memiliki Akses untuk Bergabung!";
        } else {
            $message = "You do not Have Access to Join!";
        }
    }
} else {
    $for = 'non user';
    if ($loc == "ch") {
        $message = "请先登录";
    } elseif ($loc == "in") {
        $message = "Silahkan Login Terlebih Dahulu!";
    } else {
        $message = "Please Login to Continue!";
    }
}

?>
<div class="d-flex flex-column flex" style="">
    <div class="light bg pos-rlt box-shadow"
         style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
        <div class="mx-auto">
            <table border="0" width="100%">
                <tr>
                    <td width="30%" style="font-size:13px;padding-left:10px"><img height="30px"
                                                                                  src="{{url('assets')}}/assets/images/logo.jpg"
                                                                                  alt="."><b>&nbsp;&nbsp;&nbsp; Ministry
                            Of Trade</b></td>
                    <td width="30%"></td>
                    <td width="40%" align="right" style="padding-right:10px;">
                        <a href="{{ url('locale/en') }}"><img width="20px" height="15px"
                                                              src="{{asset('negara/en.png')}}"></a>&nbsp;
                        <a href="{{ url('locale/in') }}"><img width="20px" height="15px"
                                                              src="{{asset('negara/in.png')}}"></a>&nbsp;
                        <a href="{{ url('locale/ch') }}"><img width="20px" height="15px"
                                                              src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
                        <a href="{{url('login')}}"><font color="white"><i
                                        class="fa fa-sign-in"></i> @lang("frontend.lbl3")</font></a>
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
                        <h4>@if($loc == "ch") 表格票务 @elseif($loc == "en") Form Ticketing @elseif($loc == "in") Form
                            Ticketing @endif</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-2">
                                <b>@if($loc == "ch") 名称 @elseif($loc == "en") Name @elseif($loc == "in") Nama @endif</b>
                            </div>
                            <div class="col-md-4">
                                : {{$users->name}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <b>@if($loc == "ch") 电子邮件 @elseif($loc == "en") Email @elseif($loc == "in")
                                        Email @endif</b>
                            </div>
                            <div class="col-md-4">
                                : {{$users->email}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <b>@if($loc == "ch") 学科 @elseif($loc == "en") Subject @elseif($loc == "in")
                                        Subyek @endif</b>
                            </div>
                            <div class="col-md-4">
                                : {{$users->subyek}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <b>@if($loc == "ch")按摩 @elseif($loc == "en") Massages @elseif($loc == "in")
                                        Pesan @endif</b>
                            </div>
                            <div class="col-md-4">
                                : {{$users->main_messages}}
                            </div>
                        </div>
                        <br>
                        <form class="" action="{{url('/ticketing/sendchat')}}" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <br>
                                        <div class="row">
                                            @foreach($messages as $msg)
                                                @if($msg->sender == $msg->id_pembuat)
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-10">
                                                        <div class="row pull-right">
                                                            <div class="col-md-10">
                                                                <label class="label"
                                                                       style="background:orange; border-radius:10px; width:300px ">
                                                                    &nbsp;&nbsp<b>@if($loc == "ch")
                                                                            您 @elseif($loc == "en")
                                                                            You @elseif($loc == "in") Anda @endif</b> :
                                                                    &nbsp;&nbsp{{$msg->messages}}<br>
                                                                    &nbsp;&nbsp<i>{{$msg->messages_send}}</i>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                    <div class="col-md-1"></div>
                                                @else
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <label class="label"
                                                                       style="background:aqua; border-radius:10px; width:300px">
                                                                    &nbsp;&nbsp<b>@if($loc == "ch")
                                                                            管理员 @elseif($loc == "en")
                                                                            Admin @elseif($loc == "in") Admin @endif</b>
                                                                    :
                                                                    &nbsp;&nbsp{{$msg->messages}}<br>
                                                                    &nbsp;&nbsp<i>{{$msg->messages_send}}</i>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                    <div class="col-md-1"></div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <br>
                                        @if($jenis == 'chat')
                                            @if($users->status != 3 )
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-8">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="sender"
                                                               value="{{$users->id_pembuat}}">
                                                        <input type="hidden" name="id" value="{{$users->id}}">
                                                        <input type="hidden" name="reciver" value="0">
                                                        <input type="text" class="form-control" name="messages" value=""
                                                               autocomplete="off">
                                                    </div>
                                                    <div class="col-md-2 pull-right">
                                                        <button type="submit" name="button" class="btn btn-primary">
                                                            <span class="fa fa-send"></span> @if($loc == "ch")
                                                                发送 @elseif($loc == "en") Send @elseif($loc == "in")
                                                                Kirim @endif</button>
                                                    </div>
                                                </div><br>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
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
            <a href="https://themeforest.net/item/apply-web-application-admin-template/21072584?ref=flatfull"
               class="btn btn-xs rounded danger float-right">BUY</a>
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
                <label class="pointer my-1 d-block" data-toggle="fullscreen" data-plugin="screenfull"
                       data-target="fullscreen">
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
                <a href="dashboard.1.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark-white"
                   class="no-ajax badge light">1</a>
                <a href="dashboard.2.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=white"
                   class="no-ajax badge light">2</a>
                <a href="dashboard.3.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white"
                   class="no-ajax badge light">3</a>
                <a href="dashboard.4.html?folded=true&amp;bg=&amp;aside=dark" class="no-ajax badge light">4</a>
                <a href="dashboard.5.html?folded=true&amp;bg=&amp;aside=dark&amp;brand=dark"
                   class="no-ajax badge light">5</a>
                <a href="dashboard.6.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white"
                   class="no-ajax badge light">6</a>
                <a href="dashboard.7.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark"
                   class="no-ajax badge light">7</a>
                <a href="dashboard.8.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white"
                   class="no-ajax badge light">8</a>
                <a href="rtl.html?folded&amp;bg=" class="no-ajax badge light">RTL</a>
            </div>
        </div>
    </div>
</div>
<!-- ############ SWITHCHER END-->
<script>
    $(function () {
        $('#toggle-two').bootstrapToggle({
            on: 'OPEN',
            off: 'CLOSED'
        });
    })
</script>

@include('frontend.layout.footer')
