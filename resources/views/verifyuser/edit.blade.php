@include('header')
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            
                <div class="box">
                    @foreach($data as $val)
                        <div class="box-divider m-0"></div>
                        <div class="box-body">
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label><b>Username</b></label>
                                    <input type="text" value="{{$val->username}}" name="year" id="year"
                                           class="form-control" readonly>
                                   
                                </div>

                                <div class="form-group col-sm-6">
                                    <label><b>Email</b></label>
                                    <input type="text" class="form-control" value="{{$val->email}}" name="value"
                                           id="value" required readonly>
                                </div>
                            </div>
							
							 <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label><b>Konfirmasi Email</b></label>
                                    <input type="text" value="<?php if($val->agree == 1){ echo "Sudah";}else{ echo "Belum";};?>" name="year" id="year"
                                           class="form-control" readonly>
                                   
                                </div>

                                <div class="form-group col-sm-6">
                                    <label><b>Role</b></label>
                                    <input type="text" class="form-control" value="<?php 
									$cari1 = DB::select("select * from public.group where id_group='".$val->id_role."'");
									foreach($cari1 as $cr1){ echo $cr1->group_name; }
									?>" name="value"
                                           id="value" required readonly>
                                </div>
                            </div>
                            
                           

                            <div class="form-row">
                                <div class="form-group col-sm-6">

                                </div>
                                <div class="form-group col-sm-6" align="right">
                                    <a style="color: white" href="{{url('/verifyuser')}}"
                                       class="btn btn-primary"><i style="color: white"></i>
                                        Kembali
                                    </a>
                                    <a href="{{url('saveverify/'.$val->id)}}" class="btn btn-success" type="submit"><i
                                                class="fa fa-plus-circle"></i> Verifikasi
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
           
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
