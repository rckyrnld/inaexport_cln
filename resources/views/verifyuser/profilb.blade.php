@extends('header2')
@section('content')
<!-- kalo ada yang gak bisa dipencet, coba liat sharethis ini, ada settingan gdpr di nonactive aja -->
<script
    src="https://platform-api.sharethis.com/js/sharethis.js#property=5e40ad0fac2cac001a00d45a&product=inline-share-buttons">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
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

    .form-group {
        margin-bottom: 0.5rem;
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

    .st-custom-button[data-network] {
        /*background-color: #9EEC46;*/
        display: inline-block;
        padding: 5px 10px;
        cursor: pointer;
        font-weight: bold;
        color: #fff;
    }

    .img_upl {
        /*border: 1px solid #6fccdd;*/
        border: none;
        background: transparent;
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
        height: 33px !important;
    }
</style>
<form class="form-horizontal" method="POST" id="profil" action="{{ url('simpan_profil') }}"
    enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id_role" value="{{ $ida }}">
    <input type="hidden" name="id_user" value="{{ $idb }}">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
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

                    <h3>Profile Perusahaan</h3>
                    <hr class="mb-3">


                    {{-- <div id="London" class="tabcontent" style="display:block;"> --}}
                        <div class="card-body mb--6 mt--4">
                            <h3>Account Information Supplier</h3><br>
                            <?php
                    $ca = DB::select("select * from itdp_company_users where id='$idb' limit 1");
                    foreach ($ca as $rhj) {
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="form-group col-sm-4 mt-2">
                                            <label>PIC (Nama)</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $rhj->username }}" name="username"
                                                id="username" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4 mt-2">
                                            <label>Email</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="email" value="{{ $rhj->email }}" name="email" id="email"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4 mt-2">
                                            <label>Password</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="password" value="" name="password" id="password"
                                                class="form-control" placeholder="##########">
                                            <br>
                                            <input id="password" type="checkbox" onclick="lihatpass()">&nbsp;<label>Show
                                                Password</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4 mt-2">
                                            <label>Re-Password</label>

                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="password" value="" name="repass" id="repass"
                                                class="form-control" placeholder="##########">
                                            <br>
                                            <input type="checkbox" onclick="lihatpassulang()">&nbsp;Show Password
                                        </div>
                                    </div>
                                </div>
                                <?php }

                        if ($ida == 2) {
                            //echo "jual";
                            $ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$idb' limit 1");
                        } else {
                            $ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$idb' limit 1");
                        }
                        foreach ($ceq as $ryu) {
                            ?>
                                <div class="col-md-6 mt--5">
                                    <center>
                                        <div id="ambil_ttd_1"
                                            style="width: 50%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                            <button type="button" id="qrcode" style="width: 100%;" class="img_upl">
                                                <?php
                                                //for qrcode
                                                $fileqrcode =  public_path() . '/uploads/qrcode/qrcode_2_' . $ryu->id_user . '.png';
                                                $qrcode = 'uploads/qrcode/profile2.png';
                                                if (file_exists($fileqrcode)) {
                                                    $qrcode = 'uploads/qrcode/qrcode_2_' . $ryu->id_user . '.png';
                                                    ?>
                                                <br><img id="qrcode_ambil1"
                                                    style="width: 70%;" />
													<!--<img src="{{ URL::to('/') }}/{{ $qrcode }}" id="qrcode_ambil1"
                                                    style="width: 70%;" /> -->
                                                <?php
                                                } else {
                                                    ?>
                                                {{-- <input type="text" value="{{$fileqrcode}}"> --}}
                                                <br><img src="{{ URL::to('/') }}/{{ $qrcode }}" id="qrcode_ambil1"
                                                    style="width: 70%;" />
                                                <?php
                                                }
                                                ?>
                                            </button>
                                            <a class="btn btn-md btn-primary" id="gen_qrcode" onclick="qrcode()"
                                                style="display: none;"></a>
                                            {{-- <input type="file" id="image_1" name="image_1" accept="image/*"
                                                style="display: none;" /> --}}
                                            <br><br>
                                            <center><span style="font-size: 17px;"><b>QR Code</b></span></center>
                                        </div>
                                        <br>
                                        <a style="color: blue;" href="{{asset('uploads/qrcode/qrcode_2_'.$ryu->id_user.'.png')}}" download>Download QRCode</a><br>
                                        <div style="border-style: solid; width: 50%">
                                            <span style="color: black">Share Your Profile to Social Media</span><br>
                                            <div data-network="twitter" class="st-custom-button"
                                                data-url="{{ URL::to('/perusahaan/') . '/' . auth::guard('eksmp')->user()->id }}">
                                                <i class="fab fa-twitter" style="font-size:24px;color:deepskyblue"></i>
                                            </div>
                                            <div data-network="facebook" class="st-custom-button"
                                                data-url="{{ URL::to('/perusahaan/') . '/' . auth::guard('eksmp')->user()->id }}">
                                                <i class="fab fa-facebook-f" style="font-size:24px;color:blue"></i>
                                            </div>
                                            <div data-network="whatsapp" class="st-custom-button"
                                                data-url="{{ URL::to('/perusahaan/') . '/' . auth::guard('eksmp')->user()->id }}">
                                                <i class="fab fa-whatsapp" style="font-size:24px;color:lawngreen"></i>
                                            </div>
                                        </div>
                                    </center>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <hr class="mt-2 mb-2">
                        <div class="card-body mt--4 mb--4">

                            <h3>Company Profile</h3><br>
                            <?php
                if ($ida == 2) {

                    $ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$idb' limit 1");
                } else {
                    $ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$idb' limit 1");
                }
                // dd($ceq);
                foreach ($ceq as $ryu) {
                    $img1 = "front/assets/icon/profile2.png";
                    if ($ryu->foto_profil != NULL) {
                        $imge1 = 'uploads/Profile/Eksportir/' . $ryu->id_user . '/' . $ryu->foto_profil;
                        if (file_exists($imge1)) {
                            $img1 = 'uploads/Profile/Eksportir/' . $ryu->id_user . '/' . $ryu->foto_profil;
                        }
                    }

                    ?>
                            <input type="hidden" name="idu" value="{{ $ryu->id }}">
                            <input type="hidden" name="staim" value="{{ $rhj->status }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Name of Company</label>
                                        </div>

                                        <div class="form-group col-sm-2">

                                            <select name="badanusaha" class="form-control">
                                                <option>-</option>
                                                <?php
                                            $bns = DB::select("select * from eks_business_entity");
                                            foreach ($bns as $val) {
                                                ?>
                                                <option <?php if ($ryu->badanusaha == $val->nmbadanusaha) {
                                                    echo 'selected';
                                                    } ?>
                                                    value="{{ $val->nmbadanusaha . ',' . $val->id }}">
                                                    {{ $val->nmbadanusaha }}</option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <input type="text" value="{{ $ryu->company }}" name="company" id="company"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Year of Establishment</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->year_establish }}" name="year_establish"
                                                id="year_establish" class="form-control" maxlength="9999">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Main Product</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->main_product }}" name="main_product"
                                                id="main_product" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Company Description</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <textarea name="description" id="description"
                                                class="form-control">{{ $ryu->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Address</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <textarea name="addres" id="addres"
                                                class="form-control">{{ $ryu->addres }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>City</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <textarea name="city" id="city"
                                                class="form-control">{{ $ryu->city }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Province</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <select name="province" id="province" class="form-control select2"
                                                style="width: 100%">
                                                <?php
                                            $qc = DB::select("select id,province_en from mst_province order by province_en asc");
                                            foreach ($qc as $cq) {
                                                ?>
                                                <option <?php if ($cq->id == $ryu->id_mst_province) {
                                                    echo 'selected';
                                                    } ?> value="{{ $cq->id }}">
                                                    {{ $cq->province_en }}</option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Zip Code</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->postcode }}" name="postcode"
                                                id="postcode" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Fax</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->fax }}" name="fax" id="fax"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Scale of Business</label>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <select name="scoope" id="scoope" class="form-control"
                                                onchange="Scoope(this)">
                                                <option>-</option>
                                                <?php
                                            $sob = DB::select("select * from eks_business_size order by size_order");
                                            foreach ($sob as $val) {
                                                ?>
                                                <option <?php if ($ryu->id_eks_business_size == $val->id) {
                                                    echo 'selected';
                                                    } ?> value="{{ $val->id }}">
                                                    {{ $val->size }}</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <input type="text" id="scoope_in" class="form-control" readonly
                                                value="{{ $ryu->id_eks_business_size == null ? '' : SOB($ryu->id_eks_business_size) }}">
                                        </div>
                                    </div>



                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Incoterm</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <select name="incoterm" id="incoterm" class="form-control select2"
                                                style="width: 100%">
                                                <?php
                                            $qc = DB::select("select id,incoterm from mst_incoterm order by incoterm asc");
                                            foreach ($qc as $cq) {
                                                ?>
                                                <option <?php if ($cq->id == $ryu->id_incoterm) {
                                                    echo 'selected';
                                                    } ?> value="{{ $cq->id }}">
                                                    {{ $cq->incoterm }}
                                                </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Terms of Payment</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <select name="payment" id="payment" class="form-control select2"
                                                style="width: 100%">
                                                <?php
                                            $qc = DB::select("select id,payment from mst_payment order by payment asc");
                                            foreach ($qc as $cq) {
                                                ?>
                                                <option <?php if ($cq->id == $ryu->id_payment) {
                                                    echo 'selected';
                                                    } ?> value="{{ $cq->id }}">
                                                    {{ $cq->payment }}
                                                </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Employee</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->employe }}" name="employee" id="employee"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4 mt-2">
                                            <label>Website</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->website }}" onkeyup="cekwebsite()"
                                                name="website" id="website" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4 mt-2">
                                            <label>E-mail</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->email }}" name="email1" id="email1"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4 mt-2">
                                            <label>Phone</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->phone }}" name="phone" id="phone"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4 mt-2">
                                            <label>Type of Business</label>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <select name="tob" id="tob" class="form-control" onchange="TOB(this)">
                                                <option>-</option>
                                                <?php
                                            $tob = DB::select("select * from eks_business_role");
                                            foreach ($tob as $val) {
                                                ?>
                                                <option <?php if ($ryu->id_business_role_id == $val->id) {
                                                    echo 'selected';
                                                    } ?> value="{{ $val->id }}">
                                                    {{ $val->nmtype }}
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <input type="text" id="tob_in" class="form-control" readonly
                                                value="{{ $ryu->id_business_role_id == null ? '' : TOB($ryu->id_business_role_id) }}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Link Google Maps</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->link_gmap }}" name="map_link"
                                                id="map_link" class="form-control" placeholder="Map Link">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Longitude</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->long }}" name="long" id="long"
                                                class="form-control" placeholder="Long">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-sm-4">
                                            <label>Latitude</label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" value="{{ $ryu->lat }}" name="lat" id="lat"
                                                class="form-control" placeholder="Lat">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <div id="ambil_ttd_1"
                                            style="width: 50%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                            <button type="button" id="img_1" style="width: 100%;" class="img_upl">
                                                <br><img src="{{ asset($img1) }}" id="image_1_ambil"
                                                    style="width: 80%;" />
                                            </button>
                                            <input type="file" id="image_1" name="image_1" accept=".jpg, .jpeg, .png"
                                                style="display: none;" />
                                            <br><br>
                                            <center><span style="font-size: 17px;">Company logo</span></center>
                                        </div>
                                        <br>
                                        <span style="color: red;">* Click image to upload a company logo</span>
                                    </center>
                                    <br><br>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <hr class="mt-2 mb-2">

                        <input type="hidden" name="id_role" value="{{ $ida }}">
                        <input type="hidden" name="id_user" value="{{ $idb }}">

                        <div class="card-body mt--4 mb--5">
                            <!--Menu Dokumen Perusahaan-->
                            <h3>Dokumen Perusahaan</h3><br>
                            <?php
                $ca = DB::select("select * from itdp_company_users where id='$idb' limit 1");
                foreach ($ca as $rhj) {
                    if ($ida == 2) {
                        //echo "jual";
                        $ceq = DB::select("select b.*, b.npwp, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$idb' limit 1");
                    } else {
                        $ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$idb' limit 1");
                    }
                    ?>
                            <?php foreach ($ceq as $ryu) { ?>
                            <input type="hidden" name="idu" value="{{ $ryu->id }}">

                            @if ($message = Session::get('warning'))
                            <div class="alert alert-info text-center">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif

                            {{-- <div class="form-row"> --}}
                                {{-- <div class="form-group col-sm-4"> --}}
                                    {{-- </div> --}}
                                {{-- <div class="form-group col-sm-4"> --}}
                                    {{-- --}}
                                    {{-- </div> --}}

                                {{-- </div> --}}

                            <div class="form-group row">
                                <label class="col-sm-2 mt-2">
                                    <font color="red">(*)</font> NPWP
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Number Only(without dot)" value="{{ $ryu->npwp }}"
                                        name="npwp" id="npwp" class="form-control" aria-describedby="npwphelp" required>
                                    <small id="npwphelp">Diinput hanya karakter angka</small>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 mt-2">
                                    <font color="red">(*)</font> Dokumen NPWP
                                </label>
                                <div class="col-sm-4">
                                    <?php
                                        if (empty(Auth::user()->name)) {  ?>
                                    <input type="file" name="npwpfile" id="npwpfile" class="form-control  upload1" accept=".jpg, .jpeg, .png, .pdf">
                                    <?php if ($ryu->uploadnpwp == null) {
                                                    echo "";
                                                } else { ?>
                                    <span style="font-size:13px">File Sebelumnya : <a
                                            href="{{ asset('eksportir/' . $ryu->uploadnpwp) }}">
                                            {{ $ryu->uploadnpwp }}</a></span>
                                    <input type="hidden" id="docNPWP" value={{ $ryu->uploadnpwp }}>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <span>
                                        <?php if (empty($ryu->uploadnpwp) || $ryu->uploadnpwp == null) {
                                                            echo "<font color='red'>No File</font>";
                                                        } else { ?>
                                        <a href="{{ asset('eksportir/' . $ryu->uploadnpwp) }}">{{ $ryu->uploadnpwp
                                            }}</a>
                                        <?php } ?>
                                    </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 mt-2">
                                    <font color="red">(*)</font> Nomor Induk Berusaha
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" value="{{ $ryu->tdp }}" name="tanda_daftar" id="tanda_daftar"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 mt-2">
                                    <font color="red">(*)</font> Dokumen Nomor Induk Berusaha
                                </label>
                                <div class="col-sm-4">
                                    <?php
                                        if (empty(Auth::user()->name)) {  ?>
                                    <input type="file" name="tdpfile" id="tdpfile" class="form-control upload1" accept=".jpg, .jpeg, .png, .pdf">
                                    <?php if ($ryu->uploadtdp == null) {
                                                    echo "";
                                                } else { ?>
                                    <span>File Sebelumnya : <a href="{{ asset('eksportir/' . $ryu->uploadtdp) }}">{{
                                            $ryu->uploadtdp }}</a></span>
                                    <input type="hidden" id="docNIB" value="{{ $ryu->uploadtdp }}">
                                    <?php } ?>
                                    <?php } else { ?>
                                    <span style="font-size:13px">
                                        <?php if (empty($ryu->uploadtdp) || $ryu->uploadtdp == null) {
                                                                                    echo "<font color='red'>No File</font>";
                                                                                } else { ?>
                                        <a href="{{ asset('eksportir/' . $ryu->uploadtdp) }}">{{ $ryu->uploadtdp }}</a>
                                        <?php } ?>
                                    </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                                                    <label class="col-sm-2 mt-2">Surat Izin Usaha Perdagangan</label>
                                                                    <div class="col-sm-4">
                                                                     <input type="text" value="{{ $ryu->siup }}" name="siup" id="siup" class="form-control">
                                                                    </div>
                                                                    <label class="col-sm-2 mt-2">Dokumen Surat Izin Usaha Perdagangan</label>
                                                                    <div class="col-sm-4">
                                                                     <?php
                                        if (empty(Auth::user()->name)) {  ?>
                                                                                                <input type="file" name="siupfile" id="siupfile"
                                                                                                    class="form-control upload1">
                                                                                                <?php if ($ryu->uploadsiup == null) {
                                                                        echo "";
                                                                    } else { ?>
                                                                                                <span style="font-size:13px">File Sebelumnya : <a
                                                                                                        href="{{ asset('eksportir/' . $ryu->uploadsiup) }}"></a><?php echo $ryu->uploadsiup; ?></span>
                                                                                                <?php } ?>
                                                                                                <?php } else { ?>
                                                                                                <span><?php if (empty($ryu->uploadsiup) || $ryu->uploadsiup == null) {
                                                                                echo "<font color='red'>No File</font>";
                                                                            } else { ?>
                                                                                                    <a
                                                                                                        href="{{ asset('eksportir/' . $ryu->uploadsiup) }}"><?php echo $ryu->uploadsiup; ?></a>
                                                                                                    <?php } ?>
                                                                                                </span>
                                                                                                <?php } ?>
                                                                    </div>
                                                                   </div> -->

                            <!-- <div class="form-group row">
                                                                    <label class="col-sm-2 mt-2">Surat Izin Tanda Usaha</label>
                                                                    <div class="col-sm-4">
                                                                     <input type="text" value="{{ $ryu->upduserid }}" name="situ" id="situ"
                                                                                                    class="form-control">
                                                                    </div>
                                                                    <label class="col-sm-2 mt-2"> <?php
if (empty(Auth::user()->name)) {
    echo 'Document';
} else {
    echo 'File Upload from Exporter';
} ?>
                                                                     </label>
                                                                    <div class="col-sm-4">
                                                                     <?php
                                        if (empty(Auth::user()->name)) {  ?>
                                                                                                <input type="file" value="" name="doc" id="doc"
                                                                                                    class="form-control upload1">
                                                                                                <?php if ($ryu->doc == null) {
                                                                        echo "";
                                                                    } else { ?>
                                                                                                <span style="font-size:13px">File Sebelumnya : <a
                                                                                                        href="{{ asset('eksportir/' . $ryu->doc) }}"><b>{{ $ryu->doc }}</b></a></span>
                                                                                                <?php } ?>
                                                                                                <?php } else { ?>
                                                                                                <span><?php if (empty($ryu->doc) || $ryu->doc == null) {
                                                                                echo "<font color='red'>No File</font>";
                                                                            } else { ?>
                                                                                                    <a
                                                                                                        href="{{ asset('eksportir/' . $ryu->doc) }}">{{ $ryu->doc }}</a>
                                                                                                    <?php } ?>
                                                                                                </span>
                                                                                                <?php } ?>
                                                                    </div>
                                                                   </div> -->

                            <!-- <div class="form-group row">
                                                                    <label class="col-sm-2 mt-2">Status Exporter</label>
                                                                    <div class="col-sm-4">
                                                                     <span class="labelverif">
                                                                                                    <?php if (empty(Auth::user()->name)) {
                                                                        if ($rhj->status == 1) {
                                                                            echo "Verified";
                                                                        } else if ($rhj->status == 2) {
                                                                            echo "Not Verified";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                        ?>
                                                                                                </span>
                                                                                                <input type="hidden" name="staim" id="staim"
                                                                                                    value="{{ $rhj->status }}">
                                                                                                <?php
                                                                } else { ?>
                                                                                                <select class="form-control" name="staim">
                                                                                                    <option <?php if ($rhj->status == 0) {
    echo 'selected';
} ?> value="0">-- Choose Status --</option>
                                                                                                    <option <?php if ($rhj->status == 1) {
    echo 'selected';
} ?> value="1">Verified</option>
                                                                                                    <option <?php if ($rhj->status == 3) {
    echo 'selected';
} ?> value="3">Not Verified</option>
                                                                                                </select>
                                                                                                <?php } ?>

                                                                                            </div>
                                                                                        </div> -->
                            {{-- penutup foreach ryu --}}
                            <?php } ?>
                            {{-- penutup foreach rhj --}}
                            <?php } ?>
                        </div>
                        <br>


                        <hr class="mt-2 mb-2">

                        <div class="table-responsive">
                            <button class="btn btn-success ml-5" type="button" id="tambah_contact"><span
                                    class="fa fa-plus"></span> Contact
                            </button>
                            <br>
                            <br>
                            <table id="tablecontact" class="table table-striped table-hover">
                                <thead class="text-white" style="background-color: #6B7BD6;">
                                    <tr>
                                        <!-- <th>
                                                                                <center>No</center>
                                                                            </th> -->
                                        <th>
                                            <center>
                                                Name
                                            </center>
                                        </th>
                                        <th>
                                            <center>Position</center>
                                        </th>
                                        <th>
                                            <center>Phone</center>
                                        </th>
                                        <th>
                                            <center>Action</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="body_contact">
                                    @foreach ($user as $key => $val)
                                    <tr>
                                        <td>
                                            <input type="text" name="name_c[]" value="{{ $val->name }}"
                                                class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="phone_c[]"
                                                value="{{ $val->phone }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="position_c[]"
                                                value="{{ $val->job_title }}">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="removenama(this)" title="Hapus"><i
                                                    class="fa fa-trash text-white"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <br>

                        <div align="left" class="ml-5">
                            <?php if (empty(Auth::user()->name)) { } else { ?>
                            <a href="{{ url('verifyuser') }}" class="btn btn-md btn-danger"><i
                                    class="fa fa-arrow-left"></i> Kembali</a>
                            <?php } ?>
                            <button type="button" class="btn btn-md btn-primary" id="simpanBtn"
                                onclick="send('#profil')"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    </div>
</form>

<script>
    function lihatpass() {
            var x = document.getElementById("password");
            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function lihatpassulang() {
            var x = document.getElementById("repass");
            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function ceknpwp() {

            var inputnpwp = $("#npwp").val();
            var jumlahkarakter = inputnpwp.length;
            // alert('1234567');
            if (jumlahkarakter == 15) {
                $.get('{{ url(' / ceknpwp ') }}', {
                    id: inputnpwp
                }, function(data) {
                    json = JSON.parse(data);
                    console.log('metro');
                    console.log(json.nama);
                    console.log(json.status);
                    if (json.status == "VALID") {
                        $('.vld').html("<font color='green'>Valid</font>");
                        alert("NPWP terdaftar dengan nama " + json.nama);

                    } else {
                        alert("NPWP Tidak Benar, Silahkan Hubungin Kantor Pajak Terdekat");
                        $('.vld').html("<font color='red'>Not Valid</font>");
                        $("#npwp").val('');
                    }
                    //console.log(data.status);
                    // alert(jumlahkarakter);

                })
            } else {
                $('.vld').html("<font color='red'>Not Valid</font>");
            }


        }
</script>

<script>
    $(document).ready(function() {
            $('.select2').select2();
            $("#img_1").click(function() {
                $("input[id='image_1']").click();
            });
            document.getElementById("image_1").addEventListener('change', handleFileSelect, false);
            //for qrcode
            $("#qrcode").click(function() {
                $("#gen_qrcode").click();
            });

            let count = 0;

            $("#tambah_contact").click(function() {
                var html = '';
                i_geokimia = 0
                i_geokimia += 1;
                id_jenis = 0;
                jenis = '';
                negara = '';
                var conter = parseInt($('#conter_geo_bb').val());
                $('#conter_geo_bb').val(conter + 1);
                isi = '<tr id="trgeokimia' + $('#conter_geo_bb').val() + '">' +
                    '<td> <input class="form-control" type="text" name="name_c[]" > </td>' +
                    '<td> <input class="form-control" type="text" name="phone_c[]" ></td>' +
                    '<td> <input class="form-control" type="text" name="position_c[]" ></td>' +
                    '<td><button type="button" class="btn btn-sm btn-danger" onclick="removenama(this)" title="Hapus"><i class="fa fa-trash" aria-hidden="true"></i></button></td>' +
                    '</tr>';
                $('#body_contact').append(isi);
                count++;
            });
		
		var id = {{ auth::guard('eksmp')->user()->id }};

            $.ajax({
                type: 'GET',
                url: "{{ route('eksportir.qrcode') }}",
                data: {
                    code: id
                },
            }).then(function(data) {
                $("#qrcode_ambil1").attr('src', 'uploads/qrcode/qrcode_2_' + id + '.png');
            });
			
        });

        function removenama(obj) {
            $(obj).parent().parent().remove()
        }

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

        function handleFileSelect(evt) {
            var files = evt.target.files; // FileList object
            var idfile = evt.target.id; // FileList object

            // FileReader support
            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function() {
                    document.getElementById(idfile + "_ambil").src = fr.result;
                    document.getElementById(idfile + "_ambil").style.width = "100%";
                    document.getElementById(idfile + "_ambil").style.height = "100%";
                }
                fr.readAsDataURL(files[0]);
            }
        }
</script>

<script>
    (function(document) {
            var shareButtons = document.querySelectorAll(".st-custom-button[data-network]");
            for (var i = 0; i < shareButtons.length; i++) {
                var shareButton = shareButtons[i];

                shareButton.addEventListener("click", function(e) {
                    var elm = e.target;
                    var network = elm.dataset.network;

                    console.log("share click: " + network);
                });
            }
        })(document);
</script>

<script>
    $('.upload1').on('change', function(evt) {
            var size = this.files[0].size;
            if (size > 5000000) {
                // if(size > 20000){
                $(this).val("");
                alert('image size must less than 5MB');
            } else {

            }
        })

        function qrcode() {
            var id = {{ auth::guard('eksmp')->user()->id }};

            $.ajax({
                type: 'GET',
                url: "{{ route('eksportir.qrcode') }}",
                data: {
                    code: id
                },
            }).then(function(data) {
                $("#qrcode_ambil1").attr('src', 'uploads/qrcode/qrcode_2_' + id + '.png');
            });
        }

        function Scoope(obj) {
            csrf_token = '{{ csrf_token() }}';
            val = $(obj).val();
            $('#scoope_in').val('');
            $.post("{{ route('getscoope') }}", {
                '_token': csrf_token,
                'id': val
            }, function(response) {
                res = JSON.parse(response);
                $('#scoope_in').val(res.nmsize_ind);
            });
        }

        function TOB(obj) {
            csrf_token = '{{ csrf_token() }}';
            val = $(obj).val();
            $('#tob_in').val('');
            $.post("{{ route('gettob') }}", {
                '_token': csrf_token,
                'id': val
            }, function(response) {
                res = JSON.parse(response);
                $('#tob_in').val(res.nmtype_ind);
            });
        }

        function cekwebsite() {
            var m = $('#website').val();
            var carikoma = m.search(",");
            if (carikoma != "-1") {
                $('#website').val("");
            }
            var carispa = m.search(" ");
            if (carispa != "-1") {
                $('#email').val("");
            }
        }

        function send(form) {
            console.log('kesini');
            if ($('#password').val() != $('#repass').val()) {
                alert('Make sure the value re-password and password is same');
                $('#repass').focus();

            } else {
                let npwp = $('#npwp').val();
                let doc_npwp = $('#npwpfile').val();
                let no_induk_berusaha = $('#tanda_daftar').val();
                let dok_no_induk_berusaha = $('#tdpfile').val();
                let docNPWP = $('#docNPWP').val();
                let docNIB = $('#docNIB').val();
                if (npwp == '' || no_induk_berusaha == '' || docNPWP == '' || docNIB == '') {
                    alert('You have to fill the required fields');
                    // console.log("kosong ??");
                    if (npwp == '') {
                        $('#npwp').focus();
                    }
                    if (doc_npwp == '') {
                        $('#npwpfile').focus();
                    }
                    if (no_induk_berusaha == '') {
                        $('#tanda_daftar').focus();
                    }
                    if (dok_no_induk_berusaha == '') {
                        $('#tdpfile').focus();
                    }
                    return false;
                }
                // console.log('kesini 3');
                $(form).submit();
            }
        }
</script>

<script>
    $(function() {
        $(".alert").slideDown(1000).delay(10000).slideUp(1000);
        $('#tablecontact').DataTable({
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                },
                "zeroRecords": " "
            }
        })
    })

    $("#year_establish").keypress(function(e){
        var keyCode = e.which;
        if ( !( (keyCode >= 48 && keyCode <= 57))) { e.preventDefault(); }
        charLimit(this, 3);
    })

    function charLimit(input, maxChar) {
        var len = $(input).val().length;
        if (len > maxChar) {
            $(input).val($(input).val().substring(0, maxChar));
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
            $('.select2').select2();
            $('#STAT').on('change', function() {
                var val = $('#STAT').val().split("|");
                var nama = val[0];
                var instansi = val[1];
                // alert(gambar);
                $('#institusi').val(instansi);

            });
            $('#tanggal_registrasi').val(new Date().toDateInputValue());
            $("#email").keyup(function() {
                var uname = $("#email").val();
                // alert(uname);
                $.get('{{ url('getem') }}/' + uname,
                    function(data) {
                        console.log(data);
                        if (data == 0) {
                            $('#cekl').html("<font color='green'>Tersedia</font>");
                        } else {
                            $('#cekl').html("<font color='red'>Telah digunakan</font>");
                        }
                        // $('#alot').html(data);
                    });
            });
            $('#provinsiku').on('change', function() {
                var json = null;
                var id = this.value;

                $.get('{{ URL::to('getkab') }}/' + id,
                    function(data) {
                        $('#kabupatenku').val(null).trigger('change');
                        json = JSON.parse(data);
                        var test = null;
                        // console.log("##PANJANGNYA =" + json.length)
                        test =
                            "<option class='' disabled='' selected='' value='0'>-PILIH KABUPATEN-</option>";
                        for (i = 0; i < json.length; i++) {

                            test += "<option  class='' value='" + json[i].id +
                                "'>" + json[i].nama_kab + "</option>";

                        }
                        $('#kabupatenmu').show();
                        $('#kabupatenku').html(test);
                        $('#kabupatenku').trigger('change');
                    });

            });
            $("#confirm_password").keyup(function() {
                var password = $("#password").val();
                var cpassword = $("#confirm_password").val();
                if (cpassword == password) {
                    $('#cek2').html("<font color='green'>Sama</font>");
                } else {
                    $('#cek2').html("<font color='red'>Tidak Sama</font>");
                }
                // $('#alot').html(data);

            });
        });
        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0, 10);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#tgl_mulai_berlaku").change(function() {
            $("#label_tkeanggotaan").css("display", "none");
            $("#tipe_keanggotaan").css("display", "block");

            var val = $("#tipe_keanggotaan").val().split("|");
            var periode = val[1];
            // alert(periode);

            var date = new Date(this.value);
            var current = new Date();

            var month = (date.getMonth() < 10) ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
            var hari = (date.getDate() < 10) ? "0" + date.getDate() : date.getDate();
            var result = hari + "-" + month + "-" + (Number(date.getFullYear()) + Number(periode));

            $("#tanggal_kadaluarsa").val(result);
        });

        $("#tipe_keanggotaan").change(function() {
            $("#label_tkadaluarsa").css("display", "none");
            $("#tanggal_kadaluarsa").css("display", "block");

            var val = this.value.split("|");
            var periode = val[1];

            var date = new Date($('#tgl_mulai_berlaku').val());
            var current = new Date();

            var month = (date.getMonth() < 10) ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
            var hari = (date.getDate() < 10) ? "0" + date.getDate() : date.getDate();
            var result = hari + "-" + month + "-" + (Number(date.getFullYear()) + Number(periode));

            $("#tanggal_kadaluarsa").val(result);

        });

        $("#imgInp").change(function() {
            readURL(this);
        });
</script>

<script>
    function ceknpwp() {

            var inputnpwp = $("#npwp").val();
            var jumlahkarakter = inputnpwp.length;
            // alert('1234567');
            if (jumlahkarakter == 15) {
                $.get('{{ url(' / ceknpwp ') }}', {
                    id: inputnpwp
                }, function(data) {
                    json = JSON.parse(data);
                    console.log('metro');
                    console.log(json.nama);
                    console.log(json.status);
                    if (json.status == "VALID") {
                        $('.vld').html("<font color='green'>Valid</font>");
                        $('.labelverif').html("Verified");
                        alert("NPWP terdaftar dengan nama " + json.nama);
                        $('#staim').val(1);
                    } else {
                        alert("NPWP Tidak Benar, Silahkan Hubungin Kantor Pajak Terdekat");
                        $('.vld').html("<font color='red'>Not Valid</font>");
                        $("#npwp").val('');
                        $('#staim').val(0);
                        $('.labelverif').html("-");
                    }
                    //console.log(data.status);
                    // alert(jumlahkarakter);

                })
            } else {
                $('.vld').html("<font color='red'>Not Valid</font>");
            }


        }
</script>
<script>
    $(document).ready(function() {
            $('.select2').select2();
            // $("#img_1").click(function() {
            //     $("input[id='image_1']").click();
            // });
            document.getElementById("image_1").addEventListener('change', handleFileSelect, false);
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

        function handleFileSelect(evt) {
            var files = evt.target.files; // FileList object
            var idfile = evt.target.id; // FileList object

            // FileReader support
            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function() {
                    document.getElementById(idfile + "_ambil").src = fr.result;
                    document.getElementById(idfile + "_ambil").style.width = "100%";
                    document.getElementById(idfile + "_ambil").style.height = "100%";
                }
                fr.readAsDataURL(files[0]);
            }
        }

        function check() {
            var npwp = $('#npwp').val();
            var npwpfile = $('#npwpfile').val();
            if (!isEmptyM(npwp) && !isEmptyM(npwpfile)) {
                //kalo gak ada inputan yang kosong, masuk sini
                $("#formdokumen").submit();
            } else if (('{{ $ryu->npwp }}' != '') && ('{{ $ryu->uploadnpwp }}' != '')) {
                // if(!isEmptyM(npwp)  || !isEmptyM(npwpfile)  || !isEmptyM(pernyataan) || !isEmptyM(bill) || !isEmptyM(packing) || !isEmptyM(kontrak)) {

                $("#formdokumen").submit();
                // }
            } else {
                //ada yang kosong
                alert('pastikan mengisi npwp dan upload npwp')
            }
        }

        function isEmptyM(obj) {
            for (var key in obj) {
                if (obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        }
</script>
<script>
    $('.upload1').on('change', function(evt) {
            var size = this.files[0].size;
            if (size > 5000000) {
                // if(size > 20000){
                $(this).val("");
                alert('image size must less than 5MB');
            } else {

            }
        })
</script>
@include('footer')
@endsection