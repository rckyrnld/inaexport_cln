@extends('header2')
@section('content')
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

    .button_form{width: 120px}
    input[type="text"], input[type="text"]:focus{
      border-color: #dce5e8;
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
<?php 
  $view = ''; $all_chck = ''; $prov_chck = ''; $cat_chck = '';
  $display_prov = 'none'; $display_cat = 'none';
  $req_prov = ''; $req_cat = '';
  if($page == 'view'){ $view = 'disabled'; } 
  if(isset($data->status)){
    if($data->status == '0'){
        $all_chck = 'checked="true"';
    }else{
        $all_chck = 'checked="false"';
    }
  }
?>

{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-bottom">
                <h3 class="mb-0">Form Slideshows</h3>
            </div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block" style="text-align: center">
                        {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block" style="text-align: center">
                        {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="card-body">
                  @if($page != 'view')
                    {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
                  @endif<br>
                  <div class="form-group row">
                    <div class="col-md-1"></div>
                      <label class="control-label col-md-2 mt-2">Judul</label>
                      <div class="col-md-7">
                          <input type="text" class="form-control" name="judul" required {{$view}} @isset($data) value="{{ $data->judul }}" @endisset style="border-color: #d1d1d1;">
                      </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-1"></div>
                      <label class="control-label col-md-2 mt-2">Upload Gambar</label>
                      <div class="col-md-7">
                        @if($page != 'view')
                          <input type="file" class="form-control" name="file" {{$view}} style="border-color: #d1d1d1;" accept="image/x-png,image/gif,image/jpeg">
                        @else
                          @if($data->nama)
                          <a href="{{ url('/').'/image/slide/'.$data->nama}}" target="_blank" class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Latest File</a>
                          @else
                          <button type="button" class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;" disabled>No File</button>
                          @endif
                        @endif
                      </div>
                  </div>

                  @if($page == 'edit')
                    @if($data->nama)
                    <div class="form-group row">
                      <div class="col-md-1"></div>
                        <label class="control-label col-md-2"></label>
                        <div class="col-md-7">
                            <a href="{{ url('/').'/image/slide/'.$data->nama}}" target="_blank" class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Latest File</a>
                            <input type="hidden" name="lastest_file" value="{{$data->nama}}">
                        </div>
                    </div>
                    @endif
                  @endif

                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-md-1"></div>
                      <label class="control-label col-md-2 mt-2">Status</label>
                      <div class="col-md-2">
                        <div class="form-group" style="width: 100%; height: 35px">
                            @if($page != 'create')
                                <input type="checkbox" name="send_to[]" {{$all_chck}} onclick="send_to(this)" id="to_all" autocomplete="off" @isset($data) value="{{$data->status}}" @endisset {{ $view }} />
                            @else
                              <input type="checkbox"  name="send_to[]" {{$all_chck}} onclick="send_to(this)" id="to_all" autocomplete="off" value="0" checked="true"/>
                            @endif
                          
                            <div class="btn-group" style="width: 100%; height: 100%">
                                <label for="to_all" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 30%; height: 100%;">
                                    <span class="fa fa-check" style="font-size: 16px;"></span>
                                    <span></span>
                                </label>
                                <label for="to_all_2" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 70%; height: 100%;">
                                    Aktif
                                </label>
                            </div>
                        </div>
                      </div>                    
                  </div>
                  <div class="form-group row">
                    <div class="col-md-11">
                      <div align="right">
                          @if($page != 'view')
                          <button class="btn btn-primary button_form" type="submit" style="margin-right: 20px">Submit</button>
                          @endif
                          <a href="{{route('slideshows.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
                      </div>
                    </div>
                  </div>
                  @if($page != 'view')
                    {!! Form::close() !!}
                  @endif
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2e899e; color:white;">
                <h6>Broadcast Buying Request</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div id="isibroadcast"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    CKEDITOR.replace('slideshows');
    @isset($data)
      @if($data->status == '1')
            $("[name='send_to']").prop("checked", false);
            $("label[for = to_all_2]").text("Non Aktif");  
      @endif
    @endisset

    $("textarea").each(function () {
      this.style.height = (this.scrollHeight+10)+'px';
    });
    
  });

  function send_to(obj){
    switch(obj.value){
      case '0': 
        if(obj.checked == true){
          $("label[for = to_all_2]").text("Aktif");  
        }else{
          $("label[for = to_all_2]").text("Non Aktif");  
        }
        break;
      case 'N': 
        if(obj.checked == true){
          $("label[for = to_all_2]").text("Aktif");  
        }else{
          $("label[for = to_all_2]").text("Non Aktif");  
        }
        break;      
    }
  }
</script>

@include('footer')

@endsection
