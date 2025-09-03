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
            height: 35px !important;
        }

    </style>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Form Inquiry/Buying Request</h3>
                </div>

                <?php 
				$pesan = DB::select("select * from csc_inquiry_br where id='".$id."' limit 1 ");
				foreach($pesan as $ryu){
			?>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="box-body">
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>What are you looking for</b></label>
                                </div>
                                <div class="form-group col-sm-8">
                                    <input readonly type="text" style="color:black;" value="{{ $ryu->subyek_en }}"
                                        name="cmp" id="cmp" class="form-control">
                                </div>
                                <div class="form-group col-sm-4">
                                    <select disabled style="color:black;" class="form-control" name="valid" id="valid">
                                        <option value="7">Valid within 7 day</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>Category</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <?php
                                    $ms1 = DB::select('select id,nama_kategori_en from csc_product order by nama_kategori_en asc');
                                    ?>
                                    <select style="color:black;width:100%;" class="form-control select2" multiple
                                        name="category" id="category" disabled>
                                        <option value="">-- Select Category --</option>
                                        <?php foreach($ms1 as $val1){ ?>
                                        <option <?php
$oc = explode(',', $ryu->id_csc_prod_cat);
if (empty($oc[0])) {
    $a1 = '';
} else {
    $a1 = $oc[0];
}
if (empty($oc[1])) {
    $a2 = '';
} else {
    $a2 = $oc[1];
}
if (empty($oc[2])) {
    $a3 = '';
} else {
    $a3 = $oc[2];
}
if (empty($oc[3])) {
    $a4 = '';
} else {
    $a4 = $oc[3];
}
if (empty($oc[4])) {
    $a5 = '';
} else {
    $a5 = $oc[4];
}

if ($a1 == $val1->id || $a2 == $val1->id || $a3 == $val1->id || $a4 == $val1->id || $a5 == $val1->id) {
    echo 'selected';
}
?> value="{{ $val1->id }}">
                                            {{ $val1->nama_kategori_en }}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div id="t2">
                                <input type="hidden" name="t2s" id="t2s" value="0">
                            </div>

                            <div id="t3">
                                <input type="hidden" name="t3s" id="t3s" value="0">
                            </div>

                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>Specification</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <textarea readonly style="color:black;" name="spec" id="spec"
                                        class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-sm-6">
                                    <label><b>Estimated order quantity</b></label>
                                </div>
                                <div class="col-sm-6">
                                    <label><b>Targeted price (Estimated total)</b></label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="form-row">
                                        <div class="col-sm-7"><input readonly style="color:black;" type="number"
                                                value="" name="eo" id="eo" class="form-control">
                                        </div>
                                        <div class="col-sm-5"> <select disabled style="color:black;"
                                                class="form-control" name="neo" id="neo">
                                                <option value="Pieces">Pieces</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="form-row">
                                        <div class="col-sm-7"><input readonly style="color:black;" type="number"
                                                value="" name="tp" id="tp" class="form-control"></div>
                                        <div class="col-sm-5 align-self-center">
                                            <label class="control-label">USD</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box-body">
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>Location of delivery</b></label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php
                                    $ms2 = DB::select('select id,country from mst_country order by country asc');
                                    ?>
                                    <select disabled style="color:black;" style="border-color: rgba(120, 130, 140, 0.5)!important;
          border-radius: 0.25rem!important; color: inherit!important;" class="form-control" name="country" id="country">
                                        <option value="">-- Select Country --</option>
                                        <?php foreach($ms2 as $val2){ ?>
                                        <option <?php if ($ryu->id_mst_country == $val2->id) {
    echo 'selected';
} ?> value="{{ $val2->id }}">{{ $val2->country }}
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input readonly style="color:black;" type="text" value="" name="city" id="city"
                                        class="form-control" placeholder="City/State">
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- <div class="col-sm-12">
                                    <label><b>Shipping & Payment conditions</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <textarea readonly style="color:black;" value="" name="ship" id="ship"
                                        class="form-control"></textarea>
                                </div> --}}
                            </div>

                            <div class="form-row">
                                {{-- <div class="col-sm-12">
                                    <label><b>Add attachment (Relevant to a request)</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <a class="btn btn-warning" download
                                        href="{{ asset('uploads/buy_request/' . $ryu->file) }}">Download File</a>
                                </div> --}}
                            </div>

                            <div class="col-sm-12 mt-5">
                                <div align="right">
                                    <a href="{{ url('br_list') }}" class="btn btn-md btn-danger"><i
                                            class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            @include('footer')
        @endsection
