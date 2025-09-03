@include('frontend.layouts.header')
<style>
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

</style>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css" rel="stylesheet">
<style type="text/css">
    /* .chat-container {
        width: 100%;
        background-color: white;
        border-radius: 30px;
    }

    .chat-header {
        width: 100%;
        height: 5%;
        background-color: #1a7688;
        border-radius: 30px 30px 0px 0px;
        padding: 2% 2% 2% 3%;

    }

    .chat-user {
        font-size: 15px;
        font-family: 'Verdana';
    }

    .chat-body {
        height: 375px;
        max-height: 500px;
        overflow-y: scroll;
        overflow-x: hidden;
        padding: 2%;
        font-size: 15px;
        background-color: #c9d3de;
    }

    .chat-footer {
        width: 100%;
        height: 5%;
        border-top: 2px solid #87c4ee;
        border-radius: 0px 0px 30px 30px;
        padding: 1% 1% 1% 1%;
        background-color: #c9d3de;
    }

    .chat-message {
        border: 1.5px solid #4088C6;
        height: 100%;
        width: 100%;
        border-radius: 10px;
        resize: none;
        padding: 1%;
        font-size: 15px;
    }

    .chat-me {
        background: #64abe4;
        border-radius: 10px 0px 10px 10px;
        width: 400px;
        padding: 10px;
        color: white;
    }

    .chat-other {
        background: #DDEFFD;
        border-radius: 0px 10px 10px 10px;
        width: 400px;
        padding: 10px;
    } */

    #uploading2 {
        cursor: pointer;
        transition: 0.3s;
    }

    #uploading2:hover {
        opacity: 0.7;
    }

    #sendmessage {
        cursor: pointer;
        transition: 0.3s;
    }

    #sendmessage:hover {
        opacity: 0.7;
    }

    .chat-back:hover {
        opacity: 0.7;
    }

    button.closedmodal {
        padding: 0;
        background-color: transparent;
        border: 0;
        -webkit-appearance: none;
    }

    .closedmodal {
        float: right;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
    }

    .modal-header .closedmodal {
        padding: 1rem;
        margin: -1rem -1rem -1rem auto;
    }

    .closedmodal:hover {
        color: #fff;
    }

    /* Select2 */
    .select2-selection__rendered {
        line-height: 30px !important;
    }

    .select2-container .select2-selection--single {
        height: 34px !important;
    }

    .select2-selection__arrow {
        height: 33px !important;
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

    .loader2 {
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

    /* Select2 */

</style>
<!--slider area start-->
<?php
$loc = app()->getLocale();
if ($loc == 'ch') {
    $lct = 'chn';
} elseif ($loc == 'in') {
    $lct = 'in';
} else {
    $lct = 'en';
}
?>
<style>
    .table-striped>tbody>tr:nth-child(odd) {
        background-color: white !important;
        background-clip: padding-box !important;
    }

    .table-striped>tbody>tr:nth-child(even) {
        background-color: white !important;
        background-clip: padding-box !important;
    }

    .table-bordered td,
    .table-bordered th {
        border: transparent;
    }

    .form-control[readonly] {
        font-size: 12px;
    }

</style>
<!--product area start-->
<section class="product_area mb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">

                </div>

            </div>
        </div>

        <div class="tab-content" id="tabing-product">
            <div class="breadcrumb_content">
                <ul>
                    <li><a href="{{ url('front_end') }}">@lang("login.forms.home")</a></li>
                    <li>@lang("login.forms.br")</li>
                </ul>
            </div>

            <?php
            $nyariek = DB::select("select * from csc_buying_request_join where id=$idb");
            foreach ($nyariek as $ek1) {
                $id_eks = $ek1->id_eks;
            }
            $nyariek2 = DB::select("select b.*, a.id as id_itdp_company_users from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='" . $id_eks . "'");
            foreach ($nyariek2 as $ek2) {
                $idu = $ek2->id;
                $idc = $ek2->id_itdp_company_users;
                $company = $ek2->company;
                $addres = $ek2->addres;
                $city = $ek2->city;
            }
            //echo $company;die();
            ?>
            <div class="form-row" style="font-size:12px;">
                <div id="content-body" class="container-fluid" style="color: #ffffff">
                    <div class="py-2 w-100">


                        <div class=""
                            style="color:black;padding-left:10px; padding-right:10px; border-radius: 3px;">


                            <?php 
								$pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
								foreach($pesan as $ryu){
									?>
                            <div class="form-row mt-2">
                                <div class="col-md-6" style="padding-right: 20px;">
                                    <div class="box-body">


                                        <div class="form-row">
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="text-break"><b>Supplier </b></label>
                                            </div>
                                            <div>:</div>
                                            <div class="col-lg-7 col-md-9 col-sm-11">

                                                <label class="text-break">
                                                    <?php echo $company; ?>
                                                    <?php if(Cache::has('user-is-eksmp-' . $idc)){ ?>&nbsp;<label
                                                        class="text-success font-weight-bold">(Online)</label>
                                                    <?php }else{ ?>&nbsp;<label
                                                        class="text-success font-weight-bold">(Online)</label>
                                                    <?php } ?>
                                                </label>
                                            </div>
                                            {{-- <div class="form-group col-sm-12"> --}}
                                            <input type="hidden" readonly class="form-control"
                                                value="<?php echo $company; ?> <?php if(Cache::has('user-is-eksmp-' . $idc)){ ?>(Online)<?php }else{ ?>&nbsp;(Offline)<?php } ?>">
                                            {{-- </div> --}}

                                        </div>

                                        <div class="form-row">
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="text-break"><b>Product</b></label>
                                            </div>
                                            <div>:</div>
                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                <label class="text-break">
                                                    <?php echo $ryu->subyek; ?> @if ($ryu->valid == '3')
                                                        (Valid within 3 days)
                                                    @elseif ($ryu->valid == '5')
                                                        (Valid within 5 days)
                                                    @elseif ($ryu->valid == '7')
                                                        (Valid within 7 days)
                                                    @elseif ($ryu->valid == '15')
                                                        (Valid within 15 days)
                                                    @elseif ($ryu->valid == '30')
                                                        (Valid within 30 days)
                                                    @endif
                                                </label>
                                            </div>
                                            {{-- <div class="form-group col-sm-8"> --}}
                                            <input readonly type="hidden" style="color:black;"
                                                value="<?php echo $ryu->subyek; ?>" name="cmp" id="cmp" class="form-control">
                                            {{-- </div> --}}
                                            <div class="form-group col-sm-4 d-none">
                                                <select disabled
                                                    style="color:black;font-size: 12px; height: 34px !important;"
                                                    class="form-control d-none" name="valid" id="valid">
                                                    <option <?php if ($ryu->valid == '3') {
    echo 'selected';
} ?> value="3">Valid within 3 day</option>
                                                    <option <?php if ($ryu->valid == '5') {
    echo 'selected';
} ?> value="5">Valid within 5 day</option>
                                                    <option <?php if ($ryu->valid == '7') {
    echo 'selected';
} ?> value="7">Valid within 7 day</option>
                                                    <option <?php if ($ryu->valid == '15') {
    echo 'selected';
} ?> value="15">Valid within 15 days
                                                    </option>
                                                    <option <?php if ($ryu->valid == '30') {
    echo 'selected';
} ?> value="30">Valid within 30 days
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="text-break"><b>Category</b></label>
                                            </div>
                                            <div>:</div>
                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                <label class="text-break">
                                                    <?php
                                                    $cr = explode(',', $ryu->id_csc_prod);
                                                    $hitung = count($cr);
                                                    $semuacat = '';
                                                    for ($a = 0; $a < $hitung - 1; $a++) {
                                                        $namaprod = DB::select("select * from csc_product where id='" . $cr[$a] . "' ");
                                                        foreach ($namaprod as $prod) {
                                                            $napro = $prod->nama_kategori_en;
                                                        }
                                                        $semuacat = $semuacat . '- ' . $napro . ' ';
                                                    
                                                        echo $napro . '<br/>';
                                                    }
                                                    // echo $semuacat;
                                                    ?>
                                                </label>
                                                <!--<textarea class="form-control"><?php echo $semuacat; ?></textarea> -->
                                            </div>

                                        </div>
                                        <div id="t2">
                                            <input type="hidden" name="t2s" id="t2s" value="0">
                                        </div>
                                        <div id="t3">
                                            <input type="hidden" name="t3s" id="t3s" value="0">
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-break">
                                                <label class="text-break"><b>Specification</b></label>
                                            </div>
                                            <div>
                                                :
                                            </div>
                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                <label class="text-break"> {{ $ryu->spec }}</label>
                                                <textarea readonly style="color:black;display:none;" name="spec" id="spec"
                                                    class="form-control"><?php echo $ryu->spec; ?></textarea>
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-break">
                                                <label class="text-break"><b>Estimated order</b></label>
                                            </div>
                                            <div>:</div>
                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                {{-- <div class="form-row"> --}}
                                                <label class="text-break">
                                                    <?php echo $ryu->eo; ?>
                                                    {{ $ryu->neo }}
                                                </label>
                                                <div class="col-sm-7 d-none"><input readonly
                                                        style="color:black; text-align: right;" type="hidden"
                                                        value="<?php echo number_format($ryu->eo, 0, ',', '.'); ?>" name="eo" id="eo"
                                                        class="form-control"> </div>
                                                <div class="col-sm-5 d-none"> <select disabled
                                                        style="color:black;font-size: 12px; height: 34px !important;"
                                                        class="form-control" name="neo" id="neo">
                                                        <option value="Dozen"
                                                            @if ($ryu->neo == 'Dozen') selected @endif>Dozen
                                                        </option>
                                                        <option value="Grams"
                                                            @if ($ryu->neo == 'Grams') selected @endif>Grams
                                                        </option>
                                                        <option value="Kilograms"
                                                            @if ($ryu->neo == 'Kilograms') selected @endif>Kilograms
                                                        </option>
                                                        <option value="Liters"
                                                            @if ($ryu->neo == 'Liters') selected @endif>Liters
                                                        </option>
                                                        <option value="Meters"
                                                            @if ($ryu->neo == 'Meters') selected @endif>Meters
                                                        </option>
                                                        <option value="Packs"
                                                            @if ($ryu->neo == 'Packs') selected @endif>Packs
                                                        </option>
                                                        <option value="Pairs"
                                                            @if ($ryu->neo == 'Pairs') selected @endif>Pairs
                                                        </option>
                                                        <option value="Pieces"
                                                            @if ($ryu->neo == 'Pieces') selected @endif>Pieces
                                                        </option>
                                                        <option value="Sets"
                                                            @if ($ryu->neo == 'Sets') selected @endif>Sets
                                                        </option>
                                                        <option value="Tons"
                                                            @if ($ryu->neo == 'Tons') selected @endif>Tons
                                                        </option>
                                                        <option value="Unit"
                                                            @if ($ryu->neo == 'Unit') selected @endif>Unit
                                                        </option>
                                                    </select>
                                                </div>
                                                {{-- </div> --}}


                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-break">
                                                <label class="text-break"><b>Targeted price (FOB)</b></label>
                                            </div>
                                            <div>
                                                :
                                            </div>
                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                <label class="text-break">
                                                    <?php echo number_format($ryu->tp, 0, ',', '.'); ?>
                                                </label>
                                                <label class="text-break">USD</label>
                                            </div>


                                        </div>



                                        <div class="form-row">
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-break">
                                                <label class="text-break"><b>Location of delivery</b></label>
                                            </div>
                                            <div>:</div>
                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                <?php
                                                $ms2 = DB::select('select id,country from mst_country order by country asc');
                                                ?>
                                                <label class="text-break">
                                                    @foreach ($ms2 as $val2)
                                                        @if ($ryu->id_mst_country == $val2->id)
                                                            {{ $val2->country }}
                                                        @endif
                                                    @endforeach
                                                </label>

                                                <lable class="text-break">
                                                    ({{ $ryu->city }})
                                                </lable>
                                            </div>
                                            {{-- <div class="form-group col-sm-6"> --}}
                                            <input readonly style="color:black;" type="hidden"
                                                value="<?php echo $ryu->city; ?>" name="city" id="city"
                                                class="form-control" placeholder="City/State">
                                            {{-- </div> --}}
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label class="text-break"> <b>Inquiry Date</b></label>
                                            </div>
                                            <div>:</div>
                                            <div class="col-lg-7 col-md-9 col-sm-11">
                                                <label class="text-break">
                                                    <?php echo date('Y-m-d', strtotime($ryu->date)); ?>
                                                </label>
                                            </div>
                                        </div>



                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-md-12"
                                                style="background-color: #1a7688;color:white;border-top-left-radius: 13px 13px;border-top-right-radius: 13px 13px;">
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                    </div>
                                                    <div class="col-sm-10 text-center">
                                                        <br>
                                                        <h6><b>Chat</b></h6><br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12"
                                                style="background-color: #def1f1;border-bottom-left-radius: 13px 13px;border-bottom-right-radius: 13px 13px;">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <span class="glyphicon glyphicon-comment"></span>

                                                    </div>
                                                    <br>
                                                    <div id="fg1" class="panel-body" style="overflow-y: scroll;">
                                                        <ul class="chat" id="rchat"
                                                            style="color:black!Important;">
                                                            <?php 
                                                                                            $qwr = DB::select("select * from csc_buying_request_chat where id_br='".$id."' and id_join='".$idb."'");
                                                                                            foreach($qwr as $r){
                                                                                            ?>

                                                            <?php if($r->id_pengirim == Auth::guard('eksmp')->user()->id){?>
                                                            <li class="right clearfix">
                                                                <span class="chat-img pull-right">
                                                                    <img src="https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13"
                                                                        alt="User Avatar" class="img-circle" />
                                                                </span>
                                                                <div class="chat-body clearfix pull-right">
                                                                    <div class="header">
                                                                        <strong class=" text-muted"><span
                                                                                class="pull-right primary-font"></span><b>
                                                                                <?php echo $r->username_pengirim; ?>



                                                                            </b></strong>
                                                                        <small class="glyphicon glyphicon-time">
                                                                            (
                                                                            <?php echo $r->tanggal; ?>)
                                                                        </small>
                                                                    </div>
                                                                    <p>
                                                                        <?php echo $r->pesan; ?>

                                                                    </p>
                                                                    <p>
                                                                        <?php if(empty($r->files)){}else{?>
                                                                        <br><a target="_BLANK"
                                                                            href="{{ asset('uploads/pop/' . $r->files) }}">
                                                                            <font color="green">
                                                                                <?php echo $r->files; ?>
                                                                            </font>
                                                                        </a>
                                                                        <?php } ?>
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <?php }else{ ?>
                                                            <li class="left clearfix" align="left"><span
                                                                    class="chat-img pull-left">
                                                                    <img src="https://place-hold.it/50x50/55C1E7/fff&text=H&fontsize=13"
                                                                        alt="User Avatar" class="img-circle" />
                                                                </span>
                                                                <div class="chat-body clearfix">
                                                                    <div class="header">
                                                                        <strong class="text-muted"><span
                                                                                class="pull-right primary-font"></span><b>
                                                                                <?php echo $r->username_pengirim; ?>
                                                                                @if (Cache::has('user-is-eksmp-' . $r->id_pengirim))
                                                                                    (<span
                                                                                        class="text-success">Online</span>)
                                                                                @else
                                                                                    (<span
                                                                                        class="text-danger">Offline</span>)
                                                                                @endif
                                                                            </b></strong>
                                                                        <small class="glyphicon glyphicon-time">
                                                                            (
                                                                            <?php echo $r->tanggal; ?>)
                                                                        </small>
                                                                    </div>
                                                                    <p>
                                                                        <?php echo $r->pesan; ?>

                                                                    </p>
                                                                    <p>
                                                                        <?php if(empty($r->files)){}else{?>
                                                                        <br><a target="_BLANK"
                                                                            href="{{ asset('uploads/pop/' . $r->files) }}">
                                                                            <font color="green">
                                                                                <?php echo $r->files; ?>
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
                                                                <a onclick="kirimchat()" class="btn btn-success"
                                                                    id="btn-chat">
                                                                    <font color="white">
                                                                        <i class="fa fa-paper-plane"></i>
                                                                        Send
                                                                    </font>
                                                                </a>
                                                                <a class="btn btn-info" data-toggle="modal"
                                                                    data-target="#myModal">
                                                                    <font color="white">
                                                                        <i class="fa fa-paperclip"></i>
                                                                    </font>
                                                                </a>
                                                                <a class="btn btn-warning" onclick="rfr()">
                                                                    <font color="white">
                                                                        <i class="fa fa-refresh"></i>
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

                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header"
                                                    style="background-color:#2e899e; color:white;">
                                                    <h6>Upload Proof of Payment</h6>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>

                                                </div>
                                                <form id="formId" action="{{ url('uploadpop') }}"
                                                    enctype="multipart/form-data" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="modal-body">
                                                        <div class="form-row">
                                                            <div class="col-sm-3">
                                                                <label><b>File
                                                                        Upload</b></label>
                                                            </div>
                                                            <div class="form-group col-sm-7">
                                                                <input type="hidden" class="form-control" name="idq"
                                                                    id="idq" value="<?php echo $id; ?>">
                                                                <input type="hidden" class="form-control" name="idb"
                                                                    id="idb" value="<?php echo $idb; ?>">
                                                                <input type="hidden" class="form-control" name="idc"
                                                                    id="idc" value="<?php echo Auth::guard('eksmp')->user()->id; ?>">
                                                                <input type="hidden" class="form-control" name="idd"
                                                                    id="idd" value="<?php echo Auth::guard('eksmp')->user()->profile != '' ? Auth::guard('eksmp')->user()->profile->company : Auth::guard('eksmp')->user()->profile_buyer->company; ?>">
                                                                <input type="hidden" class="form-control" name="ide"
                                                                    id="ide" value="<?php echo Auth::guard('eksmp')->user()->id_role; ?>">
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
                                                            <input type="hidden" name="id_chat"
                                                                value="{{ $idb }}">
                                                        </div>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success btn-submit-1">
                                                            <font color="white">Upload
                                                            </font>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-close-1"
                                                            data-dismiss="modal">Close</button>
                                                        <div class="loader" style="display: none;"></div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#2e899e; color:white;">
                                                <h6>Upload Proof of Payment</h6>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>

                                            </div>
                                            <form id="formId2" action="{{ url('uploadpop') }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="form-row">
                                                        <div class="col-sm-3">
                                                            <label><b>File Upload</b></label>
                                                        </div>
                                                        <div class="form-group col-sm-7">
                                                            <input type="hidden" class="form-control" name="idq"
                                                                id="idq" value="<?php echo $id; ?>">
                                                            <input type="hidden" class="form-control" name="idb"
                                                                id="idb" value="<?php echo $idb; ?>">
                                                            <input type="hidden" class="form-control" name="idc"
                                                                id="idc" value="<?php echo Auth::guard('eksmp')->user()->id; ?>">
                                                            <input type="hidden" class="form-control" name="idd"
                                                                id="idd" value="<?php echo Auth::guard('eksmp')->user()->profile != '' ? Auth::guard('eksmp')->user()->profile->company : Auth::guard('eksmp')->user()->profile_buyer->company; ?>">
                                                            <input type="hidden" class="form-control" name="ide"
                                                                id="ide" value="<?php echo Auth::guard('eksmp')->user()->id_role; ?>">
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

                                                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success btn-submit-2">
                                                        <font color="white">Upload</font>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-close-2"
                                                        data-dismiss="modal">Close</button>
                                                    <div class="loader2" style="display: none;"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <div align="left">
                                        <a href="{{ url('br_importir_lc/' . $id) }}"
                                            class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Back</a>


                                    </div>
                                </div>



                                <?php } ?>

                                <?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
                                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js">
                                </script>
                                <script type="text/javascript">
                                    $(function() {
                                        $('#example1').DataTable({
                                            "lengthMenu": [
                                                [10, 25, 50, -1],
                                                [10, 25, 50, "All"]
                                            ]
                                        });

                                        $('#example2').DataTable({
                                            "lengthMenu": [
                                                [10, 25, 50, -1],
                                                [10, 25, 50, "All"]
                                            ]
                                        });

                                        $('#yahoo').DataTable({

                                        });

                                        $('.select2').select2();
                                    });
                                </script>
                                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
                                <script type="text/javascript">
                                    $(function() {
                                        $('#users-table').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            ajax: "{{ url('getcsc') }}",
                                            columns: [{
                                                    data: 'row',
                                                    name: 'row'
                                                },
                                                {
                                                    data: 'f1',
                                                    name: 'f1'
                                                },
                                                {
                                                    data: 'f2',
                                                    name: 'f2'
                                                },
                                                {
                                                    data: 'f3',
                                                    name: 'f3'
                                                },
                                                {
                                                    data: 'f4',
                                                    name: 'f4'
                                                },
                                                {
                                                    data: 'f6',
                                                    name: 'f6',
                                                    orderable: false,
                                                    searchable: false
                                                },
                                                {
                                                    data: 'f7',
                                                    name: 'f7',
                                                    orderable: false,
                                                    searchable: false
                                                },
                                                {
                                                    data: 'action',
                                                    name: 'action',
                                                    orderable: false,
                                                    searchable: false
                                                }
                                            ]
                                        });
                                    });
                                </script>
                                <script>
                                    $(document).ready(function() {
                                        var con = document.getElementById("fg1");
                                        con.scrollTop = con.scrollHeight;

                                    });

                                    function kirimchat() {
                                        var a = $('#inputan').val();
                                        var b = {{ $id }};
                                        var c = {{ Auth::guard('eksmp')->user()->id_role }};
                                        var d = {{ Auth::guard('eksmp')->user()->id }};
                                        var e =
                                            "{{ Auth::guard('eksmp')->user()->load('profile', 'profile_buyer')->profile != ''
                                                ? Auth::guard('eksmp')->user()->load('profile', 'profile_buyer')->profile->company
                                                : Auth::guard('eksmp')->user()->load('profile', 'profile_buyer')->profile_buyer->company }}";
                                        var f = {{ $idb }};
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

                                            $('#inputan').val('');

                                            x = {{ $id }};
                                            y = {{ $idb }};
                                            $.get('{{ URL::to('refreshchat/') }}/' + x + '/' + y, {
                                                _token: token
                                            }, function(data) {
                                                $('#rchat').html(data)
                                            });

                                        }

                                    }

                                    function rfr() {
                                        a = {{ $id }};
                                        b = {{ $idb }};
                                        var token = $('meta[name="csrf-token"]').attr('content');
                                        $.get('{{ URL::to('refreshchat/') }}/' + a + '/' + b, {
                                            _token: token
                                        }, function(data) {
                                            $('#rchat').html(data);
                                            setTimeout(function() {
                                                var con = document.getElementById("fg1");
                                                con.scrollTop = con.scrollHeight;
                                            }, 1000);
                                        });
                                        //$('#rchat').html('Kosong')
                                    }
                                </script>
                                <script>
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
                                                '<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id; ?>"><?php echo $qr->nama_template; ?></option><?php } ?></select></div></div>'
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
                                </script>



                            </div>


                        </div>
                    </div>


                    <!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Broadcast Buying Request</h6>
          <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
         
        </div>
  <div id ="isibroadcast"></div>
        
      </div>
    </div>
  </div> -->

                    <!--<a href="{{ url('br_importir_add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add Buying Request</a><br><br> -->

                </div>

            </div>
        </div>
</section>
<!--
 <div class="product_details mt-20" style="background-color: #1A70BB; margin-bottom: 0px !important; margin-top: 0px; font-size: 14px;">
          <div class="container">
            <br><br>
          
            <br><br>
          </div>
      </div>
   <br><br><br> -->
<!--product area end-->

@include('frontend.layouts.footer')
<?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    $(function() {
        var a = {{ $id }};
        var b = {{ $idb }};
        var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        var channel = pusher.subscribe('notify-channel-' + b);
        var token = $('meta[name="csrf-token"]').attr('content');
        channel.bind('App\\Events\\Notify', function(data) {
            $.get('{{ URL::to('refreshchat/') }}/' + a + '/' + b, {
                _token: token
            }, function(data) {
                $('#rchat').html(data)
                setTimeout(function() {
                    var con = document.getElementById("fg1");
                    con.scrollTop = con.scrollHeight;
                }, 1000);
            });
        });



        $("#inputan").keypress(function(e) {
            if (e.which == 13) {
                kirimchat()
            }
        });
    })
    var token = $('meta[name="csrf-token"]').attr('content');
    $("#formId").submit(function(e) {
        $('.btn-submit-1, .btn-close-1').hide();
        $('.loader').show();

    });

    $("#formId2").submit(function(e) {
        $('.btn-submit-2, .btn-close-2').hide();
        $('.loader2').show();
    });
</script>
<script>
    function xy(a) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilbroad/') }}/' + a, {
            _token: token
        }, function(data) {
            $("#isibroadcast").html(data);

        })
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
                '<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id; ?>"><?php echo $qr->nama_template; ?></option><?php } ?></select></div></div>'
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
</script>
<script type="text/javascript">
    // $(document).ready(function () {

    // })
    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#' + tabname).addClass('active');
    }
</script>
