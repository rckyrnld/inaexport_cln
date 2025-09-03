<?php // echo bcrypt('abc');die();
?>
@extends('header2')
@section('content')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
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

    </style>
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
    <div class="padding">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body bg-light">
                        <div class="col-md-14">
                            <div class="">
                                <form class="form-horizontal" method="POST" action="{{ url('br_save_trx') }}"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <?php 
							$q1 = DB::select("select * from csc_buying_request_join where id='".$id2."'");
							foreach($q1 as $p){ $id_br = $p->id_br; }
							$q2 = DB::select("select * from csc_buying_request where id='".$id."'");
							foreach($q2 as $p2){
							?>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="box-body">
                                                <br><br>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>Category Product</b>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <?php
                                                        $ms1 = DB::select("select id,nama_kategori_en from csc_product where id='" . $p2->id_csc_prod_cat . "'");
                                                        foreach ($ms1 as $kc1) {
                                                            echo $kc1->nama_kategori_en;
                                                        }
                                                        ?>
                                                    </div>

                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>Kind of Subject</b>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        Offer to buy
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>Date</b>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <?php echo $p2->date; ?>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>Quantity</b>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <input type="number" class="form-control"
                                                            value="<?php echo $p2->eo; ?>" readonly>
                                                    </div>
                                                    <div class="form-group col-sm-1">
                                                        <input type="hidden" name="id1" class="form-control"
                                                            value="<?php echo $id; ?>">
                                                        <input type="hidden" name="id2" class="form-control"
                                                            value="<?php echo $id2; ?>">
                                                        <input type="text" class="form-control"
                                                            value="<?php echo $p2->neo; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>Price</b>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <input type="number" class="form-control"
                                                            value="<?php echo $p2->tp; ?>" readonly>
                                                    </div>
                                                    <div class="form-group col-sm-1">
                                                        <input type="text" class="form-control"
                                                            value="<?php echo $p2->ntp; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>Subject</b>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <?php echo $p2->subyek; ?>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>Messages</b>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <?php echo $p2->spec; ?>
                                                        <input type="hidden" id="id_br" value="<?php echo $id_br; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>File</b>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <a download
                                                            href="{{ asset('uploads/buy_request/' . $p2->files) }}"><?php echo $p2->files; ?></a>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>Sources</b>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        Buying Request
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>Tracking of Type</b>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <select <?php if ($p2->status_trx == 1) {
    echo 'readonly';
} ?> class="form-control"
                                                            name="type_tracking" required>
                                                            <option value="">- Select Tracking Type -</option>
                                                            <option <?php if ($p2->type_tracking == 'DHL Express') {
    echo 'selected';
} ?> value="DHL Express">DHL Express
                                                            </option>
                                                            <option <?php if ($p2->type_tracking == 'DHL Active Tracing') {
    echo 'selected';
} ?> value="DHL Active Tracing">DHL
                                                                Active Tracing</option>
                                                            <option <?php if ($p2->type_tracking == 'DHL Global Forwarding') {
    echo 'selected';
} ?> value="DHL Global Forwarding">DHL
                                                                Global Forwarding</option>
                                                            <option <?php if ($p2->type_tracking == 'Fedex') {
    echo 'selected';
} ?> value="Fedex">Fedex</option>
                                                            <option <?php if ($p2->type_tracking == 'Fedex Freight') {
    echo 'selected';
} ?> value="Fedex Freight">Fedex Freight
                                                            </option>
                                                            <option <?php if ($p2->type_tracking == 'FedEx Ground') {
    echo 'selected';
} ?> value="FedEx Ground">FedEx Ground
                                                            </option>
                                                            <option <?php if ($p2->type_tracking == 'China EMS') {
    echo 'selected';
} ?> value="China EMS">China EMS
                                                            </option>
                                                            <option <?php if ($p2->type_tracking == 'Deutsche Post DHL') {
    echo 'selected';
} ?> value="Deutsche Post DHL">Deutsche
                                                                Post DHL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-2">
                                                        <b>No Tracking</b>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <input class="form-control" type="text" id="no_track"
                                                            name="no_track" value="<?php echo $p2->no_track; ?>"
                                                            <?php if ($p2->status_trx == 1) {
                                                                echo 'readonly';
                                                            } ?> required>
                                                        <input class="form-control" type="hidden" id="tipekirim"
                                                            name="tipekirim" value="" required>
                                                    </div>
                                                </div>
                                                <div class="form-row">

                                                    <div class="form-group col-sm-5">

                                                        <center>
                                                            <?php if($p2->status_trx != 1){ ?>
                                                            <button style="width:33%;" onclick="getyou(1)" type="submit"
                                                                class="btn btn-info">Submit</button>
                                                            <button style="width:30%;" onclick="getyou(0)" type="submit"
                                                                class="btn btn-warning">
                                                                <font color="white">Draft</font>
                                                            </button>
                                                            <?php } ?>
                                                            <a style="width:33%;" href="{{ url('trx_list') }}"
                                                                class="btn btn-danger">Cancel</a>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                </form>
                                <?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        function getyou(x) {
            $('#tipekirim').val(x);
        }

        function kirimchat() {
            var a = $('#inputan').val();
            var b = $('#id_br').val();
            var c = <?php echo Auth::guard('eksmp')->user()->id_role; ?>;
            var d = <?php echo Auth::guard('eksmp')->user()->id; ?>;
            var e = '<?php echo Auth::guard('eksmp')->user()->username; ?>';
            var f = '<?php echo $id; ?>';
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
                $('#rchat').append(
                    '<li class="right clearfix"><span class="chat-img pull-right"><img src="https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix pull-right"><div class="header"><strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo Auth::guard('eksmp')->user()->username; ?></b></strong><small class="glyphicon glyphicon-time"> (<?php echo date('Y-m-d H:m:s'); ?>)</small></div><p>' +
                    a + '</p></div></li>');
                $('#inputan').val('');
            }

        }

        function rfr() {
            a = $('#id_br').val();
            b = <?php echo $id; ?>;
            var token = $('meta[name="csrf-token"]').attr('content');
            $.get('{{ URL::to('refreshchat/') }}/' + a + '/' + b, {
                _token: token
            }, function(data) {
                $('#rchat').html(data)
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
    @include('footer')
@endsection
