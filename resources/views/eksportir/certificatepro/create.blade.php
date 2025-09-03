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
                <h3 class="mb-0">Form Sertifikat Produk</h3>
            </div>
            <div class="card-body mt--3">
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

                  @if($page != 'view')
                    {!! Form::open(['url' => $url, 'class' => 'form-horizontal mt--3', 'files' => true]) !!}
                  @endif<br>

                  <div class="form-row">
                    <div class="form-group col-sm-3 mb-2">
                        <label><b>Produk</b></label>
                        @if($page != 'view')
                            @if($page == 'edit')
                                <select class="form-control" id="prodname_en" name="prodname_en" required>
                                    @foreach($produk as $pro)
                                        <option value="{{ $pro->id }}" {{ $data->id_produk == $pro->id ? 'selected' : '' }}>{{ $pro->prodname_en }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="atc form-control select2" required id="prodname_en" name="prodname_en">
                                    <option value="">- Choose Produk -</option>
                                    @foreach ($produk as $pro)
                                        <option value="{{ $pro->id }}">{{ $pro->prodname_en }}</option>
                                    @endforeach
                                </select>
                            @endif
                        @else
                        <select disabled class="form-control" id="prodname_en" name="prodname_en" required>
                            @foreach($produk as $pro)
                                <option value="{{ $pro->id }}" {{ $data->id_produk == $pro->id ? 'selected' : '' }}>{{ $pro->prodname_en }}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                </div>

                {{-- @if($page == 'edit')
                  <div class="form-row">
                    <div class="form-group col-sm-3 mb-2">
                        <select class="form-control" id="prodname_en" name="prodname_en" required>
                            @foreach($produk as $pro)
                                <option value="{{ $pro->id }}" >{{ $pro->prodname_en }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                @endif --}}

                  <div class="form-row ">
                    <div class="form-group col-sm-3 mb-2">
                        <label class="control-label font-weight-bold">Nama Sertifikat</label>
                        <input type="text" class="form-control" name="nama" required {{$view}} @isset($data) value="{{ $data->nama }}" @endisset style="border-color: #d1d1d1;">
                    </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-sm-3 mb-2">
                      <label class="control-label font-weight-bold">Upload Gambar</label>
                      @if($page != 'view')
                        <input type="file" class="form-control" name="file" {{$view}} style="border-color: #d1d1d1;" accept="image/x-png,image/gif,image/jpeg">
                      @else
                    
                        @if($data->file)
                        <div class="form-group col-sm-3 mb-2">
                            <a href="{{ url('/').'/uploads/CertificatePro/'.$data->id_itdp_profil_eks. '/' .$data->file}}" target="_blank" class="ml--3 btn btn-outline-secondary" style="border-color: #d1d1d1;">
                            <i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Latest Image</a>
                        </div>
                        @else
                        <button type="button" class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;" disabled>No Image</button>
                        @endif
                      @endif
                  </div>
              </div>
                 
                @if($page == 'edit')
                  @if($data->file)
                  <div class="form-row">
                    <div class="form-group col-sm-2 mb-2">
                        <a href="{{ url('/').'/uploads/CertificatePro/'.$data->id_itdp_profil_eks. '/' .$data->file}}" target="_blank" class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;">
                            <i class="fa fa-download" aria-hidden="true"></i></a>
                            <input type="hidden" name="lastest_file" value="{{$data->file}}">
                    </div>
                  </div>
                  @endif
                @endif

              <div class="form-row">
                <div class="form-group col-sm-3 mb-2">
                    <label class="control-label font-weight-bold">Kategori</label>
                    <input type="text" class="form-control" name="kategori" required {{$view}} @isset($data) value="{{ $data->kategori }}" @endisset style="border-color: #d1d1d1;">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-3 mb-2">
                    <label class="control-label font-weight-bold">Nomor Referensi</label>
                    <input type="text" class="form-control" name="no_ref" required {{$view}} @isset($data) value="{{ $data->no_ref }}" @endisset style="border-color: #d1d1d1;">
                </div>
            </div>

            <br>
            <div class="form-row rightbtn">
                <div class="form-group col-sm-12">
                    <a style="color: white" href="{{ URL::previous() }}" class="btn btn-danger"><i
                            style="color: white"></i>
                        Back
                    </a>
                    <button class="btn btn-primary" type="submit"> Submit
                    </button>
                </div>
            </div>
            

              </div>
          </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    
  });
</script>

@include('footer')
@endsection