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

        .rightbtn {
            float: left;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            {{ csrf_field() }}
            <div class="card">
                @foreach ($data as $val)
                    <div class="card-header border-bottom">
                        <h3 class="mb-0">View Contact</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Name</b></label>
                                <input type="text" disabled value="{{ $val->name }}" name="name" id="name"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Position</b></label>
                                <input type="text" disabled class="form-control" value="{{ $val->job_title }}"
                                    name="position" id="position" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Phone</b></label>
                                <input type="text" disabled class="form-control" value="{{ $val->phone }}" name="phone"
                                    id="phone">
                                <input type="hidden" class="form-control" value="{{ $val->id }}" name="id_sales"
                                    id="id_sales">
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
        </div>
    </div>

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
