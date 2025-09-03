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
    if ($page == 'view') {
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
                    <h3 class="mb-0">Add Event Organizer</h3>
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
                    @if ($page != 'view')
                        {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => false]) !!}
                    @endif
                    <div class="card-body">
                        <div class="form-group row mb-2">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-1 my-auto">Name</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="name_en" autocomplete="off" required
                                    name="name_en" placeholder="Input Name" {{ $view }}
                                    @isset($data) value="{{ $data->name_en }}" @endisset>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-1 my-auto">Address</label>
                            <div class="col-md-7">
                                <textarea rows="5" style="resize: vertical; min-height: 150px" class="form-control"
                                    id="addres_en" name="addres_en" autocomplete="off" required
                                    {{ $view }}>@isset($data) {{ $data->addres_en }} @endisset</textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-1 my-auto">Mobile</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="mobile" autocomplete="off" required
                                    name="mobile" placeholder="Input Mobile" {{ $view }}
                                    @isset($data) value="{{ $data->mobile }}" @endisset>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-1 my-auto">Phone</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="phone" autocomplete="off" name="phone"
                                    placeholder="Input Phone" {{ $view }} @isset($data)
                                    value="{{ $data->phone }}" @endisset>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-1 my-auto">Fax</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="fax" autocomplete="off" name="fax"
                                    placeholder="Input Fax" {{ $view }} @isset($data)
                                    value="{{ $data->fax }}" @endisset>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-1 my-auto">Email</label>
                            <div class="col-md-7">
                                <input type="email" class="form-control" id="email_en" autocomplete="off" name="email_en"
                                    placeholder="Input Email" required {{ $view }} @isset($data)
                                    value="{{ $data->email_en }}" @endisset>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-1 my-auto">Website</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="website_en" autocomplete="off" name="website_en"
                                    placeholder="Input Website" required {{ $view }} @isset($data)
                                    value="{{ $data->website_en }}" @endisset>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-md-2 col-md-10">
                                <div align="left">
                                    @if ($page != 'view')
                                        <button class="btn btn-primary button_form" type="submit">Save</button>
                                    @endif
                                    <a href="{{ url('event-place') }}"
                                        class="btn btn-danger button_form">@if ($page != 'view') Cancel @else Back @endif</a>
                                </div>
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


    <script type="text/javascript">
        $(document).ready(function() {
            $('.integer').inputmask({
                alias: "integer",
                repeat: 3,
                digitsOptional: false,
                decimalProtect: false,
                radixFocus: true,
                autoUnmask: false,
                allowMinus: false,
                rightAlign: false,
                clearMaskOnLostFocus: false,
                onBeforeMask: function(value, opts) {
                    return value;
                },
                removeMaskOnSubmit: true
            });


            $('select').select2();
        });
    </script>

    @include('footer')

@endsection
