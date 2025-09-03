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

        .form-group {
            margin-bottom: 1rem;
        }

    </style>
    <?php
    if ($page == 'view') {
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
                    <h3 class="mb-0"> Form Publication
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
                    {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true, 'id' => 'form']) !!}<br>
                    <div class="form-group row">
                        <label class="control-label col-md-2 mt-2 text-lg-right text-sm-left">Title (EN)</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="title_en" autocomplete="off" required
                                placeholder="Input">
                        </div>
                        <label class="control-label col-md-2 mt-2 text-lg-right text-sm-left">Title (IN)</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="title_in" autocomplete="off" required
                                placeholder="Input">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2 mt-2 text-lg-right text-sm-left">Type</label>
                        <div class="col-md-4">
                            <select class="form-control select2" id="type" required name="type">
                                <option value="" disabled selected>---Choose one---</option>
                                <option value="Export News">Export News</option>
                                <option value="Warta Ekspor">Warta Ekspor</option>
                                <option value="Brochure">Brochure</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-2 col-sm-4 mt-2 text-lg-right text-sm-left">Tanggal
                            Publish</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="date" autocomplete="off" required
                                placeholder="Input" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-2 mt-2 text-lg-right text-sm-left">Cover</label>
                        <div class="col-md-4">
                            <input type="file" class="form-control upload1" name="cover" accept="image/*" /><br>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-top: -21px;">
                        <label class="control-label col-md-2 mt-2 text-lg-right text-sm-left">File</label>
                        <div class="col-md-4">
                            <input type="file" class="form-control upload1" name="file" required accept=".pdf">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                            <div class="offset-lg-2 pl-5">
                                <a href="{{ route('admin.research-corner.index') }}" class="btn btn-danger button_form">
                                    Back</a>

                                <button class="btn btn-primary button_form" type="button" id="simpan">Submit</button>
                                <button class="btn btn-primary button_form" type="submit" id="save"
                                    style="display: none;">Submit</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
        $('.upload1').on('change', function(evt) {
            var size = this.files[0].size;
            if (size > 5000000) {
                //     if(size > 20000){
                $(this).val("");
                alert('image size must less than 5MB');
            } else {

            }
        });

        $('#country').select2({
            placeholder: 'Select Country'
        });

        $('#simpan').on('click', function(e) {
            e.preventDefault();
            if ($('#date').val() == "") {
                alert('please complete the date field');
                {{-- $.ajax({ --}}
                {{-- type: "POST", --}}
                {{-- url: '{{url('/admin/research-corner/store/Create')}}', --}}
                {{-- data: { :company,username:username,email:email,website:website,phone:phone,fax:fax,password:password,city:city,prov:prov,postcode:postcode,alamat:alamat,_token:'{{csrf_token()}}' }, --}}
                {{-- success: function (data) { --}}
                {{-- console.log(data); --}}
                {{-- }, --}}
                {{-- error: function (data, textStatus, errorThrown) { --}}
                {{-- console.log(data); --}}
                {{-- }, --}}
                {{-- }); --}}
            } else {
                $("#save").click();

            }
        })
    </script>
    @include('footer')
@endsection
