@include('frontend.layouts.header')
<?php
$loc = app()->getLocale();
if ($loc == 'ch') {
    $lct = 'chn';
} elseif ($loc == 'in') {
    $lct = 'in';
} else {
    $lct = 'en';
}

//get category
$cat1 = getCategoryName($data->id_csc_product, $lct);
$cat2 = getCategoryName($data->id_csc_product_level1, $lct);
$cat3 = getCategoryName($data->id_csc_product_level2, $lct);

$arrimg = [];

$img1 = 'image/noimage.jpg';
// $img2 = "image/noimage.jpg";
// $img3 = "image/noimage.jpg";
// $img4 = "image/noimage.jpg";
if ($data->image_1 != null) {
    $imge1 = 'uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_1;
    if (file_exists($imge1)) {
        $img1 = 'uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_1;
        array_push($arrimg, $img1);
    }
}
if ($data->image_2 != null) {
    $imge2 = 'uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_2;
    if (file_exists($imge2)) {
        $img2 = 'uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_2;
        array_push($arrimg, $img2);
    }
}
if ($data->image_3 != null) {
    $imge3 = 'uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_3;
    if (file_exists($imge3)) {
        $img3 = 'uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_3;
        array_push($arrimg, $img3);
    }
}
if ($data->image_4 != null) {
    $imge4 = 'uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_4;
    if (file_exists($imge4)) {
        $img4 = 'uploads/Eksportir_Product/Image/' . $data->id . '/' . $data->image_4;
        array_push($arrimg, $img4);
    }
}
?>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ url('/') }}">@lang('frontend.proddetail.home')</a></li>
                        @if ($data->id_csc_product == null)
                            <li><a
                                    href="{{ url('/front_end/list_product') }}">@lang('frontend.proddetail.dafault')</a>
                            </li>
                        @else
                            @if ($cat1 == '-')
                                <li><a
                                        href="{{ url('/front_end/list_product') }}">@lang('frontend.proddetail.dafault')</a>
                                </li>
                            @else
                                @if ($cat2 == '-')
                                    <li><a
                                            href="{{ url('/front_end/list_product/category/' . $data->id_csc_product_level1) }}">{{ $cat1 }}</a>
                                    </li>
                                @else
                                    @if ($cat3 == '-')
                                        <li><a
                                                href="{{ url('/front_end/list_product/category/' . $data->id_csc_product) }}">{{ $cat1 }}</a>
                                        </li>
                                        <li><a
                                                href="{{ url('/front_end/list_product/category/' . $data->id_csc_product_level1) }}">{{ $cat2 }}</a>
                                        </li>
                                    @else
                                        <li><a
                                                href="{{ url('/front_end/list_product/category/' . $data->id_csc_product) }}">{{ $cat1 }}</a>
                                        </li>
                                        <li><a
                                                href="{{ url('/front_end/list_product/category/' . $data->id_csc_product_level1) }}">{{ $cat2 }}</a>
                                        </li>
                                        <li><a
                                                href="{{ url('/front_end/list_product/category/' . $data->id_csc_product_level2) }}">{{ $cat3 }}</a>
                                        </li>
                                    @endif
                                @endif
                            @endif
                        @endif
                        <li>@lang('inquiry.form')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--product details start-->
{{-- {{ url('br_importir_save') }} --}}
<form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ url($url) }}" id="formnya">
    {{ csrf_field() }}
    <div class="product_details mt-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="box-body">
                        <br>
                        <div class="product-details-tab">
                            <div id="img-1" class="zoomWrapper single-zoom" align="center">
                                <a href="#">
                                    <img id="zoom1" src="{{ url('/') }}/{{ $img1 }}"
                                        data-zoom-image="{{ url('/') }}/{{ $img1 }}" alt="big-1"
                                        style="width: 400px; height:400x;">
                                </a>
                            </div>
                            @if (count($arrimg) != 0)
                                <div class="single-zoom-thumb" align="center">
                                    <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                        <?php
                                  for ($m=0; $m < count($arrimg); $m++) { 
                              ?>
                                        <li>
                                            <a href="#" class="elevatezoom-gallery active" data-update=""
                                                data-image="{{ url('/') }}/{{ $arrimg[$m] }}"
                                                data-zoom-image="{{ url('/') }}/{{ $arrimg[$m] }}">
                                                <img src="{{ url('/') }}/{{ $arrimg[$m] }}" alt="zo-th-1" />
                                            </a>
                                        </li>
                                        <?php
                                  }
                              ?>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                        <!-- <h1>{{ getProductAttr($data->id, 'prodname', $lct) }}</h1>
                        <div class="price_box">
                            <span class="current_price">
                                @if (is_numeric($data->price_usd))
                                    $ {{ $data->price_usd }}
                                @else
                                    {{ $data->price_usd }}
                                @endif
                            </span>
                        </div> -->
                        <div class="product_desc">
                            <table border="0" cellpadding="10" cellspacing="10" style="width: 100%; font-size: 14px;">
                                <tbody>
                                    <tr>
                                        <td width="30%">@lang('inquiry.prodname')</td>
                                        <td width="60%">
                                            <input type="hidden" name="id_product" id="id_product"
                                                value="{{ $data->id }}">
                                            <input type="hidden" name="type" id="type" value="importir">
                                            <b>{{ getProductAttr($data->id, 'prodname', $lct) }}</b>
                                            <input type="hidden" name="subyek" value="{{ getProductAttr($data->id, 'prodname', $lct) }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%">@lang('inquiry.category')</td>
                                        <td width="60%">
                                            <?php
                                            if ($cat1 == '-') {
                                                echo $cat1;
                                                $kumpulcat2 = $cat1;
                                            } else {
                                                if ($cat2 == '-') {
                                                    echo $cat1;
                                                    $kumpulcat2 = $cat1;
                                                } else {
                                                    if ($cat3 == '-') {
                                                        echo $cat1 . ' > ' . $cat2;
                                                        $kumpulcat2 = $data->id_csc_product.','.$data->id_csc_product_level1.',';
                                                    } else {
                                                        echo $cat1 . ' > ' . $cat2 . ' > ' . $cat3;
                                                        $kumpulcat2 = $data->id_csc_product.','.$data->id_csc_product_level1.','.$data->id_csc_product_level2;
                                                    }
                                                }
                                            }
                                            
                                            $param = $data->id_itdp_company_user . '-' . getCompanyName($data->id_itdp_company_user);
                                            ?>
                                            <input type="hidden" name="kumpulcat2" value="{{$kumpulcat2}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%">@lang('inquiry.company')</td>
                                        <td width="60%">
                                            <a href="{{ url('/front_end/list_perusahaan/view/' . $param) }}"
                                                style="text-transform: uppercase;">
                                                {{ getCompanyName($data->id_itdp_company_user) }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-row" style="padding-left:11px;">
                            <div class="col-sm-12">
                                <label><b>Product Specification (<font color="red">*</font>)</b></label>
                            </div>
                            <div class="form-group col-sm-12">
                                <textarea class="form-control" id="spec" name="spec" style="font-size: 14px;"
                                    rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-row" style="padding-left: 11px;">
                            <div class="col-sm-3">
                                <label><b>@lang("login.forms.by5")</b></label>
                            </div>
                            <div class="col-sm-5">
                                <label><b>@lang("login.forms.by15")</b></label>
                            </div>

                            <div class="form-group col-sm-12">
                                <div class="form-row">
                                    <div class="col-sm-3">
                                        <input style="color:black;font-size:12px;height:46px;" value="" type="text" min="1"
                                            name="eo" id="eo" class="form-control order">
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" style="font-size:12px;height: 40px;" name="neo"
                                            id="neo">
                                            <option value="" disabled selected>@lang("login.forms.by14")</option>
                                            <option value="Dozen">Dozen</option>
                                            <option value="Grams">Grams</option>
                                            <option value="Kilograms">Kilograms</option>
                                            <option value="Liters">Liters</option>
                                            <option value="Meters">Meters</option>
                                            <option value="Packs">Packs</option>
                                            <option value="Pairs">Pairs</option>
                                            <option value="Pieces">Pieces</option>
                                            <option value="Sets">Sets</option>
                                            <option value="Tons">Tons</option>
                                            <option value="Unit">Unit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row" style="padding-left:11px;">
                            <div class="col-sm-12">
                                <label><b>@lang("login.forms.by6")</b> <span id="fob"><b>(FOB)</b> </span></label>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="form-row">
                                    <div class="col-sm-3"><input style="color:black;font-size:12px;" type="text"
                                            value="<?php if (empty($tp)) {
                                            } else {
                                                echo number_format($R, 0, ',', '.');
                                            } ?>" name="tp" id="tp" class="form-control amount">
                                    </div>
                                    <div class="col-sm-5">
                                        <label><b>USD</b></label>
                                        <select style="font-size:12px;height: 31px;" class="form-control d-none"
                                                disabled name="ntp" id="ntp">
                                                {{-- <option value="">@lang("login.forms.by14")</option>
                                                                <option value="SAR">Arab Saudi Riyal(SAR)</option>
                                                                <option value="BND">Brunei Dollar(BND)</option>
                                                                <option value="CNY">China Yuan(CNY)</option>
                                                                <option value="IQD">Dinar Irak(IQD)</option>
                                                                <option value="AED">Dirham Uni Emirat Arab(AED)</option> --}}
                                                <option value="USD">Dollar Amerika Serikat(USD)</option>
                                                {{-- <option value="AUD">Dollar Australia(AUD)</option>
                                                                <option value="HKD">Dollar Hong Kong(HKD)</option>
                                                                <option value="SGD">Dollar Singapura(SGD)</option>
                                                                <option value="TWD">Dollar Taiwan Baru(TWD)</option>
                                                                <option value="EUR">Euro(EUR)</option>
                                                                <option value="PHP">Peso Filipina(PHP)</option>
                                                                <option value="GBP">Pound Sterling(GBP)</option>
                                                                <option value="MYR">Ringgit Malaysia(MYR)</option>
                                                                <option value="INR">Rupee India(INR)</option>
                                                                <option value="IDR">Rupiah Indonesia(IDR)</option>
                                                                <option value="THB">Thai Baht(THB)</option>
                                                                <option value="VND">Vietnam Dong(VND)</option>
                                                                <option value="KRW">Won Korea(KRW)</option>
                                                                <option value="JPY">Yen Jepang(JPY)</option> --}}
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row" style="padding-left: 11px;">
                            <div class="col-sm-12">
                                <label><b>@lang("login.forms.by7")</b></label>
                            </div>
                            <div class="form-group col-sm-6" style="font-size: 12px !important;">
                            <select style="color:black;font-size:12px;height: 40px;"
                                        style="border-color: rgba(120, 130, 140, 0.5)!important; border-radius: 0.25rem!important; color: inherit!important; font-size: 12px!important;"
                                        class="form-control select2" name="country" id="country" required>
                                        <option value="">@lang("login.forms.by12")</option>
                                        @foreach($country as $data)
                                        <option value="{{ $data->id }}" @if ($data->id == $profile->id_mst_country) selected @endif>
                                                                {{ $data->country }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <input style="color:black;font-size:12px;height:46px;" type="text" value="" name="city" id="city"
                                    class="form-control" placeholder="City / State">
                            </div>
                        </div>

                        <!-- <div class="form-row" style="padding-left: 11px;">
                            <div class="col-sm-12">
                                <label><b>@lang("login.forms.by8")</b></label>
                            </div>
                            <div class="form-group col-sm-12">
                                <textarea style="color:black;font-size:12px;" value="" name="ship" id="ship"
                                    class="form-control"></textarea>
                            </div>

                        </div> -->
                        <div class="form-row" style="padding-left:11px;">
                            <div class="col-sm-12">
                                <label><b>Valid Within (Days) (<font color="red">*</font>)</b></label>
                            </div>
                              <div class="form-group col-sm-12">
                                  <select style="color:black;font-size:12px;height: 40px;" class="form-control"
                                      name="valid" id="valid" required>
                                      {{-- <option value="">@lang("login.forms.by10")</option> --}}
                                      {{-- <option value="0">None</option> --}}
                                      <option value="3">Valid within 3 days</option>
                                      <option value="5">Valid within 5 days</option>
                                      <option value="7">Valid within 7 days</option>
                                      <option value="15">Valid within 15 days</option>
                                      <option value="30">Valid within 30 days</option>
                                  </select>
                              </div>
                        </div>
                        <!-- <div class="form-now">
                            <div class="col-sm-12">
                                <label><b>File</b></label>
                            </div>
                            <div class="col-sm-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="filedo" name="filedo"
                                        style="font-size: 14px;"
                                        accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel,.ppt,.pptx,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,.pdf,application/pdf">
                                    <label class="custom-file-label" for="inputGroupFile01" id="labfiledo"> -
                                        @lang('inquiry.choose') - </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-now">
                            <div class="col-sm-12">
                                <div class="checkbox">
                                    <br/>
                                    <p>To further increase the inquiry response rate, this information can also be addressed to all Inaexport members</p>
                                    <input class="eksportir" name="publish" type="checkbox" id="publish" value="true">
                                    <label for="publish">I agree, this inquiry reply by others members of inaexport</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="">
                        <center>
                            <a href="{{ url('/front_end/list_product') }}" class="btn btn-danger"><i
                                    class="fa fa-arrow-left"
                                    aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.cancel')</a>
                            <button type="button" class="btn btn-primary" id="btnsubmit"><i class="fa fa-paper-plane"
                                    aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.submit')</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
<?php
$alertkos = '';
$alertsubject = '';
$alertmsg = '';
$alertfile = '';
$alertdurasi = '';

if ($loc == 'ch') {
    $alertkos = '主题种类为空，请填写';
    $alertsubject = '主题为空，请填写';
    $alertmsg = '留言为空，请填写';
    $alertfile = '文件为空，请填写';
    $alertdurasi = '期限为空，请填写';
} elseif ($loc == 'in') {
    $alertkos = 'Jenis Subjek kosong, silahkan isi.';
    $alertsubject = 'Subjek kosong, silahkan isi.';
    $alertmsg = 'Pesan kosong, silahkan isi.';
    $alertfile = 'File kosong, silahkan isi.';
    $alertdurasi = 'Durasi kosong, silahkan isi.';
} else {
    $alertkos = 'Kind of Subject is empty, please fill in.';
    $alertsubject = 'Subject is empty, please fill in.';
    $alertmsg = 'Messages is empty, please fill in.';
    $alertfile = 'File is empty, please fill in.';
    $alertdurasi = 'Duration is empty, please fill in.';
}
?>
<!--product details end-->
<!-- Plugins JS -->
<script src="{{ asset('front/assets/js/plugins.js') }}"></script>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
@include('frontend.layouts.footer')

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            dropdownPosition: 'below'
        });

    });
$('#neo').change(function() {
    $('#fob').html('(FOB/' + $('#neo').val() + ')')
});
$('.order').inputmask({
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
        // removeMaskOnSubmit: true
    });
    $('.amount').inputmask({
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
    $(document).ready(function() {
        //Upload File
        $("#filedo").on('change', function() {
            if (this.value != "") {
                var val = this.value;
                var v = val.split('\\');
                $('#labfiledo').html(v[v.length - 1]);
            } else {
                alert('The file cannot be uploaded');
            }
        });

        $('#btnsubmit').on('click', function() {

            if ($('#kos').val() == "") {
                alert("<?php echo $alertkos; ?>");
            } else if ($('#subject').val() == "") {
                alert("<?php echo $alertsubject; ?>");
            } else if ($('#spec').val() == "") {
                alert("<?php echo $alertmsg; ?>");
            } else {
                $('#formnya').submit();
            }
        });
    });
</script>
