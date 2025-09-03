{{-- @include('header') --}}
@extends('header2')
@section('content')
<style type="text/css">
    th {
        text-align: center;
    }

    td {
        color: black;
    }

    #tambah {
        background-color: #1a9cf9;
        color: white;
        white-space: pre;
    }

    #tambah:hover {
        background-color: #148de4
    }

    #export {
        background-color: #28bd4a;
        color: white;
        white-space: pre;
    }

    #export:hover {
        background-color: #08b32e
    }

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

    .form-group{
		margin-bottom: -0.8rem;
	}      
</style>
<!-- Page content -->
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="check-bold mr-2"></i>Indonesian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="check-bold mr-2"></i>English</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>Chinese</a>
                        </li> -->
                    </ul>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <section>
                                    <h2>Informasi Produk</h2>
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Code</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="code" id="code" autocomplete="off" readonly value="{{$data->code_in}}">
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Nama Produk</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="prodname_en" id="prodname_en" autocomplete="off" readonly value="{{$data->prodname_in}}">
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group row">
                                        <div class="col-md-2"><label><b>Kategori Produk</b></label></div><br>
                                        <div class="col-md-10">
                                            <span id="cadprod_en">{{getNameCategoryProduct($data->id_csc_product, 'in')}}</span>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group row">
                                        <div class="col-md-2"><label><b>Warna Produk</b></label></div><br>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="color_en" id="color_en" autocomplete="off" value="{{$data->color_in}}" readonly>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Ukuran</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="size_en" id="size_en" autocomplete="off" value="{{$data->size_in}}" readonly>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Bahan Dasar</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="raw_material_en" id="raw_material_en" autocomplete="off" value="{{$data->raw_material_in}}" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Deskripsi Produk</b></label>
                                        <div class="col-md-10">
                                            <p class="">{{strip_tags($data->product_description_in)}}</p>
                                        </div>
                                    </div>
                                    

                                </section>
                                <section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><b>Media</b></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Image (.png, .jpg, .jpeg, .gif)</label>
                                            <label style="color: red">*maksimum file size 5MB</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_1" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_1" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($data->image_1 == NULL)
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_1_ambil" style="height: 40px; width: 40px;" />
                                                    @else
                                                    <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_1}}" id="image_1_ambil" style="height: 100%; width: 100%;" />
                                                    @endif
                                                </button>
                                                {{--accept="image/png"--}}
                                                <input type="file" id="image_1" name="image_1" style="display: none;" class="upload1" />
                                                <br>
                                                <center>+ Photo 1</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_2" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_2" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($data->image_2 == NULL)
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_2_ambil" style="height: 40px; width: 40px;" />
                                                    @else
                                                    <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_2}}" id="image_2_ambil" style="height: 100%; width: 100%;" />
                                                    @endif
                                                </button>
                                                <input type="file" id="image_2" name="image_2" style="display: none;" class="upload1" />
                                                <br>
                                                <center>+ Photo 2</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_3" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_3" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($data->image_3 == NULL)
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_3_ambil" style="height: 40px; width: 40px;" />
                                                    @else
                                                    <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_3}}" id="image_3_ambil" style="height: 100%; width: 100%;" />
                                                    @endif
                                                </button>
                                                <input type="file" id="image_3" name="image_3" style="display: none;" class="upload1" />
                                                <br>
                                                <center>+ Photo 3</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_4" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_4" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($data->image_4 == NULL)
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_4_ambil" style="height: 40px; width: 40px;" />
                                                    @else
                                                    <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_4}}" id="image_4_ambil" style="height: 100%; width: 100%;" />
                                                    @endif
                                                </button>
                                                <input type="file" id="image_4" name="image_4" style="display: none;" class="upload1" />
                                                <br>
                                                <center>+ Photo 4</center>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <hr class="mt-2 mb-1">
                                <section>
                                    <h2>Harga Produk</h2>
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Minimal Order</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="minimum_order" id="minimum_order" autocomplete="off" value="{{$data->minimum_order}}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="satuan" id="satuan" autocomplete="off" value="{{$data->unit}}" readonly>
                                            
                                        </div>


                                    </div>
                                    
                                    <br />
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Harga <span id="usd">(USD)</span></b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="price_usd" id="price_usd" autocomplete="off" value="{{$data->price_usd}}" readonly>
                                        </div>
                                    </div>
                                    <br />
                                </section>
                                <section>
                                    <h2>Spesifikasi Produk</h2>

                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Kapasitas Produksi <span id="bulan">(Bulan)</span></b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="capacity" id="capacity" autocomplete="off" value="{{str_replace(".", ",",$data->capacity)}}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="satuan_pro" id="satuan_pro" autocomplete="off" value="{{$data->unit}}" readonly>
                                            
                                        </div>
                                        
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-md-2"><b>HS Code</b></label>
                                        <div class="col-md-9">
                                            <?php
                                            $hscodenya = NULL;
                                            if ($hsco != NULL) {
                                                $hscodenya = $hsco->fullhs . " - " . $hsco->desc_in;
                                            }
                                            ?>
                                            {{$hscodenya}}
                                        </div>
                                    </div>
                                    <br>
                                </section>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                <section>
                                    <h2>Product Information</h2>
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Code</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="code" id="code" autocomplete="off" readonly value="{{$data->code_en}}">
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>{{translateToEn('Product Name')}}</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="prodname_en" id="prodname_en" autocomplete="off" readonly value="{{$data->prodname_en}}">
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group row">
                                        <div class="col-md-2"><label><b>{{translateToEn('Product Category')}}</b></label></div><br>
                                        <div class="col-md-10">
                                            <span id="cadprod_en">{{getNameCategoryProduct($data->id_csc_product, 'en')}}</span>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group row">
                                        <div class="col-md-2"><label><b>Product Color</b></label></div><br>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="color_en" id="color_en" autocomplete="off" value="{{$data->color_en}}" readonly>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Size</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="size_en" id="size_en" autocomplete="off" value="{{$data->size_en}}" readonly>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Raw Material</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="raw_material_en" id="raw_material_en" autocomplete="off" value="{{$data->raw_material_en}}" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Product Description</b></label>
                                        <div class="col-md-10">
                                            <p class="">{{strip_tags($data->product_description_en)}}</p>
                                        </div>
                                    </div>

                                </section>
                                <section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><b>Media</b></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Image (.png, .jpg, .jpeg, .gif)</label>
                                            <label style="color: red">*maksimum file size 5MB</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_1" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_1" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($data->image_1 == NULL)
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_1_ambil" style="height: 40px; width: 40px;" />
                                                    @else
                                                    <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_1}}" id="image_1_ambil" style="height: 100%; width: 100%;" />
                                                    @endif
                                                </button>
                                                {{--accept="image/png"--}}
                                                <input type="file" id="image_1" name="image_1" style="display: none;" class="upload1" />
                                                <br>
                                                <center>+ Photo 1</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_2" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_2" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($data->image_2 == NULL)
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_2_ambil" style="height: 40px; width: 40px;" />
                                                    @else
                                                    <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_2}}" id="image_2_ambil" style="height: 100%; width: 100%;" />
                                                    @endif
                                                </button>
                                                <input type="file" id="image_2" name="image_2" style="display: none;" class="upload1" />
                                                <br>
                                                <center>+ Photo 2</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_3" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_3" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($data->image_3 == NULL)
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_3_ambil" style="height: 40px; width: 40px;" />
                                                    @else
                                                    <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_3}}" id="image_3_ambil" style="height: 100%; width: 100%;" />
                                                    @endif
                                                </button>
                                                <input type="file" id="image_3" name="image_3" style="display: none;" class="upload1" />
                                                <br>
                                                <center>+ Photo 3</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_4" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_4" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($data->image_4 == NULL)
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_4_ambil" style="height: 40px; width: 40px;" />
                                                    @else
                                                    <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_4}}" id="image_4_ambil" style="height: 100%; width: 100%;" />
                                                    @endif
                                                </button>
                                                <input type="file" id="image_4" name="image_4" style="display: none;" class="upload1" />
                                                <br>
                                                <center>+ Photo 4</center>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <hr class="mt-2 mb-1">
                                <section>
                                    <h2>Product Price</h2>
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Minimum Selling</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="minimum_order" id="minimum_order" autocomplete="off" value="{{$data->minimum_order}}" readonly>
                                        </div>

                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="satuan_en" id="satuan_en" autocomplete="off" value="{{$data->unit}}" readonly>
                                        </div>

                                    </div>
                                    <br />
                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Price <span id="usd_en">(USD)</span></b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="price_usd" id="price_usd" autocomplete="off" value="{{$data->price_usd}}" readonly>
                                        </div>
                                    </div>
                                    <br />
                                </section>
                                <section>
                                    <h2>Product Spesification</h2>

                                    <div class="form-group row">
                                        <label class="col-md-2"><b>Capacity Production <span id="bulan_en">(Bulan)</b></label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="capacity" id="capacity" autocomplete="off" value="{{$data->capacity}}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="satuan_pro_en" id="satuan_pro_en" autocomplete="off" value="{{$data->unit}}" readonly>
                                        </div>
                                        
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-md-2"><b>HS Code</b></label>
                                        <div class="col-md-9">
                                            <?php
                                            $hscodenya = NULL;
                                            if ($hsco != NULL) {
                                                $hscodenya = $hsco->fullhs . " - " . $hsco->desc_eng;
                                            }
                                            ?>
                                            {{$hscodenya}}
                                        </div>
                                    </div>
                                    <br>
                                </section>
                            </div>
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
{{-- </div> --}}
@include('footer')
<script type="text/javascript">
    $('#satuan').ready(function() {
        $('#usd').html('(' + $('#satuan').val() + '/USD)')
    });
    $('#satuan_en').ready(function() {
        $('#usd_en').html('(' + $('#satuan_en').val() + '/USD)')
    });
    $('#satuan_pro').ready(function() {
        $('#bulan').html('(' + $('#satuan_pro').val() + '/Bulan)')
    });
    $('#satuan_pro_en').ready(function() {
        $('#bulan_en').html('(' + $('#satuan_pro_en').val() + '/Bulan)')
    });
    $(document).ready(function() {
        // CKEDITOR.replace('product_description_en');
        // CKEDITOR.replace('product_description_in');
        // CKEDITOR.replace('product_description_chn');
        $('.prefent').on('click', function(event) {
            event.preventDefault();
        });
        // $("#img_utama").click(function() {
        //     $("input[id='image_utama']").click();
        // });

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
            nextTab('formprod', 'infoprod');
            return true;
        });

        $("#hal2").on("click", function() {
            nextTab('infoprod', 'descprod');
            return true;
        });

        $("#hal3").on("click", function() {
            // var desc = CKEDITOR.instances.product_description_en.getData();
            // if (desc == "") {
            //     alert("Product Description is empty, Please fill in!");
            //     document.getElementById('product_description_en').focus();
            //     return false;
            // }else {
            //     $("#formnya").submit();
            // }
        });

        $("#code").focus(function() {}).blur(function() {
            $('#codenya').text(this.value);
        });

        $("#prodname_en").focus(function() {}).blur(function() {
            $('#prodname_ea').text(this.value);
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
    })

    function nextTab(now, next) {
        $('#set_' + now).removeClass('active');
        $('#set_' + next).addClass('active');

        $('.tab-pane.active').removeClass('active');
        $('#' + next).addClass('active');
    }

    function getSub(sub, idp, ids, name) {
        if (sub == 3) {
            $('#select_3').text('>' + name);
            $('#id_csc_product_level2').val(ids);
            $('.listbag3').removeClass('active');
            $('#kat3_' + ids).addClass('active');
        } else {
            if (sub == 1) {
                $('#select_1').text(name);
                $('#cadprod_en').text(name);
                $('#id_csc_product').val(idp);
                $('.listbag1').removeClass('active');
                $('#kat1_' + idp).addClass('active');
            } else {
                $('#select_2').text('>' + name);
                $('#id_csc_product_level1').val(ids);
                $('.listbag2').removeClass('active');
                $('#kat2_' + ids).addClass('active');
            }
            $.ajax({
                url: "{{route('eksproduct.getSub')}}",
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
                    } else {
                        $('#prod3').html(response);
                    }
                }
            });
        }
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
@endsection