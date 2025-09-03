@extends('header2')
@section('content')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<style>
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

    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        display: block;
        margin: 30px auto;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
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
                $pesan = DB::select("select * from csc_buying_request where id='" . $id . "' limit 1 ");
                foreach ($pesan as $ryu) {
                    ?>
                <div class="form-row">
                    <div class="col-md-12" style="display: none">
                        <div class="box-body">
                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label class="text-break"><b>Created By</b></label>
                                </div>
                                <div>:</div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    <label class="text-break">
                                        <?php
                                            if ($ryu->by_role == 1) {
                                                $t = 'Admin';
                                            } elseif ($ryu->by_role == 4) {
                                                $t = 'Perwakilan';
                                            } elseif ($ryu->by_role == 3) {
                                                $usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $ryu->id_pembuat . "'");
                                                foreach ($usre as $imp) {
                                                    $t = 'Importir - ' . $imp->badanusaha . ' ' . $imp->company;
                                                }
                                            }
                                            ?>
                                        {{ $t }}
                                    </label>
                                    <input type="text" class="form-control d-none" value="{{ $t }}" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label><b>Location of delivery</b></label>
                                </div>

                                <div>:</div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    <?php $ms2 = DB::select('select id,country from mst_country order by country asc'); ?>
                                    <select style="color:black;" style="border-color: rgba(120, 130, 140, 0.5)!important; border-radius: 0.25rem!important; 
                                                                                        color: inherit!important;"
                                        readonly class="form-control d-none" name="country" id="country">
                                        <option value="">-- Select Country --</option>
                                        <?php foreach($ms2 as $val2){ ?>
                                        <option <?php if ($ryu->id_mst_country == $val2->id) { echo 'selected';} ?>
                                            value="
                                            <?php echo $val2->id; ?>">
                                            <?php echo $val2->country; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <label class="text-break">
                                        {{ $val2->country }}
                                    </label>
                                </div>


                            </div>

                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label><b>Country</b></label>
                                </div>
                                <div>:</div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    <?php
                                        $ms2 = DB::select('select id,country from mst_country order by country asc');
                                        ?>
                                    <label class="text-break">
                                        @foreach ($ms2 as $val2)
                                        @if ($ryu->id_mst_country == $val2->id)
                                        {{ $val2->country }}
                                        @endif
                                        @endforeach
                                    </label>
                                    <label class="text-break">
                                        <?php echo '(' . $ryu->city . ')'; ?>
                                    </label>
                                    <input readonly style="color:black;display: none;" type="text"
                                        value="<?php echo $ryu->city; ?>" name="city" id="city" class="form-control"
                                        placeholder="City/State">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label><b>Product</b></label>
                                </div>
                                <div>:</div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    {{-- <input readonly type="text" style="color:black;" value="{{ $ryu->subyek }}"
                                        name="cmp" id="cmp" class="form-control"> --}}
                                    <label class="text-break">
                                        <?php echo $ryu->subyek; ?> @if ($ryu->valid == '3')
                                        (Valid within 3 days)
                                        @elseif ($ryu->valid == '5')
                                        (Valid within 5 days)
                                        @elseif ($ryu->valid == '7')
                                        (Valid within 7 days)
                                        @elseif ($ryu->valid == '15')
                                        (Valid within 15 days)
                                        @elseif ($ryu->valid == '30')
                                        (Valid within 30 days)
                                        @endif
                                    </label>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label class="text-break"><b>Category</b></label>
                                </div>
                                <div>:</div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    <label class="text-break">
                                        <?php
                                            $cr = explode(',', $ryu->id_csc_prod);
                                            $hitung = count($cr);
                                            $semuacat = '';
                                            for ($a = 0; $a < $hitung - 1; $a++) {
                                                $namaprod = DB::select("select * from csc_product where id='" . $cr[$a] . "' ");
                                                foreach ($namaprod as $prod) {
                                                    $napro = $prod->nama_kategori_en;
                                                }
                                                $semuacat = $semuacat . '- ' . $napro . ' ';
                                            
                                                echo $napro . '<br/>';
                                            }
                                            // echo $semuacat;
                                            ?>
                                    </label>
                                </div>
                            </div>

                            <div id="t2">
                                <input type="hidden" name="t2s" id="t2s" value="0">
                            </div>

                            <div id="t3">
                                <input type="hidden" name="t3s" id="t3s" value="0">
                            </div>

                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label class="text-break"><b>Specification</b></label>
                                </div>
                                <div>:</div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    <label class="text-break"> {{ $ryu->spec }}</label>
                                    <textarea readonly style="color:black;display:none;" name="spec" id="spec"
                                        class="form-control"><?php echo $ryu->spec; ?></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12 text-break">
                                    <label class="text-break"><b>Estimated order</b></label>
                                </div>
                                <div>:</div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    {{-- <div class="form-row"> --}}
                                        <label class="text-break">
                                            <?php echo $ryu->eo; ?>
                                            {{ $ryu->neo }}
                                        </label>
                                        <div class="col-sm-7 d-none"><input readonly
                                                style="color:black; text-align: right;" type="hidden"
                                                value="<?php echo ($ryu->eo > 0) ? number_format($ryu->eo, 0, ',', '.') : 0; ?>"
                                                name="eo" id="eo" class="form-control"> </div>
                                        <div class="col-sm-5 d-none"> <select disabled
                                                style="color:black;font-size: 12px; height: 34px !important;"
                                                class="form-control" name="neo" id="neo">
                                                <option value="Dozen" @if ($ryu->neo == 'Dozen')selected @endif>Dozen
                                                </option>
                                                <option value="Grams" @if ($ryu->neo == 'Grams') selected @endif>Grams
                                                </option>
                                                <option value="Kilograms" @if ($ryu->neo == 'Kilograms') selected
                                                    @endif>Kilograms
                                                </option>
                                                <option value="Liters" @if ($ryu->neo == 'Liters') selected
                                                    @endif>Liters</option>
                                                <option value="Meters" @if ($ryu->neo == 'Meters') selected
                                                    @endif>Meters</option>
                                                <option value="Packs" @if ($ryu->neo == 'Packs') selected @endif>Packs
                                                </option>
                                                <option value="Pairs" @if ($ryu->neo == 'Pairs') selected @endif>Pairs
                                                </option>
                                                <option value="Pieces" @if ($ryu->neo == 'Pieces') selected
                                                    @endif>Pieces</option>
                                                <option value="Sets" @if ($ryu->neo == 'Sets') selected @endif>Sets
                                                </option>
                                                <option value="Tons" @if ($ryu->neo == 'Tons') selected @endif>Tons
                                                </option>
                                                <option value="Unit" @if ($ryu->neo == 'Unit') selected @endif>Unit
                                                </option>
                                            </select>
                                        </div>
                                        {{--
                                    </div> --}}


                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12 text-break">
                                    <label class="text-break"><b>Targeted price (FOB)</b></label>
                                </div>
                                <div>
                                    :
                                </div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    <label class="text-break">
                                        <?php echo ($ryu->tp > 0) ? number_format($ryu->tp, 0, ',', '.') : 0; ?>
                                    </label>
                                    <label class="text-break">USD</label>
                                </div>


                            </div>



                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12 text-break">
                                    <label class="text-break"><b>Location of delivery</b></label>
                                </div>
                                <div>:</div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    <?php
                                        $ms2 = DB::select('select id,country from mst_country order by country asc');
                                        ?>
                                    <label class="text-break">
                                        @foreach ($ms2 as $val2)
                                        @if ($ryu->id_mst_country == $val2->id)
                                        {{ $val2->country }}
                                        @endif
                                        @endforeach
                                    </label>

                                    <lable class="text-break">
                                        ({{ $ryu->city }})
                                    </lable>
                                </div>
                                {{-- <div class="form-group col-sm-6"> --}}
                                    <input readonly style="color:black;" type="hidden" value="<?php echo $ryu->city; ?>"
                                        name="city" id="city" class="form-control" placeholder="City/State">
                                    {{--
                                </div> --}}
                            </div>
                            <div class="form-row">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <label class="text-break"> <b>Inquiry Date</b></label>
                                </div>
                                <div>:</div>
                                <div class="col-lg-7 col-md-9 col-sm-11">
                                    <label class="text-break">
                                        <?php echo date('Y-m-d', strtotime($ryu->date)); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="box-body">
                            <table id="example1" border="0" class="table table-striped table-hover">
                                <thead class="text-white" style="background-color: #6B7BD6">
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
                                            $pesan = DB::select("
                                            select
                                                a.*,
                                                b.*,
                                                c.*,
                                                a.email as oemail,
                                                b.id as idb,
                                                a.id as id_user,
                                                d.valid,
                                                d.date,
                                                d.id as id_br
                                            from
                                                itdp_company_users a,
                                                csc_buying_request_join b,
                                                itdp_profil_eks c,
                                                csc_buying_request d
                                            where
                                                a.id = b.id_eks
                                                and a.id_profil = c.id
                                                and id_br='" . $id . "'
                                                and d.id = $id ");
                                            $na = 1;
                                            foreach ($pesan as $ryu) {
                                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $na; ?>
                                        </td>
                                        <td>
                                            <div align="left"><a
                                                    href="{{ url('front_end/list_perusahaan/view', $ryu->id_user) }}-{{ $ryu->company }}"
                                                    target="_blank">
                                                    <?php echo $ryu->company; ?>
                                                </a></div>
                                        </td>
                                        <td>
                                            <div class="text-wrap" style="width:150px">
                                                <?php echo $ryu->addres . ' , ' . $ryu->city; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo $ryu->oemail; ?>
                                        </td>
                                        <td>
                                            <center>
                                                <?php if ($ryu->status_join == null) {
                                                                    echo 'pending';
                                                                } elseif ($ryu->status_join == '1') {
                                                                    echo 'Menunggu Verifikasi';
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
                                                <?php 
                                                $valid_date = \Carbon\Carbon::parse($ryu->date)->addDays($ryu->valid);
                                                $now = \Carbon\Carbon::now();
                                                $compare_date = $valid_date->gt($now);

                                                if($compare_date){?>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-md btn-default btn-send-mail"
                                                    onclick="sendReminderToSupplier({{ $ryu->id_br }}, {{$ryu->id_user }})"
                                                    data-toggle="tooltip" title="Reminder to Supplier"><i
                                                        class="fa fa-bell"></i></a>
                                                <?php } ?>
                                                <?php if ($ryu->status_join == 1) { ?>
                                                <a href="{{ url('br_konfirm2/' . encrypt($ryu->idb) . '/' . encrypt($id)) }}"
                                                    class="btn btn-success" title="Verifikasi"><i
                                                        class="fa fa-check"></i></a>
                                                <?php } else if ($ryu->status_join == 2) { ?>
                                                <a href="{{ url('br_pw_chat/' . encrypt($ryu->idb)) }}"
                                                    class="btn btn-info" title="Chat"><i class="fa fa-comment"></i></a>
                                                <?php } else if ($ryu->status_join == 4) { ?>
                                                <a href="{{ url('br_pw_chat/' . encrypt($ryu->idb)) }}"
                                                    class="btn btn-success" title="View"><i class="fa fa-list"></i></a>
                                                <?php } ?>
                                            </center>
                                        </td>
                                    </tr>
                                    <?php $na++;
                                            } ?>
                                </tbody>
                            </table>

                            <br>

                            <div class="col-sm-12">
                                <div align="left">
                                    <a href="{{ url('br_list') }}" class="btn btn-md btn-danger"><i
                                            class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function sendReminderToSupplier(id_br, id_user){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Send mail to reminder supplier",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = "{{ url('/send_mail_reminder_supplier') }}/" + id_br + '/' + id_user;

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: 'json',
                            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to
                                Swal.fire({
                                    title: 'Please Wait...',
                                    html: '<div class="loader"></div>',
                                    allowOutsideClick: false,
                                    showConfirmButton: false
                                });
                            },
                            success: function (data) {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: data.message,
                                    });
                                } else{
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Oops...',
                                        text: data.message,
                                    });
                                }
                            } 
                        });
                    }
                })
            } 
        </script>
        @include('footer')
        @endsection