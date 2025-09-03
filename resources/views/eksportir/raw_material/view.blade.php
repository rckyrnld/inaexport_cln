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
    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 35px !important;
    }
    .custom-select, .custom-file-control, .custom-file-control:before, select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
        height: 33px !important;
    }

</style>
<!-- Page content -->
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
        <div class="col-md-12">
            {{ csrf_field() }}
            <div class="card">
                @foreach($data as $val)
                    <div class="card-header border-bottom">
                        <h3 class="mb-0">View Bahan Baku</h3>
                    </div>
                    <div class="box-divider m-0"></div>
                    <div class="box-body">

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Year</b></label>
                                <select disabled class="atc form-control select2" required id="year"
                                        name="year">
                                    <option value="">- Select Years -</option>
                                    @foreach($years as $sa)
                                        <option value="{{$sa}}" {{($val->tahun == $sa)?'selected':''}}>{{$sa}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Domestic</b></label>
                                <input disabled type="text" value="{{str_replace(".", ",",$val->lokal_persen)}}"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control amount" name="domestic">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Overseas</b></label>
                                <input disabled type="text" value="{{ str_replace(".", ",",$val->impor_persen)}}"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control amount" name="overseas">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Value From Domestic</b></label>
                                <input disabled type="text" value="{{ str_replace(".", ",", $val->nilai_impor)}}"
                                class="form-control rupiah" name="valuefromdomestic">
                            </div>
                        </div>

                        <div class="form-row rightbtn">
                            <div class="form-group col-sm-12">
                                <a style="color: white" href="{{ URL::previous() }}" class="btn btn-danger"><i
                                        style="color: white"></i>
                                    Back
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
            {{--            </form>--}}
        </div>
    </div>
{{-- </div> --}}
@include('footer')
<script type="text/javascript">
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
@endsection