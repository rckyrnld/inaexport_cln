@extends('header2')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/jquery.datetimepicker.css') }}" />
    <link href="{{ asset('css/dashboard/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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

        .rightbtn {
            float: left;
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
            height: 45px !important;
        }

        input.input-error {
            color: #ff0000;
            border: 1px solid #ff0000;
            box-shadow: 0 0 5px #ff0000;
        }

        span.select2-selection.select2-selection--single {
            height: 44px;
        }

        span.select2-selection.select2-selection--multiple {
            height: 50px;
            overflow: hidden !important;
            height: auto !important;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Form {{ $id != '' ? 'Edit' : 'Tambah' }} Video Conference</h3>
                </div>
                <div class="card-body">
                    <form id="form_video_conference" class="form-horizontal" enctype="multipart/form-data" method="POST"
                        action="{{ url($url) }}">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputMeetingTopic" class="col-sm-3 col-form-label font-weight-bold">Topic
                                        <span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control topic required create-input"
                                            id="inputMeetingTopic" placeholder="Input video conference topic"
                                            name="inputMeetingTopic"
                                            value="{{ old('inputMeetingTopic', $data != '' ? $data->topic : '') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputStartTime" class="col-sm-3 col-form-label font-weight-bold">Start
                                        Time (UTC+7)<span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control topic required create-input"
                                            id="inputStartTime" placeholder="Input Start Time (UTC+7)" name="inputStartTime"
                                            value="{{ old('inputStartTime', $data != '' ? $data->start_time : '') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputMeetingDuration"
                                        class="col-sm-3 col-form-label font-weight-bold">Duration (in Minute)<span
                                            style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control minute required create-input" max="1800"
                                            id="inputMeetingDuration"
                                            placeholder="Input video conference duration (in Minute)"
                                            name="inputMeetingDuration"
                                            value="{{ old('inputMeetingDuration', $data != '' ? $data->duration : '') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row mb-2 ml-2">
                                    <input type="hidden" name="for_expo" value="Supplier">
                                    <label for="myInviteExportir"
                                        class="col-sm-3 col-form-label font-weight-bold">Supplier</label>
                                    <div class="col-sm-9">
                                        <select id="myInviteExportir" data-toggle="select"
                                            class="js-example-basic-multiple-exportir form-control" name="states_exportir[]"
                                            multiple="multiple" data-placeholder="Choose exportir">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <input type="hidden" name="for_buyer" value="Buyer">
                                    <label for="myInviteBuyer"
                                        class="col-sm-3 col-form-label font-weight-bold">Buyer</label>
                                    <div class="col-sm-9">
                                        <select id="myInviteBuyer" data-toggle="select"
                                            class="js-example-basic-multiple-buyer form-control" name="states_buyer[]"
                                            multiple="multiple" data-placeholder="Choose buyer">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <input type="hidden" name="for_wakil" value="Perwakilan">
                                    <label for="myInvitePerwakilan"
                                        class="col-sm-3 col-form-label font-weight-bold">Perwakilan</label>
                                    <div class="col-sm-9">
                                        <select id="myInvitePerwakilan" data-toggle="select"
                                            class="js-example-basic-multiple-perwakilan form-control"
                                            name="states_perwakilan[]" multiple="multiple"
                                            data-placeholder="Choose perwakilan">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12 pt-2">
                                    <div class="offset-lg-3 col text-left">
                                        <button type="submit" class="btn btn-success btn-submit ml-3"><i
                                                class="fa fa-save"></i>
                                            {{ $id != '' ? 'Edit' : 'Create' }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{ asset('vendor/datetimepicker/moment.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('vendor/datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('css/dashboard/vendor/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(function() {
            // Select2
            $('#myInviteExportir').select2({
                width: '100%',
                multiple: true,
                placeholder: 'Choose exportir',
                allowClear: true,
                ajax: {
                    url: '{{ url('video_conference/autocomplete-ajax-user-exportir') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, d) {
                            let badan_usaha = "";
                            if (d.profile != null) {
                                if (d.profile.badanusaha != null && d.profile.badanusaha !=
                                    'Others' && d.profile.badanusaha != '-') {
                                    badan_usaha = ", " + d.profile.badanusaha;
                                }
                            } else {
                                badan_usaha = "";
                            }

                            results.push({
                                id: d.id,
                                text: (d.profile != null) ? d.profile.company + '' +
                                    badan_usaha + ' (' + d
                                    .email + ')' : '(' + d.email + ')'
                            });
                        });

                        return {
                            results: results
                        };
                    },
                    cache: true,
                    delay: 300
                }
            });

            $('#myInviteBuyer').select2({
                width: '100%',
                multiple: true,
                placeholder: 'Choose buyer',
                allowClear: true,
                ajax: {
                    url: '{{ url('video_conference/autocomplete-ajax-user-buyer') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            search: params.term,
                            meeting_id: $('#zoom_room_id').val()
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, d) {
                            let badan_usaha = "";
                            if (d.profile_buyer != null) {
                                if (d.profile_buyer.badanusaha != null && d.profile_buyer
                                    .badanusaha != 'Others' && d.profile_buyer.badanusaha != '-'
                                ) {
                                    badan_usaha = ", " + d.profile_buyer.badanusaha;
                                }
                            } else {
                                badan_usaha = "";
                            }
                            results.push({
                                id: d.id,
                                text: (d.profile_buyer != null) ? d.profile_buyer
                                    .company + '' + badan_usaha + ' (' + d.email + ')' :
                                    '(' + d
                                    .email +
                                    ')'
                            });
                        });

                        return {
                            results: results
                        };
                    },
                    cache: true
                }
            });

            $('#myInvitePerwakilan').select2({
                width: '100%',
                multiple: true,
                placeholder: 'Choose perwakilan',
                allowClear: true,
                ajax: {
                    url: '{{ url('video_conference/autocomplete-ajax-user-perwakilan') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, d) {
                            // console.log(d)
                            let check_perwadag;
                            if (d.profile_perwadag_ln != null && d.profile_perwadag_dn ==
                                null) {
                                check_perwadag = d.name + "(" + d.email +
                                    ")";
                            } else if (d.profile_perwadag_ln == null && d.profile_perwadag_dn !=
                                null) {
                                check_perwadag = d.name + "(" + d.email +
                                    ")";
                            } else {
                                check_perwadag = d.email;
                            }

                            results.push({
                                id: d.id,
                                text: check_perwadag
                            });
                        });

                        return {
                            results: results
                        };
                    },
                    cache: true
                }
            });
        })

        $('#inputStartTime').datetimepicker({
            mask: '39-19-1999 29:59',
            format: 'd-m-Y H:i',
            formatDate: 'd-m-Y',
            formatTime: 'H:i',
            interval: 15,
            step: 15,
            stepping: 15,
            stepMinute: 15,
            monthChangeSpinner: true,

        });

        // $('#form_video_conference').submit(function(e) {
        //     e.preventDefault();

        //     Swal.fire({
        //         title: 'Are you sure',
        //         text: "You want create video conference?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $(this).submit();
        //         }
        //     });
        // })
    </script>

@endsection
@extends('header2')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/jquery.datetimepicker.css') }}" />
    <link href="{{ asset('css/dashboard/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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

        .rightbtn {
            float: left;
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
            height: 45px !important;
        }

        input.input-error {
            color: #ff0000;
            border: 1px solid #ff0000;
            box-shadow: 0 0 5px #ff0000;
        }

        span.select2-selection.select2-selection--single {
            height: 44px;
        }

        span.select2-selection.select2-selection--multiple {
            height: 50px;
            overflow: hidden !important;
            height: auto !important;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Form {{ $id != '' ? 'Edit' : 'Tambah' }} Video Conference</h3>
                </div>
                <div class="card-body">
                    <form id="form_video_conference" class="form-horizontal" enctype="multipart/form-data" method="POST"
                        action="{{ url($url) }}">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputMeetingTopic" class="col-sm-3 col-form-label font-weight-bold">Topic
                                        <span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control topic required create-input"
                                            id="inputMeetingTopic" placeholder="Input meeting topic"
                                            name="inputMeetingTopic"
                                            value="{{ old('inputMeetingTopic', $data != '' ? $data->topic : '') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputStartTime" class="col-sm-3 col-form-label font-weight-bold">Start
                                        Time (UTC+7)<span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control topic required create-input"
                                            id="inputStartTime" placeholder="Input Start Time (UTC+7)" name="inputStartTime"
                                            value="{{ old('inputStartTime', $data != '' ? $data->start_time : '') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputMeetingDuration"
                                        class="col-sm-3 col-form-label font-weight-bold">Duration (in Minute)<span
                                            style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control minute required create-input" max="1800"
                                            id="inputMeetingDuration" placeholder="Input meeting duration (in Minute)"
                                            name="inputMeetingDuration"
                                            value="{{ old('inputMeetingDuration', $data != '' ? $data->duration : '') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row mb-2 ml-2">
                                    <input type="hidden" name="for_expo" value="Supplier">
                                    <label for="myInviteExportir"
                                        class="col-sm-3 col-form-label font-weight-bold">Supplier</label>
                                    <div class="col-sm-9">
                                        <select id="myInviteExportir" data-toggle="select"
                                            class="js-example-basic-multiple-exportir form-control" name="states_exportir[]"
                                            multiple="multiple" data-placeholder="Choose exportir">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <input type="hidden" name="for_buyer" value="Buyer">
                                    <label for="myInviteBuyer"
                                        class="col-sm-3 col-form-label font-weight-bold">Buyer</label>
                                    <div class="col-sm-9">
                                        <select id="myInviteBuyer" data-toggle="select"
                                            class="js-example-basic-multiple-buyer form-control" name="states_buyer[]"
                                            multiple="multiple" data-placeholder="Choose buyer">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <input type="hidden" name="for_wakil" value="Perwakilan">
                                    <label for="myInvitePerwakilan"
                                        class="col-sm-3 col-form-label font-weight-bold">Perwakilan</label>
                                    <div class="col-sm-9">
                                        <select id="myInvitePerwakilan" data-toggle="select"
                                            class="js-example-basic-multiple-perwakilan form-control"
                                            name="states_perwakilan[]" multiple="multiple"
                                            data-placeholder="Choose perwakilan">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12 pt-2">
                                    <div class="offset-lg-3 col text-left">
                                        <button type="submit" class="btn btn-success btn-submit ml-3"><i
                                                class="fa fa-save"></i>
                                            {{ $id != '' ? 'Edit' : 'Create' }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{ asset('vendor/datetimepicker/moment.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('vendor/datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('css/dashboard/vendor/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(function() {
            // Select2
            $('#myInviteExportir').select2({
                width: '100%',
                multiple: true,
                placeholder: 'Choose exportir',
                allowClear: true,
                ajax: {
                    url: '{{ url('video_conference/autocomplete-ajax-user-exportir') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, d) {
                            let badan_usaha = "";
                            if (d.profile != null) {
                                if (d.profile.badanusaha != null && d.profile.badanusaha !=
                                    'Others' && d.profile.badanusaha != '-') {
                                    badan_usaha = ", " + d.profile.badanusaha;
                                }
                            } else {
                                badan_usaha = "";
                            }

                            results.push({
                                id: d.id,
                                text: (d.profile != null) ? d.profile.company + '' +
                                    badan_usaha + ' (' + d
                                    .email + ')' : '(' + d.email + ')'
                            });
                        });

                        return {
                            results: results
                        };
                    },
                    cache: true,
                    delay: 300
                }
            });

            $('#myInviteBuyer').select2({
                width: '100%',
                multiple: true,
                placeholder: 'Choose buyer',
                allowClear: true,
                ajax: {
                    url: '{{ url('video_conference/autocomplete-ajax-user-buyer') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            search: params.term,
                            meeting_id: $('#zoom_room_id').val()
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, d) {
                            let badan_usaha = "";
                            if (d.profile_buyer != null) {
                                if (d.profile_buyer.badanusaha != null && d.profile_buyer
                                    .badanusaha != 'Others' && d.profile_buyer.badanusaha != '-'
                                ) {
                                    badan_usaha = ", " + d.profile_buyer.badanusaha;
                                }
                            } else {
                                badan_usaha = "";
                            }
                            results.push({
                                id: d.id,
                                text: (d.profile_buyer != null) ? d.profile_buyer
                                    .company + '' + badan_usaha + ' (' + d.email + ')' :
                                    '(' + d
                                    .email +
                                    ')'
                            });
                        });

                        return {
                            results: results
                        };
                    },
                    cache: true
                }
            });

            $('#myInvitePerwakilan').select2({
                width: '100%',
                multiple: true,
                placeholder: 'Choose perwakilan',
                allowClear: true,
                ajax: {
                    url: '{{ url('video_conference/autocomplete-ajax-user-perwakilan') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, d) {
                            // console.log(d)
                            let check_perwadag;
                            if (d.profile_perwadag_ln != null && d.profile_perwadag_dn ==
                                null) {
                                check_perwadag = d.name + "(" + d.email +
                                    ")";
                            } else if (d.profile_perwadag_ln == null && d.profile_perwadag_dn !=
                                null) {
                                check_perwadag = d.name + "(" + d.email +
                                    ")";
                            } else {
                                check_perwadag = d.email;
                            }

                            results.push({
                                id: d.id,
                                text: check_perwadag
                            });
                        });

                        return {
                            results: results
                        };
                    },
                    cache: true
                }
            });
        })

        $('#inputStartTime').datetimepicker({
            mask: '39-19-1999 29:59',
            format: 'd-m-Y H:i',
            formatDate: 'd-m-Y',
            formatTime: 'H:i',
            interval: 15,
            step: 15,
            stepping: 15,
            stepMinute: 15,
            monthChangeSpinner: true,

        });

        // $('#form_video_conference').submit(function(e) {
        //     e.preventDefault();

        //     Swal.fire({
        //         title: 'Are you sure',
        //         text: "You want create video conference?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $(this).submit();
        //         }
        //     });
        // })
    </script>

@endsection
