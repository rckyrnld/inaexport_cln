{{-- @include('header') --}}
@extends('header2')
@section('content')
<title>InaExport | Tambah User</title>
{{-- <div class="padding"> --}}
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <style>
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

        .row {
            margin-bottom: -0.8rem;
        }
    </style>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="box-divider m-0"></div>
                <div class="box-body">
                    <div id="exTab2" class="container">
                        <ul class="nav nav-tabs" style="display: none;">
                            <li class="nav-item"><a class="nav-link active" href="#formprod" id="set_formprod"
                                    data-toggle="tab">Form Product</a></li>
                            <li class="nav-item"><a class="nav-link" href="#infoprod" id="set_infoprod"
                                    data-toggle="tab">Information Product</a></li>
                            <li class="nav-item"><a class="nav-link" href="#descprod" id="set_descprod"
                                    data-toggle="tab">Description Product</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="formprod">
                                <br>
                                <h3>Form Product</h3>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5">
                                        <center><label for="lbl"><b>English</b></label></center>
                                    </div>
                                    <div class="col-md-5">
                                        <center><label for="lbl"><b>Indonesia</b></label></center>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <center><label for="lbl"><b>China</b></label></center>
                                    </div> --}}
                                </div>
                                <br>
                                @if($jenis == 'admin')
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="lbl"><b>Company Name</b></label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="compname" id="compname"
                                            autocomplete="off" value="{{getNameCompany($data->id_itdp_company_user)}}"
                                            style="text-transform: uppercase; font-weight: bold;" readonly>
                                    </div>
                                    <div class="col-md-5"></div>
                                </div><br>
                                @endif
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Code</b></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="code" id="code" autocomplete="off"
                                            value="{{$data->code_en}}" readonly>
                                    </div>
                                    <div class="col-md-5"></div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Product Name</b></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="prodname_en" id="prodname_en"
                                            autocomplete="off" value="{{$data->prodname_en}}" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="prodname_in" id="prodname_in"
                                            autocomplete="off" value="{{$data->prodname_in}}" readonly>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <input type="text" class="form-control" name="prodname_chn" id="prodname_chn"
                                            autocomplete="off" value="{{$data->prodname_chn}}" readonly>
                                    </div> --}}
                                </div>
                                <!--<div class="row" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 10px;">
                                    <div class="col-md-12"><label><b>Product Category</b></label></div><br>
                                    <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px; max-height: 450px;">
                                        <div id="prod1" class="list-group" style="height: 430px; overflow-y: auto;">
                                            @if($data->id_csc_product != NULL)
                                                @foreach($catprod as $cp)
                                                    <?php
                                                        if($data->id_csc_product == $cp->id){
                                                            $cact = "active";
                                                        }else{
                                                            $cact = "";
                                                        }
                                                    ?>
                                                    <a href="#" class="list-group-item list-group-item-action listbag1 {{$cact}}" onclick="getSub(1,'{{$cp->id}}', '', '{{$cp->nama_kategori_en}}', event)" id="kat1_{{$cp->id}}">{{$cp->nama_kategori_en}}</a>
                                                @endforeach
                                            @else
                                            Category Not Found
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                        <div id="prod2" class="list-group" style="height: 430px; overflow-y: auto;">
                                            @if($data->id_csc_product_level1 != NULL)
                                                @foreach($catprod2 as $cp1)
                                                    @if($cp1->level_1 == $data->id_csc_product)
                                                        <?php
                                                            if($data->id_csc_product_level1 == $cp1->id){
                                                                $cact1 = "active";
                                                            }else{
                                                                $cact1 = "";
                                                            }
                                                        ?>
                                                        <a href="#" class="list-group-item list-group-item-action listbag2 {{$cact1}}" onclick="getSub(2,'{{$cp1->level_1}}', '{{$cp1->id}}','{{$cp1->nama_kategori_en}}', event)" id="kat2_{{$cp1->id}}">{{$cp1->nama_kategori_en}}</a>
                                                    @endif
                                                @endforeach
                                            @else
                                            Category Not Found
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                        <div id="prod3" class="list-group" style="height: 430px; overflow-y: auto;">
                                            @if($data->id_csc_product_level2 != NULL)
                                                @foreach($catprod3 as $cp2)
                                                    @if($cp2->level_2 == $data->id_csc_product)
                                                        @if($cp2->level_1 == $data->id_csc_product_level1)
                                                            <?php
                                                                if($data->id_csc_product_level2 == $cp2->id){
                                                                    $cact2 = "active";
                                                                }else{
                                                                    $cact2 = "";
                                                                }
                                                            ?>
                                                            <a href="#" class="list-group-item list-group-item-action listbag3 {{$cact2}}" onclick="getSub(3,'{{$cp2->level_1}}', '{{$cp2->id}}','{{$cp2->nama_kategori_en}}', event)" id="kat3_{{$cp2->id}}">{{$cp2->nama_kategori_en}}</a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @else
                                            Category Not Found
                                            @endif
                                        </div>
                                    </div> -->
                                <div class="row">
                                    <div class="col-md-2" style="margin-top: 20px;"><label><b>Select</b></label></div>
                                    <div class="col-md-10" style="margin-top: 20px;">
                                        @if($data->id_csc_product != NULL)
                                        <span id="select_1">{{getNameCategoryProduct($data->id_csc_product,
                                            'en')}}</span>
                                        <input type="hidden" id="id_csc_product" value="{{$data->id_csc_product}}">
                                        @else
                                        <span id="select_1">null</span>
                                        <input type="hidden" id="id_csc_product" value="">
                                        @endif
                                        @if($data->id_csc_product_level1 != NULL)
                                        <span id="select_2">> {{getNameCategoryProduct($data->id_csc_product_level1,
                                            'en')}}</span>
                                        <input type="hidden" id="id_csc_product_level1"
                                            value="{{$data->id_csc_product_level1}}">
                                        @else
                                        {{-- <span id="select_2">null</span>
                                        <input type="hidden" id="id_csc_product_level1" value=""> --}}
                                        @endif
                                        @if($data->id_csc_product_level2 != NULL)
                                        <span id="select_3">> {{getNameCategoryProduct($data->id_csc_product_level2,
                                            'en')}}</span>
                                        <input type="hidden" id="id_csc_product_level2"
                                            value="{{$data->id_csc_product_level2}}">
                                        @else
                                        {{-- <span id="select_3">null</span>
                                        <input type="hidden" id="id_csc_product_level2" value=""> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-group" style="float: right;">
                                        <button type="button" class="btn btn-primary" id="hal1">Next</button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="tab-pane " id="infoprod">
                            <br>
                            <hr class="mt-1 mb-2">
                            <h3>Information Product</h3>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <center><label for="lbl"><b>English</b></label></center>
                                </div>
                                <div class="col-md-5">
                                    <center><label for="lbl"><b>Indonesia</b></label></center>
                                </div>
                                {{-- <div class="col-md-3">
                                    <center><label for="lbl"><b>China</b></label></center>
                                </div> --}}

                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Code</b></label>
                                <div class="col-md-5">
                                    <center><span id="codenya">{{$data->code_en}}</span></center>
                                </div>
                                <div class="col-md-5"></div>
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Product Name</b></label>
                                <div class="col-md-5">
                                    <center><span id="prodname_ea">{{$data->prodname_en}}</span></center>
                                    <input type="hidden" id="nama_prod" value="{{$data->prodname_en}}">
                                </div>
                                <div class="col-md-5">
                                    <center><span id="prodname_ia">{{$data->prodname_in}}</span></center>
                                </div>
                                {{-- <div class="col-md-3">
                                    <center><span id="prodname_ca">{{$data->prodname_chn}}</span></center>
                                </div> --}}
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Category Product</b></label>
                                <div class="col-md-5">
                                    <center><span id="cadprod_en">{{getNameCategoryProduct($data->id_csc_product,
                                            'en')}}</span></center>
                                </div>
                                <div class="col-md-5">
                                    <center><span id="cadprod_in">{{getNameCategoryProduct($data->id_csc_product,
                                            'in')}}</span></center>
                                </div>
                                {{-- <div class="col-md-3">
                                    <center><span id="cadprod_chn">{{getNameCategoryProduct($data->id_csc_product,
                                            'chn')}}</span></center>
                                </div> --}}
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Description Product</b></label>
                                <div class="col-md-5">
                                    {{-- <input type="text" class="form-control" autocomplete="off"
                                        value="{{strip_tags( $data->product_description_in )}}" readonly> --}}
                                    <textarea class="form-control" autocomplete="off" readonly rows="15"
                                        style="">{{strip_tags( $data->product_description_en )}}</textarea>
                                </div>
                                <div class="col-md-5">
                                    {{-- <input type="text" class="form-control" autocomplete="off"
                                        value="{{strip_tags( $data->product_description_en )}}" readonly> --}}
                                    <textarea class="form-control" autocomplete="off" readonly rows="15"
                                        style="">{{strip_tags( $data->product_description_in )}}</textarea>
                                </div>
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Color</b></label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="color_en" id="color_en"
                                        autocomplete="off" value="{{$data->color_en}}" readonly>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="color_in" id="color_in"
                                        autocomplete="off" value="{{$data->color_in}}" readonly>
                                </div>
                                {{-- <div class="col-md-3">
                                    <input type="text" class="form-control" name="color_chn" id="color_chn"
                                        autocomplete="off" value="{{$data->color_chn}}" readonly>
                                </div> --}}
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Size</b></label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="size_en" id="size_en"
                                        autocomplete="off" value="{{$data->size_en}}" readonly>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="size_in" id="size_in"
                                        autocomplete="off" value="{{$data->size_in}}" readonly>
                                </div>
                                {{-- <div class="col-md-3">
                                    <input type="text" class="form-control" name="size_chn" id="size_chn"
                                        autocomplete="off" value="{{$data->size_chn}}" readonly>
                                </div> --}}
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Raw Material</b></label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="raw_material_en" id="raw_material_en"
                                        autocomplete="off" value="{{$data->raw_material_en}}" readonly>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="raw_material_in" id="raw_material_in"
                                        autocomplete="off" value="{{$data->raw_material_in}}" readonly>
                                </div>
                                {{-- <div class="col-md-3">
                                    <input type="text" class="form-control" name="raw_material_chn"
                                        id="raw_material_chn" autocomplete="off" value="{{$data->raw_material_chn}}"
                                        readonly>
                                </div> --}}
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Prod. Capacity (Month)</b></label>
                                <div class="col-md-5">
                                    @php
                                    if (!preg_match('/(\d+(\.\d+)*)/', $data->capacity, $matches)) {
                                    // Could not find a matching number in the data - handle this appropriately
                                    $capacity = '0 '.$data->satuan_pro;
                                    } else {
                                    $capacity = number_format($matches[1], 0).' '.$data->satuan_pro;
                                    }
                                    @endphp
                                    <input type="text" class="form-control" name="capacity" id="capacity"
                                        autocomplete="off" value="{{$capacity}}" readonly>
                                </div>
                                <div class="col-md-5">
                                </div>
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Price (USD)</b></label>
                                <div class="col-md-5">
                                    @php
                                    if (!preg_match('/(\d+(\.\d+)*)/', $data->price_usd, $matches2)) {
                                    // Could not find a matching number in the data - handle this appropriately
                                    $concat = '/';
                                    if($data->unit == '' || $data->unit == null){
                                    $concat = '';
                                    }
                                    $price_usd = '0 '.$concat.' '.$data->unit;
                                    } else {
                                    $concat = '/';
                                    if($data->unit == '' || $data->unit == null){
                                    $concat = '';
                                    }
                                    $price_usd = number_format($matches2[1], 1).' '.$concat.' '.$data->unit;
                                    }
                                    @endphp
                                    <input type="text" class="form-control" name="price_usd" id="price_usd"
                                        autocomplete="off" value="{{$price_usd}}" readonly>
                                </div>
                                <div class="col-md-5">
                                </div>
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>HS Code</b></label>
                                <div class="col-md-5">
                                    <?php
                                                $hscodenya = NULL;
                                                if($hsco != NULL){
                                                    $hscodenya = $hsco->fullhs." - ". $hsco->desc_eng;
                                                }
                                            ?>
                                    {{$hscodenya}}
                                </div>
                                <div class="col-md-5">
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-md-12">
                                    <hr class="mt-1 mb-2">
                                    <h3>Setting Media</h3><br>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Image</b></label>
                                <div class="col-md-2">
                                    <div id="ambil_ttd_1"
                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                        <button type="button" id="img_1_view" style="width: 100%; height: 120px;"
                                            class="img_upl">
                                            @if($data->image_1 == NULL)
                                            <img src="{{url('/')}}/image/plus/plusin.png" id="image_1_ambil"
                                                style="height: 40px; width: 40px;" />
                                            @else
                                            <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_1}}"
                                                style="height: 100%; width: 100%;" />
                                            @endif
                                        </button>
                                        <input type="file" id="image_1" name="image_1" style="display: none;" />
                                        <br>
                                        <center>+ Photo 1</center>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div id="ambil_ttd_2"
                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                        <button type="button" id="img_2_view" style="width: 100%; height: 120px;"
                                            class="img_upl">
                                            @if($data->image_2 == NULL)
                                            <img src="{{url('/')}}/image/plus/plusin.png" id="image_2_ambil"
                                                style="height: 40px; width: 40px;" />
                                            @else
                                            <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_2}}"
                                                style="height: 100%; width: 100%;" />
                                            @endif
                                        </button>
                                        <input type="file" id="image_2" name="image_2" style="display: none;" />
                                        <br>
                                        <center>+ Photo 2</center>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div id="ambil_ttd_3"
                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                        <button type="button" id="img_3_view" style="width: 100%; height: 120px;"
                                            class="img_upl">
                                            @if($data->image_3 == NULL)
                                            <img src="{{url('/')}}/image/plus/plusin.png" id="image_3_ambil"
                                                style="height: 40px; width: 40px;" />
                                            @else
                                            <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_3}}"
                                                style="height: 100%; width: 100%;" />
                                            @endif
                                        </button>
                                        <input type="file" id="image_3" name="image_3" style="display: none;" />
                                        <br>
                                        <center>+ Photo 3</center>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div id="ambil_ttd_4"
                                        style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                        <button type="button" id="img_4_view" style="width: 100%; height: 120px;"
                                            class="img_upl">
                                            @if($data->image_4 == NULL)
                                            <img src="{{url('/')}}/image/plus/plusin.png" id="image_4_ambil"
                                                style="height: 40px; width: 40px;" />
                                            @else
                                            <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_4}}"
                                                style="height: 100%; width: 100%;" />
                                            @endif
                                        </button>
                                        <input type="file" id="image_4" name="image_4" style="display: none;" />
                                        <br>
                                        <center>+ Photo 4</center>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Minimum Selling</b></label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="minimum_order" id="minimum_order"
                                        autocomplete="off" value="{{$data->minimum_order}}" readonly>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="minimum_order" id="minimum_order"
                                        autocomplete="off" value="{{$data->unit}}" readonly>

                                </div>
                            </div><br>
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div style="float: right;">
                                        <button type="button" class="btn btn-default"
                                            onclick="nextTab('infoprod', 'formprod')">Back</button>
                                        <button type="button" class="btn btn-primary" id="hal2">Next</button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="tab-pane" id="descprod">
                            <br>
                            {{-- <h3>Description Product</h3>
                            <hr>
                            <div class="row">
                                <label for="code" class="col-md-3"><b>English</b></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="product_description_en"
                                        name="product_description_en"
                                        disabled>{{$data->product_description_en}}</textarea>

                                </div>
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-3"><b>Indonesia</b></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="product_description_in"
                                        name="product_description_in"
                                        disabled>{{$data->product_description_in}}</textarea>
                                </div>
                            </div><br>
                            <div class="row">
                                <label for="code" class="col-md-3"><b>China</b></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="product_description_chn"
                                        name="product_description_chn"
                                        disabled>{{$data->product_description_chn}}</textarea>
                                </div>
                            </div><br> --}}
                            <div class="row">
                                <label for="code" class="col-md-2"><b>Show Product</b></label>
                                <div class="col-md-9">
                                    <?php
                                            if($data->show == 0){
                                                $chck = "";
                                            }else{
                                                $chck = "checked";
                                            }
                                        ?>
                                    <input type="checkbox" {{$chck}} data-toggle="toggle" data-on="Publish"
                                        data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya">
                                </div>
                            </div><br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <div class="btn-group">
                                            <a class="btn btn-primary mr-2" href="{{ URL::previous() }}">Cancel</a>
                                            <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                                                action="{{url($url)}}" id="formnya">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="verifikasi" value="1">
                                                <input type="hidden" name="id_csc_product"
                                                    value="{{$data->id_csc_product}}">
                                                <input type="hidden" name="id_csc_product_level1"
                                                    value="{{$data->id_csc_product_level1}}">
                                                <input type="hidden" name="id_csc_product_level2"
                                                    value="{{$data->id_csc_product_level2}}">
                                                    <input type="hidden" name="status" id="status" value="{{ $data->show }}">
                                                <button class="btn btn-success" type="button" onclick=verif()><i
                                                        class="fa fa-check" aria-hidden="true"></i> Accept</button>
                                            </form>&nbsp;&nbsp;&nbsp;
                                            {{-- <button class="btn btn-success" type="button" onclick=test()>
                                                <i class="fa fa-check" aria-hidden="true"></i> Accept
                                            </button> --}}
                                            <button class="btn btn-danger" type="button" data-toggle="modal"
                                                data-target="#modalDecline"><i class="fa fa-times"
                                                    aria-hidden="true"></i> Decline</button>
                                        </div>
                                    </center>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="float: left;">
                                        {{-- <button type="button" class="btn btn-default"
                                            onclick="nextTab('descprod', 'infoprod')">Back</button> --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDecline" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{url($url)}}"
                id="formdecline">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align: left;">Form Rejection</h4>
                    <button type="button" class="close" data-dismiss="modal" style="text-align: right;">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="verifikasi" value="0">
                            <label><b>This product was rejected due to :</b></label>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="5"></textarea>
                        </div>
                    </div><br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="sendDecline">Send</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace('product_description_en');
        CKEDITOR.replace('product_description_in');
        CKEDITOR.replace('product_description_chn');

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
        document.getElementById("image_1").addEventListener('change',handleFileSelect,false);
        document.getElementById("image_2").addEventListener('change',handleFileSelect,false);
        document.getElementById("image_3").addEventListener('change',handleFileSelect,false);
        document.getElementById("image_4").addEventListener('change',handleFileSelect,false);

        $("#hal1").on("click", function(){
            nextTab('formprod','infoprod');
            return true;
        });

        $("#hal2").on("click", function(){
            nextTab('infoprod','descprod');
            return true;
        });

        $("#hal3").on("click", function(){
            // var desc = CKEDITOR.instances.product_description_en.getData();
            // if (desc == "") {
            //     alert("Product Description is empty, Please fill in!");
            //     document.getElementById('product_description_en').focus();
            //     return false;
            // }else {
            //     $("#formnya").submit();
            // }
        });

        $("#code").focus(function(){}).blur(function(){
            $('#codenya').text(this.value);
        });

        $("#prodname_en").focus(function(){}).blur(function(){
            $('#prodname_ea').text(this.value);
        });

        $('#statusnya').on('change', function() {
            var isChecked = $(this).is(':checked');
            var selectedData;

            if(isChecked) {
                $('#status').val(1);
            } else {
                $('#status').val(0);
            }

        });

        $("#verif_btn").click(function () {
            alert("test");
        });

        $('#verif_btn').on('click', function() {
            // var kategori1 = $('#id_csc_product').val();

            // if(kategori1 == "") {
            //     alert("Please fill in the reason you rejected this product");
            // } else {
            //     // $('#formdecline').submit();
            //     alert("wow")
            // }
            console.log("sssss");
        });

        $('#sendDecline').on('click', function() {
            var keterangan = $('#keterangan').val();;

            if(keterangan == "") {
                alert("Please fill in the reason you rejected this product");
            } else {
                $('#formdecline').submit();
            }

        });
    })

    $('#statusnya').on('change', function() {
        var isChecked = $(this).is(':checked');
        var selectedData;
        
        if(isChecked) {
            $('#status').val(1);
        } else {
            $('#status').val(0);
        }
    
    });

    function verif(){
        var kategori1 = $('#id_csc_product').val();
        var kategori2 = $('#id_csc_product_level1').val();
        var kategori3 = $('#id_csc_product_level2').val();
        var prodname = $('#nama_prod').val();

        if(kategori1 == "" || prodname == "") {
            alert("Your Product Categories Or Product name is empty");
        } else {
            $('#formnya').submit();
        }
    }

    function nextTab(now, next) {
        $('#set_'+now).removeClass('active');
        $('#set_'+next).addClass('active');

        $('.tab-pane.active').removeClass('active');
        $('#'+next).addClass('active');
    }

    function getSub(sub, idp, ids, name, e) {
        e.preventDefault();
        if(sub == 3){
            $('#select_3').text('> '+name);
            $('#id_csc_product_level2').val(ids);
            $('input[name="id_csc_product_level2"]').val(ids);
            $('.listbag3').removeClass('active');
            $('#kat3_'+ids).addClass('active');
        }else{
            if(sub == 1){
                $('#select_1').text(name);
                $('#cadprod_en').text(name);
                $('#id_csc_product').val(idp);
                $('input[name="id_csc_product"]').val(idp);
                $('#select_2').text('');
                $('#id_csc_product_level1').val('');
                $('input[name="id_csc_product_level1"]').val('');
                $('#select_3').text('');
                $('#id_csc_product_level2').val('');
                $('input[name="id_csc_product_level2"]').val('');
                $('#prod2').html('');
                $('#prod3').html('');
                $('.listbag1').removeClass('active');
                $('#kat1_'+idp).addClass('active');
            }else{
                $('#select_2').text('> '+name);
                $('#id_csc_product_level1').val(ids);
                $('input[name="id_csc_product_level1"]').val(ids);
                $('#select_3').text('');
                $('#id_csc_product_level2').val('');
                $('input[name="id_csc_product_level2"]').val('');
                $('#prod3').html('');
                $('.listbag2').removeClass('active');
                $('#kat2_'+ids).addClass('active');
            }
            $.ajax({
                url: "{{route('eksproduct.getSub')}}",
                type: 'get',
                data: {level:sub, idparent:idp, idsub:ids},
                success:function(response){
                    // console.log(response);
                    if(sub == 1){
                        $('#prod2').html(response);
                    }else{
                        $('#prod3').html(response);
                    }
                }
            });
        }
    }

    function handleFileSelect(evt){
        var files = evt.target.files; // FileList object
        var idfile = evt.target.id; // FileList object

        // FileReader support
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
                document.getElementById(idfile+"_ambil").src = fr.result;
                document.getElementById(idfile+"_ambil").style.width = "100%";
                document.getElementById(idfile+"_ambil").style.height = "100%";
            }
            fr.readAsDataURL(files[0]);
        }
     }

     function getStatus(data) {
         console.log(data);
     }
</script>

@include('footer')
@endsection