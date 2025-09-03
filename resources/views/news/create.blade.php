{{-- @include('header') --}}
<style type="text/css">
    .button_form {
        width: 120px
    }

    input[type="text"],
    input[type="text"]:focus {
        border-color: #dce5e8;
    }

    .form-group input[type="checkbox"] {
        display: none;
    }

    .form-group input[type="checkbox"]+.btn-group>label span {
        width: 20px;
    }

    .form-group input[type="checkbox"]+.btn-group>label span:first-child {
        display: none;
    }

    .form-group input[type="checkbox"]+.btn-group>label span:last-child {
        display: inline-block;
    }

    .form-group input[type="checkbox"]:checked+.btn-group>label span:first-child {
        display: inline-block;
    }

    .form-group input[type="checkbox"]:checked+.btn-group>label span:last-child {
        display: none;
    }

</style>

@extends('header2')
@section('content')

    <?php
    $view = '';
    $all_chck = '';
    $prov_chck = '';
    $cat_chck = '';
    $display_prov = 'none';
    $display_cat = 'none';
    $req_prov = '';
    $req_cat = '';
    if ($page == 'view') {
        $view = 'disabled';
    }
    
    if (isset($data->aktif)) {
        if ($data->aktif == 'Y') {
            $all_chck = 'checked="true"';
        } else {
            //$all_chck = 'checked="false"';
        }
    }
    ?>
    {{-- <div class="padding"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom ">
                    <h3 class="mb-0">{{ $section }}</h3>
                </div>

                <div class="col-md-12">
                    @if ($page != 'view')
                        {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
                    @endif
                    <br>
                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2">Judul</label>
                        <div class="col-md-7">

                            <input type="text" class="form-control" name="judul" required {{ $view }}
                                @isset($data) value="{{ $data->judul }}" @endisset
                                style="border-color: #d1d1d1;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2">Thumbnail Preview</label>
                        <div class="col-md-7">
                            @if ($page != 'view')
                                <input type="file" class="form-control" name="file" {{ $view }}
                                    style="border-color: #d1d1d1;" accept="image/x-png,image/gif,image/jpeg">
                            @else
                                @if ($data->gambar)
                                    <a href="{{ url('/') . '/uploads/News/' . $data->gambar }}" target="_blank"
                                        class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;"><i
                                            class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Latest File</a>
                                @else
                                    <button type="button" class="btn btn-outline-secondary"
                                        style="width: 40%; border-color: #d1d1d1;" disabled>No File</button>
                                @endif
                            @endif
                        </div>
                    </div>


                    @if ($page == 'edit')
                        @if ($data->gambar)
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-2"></label>
                                <div class="col-md-7">
                                    <a href="{{ url('/') . '/uploads/News/' . $data->gambar }}" target="_blank"
                                        class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;"><i
                                            class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Latest Gambar
                                        Thumbnail</a>
                                    <input type="hidden" name="lastest_file" value="{{ $data->gambar }}">
                                </div>
                            </div>
                        @endif
                    @endif


                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2">Gambar Header</label>
                        <div class="col-md-7">
                            @if ($page != 'view')
                                <input type="file" class="form-control" name="gambar_header" {{ $view }}
                                    style="border-color: #d1d1d1;" accept="image/x-png,image/gif,image/jpeg">
                            @else
                                @if ($data->gambar_header)
                                    <a href="{{ url('/') . '/uploads/News/gambar_header/' . $data->gambar_header }}"
                                        target="_blank" class="btn btn-outline-secondary"
                                        style="width: 40%; border-color: #d1d1d1;"><i class="fa fa-download"
                                            aria-hidden="true"></i>&nbsp;&nbsp;Latest File</a>
                                @else
                                    <button type="button" class="btn btn-outline-secondary"
                                        style="width: 40%; border-color: #d1d1d1;" disabled>No File</button>
                                @endif
                            @endif
                        </div>
                    </div>

                    @if ($page == 'edit')
                        @if ($data->gambar_header)
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-2"></label>
                                <div class="col-md-7">
                                    <a href="{{ url('/') . '/uploads/News/gambar_header/' . $data->gambar_header }}"
                                        target="_blank" class="btn btn-outline-secondary"
                                        style="width: 40%; border-color: #d1d1d1;"><i class="fa fa-download"
                                            aria-hidden="true"></i>&nbsp;&nbsp;Latest Gambar Header</a>
                                    <input type="hidden" name="lastest_gambar_header" value="{{ $data->gambar_header }}">
                                </div>
                            </div>
                        @endif
                    @endif

                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2">Tanggal</label>
                        <div class="col-md-7">
                            <input type="date" class="form-control" name="tanggal"
                                {{ $view }}@isset($data) value="{{ $data->tanggal }}" @endisset
                                style="border-color: #d1d1d1;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2">Waktu</label>
                        <div class="col-md-7">
                            <input type="time" class="form-control" name="jam"
                                {{ $view }}@isset($data) value="{{ $data->jam }}" @endisset
                                style="border-color: #d1d1d1;">
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2">News</label>
                        <div class="col-md-7">
                            <textarea class="form-control" id="news" name="news" {{ $view }}>
@isset($data)
{{ $data->isi_artikel }}
@endisset
</textarea>
                        </div>
                    </div>

                    <div class="form-group row" style="margin-bottom: 0px;">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2">Status</label>
                        <div class="col-md-2">
                            <div class="form-group" style="width: 100%; height: 35px">
                                @if ($page != 'create')
                                    <input type="checkbox" name="send_to[]" {{ $all_chck }} onclick="send_to(this)"
                                        id="to_all" autocomplete="off"
                                        @isset($data) value="{{ $data->aktif }}" @endisset
                                        {{ $view }} />
                                @else
                                    <input type="checkbox" name="send_to[]" {{ $all_chck }} onclick="send_to(this)"
                                        id="to_all" autocomplete="off" value="Y" checked="true" />
                                @endif

                                <div class="btn-group" style="width: 100%; height: 100%">
                                    <label for="to_all" class="btn btn-default border-color"
                                        style="border-color: #aeb5b7; width: 30%; height: 100%;">
                                        <span class="fa fa-check" style="font-size: 16px;"></span>
                                        <span></span>
                                    </label>
                                    <label for="to_all_2" class="btn btn-default active border-color"
                                        style="border-color: #aeb5b7; width: 70%; height: 100%;">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-7">
                            @if ($page != 'view')
                                <button class="btn btn-primary button_form" type="submit"
                                    style="margin-right: 20px">Submit</button>
                            @endif
                            <a href="{{ route('news.index') }}" class="btn btn-danger button_form">
                                @if ($page != 'view')
                                    Cancel
                                @else
                                    Back
                                @endif
                            </a>
                        </div>
                    </div>
                    @if ($page != 'view')
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('news');

            $("#date").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                language: 'id'
            });

            // $( "#timepicker" ).datetimepicker({
            //   autoclose:true,
            //   format:'H:i:ss',
            //   language: 'id'
            // });


            $("textarea").each(function() {
                this.style.height = (this.scrollHeight + 10) + 'px';
            });
            $('.select2').select2({
                placeholder: 'Select Country'
            });

            $('#category').select2({
                placeholder: '-Choose Category-',
                sorter: function(data) {
                    return data.sort(function(a, b) {
                        return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                    });
                }
            }).on("select2:select", function(e) {
                $('#category-selection__rendered li#category-selection__choice').sort(function(a, b) {
                    return $(a).text() < $(b).text() ? -1 : $(a).text() > $(b).text() ? 1 : 0;
                }).prependTo('.select2-selection__rendered');
            });

            $('#province').select2({
                placeholder: '-Choose Province-',
                sorter: function(data) {
                    return data.sort(function(a, b) {
                        return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                    });
                }
            }).on("select2:select", function(e) {
                $('#province-selection__rendered li#province-selection__choice').sort(function(a, b) {
                    return $(a).text() < $(b).text() ? -1 : $(a).text() > $(b).text() ? 1 : 0;
                }).prependTo('.select2-selection__rendered');
            });
        });

        function send_to(obj) {
            switch (obj.value) {
                case 'Y':
                    if (obj.checked == true) {
                        $("label[for = to_all_2]").text("Aktif");
                    } else {
                        $("label[for = to_all_2]").text("Non Aktif");
                    }
                    break;
                case 'N':
                    if (obj.checked == true) {
                        $("label[for = to_all_2]").text("Aktif");
                    } else {
                        $("label[for = to_all_2]").text("Non Aktif");
                    }
                    break;
            }
        }
    </script>
    @include('footer')
@endsection
