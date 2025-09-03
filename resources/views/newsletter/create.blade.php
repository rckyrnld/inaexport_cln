@extends('header2')
@section('content')
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
    if (isset($data->send_to)) {
        if (strstr($data->send_to, 'Province')) {
            $prov_chck = 'checked';
            $req_prov = 'required';
            $display_prov = '';
        }
        if (strstr($data->send_to, 'Category')) {
            $cat_chck = 'checked';
            $req_cat = 'required';
            $display_cat = '';
        }
        if (strstr($data->send_to, 'All')) {
            $all_chck = 'checked';
            $prov_chck = 'disabled';
            $cat_chck = 'disabled';
            $display_prov = 'none';
            $display_cat = 'none';
            $req_prov = '';
            $req_cat = '';
        }
    }
    ?>
    <div class="padding">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Form Newsletter</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            @if ($page != 'view')
                                {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
                            @endif
                            <br>
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-2">About</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="about" required {{ $view }}
                                        @isset($data) value="{{ $data->about }}" @endisset
                                        style="border-color: #d1d1d1;">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-2">File Image</label>
                                <div class="col-md-7">
                                    @if ($page != 'view')
                                        <input type="file" class="form-control" name="file" {{ $view }}
                                            style="border-color: #d1d1d1;" accept="image/x-png,image/gif,image/jpeg">
                                    @else
                                        @if ($data->file)
                                            <a href="{{ url('/') . '/uploads/Newsletter/File/' . $data->file }}"
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
                                @if ($data->file)
                                    <div class="form-group row">
                                        <div class="col-md-1"></div>
                                        <label class="control-label col-md-2"></label>
                                        <div class="col-md-7">
                                            <a href="{{ url('/') . '/uploads/Newsletter/File/' . $data->file }}"
                                                target="_blank" class="btn btn-outline-secondary"
                                                style="width: 40%; border-color: #d1d1d1;"><i class="fa fa-download"
                                                    aria-hidden="true"></i>&nbsp;&nbsp;Latest File</a>
                                            <input type="hidden" name="lastest_file" value="{{ $data->file }}">
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-2">Messages</label>
                                <div class="col-md-7">
                                    <textarea class="form-control" id="messages" name="messages" {{ $view }}>
                                    @isset($data)
{{ $data->messages }}
@endisset
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: 0px;">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-2">Send To</label>
                                <div class="col-md-2">
                                    <div class="form-group" style="width: 100%; height: 35px">
                                        <input type="checkbox" name="send_to[]" {{ $all_chck }} onclick="send_to(this)"
                                            id="to_all" autocomplete="off" value="All" />
                                        <div class="btn-group" style="width: 100%; height: 100%">
                                            <label for="to_all" class="btn btn-default border-color"
                                                style="border-color: #aeb5b7; width: 30%; height: 100%;">
                                                <span class="fa fa-check" style="font-size: 16px;"></span>
                                                <span></span>
                                            </label>
                                            <label for="to_all" class="btn btn-default active border-color"
                                                style="border-color: #aeb5b7; width: 70%; height: 100%;">
                                                All
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="width: 100%; height: 35px">
                                        <input type="checkbox" name="send_to[]" {{ $prov_chck }} onclick="send_to(this)"
                                            id="to_province" autocomplete="off" value="Province" />
                                        <div class="btn-group" style="width: 100%; height: 100%">
                                            <label for="to_province" class="btn btn-default border-color"
                                                style="border-color: #aeb5b7; width: 30%; height: 100%;">
                                                <span class="fa fa-check" style="font-size: 16px;"></span>
                                                <span></span>
                                            </label>
                                            <label for="to_province" class="btn btn-default active border-color"
                                                style="border-color: #aeb5b7; width: 70%; height: 100%;">
                                                Province
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="width: 100%; height: 35px">
                                        <input type="checkbox" name="send_to[]" {{ $cat_chck }} onclick="send_to(this)"
                                            id="to_category" autocomplete="off" value="Category" />
                                        <div class="btn-group" style="width: 100%; height: 100%">
                                            <label for="to_category" class="btn btn-default border-color"
                                                style="border-color: #aeb5b7; width: 30%; height: 100%;">
                                                <span class="fa fa-check" style="font-size: 16px;"></span>
                                                <span></span>
                                            </label>
                                            <label for="to_category" class="btn btn-default active border-color"
                                                style="border-color: #aeb5b7; width: 70%; height: 100%;">
                                                Category
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" id="form_province" style="display: {{ $display_prov }};">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-2">Province</label>
                                <div class="col-md-7">
                                    <select class="form-control" id="province" style="width: 100%;" {{ $req_prov }}
                                        name="province[]" multiple="multiple">
                                        @if ($prov_chck == 'checked')
                                            {{ getOptionProvinceNewsletter($data->id) }}
                                        @else
                                            {{ getOptionProvince() }}
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="form_category" style="display: {{ $display_cat }};">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-2">Category</label>
                                <div class="col-md-7">
                                    <select class="form-control" id="category" style="width: 100%;" {{ $req_cat }}
                                        name="category[]" multiple="multiple">
                                        @if ($cat_chck == 'checked')
                                            {{ optionCategoryNewsletter($data->id) }}
                                        @else
                                            {{ optionCategory() }}
                                        @endif
                                    </select>
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
                                    <a href="{{ route('newsletter.index') }}" class="btn btn-danger button_form">
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
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('messages');
            @isset($data)
                @if ($data->status == 1)
                    $('input').prop('disabled', true);
                    $('select').prop('disabled', true);
                    $('.btn[type="submit"]').prop('disabled', true);
                @endif
            @endisset

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
                case 'All':
                    if (obj.checked == true) {
                        $('#to_province').prop('checked', false);
                        $('#to_category').prop('checked', false);
                        $('#to_province').prop('disabled', true);
                        $('#to_category').prop('disabled', true);
                        $('#form_province').hide('fast');
                        $('#form_category').hide('fast');
                    } else {
                        $('#to_province').prop('disabled', false);
                        $('#to_category').prop('disabled', false);
                    }
                    $('#province').removeAttr('required');
                    $('#category').removeAttr('required');
                    break;
                case 'Province':
                    if (obj.checked == true) {
                        $('#form_province').show('fast');
                        $('#province').attr('required', 'required');
                    } else {
                        $('#form_province').hide('fast');
                        $('#province').removeAttr('required');
                    }
                    break;
                case 'Category':
                    if (obj.checked == true) {
                        $('#form_category').show('fast');
                        $('#category').attr('required', 'required');
                    } else {
                        $('#form_category').hide('fast');
                        $('#category').removeAttr('required');
                    }
                    break;
            }
        }
    </script>

    @include('footer')

@endsection
