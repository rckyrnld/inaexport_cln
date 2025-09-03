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

  .custom-select,
  .custom-file-control,
  .custom-file-control:before,
  select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
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

  .button_form {
    width: 80px
  }

  input:read-only {
    background-color: white !important
  }

  input:disabled {
    background-color: white !important
  }

  input[type="text"],
  input[type="text"]:focus,
  input[type="file"],
  input[type="file"]:focus {
    border-color: #d6d9daad;
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

  <!-- Select Category -->
  <div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="catModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="catModalLabel">Click Here to Select Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="col-sm-4">
              <div class="col-sm-12">
                <label><b>@lang("login.forms.by3") (<font color="red">*</font>)</b></label>
              </div>
              <div class="form-group col-sm-12" style="font-size: 12px !important;">
                <?php
                          $ms1 = DB::select("select id,nama_kategori_en from csc_product where level_1 = 0 and level_2 = 0 order by nama_kategori_en asc");
                          ?>
                <select style="color:black;font-size: 12px !important; " size="13" class="column J-noselect"
                  name="category[]" id="category" onchange="t1()" required form="form_br">
                  <option value="">@lang("login.forms.by11")</option>
                  <?php foreach ($ms1 as $val1) { ?>
                  <option value="{{ $val1->id }}">{{ $val1->nama_kategori_en }}</option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div id="t2">
                <input type="hidden" name="t2s" id="t2s" value="0" form="form_br">
              </div>
            </div>
            <div class="col-sm-4">
              <div id="t3">
                <input type="hidden" name="t3s" id="t3s" value="0" form="form_br">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary mr-auto rounded" data-dismiss="modal">Confirm</button>
        </div>
      </div>
    </div>
  </div>
  <!--select category end-->

  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header border-bottom">
          <h3 class="mb-0">@if($page == 'view') View @else Form @endif Market Research
            @if($page == 'view')<a href="{{route('admin.research-corner.index')}}" style="float: right;"
              class="btn btn-danger button_form"> Back</a><br><br>@endif</h3>
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
          {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true, 'id' => 'form']) !!}
          @endif<br>
          <div class="form-group row">
            <div class="col-md-1"></div>
            <label class="control-label col-md-1 mt-2">Title (EN)</label>
            <div class="col-md-4">
              <input type="text" class="form-control" name="title_en" autocomplete="off" required placeholder="Input"
                {{$view}} @isset($data) value="{{ $data->title_en }}" @endisset>
            </div>
            <label class="control-label col-md-1 mt-2">Title (IN)</label>
            <div class="col-md-4">
              <input type="text" class="form-control" name="title_in" autocomplete="off" required placeholder="Input"
                {{$view}} @isset($data) value="{{ $data->title_in }}" @endisset>
            </div>
            <div class="col-md-1"></div>
          </div>

          <div class="form-group row">
            <div class="col-md-1"></div>
            <label class="control-label col-md-1 mt-2">Type</label>
            <div class="col-md-4">
              @if($page == 'view')
              <input type="text" class="form-control" readonly value="{{rc_type($data->id_csc_research_type, 'en')}}">
              @else
              <select class="form-control" id="type" required name="type" {{$view}}>
                <option></option>
                @foreach($type as $val)
                <option value="{{$val->id}}" @isset($data) @if($data->id_csc_research_type == $val->id) selected @endif
                  @endisset>{{$val->nama_en}}</option>
                @endforeach
              </select>
              @endif
            </div>

            <label class="control-label col-md-1 mt-2">Country</label>
            <div class="col-md-4">
              @if($page == 'view')
              <input type="text" class="form-control" readonly value="{{rc_country($data->id_mst_country)}}">
              @else
              <select class="form-control" id="country" required name="country" {{$view}}>
                <option></option>
                @foreach($country as $val)
                <option value="{{$val->id}}" @isset($data) @if($data->id_mst_country == $val->id) selected @endif
                  @endisset>{{$val->country}}</option>
                @endforeach
              </select>
              @endif
            </div>
            <div class="col-md-1"></div>
          </div>

          <div class="form-group row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><label><b>Product Category</b></label></div><br>
            <div class="col-md-4">
              @php
              if($page == 'edit'){
              $arr = explode(',', $data->category);
              $cat = (isset($arr[0]) && $arr[0] != '') ? DB::table('csc_product')->where('id',
              $arr[0])->first()->nama_kategori_en : '';
              $lvl1 = (isset($arr[1]) && $arr[1] != '') ? ' » '. DB::table('csc_product')->where('id',
              $arr[1])->first()->nama_kategori_en : '';
              $lvl2 = (isset($arr[2]) && $arr[2] != '') ? ' » '. DB::table('csc_product')->where('id',
              $arr[2])->first()->nama_kategori_en : '';
              }
              @endphp

              @if($page == 'view')
              <a id="labelcat" href="#">
                {{($page == 'edit' && ($cat != '' || $lvl1 != '' || $lvl2 != '')) ? $cat.$lvl1.$lvl2 : ''}}
              </a>
              @else
              <a data-toggle="modal" data-target="#catModal" id="labelcat" href="#">
                {{($page == 'edit' && ($cat != '' || $lvl1 != '' || $lvl2 != '')) ? $cat.$lvl1.$lvl2 : 'Click here to
                select'}}
              </a>
              @endif

              <input type="hidden" name="val_category" id="val_category" value="">
              <span id="select_1"></span>
              <input type="hidden" name="id_csc_product" id="id_csc_product"
                value="@if($page == 'edit') {{(isset($arr[0])) ? $arr[0] : 0}} @endif">
              <span id="select_2"></span>
              <input type="hidden" name="id_csc_product_level1" id="id_csc_product_level1"
                value="@if($page == 'edit') {{(isset($arr[1])) ? $arr[1] : 0}} @endif">
              <span id="select_3"></span>
              <input type="hidden" name="id_csc_product_level2" id="id_csc_product_level2"
                value="@if($page == 'edit') {{(isset($arr[2])) ? $arr[2] : 0}} @endif">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-1"></div>
            <label class="control-label col-md-1 mt-2">HS Code</label>
            <div class="col-md-9">
              @if($page == 'view')
              @if($data->id_mst_hscodes)
              <input type="text" class="form-control" readonly value="{{rc_hscodes($data->id_mst_hscodes)}}">
              @else
              <input type="text" class="form-control" readonly value="">
              @endif
              @else
              <select class="form-control" id="code" name="code" {{$view}}></select>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-1"></div>
            <label class="control-label col-md-1 mt-2">Cover</label>
            <div class="col-md-4">
              @if($page != 'view')
              @if(isset( $data->cover))
              <input type="file" class="form-control upload1" name="cover" accept="image/*" {{$view}}
                @if($page=='create' ) @endif /><br>
              <a href="{{ url('/').'/uploads/Market Research/Cover/'.$data->cover}}" target="_blank"
                class="btn btn-outline-secondary"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Previous
                Cover</a><br>
              @else
              <input type="file" class="form-control upload1" name="cover" accept="image/*" required {{$view}}
                @if($page=='create' ) @endif />
              @endif
              <input type="hidden" name="lastest_cover" @isset($data) value="{{ $data->cover }}" @endisset>
              @else
              <a href="{{ url('/').'/uploads/Market Research/Cover/'.$data->cover}}" target="_blank"
                class="btn btn-outline-secondary" style="width: 30%"><i class="fa fa-download"
                  aria-hidden="true"></i>&nbsp;&nbsp;Cover</a>
              @endif
            </div>

            <label class="control-label col-md-1 mt-2">File</label>
            <div class="col-md-4">
              @if($page != 'view')
              @if(isset( $data->exum))
              <input type="file" class="form-control upload1" name="file" {{$view}} @if($page=='create' ) required
                @endif><br>
              <a href="{{ url('/').'/uploads/Market Research/File/'.$data->exum}}" target="_blank"
                class="btn btn-outline-secondary"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Previous
                Document</a><br>
              @else
              <input type="file" class="form-control upload1" name="file" required accept="image/*" {{$view}}
                @if($page=='create' ) @endif />
              @endif
              <input type="hidden" name="lastest_file" @isset($data) value="{{ $data->exum }}" @endisset>
              @else
              <a href="{{ url('/').'/uploads/Market Research/File/'.$data->exum}}" target="_blank"
                class="btn btn-outline-secondary" style="width: 30%"><i class="fa fa-download"
                  aria-hidden="true"></i>&nbsp;&nbsp;Document</a>
              @endif
            </div>
            <div class="col-md-1"></div>
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
                    <th>Company</th>
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
            <div class="col-md-10">
              <div align="right">
                <a href="{{route('admin.research-corner.index')}}" class="btn btn-danger button_form">@if($page !=
                  'view') Cancel @else Back @endif</a>
                @if($page != 'view')
                <button class="btn btn-primary button_form" type="button" id="simpan">Submit</button>
                <button class="btn btn-primary button_form" type="submit" id="save"
                  style="display: none;">Submit</button>
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
    $('.upload1').on('change', function(evt){
        var size = this.files[0].size;
        if(size > 5000000){
        //     if(size > 20000){
            $(this).val("");
            alert('image size must less than 5MB');
        }
        else{

        }
    });

  $(document).ready(function () {
    var page = "{{$page}}";
    
    if(page == 'view'){
      $('#table').dataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('admin.research-corner.getDataDownload', $id)}}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'company', name: 'company'},
              {data: 'download_date', name: 'download_date'}
          ],
          "language": {
              "paginate": {
                  "previous": "<i class='fa fa-angle-left'/></>",
                  "next": "<i class='fa fa-angle-right'/></>"
              }
          }
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

    // $('#code').select2({
    //   placeholder: 'Select Code'
    // });

    $('#code').select2({
      allowClear: true,
      placeholder: 'Select Code',
      ajax: {
        url: "{{route('admin.research-corner.hscode')}}",
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.fullhs + "  -  " + item.desc_eng,
                // text: item.desc_eng ,
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
    if (hscode != "") {
        $.ajax({
            type: 'GET',
            url: "{{route('admin.research-corner.hscode')}}",
            data: { code: hscode }
        }).then(function (data) {
            console.log(hscode);
                var option = new Option( data[0].fullhs+ " - " +data[0].desc_eng, data[0].id, true, true);

            // var option = new Option(data[0].desc_eng, data[0].id, true, true);

            $('#code').append(option).trigger('change');
        });
    }
    else{
        $('#code').select2({
            allowClear: true,
            placeholder: 'Select Code',
            ajax: {
                url: "{{route('admin.research-corner.hscode')}}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.fullhs + "  -  " + item.desc_eng,
                                // text: item.desc_eng ,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    }
    @endisset
  });
  $('#simpan').on('click',function (e) {
    e.preventDefault();
    if($('#date').val() == ""){
        alert('please complete the date field');
        {{--$.ajax({--}}
        {{--    type: "POST",--}}
        {{--    url: '{{url('/admin/research-corner/store/Create')}}',--}}
        {{--    data: { :company,username:username,email:email,website:website,phone:phone,fax:fax,password:password,city:city,prov:prov,postcode:postcode,alamat:alamat,_token:'{{csrf_token()}}' },--}}
        {{--    success: function (data) {--}}
        {{--        console.log(data);--}}
        {{--    },--}}
        {{--    error: function (data, textStatus, errorThrown) {--}}
        {{--        console.log(data);--}}
        {{--    },--}}
        {{--});--}}
    }
    else{
        $("#save").click();

    }
  })

  function catLabel() {
      var text = 'Select Category';
      var category = $('#category option:selected').text();
      var categoryval = $('#category option:selected').val();
      if (category != '') {
          text = category;
          $('#id_csc_product').val(categoryval);
          var cat1 = $('#t2s option:selected').text();
          var cat1val = $('#t2s option:selected').val();
          if (cat1 != '') {
              text += ' » ' + cat1;
              $('#id_csc_product_level1').val(cat1val);
          }
          var cat2 = $('#t3s option:selected').text();
          var cat2val = $('#t3s option:selected').val();
          if (cat2 != '') {
              text += ' » ' + cat2;
              $('#id_csc_product_level2').val(cat2val);
          }
      }

      $('#labelcat').html(text);
  }

  function t1() {
      $('#t2').html('');
      $('#t3').html('');
      $('#id_csc_product_level1').val('');
      $('#id_csc_product_level2').val('');
      var t1 = $('#category').val();
      var token = $('meta[name="csrf-token"]').attr('content');
      $.get('{{URL::to("ambilt2/")}}/' + t1, {
          _token: token
      }, function(data) {
          $("#t2").html(data);
          $("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0" size="13" class="column J-noselect">');
          // $('.select2').select2();
      })
      catLabel();
  }

  function t2() {
      $('#t3').html('');
      $('#id_csc_product_level2').val('');
      var t2 = $('#t2s').val();
      var token = $('meta[name="csrf-token"]').attr('content');
      $.get('{{URL::to("ambilt3/")}}/' + t2, {
          _token: token
      }, function(data) {
          $("#t3").html(data);
          // $('.select2').select2();
      })
      catLabel()
  }

  function t3() {
      catLabel();
  }
  </script>
  @include('footer')
  @endsection