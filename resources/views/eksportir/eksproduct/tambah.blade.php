@extends('header2')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>InaExport | Tambah User</title>
    <div class="padding">
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

            .required:after {
                content: " *";
                color: red;
            }
        </style>
        {{-- <div class="container-fluid mt--6"> --}}
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
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                                        href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                                        aria-selected="true"><i class="check-bold mr-2"></i>Indonesian</a>
                                </li>
                                <!-- <li class="nav-item">
                                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="check-bold mr-2"></i>English</a>
                                                </li> -->
                                <!-- <li class="nav-item">
                                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>Chinese</a>
                                                </li> -->
                            </ul>
                        </div>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                                        aria-labelledby="tabs-icons-text-1-tab">

                                        <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                                            action="{{ url($url) }}" id="formnya">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Form Produk</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label><b>Upload Media</b></label>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Image (.png, .jpg, .jpeg, .gif)</label>
                                                            <label style="color: red">*maksimum file size 5MB</label>
                                                        </div>

                                                        <div class="col-md-2 mt--4">
                                                            <div id="ambil_ttd_1"
                                                                style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                                <button type="button" id="img_1"
                                                                    style="width: 100%; height: 120px;" class="img_upl">
                                                                    <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                        id="image_1_ambil"
                                                                        style="height: 40px; width: 40px;" />
                                                                </button>
                                                                <input type="file" id="image_1" name="image_1"
                                                                    class="upload1" style="display: none;"
                                                                    accept=".jpg, .jpeg, .png, .gif" />
                                                                <br>
                                                                <center>+ Photo 1</center>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mt--4">
                                                            <div id="ambil_ttd_2"
                                                                style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                                <button type="button" id="img_2"
                                                                    style="width: 100%; height: 120px;" class="img_upl">
                                                                    <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                        id="image_2_ambil"
                                                                        style="height: 40px; width: 40px;" />
                                                                </button>
                                                                <input type="file" id="image_2" name="image_2"
                                                                    class="upload1" style="display: none;"
                                                                    accept=".jpg, .jpeg, .png, .gif" />
                                                                <br>
                                                                <center>+ Photo 2</center>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mt--4">
                                                            <div id="ambil_ttd_3"
                                                                style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                                <button type="button" id="img_3"
                                                                    style="width: 100%; height: 120px;" class="img_upl">
                                                                    <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                        id="image_3_ambil"
                                                                        style="height: 40px; width: 40px;" />
                                                                </button>
                                                                <input type="file" id="image_3" name="image_3"
                                                                    class="upload1" style="display: none;"
                                                                    accept=".jpg, .jpeg, .png, .gif" />
                                                                <br>
                                                                <center>+ Photo 3</center>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mt--4">
                                                            <div id="ambil_ttd_4"
                                                                style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                                <button type="button" id="img_4"
                                                                    style="width: 100%; height: 120px;" class="img_upl">
                                                                    <img src="{{ url('/') }}/image/plus/plusin.png"
                                                                        id="image_4_ambil"
                                                                        style="height: 40px; width: 40px;" />
                                                                </button>
                                                                <input type="file" id="image_4" name="image_4"
                                                                    class="upload1" style="display: none;"
                                                                    accept=".jpg, .jpeg, .png, .gif" />
                                                                <br>
                                                                <center>+ Photo 4</center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-2">
                                            <div class="">
                                                <h2>Informasi Produk</h2>
                                                <div class="form-group row">
                                                    <label class="col-md-2 required"><b>Nama Product </b></label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="prodname_in"
                                                            id="prodname_in" autocomplete="off" required>
                                                    </div>
                                                </div>
                                                <br />
                                                <div class="form-group row" style="display: none" id="rec_kat">
                                                    <div class="col-md-2"><label><b>Rekomendasi Kategori</b></label>
                                                    </div><br>
                                                    <div class="col-md-4" id="rec_kat_isi">

                                                    </div>
                                                </div>
                                                <br />
                                                <div class="form-group row">
                                                    <br />
                                                    <div class="col-md-2"><label class="required"><b>Kategori
                                                                Produk</b></label></div>
                                                    <br>
                                                    <div class="col-md-4">
                                                        <a data-toggle="modal" data-target="#catModal" id="labelcat"
                                                            href="#">
                                                            Klik Untuk Memilih Kategori Produk
                                                        </a>
                                                        <input type="hidden" name="val_category" id="val_category"
                                                            value="">
                                                        <span id="select_1"></span>
                                                        <input type="hidden" name="id_csc_product" id="id_csc_product">
                                                        <span id="select_2"></span>
                                                        <input type="hidden" name="id_csc_product_level1"
                                                            id="id_csc_product_level1">
                                                        <span id="select_3"></span>
                                                        <input type="hidden" name="id_csc_product_level2"
                                                            id="id_csc_product_level2">
                                                    </div>
                                                </div>
                                                <br />
                                            </div>
                                            <div class="row">
                                                <label class="col-md-2"><b>Deskripsi Produk</b></label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" id="product_description_in" name="product_description_in">Deskripsi produk juga mencantumkan dimensi</textarea>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row">
                                                <label class="col-md-2"><b>SKU</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="code"
                                                        id="code" autocomplete="off">
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-2">
                                            <h2>Harga</h2>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Minimal Order</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control satuan"
                                                        name="minimum_order" id="minimum_order" autocomplete="off">
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control"
                                                        style="font-size:12px;height: 34px !important;" name="satuan"
                                                        id="satuan">
                                                        <option value="" disabled="" selected="">- Select -
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
                                            </div><br>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Harga <span
                                                            id="usd">(USD)</span></b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control usd" name="price_usd"
                                                        id="price_usd" autocomplete="off">
                                                </div>
                                            </div>
                                            <hr class="mb-2 mt-4">
                                            <h2>Spesifikasi Produk</h2>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Ukuran</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="size_in"
                                                        id="size_in" autocomplete="off">
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Bahan Baku</b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="raw_material_in"
                                                        id="raw_material_in" autocomplete="off">
                                                </div>
                                            </div>
                                            <br />
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>Kapasitas Produksi <span
                                                            id="bulan">(Bulan)</span></b></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control satuan" name="capacity"
                                                        id="capacity" autocomplete="off">
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control"
                                                        style="font-size:12px;height: 34px !important;" name="satuan_pro"
                                                        id="satuan_pro">
                                                        <option value="" disabled="" selected="">- Select -
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
                                                <label class="col-md-2"><b>HS Code</b></label>
                                                <div class="col-md-4">
                                                    <select class="form-control select2" name="hscode" id="hscode"
                                                        style="width: 100%;">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- <div class="form-group row">
                                                                <label class="col-md-2"><b>Tampilkan Produk</b></label>
                                                                <div class="col-md-9">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input custom-control-inline" checked data-toggle="toggle" data-on="Publish" data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya">
                                                                         <label class="custom-control-label" for="statusnya">Publish</label>
                                                                        <input type="hidden" name="status" id="status" value="1">
                                                                    </div>
                                                                </div>
                                                            </div> -->
                                            <br />
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <div style="float: left;">
                                                        {{-- <button type="button" class="btn btn-default" onclick="nextTab('descprod', 'infoprod')">Back</button> --}}
                                                        <a class="btn btn-danger" href="{{ URL::previous() }}">Cancel</a>
                                                        <button type="button" class="btn btn-primary"
                                                            id="hal3">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                                        Code Here
                                                    </div> -->
                                    <!-- <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                                        <p class="description">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
                                                    </div> -->
                                </div>
                            </div>
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
                                <label><b>@lang('login.forms.by3') (<font color="red">*</font>)</b></label>
                            </div>
                            <div class="form-group col-sm-12" style="font-size: 12px !important;">
                                <?php
                                $ms1 = DB::select('select id,nama_kategori_en from csc_product where level_1 = 0 and level_2 = 0 order by nama_kategori_en asc');
                                ?>
                                <select style="color:black;font-size: 12px !important; " size="13"
                                    class="column J-noselect" name="category[]" id="category" onchange="t1()" required
                                    form="form_br">
                                    <option value="">@lang('login.forms.by11')</option>
                                    <?php foreach ($ms1 as $val1) { ?>
                                    <option value="{{ $val1->id }}">{{ $val1->nama_kategori_en }}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div id="t2">
                                <input type="hidden" name="t2s" id="t2s" value="0" form="form_br">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div id="t3">
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

    <script type="text/javascript">
        $('#satuan').change(function() {
            $('#usd').html('(' + $('#satuan').val() + '/USD)')
        });
        $('#satuan_pro').change(function() {
            $('#bulan').html('(' + $('#satuan_pro').val() + '/Bulan)')
        });
        $(document).ready(function() {
            var CSRF_TOKEN = "{{ csrf_token() }}";
            // CKEDITOR.replace('product_description_en');
            // CKEDITOR.replace('product_description_in');
            // CKEDITOR.replace('product_description_chn');

            // $("#img_utama").click(function() {
            //     $("input[id='image_utama']").click();
            // });

            var product_description_in = document.getElementById("product_description_in");
            CKEDITOR.replace(product_description_in, {
                language: 'en-gb',
                height: 100,
                toolbar: [
                    ['Source', 'Bold', 'Italic']
                ]
            });
            CKEDITOR.config.placeholder = 'some value';



            $("#satuan").select2({
                placeholder: "Pilih Satuan Produk",
                allowClear: true
            });

            $("#satuan_pro").select2({
                placeholder: "Pilih Satuan Produk",
                allowClear: true
            });

            $('#hscode').select2({
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
                                    text: item.fullhs + "  -  " + item.desc_eng,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $("#img_1").click(function() {
                $("input[id='image_1']").click();
            });

            $("#img_2").click(function() {
                $("input[id='image_2']").click();
            });

            $("#img_3").click(function() {
                $("input[id='image_3']").click();
            });

            $("#img_4").click(function() {
                $("input[id='image_4']").click();
            });

            // document.getElementById("image_utama").addEventListener('change',handleFileSelect,false);
            document.getElementById("image_1").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_2").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_3").addEventListener('change', handleFileSelect, false);
            document.getElementById("image_4").addEventListener('change', handleFileSelect, false);

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
                nextTab('infoprod', 'descprod');
                return true;
            });

            $("#hal3").on("click", function() {
                if ($('#prodname_in').val() == "") {
                    alert("Nama Product masih kosong, harap diisi");
                    return false;
                } else if ($('#id_csc_product').val() == "" && $('input[name=category_rec]:checked').prop(
                        'checked') != true) {
                    alert("Harap memilih Kategori Produk");
                    return false;
                } else {
                    $("#formnya").submit();
                }
            });

            // $("#code").focus(function() {}).blur(function() {
            //     $('#codenya').text(this.value);
            // });

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

            // $(document).on('keyup', '.select2', function (e) {   
            //     console.log(e);
            //     // alert(this.value);
            // })

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


        })

        function nextTab(now, next) {
            $('#set_' + now).removeClass('active');
            $('#set_' + next).addClass('active');

            $('.tab-pane.active').removeClass('active');
            $('#' + next).addClass('active');
        }

        function getSub(sub, idp, ids, name, evt) {
            evt.preventDefault();
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
                    $('#select_2').text(' > ' + name);
                    $('#id_csc_product_level1').val(ids);
                    $('#select_3').text('');
                    $('#id_csc_product_level2').val('');
                    $('#prod3').html('');
                    $('.listbag2').removeClass('active');
                    $('#kat2_' + ids).addClass('active');
                    $('#tmpsearch3').html('');
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

        $('.upload1').on('change', function(evt) {
            var size = this.files[0].size;
            if (size > 5000000) {
                // if(size > 20000){
                $(this).val("");
                alert('image size must less than 5MB');
            } else {

            }
        })

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

            $('#labelcat').html(text);
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

        $('#labelcat').on('click', function() {
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
                                var id_a = (val.id_level_1 != null) ? val.id_level_1 +
                                    "," : "";
                                var id_b = (val.id_level_2 != null) ? val.id_level_2 +
                                    "," : "";
                                var id_c = (val.id != null) ? val.id + "," : "";
                                var id = id_a + id_b + id_c;

                                var a = (val.level_1 != null) ? val.level_1 + " » " :
                                    "";
                                var b = (val.level_2 != null) ? val.level_2 + " » " :
                                    "";
                                var c = (val.nama_kategori_en != null) ? val
                                    .nama_kategori_en : "";
                                var kat = a + b + c;

                                res +=
                                    '<input type="radio" class="category_radio" id="cat_' +
                                    id + '" name="category_rec" value="' + id + '">' +
                                    '<label class="form-check-label" for="cat_' + id +
                                    '">&nbsp;' + kat + '</label><br>';
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
