@include('frontend.layouts.header')
<style>
    .card {
        border-radius: 10px;
    }
    .btn {
        border-radius: 5px;
    }
</style>
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
<style type="text/css">

</style>

<!--breadcrumbs area start-->
<div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content" style="margin-top: -8px; margin-bottom: 20px;">
                    <ul>
                        <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                        <li><a href="#">@lang('frontend.history.ticket')</a></li>
                        <li>@lang('frontend.ticket_title')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--product details start-->
    <div class="mt-20" style="background-color: #ddeffd;background-color: margin-bottom: 0px !important; margin-top: 0px; font-size: 14px;">
        <div class="container">
            <br><br>
            <div class="content conten-form">
                <form class="form" action="{{route('front.ticket.add')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row ">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="fa fa-ticket"></i> Create New Ticket</h4>
                                    @if($help == null)
                                        <sub style="color: red">*Akun belum terdaftar di helpdesk support</sub>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="subject">Title</label>
                                        <input type="text" required name="subject" id="subject" class="form-control" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="content-editor">Content</label>
                                        <textarea id="konten" class="form-control" name="contents"></textarea>
                                        <script>
                                            var konten = document.getElementById("konten");
                                            CKEDITOR.replace(konten,{
                                                language:'en-gb',
                                                height:255
                                            });
                                            CKEDITOR.config.removePlugins = 'image,pwimage';
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">Attachment</label>
                                        <input type="file" name="file" id="file" class="form-control">
                                        <sub>Allowed file types: .zip, .rar, .jpg, .jpeg, .png, .gif</sub>
                                    </div>
                                </div>
                                <br>
                                <div class="card-footer text-right">
                                    <a href="{{route('front.ticket.index')}}" class="btn btn-danger"><i class="fas fa-arrow-circle-left"></i> Go
                                        Back</a>
                                    @if($help != null)
                                        <button type="submit" name="save" class="btn btn-primary submitNT"><i class="far fa-save"></i> Save <i
                                                    class="fa fa-spinner fa-pulse loader" style="display: none;"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="far fa-address-card"></i> About the Ticket</h4>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-5">Department</dt>
                                        <dd class="col-sm-7">
                                            <select name="depid" id="depid" class="form-control">
                                                @foreach($department as $val)
                                                    <option value="{{$val['id']}}">{{$val['title']}}</option>
                                                @endforeach
                                            </select>
                                        </dd>
                                        <dt class="col-sm-5">Ticket Priority</dt>
                                        <dd class="col-sm-7">
                                            <div class="dropdown bootstrap-select">
                                                <select name="priorityid" id="priorityid" class="form-control" >
                                                    <option value="1">Low</option>
                                                    <option value="2">Medium</option>
                                                    <option value="3">High</option>
                                                </select>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-5">Option</dt>
                                        <dd class="col-sm-7">
                                            <div class="dropdown bootstrap-select">
                                                <select name="toptionid" id="toptionid" class="form-control">
                                                    <option value="1">Feedback</option>
                                                    <option value="2">Support</option>
                                                    <option value="3">Bug Report</option>
                                                </select>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-5">Private</dt>
                                        <dd class="col-sm-7">
                                            <div class="form-check form-check-radio">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="private" value="1" checked="">
                                                    <span class="form-check-sign"></span>Yes
                                                </label>
                                                <label style="margin-left: 25px" class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="private" value="0">
                                                    <span class="form-check-sign"></span>No
                                                </label>
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <br><br>
        </div>
    </div>
<!--product details end-->

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function () {

    });
</script>