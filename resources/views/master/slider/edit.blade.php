{{-- @include('header') --}}
<style type="text/css">
  .button_form{width: 80px}
  input[type="text"], input[type="text"]:focus{
    border-color: #d6d9daad;
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
</style>
<?php 
  if($page == 'view'){
    $view = 'disabled';
  } else {
    $view = '';
  }
?>

@extends('header2')
@section('content')

{{-- <div class="padding"> --}}
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header border-bottom">
          <h3 class="mb-0">Edit Slide</h3>
      </div>
      	 <div class="box-body">
          <div class="col-md-12">
          <form class="form-horizontal" method="POST" action="{{ url('update-slider') }}" enctype="multipart/form-data">
           {{ csrf_field() }}<br>
		   
		   <?php 
		   $cq = DB::select("select * from mst_slide where id='".$id."'");
		   foreach($cq as $qc){
		   ?>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-2">File Image</label>
                 <div class="col-md-7">
                    <img src="{{asset('uploads/slider')}}{{ "/".$qc->file_img }}" width="200px"><br><br>
                    <input type="hidden" name="last_file" id="last_file" value="{{ $qc->file_img }}">
                    <input type="hidden" name="idnya" id="idnya" value="{{ $qc->id }}">
                    <input type="file" class="form-control" id="file_img" name="file_img">
                 </div>
             </div> 
			 
			      <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-2 mt-2">Note</label>
                 <div class="col-md-7">
                     <textarea class="form-control" id="keterangan" name="keterangan">{{ $qc->keterangan }}</textarea>
                 </div>
             </div>
			 
			      <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-2 mt-2">Publish</label>
                 <div class="col-md-2">
                     <select class="form-control" name="publish" id="publish">
                      <option value="1" <?php if($qc->publish == 1){ echo "selected"; } ?>>Yes</option>
                      <option value="0" <?php if($qc->publish == 0){ echo "selected"; } ?>>No</option>
                    </select>
                 </div>
            </div>
        
             <div class="form-group row">
                <div class="col-md-10">
                  <div align="right">
                    @if($page != 'view')
                    <button class="btn btn-primary button_form" type="submit">Save</button>
                    @endif
                    <a href="{{url('master-slide')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else <i class="fas fa-arrow-circle-left"></i> Back @endif</a>
                  </div>
                </div>
             </div>
		   <?php } ?>
          </form>
          </div>
      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')
<script type="text/javascript">
  $(document).ready(function () {

    $('.select2').select2({
      placeholder: 'Select Province'
    });

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

    $("#kode_port").focus(function(){}).blur(function(){
      var kode = $('#kode_port').val();
      var kode2 = $('#kode2').val();
      $.ajax({
          url: "{{route('master.port.kode')}}",
          type: 'get',
          data: {kode:kode},
          dataType: 'json',
          success:function(response){
            if(response != null) {
              if(kode2 != kode){
                alert('ID have been used in other Port !');
                $('#kode_port').val('');
              }
            }
          }
      });
    });

  });
</script>

@endsection