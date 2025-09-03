<?php // echo bcrypt('abc');die();
?>
@extends('header2')
@section('content')
    <script src="https://js.pusher.com/7.0/pusher.min.js">
    </script>
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
                                        margin-left: 60px;
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




                                <?php 
                                $q1 = DB::select("select * from csc_buying_request_join where id='".$id."'");
                                foreach($q1 as $p){ $id_br = $p->id_br; $ij = $p->status_join;}
                                $q2 = DB::select("select * from csc_buying_request where id='".$id_br."'");
                                foreach($q2 as $p2){
                                ?>
                                <table width="100%" class="opensans">
                                    <tr>
                                        <td width="50%" valign="top">
                                            <div class="form-row" align="left">
                                                <div class="col-md-12">
                                                    <div>
                                                        <br>
                                                        <div class="form-row">

                                                            <div class=" form-group col-md-3"></div>
                                                            <div class="form-group col-md-6">
                                                                <?php if($ij == 4){ ?>

                                                                <?php }else{ ?>
                                                                <a style="width: 100%!important;" width="100%"
                                                                    data-toggle="modal" data-target="#myModalDealInquiry"
                                                                    class="btn btn-warning">
                                                                    <font color="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                                            class="fa fa-hand-o-right "></i> Deal Buying
                                                                        Request</font>
                                                                </a>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="form-group col-md-3"></div>

                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                                <label class="text-break"><b>Buyer</b></label>
                                                            </div>
                                                            <div>:</div>
                                                            <div class="col-lg-7 col-md-9 col-sm-11">

                                                                <label class="text-break">
                                                                    <?php
                                                                    if ($p2->by_role == 1) {
                                                                        echo 'Admin';
                                                                        if (Cache::has('user-is-online-' . $p2->id_pembuat)) {
                                                                            echo ' <label class="text-success font-weight-bold">(Online)</label>';
                                                                        } else {
                                                                            echo ' <label class="text-danger font-weight-bold">(Offline)</label>';
                                                                        }
                                                                    } elseif ($p2->by_role == 4) {
                                                                        $usre = DB::select("select name from itdp_admin_users where id='" . $p2->id_pembuat . "'");
                                                                        foreach ($usre as $pwd) {
                                                                            echo $pwd->name;
                                                                        }
                                                                        if (Cache::has('user-is-online-' . $p2->id_pembuat)) {
                                                                            echo ' <label class="text-success font-weight-bold">(Online)</label>';
                                                                        } else {
                                                                            echo ' <label class="text-danger font-weight-bold">(Offline)</label>';
                                                                        }
                                                                    } elseif ($p2->by_role == 3) {
                                                                        $usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $p2->id_pembuat . "'");
                                                                        foreach ($usre as $imp) {
                                                                            echo $imp->badanusaha . ' ' . $imp->company;
                                                                            if (Cache::has('user-is-eksmp-' . $p2->id_pembuat)) {
                                                                                echo ' <label class="text-success font-weight-bold">(Online)</label>';
                                                                            } else {
                                                                                echo ' <label class="text-danger font-weight-bold">(Offline)</label>';
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </label>
                                                            </div>

                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                                <label class="text-break"><b>Produk</b></label>
                                                            </div>
                                                            <div>:</div>
                                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                                <label class="text-break">
                                                                    {{ $p2->subyek }}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="form-row">
                                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                                            <b>Kategori Produk</b>
                                                        </div>
                                                        <div>:</div>
                                                        <div class="col-lg-7 col-md-9 col-sm-11">
                                                            <label class="text-break"> --}}
                                                        <?php
                                                        // $cr = explode(',', $p2->id_csc_prod);
                                                        // $hitung = count($cr);
                                                        // $semuacat = '';
                                                        // for ($a = 0; $a < $hitung - 1; $a++) {
                                                        //     $namaprod = DB::select("select * from csc_product where id=$cr[$a]");
                                                        //     foreach ($namaprod as $prod) {
                                                        //         $napro = $prod->nama_kategori_en;
                                                        //     }
                                                        //     $semuacat = $semuacat . '' . $napro . '<br>';
                                                        // }
                                                        // echo $semuacat;
                                                        ?>
                                                        {{-- </label>
                                                        </div>
                                                    </div> --}}
                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 text-break">
                                                                <label class="text-break"><b>Spesifikasi
                                                                        Produk</b></label>
                                                            </div>
                                                            <div>
                                                                :
                                                            </div>
                                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                                <label class="text-break"> {{ $p2->spec }}</label>
                                                                <textarea readonly style="color:black;display:none;" name="spec" id="spec"
                                                                    class="form-control">{{ $p2->spec }}</textarea>
                                                            </div>

                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                                <label class="text-break"> <b>Jumlah</b></label>
                                                            </div>
                                                            <div>:</div>
                                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                                <label class="text-break">
                                                                    {{ $p2->eo . ' ' . $p2->neo }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 text-break">
                                                                <label class="text-break"><b>Harga (FOB)</b></label>
                                                            </div>
                                                            <div>
                                                                :
                                                            </div>
                                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                                <label class="text-break">
                                                                    {{ number_format($p2->tp, 0, ',', '.') }}
                                                                </label>
                                                                <label class="text-break">USD</label>
                                                            </div>


                                                        </div>



                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                                <label class="text-break">
                                                                    <b>Negara Buyer</b>
                                                                </label>
                                                            </div>
                                                            <div>:</div>
                                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                                <label class="text-break">
                                                                    <?php
                                                                    if ($p2->by_role == 1) {
                                                                    } elseif ($p2->by_role == 4) {
                                                                        $usre = DB::select("select mc.country from itdp_admin_users a, itdp_admin_ln b left join mst_country mc on mc.id = b.country where a.id_admin_ln = b.id and a.id='" . $p2->id_pembuat . "'");
                                                                        foreach ($usre as $imp) {
                                                                            echo $imp->country;
                                                                        }
                                                                    } elseif ($p2->by_role == 3) {
                                                                        $usre = DB::select("select b.addres,b.city, mc.country from itdp_company_users a, itdp_profil_imp b left join mst_country mc on mc.id = b.id_mst_country where a.id_profil = b.id and a.id='" . $p2->id_pembuat . "'");
                                                                        foreach ($usre as $imp) {
                                                                            echo $imp->country;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                                <label class="text-break"> <b>Tanggal
                                                                        Inquiry</b></label>
                                                            </div>
                                                            <div>:</div>
                                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                                <label class="text-break">
                                                                    {{ Carbon\Carbon::parse($p2->date)->format('d M Y') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="id_br" value="{{ $id_br }}">
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
                                                                                <!--<a class="btn btn-info" onclick="rfr()">Refresh</a> -->
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
                                                                            <div id="fg1" class="panel-body"
                                                                                style="overflow-y: scroll;">
                                                                                <ul class="chat" id="rchat">
                                                                                    <?php 
                                                                                    $qwr = DB::select("select * from csc_buying_request_chat where id_br='".$id_br."' and id_join='".$id."'");
                                                                                    foreach($qwr as $r){
                                                                                    ?>

                                                                                    <?php if($r->id_pengirim == Auth::guard('eksmp')->user()->id){?>
                                                                                    <li class="right clearfix"><span
                                                                                            class="chat-img pull-right">
                                                                                            <img src="https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13"
                                                                                                alt="User Avatar"
                                                                                                class="img-circle" />
                                                                                        </span>
                                                                                        <div
                                                                                            class="chat-body clearfix pull-right">
                                                                                            <div class="header">
                                                                                                <strong
                                                                                                    class=" text-muted"><span
                                                                                                        class="pull-right primary-font"></span><b>
                                                                                                        {{ $r->username_pengirim }}

                                                                                                    </b></strong>
                                                                                                <small
                                                                                                    class="glyphicon glyphicon-time">
                                                                                                    ({{ $r->tanggal }})
                                                                                                </small>
                                                                                            </div>
                                                                                            <p>
                                                                                                {{ $r->pesan }}
                                                                                            </p>
                                                                                            <p>
                                                                                                <?php if(empty($r->files)){}else{?>
                                                                                                <br><a target="_BLANK"
                                                                                                    href="{{ asset('uploads/pop/' . $r->files) }}">
                                                                                                    <font color="green">
                                                                                                        {{ $r->files }}
                                                                                                    </font>
                                                                                                </a>
                                                                                                <?php } ?>
                                                                                            </p>

                                                                                        </div>
                                                                                    </li>
                                                                                    <?php }else{ ?>
                                                                                    <li class="left clearfix"><span
                                                                                            class="chat-img pull-left">
                                                                                            <img src="https://place-hold.it/50x50/55C1E7/fff&text=H&fontsize=13"
                                                                                                alt="User Avatar"
                                                                                                class="img-circle" />
                                                                                        </span>
                                                                                        <div class="chat-body clearfix">
                                                                                            <div class="header">
                                                                                                <strong
                                                                                                    class="text-muted"><span
                                                                                                        class="pull-right primary-font"></span><b>
                                                                                                        {{ $r->username_pengirim }}
                                                                                                        @if ($r->id_role == 1 || $r->id_role == 4 || $r->id_role == 5 || $r->id_role == 8 || $r->id_role == 11)
                                                                                                            @if (Cache::has('user-is-online-' . $r->id_pengirim))
                                                                                                                (<span
                                                                                                                    class="text-success">Online</span>)
                                                                                                            @else
                                                                                                                (<span
                                                                                                                    class="text-danger">Offline</span>)
                                                                                                            @endif
                                                                                                        @else
                                                                                                            @if (Cache::has('user-is-eksmp-' . $r->id_pengirim))
                                                                                                                (<span
                                                                                                                    class="text-success">Online</span>)
                                                                                                            @else
                                                                                                                (<span
                                                                                                                    class="text-danger">Offline</span>)
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </b></strong>
                                                                                                <small
                                                                                                    class="glyphicon glyphicon-time">
                                                                                                    ({{ $r->tanggal }})
                                                                                                </small>
                                                                                            </div>
                                                                                            <p>
                                                                                                {{ $r->pesan }}

                                                                                            </p>
                                                                                            <p>
                                                                                                <?php if(empty($r->files)){}else{?>
                                                                                                <br><a target="_BLANK"
                                                                                                    href="{{ asset('uploads/pop/' . $r->files) }}">
                                                                                                    <font color="green">
                                                                                                        {{ $r->files }}
                                                                                                    </font>
                                                                                                </a>
                                                                                                <?php } ?>
                                                                                            </p>

                                                                                        </div>
                                                                                    </li>
                                                                                    <?php } ?>
                                                                                    <?php } ?>
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
                                                                                        <a class="btn btn-info"
                                                                                            data-toggle="modal"
                                                                                            data-target="#myModalUploadFile">
                                                                                            <font color="white"> <i
                                                                                                    class="fa fa-paperclip"></i>
                                                                                            </font>
                                                                                        </a>
                                                                                        <a class="btn btn-warning"
                                                                                            onclick="rfr()">
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
                                    <a href="{{ url('br_list') }}" class="btn btn-danger">
                                        <font color="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-left "></i>
                                            Back&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                                    </a>
                                </div>
                                <?php } ?>

                                <div class="modal fade" id="myModalDealInquiry" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#2e899e; color:white;">
                                                <h6>Validation Deal</h6>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>

                                            </div>
                                            <!--<div id ="isibroadcast"></div> -->
                                            <div class="modal-body">
                                                What do you choose about Deal ?
                                            </div>
                                            <div class="modal-footer" style="color:white!important;">
                                                <a href="{{ url('br_deal/' . $id . '/' . $id_br . '/' . Auth::guard('eksmp')->user()->id) }}"
                                                    class="btn btn-warning">
                                                    <font color="white">Deal</font>
                                                </a>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="myModalUploadFile" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#2e899e; color:white;">
                                                <h4 class="text-white">Upload File</h4>
                                                <button type="button" class="close text-white"
                                                    data-dismiss="modal">&times;</button>

                                            </div>
                                            <form id="formId" action="{{ url('uploadpop3') }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="form-row">
                                                        <div class="col-sm-3">
                                                            <label><b>File Upload</b></label>
                                                        </div>
                                                        <div class="form-group col-sm-7">
                                                            <?php
                                                            $rg = DB::select("select b.company from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='" . Auth::guard('eksmp')->user()->id . "' ");
                                                            foreach ($rg as $gr) {
                                                                $compa = $gr->company;
                                                            }
                                                            ?>
                                                            <input type="hidden" class="form-control" name="idq" id="idq"
                                                                value="{{ $id }}">
                                                            <input type="hidden" class="form-control" name="idb" id="idb"
                                                                value="{{ $id_br }}">
                                                            <input type="hidden" class="form-control" name="idc" id="idc"
                                                                value="{{ Auth::guard('eksmp')->user()->id_role }}">
                                                            <input type="hidden" class="form-control" name="idd" id="idd"
                                                                value="{{ Auth::guard('eksmp')->user()->id }}">
                                                            <input type="hidden" class="form-control" name="ide" id="ide"
                                                                value="{{ Auth::guard('eksmp')->user()->profile != ''? Auth::guard('eksmp')->user()->profile->company: Auth::guard('eksmp')->user()->profile_buyer->company }}">
                                                            <input type="file" class="form-control" name="filez"
                                                                id="filez" required>
                                                        </div>

                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-sm-3">
                                                            <label><b>Note</b></label>
                                                        </div>
                                                        <div class="form-group col-sm-7">
                                                            <textarea class="form-control" name="catatan" required></textarea>
                                                        </div>
                                                        <input type="hidden" name="id_chat" value="{{ $id }}">
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
                                <?php $quertreject = DB::select('select * from mst_template_reject order by id asc');
                                $compa = '-';
                                $rg = DB::select("select b.company from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='" . Auth::guard('eksmp')->user()->id . "' ");
                                foreach ($rg as $gr) {
                                    $compa = $gr->company;
                                }
                                
                                ?>

                                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
                                <script>
                                    function kirimchat() {
                                        var a = $('#inputan').val();
                                        var b = $('#id_br').val();
                                        var c = {{ Auth::guard('eksmp')->user()->id_role }};
                                        var d = {{ Auth::guard('eksmp')->user()->id }};
                                        var e = "{{ $compa }}";
                                        var f = "{{ $id }}";
                                        var token = $('meta[name="csrf-token"]').attr('content');
                                        if (a == null || a == "") {
                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Oops...',
                                                text: "Please write Something !",
                                            });
                                        } else {
                                            $.get('{{ URL::to('simpanchatbr/') }}/a/' + b + '/' + c + '/' + d + '/' + e + '/' + f, {
                                                a: a,
                                                _token: token
                                            }, function(data) {

                                            });
                                            $.get('{{ URL::to('notification/') }}/' + f, {
                                                a: a,
                                                _token: token
                                            }, function(data) {

                                            });
                                            $('#rchat').append(
                                                `<li class="right clearfix"><span class="chat-img pull-right"><img src="https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix pull-right"><div class="header"><strong class=" text-muted"><span class="pull-right primary-font"></span><b>{{ Auth::guard('eksmp')->user()->load('profile', 'profile_buyer')->profile != ''
                                                    ? Auth::guard('eksmp')->user()->load('profile', 'profile_buyer')->profile->company
                                                    : Auth::guard('eksmp')->user()->load('profile', 'profile_buyer')->profile_buyer->company }}</b></strong><small class="glyphicon glyphicon-time"> ({{ date('Y-m-d H:m:s') }})</small></div><p>' +
                                                a + '</p></div></li>`);
                                            $('#inputan').val('');
                                        }

                                    }
                                    $(document).ready(function() {
                                        var con = document.getElementById("fg1");
                                        con.scrollTop = con.scrollHeight;
                                        // setInterval(function() {
                                        a = $('#id_br').val();
                                        b = {{ $id }};
                                        console.log(b)
                                        //     var token = $('meta[name="csrf-token"]').attr('content');
                                        //     $.get('{{ URL::to('refreshchat3/') }}/' + a + '/' + b, {
                                        //         _token: token
                                        //     }, function(data) {
                                        //         $('#rchat').html(data)
                                        //         var con = document.getElementById("fg1");
                                        //         con.scrollTop = con.scrollHeight;
                                        //     });
                                        // }, 2000);

                                        $("#inputan").keypress(function(e) {
                                            if (e.which == 13) {
                                                kirimchat()
                                            }
                                        });

                                    });

                                    function rfr() {
                                        a = $('#id_br').val();
                                        b = {{ $id }};
                                        var token = $('meta[name="csrf-token"]').attr('content');
                                        $.get('{{ URL::to('refreshchat3/') }}/' + a + '/' + b, {
                                            _token: token
                                        }, function(data) {
                                            $('#rchat').html(data);
                                            setTimeout(function() {
                                                var con = document.getElementById("fg1");
                                                con.scrollTop = con.scrollHeight;
                                            }, 1000);
                                        });
                                    }

                                    function t1() {
                                        $('#t2').html('');
                                        $('#t3').html('');
                                        var t1 = $('#category').val();
                                        var token = $('meta[name="csrf-token"]').attr('content');
                                        $.get('{{ URL::to('ambilt2/') }}/' + t1, {
                                            _token: token
                                        }, function(data) {
                                            $("#t2").html(data);
                                            $("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
                                            $('.select2').select2();

                                        })
                                    }

                                    function t2() {
                                        $('#t3').html('');
                                        var t2 = $('#t2s').val();
                                        var token = $('meta[name="csrf-token"]').attr('content');
                                        $.get('{{ URL::to('ambilt3/') }}/' + t2, {
                                            _token: token
                                        }, function(data) {
                                            $("#t3").html(data);
                                            $('.select2').select2();

                                        })
                                    }

                                    function nv() {
                                        var a = $('#staim').val();
                                        if (a == 2) {
                                            $('#sh1').html(
                                                `<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option>
                                                @foreach ($quertreject as $qr)
                                                    <option value="{{ $qr->id }}">{{ $qr->nama_template }}></option>
                                                @endforeach
                                                </select></div></div>`
                                            )
                                        } else {
                                            $('#sh1').html(' ');
                                            $('#sh2').html(' ');
                                        }
                                    }

                                    function ketv() {
                                        var a = $('#template_reject').val();
                                        if (a == 1) {
                                            $('#sh2').html(
                                                '<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>'
                                            )
                                        }
                                    }
                                    $(document).ready(function() {
                                        $('.select2').select2();
                                    });

                                    function openCity(evt, cityName) {
                                        var i, tabcontent, tablinks;
                                        tabcontent = document.getElementsByClassName("tabcontent");
                                        for (i = 0; i < tabcontent.length; i++) {
                                            tabcontent[i].style.display = "none";
                                        }
                                        tablinks = document.getElementsByClassName("tablinks");
                                        for (i = 0; i < tablinks.length; i++) {
                                            tablinks[i].className = tablinks[i].className.replace(" active", "");
                                        }
                                        document.getElementById(cityName).style.display = "block";
                                        evt.currentTarget.className += " active";
                                    }

                                    $(function() {
                                        var a = $('#id_br').val();
                                        var b = {{ $id }};
                                        var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
                                            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                                            encrypted: true
                                        });

                                        var channel = pusher.subscribe('notify-channel-' + b);
                                        var token = $('meta[name="csrf-token"]').attr('content');
                                        channel.bind('App\\Events\\Notify', function(data) {
                                            $.get('{{ URL::to('refreshchat3/') }}/' + a + '/' + b, {
                                                _token: token
                                            }, function(data) {
                                                $('#rchat').html(data)
                                                setTimeout(function() {
                                                    var con = document.getElementById("fg1");
                                                    con.scrollTop = con.scrollHeight;
                                                }, 1000);
                                            });
                                        });

                                    });

                                    $("#formId").submit(function(e) {
                                        $('.btn-submit, .btn-close').hide();
                                        $('.loader').show();
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
