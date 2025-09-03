@extends('header2')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
  body {
      font-family: Arial;
  }

  .form-group{
		margin-bottom: 0.5rem;
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
  .button_form{width: 80px}
  input:read-only{ background-color:white !important}
  input:disabled{ background-color:white !important}
  input[type="text"], input[type="text"]:focus, input[type="file"], input[type="file"]:focus{
    border-color: #d6d9daad;
  }

</style>
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header border-bottom">
        <h3 class="mb-0">View Market Research</h3>
      </div>
      <div class="card-body">
        <div class="form-group row">
          <div class="col-md-1"></div>
            <label class="control-label col-md-2">Title (EN)</label>
            <div class="col-md-7">
              <input type="text" class="form-control" name="title_en" autocomplete="off" required placeholder="Input" readonly value="{{ $data->title_en }}">
            </div>
        </div>

        <div class="form-group row">
          <div class="col-md-1"></div>
              <label class="control-label col-md-2">Title (IN)</label>
              <div class="col-md-7">
                  <input type="text" class="form-control" name="title_in" autocomplete="off" required placeholder="Input" readonly value="{{ $data->title_in }}">
              </div>
        </div>

        <div class="form-group row">
          <div class="col-md-1"></div>
              <label class="control-label col-md-2">Type</label>
              <div class="col-md-7">
                <input type="text" class="form-control" readonly value="{{rc_type($data->id_csc_research_type,'en')}}">
              </div>
        </div>

        <div class="form-group row">
          <div class="col-md-1"></div>
              <label class="control-label col-md-2">Country</label>
              <div class="col-md-7">
                <input type="text" class="form-control" readonly value="{{rc_country($data->id_mst_country)}}">
              </div>
        </div>

        <div class="form-group row">
          <div class="col-md-1"></div>
              <label class="control-label col-md-2">HS Code</label>
              <div class="col-md-7">
                <input type="text" class="form-control" readonly value="{{rc_hscodes($data->id_mst_hscodes)}}">
              </div>
        </div>
        
        <div class="form-group row">
          <div class="col-md-1"></div>
            <label class="control-label col-md-2">Publish Date</label>
            <div class="col-md-7">
                <input type="text" class="form-control" id="date" name="date" placeholder="Date Time" autocomplete="off" disabled value="{{ $data->publish_date }}">
            </div>
        </div>

        <div class="form-group row">
          <div class="col-md-1"></div>
              <label class="control-label col-md-2">File</label>
              <div class="col-md-7">
                  <a href="{{ url('/').'/uploads/Market Research/File/'.$data->exum}}" id="download" class="btn btn-secondary" style="width: 30%"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Document</a>
              </div>
        </div>

        <div class="form-group row">
          <div class="col-md-3"></div>
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

@include('footer')

@endsection