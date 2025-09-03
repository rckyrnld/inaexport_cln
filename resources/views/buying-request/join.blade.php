<?php // echo bcrypt('abc');die();
?>
@extends('header2')
@section('content')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <div class="padding">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">

                        <div class="col-md-14">
                            <div class="">


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

                                <?php 
    $q1 = DB::select("select * from csc_buying_request_join where id='".$id."'");
    foreach($q1 as $p){ $id_br = $p->id_br; }
    $q2 = ($public) ? DB::select("select * from csc_buying_request where id='".$id."'") : DB::select("select * from csc_buying_request where id='".$id_br."'");
    foreach($q2 as $p2){
?>
                                @php
                                    $lvl1 = $p2->id_csc_prod_cat_level1;
                                    $lvl2 = $p2->id_csc_prod_cat_level2;
                                    
                                    $vibe = DB::table('csc_product_single')
                                        ->where('id_itdp_company_user', Auth::guard('eksmp')->user()->id)
                                        ->where('id_csc_product', $p2->id_csc_prod_cat)
                                        ->when($lvl1 > 0, function ($q) use ($lvl1) {
                                            return $q->where('id_csc_product_level1', $lvl1);
                                        })
                                        ->when($lvl2 > 0, function ($q) use ($lvl2) {
                                            return $q->where('id_csc_product_level2', $lvl2);
                                        })
                                        ->first();
                                    
                                @endphp
                                @if (isset($vibe))
                                    <form class="form-horizontal" method="POST" action="{{ url('br_save') }}"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="col-lg-2 col-md-2 col-sm-12">
                                                            <label class="text-break"><b>Buyer</b></label>
                                                        </div>
                                                        <div>:</div>
                                                        <div class="col-lg-9 col-md-9 col-sm-11">
                                                            <label class="text-break">
                                                                <?php
                                                                if ($p2->by_role == 1) {
                                                                    echo 'Admin';
                                                                } elseif ($p2->by_role == 4) {
                                                                    echo 'Perwakilan';
                                                                } elseif ($p2->by_role == 3) {
                                                                    $usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $p2->id_pembuat . "'");
                                                                    foreach ($usre as $imp) {
                                                                        echo $imp->badanusaha . ' ' . $imp->company;
                                                                    }
                                                                }
                                                                ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-lg-2 col-md-2 col-sm-12">
                                                            <label class="text-break"> <b>Produk</b></label>
                                                        </div>
                                                        <div>:</div>
                                                        <div class="col-lg-9 col-md-9 col-sm-11">
                                                            <label class="text-break">
                                                                <?php echo $p2->subyek; ?>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-lg-2 col-md-2 col-sm-12">
                                                            <label class="text-break"> <b>Kategori Produk</b></label>
                                                        </div>
                                                        <div>:</div>
                                                        <div class="col-lg-9 col-md-9 col-sm-11">
                                                            <label class="text-break">
                                                                <?php
                                                                $cr = explode(',', $p2->id_csc_prod);
                                                                $hitung = count($cr);
                                                                $semuacat = '';
                                                                for ($a = 0; $a < $hitung - 1; $a++) {
                                                                    $namaprod = DB::select("select * from csc_product where id='" . $cr[$a] . "' ");
                                                                    foreach ($namaprod as $prod) {
                                                                        $napro = $prod->nama_kategori_en;
                                                                    }
                                                                    $semuacat = $semuacat . '' . $napro . '<br>';
                                                                }
                                                                echo $semuacat;
                                                                
                                                                ?>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-lg-2 col-md-2 col-sm-12">
                                                            <label class="text-break"><b>Alamat</b></label>
                                                        </div>
                                                        <div>:</div>
                                                        <div class="col-lg-9 col-md-9 col-sm-11">
                                                            <label class="text-break">
                                                                <?php
                                                                if ($p2->by_role == 1) {
                                                                    $co = $p2->id_mst_country;
                                                                    $naco = '';
                                                                    $caric = DB::select("select * from mst_country where id='" . $co . "'");
                                                                    foreach ($caric as $cc) {
                                                                        $naco = $cc->country;
                                                                    }
                                                                    echo $naco . ' ,' . $p2->city;
                                                                } elseif ($p2->by_role == 4) {
                                                                    $co = $p2->id_mst_country;
                                                                    $naco = '';
                                                                    $caric = DB::select("select * from mst_country where id='" . $co . "'");
                                                                    foreach ($caric as $cc) {
                                                                        $naco = $cc->country;
                                                                    }
                                                                    echo $naco . ' ,' . $p2->city;
                                                                } elseif ($p2->by_role == 3) {
                                                                    $usre = DB::select("select b.addres,b.city from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $p2->id_pembuat . "'");
                                                                    foreach ($usre as $imp) {
                                                                        echo $imp->addres . ' , ' . $imp->city;
                                                                    }
                                                                }
                                                                ?>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-lg-2 col-md-2 col-sm-12">
                                                            <label class="text-break"><b>Tanggal Inquiry</b></label>
                                                        </div>
                                                        <div>:</div>
                                                        <div class="col-lg-9 col-md-9 col-sm-11">
                                                            <label class="text-break"><?php echo $p2->date; ?></label>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-lg-2 col-md-2 col-sm-12">
                                                            <label class="text-break"> <b>Spesifikasi</b></label>
                                                        </div>
                                                        <div>:</div>
                                                        <div class="col-lg-9 col-md-9 col-sm-11">
                                                            <label class="text-break"><?php echo $p2->spec; ?></label>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="form-row">
                                                    <div class="col-lg-2 col-md-2 col-sm-12">
                                                        <label class="text-break"><b>File</b></label>
                                                    </div>
                                                    <div>:</div>
                                                    <div class="col-lg-9 col-md-9 col-sm-11">
                                                        <a download
                                                            href="{{ asset('uploads/buy_request/' . $p2->files) }}">
                                                            @php echo $p2->files; @endphp
                                                        </a>
                                                    </div>
                                                </div> --}}
                                                </div>

                                            </div>


                                            <div class="col-sm-12">
                                                <div align="center"><br>
                                                    @if ($public)
                                                        <a href="{{ url('br_join_published/' . $id) }}"
                                                            class="btn btn-md btn-primary">I'm Interested</a>
                                                    @else
                                                        <a href="{{ url('br_save_join/' . $id) }}"
                                                            class="btn btn-md btn-primary">Join</a>
                                                    @endif
                                                    <a href="{{ $public ? url('front_end/ourinqueris') : url('br_list') }}"
                                                        class="btn btn-md btn-danger">Back</a>

                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                @else
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="col-lg-12 col-md-2 col-sm-12">
                                                        <label class="text-break"><b>Your product category is not match
                                                                with this inquiry…</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <a href="{{ $public ? url('front_end/ourinqueris') : url('br_list') }}"
                                            class="btn btn-md btn-danger">Back</a>

                                    </div>
                            </div>
                            @endif

                            <?php } ?>
                            <?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
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

            </div>

        </div>
    </div>
    </div>

    @include('footer')

@endsection
