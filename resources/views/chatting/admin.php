@extends('header2')
@section('content')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> --}}
    <div class="padding">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">

                        <div class="col-md-14">
                            <div class="">


                                <style>
                                    @import url('https://fonts.googleapis.com/css?family=Open+Sans');

                                    body {
                                        font-family: Arial;
                                    }

                                    .select2-container--default .select2-selection--single {
                                        background-color: #fff !important;
                                        border: 1px solid rgba(120, 130, 140, 0.5) !important;
                                        border-radius: 4px !important;
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

                                    .chat {
                                        list-style: none;
                                        margin: 0;
                                        padding: 0;
                                    }

                                    .chat li {
                                        margin-bottom: 10px;
                                        padding-bottom: 5px;
                                        border-bottom: 1px dotted #B3A9A9;
                                    }

                                    .chat li.left .chat-body {
                                        margin-left: 10px;
                                    }

                                    .chat li.right .chat-body {
                                        margin-right: 10px;
                                    }


                                    .chat li .chat-body p {
                                        margin: 0;
                                        color: #777777;
                                    }

                                    .panel .slidedown .glyphicon,
                                    .chat .glyphicon {
                                        margin-right: 5px;
                                    }

                                    .panel-body {

                                        height: 280px;
                                    }

                                    ::-webkit-scrollbar-track {
                                        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                                        background-color: #F5F5F5;
                                    }

                                    ::-webkit-scrollbar {
                                        width: 10px;
                                        background-color: #F5F5F5;
                                    }

                                    ::-webkit-scrollbar-thumb {
                                        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
                                        background-color: #555;
                                    }

                                    .opensans {
                                        font-family: "Open Sans", sans-serif;
                                    }

                                    label.text-break {
                                        color: black !important;
                                    }

                                    .text-muted {
                                        color: #868e96 !important;
                                        opacity: 1 !important;
                                    }

                                    .glyphicon.glyphicon-time {
                                        color: black !important;
                                    }

                                    p {
                                        color: black !important;
                                    }

                                    .img-circle {
                                        background-color: #FFFFFF;
                                        margin-bottom: 10px;
                                        padding: 4px;
                                        border-radius: 50% !important;
                                        max-width: 100%;
                                    }

                                    .loader {
                                        border: 5px solid #f3f3f3;
                                        -webkit-animation: spin 1s linear infinite;
                                        animation: spin 1s linear infinite;
                                        border-top: 5px solid #555;
                                        border-radius: 50%;
                                        width: 50px;
                                        height: 50px;
                                        margin-right: 25px;
                                    }

                                    @-webkit-keyframes spin {
                                        0% {
                                            -webkit-transform: rotate(0deg);
                                            -ms-transform: rotate(0deg);
                                            transform: rotate(0deg);
                                        }

                                        100% {
                                            -webkit-transform: rotate(360deg);
                                            -ms-transform: rotate(360deg);
                                            transform: rotate(360deg);
                                        }
                                    }

                                    @keyframes spin {
                                        0% {
                                            -webkit-transform: rotate(0deg);
                                            -ms-transform: rotate(0deg);
                                            transform: rotate(0deg);
                                        }

                                        100% {
                                            -webkit-transform: rotate(360deg);
                                            -ms-transform: rotate(360deg);
                                            transform: rotate(360deg);
                                        }
                                    }

                                </style>
                                <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css"
                                    rel="stylesheet">
                                {{ csrf_field() }}
                                <input type="hidden" id="id_pengirim"
                                    value="{{ Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id }}">
                                <table width="100%" class="opensans">
                                    <tr>
                                        <td width="50%" valign="top">
                                            <div class="form-row" align="left">
                                                <div class="col-md-12">
                                                    <div>
                                                        <br>
                                                        @if (Auth::guard('eksmp')->user() != '')
                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label
                                                                        class="text-break"><b>{{ ucfirst($admin_group_name) }}</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        @if ($admin_user->profile_perwadag_ln != '')
                                                                            {{ $admin_user->name }}
                                                                            @if (Cache::has('user-is-online-' . $admin_user->id))
                                                                                <label
                                                                                    class="text-success font-weight-bold">(Online)</label>
                                                                            @else
                                                                                <label
                                                                                    class="text-danger font-weight-bold">(Offline)</label>
                                                                            @endif
                                                                        @elseif ($admin_user->profile_perwadag_dn != '')
                                                                            {{ $admin_user->name }}
                                                                            @if (Cache::has('user-is-online-' . $admin_user->id))
                                                                                <label
                                                                                    class="text-success font-weight-bold">(Online)</label>
                                                                            @else
                                                                                <label
                                                                                    class="text-danger font-weight-bold">(Offline)</label>
                                                                            @endif
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label class="text-break"><b>Tipe</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        {{ $admin_user->type }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @if ($admin_user->profile_perwadag_ln != '')
                                                                <div class="form-row">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                                        <label class="text-break"><b>Negara</b></label>
                                                                    </div>
                                                                    <div>:</div>
                                                                    <div class="col-lg-7 col-md-9 col-sm-11">
                                                                        @php
                                                                            if ($admin_user->profile_perwadag_ln->country_tambahan != '') {
                                                                                $countries = explode(',', $admin_user->profile_perwadag_ln->country_tambahan);
                                                                            } else {
                                                                                $countries = [];
                                                                            }
                                                                            
                                                                            if ($admin_user->profile_perwadag_ln->country != '') {
                                                                                $main_countries = explode(',', $admin_user->profile_perwadag_ln->country);
                                                                            } else {
                                                                                $main_countries = [];
                                                                            }
                                                                            
                                                                            $unique_countries = array_unique(array_merge($countries, $main_countries));
                                                                            $merge_countries = array_filter($unique_countries, function ($value) {
                                                                                return !is_null($value) && $value !== '';
                                                                            });
                                                                        @endphp
                                                                        <label class="text-break">
                                                                            @php
                                                                                $length = count($merge_countries);
                                                                            @endphp
                                                                            @if ($length > 0)
                                                                                @foreach ($merge_countries as $key => $c)
                                                                                    {{ rc_country($c) }}@if ($key + 1 != $length),@endif
                                                                                @endforeach
                                                                            @endif

                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label class="text-break"><b>Pejabat</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        @if ($admin_user->profile_perwadag_ln != '')
                                                                            {{ $admin_user->profile_perwadag_ln->nama }}
                                                                        @else
                                                                            {{ $admin_user->profile_perwadag_dn->nama }}
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label class="text-break"><b>Kepala</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        @if ($admin_user->profile_perwadag_ln != '')
                                                                            {{ $admin_user->profile_perwadag_ln->kepala }}
                                                                        @else
                                                                            {{ $admin_user->profile_perwadag_dn->kepala }}
                                                                        @endif

                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label class="text-break"><b>Telp</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        @if ($admin_user->profile_perwadag_ln != '')
                                                                            {{ $admin_user->profile_perwadag_ln->telp }}
                                                                        @else
                                                                            {{ $admin_user->profile_perwadag_dn->telp }}
                                                                        @endif

                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label class="text-break"><b>Email</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        @if ($admin_user->profile_perwadag_ln != '')
                                                                            <a
                                                                                href="mailto:{{ $admin_user->profile_perwadag_ln->email }}">{{ $admin_user->profile_perwadag_ln->email }}</a>
                                                                        @else
                                                                            <a
                                                                                href="mailto:{{ $admin_user->profile_perwadag_dn->email }}">{{ $admin_user->profile_perwadag_dn->email }}</a>
                                                                        @endif

                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label class="text-break"><b>Website</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        {{ $admin_user->website }}
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        @elseif(Auth::user() != '')
                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label
                                                                        class="text-break"><b>{{ ucfirst($company_group_name) }}</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        @if ($company_user->profile != '')
                                                                            {{ $company_user->profile->company }},
                                                                            {{ $company_user->profile->badanusaha }}

                                                                            @if (Cache::has('user-is-eksmp-' . $company_user->id))
                                                                                <label
                                                                                    class="text-success font-weight-bold">(Online)</label>
                                                                            @else
                                                                                <label
                                                                                    class="text-danger font-weight-bold">(Offline)</label>
                                                                            @endif
                                                                        @elseif($company_user->profile_buyer != '')
                                                                            {{ $company_user->profile_buyer->company }}
                                                                            @if (Cache::has('user-is-eksmp-' . $company_user->id))
                                                                                <label
                                                                                    class="text-success font-weight-bold">(Online)</label>
                                                                            @else
                                                                                <label
                                                                                    class="text-danger font-weight-bold">(Offline)</label>
                                                                            @endif
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label class="text-break"><b>Email</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        {{ $company_user->email }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @if ($company_user->id_role == 3)
                                                                <div class="form-row">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                                        <label class="text-break">
                                                                            <b>Negara Buyer</b>
                                                                        </label>
                                                                    </div>
                                                                    <div>:</div>
                                                                    <div class="col-lg-7 col-md-9 col-sm-11">
                                                                        <label class="text-break">
                                                                            {{ $company_user->profile_buyer->country->country }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="form-row">
                                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                                    <label class="text-break"><b>Address</b></label>
                                                                </div>
                                                                <div>:</div>
                                                                <div class="col-lg-7 col-md-9 col-sm-11">

                                                                    <label class="text-break">
                                                                        {{ $company_user->profile != '' ? $company_user->profile->addres : $company_user->profile_buyer->addres }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @if ($company_user->id_role == 2)
                                                                <div class="form-row">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                                        <label class="text-break"><b>PIC
                                                                                Name</b></label>
                                                                    </div>
                                                                    <div>:</div>
                                                                    <div class="col-lg-7 col-md-9 col-sm-11">

                                                                        <label class="text-break">
                                                                            @php
                                                                                $name_pic = '';
                                                                            @endphp
                                                                            @foreach ($company_user->profile->contact_person as $key => $cp)
                                                                                @if ($key == 0)
                                                                                    @php
                                                                                        $name_pic .= $cp->name;
                                                                                    @endphp
                                                                                @else
                                                                                    @php
                                                                                        $name_pic .= ',' . $cp->name;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            {{ $name_pic }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                                        <label class="text-break"><b>PIC
                                                                                Phone</b></label>
                                                                    </div>
                                                                    <div>:</div>
                                                                    <div class="col-lg-7 col-md-9 col-sm-11">

                                                                        <label class="text-break">
                                                                            @php
                                                                                $phone_pic = '';
                                                                            @endphp
                                                                            @foreach ($company_user->profile->contact_person as $key => $cp)
                                                                                @if ($key == 0)
                                                                                    @php
                                                                                        $phone_pic .= $cp->phone;
                                                                                    @endphp
                                                                                @else
                                                                                    @php
                                                                                        $phone_pic .= ',' . $cp->phone;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            {{ $phone_pic }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif

                                                        <input type="hidden" id="id_admin" value="{{ $id_admin }}">
                                                        <input type="hidden" id="id_eks_imp" value="{{ $id_eks_imp }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50%">

                                            <div class="col-sm-12">
                                                <div align="center"><br>
                                                    <center>
                                                        <div class="">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="col-md-12"
                                                                        style="background-color: #1a7688;color:white;border-top-left-radius: 13px 13px;border-top-right-radius: 13px 13px;">
                                                                        <div class="row">
                                                                            <div class="col-sm-1">
                                                                            </div>
                                                                            <div class="col-sm-10">
                                                                                <br>
                                                                                <h4 style="color: #fff;"><b>Chat</b></h4>
                                                                                <br>
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <br>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12"
                                                                        style="background-color: #def1f1;border-bottom-left-radius: 13px 13px;border-bottom-right-radius: 13px 13px;">
                                                                        <div class="panel panel-primary">
                                                                            <div class="panel-heading">
                                                                                <span
                                                                                    class="glyphicon glyphicon-comment"></span>
                                                                            </div>
                                                                            <br>
                                                                            <div id="chat_box" class="panel-body"
                                                                                style="overflow-y: scroll;">
                                                                                <ul class="chat" id="rchat">

                                                                                    @foreach ($data as $d)
                                                                                        @if (Auth::user() != '')
                                                                                            @if ($d->id_pengirim == Auth::user()->id)
                                                                                                @php
                                                                                                    $class = 'right';
                                                                                                    $placeholder = 'https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13';
                                                                                                @endphp
                                                                                            @else
                                                                                                @php
                                                                                                    $class = 'left';
                                                                                                    $placeholder = 'https://place-hold.it/50x50/55C1E7/fff&text=H&fontsize=13';
                                                                                                @endphp
                                                                                            @endif
                                                                                        @endif
                                                                                        @if (Auth::guard('eksmp')->user() != '')
                                                                                            @if ($d->id_pengirim == Auth::guard('eksmp')->user()->id)
                                                                                                @php
                                                                                                    $class = 'right';
                                                                                                    $placeholder = 'https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13';
                                                                                                @endphp
                                                                                            @else
                                                                                                @php
                                                                                                    $class = 'left';
                                                                                                    $placeholder = 'https://place-hold.it/50x50/55C1E7/fff&text=H&fontsize=13';
                                                                                                    
                                                                                                @endphp
                                                                                            @endif
                                                                                        @endif
                                                                                        <li
                                                                                            class="{{ $class }} clearfix">
                                                                                            <span
                                                                                                class="chat-img pull-{{ $class }}">
                                                                                                <img src="{{ $placeholder }}"
                                                                                                    alt="User Avatar"
                                                                                                    class="img-circle" />
                                                                                            </span>
                                                                                            <div
                                                                                                class="chat-body clearfix pull-{{ $class }}">
                                                                                                <div
                                                                                                    class="header">
                                                                                                    <strong
                                                                                                        class=" text-muted"><span
                                                                                                            class="pull-{{ $class }} primary-font"></span><b>

                                                                                                            @if ($d->id_pengirim == $d->admin_user->id)
                                                                                                                {{ $d->admin_user->name }}
                                                                                                            @endif

                                                                                                            @if ($d->company_user->profile != '' && $d->id_pengirim == $d->company_user->id)
                                                                                                                {{ $d->company_user->profile->company }}
                                                                                                            @elseif($d->company_user->profile_buyer != '' && $d->id_pengirim == $d->company_user->id)
                                                                                                                {{ $d->company_user->profile_buyer->company }}
                                                                                                            @endif

                                                                                                        </b></strong>
                                                                                                    <small
                                                                                                        class="glyphicon glyphicon-time">
                                                                                                        ({{ date('d-m-Y H:i:s', strtotime($d->created_at)) }})
                                                                                                    </small>
                                                                                                </div>
                                                                                                <p>
                                                                                                    {{ $d->pesan }}
                                                                                                </p>
                                                                                                <p>
                                                                                                    @if (empty($d->file))
                                                                                                    @else
                                                                                                        <br><a
                                                                                                            target="_BLANK"
                                                                                                            href="{{ asset('uploads/ChatAdminCompanyFiles/' . $d->file) }}">
                                                                                                            <font
                                                                                                                color="green">
                                                                                                                {{ $d->file }}
                                                                                                            </font>
                                                                                                        </a>
                                                                                                    @endif
                                                                                                </p>

                                                                                            </div>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                            <div class="panel-footer">
                                                                                <div class="input-group">
                                                                                    <input id="inputan" type="text"
                                                                                        class="form-control input-sm"
                                                                                        placeholder="Type your message here..." />
                                                                                    <span class="input-group-btn">
                                                                                        <a onclick="kirimchat()"
                                                                                            class="btn btn-success"
                                                                                            id="btn-chat">
                                                                                            <font color="white"><i
                                                                                                    class="fa fa-paper-plane"></i>
                                                                                                Send</font>
                                                                                        </a>
                                                                                        <a class="btn btn-info show-modal"
                                                                                            data-toggle="modal"
                                                                                            data-target="#myModal2">
                                                                                            <font color="white"> <i
                                                                                                    class="fa fa-paperclip"></i>
                                                                                            </font>
                                                                                        </a>
                                                                                        <a class="btn btn-warning"
                                                                                            onclick="refresh_act()">
                                                                                            <font color="white"><i
                                                                                                    class="fa fa-refresh"></i>
                                                                                            </font>
                                                                                        </a>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </center>
                                                    {{-- <div align="left"><br><br>

                                                    </div> --}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div align="left"><br><br>
                                    @if (Auth::guard('eksmp')->user() != '')
                                        @if (Auth::guard('eksmp')->user()->id_role == 2)
                                            @if ($admin_group == 4)
                                                <a href="{{ url('list_perwadag/ln') }}" class="btn btn-danger">
                                                    <font color="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                            class="fa fa-arrow-left "></i>
                                                        Back&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                                                </a>

                                            @elseif ($admin_group == 5)
                                                <a href="{{ url('list_perwadag/dn') }}" class="btn btn-danger">
                                                    <font color="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                            class="fa fa-arrow-left "></i>
                                                        Back&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                                                </a>

                                            @endif

                                        @elseif(Auth::guard('eksmp')->user()->id_role == 3)
                                            <a href="{{ url('eksportir/admin') }}" class="btn btn-danger">
                                                <font color="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                        class="fa fa-arrow-left "></i>
                                                    Back&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                                            </a>

                                        @endif
                                    @elseif (Auth::user() != '')
                                        <a href="{{ url('eksportir/admin') }}" class="btn btn-danger">
                                            <font color="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                    class="fa fa-arrow-left "></i>
                                                Back&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                                        </a>

                                    @endif
                                </div>


                                <div class="modal fade" id="myModal2" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#2e899e; color:white;">
                                                <h4 class="text-white">Upload File</h4>
                                                <button type="button" class="close text-white"
                                                    data-dismiss="modal">&times;</button>

                                            </div>
                                            <form id="formId"
                                                action="{{ url('chat_admin_eks_imp/upload_file_chat_admin_and_company/') . '/' . $id_admin . '/' . $id_eks_imp }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id_pengirim"
                                                    value="{{ Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id }}">
                                                <div class="modal-body">
                                                    <div class="form-row">
                                                        <div class="col-sm-3">
                                                            <label><b>File Upload</b></label>
                                                        </div>
                                                        <div class="form-group col-sm-7">
                                                            <input type="hidden" class="form-control" name="id_admin"
                                                                id="id_admin" value="{{ $id_admin }}">
                                                            <input type="hidden" class="form-control" name="id_eks_imp"
                                                                id="id_eks_imp" value="{{ $id_eks_imp }}">
                                                            <input type="hidden" class="form-control"
                                                                name="email_pengirim" id="email_pengirim"
                                                                value="{{ empty(Auth::user()->id_group) == true ? Auth::guard('eksmp')->user()->email : Auth::user()->email }}">
                                                            <input type="file" class="form-control" name="file_chat"
                                                                id="file_chat" required>
                                                        </div>

                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-sm-3">
                                                            <label><b>Note</b></label>
                                                        </div>
                                                        <div class="form-group col-sm-7">
                                                            <textarea class="form-control" name="catatan"
                                                                required></textarea>
                                                        </div>

                                                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success btn-submit">
                                                        <font color="white">Upload</font>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-close"
                                                        data-dismiss="modal">Close</button>
                                                    <div class="loader" style="display: none;"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo Auth::user() != '' ? 'admin' : 'company'; ?>" id="jenis_auth">

                                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
                                <script>
                                    function kirimchat() {
                                        var message = $('#inputan').val();
                                        var id_admin = $('#id_admin').val();
                                        var id_eks_imp = $('#id_eks_imp').val();
                                        var email_pengirim = $('#email_pengirim').val();
                                        var id_pengirim = $('#id_pengirim').val();
                                        var jenis_auth = $('#jenis_auth').val();
                                        var token = $('meta[name="csrf-token"]').attr('content');
                                        if (message == null || message == "") {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: "Please write Something !",
                                            });
                                        } else {
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                                                }
                                            });
                                            $.post('{{ URL::to('chat_admin_eks_imp/send_chat') }}', {
                                                    id_admin: id_admin,
                                                    id_eks_imp: id_eks_imp,
                                                    message: message,
                                                    email_pengirim: email_pengirim,
                                                    id_pengirim: id_pengirim,
                                                    _token: token
                                                },
                                                function(data) {

                                                });
                                            $.get('{{ URL::to('chat_admin_eks_imp/notification') }}/' + id_admin + '/' + id_eks_imp, {
                                                _token: token
                                            }, function(data) {

                                            });
                                            if (jenis_auth == 'admin') {
                                                $.get('{{ URL::to('chat-notif-comnya') }}/' + id_eks_imp, {
                                                    _token: token
                                                }, function(data) {

                                                });
                                            } else {
                                                $.get('{{ URL::to('chat-notif') }}/' + id_admin, {
                                                    _token: token
                                                }, function(data) {

                                                });
                                            }
                                            $('#rchat').append(
                                                '<li class="right clearfix"><span class="chat-img pull-right"><img src="https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix pull-right"><div class="header"><strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo empty(Auth::user()->id_group) == true
    ? (Auth::guard('eksmp')
        ->user()
        ->load('profile', 'profile_buyer')->profile != ''
        ? Auth::guard('eksmp')
            ->user()
            ->load('profile', 'profile_buyer')->profile->company
        : Auth::guard('eksmp')
            ->user()
            ->load('profile', 'profile_buyer')->profile_buyer->company)
    : Auth::user()->name; ?></b></strong><small class="glyphicon glyphicon-time"> (<?php echo date('Y-m-d H:m:s'); ?>)</small></div><p>' +
                                                message + '</p></div></li>');
                                            $('#inputan').val('');
                                        }

                                    }
                                    $(document).ready(function() {
                                        var con = document.getElementById("chat_box");
                                        con.scrollTop = con.scrollHeight;

                                        $("#inputan").keypress(function(e) {
                                            if (e.which == 13) {
                                                kirimchat()
                                            }
                                        });

                                    });

                                    function refresh_act() {
                                        var a = $('#id_admin').val();
                                        var b = $('#id_eks_imp').val();
                                        var token = $('meta[name="csrf-token"]').attr('content');
                                        $.get('{{ URL::to('chat_admin_eks_imp/refreshchat/') }}/' + a + '/' + b, {
                                            _token: token
                                        }, function(data) {
                                            $('#rchat').html(data)
                                        });
                                    }

                                    $(function() {
                                        var jenis_auth = $('#jenis_auth').val();
                                        var a = $('#id_admin').val();
                                        var b = $('#id_eks_imp').val();
                                        var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
                                            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                                            encrypted: true
                                        });

                                        var channel = pusher.subscribe('notify-channel-' + a + '-' + b);
                                        var token = $('meta[name="csrf-token"]').attr('content');
                                        channel.bind('App\\Events\\Notify', function(data) {
                                            $.get('{{ URL::to('chat_admin_eks_imp/refreshchat/') }}/' + a + '/' + b, {
                                                _token: token
                                            }, function(data) {
                                                $('#rchat').html(data)
                                                var con = document.getElementById("chat_box");
                                                con.scrollTop = con.scrollHeight;
                                            });
                                        });

                                    })
                                    var token = $('meta[name="csrf-token"]').attr('content');
                                    var a = $('#id_admin').val();
                                    var b = $('#id_eks_imp').val();
                                    var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
                                        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                                        encrypted: true
                                    });
                                    var channel = pusher.subscribe('notify-channel-' + a + '-' + b);
                                    $("#formId").submit(function(e) {
                                        $('.btn-submit, .btn-close,.close').hide();
                                        $('.loader').show();
                                        $.get('{{ URL::to('chat_admin_eks_imp/notification') }}/' + a + '/' + b, {
                                            _token: token
                                        }, function(data) {

                                        });
                                        channel.bind('App\\Events\\Notify', function(data) {
                                            $.get('{{ URL::to('chat_admin_eks_imp/refreshchat/') }}/' + a + '/' + b, {
                                                _token: token
                                            }, function(data) {
                                                console.log("datanya:" + data)
                                                var con = document.getElementById("chat_box");
                                                con.scrollTop = con.scrollHeight;
                                            });
                                        });
                                    });

                                    $(function() {
                                        $(".show-modal").click(function() {
                                            $("#myModal2").modal({
                                                backdrop: 'static',
                                                keyboard: false
                                            });
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @include('footer')

@endsection
