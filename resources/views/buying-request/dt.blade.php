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
				$pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
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
                                    <input readonly type="text" style="color:black;" value="{{ $ryu->subyek }}" name="cmp"
                                        id="cmp" class="form-control">
                                </div>
                                <div class="form-group col-sm-4">
                                    <select disabled style="color:black;" class="form-control" name="valid" id="valid">
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
} ?> value="15">Valid within 15 day</option>
                                        <option <?php if ($ryu->valid == '30') {
    echo 'selected';
} ?> value="30">Valid within 30 day</option>
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
$oc = explode(',', $ryu->id_csc_prod);
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
                                        class="form-control">{{ $ryu->spec }}</textarea>
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
                                                value="{{ $ryu->eo }}" name="eo" id="eo" class="form-control"> </div>
                                        <div class="col-sm-5"> <select disabled style="color:black;"
                                                class="form-control" name="neo" id="neo">
                                                <option value="Dozen" @if ($ryu->neo == 'Dozen')selected @endif>Dozen</option>
                                                <option value="Grams" @if ($ryu->neo == 'Grams') selected @endif>Grams</option>
                                                <option value="Kilograms" @if ($ryu->neo == 'Kilograms') selected @endif>Kilograms
                                                </option>
                                                <option value="Liters" @if ($ryu->neo == 'Liters') selected @endif>Liters</option>
                                                <option value="Meters" @if ($ryu->neo == 'Meters') selected @endif>Meters</option>
                                                <option value="Packs" @if ($ryu->neo == 'Packs') selected @endif>Packs</option>
                                                <option value="Pairs" @if ($ryu->neo == 'Pairs') selected @endif>Pairs</option>
                                                <option value="Pieces" @if ($ryu->neo == 'Pieces') selected @endif>Pieces</option>
                                                <option value="Sets" @if ($ryu->neo == 'Sets') selected @endif>Sets</option>
                                                <option value="Tons" @if ($ryu->neo == 'Tons') selected @endif>Tons</option>
                                                <option value="Unit" @if ($ryu->neo == 'Unit') selected @endif>Unit</option>
                                            </select></div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <div class="form-row">
                                        <div class="col-sm-7"><input readonly style="color:black;" type="number"
                                                value="{{ $ryu->tp }}" name="tp" id="tp" class="form-control"></div>
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
                      border-radius: 0.25rem!important; color: inherit!important;" class="form-control" name="country"
                                        id="country">
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
                                    <input readonly style="color:black;" type="text" value="{{ $ryu->city }}" name="city"
                                        id="city" class="form-control" placeholder="City/State">
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- <div class="col-sm-12">
                                    <label><b>Shipping & Payment conditions</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <textarea readonly style="color:black;" value="" name="ship" id="ship"
                                        class="form-control">{{ $ryu->shipping }}</textarea>
                                </div> --}}
                            </div>

                            <div class="form-row">
                                {{-- <div class="col-sm-12">
                                    <label><b>Add attachment (Relevant to a request)</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <!-- <input style="color:black;" type="file" value="" name="doc" id="doc" class="form-control" > -->
                                    <a class="btn btn-warning" download
                                        href="{{ asset('uploads/buy_request/' . $ryu->files) }}">Download File</a>
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
        </div>
    </div>
    </div>
    </div>
    </div>

    @include('footer')
@endsection
