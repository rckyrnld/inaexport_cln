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
                    <h3 class="text-black">
                        @if ($page == 'view')
                            View
                        @else
                            Form
                        @endif Trade Update
                        @if ($page == 'view')
                            <a href="{{ route('admin.curris.index') }}" style="float: right;"
                                class="btn btn-danger button_form"><i class="fas fa-arrow-circle-left"></i> Back</a>
                        @endif
                    </h3>
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
                        {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true, 'id' => 'form']) !!}
                    @endif
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-2 mt-2">Title (EN)</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="title_en" autocomplete="off" required
                                    placeholder="Input" {{ $view }}
                                    @isset($data) value="{{ $data->title_en }}" @endisset>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-2 mt-2">Title (IN)</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="title_in" autocomplete="off" required
                                    placeholder="Input" {{ $view }}
                                    @isset($data) value="{{ $data->title_in }}" @endisset>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-2 mt-2">Country</label>
                            <div class="col-md-8">
                                @if ($page == 'view')
                                    <input type="text" class="form-control" readonly
                                        value="{{ rc_country($data->id_mst_country) }}">
                                @else
                                    <select class="form-control" id="country" required name="country" {{ $view }}>
                                        <option></option>
                                        @foreach ($country as $val)
                                            <option value="{{ $val->id }}"
                                                @isset($data) @if ($data->id_mst_country == $val->id) selected @endif @endisset>
                                                {{ $val->country }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-2 mt-2">Publish Date</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="date" name="date" placeholder="Date Time"
                                    autocomplete="off" {{ $view }}
                                    @isset($data) value="{{ $data->publish_date }}" @endisset>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <label class="control-label col-md-2 mt-2">File</label>
                            <div class="col-md-8">
                                @if ($page != 'view')
                                    @if (isset($data->exum))
                                        <input type="file" class="form-control upload1" name="file" accept="application/pdf"
                                            {{ $view }} @if ($page == 'create') required @endif><br>
                                        <a href="{{ url('/') . '/uploads/Market Research/File/' . $data->exum }}"
                                            target="_blank" class="btn btn-outline-secondary"><i class="fa fa-download"
                                                aria-hidden="true"></i>&nbsp;&nbsp;Previous Document</a><br>
                                    @else
                                        <input type="file" class="form-control upload1" name="file" accept="application/pdf"
                                            required {{ $view }} @if ($page == 'create')  @endif />
                                    @endif
                                    <input type="hidden" name="lastest_file"
                                        @isset($data) value="{{ $data->exum }}" @endisset>
                                @else
                                    <a href="{{ url('/') . '/uploads/Market Research/File/' . $data->exum }}" target="_blank"
                                        class="btn btn-outline-secondary" style="width: 30%"><i class="fa fa-download"
                                            aria-hidden="true"></i>&nbsp;&nbsp;Document</a>
                                @endif
                            </div>
                        </div>

                        @if ($page == 'view')
                            <br>

                            <div class="row ml--5 mr--5">

                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <table id="table" class="table table-striped table-hover" data-plugin="dataTable">
                                        <thead class="text-white" style="background-color: #C4C4C4">
                                            <tr>
                                                <th width="8%">
                                                    <center>No</center>
                                                </th>
                                                <th>
                                                    <center>Company / Eksportir</center>
                                                </th>
                                                <th>
                                                    <center>Download Date</center>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        @endif

                        @if ($page != 'view')
                            <div class="form-group row">
                                <div class="col-md-11">
                                    <div align="right">
                                        <a href="{{ route('admin.curris.index') }}" class="btn btn-danger button_form">
                                            @if ($page != 'view')
                                                Cancel
                                            @else
                                                Back
                                            @endif
                                        </a>
                                        @if ($page != 'view')
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
        $('.upload1').on('change', function(evt) {
            var size = this.files[0].size;
            var type = this.files[0].type;
            console.log(type);

            if (type == 'application/pdf') {
                if (size > 5000000) {
                    //     if(size > 20000){
                    $(this).val("");
                    alert('image size must less than 5MB');

                }
            } else {
                $(this).val("");
                alert('uploaded file must be a pdf file')
            }
        });

        $(document).ready(function() {
            var page = "{{ $page }}";

            if (page == 'view') {
                $('#table').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.curris.getDataDownload', $id) }}",
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
