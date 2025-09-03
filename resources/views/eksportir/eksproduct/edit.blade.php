@extends('header2')
@section('content')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
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

    .img_upl {
        border: 1px dashed #6fccdd;
        background: transparent;
    }

    .list-group-item.active,
    .list-group-item.active:hover,
    .list-group-item.active:focus {
        background: #1a7688 !important;
        color: white;
    }

    .toggle.btn.btn-info {
        width: 15% !important;
    }

    .toggle.btn.btn-default.off {
        width: 15% !important;
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        /* height: 45px !important; */
    }

    .custom-select,
    .custom-file-control,
    .custom-file-control:before,
    select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
        /* height: 45px !important; */
    }

    .form-group {
        margin-bottom: -0.8rem;
    }

    .row {
        margin-bottom: -0.8rem;
    }

    .required:after {
        content: " *";
        color: red;
    }
</style>
<?php //dd($data);
    ?>
{{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <p><strong>Opps Something went wrong</strong></p>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                                    href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                                    aria-selected="true"><i class=" mr-2"></i>Indonesian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                                    href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                                    aria-selected="false"><i class=" mr-2"></i>English</a>
                            </li>
                            <!-- <li class="nav-item">
                                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>Messages</a>
                                                    </li> -->
                        </ul>
                    </div>
                    <div class="card shadow">
                        <div class="card-body">
                            <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                                action="{{ url($url) }}" id="formnya">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                                        aria-labelledby="tabs-icons-text-1-tab">
                                        {{ csrf_field() }}
                                        <section>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Status Produk</b></label>
                                                <div class="col-md-9" style="margin-left: 0.5rem !important;">
                                                    @if($data->status == '0' || $data->status == '1')
                                                    <lable class="text-primary">Belum diverifikasi oleh Administrator
                                                    </lable>
                                                    @elseif($data->status == '2')
                                                    <label class="text-success">Sudah diverifikasi oleh
                                                        Administrator</label>
                                                    @elseif($data->status == '3')
                                                    <label class="text-danger">Ditolak oleh Administrator</label>
                                                    @endif
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label><b>Media</b></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Image Format (.png, .jpg, .jpeg, .gif)</label>
                                                    <label style="color: red">*maksimum file size 5MB</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div id="ambil_ttd_1"
                                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                        <button type="button" id="img_1_in"
                                                            style="width: 100%; height: 120px;" class="img_upl">
                                                            @if ($data->image_1 == null)
                                                            <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                id="image_1_in_ambil"
                                                                style="height: 40px; width: 40px;" />
                                                            @else
                                                            <img src="{{ url('/') }}/uploads/Eksportir_Product/Image/{{ $data->id }}/{{ $data->image_1 }}"
                                                                id="image_1_in_ambil"
                                                                style="height: 100%; width: 100%;" />
                                                            @endif
                                                        </button>
                                                        {{-- accept="image/png" --}}
                                                        <input type="file" id="image_1_in" name="image_1_in"
                                                            style="display: none;" class="upload1" accept=".jpg, .jpeg, .png, .gif" />
                                                        <br>
                                                        <center>+ Photo 1</center>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div id="ambil_ttd_2"
                                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                        <button type="button" id="img_2_in"
                                                            style="width: 100%; height: 120px;" class="img_upl">
                                                            @if ($data->image_2 == null)
                                                            <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                id="image_2_in_ambil"
                                                                style="height: 40px; width: 40px;" />
                                                            @else
                                                            <img src="{{ url('/') }}/uploads/Eksportir_Product/Image/{{ $data->id }}/{{ $data->image_2 }}"
                                                                id="image_2_in_ambil"
                                                                style="height: 100%; width: 100%;" />
                                                            @endif
                                                        </button>
                                                        <input type="file" id="image_2_in" name="image_2_in"
                                                            style="display: none;" class="upload1" accept=".jpg, .jpeg, .png, .gif" />
                                                        <br>
                                                        <center>+ Photo 2</center>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div id="ambil_ttd_3"
                                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                        <button type="button" id="img_3_in"
                                                            style="width: 100%; height: 120px;" class="img_upl">
                                                            @if ($data->image_3 == null)
                                                            <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                id="image_3_in_ambil"
                                                                style="height: 40px; width: 40px;" />
                                                            @else
                                                            <img src="{{ url('/') }}/uploads/Eksportir_Product/Image/{{ $data->id }}/{{ $data->image_3 }}"
                                                                id="image_3_in_ambil"
                                                                style="height: 100%; width: 100%;" />
                                                            @endif
                                                        </button>
                                                        <input type="file" id="image_3_in" name="image_3_in"
                                                            style="display: none;" class="upload1" accept=".jpg, .jpeg, .png, .gif" />
                                                        <br>
                                                        <center>+ Photo 3</center>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div id="ambil_ttd_4"
                                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                        <button type="button" id="img_4_in"
                                                            style="width: 100%; height: 120px;" class="img_upl">
                                                            @if ($data->image_4 == null)
                                                            <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                id="image_4_in_ambil"
                                                                style="height: 40px; width: 40px;" />
                                                            @else
                                                            <img src="{{ url('/') }}/uploads/Eksportir_Product/Image/{{ $data->id }}/{{ $data->image_4 }}"
                                                                id="image_4_in_ambil"
                                                                style="height: 100%; width: 100%;" />
                                                            @endif
                                                        </button>
                                                        <input type="file" id="image_4_in" name="image_4_in"
                                                            style="display: none;" class="upload1" accept=".jpg, .jpeg, .png, .gif" />
                                                        <br>
                                                        <center>+ Photo 4</center>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <hr class="mt-3 mb-3">
                                        <section>
                                            <h2>Informasi Produk</h2>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Nama Produk</b></label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="prodname_in"
                                                        id="prodname_in" autocomplete="off"
                                                        value="{{ old('prodname_in', $data->prodname_in) }}">
                                                </div>
                                            </div>
                                            <br />

                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Kategori Produk</b></label>

                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <a data-toggle="modal" data-target="#catModal" id="labelcat" class="labelcat"
                                                                href="#">
                                                                @if ($data->id_csc_product != null)
                                                                <span id="select_1">{{
                                                                    getNameCategoryProduct($data->id_csc_product,
                                                                    'en') }}</span>
                                                                <input type="hidden" name="id_csc_product_in"
                                                                    id="id_csc_product"
                                                                    value="{{ $data->id_csc_product }}">
                                                                @else
                                                                <span id="select_1"></span>
                                                                <input type="hidden" name="id_csc_product_in"
                                                                    id="id_csc_product">
                                                                @endif
                                                                @if ($data->id_csc_product_level1 != null)
                                                                <span id="select_2"> »
                                                                    {{
                                                                    getNameCategoryProduct($data->id_csc_product_level1,
                                                                    'en') }}</span>
                                                                <input type="hidden" name="id_csc_product_level1_in"
                                                                    id="id_csc_product_level1"
                                                                    value="{{ $data->id_csc_product_level1 }}">
                                                                @else
                                                                <span id="select_2"></span>
                                                                <input type="hidden" name="id_csc_product_level1_in"
                                                                    id="id_csc_product_level1">
                                                                @endif
                                                                @if ($data->id_csc_product_level2 != null)
                                                                <span id="select_3"> »
                                                                    {{
                                                                    getNameCategoryProduct($data->id_csc_product_level2,
                                                                    'en') }}</span>
                                                                <input type="hidden" name="id_csc_product_level2_in"
                                                                    id="id_csc_product_level2"
                                                                    value="{{ $data->id_csc_product_level2 }}">
                                                                @else
                                                                <span id="select_3"></span>
                                                                <input type="hidden" name="id_csc_product_level2_in"
                                                                    id="id_csc_product_level2">
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <!-- <a data-toggle="modal" data-target="#catModal" id="labelcat" href="#">
                                                                                    Klik Untuk Memilih Kategori Produk
                                                                                </a> -->
                                                            <input type="hidden" name="val_category" id="val_category" value="">
                                                            <span id="select_1"></span>
                                                            <input type="hidden" name="id_csc_product_in" id="id_csc_product" value="{{ $data->id_csc_product }}">
                                                            <span id="select_2"></span>
                                                            <input type="hidden" name="id_csc_product_level1_in" id="id_csc_product_level1" value="{{ $data->id_csc_product_level1 }}">
                                                            <span id="select_3"></span>
                                                            <input type="hidden" name="id_csc_product_level2_in" id="id_csc_product_level2" value="{{ $data->id_csc_product_level2 }}">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-4">

                                                </div>
                                            </div>

                                            <br />
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Deskripsi Produk</b></label>
                                                <div class="col-md-8">
                                                    <textarea class="wysihtml5 form-control" id="product_description_in"
                                                        name="product_description_in">{{ old('product_description_in', $data->product_description_in) }}</textarea>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Kode</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="code_in" id="code"
                                                        autocomplete="off" value="{{ old('code_in', $data->code_in) }}">
                                                </div>
                                            </div>
                                            <br />
                                        </section>
                                        <hr class="mt-3 mb-3">
                                        <section>

                                            <h2>Harga Produk</h2>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Minimal Order</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control satuan"
                                                        name="minimum_order_in" id="minimum_order_in" autocomplete="off"
                                                        value="{{ old('minimum_order_in', $data->minimum_order) }}"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control js-select"
                                                        style="font-size:12px;height: 34px !important;" name="satuan_in"
                                                        id="satuan_in">
                                                        <option value="" disabled="" selected="">- Pilih Satuan Produk -
                                                        </option>
                                                        <option value="Dozen">Dozen</option>
                                                        <option value="Grams">Grams</option>
                                                        <option value="Kilograms">Kilograms</option>
                                                        <option value="Liters">Liters</option>
                                                        <option value="Meters">Meters</option>
                                                        <option value="Packs">Packs</option>
                                                        <option value="Pairs">Pairs</option>
                                                        <option value="Pieces">Pieces</option>
                                                        <option value="Sets">Sets</option>
                                                        <option value="Tons">Tons</option>
                                                        <option value="Unit">Unit</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Harga <span id="usd_1">
                                                            (USD)</span></b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control usd" name="price_usd_in"
                                                        id="price_usd_in" autocomplete="off"
                                                        value="{{ old('price_usd_in', $data->price_usd) }}" required>
                                                </div>
                                            </div>
                                            <br />
                                        </section>
                                        <hr class="mt-3 mb-3">
                                        <section>
                                            <h2>Spesifikasi Produk</h2>
                                            <div class="row">
                                                <label class="col-md-2"><b>Ukuran</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="size_in" id="size_in"
                                                        autocomplete="off" value="{{ old('size_in', $data->size_in) }}"
                                                        required>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <label class="col-md-2"><b>Bahan Baku</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="raw_material_in"
                                                        id="raw_material_in" autocomplete="off"
                                                        value="{{ old('raw_material_in', $data->raw_material_in) }}"
                                                        required>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <label class="col-md-2"><b>Kapasitas Produksi <span
                                                            id="bulan_1">(Bulan)</span></b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control satuan" name="capacity_in"
                                                        id="capacity_in" autocomplete="off"
                                                        value="{{ old('capacity_in', $data->capacity) }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control js-select"
                                                        style="font-size:12px;height: 34px !important;"
                                                        name="satuan_pro_in" id="satuan_pro_in">
                                                        <option value="" disabled="" selected="">- Pilih Satuan Produk -
                                                        </option>
                                                        <option value="Dozen">Dozen</option>
                                                        <option value="Grams">Grams</option>
                                                        <option value="Kilograms">Kilograms</option>
                                                        <option value="Liters">Liters</option>
                                                        <option value="Meters">Meters</option>
                                                        <option value="Packs">Packs</option>
                                                        <option value="Pairs">Pairs</option>
                                                        <option value="Pieces">Pieces</option>
                                                        <option value="Sets">Sets</option>
                                                        <option value="Tons">Tons</option>
                                                        <option value="Unit">Unit</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <label class="col-md-2"><b>HS Kode</b></label>
                                                <div class="col-md-4">
                                                    <select class="form-control hscode" name="hscode_in" id="hscode_in"
                                                        style="width: 100%;">
                                                        <option value=""></option>
                                                    </select>
                                                    <span>HS Kode Terpilih : <small id="hscode_info_in"></small></span>
                                                    <br />
                                                    <span style="color:red">*) Ignore if there is no change HS Code
                                                        (Abaikan
                                                        jika tidak ada perubahan)</span>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div style="float: left;">
                                                        {{-- <button type="button" class="btn btn-default"
                                                            onclick="nextTab('descprod', 'infoprod')">Back</button> --}}
                                                        <a class="btn btn-danger"
                                                            href="{{ url('eksportir/product') }}">Cancel</a>
                                                        <button type="button" class="btn btn-primary"
                                                            id="hal2">Next</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                                        aria-labelledby="tabs-icons-text-2-tab">
                                        <section>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Product Status</b></label>
                                                <div class="col-md-9" style="margin-left: 0.5rem !important;">
                                                    @if($data->status == '0' || $data->status == '1')
                                                    <lable class="text-primary">Not verified by Administrator</lable>
                                                    @elseif($data->status == '2')
                                                    <label class="text-success">Verified by Administrator</label>
                                                    @elseif($data->status == '3')
                                                    <label class="text-danger">Rejected by Administrator</label>
                                                    @endif
                                                </div>
                                            </div><br>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label><b>Media</b></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Image Format (.png, .jpg, .jpeg, .gif)</label>
                                                    <label style="color: red">*maksimum file size 5MB</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div id="ambil_ttd_1"
                                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                        <button type="button" id="img_1_en"
                                                            style="width: 100%; height: 120px;" class="img_upl">
                                                            @if ($data->image_1 == null)
                                                            <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                id="image_1_en_ambil"
                                                                style="height: 40px; width: 40px;" />
                                                            @else
                                                            <img src="{{ url('/') }}/uploads/Eksportir_Product/Image/{{ $data->id }}/{{ $data->image_1 }}"
                                                                id="image_1_en_ambil"
                                                                style="height: 100%; width: 100%;" />
                                                            @endif
                                                        </button>
                                                        {{-- accept="image/png" --}}
                                                        <input type="file" id="image_1_en" name="image_1_en"
                                                            style="display: none;" class="upload1" accept=".jpg, .jpeg, .png, .gif" />
                                                        <br>
                                                        <center>+ Photo 1</center>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div id="ambil_ttd_2"
                                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                        <button type="button" id="img_2_en"
                                                            style="width: 100%; height: 120px;" class="img_upl">
                                                            @if ($data->image_2 == null)
                                                            <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                id="image_2_en_ambil"
                                                                style="height: 40px; width: 40px;" />
                                                            @else
                                                            <img src="{{ url('/') }}/uploads/Eksportir_Product/Image/{{ $data->id }}/{{ $data->image_2 }}"
                                                                id="image_2_en_ambil"
                                                                style="height: 100%; width: 100%;" />
                                                            @endif
                                                        </button>
                                                        <input type="file" id="image_2_en" name="image_2_en"
                                                            style="display: none;" class="upload1" accept=".jpg, .jpeg, .png, .gif" />
                                                        <br>
                                                        <center>+ Photo 2</center>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div id="ambil_ttd_3"
                                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                        <button type="button" id="img_3_en"
                                                            style="width: 100%; height: 120px;" class="img_upl">
                                                            @if ($data->image_3 == null)
                                                            <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                id="image_3_en_ambil"
                                                                style="height: 40px; width: 40px;" />
                                                            @else
                                                            <img src="{{ url('/') }}/uploads/Eksportir_Product/Image/{{ $data->id }}/{{ $data->image_3 }}"
                                                                id="image_3_en_ambil"
                                                                style="height: 100%; width: 100%;" />
                                                            @endif
                                                        </button>
                                                        <input type="file" id="image_3_en" name="image_3_en"
                                                            style="display: none;" class="upload1" accept=".jpg, .jpeg, .png, .gif" />
                                                        <br>
                                                        <center>+ Photo 3</center>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div id="ambil_ttd_4"
                                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                        <button type="button" id="img_4_en"
                                                            style="width: 100%; height: 120px;" class="img_upl">
                                                            @if ($data->image_4 == null)
                                                            <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                id="image_4_en_ambil"
                                                                style="height: 40px; width: 40px;" />
                                                            @else
                                                            <img src="{{ url('/') }}/uploads/Eksportir_Product/Image/{{ $data->id }}/{{ $data->image_4 }}"
                                                                id="image_4_en_ambil"
                                                                style="height: 100%; width: 100%;" />
                                                            @endif
                                                        </button>
                                                        <input type="file" id="image_4_en" name="image_4_en"
                                                            style="display: none;" class="upload1" accept=".jpg, .jpeg, .png, .gif" />
                                                        <br>
                                                        <center>+ Photo 4</center>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <hr class="mt-3 mb-3">
                                        <section>
                                            <h2>Product Information</h2>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>@lang("product.pName")</b></label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="prodname_en"
                                                        id="prodname_en" autocomplete="off"
                                                        value="{{ old('prodname_en', $data->prodname_en) }}">
                                                </div>
                                            </div>
                                            <br />

                                            <div class="form-group row">
                                                <label class="col-md-2"><b>@lang("product.category")</b></label>

                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <a data-toggle="modal" data-target="#catModal" class="labelcat"
                                                                href="#">
                                                                @if ($data->id_csc_product != null)
                                                                <span id="select_1">{{
                                                                    getNameCategoryProduct($data->id_csc_product, 'en')
                                                                    }}</span>
                                                                
                                                                @else
                                                                <span id="select_1"></span>
                                                               
                                                                @endif
                                                                @if ($data->id_csc_product_level1 != null)
                                                                <span id="select_2"> »
                                                                    {{
                                                                    getNameCategoryProduct($data->id_csc_product_level1,
                                                                    'en') }}</span>
                                                               
                                                                @else
                                                                <span id="select_2"></span>
                                                                
                                                                @endif
                                                                @if ($data->id_csc_product_level2 != null)
                                                                <span id="select_3"> »
                                                                    {{
                                                                    getNameCategoryProduct($data->id_csc_product_level2,
                                                                    'en') }}</span>
                                                                
                                                                @else
                                                                <span id="select_3"></span>
                                                               
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <!-- <a data-toggle="modal" data-target="#catModal" id="labelcat" href="#">
                                                                                        Klik Untuk Memilih Kategori Produk
                                                                                    </a> -->
                                                           
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-4">

                                                </div>
                                            </div>

                                            <br />
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>@lang("product.prodesc")</b></label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" id="product_description_en"
                                                        name="product_description_en">{{ old('product_description_en', $data->product_description_en) }}</textarea>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>@lang("product.code")</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="code_en" id="code_en"
                                                        autocomplete="off" value="{{ old('code_en', $data->code_en) }}">
                                                </div>
                                            </div>
                                            <br />
                                        </section>
                                        <hr class="mt-3 mb-3">
                                        <section>
                                            <h2>Product Price</h2>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>@lang("product.minorder")</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control satuan"
                                                        name="minimum_order_en" id="minimum_order_en" autocomplete="off"
                                                        value="{{ old('minimum_order_en', $data->minimum_order) }}"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control js-select"
                                                        style="font-size:12px;height: 34px !important;" name="satuan_en"
                                                        id="satuan_en">
                                                        <option value="" disabled="" selected="">- Choose Porduct Unit -
                                                        </option>
                                                        <option value="Dozen">Dozen</option>
                                                        <option value="Grams">Grams</option>
                                                        <option value="Kilograms">Kilograms</option>
                                                        <option value="Liters">Liters</option>
                                                        <option value="Meters">Meters</option>
                                                        <option value="Packs">Packs</option>
                                                        <option value="Pairs">Pairs</option>
                                                        <option value="Pieces">Pieces</option>
                                                        <option value="Sets">Sets</option>
                                                        <option value="Tons">Tons</option>
                                                        <option value="Unit">Unit</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>@lang("product.hPUnit") <span
                                                            id="usd_2">(USD)</span></b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control usd" name="price_usd_en"
                                                        id="price_usd_en" autocomplete="off"
                                                        value="{{ old('price_usd_en', $data->price_usd) }}" required>
                                                </div>
                                            </div>
                                            <br />
                                        </section>
                                        <hr class="mt-3 mb-3">
                                        <section>
                                            <h2>Product Spesification</h2>
                                            <div class="row">
                                                <label class="col-md-2"><b>@lang("product.size")</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="size_en" id="size_en"
                                                        autocomplete="off" value="{{ old('size_en', $data->size_en) }}"
                                                        required>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <label class="col-md-2"><b>@lang("product.rawmaterial")</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="raw_material_en"
                                                        id="raw_material_en" autocomplete="off"
                                                        value="{{ old('raw_material_en', $data->raw_material_en) }}"
                                                        required>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <label class="col-md-2"><b>Production Capacity <span
                                                            id="bulan_2">(Month)</span></b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control satuan" name="capacity_en"
                                                        id="capacity_en" autocomplete="off"
                                                        value="{{ $data->capacity }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control js-select"
                                                        style="font-size:12px;height: 34px !important;"
                                                        name="satuan_pro_en" id="satuan_pro_en">
                                                        <option value="" disabled="" selected="">- Choose Product Unit -
                                                        </option>
                                                        <option value="Dozen">Dozen</option>
                                                        <option value="Grams">Grams</option>
                                                        <option value="Kilograms">Kilograms</option>
                                                        <option value="Liters">Liters</option>
                                                        <option value="Meters">Meters</option>
                                                        <option value="Packs">Packs</option>
                                                        <option value="Pairs">Pairs</option>
                                                        <option value="Pieces">Pieces</option>
                                                        <option value="Sets">Sets</option>
                                                        <option value="Tons">Tons</option>
                                                        <option value="Unit">Unit</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <label class="col-md-2"><b>HS @lang("product.code")</b></label>
                                                <div class="col-md-9">
                                                    <!-- <select readonly class="form-control" name="hscode_en" id="hscode_en" style="width: 100%;">
                                                                                <option value=""></option>
                                                                            </select> -->
                                                    <span>HS Code : <small id="hscode_info_en"></small></span>
                                                    <br />
                                                    <span style="color:red">*) Ignore if there is no change HS Code
                                                        (Abaikan
                                                        jika tidak ada perubahan)</span>
                                                </div>

                                            </div>
                                            <br>
                                            <div class="form-group row mb-2">
                                                <label class="col-md-2"><b>Show Product</b></label>
                                                <div class="col-md-9 ml--4">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                            class="custom-control-input custom-control-inline" {{
                                                            ($data->show == '1') ? 'checked' :'' }}
                                                        data-toggle="toggle" data-on="Publish" data-off="Hide"
                                                        data-onstyle="info" data-offstyle="default" id="statusnya">
                                                        <!-- <label class="custom-control-label" for="statusnya">Publish</label> -->
                                                        <input type="hidden" name="status" id="status" value="">
                                                    </div>
                                                </div>
                                            </div><br>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div style="float: left;">
                                                        {{-- <button type="button" class="btn btn-default"
                                                            onclick="nextTab('descprod', 'infoprod')">Back</button> --}}
                                                        <a class="btn btn-danger"
                                                            href="{{ url('eksportir/product') }}">Cancel</a>
                                                        <button type="button" class="btn btn-primary"
                                                            id="hal3">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <!-- <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                                        <p class="description">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
                                                    </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Select Category -->
    <div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="catModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="catModalLabel">Click Here to Select Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-4">
                            <div class="col-sm-12">
                                <label><b>@lang("login.forms.by3") (<font color="red">*</font>)</b></label>
                            </div>
                            <div class="form-group col-sm-12" style="font-size: 12px !important;">
                                <?php
                                $ms1 = DB::select('select id,nama_kategori_en from csc_product where level_1 = 0 and level_2 = 0 order by nama_kategori_en asc');
                                ?>
                                <select style="color:black;font-size: 12px !important; " size="13"
                                    class="column J-noselect" name="category[]" id="category" onchange="t1()" required
                                    form="form_br">
                                    <option value="">@lang("login.forms.by11")</option>
                                    <?php foreach ($ms1 as $val1) { ?>
                                    <option value="{{ $val1->id }}" {{ ($val1->id == $data->id_csc_product) ? 'selected'
                                        : '' }}>{{ $val1->nama_kategori_en }}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div id="t2">
                                <?php 
                                if($data->id_csc_product_level1 != ''){
                                $qr = DB::table('csc_product')
                                			->select('id','nama_kategori_en')
                                			->where('level_1', $data->id_csc_product)
                                			->where('level_2', 0)
                                			->orderBy('nama_kategori_en', 'asc')
                                			->get();
                                
                                
                                if(count($qr) == 0){
                                ?>
                                <?php }else{ ?>
                                <div class="">
                                    <div class="col-sm-12">
                                        <label><b>Sub Category 1</b></label>
                                    </div>
                                    <div class="form-group col-sm-12" style="font-size: 12px !important;">

                                        <select style="color:black;font-size: 12px!important;" size="13"
                                            class="column J-noselect" name="t2s" id="t2s" onchange="t2()"
                                            form="form_br">
                                            <option value="">-- Select Sub Category 1 --</option>
                                            <?php foreach($qr as $val1){ ?>
                                            <option style="font-size: 12px !important;" value="<?php echo $val1->id; ?>"
                                                {{ ($val1->id == $data->id_csc_product_level1) ? 'selected' : '' }}>
                                                <?php echo $val1->nama_kategori_en; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                                <?php }
                                } ?>
                                <input type="hidden" name="t2s" id="t2s" value="0" form="form_br">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div id="t3">
                                <?php 
                                if($data->id_csc_product_level2 != ''){
                                $qr = DB::select("select id,nama_kategori_en from csc_product where level_2='".$data->id_csc_product_level1."' order by nama_kategori_en asc");
                                if(count($qr) == 0){
                                ?>
                                <input type="hidden" name="t3s" id="t3s" value="0">
                                <?php }else{ ?>
                                <div class="">
                                    <div class="col-sm-12">
                                        <label><b>Sub Category 2</b></label>
                                    </div>
                                    <div class="form-group col-sm-12" style="font-size: 12px!important;">

                                        <select style="color:black;font-size: 12px!important;" size="13"
                                            class="column J-noselect" name="t3s" id="t3s" onchange="t3()"
                                            form="form_br">
                                            <option value="">-- Select Sub Category 2 --</option>
                                            <?php foreach($qr as $val1){ ?>
                                            <option style="font-size: 12px!important;" value="<?php echo $val1->id; ?>"
                                                {{ ($val1->id == $data->id_csc_product_level2) ? 'selected' : '' }}>
                                                <?php echo $val1->nama_kategori_en; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                                <?php }
                                } 
                                ?>
                                <input type="hidden" name="t3s" id="t3s" value="0" form="form_br">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mr-auto rounded" data-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!--select category end-->
    <script src="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/js/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#satuan_in').change(function() {
                let sat_in = $('#satuan_in').val();
                let val_usd_1 = '(USD)';
                if(sat_in != null){
                    val_usd_1 = '(' + sat_in + '/USD)';
                }
                $('#usd_1').html(val_usd_1)
            });
            $('#satuan_en').change(function() {
                let sat_en = $('#satuan_en').val();
                let val_usd_2 = '(USD)';
                if(sat_en != null){
                    val_usd_2 = '(' + sat_en + '/USD)';
                }
                $('#usd_2').html(val_usd_2)
            });
            $('#satuan_pro_in').change(function() {
                let sat_pro_in = $('#satuan_pro_in').val();
                let val_bulan_1 = '(Bulan)';
                if(sat_pro_in != null){
                    val_bulan_1 = '(' + sat_pro_in + '/Bulan)';
                }
                $('#bulan_1').html(val_bulan_1)
            });
            $('#satuan_pro_en').change(function() {
                let sat_pro_en = $('#satuan_pro_en').val();
                let val_bulan_2 = '(Month)';
                if(sat_pro_en != null){
                val_bulan_2 = '(' + sat_pro_en + '/Month)';
                }
                $('#bulan_2').html(val_bulan_2)
            });

            // CKEDITOR.replace('product_description_en');
            // CKEDITOR.replace('product_description_in');

            var product_description_in = document.getElementById("product_description_in");
            CKEDITOR.replace(product_description_in, {
                language: 'en-gb',
                height: 100,
                toolbar: [
                    ['Source', 'Bold', 'Italic']
                ]
            });

            var product_description_en = document.getElementById("product_description_en");
            CKEDITOR.replace(product_description_en, {
                language: 'en-gb',
                height: 100,
                toolbar: [
                    ['Source', 'Bold', 'Italic']
                ]
            });


            // CKEDITOR.replace('product_description_chn');

            // $("#img_utama").click(function() {
            //     $("input[id='image_utama']").click();
            // });

            $("#img_1_in").click(function() {
                $("input[id='image_1_in']").click();
            });

            $("#img_1_en").click(function() {
                $("input[id='image_1_en']").click();
            });

            $("#img_2_in").click(function() {
                $("input[id='image_2_in']").click();
            });

            $("#img_2_en").click(function() {
                $("input[id='image_2_en']").click();
            });

            $("#img_3_in").click(function() {
                $("input[id='image_3_in']").click();
            });

            $("#img_3_en").click(function() {
                $("input[id='image_3_en']").click();
            });

            $("#img_4_in").click(function() {
                $("input[id='image_4_in']").click();
            });

            $("#img_4_en").click(function() {
                $("input[id='image_4_en']").click();
            });

            // document.getElementById("image_utama").addEventListener('change',handleFileSelect,false);
            document.getElementById("image_1_in").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_1_en").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_2_in").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_2_en").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_3_in").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_3_en").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_4_in").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_4_en").addEventListener('change', handleFileSelect, false);

            $("#hal1").on("click", function() {
                // if ($('#prodname_en').val() == "") {
                //     alert("Product name is empty, please fill in!");
                //     return false;
                // }else if ($('#id_csc_product').val() == "") {
                //     alert("Please select a product category!");
                //     return false;
                // }else {
                nextTab('formprod', 'infoprod');
                return true;
                // }
            });

            $("#hal2").on("click", function() {
                nextTab('1-tab', '2-tab');
                return true;
            });

            $("#hal3").on("click", function() {
                if ($('#prodname_en').val() == "") {
                    alert("Product name is empty, please fill in!");
                    return false;
                } else if ($('#id_csc_product').val() == "") {
                    alert("Please select a product category!");
                    return false;
                } else {
                    $("#formnya").submit();
                }
            });

            $("#code").focus(function() {}).blur(function() {
                $('#codenya').text(this.value);
            });

            $("#prodname_en").focus(function() {}).blur(function() {
                $('#prodname_ea').text(this.value);
            });

            $("#prodname_in").focus(function() {}).blur(function() {
                $('#prodname_ia').text(this.value);
            });

            $("#prodname_chn").focus(function() {}).blur(function() {
                $('#prodname_ca').text(this.value);
            });

            $('#statusnya').on('change', function() {
                var isChecked = $(this).is(':checked');
                var selectedData;

                if (isChecked) {
                    $('#status').val(1);
                } else {
                    $('#status').val(0);
                }

            });

            $('.satuan').inputmask({
                alias: "decimal",
                digits: 0,
                repeat: 36,
                digitsOptional: false,
                decimalProtect: true,
                groupSeparator: ".",
                placeholder: '0',
                rightAlign: false,
                radixPoint: ",",
                radixFocus: true,
                autoGroup: true,
                autoUnmask: false,
                onBeforeMask: function(value, opts) {
                    return value;
                },
                removeMaskOnSubmit: true
            });



            $('.persen').inputmask({
                alias: "decimal",
                digits: 2,
                repeat: 3,
                digitsOptional: false,
                decimalProtect: true,
                groupSeparator: ".",
                placeholder: '0',
                rightAlign: false,
                radixPoint: ",",
                radixFocus: true,
                autoGroup: true,
                autoUnmask: false,
                onBeforeMask: function(value, opts) {
                    return value;
                },
                removeMaskOnSubmit: true
            });

            $('.usd').inputmask({
                alias: "decimal",
                digits: 2,
                repeat: 12,
                digitsOptional: false,
                decimalProtect: true,
                groupSeparator: ",",
                placeholder: '0',
                rightAlign: false,
                radixPoint: ".",
                radixFocus: true,
                autoGroup: true,
                autoUnmask: false,
                onBeforeMask: function(value, opts) {
                    return value;
                },
                removeMaskOnSubmit: true
            });

            $('.decimals').inputmask({
                alias: "decimal",
                digits: 2,
                repeat: 12,
                digitsOptional: false,
                decimalProtect: true,
                groupSeparator: ".",
                placeholder: '0',
                rightAlign: false,
                radixPoint: ",",
                radixFocus: true,
                autoGroup: true,
                autoUnmask: false,
                onBeforeMask: function(value, opts) {
                    return value;
                },
                removeMaskOnSubmit: true
            });



            var unit = "{{ $data->unit }}";
            var satuan_pro = "{{ $data->satuan_pro }}";
            var hscode_in = "{{ $data->id_mst_hscodes }}";
            $('.js-select').select2();
            $('#satuan_in').val(unit).trigger('change');
            $('#satuan_en').val(unit).trigger('change');
            $('#hscode_in').val(hscode_in).trigger('change');

            $('#satuan_pro_in').val(satuan_pro).trigger('change');
            $('#satuan_pro_en').val(satuan_pro).trigger('change');
            // if (unit != '') {
            //     $('.js-select').select2();
            //     $('.js-select').val("{{ $data->unit }}").trigger('change');
            //     $(".js-select").prop("disabled", true);
            //     $('#satuan_in').prop("disabled", false);
            //     $("#satuan_in").select2("readonly", false);

            //     $('#satuan_en').prop("disabled", false);
            //     $("#satuan_en").select2("readonly", false);

            //     $('#satuan_pro_in').prop("disabled", false);
            //     $("#satuan_pro_in").select2("readonly", false);

            //     $('#satuan_pro_en').prop("disabled", false);
            //     $("#satuan_pro_en").select2("readonly", false);
            // } else {
            //     $('.js-select').select2();
            //     $("#satuan_in").select2("readonly", true);
            //     $("#satuan_en").select2("readonly", true);
            //     $("#satuan_pro_in").select2("readonly", true);
            //     $("#satuan_pro_en").select2("readonly", true);
            //     $("#hscode_in").select2("readonly", true);
            // }
            @isset($data)
                //untuk disable semua inputan select dll.
                var hscode = "{{ $data->id_mst_hscodes }}";
                if (hscode != "") {
                    $.ajax({
                        type: 'GET',
                            url: "{{ route('eksproduct.getHsCode') }}",
                            data: {
                            code: hscode
                        }
                    }).then(function(data) {
                        var option = new Option(data[0].fullhs + " - " + data[0].desc_eng, data[0].id, true, true);
                
                        $('#hscode_en').select2({
                            allowClear: true,
                            placeholder: 'Select HS Code',
                            ajax: {
                                url: "{{ route('eksproduct.getHsCode') }}",
                                dataType: 'json',
                                delay: 250,
                                processResults: function(data) {
                                    return {
                                        results: $.map(data, function(item) {
                                            return {
                                                text: item.fullhs + " - " + item.desc_eng,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                                cache: true
                            }
                        });
                
                        $('#hscode_in').select2({
                            allowClear: true,
                            placeholder: 'Select HS Code',
                            ajax: {
                                url: "{{ route('eksproduct.getHsCode') }}",
                                dataType: 'json',
                                delay: 250,
                                processResults: function(data) {
                                    return {
                                        results: $.map(data, function(item) {
                                        return {
                                            text: item.fullhs + " - " + item.desc_eng,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            cache: true
                            }
                        });
                        console.log(option);
                        $('#hscode_info_in').html(data[0].fullhs + " - " + data[0].desc_eng).trigger('change');
                        $('#hscode_info_en').html(data[0].fullhs + " - " + data[0].desc_eng).trigger('change');
                    });
                } else {
                    $('#hscode_in').select2({
                        allowClear: true,
                        placeholder: 'Select HS Code',
                        ajax: {
                            url: "{{ route('eksproduct.getHsCode') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.fullhs + " - " + item.desc_eng,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                    $('#hscode_en').select2({
                        allowClear: true,
                        placeholder: 'Select HS Code',
                        ajax: {
                            url: "{{ route('eksproduct.getHsCode') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.fullhs + " - " + item.desc_eng,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                }
            @endisset
        })

        function nextTab(now, next) {
            // $('#set_' + now).removeClass('active');
            // $('#set_' + next).addClass('active');
            // $('#tabs-icons-text-' + now).removeClass('active');
            // $('#tabs-icons-text-' + next).addClass('active');

            // $('.tab-pane.active').removeClass('active');
            // $('#tabs-icons-text-2').addClass('active');

            $("#tabs-icons-text-2-tab").click();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function getSub(sub, idp, ids, name, e) {
            e.preventDefault();
            if (sub == 3) {
                $('#select_3').text('> ' + name);
                $('#id_csc_product_level2').val(ids);
                $('.listbag3').removeClass('active');
                $('#kat3_' + ids).addClass('active');
            } else {
                if (sub == 1) {
                    $('#select_1').text(name);
                    $('#cadprod_en').text(name);
                    $('#id_csc_product').val(idp);
                    $('#select_2').text('');
                    $('#id_csc_product_level1').val('');
                    $('#select_3').text('');
                    $('#id_csc_product_level2').val('');
                    $('#prod2').html('');
                    $('#prod3').html('');
                    $('.listbag1').removeClass('active');
                    $('#kat1_' + idp).addClass('active');
                    $('#tmpsearch2').html('');
                    $('#tmpsearch3').html('');
                } else {
                    $('#select_2').text('> ' + name);
                    $('#id_csc_product_level1').val(ids);
                    $('#select_3').text('');
                    $('#id_csc_product_level2').val('');
                    $('#prod3').html('');
                    $('.listbag2').removeClass('active');
                    $('#kat2_' + ids).addClass('active');
                    // $('#tmpsearch3').html('');
                }
                $.ajax({
                    url: "{{ route('eksproduct.getSub') }}",
                    type: 'get',
                    data: {
                        level: sub,
                        idparent: idp,
                        idsub: ids
                    },
                    success: function(response) {
                        // console.log(response);
                        if (sub == 1) {
                            $('#prod2').html(response);
                            $('#tmpsearch2').html(
                                "<input type=\"text\" id=\"search2\" name=\"search2\" class=\"form-control\" onInput=\"searchsub(2)\">"
                            );
                        } else {
                            $('#prod3').html(response);
                            $('#tmpsearch3').html(
                                "<input type=\"text\" id=\"search3\" name=\"search3\" class=\"form-control\" onInput=\"searchsub(3)\">"
                            );
                        }
                    }
                });
            }
        }

        function searchsub(suba) {
            if (suba == 1) {
                var tes = document.getElementById("search1");
                var s = tes.value;
                var value = "kosong";
                var value2 = "kosong";
                $('#tmpsearch2').html('');
                $('#tmpsearch3').html('');
                $('#prod2').html('');
                $('#prod3').html('');
            } else if (suba == 2) {
                var items = document.getElementsByClassName("list-group-item listbag1 active");
                var value = $(items).attr('data-value');
                var tes = document.getElementById("search2");
                var s = tes.value;
                var value2 = "kosong";
                $('#tmpsearch3').html('');
                $('#prod3').html('');
            } else {
                var items = document.getElementsByClassName("list-group-item listbag1 active");
                var value = $(items).attr('data-value');
                var items2 = document.getElementsByClassName("list-group-item listbag2 active");
                var value2 = $(items2).attr('data-value');
                var tes = document.getElementById("search3");
                var s = tes.value;
            }

            $.ajax({
                url: "{{ route('eksproduct.searchsub') }}",
                type: 'get',
                data: {
                    level: suba,
                    text: s,
                    parent: value,
                    parent2: value2
                },
                success: function(response) {
                    // console.log(response);
                    if (suba == 1) {
                        $('#prod1').html(response);
                    } else if (suba == 2) {
                        $('#prod2').html(response);
                    } else {
                        $('#prod3').html(response);
                    }
                }
            });

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

        $('.upload1').on('change', function(evt) {
            var size = this.files[0].size;
            if (size > 5000000) {
                // if(size > 20000){
                $(this).val("");
                alert('image size must less than 5MB');
            } else {

            }
        })

        function getStatus(data) {
            console.log(data);
        }
    </script>
    <script>
        function catLabel() {
            var text = 'Select Category';
            var category = $('#category option:selected').text();
            var categoryval = $('#category option:selected').val();
            if (category != '') {
                text = category;
                $('#id_csc_product').val(categoryval);
                var cat1 = $('#t2s option:selected').text();
                var cat1val = $('#t2s option:selected').val();
                if (cat1 != '') {
                    text += ' » ' + cat1;
                    $('#id_csc_product_level1').val(cat1val);
                } else {
                    $('#id_csc_product_level1').val('');
                }
                var cat2 = $('#t3s option:selected').text();
                var cat2val = $('#t3s option:selected').val();
                if (cat2 != '') {
                    text += ' » ' + cat2;
                    $('#id_csc_product_level2').val(cat2val);
                } else {
                    $('#id_csc_product_level2').val('');
                }
            }

            $('.labelcat').html(text);
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
                $("#t3").html(
                    '<input type="hidden" name="t3s" id="t3s" value="0" size="13" class="column J-noselect">');
                // $('.select2').select2();
            })
            catLabel();
        }

        function t2() {
            $('#t3').html('');
            var t2 = $('#t2s').val();
            var token = $('meta[name="csrf-token"]').attr('content');
            $.get('{{ URL::to('ambilt3/') }}/' + t2, {
                _token: token
            }, function(data) {
                $("#t3").html(data);
                // $('.select2').select2();
            })
            catLabel()
        }

        function t3() {
            catLabel();
        }

        $('.labelcat').on('click', function() {
            $('input[name=category_rec]:checked').prop('checked', false);
        });

        let time = 0;
        
        $('#prodname_in').on('input', function() {
            clearTimeout(time);
            
            
            var res = '';
            time = setTimeout(function() {
            var name = $("input[name=prodname_in]").val();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                
                if (name.length > 2) {
                    $('#rec_kat').show();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('product-category.recommendation') }}",
                        data: {
                        name: name
                    },
                    success: function(data) {
                        $('#rec_kat_isi').html('');
                    
                        $.each(data, function(key, val) {
                        var id_a = (val.id_level_1 != null) ? val.id_level_1 + "," : "";
                        var id_b = (val.id_level_2 != null) ? val.id_level_2 + "," : "";
                        var id_c = (val.id != null) ? val.id + "," : "";
                        var id = id_a + id_b + id_c;
                        
                        var a = (val.level_1 != null) ? val.level_1 + " » " : "";
                        var b = (val.level_2 != null) ? val.level_2 + " » " : "";
                        var c = (val.nama_kategori_en != null) ? val .nama_kategori_en : "";
                        var kat = a + b + c;
                        
                        res += '<input type="radio" class="category_radio" id="cat_' + id + '" name="category_rec" value="' + id + '">' +
                        '<label class="form-check-label" for="cat_' + id + '">&nbsp;' + kat + '</label><br>';
                        });
                            $('#rec_kat_isi').html(res);
                    }
                    });
                } else {
                    $('#rec_kat').hide();
                }
                
            }, 2000);
        });
    </script>
    @include('footer')
    @endsection