@include('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style type="text/css">
  .button_form{width: 80px}
  input:read-only{ background-color:white !important}
  input:disabled{ background-color:white !important}
  input[type="text"], input[type="text"]:focus, input[type="file"], input[type="file"]:focus{
    border-color: #d6d9daad;
  }
</style>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">View</h4>
         </div>
      	 <div class="box-body">
          <div class="col-md-12">
            <br>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Title (EN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="title_en" autocomplete="off" required placeholder="Input" readonly value="{{ $data->title_en }}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Title (IN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="title_in" autocomplete="off" required placeholder="Input" readonly value="{{ $data->title_in }}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Type</label>
                 <div class="col-md-7">
                    <input type="text" class="form-control" readonly value="{{rc_type($data->id_csc_research_type,'en')}}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Country</label>
                 <div class="col-md-7">
                    <input type="text" class="form-control" readonly value="{{rc_country($data->id_mst_country)}}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">HS Code</label>
                 <div class="col-md-7">
                    <input type="text" class="form-control" readonly value="{{rc_hscodes($data->id_mst_hscodes)}}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Publish Date</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" id="date" name="date" placeholder="Date Time" autocomplete="off" disabled value="{{ $data->publish_date }}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">File</label>
                 <div class="col-md-7">
                      <a href="{{ url('/').'/uploads/Market Research/File/'.$data->exum}}" id="download" class="btn btn-outline-secondary" style="width: 30%"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Document</a>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-4"></div>
                <div class="col-md-7">
                  <div align="right">
                    <a href="{{route('research-corner.index')}}" class="btn btn-danger button_form">Back</a>
                  </div>
                </div>
             </div>

          </div>
      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')
<script type="text/javascript">
  $(document).ready(function () {
    $('#download').on('click', function(e) {
      e.preventDefault(); 
      $.ajax({
            url: "{{route('research-corner.download')}}",
            type: 'get',
            data: {id:"{{$data->id}}"},
            dataType: 'json',
            success:function(response){
              if(response){
                window.open($('#download').attr('href'), '_blank');
              }
            }
        });
    });

    $("#date").flatpickr({
      altInput: true,
      altFormat: "j F Y  ( H:i )",
      dateFormat: "Y-m-d H:i:ss",
      enableTime: true,
    });
  });
</script>