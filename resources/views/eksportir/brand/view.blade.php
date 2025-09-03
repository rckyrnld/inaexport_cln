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
        background-color: #148de4;
    }

    #export {
        background-color: #28bd4a;
        color: white;
        white-space: pre;
    }

    #export:hover {
        background-color: #08b32e;
    }
    .select2-container .select2-selection--single {
		box-sizing: border-box;
		cursor: pointer;
		display: block;
		height: 35px !important;
	}
	.custom-select, .custom-file-control, .custom-file-control:before, select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
		height: 45px !important;
	}

</style>
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    <div class="col">
    {{ csrf_field() }}
        <div class="card">
        @foreach($data as $val)
            <div class="card-header border-bottom">
                <h3 class="mb-0">View Merek</h3>
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-sm-3 mb-2">
                        <label><b>Brand</b></label>
                        <input type="text" name="brand" value="{{ $val->merek }}" disabled id="brand"
                            class="form-control">
                        <input type="hidden" name="id_sales" value="{{ $val->id }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-3 mb-2">
                        <label><b>Meaning of Brand</b></label>
                        <input type="text" class="form-control" disabled value="{{ $val->arti_merek }}"
                            name="arti_brand" id="arti_brand" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-3 mb-2">
                        <label for="bulan"><b>Month</b></label>
                        <select disabled class="form-control select2"  id="bulan" name="bulan">
                            <option value="00">--Select Month--</option>
                            <option value="01" {{($val->bulan_merek == '01')?'selected':''}}>January</option>
                            <option value="02" {{($val->bulan_merek == '02')?'selected':''}}>February</option>
                            <option value="03" {{($val->bulan_merek == '03')?'selected':''}}>March</option>
                            <option value="04" {{($val->bulan_merek == '04')?'selected':''}}>April</option>
                            <option value="05" {{($val->bulan_merek == '05')?'selected':''}}>May</option>
                            <option value="06" {{($val->bulan_merek == '06')?'selected':''}}>June</option>
                            <option value="07" {{($val->bulan_merek == '07')?'selected':''}}>July</option>
                            <option value="08" {{($val->bulan_merek == '08')?'selected':''}}>August</option>
                            <option value="09" {{($val->bulan_merek == '09')?'selected':''}}>September</option>
                            <option value="10" {{($val->bulan_merek == '10')?'selected':''}}>October</option>
                            <option value="12" {{($val->bulan_merek == '11')?'selected':''}}>November</option>
                            <option value="12" {{($val->bulan_merek == '12')?'selected':''}}>December</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-3 mb-2">
                        <label><b>Year</b></label>
                        <input type="text" class="form-control" disabled value="{{$val->tahun_merek}}" name="year"
                                id="year" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-3 mb-2">
                        <label><b>Copyright Number</b></label>
                        <input type="text" class="form-control" disabled value="{{ $val->paten_merek }}"
                        name="copyright_number" id="copyright_number">
                    </div>
                </div>


                <div class="form-row " >
                    
                    <div class="form-group col-sm-6">
                        <a style="color: white" href="{{ URL::previous() }}"
                            class="btn btn-danger float-left"><i style="color: white"></i>
                            Back
                        </a>

                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
        $('#STAT').on('change', function () {
            var val = $('#STAT').val().split("|");
            var nama = val[0];
            var instansi = val[1];
            // alert(gambar);
            $('#institusi').val(instansi);

        });
        $('#tanggal_registrasi').val(new Date().toDateInputValue());
        $("#email").keyup(function () {
            var uname = $("#email").val();
            // alert(uname);
            $.get('{{url("getem")}}/' + uname, function (data) {
                console.log(data);
                if (data == 0) {
                    $('#cekl').html("<font color='green'>Tersedia</font>");
                } else {
                    $('#cekl').html("<font color='red'>Telah digunakan</font>");
                }
                // $('#alot').html(data);
            });
        });
        $('#provinsiku').on('change', function () {
            var json = null;
            var id = this.value;

            $.get('{{URL::to("getkab")}}/' + id, function (data) {
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
        $("#confirm_password").keyup(function () {
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
    Date.prototype.toDateInputValue = (function () {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#tgl_mulai_berlaku").change(function () {
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

    $("#tipe_keanggotaan").change(function () {
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

    $("#imgInp").change(function () {
        readURL(this);
    });
</script>

@include('footer')

@endsection