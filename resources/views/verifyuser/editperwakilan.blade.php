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
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-bottom">
                <h3 class="mb-0">Form Representative</h3>
            </div>
            <div class="card-body">

                {{ Form::open(['url' => 'updateperwakilan', 'method' => 'post']) }}
                <?php 
				$qe = DB::select("select * from itdp_admin_users where id='".$id."'");
				foreach($qe as $eq){
				if($eq->type == "DINAS PERDAGANGAN"){
                    $tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and a.id='".$id."' ");
				}else{
					$tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_ln b where a.id_admin_ln = b.id and a.id='".$id."' ");
				}
                $id_country = '';
				foreach($tq as $qt){
                    $id_country = $qt->id_country;
				?>

                <input type="hidden" value="{{ $id }}" name="ida">
                <input type="hidden" value="{{ $qt->idb }}" name="idb">

                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Type', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <select style="height:150%" class="form-control" id="type" name="type" required
                            onchange="gantikota()"></select>
                        </select>
                    </div>
                </div>

                <?php if($qt->type=="DINAS PERDAGANGAN"){ ?>
                <div id=ch1></div>
                <div id="ch6"></div>
                <div id="ch7"></div>

                <?php } else { ?>
                <div id=ch1></div>
                <div id=ch2></div>




                @if ($qt->country_tambahan != '')
                <div class="control-group after-add-more" id="ch5">
                    <div class="form row">
                        <div class="col-md-1"></div>
                        <label for="password_confirm" class="col-sm-2 col-form-label">Main Country</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" onchange="ambilCountry();" id="country" name="country"
                                required>
                                <option disabled value="">-- Choose Country --</option>
                                @foreach ($country as $cu)
                                <option value="{{ $cu->id }}" {{ $qt->country == $cu->id ? 'selected="selected"' : ''
                                    }}>{{ $cu->country }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i>
                            Add</button>
                        <div class="checkbox">
                            <input style="margin-top:15px" type="checkbox" id="country_utama" name="country_utama"
                                value="" checked> Country Utama
                            <input type="hidden" class="form-control countKota" name="main_country_id"
                                value="main_country_id" readonly>
                        </div>
                    </div>
                </div>


                <?php
				$country_pecah2 = explode(',', $qt->country_tambahan);
				foreach ($country_pecah2 as $key => $cp2) {
				?>
                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Country', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <input type="hidden" class="form-control countKota" name="country_id_arr[]" value={{
                            $qt->country_tambahan }}>
                        <select class="form-control" id="country" name="country_arr[]">
                            @foreach ($country as $cu)
                            <option value="{{ $cu->id }}" {{ $cp2==$cu->id ? 'selected="selected"' : '' }}>{{
                                $cu->country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i>
                        Remove</button>
                </div>

                <?php } ?>
                @else
                <div class="control-group after-add-more" id="ch5">
                    <div class="form row">
                        <div class="col-md-1"></div>
                        <label for="password_confirm" class="col-sm-2 col-form-label">Main Country</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" onchange="ambilCountry();" id="country" name="country"
                                required>
                                <option disabled value="">-- Choose Country --</option>
                                @foreach ($country as $cu)
                                <option value="{{ $cu->id }}" {{ $qt->country == $cu->id ? 'selected="selected"' : ''
                                    }}>{{ $cu->country }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i>
                            Add</button>
                        <div class="checkbox">
                            <input style="margin-top:15px" type="checkbox" id="country_utama" name="country_utama"
                                value="" checked> Country Utama
                            <input type="hidden" class="form-control countKota" name="main_country_id"
                                value="main_country_id" readonly>
                        </div>
                    </div>
                </div>


                @endif

                <div id="div_country"></div>


                <div class="form row" id="ch3">
                    <div class="col-md-1"></div>
                    <label for="password_confirm" class="col-sm-2 col-form-label ">City</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="city" name="city">
                            @if ($qt->city == '')
                            <option value="" selected="selected">-- Choose City --</option>
                            @foreach ($city as $ci)
                            <option value="{{ $ci->id }}">{{
                                $ci->city }}
                            </option>
                            @endforeach
                            @else
                            @foreach ($city as $ci)
                            <option value="{{ $ci->id }}" {{ $qt->city == $ci->id ? 'selected="selected"' : '' }}>{{
                                $ci->city }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <?php } ?>

                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Email', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="email" value="{{ $eq->email }}" required>
                    </div>
                </div>

                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Nama', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="nama" value="{{ $qt->nama }}" required>
                    </div>
                </div>

                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Jabatan', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="kepala" value="{{ $qt->kepala }}" required>
                    </div>
                </div>

                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Telepon', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="phone" value="{{ $qt->telp }}" required>
                    </div>
                </div>

                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Nama Kantor', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="username" value="{{ $qt->username }}">
                        <input type="hidden" class="form-control" name="pejabat" value="{{ $qt->nama }}" required>
                    </div>
                </div>

                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Website', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="web" value="{{ $qt->website }}" required>
                    </div>
                </div>

                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Password', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="password">
                        <span>
                            <font color="red">Alert ! Dont fill it, if dont want password change !</font>
                        </span>
                    </div>
                </div>

                <div class="form row">
                    <div class="col-md-1"></div>
                    {!! Form::label('password_confirm', 'Status', ['class' => 'col-sm-2 col-form-label ']) !!}
                    <div class="col-sm-6">
                        <select class="form-control" name="status" required>
                            <option value="">-- Choose Status --</option>
                            <option <?php if ($qt->status == 1) {
                                echo 'selected';
                                } ?> value="1">Aktif</option>
                            <option <?php if ($qt->status == 0) {
                                echo 'selected';
                                } ?> value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div align="right" style="margin-right:310px">
                    <a class="btn btn-danger" href="{{ URL::previous() }}">Cancel</a>
                    <input class="btn btn-primary" type="submit" value=" Update">
                </div>
                <?php } } ?>
                <input type="hidden" id="country_utama_hidden" value="{{ isset($qt->country) ? $qt->country : '' }}">
                @php
                $country_tambahan = '';
                if(isset($qt->country_tambahan) && $qt->country_tambahan == ''){
                if(isset($qt->country)){
                $country_tambahan = $qt->country;

                }else{
                $country_tambahan = $qt->id_country;

                }
                }else{
                if(isset($qt->country)){
                $country_tambahan = $qt->country.','.$qt->country_tambahan;
                }else{
                $country_tambahan = '';

                }
                }
                @endphp
                <input type="hidden" id="country_id_add" value="{{ $country_tambahan }}">
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
</div>
</div>

@include('footer')

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
            @isset($id)
                var type = "{{ $eq->type }}";
                if (type != null) {
                $.ajax({
                type: 'GET',
                url: "{{ route('admin.perwakilan.type') }}",
                data: { code: type }
                }).then(function (data) {
                var option = new Option( data[0].type, data[0].type, true, true);
                $('#type').append(option).trigger('change');
                });
                }
            @endisset

            $(".add-more").click(function() {
                var country = $('#country').find("option:selected").text();
                var country_id = $('#country').val();
                var html = '';
                html += '<div class="form row">';
                html += '<div class="col-md-3"></div>';
                html += '<div class="col-sm-6">';
                html +=
                    '<input type="hidden" class="form-control countKota" name="country_id_arr[]" value="' +
                    country_id + '" readonly>';
                html += '<input type="text" class="form-control" name="country_arr[]" value="' + country +
                    '" readonly>';
                html += '</div>';
                html +=
                    '<button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
                html += '</div>';

                $("#div_country").append(html);
            });

            $("body").on("click", ".remove", function() {
                $(this).parents(".form-group").remove();
            });

        })

        function gantikota() {
            var a = $('#type').val();
            if (a == 'DINAS PERDAGANGAN') {
                $('#ch1').html(
                    '<div class="form row">' +
                    '<div class="col-md-1"></div>' +
                    '<label for="password_confirm" class="col-sm-2 col-form-label placeholder="-- Choose Province --"">Province</label>' +
                    '<div class="col-sm-6"><select class="form-control select2" name="province" ><option disabled value="">-- Choose Province --</option>' +
                    '<?php $mst = DB::select("select * from mst_province order by province_en asc");foreach($mst as $cu){?><option <?php if ($id_country == $cu->id) { echo "selected" ; } ?> value="<?php echo $cu->id; ?>"><?php echo $cu->province_en; ?></option><?php } ?>' +
                    '</select></div></div></div>');

                    $('#ch2').html('');
				    $('#ch3').html('');
				    $('#ch4').html('');
				    $('#ch5').html('');
            } else {
                $('#ch1').html(
                    '<div class="form row" id="ch4">' +
                    '<div class="col-md-1"></div>' +
                    '<label for="password_confirm" class = "col-sm-2 col-form-label ">Benua</label>' +
                    '<div class="col-sm-6" >' +
                    '<select class="form-control select2" id="benua" name="benua" required>' +
                    '<option value=""></option>' +
                    @foreach ($benua as $be)
                    '<option <?php if ($id_country == $be->id) { echo 'selected'; } ?> value="{{ $be->id }}">{{ $be->group_country }}</option>'+
                    @endforeach '</select>' +
                    '</div>' +
                    '</div>');
            }
        }

        // function ambilBenua(value){
        // 	var benua = $('#benua').val();
        // 	var html = '';
        // 	$.get("{{ route('tambah.perwakilan.getBenua') }}",{benua:benua}, function( res ) {
        // 		var data = JSON.parse(res);
        // 			html += '<div class="control-group after-add-more">';
        // 			html +='<div class="form row">';
        // 			html +='<div class="col-md-1"></div>';
        // 			html +='<label for="password_confirm" class="col-sm-2 col-form-label">Country</label>';
        // 			html +='<div class="col-sm-7">';
        // 			html +='<select class="form-control select2" onchange="ambilCountry();" id="country" name="country" required>';
        // 			html +='<option disabled value="">-- Choose Country --</option>';
        // 			$.each(data, function(i, value){
        // 			html +='<option value="'+value.id+'">'+value.country+'</option>';
        // 					});
        // 			html +='</select>';
        // 			html +='</div>';
        // 			html +='<button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>';
        // 			html +='</div>';
        // 			html +='</div>';

        // 		$('#ch2').html(html);


        // 	});
        // }

        // function ambilCountry(value){
        // 	var country = $('#country_utama_hidden').val();

        // 	var html = '';
        // 	$.get("{{ route('tambah.perwakilan.getCountry') }}",{country:country}, function( res ) {
        // 		var data = JSON.parse(res);
        // 			html +='<div class="form row">';
        // 			html +='<div class="col-md-1"></div>';
        // 			html +='<label for="password_confirm" class="col-sm-2 col-form-label">City</label>';
        // 			html +='<div class="col-sm-7">';
        // 			html +='<select class="form-control select2" id="city" name="city">';
        // 			html +='<option value="">-- Choose City --</option>';
        // 			$.each(data, function(i, value){
        // 			html +='<option value="'+value.id+'">'+value.city+'</option>';
        // 					});
        // 			html +='</select>';
        // 			html +='</div>';
        // 			html +='</div>';

        // 		$('#ch3').html(html);
        // 	});
        // }

        $('body').on('change', '#benua', function () {
            var benua = $('#benua').val();
            var html = '';
            $.get("{{ route('tambah.perwakilan.getBenua') }}", {
                benua: benua
            }, function(res) {
                var data = JSON.parse(res);
                html += '<div class="control-group after-add-more" id="ch5">';
                html += '<div class="form row">';
                html += '<div class="col-md-1"></div>';
                html += '<label for="password_confirm" class="col-sm-2 col-form-label">Main Country</label>';
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

                $('.after-add-more').html(html);
                $('#ch6').html(html);

                $(".add-more").click(function() {
                    var country = $('#country').find("option:selected").text();
                    var country_id = $('#country').val();

                    console.log($("#country_utama_hidden").val())

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
                });

            });
        })

        

        function ambilCountry(value) {
           
			var	country = $('#country').val();
            
            var html = '';
            var html2 = '';
            $.get("{{ route('tambah.perwakilan.getCountry') }}", {
                country: country
            }, function(res) {
                var data = JSON.parse(res);
                console.log(data)
              
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


                html2 += '<div class="form row">';
                html2 += '<div class="col-md-1"></div>';
                html2 += '<label for="password_confirm" class="col-sm-2 col-form-label">City</label>';
                html2 += '<div class="col-sm-6">';
                html2 += '<select class="form-control select2" id="city" name="city">';
                html2 += '<option value="">-- Choose City --</option>';
                $.each(data, function(i, value) {
                    html2 += '<option value="' + value.id + '">' + value.city + '</option>';
                });
                html2 += '</select>';
                html2 += '</div>';
                html2 += '</div>';

                $('#ch3').html(html);
                $('#ch7').html(html2);
            });
        }

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
        });

        $(".add-more").click(function() {
            var country_id = $('#country').val();
            var array_country_selected = $('#country_id_add').val().split(',');

            if (array_country_selected.includes(country_id) && country_id != '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Duplicate country is not allowed',
                })
                return false;
            }
        });

        $(".add-more").click(function() {
            var country = $('#country').find("option:selected").text();
            var country_id = $('#country').val();

            console.log($("#country_utama_hidden").val())

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

</script>
@endsection