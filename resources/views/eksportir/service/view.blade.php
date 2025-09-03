@extends('header2')
@section('content')
<?php
    $bidang_en = explode(', ', $data->bidang_en);
    if(in_array('Pre Production', $bidang_en)){
        $chck_bidang_1 = 'checked';
    } else {
        $chck_bidang_1 = '';
    }

    if(in_array('Production', $bidang_en)){
        $chck_bidang_2 = 'checked';
    } else {
        $chck_bidang_2 = '';
    }
    
    if(in_array('Post Production', $bidang_en)){
        $chck_bidang_3 = 'checked';
    } else {
        $chck_bidang_3 = '';
    }

    if($data->status == 0){
        $chck = "";
    }else{
        $chck = "checked";
    }
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<style>
    body {
        font-family: Arial;
    }

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 8px 10px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 45px !important;
    }
    .custom-select, .custom-file-control, .custom-file-control:before, select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
        height: 45px !important;
    }
    .toggle.btn.btn-info{
        width: 15% !important;
    }
    .toggle.btn.btn-default.off{
        width: 15% !important;   
    }
    .form-group input[type="checkbox"] {
        display: none;
    }
    .form-group input[type="checkbox"] + .btn-group > label span {
        width: 20px;
    }
    .form-group input[type="checkbox"] + .btn-group > label span:first-child {
        display: none;
    }
    .form-group input[type="checkbox"] + .btn-group > label span:last-child {
        display: inline-block;   
    }
    .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
        display: inline-block;
    }
    .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
        display: none;   
    }

</style>
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="tab-content ">
                    <div class="tab-pane active" id="formprod">
                        <h3>View Produk Jasa</h3><hr>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <center><label for="lbl"><b>English</b></label></center>
                            </div>
                            <div class="col-md-3">
                                <center><label for="lbl"><b>Indonesia</b></label></center>
                            </div>
                            <div class="col-md-3">
                                <center><label for="lbl"><b>China</b></label></center>
                            </div>
                        </div>
                        <div class="row">
                            <label for="code" class="col-md-3"><b>Name</b></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="name_en" id="name_en" autocomplete="off" value="{{$data->nama_en}}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="name_ind" id="name_ind" autocomplete="off" value="{{$data->nama_ind}}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="name_chn" id="name_chn" autocomplete="off" value="{{$data->nama_chn}}">
                            </div>
                        </div><br>
                        <div class="row">
                            <label for="code" class="col-md-3"><b>Field of Work</b></label>
                            <div class="col-md-3">
                                <div class="form-group" onclick="bidang_1(1)" style="width: 80%; height: 35px">
                                    <input type="checkbox" name="bidang_en[]" {{$chck_bidang_1}} id="bidang_en" autocomplete="off" value="Pre Production"/>
                                    <div class="btn-group" style="width: 100%; height: 100%">
                                        <label for="bidang_en" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                            <span class="fa fa-check" style="font-size: 16px;"></span>
                                            <span></span>
                                        </label>
                                        <label for="bidang_en" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                            Pre Production
                                        </label>
                                    </div>
                                </div><br>
                                <div class="form-group" onclick="bidang_2(1)" style="width: 80%; height: 35px">
                                    <input type="checkbox" name="bidang_en[]" {{$chck_bidang_2}} id="bidang_en_2" autocomplete="off" value="Production"/>
                                    <div class="btn-group" style="width: 100%; height: 100%;">
                                        <label for="bidang_en_2" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                            <span class="fa fa-check" style="font-size: 16px"></span>
                                            <span></span>
                                        </label>
                                        <label for="bidang_en_2" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                            Production
                                        </label>
                                    </div>
                                </div><br>
                                <div class="form-group" onclick="bidang_3(1)" style="width: 80%; height: 35px">
                                    <input type="checkbox" name="bidang_en[]" {{$chck_bidang_3}} id="bidang_en_3" autocomplete="off" value="Post Production"/>
                                    <div class="btn-group" style="width: 100%; height: 100%;">
                                        <label for="bidang_en_3" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                            <span class="fa fa-check" style="font-size: 16px"></span>
                                            <span></span>
                                        </label>
                                        <label for="bidang_en_3" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                            Post Production
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form-group" onclick="bidang_1(2)" style="width: 80%; height: 35px">
                                    <input type="checkbox" name="bidang_ind[]" {{$chck_bidang_1}} id="bidang_ind" autocomplete="off" value="Pre Produksi"/>
                                    <div class="btn-group" style="width: 100%; height: 100%;">
                                        <label for="bidang_ind" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                            <span class="fa fa-check" style="font-size: 16px"></span>
                                            <span></span>
                                        </label>
                                        <label for="bidang_ind" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                            Pre Produksi
                                        </label>
                                    </div>
                                </div><br>
                                <div class="form-group" onclick="bidang_2(2)" style="width: 80%; height: 35px">
                                    <input type="checkbox" name="bidang_ind[]" {{$chck_bidang_2}} id="bidang_ind_2" autocomplete="off" value="Produksi"/>
                                    <div class="btn-group" style="width: 100%; height: 100%;">
                                        <label for="bidang_ind_2" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                            <span class="fa fa-check" style="font-size: 16px"></span>
                                            <span></span>
                                        </label>
                                        <label for="bidang_ind_2" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                            Produksi
                                        </label>
                                    </div>
                                </div><br>
                                <div class="form-group" onclick="bidang_3(2)" style="width: 80%; height: 35px">
                                    <input type="checkbox" name="bidang_ind[]" {{$chck_bidang_3}} id="bidang_ind_3" autocomplete="off" value="Pasca Produksi"/>
                                    <div class="btn-group" style="width: 100%; height: 100%;">
                                        <label for="bidang_ind_3" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                            <span class="fa fa-check" style="font-size: 16px"></span>
                                            <span></span>
                                        </label>
                                        <label for="bidang_ind_3" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                            Pasca Produksi
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" onclick="bidang_1(3)" style="width: 80%; height: 35px">
                                    <input type="checkbox" name="bidang_chn[]" {{$chck_bidang_1}} id="bidang_chn" autocomplete="off" value="预生产"/>
                                    <div class="btn-group" style="width: 100%; height: 100%;">
                                        <label for="bidang_chn" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                            <span class="fa fa-check" style="font-size: 16px"></span>
                                            <span></span>
                                        </label>
                                        <label for="bidang_chn" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                            预生产
                                        </label>
                                    </div>
                                </div><br>
                                <div class="form-group" onclick="bidang_2(3)" style="width: 80%; height: 35px">
                                    <input type="checkbox" name="bidang_chn[]" {{$chck_bidang_2}} id="bidang_chn_2" autocomplete="off" value="生产"/>
                                    <div class="btn-group" style="width: 100%; height: 100%;">
                                        <label for="bidang_chn_2" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                            <span class="fa fa-check" style="font-size: 16px"></span>
                                            <span></span>
                                        </label>
                                        <label for="bidang_chn_2" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                            生产
                                        </label>
                                    </div>
                                </div><br>
                                <div class="form-group" onclick="bidang_3(3)" style="width: 80%; height: 35px">
                                    <input type="checkbox" name="bidang_chn[]" {{$chck_bidang_3}} id="bidang_chn_3" autocomplete="off" value="后期制作"/>
                                    <div class="btn-group" style="width: 100%; height: 100%;">
                                        <label for="bidang_chn_3" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                            <span class="fa fa-check" style="font-size: 16px"></span>
                                            <span></span>
                                        </label>
                                        <label for="bidang_chn_3" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                            后期制作
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <label for="code" class="col-md-3"><b>Skills</b></label>
                            <div class="col-md-3">
                                <textarea class="form-control" autocomplete="off" name="skill_en" id="skill_en">{{$data->skill_en}}</textarea>
                            </div>
                            <div class="col-md-3">
                                <textarea class="form-control" autocomplete="off" name="skill_ind" id="skill_ind">{{$data->skill_ind}}</textarea>
                            </div>
                            <div class="col-md-3">
                                <textarea class="form-control" autocomplete="off" name="skill_chn" id="skill_chn">{{$data->skill_chn}}</textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <label for="code" class="col-md-3"><b>Experiences ( EN )</b></label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="experience_en" name="experience_en">{{$data->pengalaman_en}}</textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <label for="code" class="col-md-3"><b>Experiences ( IND )</b></label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="experience_ind" name="experience_ind">{{$data->pengalaman_ind}}</textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <label for="code" class="col-md-3"><b>Experiences ( CHN )</b></label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="experience_chn" name="experience_chn">{{$data->pengalaman_chn}}</textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <label for="code" class="col-md-3"><b>Links</b></label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="link" name="link">{{$data->link}}</textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <label for="code" class="col-md-3"><b>Show Services</b></label>
                            <div class="col-md-9">
                                <input type="checkbox" {{$chck}} data-toggle="toggle" data-on="Publish" data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya">
                                <input type="hidden" name="status" id="status" value="{{$data->status}}"> 
                            </div>
                        </div><br>
                        @if($data->status == 3)
                        <div class="row">
                            <label for="code" class="col-md-3"><b>This product was rejected due to</b></label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="keterangan" rows="5" style="color: black;" readonly>{{$data->keterangan}}</textarea>
                            </div>
                        </div><br>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div style="float: right;">
                                    <?php echo $button?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace('experience_en');
        CKEDITOR.replace('experience_ind');
        CKEDITOR.replace('experience_chn');
        CKEDITOR.replace('link');

        $("textarea").each(function () {
          this.style.height = (this.scrollHeight+10)+'px';
        });

        $('input').prop('disabled', true);
        $('textarea').prop('disabled', true);
    })
</script>

@include('footer')

@endsection