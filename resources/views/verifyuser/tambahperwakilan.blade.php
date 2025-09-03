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
        height: 35px !important;
    }

</style>

@extends('header2')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css" rel="stylesheet">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Add Representative</h3>
                </div>
                <div class="card-body">
                    {{ Form::open(['url' => 'simpanperwakilan', 'method' => 'post']) }}
                    <div class="form row">
                        <div class="col-md-1"></div>
                        {!! Form::label('password_confirm', 'Type', ['class' => 'col-sm-2 col-form-label ']) !!}
                        <div class="col-sm-6">
                            <select style="height:150%" class="form-control" id="type" name="type" onchange="gantikota()"
                                required></select>
                            </select>
                        </div>
                    </div>

                    <div id="ch1"></div>
                    <div id="ch2"></div>
                    <div id="div_country"></div>
                    <div id="ch3"></div>

                    <div class="form row">
                        <div class="col-md-1"></div>
                        {!! Form::label('password_confirm', 'Email', ['class' => 'col-sm-2 col-form-label ']) !!}
                        <div class="col-sm-6">
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-md-1"></div>
                        {!! Form::label('password_confirm', 'Nama', ['class' => 'col-sm-2 col-form-label ']) !!}
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-md-1"></div>
                        {!! Form::label('password_confirm', 'Jabatan', ['class' => 'col-sm-2 col-form-label ']) !!}
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="kepala" required>
                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-md-1"></div>
                        {!! Form::label('password_confirm', 'Telp', ['class' => 'col-sm-2 col-form-label ']) !!}
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-md-1"></div>
                        {!! Form::label('password_confirm', 'Nama Kantor', ['class' => 'col-sm-2 col-form-label ']) !!}
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="username" required>
                            <input type="hidden" class="form-control" name="pejabat" required>
                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-md-1"></div>
                        {!! Form::label('password_confirm', 'Website', ['class' => 'col-sm-2 col-form-label ']) !!}
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="web" required>
                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-md-1"></div>
                        {!! Form::label('password_confirm', 'Password', ['class' => 'col-sm-2 col-form-label ']) !!}
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-md-1"></div>
                        {!! Form::label('password_confirm', 'Status', ['class' => 'col-sm-2 col-form-label ']) !!}
                        <div class="col-sm-6">
                            <select class="form-control" name="status" required>
                                <option value="">-- Choose Status --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-lg-3 col-lg-6 text-right pt-1">
                            <a class="btn btn-danger" href="{{ URL::previous() }}">Cancel</a>
                            <input class="btn btn-primary" type="submit" value=" Submit">

                        </div>
                    </div>
                    <input type="hidden" id="country_utama_hidden">
                    <input type="hidden" id="country_id_add">

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    @include('footer')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#type').select2({
                allowClear: true,
                placeholder: 'Select Type',
                ajax: {
                    url: "{{ route('admin.perwakilan.type') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.type,
                                    id: item.type,
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        })

        function gantikota() {
            var a = $('#type').val();
            if (a == 'DINAS PERDAGANGAN') {
                $('#ch1').html(
                    '<div class="form row">'+
                    '<div class="col-md-1"></div>'+
                    '<label for="password_confirm" class="col-sm-2 col-form-label placeholder="-- Choose Province --"">Province</label>'+
                    '<div class="col-sm-6"><select class="form-control select2" name="province" ><option disabled value="">-- Choose Province --</option>'+
                    '<?php $mst = DB::select("select * from mst_province order by province_en asc");foreach($mst as $cu){?><option value="<?php echo $cu->id; ?>"><?php echo $cu->province_en; ?></option><?php } ?></select></div></div></div>'
                )

				$('#ch2').html('');
				$('#ch3').html('');

            } else {
                $('#ch1').html(
                    '<div class="form row">' +
                    '<div class="col-md-1"></div>' +
                    '<label for="password_confirm" class = "col-sm-2 col-form-label ">Benua</label>' +
                    '<div class="col-sm-6" >' +
                    '<select class="form-control select2" onchange="ambilBenua();" id="benua" name="benua" required>' +
                    '<option value="">-- Choose Benua --</option>' +
                    @foreach ($benua as $be)
                        '<option value="{{ $be->id }}">{{ $be->group_country }}</option>'+
                    @endforeach '</select>' +
                    '</div>' +
                    '</div>');
            }
        }

        function ambilBenua(value) {
            var benua = $('#benua').val();

            var html = '';
            $.get("{{ route('tambah.perwakilan.getBenua') }}", {
                benua: benua
            }, function(res) {
                var data = JSON.parse(res);
                html += '<div class="control-group after-add-more">';
                html += '<div class="form row">';
                html += '<div class="col-md-1"></div>';
                html += '<label for="password_confirm" class="col-sm-2 col-form-label">Country</label>';
                html += '<div class="col-sm-6">';
                html +=
                    '<select class="form-control select2" onchange="ambilCountry()" id="country" name="country" required>';
                html += '<option value="">-- Choose Country --</option>';
                $.each(data, function(i, value) {
                    html += '<option value="' + value.id + '">' + value.country + '</option>';
                });
                html += '</select>';
                html += '</div>';
                html +=
                    '<button class="btn btn-success add-more" type="button" ><i class="glyphicon glyphicon-plus"></i> Add</button>';
                html += '<div class="checkbox">';
                html +=
                    '<input style="margin-top:15px" type="checkbox" id="country_utama" name="country_utama" value="" checked> Country Utama';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#ch2').html(html);

                $(".add-more").click(function() {
                    var country = $('#country').find("option:selected").text();
                    var country_id = $('#country').val();

                    let error = false;

                    // cek country yang sama
                    var array_country_selected = $('#country_id_add').val().split(',');
                  
                    if(country_id == ''){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Select at least one country',
                        })
                        return false;
                    }

                    if (array_country_selected.includes(country_id) && country_id != '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Duplicate country is not allowed',
                        })
                        return false;
                    }
                    

                    //cek country utama yang lebih dari satu
                    if ($("#country_utama").is(':checked')) {

                        if ($("#country_utama_hidden").val() == '') {
                            var country_utama = "(main country)";

                            // console.log('bebek')
                            if (error == false) {
                                $("#country_utama_hidden").val(country_id)
                            }

                        } else {
                            error = true;
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Only one main country is allowed',
                            })
                            return false;
                        }

                    } else {
                        var country_utama = "";
                    }

                    $("#country_id_add").val(function(i, val) {
                        return val + (!val ? '' : ',') + country_id
                    })

                    var main_country_id = $("#country_utama_hidden").val();

                    var html = '';
                    html += '<div class="form row">';
                    html += '<div class="col-md-3"></div>';
                    html += '<div class="col-sm-6">';
                    html +=
                        '<input type="hidden" class="form-control countKota" name="country_id_arr[]" value="' +
                        country_id + '" readonly>';
                    html += '<input type="text" class="form-control" name="country_arr[]" value="' +
                        country + ' ' + country_utama + '" readonly>';
                    html +=
                        '<input type="hidden" class="form-control countKota" name="main_country_id" value="' +
                        main_country_id + '" readonly>';
                    html += '</div>';
                    html += '<button class="btn btn-danger remove" type="button" data-country="' +
                        country_id + '"><i class="glyphicon glyphicon-remove"></i>Remove</button>';
                    html += '</div>';

                    $("#div_country").append(html);

                });

                $("body").on("click", ".remove", function() {
                    $(this).parents(".form").remove();
                    var country_hidden = $("#country_utama_hidden").val()
                    var country_remove = $(this).data('country');
                    if (country_hidden == country_remove) {
                        $("#country_utama_hidden").val('') // remove value country_utama_hidden
                    }
                    // remove value country on input country_id_add
                    let array_country_id_add = $('#country_id_add').val().split(',');
                    var filtered_country_id_add = array_country_id_add.filter(function(value, index, arr) {
                        return value != country_remove;
                    });
                    $('#country_id_add').val(filtered_country_id_add.join())

                    if( $("#country_id_add").val() == ''){
                        $('#country').val('').change();
                    }
                });

            });
        }

        function ambilCountry(value) {
            var country = $('#country_utama_hidden').val();

			if(country == ''){
				country = $('#country').val();
			}

            var html = '';
            $.get("{{ route('tambah.perwakilan.getCountry') }}", {
                country: country
            }, function(res) {
                var data = JSON.parse(res);
                html += '<div class="form row">';
                html += '<div class="col-md-1"></div>';
                html += '<label for="password_confirm" class="col-sm-2 col-form-label">City</label>';
                html += '<div class="col-sm-6">';
                html += '<select class="form-control select2" id="city" name="city">';
                html += '<option value="">-- Choose City --</option>';
                $.each(data, function(i, value) {
                    html += '<option value="' + value.id + '">' + value.city + '</option>';
                });
                html += '</select>';
                html += '</div>';
                html += '</div>';

                $('#ch3').html(html);
            });
        }
    </script>
@endsection
