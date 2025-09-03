@extends('header2')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
  .select2-container .select2-selection--single {
		box-sizing: border-box;
		cursor: pointer;
		display: block;
		height: 45px !important;
	}
	.custom-select, .custom-file-control, .custom-file-control:before, select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
		height: 45px !important;
	}
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
  .button_form{width: 80px}
  input:read-only{ background-color:white !important}
  input:disabled{ background-color:white !important}
  input[type="text"], input[type="text"]:focus, input[type="file"], input[type="file"]:focus{
    border-color: #d6d9daad;
  }
  .form-group {
  margin-bottom: 0.5rem;
}

</style>
<?php 
  if($page == 'view'){
    $view = 'disabled';
    $id = $data->id;
  } else {
    $id = '';
    $view = '';
  }
?>
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
  <div class="col">
      <div class="card">
        <div class="card-header border-bottom">
            <h3 class="mb-0">@if($page == 'view') View @else Form @endif Market Research
        @if($page == 'view')<a href="{{route('admin.research-corner.index')}}" style="float: right;" class="btn btn-danger button_form"> Back</a><br><br>@endif</h3>
        </div>
        <div class="card-body">
                    <div class="col-md-12">
                        @if($page != 'view')
                        {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true, 'id' => 'form']) !!}
                        @endif<br>
                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-3">Title (EN)</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="title_en" autocomplete="off" required placeholder="Input" {{$view}} @isset($data) value="{{ $data->title_en }}" @endisset>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-3">Title (IN)</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="title_in" autocomplete="off" required placeholder="Input" {{$view}} @isset($data) value="{{ $data->title_in }}" @endisset>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-3">Cover</label>
                            <div class="col-md-7">
                                @if($page != 'view')
                                @if(isset( $data->cover))
                                <input type="file" class="form-control" name="cover" accept="image/*" {{$view}} @if($page=='create' ) @endif /><br>
                                <a href="{{ url('/').'/uploads/Market Research/Cover/'.$data->cover}}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Previous Cover</a><br>
                                @else
                                <input type="file" class="form-control" name="cover" accept="image/*" required {{$view}} @if($page=='create' ) @endif />
                                @endif
                                <input type="hidden" name="lastest_cover" @isset($data) value="{{ $data->cover }}" @endisset>
                                @else
                                <a href="{{ url('/').'/uploads/Market Research/Cover/'.$data->cover}}" target="_blank" class="btn btn-outline-secondary" style="width: 30%"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Cover</a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-3">Type</label>
                            <div class="col-md-7">
                                @if($page == 'view')
                                <input type="text" class="form-control" readonly value="{{rc_type($data->id_csc_research_type, 'en')}}">
                                @else
                                <select class="form-control" id="type" required name="type" {{$view}}>
                                    <option></option>
                                    @foreach($type as $val)
                                    <option value="{{$val->id}}" @isset($data) @if($data->id_csc_research_type == $val->id) selected @endif @endisset>{{$val->nama_en}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-3">Country</label>
                            <div class="col-md-7">
                                @if($page == 'view')
                                <input type="text" class="form-control" readonly value="{{rc_country($data->id_mst_country)}}">
                                @else
                                <select class="form-control" id="country" required name="country" {{$view}}>
                                    <option></option>
                                    @foreach($country as $val)
                                    <option value="{{$val->id}}" @isset($data) @if($data->id_mst_country == $val->id) selected @endif @endisset>{{$val->country}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-3">HS Code</label>
                            <div class="col-md-7">
                                @if($page == 'view')
                                <input type="text" class="form-control" readonly value="{{rc_hscodes($data->id_mst_hscodes)}}">
                                @else
                                <select class="form-control" id="code" required name="code" {{$view}}>
                                    <option></option>
                                </select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-3">Publish Date</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="date" name="date" placeholder="Date Time" autocomplete="off" {{$view}} @isset($data) value="{{ $data->publish_date }}" @endisset>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-3">File</label>
                            <div class="col-md-7">
                                @if($page != 'view')
                                @if(isset( $data->exum))
                                <input type="file" class="form-control" name="file" {{$view}} @if($page=='create' ) required @endif><br>
                                <a href="{{ url('/').'/uploads/Market Research/File/'.$data->exum}}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Previous Document</a><br>
                                @else
                                <input type="file" class="form-control" name="file" accept="image/*" required {{$view}} @if($page=='create' ) @endif />
                                @endif
                                <input type="hidden" name="lastest_file" @isset($data) value="{{ $data->exum }}" @endisset>
                                @else
                                <a href="{{ url('/').'/uploads/Market Research/File/'.$data->exum}}" target="_blank" class="btn btn-outline-secondary" style="width: 30%"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Document</a>
                                @endif
                            </div>
                        </div>

                        @if($page == 'view')
                        <br>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
                                    <thead class="text-white" style="background-color: #1089ff;">
                                        <tr>
                                            <th width="8%">No</th>
                                            <th>Company / Eksportir</th>
                                            <th>Download Date</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        @endif

                        @if($page != 'view')
                        <div class="form-group row">
                            <div class="col-md-11">
                                <div align="right">
                                    <a href="{{route('perwakilan.research-corner.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
                                    @if($page != 'view')
                                    <button class="btn btn-primary button_form" type="submit">Save</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        @endif
                    </div>
                </div>
      </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var page = "{{$page}}";

        if (page == 'view') {
            $('#table').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('perwakilan.research-corner.getDataDownload', $id)}}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'download_date',
                        name: 'download_date'
                    }
                ]
            });
        }

        $("#date").flatpickr({
            altInput: true,
            altFormat: "j F Y  ( H:i )",
            dateFormat: "Y-m-d H:i:ss",
            enableTime: true,
        });

        $('#type').select2({
            placeholder: 'Select Type'
        });

        $('#country').select2({
            placeholder: 'Select Country'
        });

        $('#code').select2({
            allowClear: true,
            placeholder: 'Select Code',
            ajax: {
                url: "{{route('admin.research-corner.hscode')}}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.fullhs + "  -  " + item.desc_eng,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        @isset($data)
        var hscode = "{{$data->id_mst_hscodes}}";
        if (hscode != null) {
            $.ajax({
                type: 'GET',
                url: "{{route('admin.research-corner.hscode')}}",
                data: {
                    code: hscode
                }
            }).then(function(data) {
                var option = new Option(data[0].desc_eng, data[0].id, true, true);

                $('#code').append(option).trigger('change');
            });
        }
        @endisset
    });
</script>
@include('footer')
@endsection