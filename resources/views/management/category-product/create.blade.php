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

        .custom-select,
        .custom-file-control,
        .custom-file-control:before,
        select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
            height: 35px !important;
        }

    </style>
    <?php
    if ($page == 'create') {
        $level2 = '|-|';
        $level1 = '';
        $id_data = '0';
    } else {
        $id_data = $data->id;
        if ($data->level_1 != '0') {
            $level1 = $data->level_1;
            if ($data->level_2 != '0') {
                $level1 = $data->level_1;
                $level2 = $data->level_2;
            } else {
                $level2 = '';
            }
        } else {
            $level1 = '';
            $level2 = '|-|';
        }
    }
    
    if ($page == 'view') {
        $view = 'disabled';
        if ($data->level_2 == '0') {
            $level2 = '|-|';
        }
    } else {
        $view = '';
    }
    ?>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">{{ $action }} Category Product</h3>
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
                    <br>
                    @if ($page != 'view')
                        {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
                    @endif
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-2 mt-2">Hierarchy</label>
                            <div class="col-md-7">
                                <select class="form-control select2" style="width: 100%" id="level_1" name="level_1"
                                    {{ $view }}>
                                    <option value="0"
                                        @isset($data) @if ($data->level_1 == '0') selected @endif
                                    @endisset>- Main Category -</option>
                                @foreach ($level_1 as $val)
                                    <option value="{{ $val->id }}"
                                        @isset($data) @if ($data->level_1 == $val->id) selected @endif
                                    @endisset>{{ $val->nama_kategori_en }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="input_level_2">
                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2 mt-2">Sub Hierarchy</label>
                        <div class="col-md-7">
                            <select class="form-control select2" style="width: 100%" id="level_2" name="level_2"
                                {{ $view }}>
                            </select>
                        </div>
                    </div>
                </div>
                {{-- <div id="input_level_2">
              <div class="form-group row">
              <div class="col-md-1"></div>
                  <label class="control-label col-md-2 mt-2">Sub Hierarchy</label>
                  <div class="col-md-7">
                      <select class="form-control select2" style="width: 100%" id="level_2" name="level_2" {{$view}}>
                      </select>
                  </div>
              </div>
            </div> --}}
                <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="control-label col-md-2 mt-2">Category Product (EN)</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="product_en" autocomplete="off" required
                            placeholder="Input" {{ $view }}
                            @isset($data) value="{{ $data->nama_kategori_en }}" @endisset>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="control-label col-md-2 mt-2">Category Product (IN)</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="product_in" autocomplete="off" required
                            placeholder="Input" {{ $view }}
                            @isset($data) value="{{ $data->nama_kategori_in }}" @endisset>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="control-label col-md-2 mt-2">Category Product (CHN)</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="product_chn" autocomplete="off"
                            placeholder="Input" {{ $view }}
                            @isset($data) value="{{ $data->nama_kategori_chn }}" @endisset>
                    </div>
                </div>
                {{-- <div class="form-group row">
            <div class="col-md-1"></div>
                <label class="control-label col-md-3">Type</label>
                <div class="col-md-7">
                    <select class="form-control" name="type" required {{$view}}>
                      <option value="" style="display: none;">- Select Type -</option>
                      <option value="-" @isset($data) @if ($data->type == '-') selected @endif @endisset>-</option>
                      <option value="Main Products" @isset($data) @if ($data->type == 'Main Products') selected @endif @endisset>Main Products</option>
                      <option value="Prespective Products" @isset($data) @if ($data->type == 'Prespective Products') selected @endif @endisset>Prespective Products</option>
                    </select>
                </div>
            </div> --}}

                <div class="form-group row" id="icon"
                    @isset($data) @if ($data->level_1 != '0') style="display:none;" @endif
                @endisset>
                <div class="col-md-1"></div>
                <label class="control-label col-md-2 mt-2">Icon</label>
                <div class="col-md-7">
                    <input type="file" class="form-control" name="icon" accept="image/*" {{ $view }}>
                </div>
                @isset($data->logo)
                    <input type="hidden" name="latest_icon" value="{{ $data->logo }}">
                    <div class="offset-md-3 col-md-7">
                        <a href="{{ asset('/uploads/Product/Icon/' . $data->logo) }}" target="_blank"
                            class="btn btn-outline-secondary"><i class="fa fa-download"
                                aria-hidden="true"></i>&nbsp;&nbsp;File Sebelumnya</a>
                    </div>
                @endisset
            </div>

            <div class="form-group row" id="banner">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2 mt-2">Banner</label>
                <div class="col-md-7">
                    <input type="file" class="form-control" name="banner" accept="image/*"
                        {{ $view }}>
                </div>
                @isset($data->banner)
                    <input type="hidden" name="latest_banner" value="{{ $data->banner }}">
                    <div class="offset-md-3 col-md-7">
                        <a href="{{ asset('/assets/assets/versi 1/' . $data->banner) }}" target="_blank"
                            class="btn btn-outline-secondary"><i class="fa fa-download"
                                aria-hidden="true"></i>&nbsp;&nbsp;File Sebelumnya</a>
                    </div>
                @endisset
            </div>

            <div class="form-group row" id="input_keyword" style="display: none;">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2 mt-2">Keyword</label>
                <div class="col-md-7">
                    <textarea value="" name="keyword" id="keyword"
                        class="form-control">@isset($data){{ $data->keyword }}@endisset</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-10">
                        <div align="right">
                            <a href="{{ route('management.category-product.index') }}"
                                class="btn btn-danger button_form">
                                @if ($page != 'view')
                                Cancel @else Back
                                @endif
                            </a>
                            @if ($page != 'view')
                                <button class="btn btn-primary button_form" type="submit">Submit</button>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($page != 'view')
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
        var level1 = "{{ $level1 }}";
        var level2 = "{{ $level2 }}";
        var update = "{{ $id_data }}";

        if (level2 == '|-|') {
            $('#input_level_2').css('display', 'none');
        } else {
            var id = "{{ $level1 }}";
            $.ajax({
                url: "{{ route('management.category-product.level2') }}",
                type: 'get',
                data: {
                    id: id,
                    except: update
                },
                dataType: 'json',
                success: function(response) {
                    $('#level_2').append(response);
                    if (level2 != 0) {
                        $('#level_2').val(level2);
                    } else {
                        $('#level_2').val(0);
                    }
                    $('#level_2').trigger('change');
                }
            });
        }

        $('#level_1').on('change', function() {
            var data = this.value;
            $('#level_2').empty().trigger("change");
            $("#first").prop("disabled", true);
            if (data != '0') {
                $.ajax({
                    url: "{{ route('management.category-product.level2') }}",
                    type: 'get',
                    data: {
                        id: data,
                        except: update
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#level_2').append(response);
                    }
                });
                $('#input_level_2').show('fast');
                $('#icon').hide('fast');
            } else {
                $('#icon').show('fast');
                $('#input_level_2').hide('fast');
            }
        });

        $('#level_2').on('change', function() {
            var data = this.value;
            console.log(data);
            if (data > 0) {
                $('#input_keyword').show('fast');
            } else {
                $('#input_keyword').hide('fast');
            }
        });

    });
</script>

@include('footer')
@endsection
