@extends('header2')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Bootstrap CSS -->


<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/jquery.datetimepicker.css') }}" />
{{--
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatable/jquery.dataTables.min.css') }}" /> --}}
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

    .px76 {
        width: 76px;
        max-width: 76px;
        word-wrap: break-word;
        align-items: center;
    }

    .custom-toggle-slider {
        top: -2px !important;
    }
</style>
{{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Business Matching</h3>
                </div>
                <?php
                $url = "https://zoom.us/oauth/authorize?response_type=code&client_id=$ZOOM_CLIENT_ID&redirect_uri=$ZOOM_REDIRECT_URI";
                ?>
                <div class="card-body pb-0 pl-4 pt-4">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block" style="text-align: center">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if ($is_login == true)
                    @if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8)
                    <a href="javascript:void(0);" id="btn-create-meeting" class="btn btn-success ml-4"><i
                            class="fa fa-plus"></i> Create
                        Business Matching</a>
                    @endif
                    <div id="form-create-update-meeting" class="col-lg-12" style="display: none;">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputMeetingTopic"
                                        class="col-sm-3 col-form-label font-weight-bold">Topic <span
                                            style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control topic required create-input"
                                            id="inputMeetingTopic" placeholder="Input meeting topic" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputStartTime" class="col-sm-3 col-form-label font-weight-bold">Start
                                        Time (UTC+7)<span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control topic required create-input"
                                            id="inputStartTime" placeholder="" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputMeetingDuration"
                                        class="col-sm-3 col-form-label font-weight-bold">Duration (in Minute)<span
                                            style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number"
                                            class="form-control minute required create-input number-only"
                                            id="inputMeetingDuration" placeholder="Input meeting duration (in Minute)"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="passwordZoom" class="col-sm-3 col-form-label font-weight-bold">Password
                                        <span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control password required create-input"
                                            id="passwordZoom" placeholder="Password" required>
                                        <a href="javascript:void(0)" style="text-decoration: none;"
                                            onMouseOver="this.style.cursor='pointer'" onclick="generateRandPass()"><i
                                                class="fa fa-cog"></i>&nbsp;Generate Random Password</a>
                                    </div>
                                </div>

                                <div class="form-group row mb-2 ml-2">
                                    <label for="buyerCountry" class="col-sm-3 col-form-label font-weight-bold">Buyer
                                        Country <span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <select id="buyerCountry"
                                            class="js-example-basic-single form-control create-input required"
                                            name="buyer_country" style="width: 100%">
                                            <option></option>
                                            @foreach ($country as $c)
                                            <option value="{{ $c->id }}">{{ $c->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputPerwadagMeetingQuota"
                                        class="col-sm-3 col-form-label font-weight-bold">Perwadag's
                                        Quota <span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number"
                                            class="form-control perwadag-quota required create-input number-only"
                                            id="inputPerwadagMeetingQuota" placeholder="Input Perwadag meeting Quota"
                                            required>
                                    </div>

                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputBuyerMeetingQuota"
                                        class="col-sm-3 col-form-label font-weight-bold">Buyer's
                                        Quota <span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number"
                                            class="form-control buyer-quota required create-input number-only"
                                            id="inputBuyerMeetingQuota" placeholder="Input Buyer meeting Quota"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputExportirMeetingQuota"
                                        class="col-sm-3 col-form-label font-weight-bold">Supplier's
                                        Quota <span style="color:#ff0000">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number"
                                            class="form-control exportir-quota required create-input number-only"
                                            id="inputExportirMeetingQuota" placeholder="Input Supplier meeting Quota"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2 ml-2">
                                    <label for="inputNeedApproval" class="col-sm-3 col-form-label font-weight-bold">Need
                                        Approval</label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" class="form-check-input mt-3 ml-0" id="need_approval"
                                            name="need_approval">
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12 pt-2">
                                    <div class="col text-left">
                                        <button type="button" class="btn btn-danger btn-cancel"><i
                                                class="fa fa-close"></i>
                                            Cancel</button>
                                        <button type="button" class="btn btn-success btn-submit"><i
                                                class="fa fa-save"></i>
                                            <span class="label-submit-btn">Create Meeting</span></button>
                                    </div>
                                </div>
                                <input type="hidden" name="meeting_id" id="meeting_id">
                                <input type="hidden" id="action_type">
                            </div>
                        </div>
                    </div>

                    @else
                    @if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8)
                    <a href="{{ $url }}" type="submit" class="btn btn-success ml-4">Login Zoom</a>
                    <label class="control-label font-italic text-blue">Please login to take an action</label>
                    @endif
                    @endif
                </div>
                <!-- Light table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="meeting-table"
                            data-plugin="dataTable">
                            <thead class="text-white" style="background-color:#6B7BD6">
                                <tr>
                                    <th style="text-align: center;">#</th>
                                    <th style="text-align: center;">Zoom Meeting ID</th>
                                    <th style="text-align: center;">Password</th>
                                    <th style="text-align: center;">Topic</th>
                                    <th style="text-align: center;">Start Time</th>
                                    <th style="text-align: center;">Duration (minute)</th>
                                    <th style="text-align: center;">Buyer Country</th>
                                    <th style="text-align: center;">Quota</th>
                                    <th style="text-align: center;">Join Url</th>
                                    <th style="text-align: center;">Need Approval</th>
                                    <th style="text-align: center;">Potential Transaction Value</th>
                                    @if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8)
                                    <th style="text-align: center;">Action</th>
                                    @endif
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
                                        {{ date('d F Y H:i:s', strtotime($d->start_time)) }} (UTC+7)
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->duration }}</td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        {{ $d->country->country }}</td>
                                    <td style="vertical-align: middle;">
                                        Perwadag Quota : {{ $d->perwadag_quota }}<br />
                                        Supplier Quota &nbsp;&nbsp;&nbsp;&nbsp;: {{ $d->exportir_quota }}<br />
                                        Buyer Quota &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                        {{ $d->buyer_quota }}<br />
                                    </td>
                                    <td style="text-align: center; vertical-align:middle">
                                        <a target="_blank" href="{{ $d->join_url }}"
                                            style="text-decoration: none; color:#3FBAE4">{{ $d->join_url }}</a>
                                    </td>
                                    <td style="text-align: center; vertical-align:middle">
                                        {{ $d->need_approval == true ? 'Yes' : 'No' }}</td>
                                    <td style="text-align: left; vertical-align:middle">
                                        $ {{ number_format($d->potential_transaction_value, 0, '.', ',') }}
                                    </td>
                                    @if (Auth::user()->id_group == 1 || Auth::user()->id_group == 8)
                                    <td style="text-align: center; vertical-align: middle; width: 180px;">
                                        @if ($is_login == true)
                                        @php
                                        $is_future = \Carbon\Carbon::parse($d->start_time) > \Carbon\Carbon::now() ?
                                        false : true;
                                        @endphp
                                        @if ($is_future == false)
                                        <a class="btn btn-warning btn-sm" style="color: white !important;"
                                            data-id="{{ $d->id }}" data-topic="{{ $d->topic }}"
                                            data-start-time="{{ date('d-m-Y H:i', strtotime($d->start_time)) }}"
                                            data-duration="{{ $d->duration }}" data-password="{{ $d->password }}"
                                            data-buyer-country="{{ $d->id_country }}"
                                            data-perwadag-quota="{{ $d->perwadag_quota }}"
                                            data-buyer-quota="{{ $d->buyer_quota }}"
                                            data-exportir-quota="{{ $d->exportir_quota }}"
                                            data-need-approval="{{ $d->need_approval == true ? 1 : 0 }}"
                                            data-exportir-invited="{{ count($d->itdp_company_user_exportir) }}"
                                            data-buyer-invited="{{ count($d->itdp_company_user_buyer) }}"
                                            data-perwadag-invited="{{ count($d->itdp_admin_user) }}"
                                            data-meeting-id="{{ $d->meeting_id }}" data-toggle="tooltip"
                                            data-placement="top" title="Edit data" onclick="editData(this)"><i
                                                class="fa fa-pencil"></i></a>
                                        <span data-toggle="modal" data-target="#exampleModalParticipant"
                                            class="btn-invite-meeting" data-value="{{ $d->id }}">
                                            <a class="btn btn-success btn-sm" style="color: white !important;"
                                                data-toggle="tooltip" data-placement="top" title="Invite user"><i
                                                    class="fa fa-user-plus"></i></a>
                                        </span>

                                        @endif
                                        @if (count($d->itdp_company_user) + count($d->itdp_admin_user) > 0)
                                        <span data-toggle="modal" data-target="#exampleModalUserParticipants"
                                            class="btn-user-participants" data-value="{{ $d->id }}">
                                            <a class="btn btn-primary btn-sm" style="color: white !important;"
                                                data-toggle="tooltip" data-placement="top" title="Registered User"><i
                                                    class="fa fa-user"></i></a>
                                        </span>
                                        @endif
                                        @if ($is_future == true)
                                        <span data-toggle="modal" data-target="#exampleModalPotentialTransactionValue"
                                            class="btn-potential-transaction" data-value="{{ $d->id }}">
                                            <a class="btn btn-primary btn-sm" style="color: white !important;"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Potential Transaction Value"><i class="fa fa-dollar"></i></a>
                                        </span>
                                        @endif
                                        <a href="javascript:void(0)" data-value="delete_meeting/{{ $d->id }}"
                                            class="btn btn-danger btn-delete-meeting btn-sm"
                                            onclick="removeMeeting(this);" style="color: white !important;"
                                            data-toggle="tooltip" data-placement="top" title="Delete meeting"><i
                                                class="fa fa-trash"></i></a>
                                        @endif
                                        @if (Auth::user()->id_group == 11)
                                        @if (count($d->itdp_company_user) + count($d->itdp_admin_user) > 0)
                                        <span data-toggle="modal" data-target="#exampleModalUserParticipants"
                                            class="btn-user-participants" data-value="{{ $d->id }}">
                                            <a class="btn btn-primary btn-sm" style="color: white !important;"
                                                data-toggle="tooltip" data-placement="top" title="Registered User"><i
                                                    class="fa fa-user"></i></a>
                                        </span>
                                        @endif
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- Card footer -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalParticipant" aria-labelledby="exampleModalLabel" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Participant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="border: none !important; left: 92% !important; padding-top: 13px;"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-2">
                        <lable class="control-label col-lg-3 my-auto">Supplier (Quota Remaining:<span
                                id="quota_exportir_remaining"></span>)</lable>
                        <div class="col-lg-9">
                            <select id="myInviteExportir" data-toggle="select"
                                class="js-example-basic-multiple-exportir form-control" name="states_exportir[]"
                                multiple="multiple" data-placeholder="Choose exportir">

                            </select>
                        </div>
                    </div>
                    <hr />
                    <div class="row mb-2">
                        <lable class="control-label col-lg-3 my-auto">Buyer (Quota Remaining:<span
                                id="quota_buyer_remaining"></span>)</lable>
                        <div class="col-lg-9">
                            <select id="myInviteBuyer" data-toggle="select"
                                class="js-example-basic-multiple-buyer form-control" name="states_buyer[]"
                                multiple="multiple" data-placeholder="Choose buyer">

                            </select>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <lable class="control-label col-lg-3 my-auto">Perwakilan (Quota Remaining:<span
                                id="quota_perwadag_remaining"></span>)</lable>
                        <div class="col-lg-9">
                            <select id="myInvitePerwakilan" data-toggle="select"
                                class="js-example-basic-multiple-perwakilan form-control" name="states_perwakilan[]"
                                multiple="multiple" data-placeholder="Choose perwakilan">

                            </select>
                        </div>
                    </div>
                    <input id="zoom_room_id" type="hidden" name="zoom_room_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close-invitation"
                        data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save-invitation"><i class="fa fa-save"></i>
                        Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalUserParticipants" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Registered</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="border: none !important; left: 92% !important; padding-top: 13px;"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <label class="control-label">Quota Remaining Information :</label><br>
                    <button type="button" class="btn btn-primary">
                        <span>Buyer</span>
                        <span class="badge badge-white" style="color: black;font-size: 12px;"
                            id="buyer-quota-remaining">0</span>
                    </button>
                    <button type="button" class="btn btn-primary">
                        <span>Supplier</span>
                        <span class="badge badge-white" style="color: black;font-size: 12px;"
                            id="exportir-quota-remaining">0</span>
                    </button>
                    <button type="button" class="btn btn-primary">
                        <span>Perwadag</span>
                        <span class="badge badge-white" style=" color: black;font-size: 12px;"
                            id="perwadag-quota-remaining">0</span>
                    </button>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="registered-user-table">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Status</th>

                                    <th class="text-center">Aksi</th>
                                    @if (Auth::user()->id_group != 11)
                                    <th class="text-center">Attendance</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalPotentialTransactionValue" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Potential Transaction Value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="border: none !important; left: 92% !important; padding-top: 13px;"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row col-lg-12">
                        <label for="inputPotentialTransactionValue"
                            class="col-sm-3 col-form-label font-weight-bold">Value
                            <span style="color:#ff0000">*</span></label>
                        <div class="input-group col-sm-8">
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="text" class="form-control required-potential create-input"
                                id="inputPotentialTransactionValue" placeholder="Input potential transaction value"
                                required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-submit-potential-value"><i class="fa fa-save"></i>
                        Save</button>
                </div>
            </div>
        </div>
    </div>
    {{--
</div> --}}


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
    $(document).ready(function() {

        $('.number-only').bind('input paste', function(){
            // this.value = this.value.replace(/[^0-9]/g, '');
            this.value = Number(this.value.replace(/\D/g, ''));
        });
        

            $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert-success").slideUp(500);
            });

            var btn_create_meeting = $('#btn-create-meeting');
            var form_create_meeting = $('#form-create-update-meeting');
            var btn_cancel = $('.btn-cancel');

            btn_create_meeting.click(function() {
                $('.js-example-basic-single').select2({
                    placeholder: 'Select country'
                });
                form_create_meeting.slideDown();
                btn_create_meeting.hide();

                $('#action_type').val('create');
                $('.label-submit-btn').text('Create Meeting');
            })

            btn_cancel.click(function() {
                form_create_meeting.slideUp();
                btn_create_meeting.show();
            })

            btn_cancel.click(function() {
                $('.create-input').val('')
            })

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
                }
                @if (Auth::user()->id_group != 11)
                , {
                    "targets": 5, // your case first column
                    "className": "px76",
                    "width": "80px",
                }
                @endif
                ]
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

                let quota = $('.quota').val();
                let minute = $('.minute').val();
                let topic = $('.topic').val();
                let start_time = $('#inputStartTime').val();
                let password = $('#passwordZoom').val();
                let buyer_country = $('#buyerCountry').val();
                let buyer_quota = $('.buyer-quota').val();
                let perwadag_quota = $('.perwadag-quota').val();
                let exportir_quota = $('.exportir-quota').val();
                let need_approval = $('#need_approval').is(":checked") == true ? 'on' : 'off';
                let meeting_id = $('#meeting_id').val();

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
                        title: 'Are you sure?',
                        text: "You want create meeting",
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
                            if ($('#action_type').val() == 'create') {
                                window.location.href =
                                    "{{ $ZOOM_OWN_URL }}/create_meeting/?duration=" + minute +
                                    "&buyer_country=" + buyer_country +
                                    "&buyer_quota=" + buyer_quota +
                                    "&perwadag_quota=" + perwadag_quota + "&exportir_quota=" +
                                    exportir_quota + "&topic=" + topic + "&start_time=" +
                                    start_time + "&password=" +
                                    password + "&need_approval=" +
                                    need_approval + "&meeting_id=" + meeting_id;
                            } else {
                                window.location.href =
                                    "{{ $ZOOM_OWN_URL }}/update_meeting/?duration=" + minute +
                                    "&buyer_country=" + buyer_country +
                                    "&buyer_quota=" + buyer_quota +
                                    "&perwadag_quota=" + perwadag_quota + "&exportir_quota=" +
                                    exportir_quota + "&topic=" + topic + "&start_time=" +
                                    start_time + "&password=" +
                                    password + "&need_approval=" +
                                    need_approval + "&meeting_id=" + meeting_id;
                            }

                        }
                    })
                }
            });

            $('#inputStartTime').datetimepicker({
                mask: '39-19-1999 29:59',
                format: 'd-m-Y H:i',
                formatDate: 'd-m-Y',
                formatTime: 'H:i',
                interval: 15,
                step: 15,
                stepping: 15,
                stepMinute: 15,
            })

            $.fn.modal.Constructor.prototype.enforceFocus = function() {};

            // Modal dialag
            $('#exampleModalParticipant').on('shown.bs.modal', function() {


                $('#myInviteExportir').val(null).trigger('change');
                $('#myInviteExportir').trigger('focus')


                $('#myInviteBuyer').val(null).trigger('change');
                $('#myInviteBuyer').trigger('focus')


                $('#myInvitePerwakilan').val(null).trigger('change');
                $('#myInvitePerwakilan').trigger('focus')



            })


            // Select2
            $('#myInviteExportir').select2({
                width: '100%',
                multiple: true,
                dropdownParent: $('#exampleModalParticipant'),
                placeholder: 'Choose exportir',
                allowClear: true,
                ajax: {
                    url: 'event_zoom/autocomplete-ajax-user-exportir',
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
                    cache: true
                }
            });

            $('#myInviteBuyer').select2({
                width: '100%',
                multiple: true,
                dropdownParent: $('#exampleModalParticipant'),
                placeholder: 'Choose buyer',
                allowClear: true,
                ajax: {
                    url: 'event_zoom/autocomplete-ajax-user-buyer',
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
                                    '(' + d.email +
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
                dropdownParent: $('#exampleModalParticipant'),
                placeholder: 'Choose perwakilan',
                allowClear: true,
                ajax: {
                    url: 'event_zoom/autocomplete-ajax-user-perwakilan',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, d) {
                            // console.log(d)
                            let check_perwadag;
                            if (d.profile_perwadag_ln != null && d.profile_perwadag_dn ==
                                null) {
                                check_perwadag = d.profile_perwadag_ln.nama + "(" + d.email +
                                    ")";
                            } else if (d.profile_perwadag_ln == null && d.profile_perwadag_dn !=
                                null) {
                                check_perwadag = d.profile_perwadag_dn.nama + "(" + d.email +
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

            $('.btn-invite-meeting').click(function() {
                $('#zoom_room_id').val($(this).attr('data-value'));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $(
                            'meta[name="csrf-token"]'
                        ).attr('content')
                    }
                });

                $.ajax({
                    url: "event_zoom/check_remaining_quota",
                    method: "POST",
                    data: {
                        zoom_room_id: $(this).attr('data-value')
                    },
                }).done(function(response) {
                    $('#quota_buyer_remaining').html(response.quota_buyer_remaining)
                    $('#quota_exportir_remaining').html(response
                        .quota_exportir_remaining)
                    $('#quota_perwadag_remaining').html(response
                        .quota_perwadag_remaining)
                })
            });

            $('.btn-user-participants').click(function() {
                $('#zoom_room_id').val($(this).attr('data-value'));
            });

            $('.btn-potential-transaction').click(function() {
                $("#inputPotentialTransactionValue").val('')
                $('#zoom_room_id').val($(this).attr('data-value'));

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "event_zoom/check_potential_transaction_value",
                    method: "POST",
                    data: {
                        zoom_room_id: $(this).attr('data-value')
                    },
                }).done(function(response) {
                    console.log(response.value)
                    let val = response.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g,
                        ",");
                    $("#inputPotentialTransactionValue").val(val)
                })

            });

            $(".btn-save-invitation").click(function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to add this participant",
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

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: "event_zoom/add_invitation",
                            method: "POST",
                            data: {
                                zoom_room_id: $('#zoom_room_id').val(),
                                exportir_id: $("#myInviteExportir").val(),
                                buyer_id: $("#myInviteBuyer").val(),
                                perwakilan_id: $("#myInvitePerwakilan").val(),
                            },
                        }).done(function(response) {
                            Swal.close();
                            if (response.status == 200) {
                                Swal.fire(
                                    'Success!',
                                    'Data saved!',
                                    'success'
                                )
                                $('#exampleModalParticipant').modal('toggle');
                                location.reload();
                            } else if (response.status == 201) {
                                Swal.fire(
                                    'Error!',
                                    'Quota Exceeded!',
                                    'error'
                                )
                            } else if (response.status == 500) {
                                Swal.fire(
                                    'Error!',
                                    'Data not saved!',
                                    'error'
                                )
                            }
                        }).fail(function(jqXHR, textStatus) {
                            Swal.close();
                            $('#exampleModalParticipant').modal('toggle');
                        })

                    }
                })
            })

            $('.btn-user-participants').click(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "event_zoom/view_invitation",
                    method: "POST",
                    data: {
                        zoom_room_id: $('#zoom_room_id').val()
                    },
                }).done(function(response) {
                    // console.log(response)
                    if (response.status == 200) {
                        $('#loader-img').hide();
                        tableUser.clear();
                        $.each(response.data, function(row) {
                            let btn_verification;
                            if (this.is_verified == null || this.is_verified == false) {
                                btn_verification =
                                    @if (Auth::user()->id_group != 11)
                                        "<a class='btn btn-sm btn-success verification-user-registered' href='#' data-value=" +
                                        this.id + " data-room-id=" + this.zoom_room_id +
                                        " data-verification='1' data-type=" + this.type +
                                        " title='Click to verifiy'><i class='fa fa-check ' style='color:white'></i></a>";
                                    @else
                                        ""
                                    @endif
                            } else if (this.is_verified == true) {
                                btn_verification =
                                    @if (Auth::user()->id_group != 11)
                                        "<a class='btn btn-sm btn-warning verification-user-registered' href='#' data-value=" +
                                        this.id + " data-room-id=" + this.zoom_room_id +
                                        " data-verification='0' data-type=" + this.type +
                                        " title='Click to unverifiy'><i class='fa fa-times ' style='color:white'></i></a>";
                                    @else
                                        ""
                                    @endif
                            }
                            // console.log(this.attendance)
                            let btn_download = '';
                            let url_download_supplier =
                                "{{ url('/front_end/listeksportir/cetakpdfnew/') }}" +
                                "/" + this.company_id;
                            // let url_download_buyer = "{{ url('/front_end/listeksportir/cetakpdfnew/') }}" + "/" + this.company_id;
                            // let url_download_perwadag = "{{ url('/front_end/listeksportir/cetakpdfnew/') }}" + "/" + this.id;
                            if (this.is_verified == true && this.type == 'Supplier') {
                                btn_download =
                                    `<a title='Print PDF' class='btn btn-sm btn-primary download-user-registered' data-value="${this.id}" data-type="${this.type}" target='_blank' href='${url_download_supplier}'><i class='fa fa-file-pdf-o ' style='color:white'></i></a>`;
                            }
                            // else if(this.is_verified == true && this.type == 'Buyer') {
                            //     btn_download =`<a title='Print PDF' class='btn btn-sm btn-primary download-user-registered' data-value="${this.id}" data-type="${this.type}" target='_blank' href='${url_download_buyer}'><i class='fa fa-file-pdf-o' style='color:white'></i></a>`;
                            // }  else if(this.is_verified == true && this.type == 'Perwakilan') {
                            //     btn_download =`<a title='Print PDF' class='btn btn-sm btn-primary download-user-registered' data-value="${this.id}" data-type="${this.type}" target='_blank' href='${url_download_perwadag}'><i class='fa fa-file-pdf-o' style='color:white'></i></a>`;
                            // }
                            tableUser.row.add([
                                this.no,
                                this.company + "(" + this.email + ")",
                                this.type,
                                (this.is_verified == true) ?
                                '<span class="badge badge-pill badge-success">Verified</span>' :
                                '<span class="badge badge-pill badge-danger">Unverified</span>',
                                btn_verification + btn_download @if (Auth::user()->id_group != 11) +
                                "<a title='Delete' class='btn btn-sm btn-danger delete-user-registered' href='#' data-value=" +
                                this.id + " data-type=" + this.type +
                                " data-room-id=" + this.zoom_room_id +
                                "><i class='fa fa-trash ' style='color:white'></i></a>"
                                @endif
                                @if (Auth::user()->id_group != 11),
                                `<label class='custom-toggle my-auto mx-auto'>
                                    <input type='checkbox' ${(this.attendance == true) ? 'checked': ''} id="checkboxAttendance-${this.id_zoom_room_participants}" data-id-zoom-room-participants="${this.id_zoom_room_participants}" class="checkboxAttendance">
                                    <span class='custom-toggle-slider rounded-circle' data-label-off='No' data-label-on='Yes'></span>
                                </label>`
                                @endif
                            ]);


                            $('#buyer-quota-remaining').html(response.quota_buyer_remaining)
                            $('#exportir-quota-remaining').html(response
                                .quota_exportir_remaining)
                            $('#perwadag-quota-remaining').html(response
                                .quota_perwadag_remaining)
                        });
                        tableUser.draw();
                    }
                }).fail(function(jqXHR, textStatus) {
                    $('#exampleModalUserParticipants').modal('toggle');
                })
            });

            // Delete action
            $('table#registered-user-table').on('click', '.delete-user-registered', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want delete this user",
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

                        let user_id = $(this).attr('data-value');
                        let zoom_room_id = $(this).attr('data-room-id');
                        let type = $(this).attr('data-type');

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $(
                                    'meta[name="csrf-token"]'
                                ).attr('content')
                            }
                        });

                        $.ajax({
                            url: "event_zoom/delete_invitation",
                            method: "DELETE",
                            data: {
                                zoom_room_id: zoom_room_id,
                                user_id: user_id,
                                type: type,
                            },
                        }).done(function(response) {
                            console.log(response)
                            if (response.status == 200) {
                                tableUser.clear()
                                $.each(response.data, function(row) {
                                    let btn_verification;
                                    if (this.is_verified == null || this
                                        .is_verified == false) {
                                        btn_verification =
                                            "<a class='btn btn-success verification-user-registered' href='#' data-value=" +
                                            this.id + " data-room-id=" + this
                                            .zoom_room_id +
                                            " data-verification='1' data-type=" +
                                            this.type +
                                            " title='Click to verifiy'><i class='fa fa-check ' style='color:white'></i></a>";
                                    } else if (this.is_verified == true) {
                                        btn_verification =
                                            "<a class='btn btn-warning verification-user-registered' href='#' data-value=" +
                                            this.id + " data-room-id=" + this
                                            .zoom_room_id +
                                            " data-verification='0' data-type=" +
                                            this.type +
                                            " title='Click to unverifiy'><i class='fa fa-times ' style='color:white'></i></a>";
                                    }

                                    let btn_download = '';
                                    let url_download_supplier =
                                        "{{ url('/front_end/listeksportir/cetakpdfnew/') }}" +
                                        "/" + this.company_id;
                                    if (this.is_verified == true && this.type ==
                                        'Supplier') {
                                        btn_download =
                                            `<a title='Print PDF' class='btn btn-sm btn-primary download-user-registered' data-value="${this.id}" data-type="${this.type}" target='_blank' href='${url_download_supplier}'><i class='fa fa-file-pdf-o ' style='color:white'></i></a>`;
                                    }
                                    tableUser.row.add([
                                        this.no,
                                        this.company + "(" + this.email +
                                        ")",
                                        this.type,
                                        (this.is_verified == true) ?
                                        '<span class="badge badge-pill badge-success">Verified</span>' :
                                        '<span class="badge badge-pill badge-danger">Unverified</span>',
                                        btn_verification + btn_download +
                                        "<a title='Delete' class='btn btn-danger delete-user-registered' href='#' data-value=" +
                                        this.id + " data-type=" + this
                                        .type +
                                        " data-room-id=" + this
                                        .zoom_room_id +
                                        "><i class='fa fa-trash ' style='color:white'></i></a>",
                                        `<label class='custom-toggle my-auto mx-auto'>
                                            <input type='checkbox' ${(this.attendance == true) ? 'checked': ''} id="checkboxAttendance-${this.id_zoom_room_participants}" 
                                            data-id-zoom-room-participants="${this.id_zoom_room_participants}" class="checkboxAttendance">
                                            <span class='custom-toggle-slider rounded-circle' data-label-off='No' data-label-on='Yes'></span>
                                        </label>`
                                    ]);
                                });
                                tableUser.draw();
                                Swal.close();
                            }

                        }).fail(function(jqXHR, textStatus) {
                            $('#exampleModalUserParticipants').modal(
                                'toggle');
                        })

                    }
                })
            })
            // Delete action

            // Verification action
            $('table#registered-user-table').on('click', '.verification-user-registered', function() {
                let user_id = $(this).attr('data-value');
                let zoom_room_id = $(this).attr('data-room-id');
                let zoom_verification = $(this).attr('data-verification');
                let type = $(this).attr('data-type');

                let verify = (zoom_verification == 1) ? 'verify' : 'unverify';

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want " + verify + " this user",
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

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $(
                                    'meta[name="csrf-token"]'
                                ).attr('content')
                            }
                        });

                        $.ajax({
                            url: "event_zoom/verification",
                            method: "POST",
                            data: {
                                zoom_room_id: zoom_room_id,
                                user_id: user_id,
                                zoom_verification: zoom_verification,
                                type: type
                            },
                        }).done(function(response) {
                            console.log(response)
                            if (response.status == 200) {
                                tableUser.clear();
                                $.each(response.data, function(
                                    row) {
                                    let btn_verification;
                                    if (this.is_verified == null || this
                                        .is_verified == false) {
                                        btn_verification =
                                            "<a class='btn btn-success verification-user-registered' href='#' data-value=" +
                                            this.id + " data-room-id=" + this
                                            .zoom_room_id +
                                            " data-verification='1' data-type=" +
                                            this.type +
                                            " title='Click to verifiy'><i class='fa fa-check ' style='color:white'></i></a>";
                                    } else if (this.is_verified == true) {
                                        btn_verification =
                                            "<a class='btn btn-warning verification-user-registered' href='#' data-value=" +
                                            this.id + " data-room-id=" + this
                                            .zoom_room_id +
                                            " data-verification='0' data-type=" +
                                            this.type +
                                            " title='Click to unverifiy'><i class='fa fa-times ' style='color:white'></i></a>";
                                    }
                                    let btn_download = '';
                                    let url_download_supplier =
                                        "{{ url('/front_end/listeksportir/cetakpdfnew/') }}" +
                                        "/" + this.company_id;
                                    if (this.is_verified == true && this.type ==
                                        'Supplier') {
                                        btn_download =
                                            `<a title='Print PDF' class='btn btn-sm btn-primary download-user-registered' data-value="${this.id}" data-type="${this.type}" target='_blank' href='${url_download_supplier}'><i class='fa fa-file-pdf-o ' style='color:white'></i></a>`;
                                    }
                                    tableUser.row.add([
                                        this.no,
                                        this.company + "(" + this.email +
                                        ")",
                                        this.type,
                                        (this.is_verified == true) ?
                                        '<span class="badge badge-pill badge-success">Verified</span>' :
                                        '<span class="badge badge-pill badge-danger">Unverified</span>',
                                        btn_verification + btn_download +
                                        "<a title='Delete' class='btn btn-danger delete-user-registered' href='#' data-value=" +
                                        this
                                        .id +
                                        " data-room-id=" +
                                        this
                                        .zoom_room_id +
                                        "><i class='fa fa-trash' style='color:white'></i></a>",
                                        `<label class='custom-toggle my-auto mx-auto'>
                                            <input type='checkbox' ${(this.attendance == true) ? 'checked': ''} id="checkboxAttendance-${this.id_zoom_room_participants}"  data-id-zoom-room-participants="${this.id_zoom_room_participants}">
                                            <span class='custom-toggle-slider rounded-circle' data-label-off='No' data-label-on='Yes'></span>
                                        </label>`
                                    ]);
                                });
                                tableUser.draw();
                                Swal.close()
                            }

                        }).fail(function(jqXHR, textStatus) {
                            $('#exampleModalUserParticipants').modal(
                                'toggle');
                        })

                    }
                })
            })
            // Verification action

            // Attendance
            $('table#registered-user-table').on('change', '.checkboxAttendance', function() {
                let check_attendance = ''
                let id_zoom_participants = $(this).attr('data-id-zoom-room-participants')
                if ($("#checkboxAttendance-" + id_zoom_participants).prop('checked') == true) {
                    check_attendance = 'present';

                } else if ($("#checkboxAttendance-" + id_zoom_participants).prop('checked') == false) {
                    // console.log('unchecked');
                    check_attendance = 'not present';
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want mark as " + check_attendance + "?",
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


                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $(
                                    'meta[name="csrf-token"]'
                                ).attr('content')
                            }
                        });

                        $.ajax({
                            url: "event_zoom/attendance",
                            method: "POST",
                            data: {
                                id_zoom_participants: id_zoom_participants,
                                attendance: (check_attendance == 'present') ? true : false,
                            },
                        }).done(function(response) {
                            console.log(response)
                            if (response.status == 200) {
                                tableUser.clear();
                                $.each(response.data, function(
                                    row) {
                                    let btn_verification;
                                    if (this.is_verified == null || this
                                        .is_verified == false) {
                                        btn_verification =
                                            "<a class='btn btn-success verification-user-registered' href='#' data-value=" +
                                            this.id + " data-room-id=" + this
                                            .zoom_room_id +
                                            " data-verification='1' data-type=" +
                                            this.type +
                                            " title='Click to verifiy'><i class='fa fa-check ' style='color:white'></i></a>";
                                    } else if (this.is_verified == true) {
                                        btn_verification =
                                            "<a class='btn btn-warning verification-user-registered' href='#' data-value=" +
                                            this.id + " data-room-id=" + this
                                            .zoom_room_id +
                                            " data-verification='0' data-type=" +
                                            this.type +
                                            " title='Click to unverifiy'><i class='fa fa-times ' style='color:white'></i></a>";
                                    }
                                    let btn_download = '';
                                    let url_download_supplier =
                                        "{{ url('/front_end/listeksportir/cetakpdfnew/') }}" +
                                        "/" + this.company_id;
                                    if (this.is_verified == true && this.type ==
                                        'Supplier') {
                                        btn_download =
                                            `<a title='Print PDF' class='btn btn-sm btn-primary download-user-registered' data-value="${this.id}" data-type="${this.type}" target='_blank' href='${url_download_supplier}'><i class='fa fa-file-pdf-o ' style='color:white'></i></a>`;
                                    }
                                    tableUser.row.add([
                                        this.no,
                                        this.company + "(" + this.email +
                                        ")",
                                        this.type,
                                        (this.is_verified == true) ?
                                        '<span class="badge badge-pill badge-success">Verified</span>' :
                                        '<span class="badge badge-pill badge-danger">Unverified</span>',
                                        btn_verification + btn_download +
                                        "<a title='Delete' class='btn btn-danger delete-user-registered' href='#' data-value=" +
                                        this
                                        .id +
                                        " data-room-id=" +
                                        this
                                        .zoom_room_id +
                                        "><i class='fa fa-trash' style='color:white'></i></a>",
                                        `<label class='custom-toggle my-auto mx-auto'>
                                            <input type='checkbox' ${(this.attendance == true) ? 'checked': ''} id="checkboxAttendance-${this.id_zoom_room_participants}" 
                                            data-id-zoom-room-participants="${this.id_zoom_room_participants}"
                                            class="checkboxAttendance"
                                            >
                                            <span class='custom-toggle-slider rounded-circle' data-label-off='No' data-label-on='Yes'></span>
                                        </label>`
                                    ]);
                                });
                                tableUser.draw();
                                Swal.close()
                            }

                        }).fail(function(jqXHR, textStatus) {
                            $('#exampleModalUserParticipants').modal(
                                'toggle');
                        })

                    } else {
                        console.log()
                        if ($("#checkboxAttendance-" + id_zoom_participants).is(":checked") ==
                            true) {
                            $("#checkboxAttendance-" + id_zoom_participants).prop('checked', false)

                        } else if ($("#checkboxAttendance-" + id_zoom_participants).is(
                                ":checked") == false) {
                            // console.log('unchecked');
                            $("#checkboxAttendance-" + id_zoom_participants).prop(
                                'checked', true)
                        }
                    }
                })
            })
            // Attendance

            $('.btn-submit-potential-value').click(function() {
                let value = $('#inputPotentialTransactionValue').val();
                var isFormValid = true;

                $(".required-potential").each(function() {
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
                        title: 'Are you sure?',
                        text: "You want to save potential transaction value",
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

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });

                            $.ajax({
                                url: "event_zoom/add_potential_transaction_value",
                                method: "POST",
                                data: {
                                    zoom_room_id: $('#zoom_room_id').val(),
                                    potential_value: $("#inputPotentialTransactionValue")
                                        .val()
                                },
                            }).done(function(response) {
                                Swal.close();
                                if (response.status == 200) {
                                    Swal.fire(
                                        'Success!',
                                        'Data saved!',
                                        'success'
                                    )
                                    $('#exampleModalPotentialTransactionValue').modal(
                                        'toggle');
                                    location.reload();
                                } else if (response.status == 500) {
                                    Swal.fire(
                                        'Error!',
                                        'Data not saved!',
                                        'error'
                                    )
                                }
                            }).fail(function(jqXHR, textStatus) {
                                Swal.close();
                                $('#exampleModalPotentialTransactionValue').modal('toggle');
                            })
                        }
                    })
                }

            })

            $('input#inputPotentialTransactionValue').keyup(function(event) {

                // skip for arrow keys
                if (event.which >= 37 && event.which <= 40) return;

                // format number
                $(this).val(function(index, value) {
                    return value
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            });

        })

        // Lc_switch
        lc_switch('input[type=checkbox], input[type=radio]', {

            // ON text
            on_txt: 'Yes',

            // OFF text
            off_txt: 'No',

            // Custom ON color. Supports gradients
            on_color: false,

            // enable compact mode
            compact_mode: false

        });
        // Lc_switch


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
                    window.location.href = "{{ $ZOOM_OWN_URL }}/" + d.getAttribute("data-value");
                }
            })

        }

        function generateRandPass() {
            $("#passwordZoom").val('');
            $("#passwordZoom").val(Math.random().toString(36).slice(-8));
        }


        function editData(d) {
            var btn_create_meeting = $('#btn-create-meeting');
            var form_create_meeting = $('#form-create-update-meeting');
            var btn_cancel = $('.btn-cancel');

            $('.js-example-basic-single').select2({
                placeholder: 'Select country'
            });
            form_create_meeting.slideDown();
            btn_create_meeting.hide();

            $('#action_type').val('update');
            $('#meeting_id').val(d.getAttribute('data-meeting-id'));
            $('.label-submit-btn').text('Update Meeting');

            $('#inputMeetingTopic').val(d.getAttribute('data-topic'))
            $('#inputStartTime').val(d.getAttribute('data-start-time'))
            $('#inputMeetingDuration').val(d.getAttribute('data-duration'))
            $('#passwordZoom').val(d.getAttribute('data-password'))
            // console.log(d.getAttribute('data-buyer-country'))
            $("#buyerCountry").val(d.getAttribute('data-buyer-country')).trigger('change');
            $('#inputPerwadagMeetingQuota').val(d.getAttribute('data-perwadag-quota'))
            $('#inputBuyerMeetingQuota').val(d.getAttribute('data-buyer-quota'))
            $('#inputExportirMeetingQuota').val(d.getAttribute('data-exportir-quota'))
            if (d.getAttribute('data-need-approval') == 1) {
                const inputs = document.querySelectorAll('input[type=checkbox], input[type=radio]');
                lcs_on(inputs);
            } else {
                const inputs = document.querySelectorAll('input[type=checkbox], input[type=radio]');
                lcs_off(inputs);
            }
            // console.log(d.getAttribute('data-exportir-invited'))
            // console.log(d.getAttribute('data-buyer-invited'))
            // console.log(d.getAttribute(' data-perwadag-invited'))

            $('#inputPerwadagMeetingQuota').on('input', function() {
                // console.log($('#inputPerwadagMeetingQuota').val(), d.getAttribute('data-perwadag-invited'))
                if ($('#inputPerwadagMeetingQuota').val() < d.getAttribute('data-perwadag-invited')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Perwadag Quota can't less than " + d.getAttribute('data-perwadag-invited'),
                    })
                    $('#inputPerwadagMeetingQuota').val(d.getAttribute('data-perwadag-invited'))
                }
            });

            $('#inputExportirMeetingQuota').on('input', function() {
                // console.log($('#inputExportirMeetingQuota').val(), d.getAttribute('data-exportir-invited'))
                if ($('#inputExportirMeetingQuota').val() < d.getAttribute('data-exportir-invited')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Supplier Quota can't less than " + d.getAttribute('data-exportir-invited'),
                    })
                    $('#inputExportirMeetingQuota').val(d.getAttribute('data-exportir-invited'))
                }
            });

            $('#inputBuyerMeetingQuota').on('input', function() {
                // console.log($('#inputBuyerMeetingQuota').val(), d.getAttribute('data-buyer-invited'))
                if ($('#inputBuyerMeetingQuota').val() < d.getAttribute('data-buyer-invited')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Buyer Quota can't less than " + d.getAttribute('data-buyer-invited'),
                    })
                    $('#inputBuyerMeetingQuota').val(d.getAttribute('data-buyer-invited'))
                }
            });
        }

        $(".btn-cancel").click(function() {
            $(this).find("input[type=text],input[type=number], select").val("");
            const inputs = document.querySelectorAll('input[type=checkbox], input[type=radio]');
            lcs_off(inputs);
        });
</script>
@endsection