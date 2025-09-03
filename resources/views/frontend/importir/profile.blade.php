@include('frontend.layouts.header_table')
<?php
$loc = app()->getLocale();
$img1 = 'front/assets/icon/icon account.png';
if ($profile->foto_profil != null) {
    $imge1 = 'uploads/Profile/Importir/' . $id_user . '/' . $profile->foto_profil;
    if (file_exists($imge1)) {
        $img1 = 'uploads/Profile/Importir/' . $id_user . '/' . $profile->foto_profil;
    }
}
?>
<style type="text/css">
    .btn.navigasi.active {
        background-color: #1a70bb !important;
        border-color: #f5f5f5 !important;
        color: #f5f5f5 !important;
    }

    .btn.navigasi {
        background-color: #f5f5f5 !important;
        border-color: #1a70bb !important;
        color: #1a70bb !important;
    }

    input.form-control,
    select.form-control {
        background-color: white;
    }

    .btn-file {
        position: relative;
        overflow: hidden;
        text-align: center;
        width: 100%;
        background-color: #2492eb;
        font-weight: 600;
        color: #f5f5f5;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        cursor: inherit;
        display: block;
    }

    span.logo {
        margin-left: 10px;
        font-size: 14px;
        font-weight: 700;
        color: #1a70bb
    }

    span.logo1 {
        margin-left: 10px;
        font-size: 15px;
        font-weight: 700;
        color: #1a70bb
    }

    .form td {
        font-weight: 600;
        font-size: 14px;
    }

    th {
        text-align: center;
    }

    .form-control.contact {
        text-align: center;
        border-color: transparent;
    }

    td span {
        font-size: 24px;
    }

    .fa-minus-square-o {
        color: red;
    }
    .fonttable th{
        font-size: 16px !important;
    }

</style>
<!-- Profile Start -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Profile</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <form id="profile" action="{{ route('profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <br>
                                @if ($message = Session::get('warning'))
                                    <div class="alert alert-warning alert-block" style="text-align: center; color: white;">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif
                                <div class="row" style="padding-top: 15px">
                                    <div class="col-lg-3 col-md-3 mt--4 ml-4 mb--4">
                                        
                                        <span class="logo1">Information Account</span>
                                        <br>
                                        <br>
                                        <span class="logo">Logo</span>
                                        <br>
                                        <img id="thumbnail" src="{{ asset($img1) }}"
                                            style="width: 180px; height: 180px; ">
                                        <p style="padding-top: 10px;">
                                            <span class="btn btn-primary btn-file"
                                                style="border-radius: 3px; width: 175px;">
                                                Upload <input type="file" name="avatar" accept="image/*" id="avatar"
                                                    {{-- class="upload1" --}} />
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-lg-8 col-md-8 align-self-center">
                                        <table width="100%" class="form"
                                            style="border-spacing: 10px; border-collapse: separate;">
                                            <tr>
                                                <td width="30%">Username</td>
                                                <td>
                                                    <input type="text" class="form-control" name="username"
                                                        value="{{ $profile->username }}" id="username"
                                                        data-toggle="tooltip" data-trigger="manual"
                                                        title="Please Fill Username !">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Email</td>
                                                <td>
                                                    <input type="text" class="form-control" name="email"
                                                        value="{{ $profile->email }}" id="email"
                                                        data-toggle="tooltip" data-trigger="manual"
                                                        title="Please Fill Email !">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Password</td>
                                                <td><input type="password" id="password" class="form-control"
                                                        name="password" placeholder="############"></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Re-Password</td>
                                                <td><input type="password" class="form-control" name="re_password"
                                                        placeholder="############" id="re_password" data-toggle="tooltip"
                                                        data-trigger="manual" title="Password is Not Matching !"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row justify-content-center" style="padding-top: 20px">
                                    <div class="col-lg-12 col-md-12">
                                        <hr style="border: 1px solid #99cdf5;">
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 20px">
                                    <div class="col-lg-6 col-md-12 ml-4 mt--3 mb--4">
                                        <span class="logo1">Information Company</span>
                                        <table width="100%" class="form"
                                            style="border-spacing: 10px; border-collapse: separate;">
                                            <tr>
                                                <td width="30%">Country</td>
                                                <td>
                                                    <select class="form-control" name="country" id="country" required>
                                                        @foreach ($country as $data)
                                                            <option value="{{ $data->id }}" @if ($data->id == $profile->id_mst_country) selected @endif>
                                                                {{ $data->country }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr style="display: none;">
                                                <td width="30%">Business Entity</td>
                                                <td>
                                                    <select name="badanusaha" class="form-control">
                                                        <option>-</option>
                                                        <?php 
                                                            $bns = DB::select("select * from eks_business_entity");
                                                            foreach($bns as $val){
                                                        ?>
                                                        <option <?php if ($profile->badanusaha == $val->nmbadanusaha) {
                                                            echo 'selected';
                                                        } ?> value="<?php echo $val->nmbadanusaha; ?>">
                                                            <?php echo $val->nmbadanusaha; ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Name of Company</td>
                                                <td>
                                                    <input type="text" class="form-control" name="name_company"
                                                        value="{{ $profile->company }}" id="name_company"
                                                        data-toggle="tooltip" data-trigger="manual"
                                                        title="Please Fill Name of Company !">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Address</td>
                                                <td><input type="text" class="form-control" name="address"
                                                        value="{{ $profile->addres }}" required></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">City</td>
                                                <td>
                                                    <!--<select class="form-control" name="city" id="city" data-toggle="tooltip" data-trigger="manual" title="Please Select City !">
                                                </select> -->
                                                    <input type="text" class="form-control" name="city"
                                                        value="{{ $profile->city }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Zip Code</td>
                                                <td><input type="text" class="form-control integer" name="zip_code"
                                                        value="{{ $profile->postcode }}"></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">E-mail</td>
                                                <td><input type="email" class="form-control" name="email"
                                                        value="{{ $profile->email }}" id="email" data-toggle="tooltip"
                                                        data-trigger="manual" title="Please Fill E-mail !"></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Fax</td>
                                                <td><input type="text" class="form-control" name="fax"
                                                        value="{{ $profile->fax }}"></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Website</td>
                                                <td><input type="text" class="form-control" onkeyup="cekwebsite()"
                                                        id="website" name="website" value="{{ $profile->website }}"></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Phone</td>
                                                <td><input type="text" class="form-control" name="phone"
                                                        value="{{ $profile->phone }}"></td>
                                            </tr>
                                            {{-- <tr>
                                                <td colspan="2" align="right">
                                                    <button type="button" class="btn navigasi active"
                                                        style="width: 20%;font-weight: 600; border-radius: 3px;"
                                                        onclick="send('#profile')">Update</button>
                                                </td>
                                            </tr> --}}
                                        </table>
                                    </div>
                                </div>

                                <div class="row justify-content-center" style="padding-top: 20px">
                                    <div class="col-lg-12 col-md-12">
                                        <hr style="border: 1px solid #99cdf5;">
                                    </div>
                                </div>

                                <div class="row" style="padding-top: 20px">
                                    <div class="col-lg-12 col-md-12 mt--4">
                                        <span class="logo1">Contact</span>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover"
                                                style="text-align: center;">
                                                <thead class="fonttable" style="background-color: #C4C4C4;">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>E-mail</th>
                                                        <th>Phone</th>
                                                        <th width="6%" valign="middle">
                                                            <a onclick="tambah()">
                                                                <span class="fa fa-plus-circle" aria-hidden="true" style="font-size: 20px"></span>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #f5f5f5" id="tbody_contact">
                                                    <input type="hidden" id="number" value="{{ count($contact) }}">
                                                    @foreach ($contact as $key => $value)
                                                        <tr id="contact_{{ $key + 1 }}">
                                                            <td><input type="text" name="name_contact[]"
                                                                    class="form-control contact"
                                                                    value="{{ $value->name }}" autocomplete="off" placeholder="Name"></td>
                                                            <td><input type="text" name="email_contact[]"
                                                                    class="form-control contact"
                                                                    value="{{ $value->email }}" autocomplete="off" placeholder="Email"></td>
                                                            <td><input type="text" name="phone_contact[]"
                                                                    class="form-control contact"
                                                                    value="{{ $value->phone }}" autocomplete="off" placeholder="Phone"></td>
                                                            <td><a onclick="hapus('{{ $key + 1 }}')"><i
                                                                        class="ni ni-fat-remove text-red" aria-hidden="true"
                                                                        style="font-size: 40px;"></i></a></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div align="left"><button class="btn navigasi active" type="submit"
                                                style="width: 20%; font-weight: 600; border-radius: 3px;">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel">
                            <form id="form-contact" action="{{ route('profile.contact_update') }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row justify-content-center" style="padding-top: 30px">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="table-responsive">

                                            <table class="table table-striped table-hover"
                                                style="text-align: center;">
                                                <thead style="background-color: #C4C4C4; color: #bdbbbb;">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>E-mail</th>
                                                        <th>Phone</th>
                                                        <th width="6%" valign="middle"><a onclick="tambah()"><span
                                                                    class="fa fa-plus-circle" aria-hidden="true"
                                                                    style="font-size: 20px"></span></a></th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #bdbbbb" id="tbody_contact">
                                                    <input type="hidden" id="number" value="{{ count($contact) }}">
                                                    @foreach ($contact as $key => $value)
                                                        <tr id="contact_{{ $key + 1 }}">
                                                            <td><input type="text" name="name_contact[]"
                                                                    class="form-control contact"
                                                                    value="{{ $value->name }}" autocomplete="off"  placeholder="Name"></td>
                                                            <td><input type="text" name="email_contact[]"
                                                                    class="form-control contact"
                                                                    value="{{ $value->email }}" autocomplete="off"  placeholder="Email"></td>
                                                            <td><input type="text" name="phone_contact[]"
                                                                    class="form-control contact"
                                                                    value="{{ $value->phone }}" autocomplete="off"  placeholder="Phone"></td>
                                                            <td><a onclick="hapus('{{ $key + 1 }}')"><i
                                                                        class="ni ni-fat-remove text-red" aria-hidden="true"
                                                                        style="font-size: 40px;"></i></a></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div align="right"><button class="btn navigasi active" type="submit"
                                                style="width: 20%; font-weight: 600; border-radius: 3px;">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Profile End -->

@include('frontend.layouts.footer_history')
<script type="text/javascript">
    $(document).ready(function() {
        var country = $('#country').val();
        $.ajax({
            url: "{{ route('ajax-city', $id_user) }}",
            type: 'get',
            data: {
                id: country
            },
            dataType: 'json',
            success: function(response) {
                $('#city').append(response);
            }
        });

        $('input').attr('autocomplete', 'off');
        $('#country').on('change', function() {
            var data = this.value;
            $(".option_city").each(function() {
                $(this).remove();
            });
            $.ajax({
                url: "{{ route('ajax-city', 'null') }}",
                type: 'get',
                data: {
                    id: data
                },
                dataType: 'json',
                success: function(response) {
                    $('#city').append(response);
                }
            });
        });

        $('.integer').inputmask({
            alias: "integer",
            digitsOptional: false,
            decimalProtect: false,
            radixFocus: true,
            autoUnmask: false,
            allowMinus: false,
            rightAlign: false,
            clearMaskOnLostFocus: false,
            onBeforeMask: function(value, opts) {
                return value;
            },
            removeMaskOnSubmit: true
        });

        $("#avatar").change(function() {
            thumbnail(this);
        });
    });

    function hapus(id) {
        $('#contact_' + id).remove();
    }

    function tambah() {
        var table = '';
        var nomor = parseInt($('#number').val());
        table += '<tr id="contact_' + nomor + '">';
        table += '<td><input type="text" name="name_contact[]" class="form-control contact" autocomplete="off"  placeholder="Name"></td>';
        table += '<td><input type="text" name="email_contact[]" class="form-control contact" autocomplete="off"  placeholder="Email"></td>';
        table += '<td><input type="text" name="phone_contact[]" class="form-control contact" autocomplete="off"  placeholder="Phone"></td>';
        table += '<td><a onclick="hapus(' + nomor +')"><i class="ni ni-fat-remove text-red" aria-hidden="true" style="font-size: 40px;"></i></a></td>';
        table += '</tr>';
        $('#tbody_contact').append(table);
        $('#number').val(parseInt(nomor) + 1);
    }

    function send(form) {
        if ($('#username').val() == '') {
            $('#username').tooltip('toggle');
            $('#username').focus();
            setTimeout(function() {
                $('#username').tooltip('toggle');
            }, 1000);
        } else if ($('#password').val() != $('#re_password').val()) {
            $('#re_password').tooltip('toggle');
            $('#re_password').focus();
            setTimeout(function() {
                $('#re_password').tooltip('toggle');
            }, 1000);
        } else if ($('#name_company').val() == '') {
            $('#name_company').tooltip('toggle');
            $('#name_company').focus();
            setTimeout(function() {
                $('#name_company').tooltip('toggle');
            }, 1000);
        } else if ($('#city').val() == '') {
            $('#city').tooltip('toggle');
            $('#city').focus();
            setTimeout(function() {
                $('#city').tooltip('toggle');
            }, 1000);
        } else if ($('#email').val() == '' || !isEmail($('#email').val())) {
            $('#email').tooltip('toggle');
            $('#email').focus();
            setTimeout(function() {
                $('#email').tooltip('toggle');
            }, 1000);
        } else {
            $(form).submit();
        }
    }

    function thumbnail(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#thumbnail').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $('.upload1').on('change', function(evt) {
        var size = this.files[0].size;
        if (size > 5000000) {
            //     if(size > 20000){
            $(this).val("");
            alert('image size must less than 5MB');
        } else {

        }
    })

    function cekwebsite() {
        var m = $('#website').val();
        var carikoma = m.search(",");
        if (carikoma != "-1") {
            $('#website').val("");
        }
        var carispa = m.search(" ");
        if (carispa != "-1") {
            $('#email').val("");
        }
    }
</script>
