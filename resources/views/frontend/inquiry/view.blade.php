@include('frontend.layouts.header_table')
<style type="text/css">
    .btn-document {
        background-color: rgba(220, 220, 220, 0.29);
        color: #326BA2;
        white-space: normal !important;
        max-width: auto;
    }

    .btn-document:hover {
        color: #326BA2;
    }

</style>
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
<!--product details start-->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-bottom">
                <h3 class="mb-0">View</h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="product-details-tab">

                                <div id="img-1" class="zoomWrapper single-zoom">
                                    <a href="#">
                                        <img id="zoom1" src="{{ url('/') }}/{{ $img1 }}"
                                            data-zoom-image="{{ url('/') }}/{{ $img1 }}" alt="big-1">
                                    </a>
                                </div>

                                @if (count($arrimg) != 0)
                                    <div class="single-zoom-thumb">
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
                        <div class="col-lg-6 col-md-6">
                            <div class="product_d_right">
                                <h1><b>{{ getProductAttr($data->id, 'prodname', $lct) }}</b></h1>
                                <hr>
                                <div class="product_desc">
                                    <table border="0" cellpadding="10" cellspacing="10"
                                        style="width: 100%; font-size: 14px;">
                                        <tbody>
                                            <!-- <tr>
                                        <td width="30%">@lang('inquiry.prodname')</td>
                                        <td width="60%">
                                          <input type="hidden" name="id_product" id="id_product" value="{{ $data->id }}">
                                          <input type="hidden" name="type" id="type" value="importir">
                                          <b>{{ getProductAttr($data->id, 'prodname', $lct) }}</b>
                                        </td>
                                      </tr> -->
                                            <tr>
                                                <td width="30%">@lang('inquiry.category')</td>
                                                <td width="60%">
                                                    <?php
                                                    if ($cat1 == '-') {
                                                        echo $cat1;
                                                    } else {
                                                        if ($cat2 == '-') {
                                                            echo $cat1;
                                                        } else {
                                                            if ($cat3 == '-') {
                                                                echo $cat1 . ' > ' . $cat2;
                                                            } else {
                                                                echo $cat1 . ' > ' . $cat2 . ' > ' . $cat3;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">@lang('inquiry.kos')</td>
                                                <td width="60%">
                                                    <?php
                                                    $nkos = 'jenis_perihal_' . $lct;
                                                    $param = $data->id_itdp_company_user . '-' . getCompanyName($data->id_itdp_company_user);
                                                    ?>
                                                    <span
                                                        style="text-transform: capitalize;">{{ $inquiry->$nkos }}</span>
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
                                            <tr>
                                                <td width="30%">@lang('inquiry.subject')</td>
                                                <td width="60%">
                                                    <?php
                                                    $nsub = 'subyek_' . $lct;
                                                    ?>
                                                    <span
                                                        style="text-transform: capitalize;">{{ $inquiry->$nsub }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="vertical-align: top;">@lang('inquiry.msg')</td>
                                                <td width="60%">
                                                    <?php
                                                    $nmsg = 'messages_' . $lct;
                                                    ?>
                                                    <span style="text-transform: capitalize;"><?php echo $inquiry->$nmsg; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">@lang('inquiry.file')</td>
                                                <td width="60%">
                                                    @if ($inquiry->file == '')
                                                        <input type="text" class="btn btn-document" value="No File"
                                                            autocomplete="off" readonly
                                                            style="text-align: center; background: gray;">
                                                    @else
                                                        <a href="{{ url('/') . '/uploads/Inquiry/' . $inquiry->id }}/{{ $inquiry->file }}"
                                                            target="_blank"
                                                            class="btn btn-document">{{ $inquiry->file }}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">@lang('inquiry.duration')</td>
                                                <td width="60%">
                                                    <?php
                                                    if ($inquiry->duration != 'None') {
                                                        $d = explode(' ', $inquiry->duration);
                                                        if ($d[1] == 'week' || $d[1] == 'weeks') {
                                                            $dw = 'w';
                                                        } elseif ($d[1] == 'month' || $d[1] == 'months') {
                                                            $dw = 'm';
                                                        }
                                                        $durasi = 'v' . $d[0] . $dw;
                                                    } else {
                                                        $durasi = 'none';
                                                    }
                                                    ?>
                                                    <span
                                                        style="text-transform: capitalize;">@lang('inquiry.'.$durasi)</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="float: right;">
                                    <a href="{{ url('/front_end/history') }}" class="btn btn-danger"><i
                                            class="fa fa-arrow-left"
                                            aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.back')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product details end-->
<!-- Plugins JS -->
<script src="{{ asset('front/assets/js/plugins.js') }}"></script>
@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function() {
        //
    });
</script>
