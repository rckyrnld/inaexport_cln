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
    .button_form {
      width: 80px
    }

    .select2-container .select2-selection--single {
      box-sizing: border-box;
      cursor: pointer;
      display: block;
      height: 35px !important;
    }
    .custom-select, .custom-file-control, .custom-file-control:before, select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
      height: 35px !important;
    }
</style>
<?php 
  if($page == 'view'){
    $view = 'disabled';
  } else {
    $view = '';
  }
?>
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-bottom">
                <h3 class="mb-0">Add Country</h3>
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
                @if($page != 'view')
                  {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
                @endif
                <div class="card-body">
                  <div class="form-group row mb-2">
                    <div class="col-md-1"></div>
                      <label class="control-label col-md-1 my-auto">Group</label>
                      <div class="col-md-7">
                        <select class="form-control" required name="group" {{$view}}>
                          <option>Select Group</option>
                            @foreach($country_group as $val)
                            <option value="{{$val->id}}" @isset($data) @if($data->mst_country_group_id == $val->id) selected @endif  @endisset>{{$val->group_country}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                  <div class="form-group row mb-2">
                    <div class="col-md-1"></div>
                      <label class="control-label col-md-1 my-auto">Region</label>
                      <div class="col-md-7">
                          <select class="form-control" required name="region" {{$view}}>
                            <option style="display: none;" value="">Select Region</option>
                              @foreach($country_region as $val)
                              <option value="{{$val->id}}" @isset($data) @if($data->mst_country_region_id == $val->id) selected @endif @endisset>{{$val->name}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="form-group row mb-2">
                    <div class="col-md-1"></div>
                      <label class="control-label col-md-1 my-auto">Kode BPS</label>
                      <div class="col-md-7">
                          <input type="text" class="form-control integer" id="kode" autocomplete="off" required name="kode_bps" placeholder="Input" {{$view}} @isset($data) value="{{ $data->kode_bps }}" @endisset>
                          <input type="hidden" id="kode2" @isset($data) value="{{ $data->kode_bps }}" @endisset>
                      </div>
                  </div>

                  <div class="form-group row mb-2">
                    <div class="col-md-1"></div>
                      <label class="control-label col-md-1 my-auto">Country</label>
                      <div class="col-md-7">
                          <input type="text" class="form-control" name="country" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->country }}" @endisset>
                      </div>
                  </div>

                  <div class="form-group row mb-2 offset-sm-2">
                    <div class="col-md-11">
                      <div align="left">
                        @if($page != 'view')
                        <button class="btn btn-primary button_form" type="submit">Save</button>
                        @endif
                        <a href="{{route('master.country.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else<i class="fas fa-arrow-circle-left"></i> Back @endif</a>
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
  $(document).ready(function() {
    $('.integer').inputmask({
        alias:"integer",
        repeat:3,
        digitsOptional:false,
        decimalProtect:false,
        radixFocus:true,
        autoUnmask:false,
        allowMinus:false,
        rightAlign:false,
        clearMaskOnLostFocus: false,
        onBeforeMask: function (value, opts) {
            return value;
        },        removeMaskOnSubmit:true
    });

    $("#kode").focus(function(){}).blur(function(){
      var kode = $('#kode').val();
      var kode2 = $('#kode2').val();
      $.ajax({
          url: "{{route('master.country.kode')}}",
          type: 'get',
          data: {kode:kode},
          dataType: 'json',
          success:function(response){
            if(response != null) {
              if(kode2 != kode){
                alert('Code have been used in other Country !');
                $('#kode').val('');
              }
            }
          }
      });
    });
    $('select').select2();
  });
</script>

@include('footer')

@endsection