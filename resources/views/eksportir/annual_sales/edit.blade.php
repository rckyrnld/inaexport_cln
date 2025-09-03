@extends('header2')
@section('content')
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

        .rightbtn {
            float: left;
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
            height: 45px !important;
        }

        input.input-error {
            color: #ff0000;
            border: 1px solid #ff0000;
            box-shadow: 0 0 5px #ff0000;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ url($url) }}">
                {{ csrf_field() }}
                <div class="card">
                    @foreach ($data as $val)
                        <div class="card-header border-bottom">
                            <h3 class="mb-0">Edit Penjualan</h3>
                        </div>
                        <div class="card-body">
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
                            <div class="form-row">
                                <div class="form-group col-sm-3 mb-2">
                                    <label><b>Year</b></label>
                                    <select class="atc form-control select2" required id="year" name="year">
                                        <option value="">- Select Years -</option>
                                        @foreach ($years as $sa)
                                            <option value="{{ $sa }}"
                                                {{ $val->tahun == $sa ? 'selected' : '' }}>
                                                {{ $sa }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" value="{{ $val->id }}" name="id_sales" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3 mb-2">
                                    <label><b>Value (USD)</b></label>
                                    <input type="text"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        class="form-control rupiah" value="{{ $val->nilai }}" name="value" id="value" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3 mb-2">
                                    <label><b>Persen (%)</b></label>
                                    <input onkeyup="sum();" type="text"
                                        class="form-control amount" value="{{ str_replace(".",",",$val->nilai_persen) }}" name="persen" id="persen">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3 mb-2">
                                    <label><b>Nilai Ekspor (USD)</b></label>
                                    <input readonly type="text"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        class="form-control rupiah" value="{{ $val->nilai_ekspor }}" name="nilai_ekspor"
                                        id="nilai_ekspor" required>
                                </div>
                            </div>
                            

                            <div class="form-row rightbtn">
                                <div class="form-group col-sm-12">
                                    <a style="color: white" href="{{ url('/eksportir/annual_sales') }}"
                                        class="btn btn-primary"><i style="color: white"></i>
                                        Back
                                    </a>
                                    <button class="btn btn-success" type="submit">Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
    </div>

    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

    <script>

        $('.rupiah').inputmask({
            alias: "decimal",
            digits: 0,
            repeat: 36,
            digitsOptional: false,
            decimalProtect: true,
            groupSeparator: ".",
            placeholder: '0',
            radixPoint: ",",
            radixFocus: true,
            autoGroup: true,
            autoUnmask: false,
            onBeforeMask: function(value, opts) {
                return value;
            },
            removeMaskOnSubmit: true
        });

        $('.amount').inputmask({
            alias: "decimal",
            digits: 2,
            repeat: 3,
            digitsOptional: false,
            decimalProtect: true,
            groupSeparator: ".",
            placeholder: '0',
            radixPoint: ",",
            radixFocus: true,
            autoGroup: true,
            autoUnmask: false,
            onBeforeMask: function(value, opts) {
                return value;
            },
            removeMaskOnSubmit: true
        });

        function sum() {
            var txtFirstPersenValue = $('#persen').val().replace(',','.');
            var txtFirstNumberValue = $('#value').val().replace('.','');
            var result = (txtFirstPersenValue * txtFirstNumberValue) /100;
            console.log(result);
            if (!isNaN(result)) {
                $('#nilai_ekspor').val(result.toString().replace('.', ','));
            }
        }

        $("#persen").keyup(function(){
        var persen = $('#persen').val().replace(',','.');
        var max = 100;
        if(persen > max){
            $('#persen').addClass('input-error');
            $("#btnSubmit").attr("type","button");
            $("#btnSubmit").attr("onclick","notifAlert()");
        }else{
            $('#persen').removeClass('input-error');
            $("#btnSubmit").attr("type","submit");
            $("#btnSubmit").attr("onclick","");
        }
    })

    function notifAlert(){
        alert('Percent Melebihi 100');
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
                $.get('{{ url('getem') }}/' + uname, function(data) {
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

                $.get('{{ URL::to('getkab') }}/' + id, function(data) {
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


    @include('footer')

@endsection
