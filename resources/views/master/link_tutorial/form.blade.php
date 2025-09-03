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
                    <h3 class="mb-0">{{ ucwords($page) }} Link Tutorial</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
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
                    {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'id' => 'myForm', 'files' => false])
                    !!}
                    @endif
                    <div class="card-body">
                        <div class="form-group row mb-2">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-1 my-auto">User Type</label>
                            <div class="col-md-9">
                                <select class="form-control select2" id="link_tutorial_user_type_id"
                                    name="link_tutorial_user_type_id" required @if($page=='view' ) disabled @endif>
                                    <option value="" disabled="disabled">- Select User Type -</option>
                                    @foreach ($user_types as $user_type)
                                    <option value="{{ $user_type->id }}" @isset($data) {{ ($data->
                                        link_tutorial_user_type_id == $user_type->id) ? 'selected' : '' }} @endisset>{{
                                        $user_type->user_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if(isset($data))
                        <div class="wrapper">
                            @php
                            $link_url = explode('%#%', $data->link);
                            $link_title = explode('%#%', $data->title);
                            @endphp
                            @foreach($link_url as $key => $val_link)
                            <div class="form-group row mb-2">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-1 my-auto">Title</label>
                                <div class="col-md-4 ">
                                    <input type="text" class="form-control link" autocomplete="off" required
                                        @if($page=='view' ) disabled @endif name="title[]"
                                        placeholder="Input Title" value={{$link_title[$key]}}>
                                </div>
                                <label class="control-label col-md-1 my-auto">Link</label>
                                <div class="col-md-4">
                                    <input type="url" class="form-control link" autocomplete="off" required
                                        @if($page=='view' ) disabled @endif name="link[]"
                                        placeholder="Input Link (prefix with http:// or https://)" value={{$val_link}}>
                                </div>
                                @if($key != 0 && $page != 'view')
                                <div class="col-md-1 pl-0 ml-0 my-auto">
                                    <i class="fa-2x fas fa-minus-circle" style="color: #dc3545;cursor:pointer;"></i>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="wrapper">
                            <div class="form-group row mb-2">
                                <div class="col-md-1"></div>
                                <label class="control-label col-md-1 my-auto">Title</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" autocomplete="off" required
                                        title="Please input title" name="title[]" placeholder="Input Title" {{ $view }}>
                                </div>
                                <label class="control-label col-md-1 my-auto">Link</label>
                                <div class="col-md-4">
                                    <input type="url" class="form-control link" autocomplete="off" required
                                        title="Please input link with prefix http:// or https://" name="link[]"
                                        placeholder="Input Link (prefix with http:// or https://)" {{ $view }}>
                                    <div class="errormsg text-danger"></div>
                                </div>
                            </div>
                        </div>
                        @endif


                        <div class="form-group row mb-2">
                            <div class="col-md-2 ml-3"></div>
                            <div style="color:orange; display:none;" id="warningMessage"><b>Please don't use character
                                    %#% in Link</b></div>
                        </div>

                        @if($page != 'view')
                        <div class="form-group row mb-2">
                            <div class="col-md-1"></div>
                            <div class="offset-md-1 col-md-2">
                                <a class="btn-md btn-success add-link rounded" href="javascript:void(0)"><i
                                        class="fa fa-plus"></i> Add Link</a>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row pt-4">
                            <div class="offset-md-2 col-md-10">
                                <div align="left">
                                    @if ($page != 'view')
                                    <button class="btn btn-primary button_form" type="submit" id="submit">Save</button>
                                    @endif
                                    <a href="{{ url('link-tutorial') }}" class="btn btn-danger button_form">@if ($page
                                        !=
                                        'view') Cancel @else Back @endif</a>
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

            $('.add-link').click(function(){
                $('.wrapper').append(`<div class="form-group row mb-2">
                                        <div class="col-md-1"></div>
                                        <label class="control-label col-md-1 my-auto">Title</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" autocomplete="off" required
                                                title="Please input title" name="title[]" placeholder="Input Title">
                                        </div>
                                        <label class="control-label col-md-1 my-auto">Link</label>
                                        <div class="col-md-4">
                                            <input type="url" class="form-control link" autocomplete="off" required
                                                name="link[]" placeholder="Input Link (prefix with http:// or https://)">
                                        </div>
                                        <div class="col-md-1 pl-0 ml-0 my-auto">
                                            <i class="fa-2x fas fa-minus-circle" style="color: #dc3545;cursor:pointer;"></i>
                                        </div>
                                     </div>`)            
            });

            
            $('.wrapper').on('click', '.fa-minus-circle', function(e) {
                e.preventDefault();

                $(this).parent().parent().remove();
            });

            $('#submit').click(function(e) {
                var isValid = true;
                $('.link').each(function() {
                    if($(this).val().includes("%#%")){
                        isValid = false;
                        $('#warningMessage').show();
                    } else {
                        $('#warningMessage').hide();
                    }
                   
                });
                if (isValid == false) e.preventDefault();

            });
        });
    </script>

    @include('footer')

    @endsection