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

        .form-group{
        margin-bottom:0.2rem;
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
                            <h3 class="mb-0">View Kapasitas Produk</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-sm-3 sm-2">
                                    <label><b>Year</b></label>
                                    <input type="text" disabled value="{{$val->tahun}}" name="tahun" id="tahun"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3 sm-2">
                                    <label><b>Own Production (%)</b></label>
                                    <input type="text" class="form-control" disabled value="{{$val->sendiri_persen}}"
                                           name="persen_sendiri" id="persen_sendiri" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3 sm-2">
                                    <label><b>Outside Production (%)</b></label>
                                    <input type="text" disabled class="form-control" value="{{$val->outsourcing_persen}}"
                                           name="out_persen" id="out_persen">
                                    <input type="hidden" class="form-control" value="{{$val->id}}" name="id_sales"
                                           id="id_sales">
                                </div>
                                <div class="form-group col-sm-6">
    
                                </div>
                            </div>
    
                            <div class="form-row">
                                <div class="form-group col-sm-6">
    
                                </div>
                                <div class="form-group col-sm-6">
    
                                </div>
                            </div>
    
                            <div class="form-row">
                                <div class="form-group col-sm-3 sm-2">
                                    <a style="color: white" href="{{ URL::previous() }}"
                                       class="btn btn-danger pull-left"><i style="color: white"></i>
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
