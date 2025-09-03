@extends('header2')
@section('content')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <style>
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 45px !important;
        }

        .custom-select,
        .custom-file-control,
        .custom-file-control:before,
        select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
            height: 45px !important;
        }

        .body {
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

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Form Inquiry/Buying Request</h3>
                </div>
                <div class="card-body">
                    <?php 
                $pesan = DB::select("select * from csc_inquiry_br where id='".$id."' limit 1 ");
                foreach($pesan as $ryu){
            ?>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="box-body">
                                <div class="form-row">
                                    <div class="form-group col-sm-12">
                                        <b>Created By</b>
                                    </div>
                                    <div class="form-group col-sm-12 mt--3">
                                        <?php
                                        if ($ryu->type == 'admin') {
                                            $t = 'Admin';
                                        } elseif ($ryu->type == 'perwakilan') {
                                            $t = 'Perwakilan';
                                        } elseif ($ryu->type == 'importir') {
                                            $t = 'Importir';
                                        }
                                        ?>
                                        <input type="text" class="form-control" value="{{ $t }}" readonly>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-sm-8">
                                        <label><b>What are you looking for</b></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label><b>Duration</b></label>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        <input readonly type="text" style="color:black;" value="{{ $ryu->subyek_en }}"
                                            name="cmp" id="cmp" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <select disabled style="color:black;" class="form-control" name="valid"
                                            id="valid">
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
                                        <select style="color:black;" disabled class="form-control" name="category"
                                            id="category" onchange="t1()">
                                            <option value="">-- Select Category --</option>
                                            <?php foreach($ms1 as $val1){ ?>
                                            <option <?php if ($ryu->id_csc_prod_cat == $val1->id) {
    echo 'selected';
} ?> value="{{ $val1->id }}">
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
                                                    value="" name="eo" id="eo" class="form-control"> </div>
                                            <div class="col-sm-5"> <select disabled style="color:black;"
                                                    class="form-control" name="neo" id="neo">
                                                    <option value="Pieces">Pieces</option>
                                                </select></div>
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
                                    <div class="col-sm-6">
                                        <label><b>Location of delivery</b></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label><b>City</b></label>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <select style="color:black;" style="border-color: rgba(120, 130, 140, 0.5)!important;
         border-radius: 0.25rem!important; color: inherit!important;" readonly class="form-control" name="country"
                                            id="country">
                                            <option value="">-- Select Country --</option>
                                            <option value="" </option>
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
                                        <div class="form-group col-sm-12">
                                            <a class="btn btn-warning" download
                                                href="{{ asset('uploads/buy_request/' . $ryu->file) }}">Download File</a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="box-body">
                                <table id="example1" border="0" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <th width="5%">No</th>
                                        <th>
                                            <center>Company Name</center>
                                        </th>
                                        <th>
                                            <center>Address</center>
                                        </th>
                                        <th>
                                            <center>Email</center>
                                        </th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th>
                                            <center>Action</center>
                                        </th>
                                    </thead>
                                    <tbody>
                                        <?php 
								$pesan = DB::select("select a.*,b.*,c.*,a.email as oemail,b.id as idb,a.id as id_user from itdp_company_users a, csc_buying_request_join b, itdp_profil_eks c where a.id=b.id_eks and a.id_profil = c.id and id_br='".$id."'");
								$na = 1;
								foreach($pesan as $ryu){
								?>
                                        <tr>
                                            <td>
                                                {{ $na }}
                                            </td>
                                            <td>
                                                <div align="left"><a
                                                        href="{{ url('front_end/list_perusahaan/view', $ryu->id_user) }}-{{ $ryu->company }}"
                                                        target="_blank">{{ $ryu->company }}</a></div>
                                            </td>
                                            <td>
                                                {{ $ryu->addres . ' , ' . $ryu->city }}
                                            </td>
                                            <td>
                                                {{ $ryu->oemail }}
                                            </td>
                                            <td>
                                                <center>
                                                    <?php if ($ryu->status_join == null) {
                                                        echo 'pending';
                                                    } elseif ($ryu->status_join == '1') {
                                                        echo 'Menunggu Verifikasi Importir';
                                                    } elseif ($ryu->status_join == '2') {
                                                        echo 'Negosiation';
                                                    } elseif ($ryu->status_join == '4') {
                                                        echo 'Deal';
                                                    } else {
                                                        echo '-';
                                                    } ?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php if($ryu->status_join == 1){ ?>
                                                    <a href="{{ url('br_konfirm2/' . $ryu->idb . '/' . $id) }}"
                                                        class="btn btn-success" title="Verifikasi">Approve</a>
                                                    <?php }else if($ryu->status_join == 2){ ?>
                                                    <a href="{{ url('br_pw_chat/' . $ryu->idb) }}" class="btn btn-info"
                                                        title="Chat"><i class="fa fa-comment"></i></a>
                                                    <?php }else if($ryu->status_join == 4){ ?>
                                                    <a href="{{ url('br_pw_chat/' . $ryu->idb) }}" class="btn btn-success"
                                                        title="View"><i class="fa fa-list"></i></a>
                                                    <?php } ?>
                                                </center>
                                            </td>
                                        </tr>

                                        <?php  $na++; } ?>

                                    </tbody>
                                </table>
                                <br>
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
