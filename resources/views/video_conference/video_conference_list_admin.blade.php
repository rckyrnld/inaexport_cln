@extends('header2')
@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->


    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/jquery.datetimepicker.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatable/jquery.dataTables.min.css') }}" /> --}}
    <link href="{{ asset('css/dashboard/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Roboto', sans-serif;
        }

        .table-responsive {
            margin: 30px 0;
        }

        .table-wrapper {
            min-width: 1000px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            font-size: 15px;
            padding-bottom: 10px;
            margin: 0 0 10px;
            min-height: 45px;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title select {
            border-color: #ddd;
            border-width: 0 0 1px 0;
            padding: 3px 10px 3px 5px;
            margin: 0 5px;
        }

        .table-title .show-entries {
            margin-top: 7px;
        }

        .search-box {
            position: relative;
            float: right;
        }

        .search-box .input-group {
            min-width: 200px;
            position: absolute;
            right: 0;
        }

        .search-box .input-group-addon,
        .search-box input {
            border-color: #ddd;
            border-radius: 0;
        }

        .search-box .input-group-addon {
            border: none;
            border: none;
            background: transparent;
            position: absolute;
            z-index: 9;
        }

        .search-box input {
            height: 34px;
            padding-left: 28px;
            box-shadow: none !important;
            border-width: 0 0 1px 0;
        }

        .search-box input:focus {
            border-color: #3FBAE4;
        }

        .search-box i {
            color: #a0a5b1;
            font-size: 19px;
            position: relative;
            top: 8px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child {
            width: 130px;
        }

        table.table td a {
            color: #a0a5b1;
            display: inline-block;
            margin: 0 5px;
        }

        table.table td a.view {
            color: #03A9F4;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #E34724;
        }

        table.table td i {
            font-size: 19px;
        }

        .pagination {
            float: right;
            margin: 0 0 5px;
        }

        .pagination li a {
            border: none;
            font-size: 13px;
            min-width: 30px;
            min-height: 30px;
            padding: 0 10px;
            color: #999;
            margin: 0 2px;
            line-height: 30px;
            border-radius: 30px !important;
            text-align: center;
        }

        .pagination li a:hover {
            color: #666;
        }

        .pagination li.active a {
            background: #03A9F4;
        }

        .pagination li.active a:hover {
            background: #0397d6;
        }

        .pagination li.disabled i {
            color: #ccc;
        }

        .pagination li i {
            font-size: 16px;
            padding-top: 6px
        }

        .hint-text {
            float: left;
            margin-top: 10px;
            font-size: 13px;
        }

        #meeting-table_length {
            padding-bottom: 20px;
        }

        /* Loader */
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            display: block;
            margin: 30px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        span.select2-selection.select2-selection--single {
            height: 44px;
        }

        span.select2-selection.select2-selection--multiple {
            height: 50px;
            overflow: hidden !important;
            height: auto !important;
        }

        table#registered-user-table tbody tr td {
            text-align: center;
        }

        .page-item .page-link,
        .page-item span {
            font-size: 0.875rem;
            display: flex;
            width: 36px;
            height: 36px;
            margin: 0 3px;
            padding: 0;
            border-radius: 50% !important;
            align-items: center;
            justify-content: center;
        }

        .lcs_wrap {
            margin-top: 0.5rem !important;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Video Conference</h3>
                </div>
                <?php
                $url = "https://zoom.us/oauth/authorize?response_type=code&client_id=$VC_CLIENT_ID&redirect_uri=$VC_REDIRECT_URI";
                ?>
                <div class="card-body pb-0 pl-4 pt-4">
                    @if ($is_login == true)

                    @else
                        <a href="{{ $url }}" type="submit" class="btn btn-success ml-4">Login Zoom</a>
                        <label class="control-label font-italic text-blue">Please login to take an action</label>
                    @endif
                </div>
                <!-- Light table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="meeting-table" data-plugin="dataTable">
                            <thead class="text-white" style="background-color:#6B7BD6">
                                <tr>
                                    <th style="text-align: center;">#</th>
                                    <th style="text-align: center;">Zoom Meeting ID</th>
                                    <th style="text-align: center;">Password</th>
                                    <th style="text-align: center;">Topic</th>
                                    <th style="text-align: center;">Start Time</th>
                                    <th style="text-align: center;">Duration (minute)</th>
                                    <th style="text-align: center;">Join Url</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($meetings as $d)
                                    <tr
                                        style="background-color: {{ \Carbon\Carbon::parse($d->start_time) < \Carbon\Carbon::now() ? '#c1c1c1' : 'white' }}">
                                        <td style="text-align: center; vertical-align:middle">{{ $loop->iteration }}</td>
                                        <td style="text-align: center; vertical-align:middle">{{ $d->meeting_id }}</td>
                                        <td style="text-align: center; vertical-align:middle">{{ $d->password }}</td>
                                        <td style="text-align: left; vertical-align:middle">{{ $d->topic }}</td>
                                        <td style="text-align: center; vertical-align:middle">
                                            <?php date_default_timezone_set('Asia/Jakarta'); ?>
                                            {{ date('d F Y H:i', strtotime($d->start_time)) }} (UTC+7)
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">{{ $d->duration }}</td>
                                        <td style="text-align: center; vertical-align:middle">
                                            <a target="_blank" href="{{ $d->join_url }}"
                                                style="text-decoration: none; color:#3FBAE4">{{ $d->join_url }}</a>
                                        </td>
                                        <td>
                                            @if ($d->approve == true)
                                                <span class="btn btn-success">Approved</span>
                                            @elseif($d->approve == '')
                                                <span class="btn btn-warning">Not yet approved</span>
                                            @elseif($d->approve == false)
                                                <span class="btn btn-warning">Declined</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center; vertical-align: middle; width: 180px;">
                                            @if ($is_login == true)
                                                @if (count($d->video_conference_participants) > 0)
                                                    <span data-toggle="modal" data-target="#exampleModalUserParticipants"
                                                        class="btn-user-participants" data-value="{{ $d->id }}"
                                                        data-value-approve="approve_meeting/{{ $d->id }}"
                                                        data-value-decline="decline_meeting/{{ $d->id }}"
                                                        data-duration="{{ $d->duration }}"
                                                        data-start-time="{{ $d->start_time }}"
                                                        data-topic="{{ $d->topic }}"
                                                        data-approve="{{ $d->approve }}">
                                                        <a class="btn btn-primary btn-sm" style="color: white !important;"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Registered User"><i class="fa fa-user"></i></a>
                                                    </span>
                                                @endif
                                                {{-- @if ($d->approve == false)
                                                <a href="javascript:void(0)"
                                                    data-value="approve_meeting/{{ $d->id }}"
                                                    data-duration="{{ $d->duration }}"
                                                    data-start-time="{{ $d->start_time }}"
                                                    data-topic="{{ $d->topic }}"
                                                    class="btn btn-primary btn-approve-meeting btn-sm"
                                                    onclick="approveMeeting(this);" style="color: white !important;"
                                                    data-toggle="tooltip" data-placement="top" title="Approve meeting"><i
                                                        class="fa fa-check"></i></a>
                                            @endif
                                            @if ($d->approve == true)
                                                <a href="javascript:void(0)"
                                                    data-value="decline_meeting/{{ $d->id }}"
                                                    class="btn btn-warning btn-approve-meeting btn-sm"
                                                    onclick="undoApproveMeeting(this);" style="color: white !important;"
                                                    data-toggle="tooltip" data-placement="top" title="Decline meeting"><i
                                                        class="fa fa-times"></i></a>
                                            @endif --}}
                                                <a href="javascript:void(0)"
                                                    data-value="delete_meeting/{{ $d->id }}"
                                                    class="btn btn-danger btn-delete-meeting btn-sm"
                                                    onclick="removeMeeting(this);" style="color: white !important;"
                                                    data-toggle="tooltip" data-placement="top" title="Delete meeting"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- Card footer -->
                <input id="zoom_room_id" type="hidden" name="zoom_room_id">
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalUserParticipants" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Registered</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="border: none !important; left: 92% !important; padding-top: 13px;"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="registered-user-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- @if ($d->approve == false) --}}
                    <a href="javascript:void(0)" class="btn btn-primary btn-approve-meeting"
                        style="color: white !important; display: none;" data-toggle="tooltip" data-placement="top"
                        title="Approve meeting"><i class="fa fa-check"></i>&nbsp;Approve</a>
                    {{-- @endif
                    @if ($d->approve == true) --}}
                    <a href="javascript:void(0)" class="btn btn-warning btn-decline-meeting"
                        style="color: white !important; display: none;" data-toggle="tooltip" data-placement="top"
                        title="Decline meeting"><i class="fa fa-times"></i>&nbsp;Decline</a>
                    {{-- @endif --}}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{ asset('vendor/datetimepicker/moment.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('vendor/datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/datatable/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('css/dashboard/vendor/select2/dist/js/select2.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="{{ asset('vendor/lc_switch/lc_switch.min.js') }}"></script>
    <script type="text/javascript">
        $(document).on("click", ".btn-user-participants", function() {
            var Id = $(this).data('value');
            var approve_url = $(this).data('value-approve');
            var decline_url = $(this).data('value-decline');
            var duration = $(this).data('duration');
            var start_time = $(this).data('start-time');
            var topic = $(this).data('topic');
            var approve = $(this).data('approve');

            if (approve == 1) {
                $('.btn-approve-meeting').hide();
                $('.btn-decline-meeting').show();

                $('.btn-decline-meeting').attr('data-value', Id);
                $('.btn-decline-meeting').attr('data-value-decline', decline_url);
                $('.btn-decline-meeting').attr('data-duration', duration);
                $('.btn-decline-meeting').attr('data-start-time', start_time);
                $('.btn-decline-meeting').attr('data-topic', topic);
                $('.btn-decline-meeting').attr('data-approve', approve);

                $('.btn-decline-meeting').attr('onclick', 'undoApproveMeeting(this)');

            } else {
                $('.btn-approve-meeting').show();
                $('.btn-decline-meeting').hide();

                $('.btn-approve-meeting').attr('data-value', Id);
                $('.btn-approve-meeting').attr('data-value-approve', approve_url);
                $('.btn-approve-meeting').attr('data-duration', duration);
                $('.btn-approve-meeting').attr('data-start-time', start_time);
                $('.btn-approve-meeting').attr('data-topic', topic);
                $('.btn-approve-meeting').attr('data-approve', approve);

                $('.btn-approve-meeting').attr('onclick', 'approveMeeting(this)');
            }
        });
        $(document).ready(function() {
            var table = $('#meeting-table').DataTable({
                responsive: true,
                "scrollX": true,
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });

            var tableUser = $('#registered-user-table').DataTable({
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                },
                'columnDefs': [{
                    "targets": 1, // your case first column
                    "className": "text-left"
                }]
            });

            $('[data-toggle="tooltip"]').tooltip();
            // Animate select box length
            var searchInput = $(".search-box input");
            var inputGroup = $(".search-box .input-group");
            var boxWidth = inputGroup.width();
            searchInput.focus(function() {
                inputGroup.animate({
                    width: "300"
                });
            }).blur(function() {
                inputGroup.animate({
                    width: boxWidth
                });
            });

            $('.btn-submit').click(function(e) {

                let minute = $('.minute').val();
                let topic = $('.topic').val();
                let start_time = $('#inputStartTime').val();
                let password = $('#passwordZoom').val();
                console.log(need_approval)

                var isFormValid = true;

                $(".required").each(function() {
                    if ($.trim($(this).val()).length == 0) {
                        isFormValid = false;
                    } else {}
                });

                if (!isFormValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please fill in all the required fields (indicated by *)',
                    })

                } else {
                    Swal.fire({
                        title: 'Are you sure',
                        text: "You want create meeting?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Please Wait...',
                                html: '<div class="loader"></div>',
                                allowOutsideClick: false,
                                showConfirmButton: false
                            });
                            window.location.href =
                                "{{ $VC_OWN_URL }}/create_meeting/?duration=" + minute +
                                "&topic=" + topic + "&start_time=" +
                                start_time + "&password=" +
                                password;

                        }
                    })
                }
            });

            $.fn.modal.Constructor.prototype.enforceFocus = function() {};

            $('.btn-user-participants').click(function() {
                $('#zoom_room_id').val($(this).attr('data-value'));
            });

            $('.btn-user-participants').click(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('/video_conference/view_invitation_admin') }}",
                    method: "POST",
                    data: {
                        zoom_room_id: $('#zoom_room_id').val()
                    },
                }).done(function(response) {
                    if (response.status == 200) {
                        tableUser.clear();
                        $.each(response.data, function(row) {

                            tableUser.row.add([
                                this.no,
                                this.company + "(" + this.email + ")",
                                this.type
                            ]);
                        });
                        tableUser.draw();
                    }
                }).fail(function(jqXHR, textStatus) {
                    $('#exampleModalUserParticipants').modal('toggle');
                })
            });
        })

        function approveMeeting(d) {

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this meeting?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Please Wait...',
                        html: '<div class="loader"></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });

                    window.location.href = "{{ url('video_conference') }}/" + d.getAttribute(
                            "data-value-approve") +
                        "/?duration=" + d.getAttribute("data-duration") +
                        "&topic=" + d.getAttribute("data-topic") +
                        "&start_time=" + d.getAttribute("data-start-time") +
                        "&password=" + Math.random().toString(36).slice(-8);
                }
            })

        }

        function removeMeeting(d) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This process can not be reverted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Please Wait...',
                        html: '<div class="loader"></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                    window.location.href = "{{ url('video_conference') }}/" + d.getAttribute("data-value");
                }
            })

        }

        function undoApproveMeeting(d) {
            console.log(d)
            console.log(d.getAttribute("data-value-decline"))
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to decline this meeting?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Please Wait...',
                        html: '<div class="loader"></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                    window.location.href = "{{ url('video_conference') }}/" + d.getAttribute(
                        "data-value-decline");
                }
            })

        }

        function generateRandPass() {
            $("#passwordZoom").val('');
            $("#passwordZoom").val(Math.random().toString(36).slice(-8));
        }
    </script>
@endsection
