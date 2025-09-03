@include('frontend.layouts.header')
<?php
$loc = app()->getLocale();
if ($loc == 'ch') {
    $lct = 'chn';
    if ($detail->event_name_chn != null) {
        $name = $detail->event_name_chn;
    } else {
        $name = $detail->event_name_en;
    }

    if ($detail->event_type_chn != null) {
        $type = $detail->event_type_chn;
    } else {
        $type = $detail->event_type_en;
    }

    if ($detail->event_scope_chn != null) {
        $scope = $detail->event_scope_chn;
    } else {
        $scope = $detail->event_scope_en;
    }
} elseif ($loc == 'in') {
    $lct = 'in';

    if ($detail->event_name_in != null) {
        $name = $detail->event_name_in;
    } else {
        $name = $detail->event_name_en;
    }

    if ($detail->event_type_in != null) {
        $type = $detail->event_type_in;
    } else {
        $type = $detail->event_type_en;
    }

    if ($detail->event_scope_in != null) {
        $scope = $detail->event_scope_in;
    } else {
        $scope = $detail->event_scope_en;
    }
} else {
    $lct = 'en';
    $type = $detail->event_type_en;
    $scope = $detail->event_scope_en;
    $name = $detail->event_name_en;
}

//    $comodity = EventComodityName($detail->event_comodity, $loc);
$eo = EventOrganizerName($detail->id_event_organizer, $loc);
$place = EventPlaceName($detail->id_event_place, $loc);

//get category
$cat1 = getCategoryName($detail->id_prod_cat, $lct);
$cat2 = getCategoryName($detail->id_prod_sub1_kat, $lct);
$cat3 = getCategoryName($detail->id_prod_sub2_kat, $lct);

if (isset($detail->id_prod_sub2_kat) && $detail->id_prod_sub2_kat != 0) {
    $kategori = $cat1 . ' > ' . $cat2 . ' > ' . $cat3;
} elseif (isset($detail->id_prod_sub1_kat) && $detail->id_prod_sub1_kat != 0) {
    $kategori = $cat1 . ' > ' . $cat2;
} elseif (isset($detail->id_prod_cat) && $detail->id_prod_cat != 0) {
    $kategori = $cat1;
} else {
    $kategori = '-';
}

$arrimg = [];
$img1 = 'image/noimage.jpg';
// $img2 = "image/noimage.jpg";
// $img3 = "image/noimage.jpg";
// $img4 = "image/noimage.jpg";
if ($detail->image_1 != null) {
    $imge1 = 'uploads/Event/Image/' . $detail->id . '/' . $detail->image_1;
    if (file_exists($imge1)) {
        $img1 = 'uploads/Event/Image/' . $detail->id . '/' . $detail->image_1;
        array_push($arrimg, $img1);
    }
}
if ($detail->image_2 != null) {
    $imge2 = 'uploads/Event/Image/' . $detail->id . '/' . $detail->image_2;
    if (file_exists($imge2)) {
        $img2 = 'uploads/Event/Image/' . $detail->id . '/' . $detail->image_2;
        array_push($arrimg, $img2);
    }
}
if ($detail->image_3 != null) {
    $imge3 = 'uploads/Event/Image/' . $detail->id . '/' . $detail->image_3;
    if (file_exists($imge3)) {
        $img3 = 'uploads/Event/Image/' . $detail->id . '/' . $detail->image_3;
        array_push($arrimg, $img3);
    }
}
if ($detail->image_4 != null) {
    $imge4 = 'uploads/Event/Image/' . $detail->id . '/' . $detail->image_4;
    if (file_exists($imge4)) {
        $img4 = 'uploads/Event/Image/' . $detail->id . '/' . $detail->image_4;
        array_push($arrimg, $img4);
    }
}
$button = '';
$nowDate = Carbon\Carbon::now();
$limit = Carbon\Carbon::parse($detail->limit)->endOfDay();
if ($detail->limit != '' && $limit->gte($nowDate)) {
    // Only show register button when limit registration is filled
    if (isset(Auth::guard('eksmp')->user()->id)) {
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            // Only role as a supplier was allowed
            $button = '<button class="btn training join btn-info" style="width:30%;" onclick="__joinSupplier(' . $detail->id . ', '.Auth::guard('eksmp')->user()->id.')">' . Lang::get('training.minat') . '</button>';
        } else {
            // $button = '<button class="btn training join btn-info" style="width:30%;" onclick="__join(\'' . getContactPerson($detail->id, 'event') . '\')">' . Lang::get('training.minat') . '</button>';
            $button = '<button class="btn training join btn-info" style="width:30%;" onclick="alert(' . "'Please login as supplier to register !!'" . ')">' . Lang::get('training.minat') . '</button>';
        }
    } else {
        $button = '<button class="btn training join btn-info" style="width:30%;" onclick="alert(' . "'Please login as supplier to register !!'" . ')">' . Lang::get('training.minat') . '</button>';
        // $button = '<button class="btn training join btn-info" style="width:30%;" onclick="__join(\'' . getContactPerson($detail->id, 'event') . '\')">' . Lang::get('training.minat') . '</button>';
    }
}
?>
<style type="text/css">
    .modal-body {
        background-image: url('{{ url('/') }}/front/assets/img/cp/bg.png');
        background-size: cover;
        background-repeat: no-repeat;
        width: 100%;
        margin: 0px;
        background-color: transparent;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        height: 380px;
    }

    .modal-content {
        background-color: transparent;
        border: none;
    }

    .icon {
        width: 15%;
    }

    .cp-data {
        padding-left: 15px;
        color: white;
        font-size: 20px;
        font-family: arial;
    }

    i.mod {
        color: white;
        font-size: 24px;
    }

    i.mod:hover {
        color: red;
    }

    .data-cp {
        background-color: transparent;
        border: none;
        color: white;
        font-size: 20px;
        width: 100%;
    }
</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ url('/') }}">@lang("frontend.proddetail.home")</a></li>
                        <li>Trade Event</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--product details start-->
<div class="product_details mt-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="product-details-tab" style="width: 400px;">

                    <div id="img-1" class="" align="center" style="border: 10px solid #edeff2;">
                        <a href="#">
                            <img id="" src="{{ url('/') }}/{{ $img1 }}" data-zoom-image="{{ url('/') }}/{{ $img1 }}"
                                alt="big-1" style="width: 400px; height: 400px;">
                        </a>
                    </div>
                    @if (count($arrimg) > 1)
                    <div class="single-zoom-thumb" align="center">
                        <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                            <?php
                                    for ($m=0; $m < count($arrimg); $m++) { 
                                ?>
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-update=""
                                    data-image="{{ url('/') }}/{{ $arrimg[$m] }}"
                                    data-zoom-image="{{ url('/') }}/{{ $arrimg[$m] }}">
                                    <img src="{{ url('/') }}/{{ $arrimg[$m] }}" alt="zo-th-1"
                                        style="width: auto; height: 105px;" />
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
                    <h1 style="font-weight: 600; color: #007bff;"><i>{{ $name }}</i></h1>
                    <span style="color: #747d90">
                        <i class="fa fa-calendar" style="padding-right: 8px;"></i>{{ date('d M Y',
                        strtotime($detail->start_date)) }} -
                        {{ date('d M Y', strtotime($detail->end_date)) }}
                        <hr>
                    </span>
                    <div class="product_desc">
                        <table>
                            <tr>
                                <td style="vertical-align: top;">@lang("frontend.event.type")</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td style="vertical-align: top;">{{ $type }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">@lang("frontend.event.eo")</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td style="vertical-align: top;">{{ $eo }}</td>
                            </tr>
                            {{-- <tr> --}}
                                {{-- <td>@lang("frontend.event.comodity")</td> --}}
                                {{-- <td style="padding-left: 5px;padding-right: 10px;">:</td> --}}
                                {{-- <td>{{$comodity}}</td> --}}
                                {{-- </tr> --}}
                            <tr>
                                <td style="vertical-align: top;">@lang("frontend.event.scope")</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td style="vertical-align: top;">{{ $scope }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">@lang("frontend.event.place")</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td style="vertical-align: top;">{{ $place }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">@lang("frontend.event.website")</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td style="vertical-align: top;"><a target="_blank" href="{{ $detail->website }}">{{
                                        $detail->website }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">@lang("frontend.event.pic")</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td>{{ explode('|', getContactPerson($detail->id, 'event'))[0] }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">@lang("frontend.event.phone")</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td>{{ explode('|', getContactPerson($detail->id, 'event'))[1] }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">Email</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td>{{ explode('|', getContactPerson($detail->id, 'event'))[2] }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">@lang("frontend.event.description")</td>
                                <td style="padding-left: 5px;padding-right: 10px; vertical-align: top;">:</td>
                                <td style="vertical-align: top;">{{ $detail->description }}</td>
                            </tr>
                            <tr>
                                <td style="width: 128px;">@lang("frontend.event.limit")</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td>{{ $detail->limit != '' && $detail->limit != null ? date('d F Y',
                                    strtotime($detail->limit)) : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">Status</td>
                                <td style="padding-left: 5px;padding-right: 10px;vertical-align: top;">:</td>
                                <td style="vertical-align: top;">{{ $detail->status_en }}</td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <center>
                            <?php echo $button; ?>&nbsp;
                            <a href="javascript:history.back()" class="btn training join btn-danger rounded"
                                style="width:20%;"><i class="fa fa-arrow-left"></i> @lang('button-name.back')</a>
                        </center>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--product details end-->
{{-- @if (Auth::guard('eksmp')->user()) --}}
<!-- Modal Contact Person -->
<div class="modal fade" id="modal_cp" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <table border="0" width="90%" align="center" height="30%">
                    <tr>
                        <td align="right"><i class="fa fa-times mod" data-dismiss="modal" style=""></i></td>
                    </tr>
                </table>
                <table border="0" width="85%" align="center">
                    <tr>
                        <td class="icon" align="center"><img src="{{ url('/') }}/front/assets/img/cp/nama.png"
                                height="100%"></td>
                        <td class="cp-data" colspan="2" style="text-transform: capitalize;"><input type="text"
                                class="data-cp" id="cp_name"></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="height: 8px;">
                                <img src="{{ url('/') }}/front/assets/img/cp/line.png" width="100%" height="100%"
                                    style="vertical-align: top;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="icon" align="center"><img src="{{ url('/') }}/front/assets/img/cp/phone.png"
                                height="100%"></td>
                        <td class="cp-data" colspan="2"><input type="text" class="data-cp" id="cp_phone">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="height: 8px;">
                                <img src="{{ url('/') }}/front/assets/img/cp/line.png" width="100%" height="100%"
                                    style="vertical-align: top;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="icon" align="center"><img src="{{ url('/') }}/front/assets/img/cp/email.png"
                                height="100%" height="100%">
                        </td>
                        <td class="cp-data" colspan="2"><input type="text" class="data-cp" id="cp_email">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="height: 8px;">
                                <img src="{{ url('/') }}/front/assets/img/cp/line.png" width="100%"
                                    style="vertical-align: top;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="icon" align="center"><img src="{{ url('/') }}/front/assets/img/cp/date.png"
                                height="100%" height="100%">
                        </td>
                        <td style="font-size: 24px; color: #fff;">*</td>
                        <td class="cp-data" style="padding-left: 0px !important;"><input type="text"
                                style="font-size: 18px !important;" class="data-cp" id="reg_date"></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="height: 8px;">
                                <img src="{{ url('/') }}/front/assets/img/cp/line.png" width="100%"
                                    style="vertical-align: top;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="font-size: 12px; color: #fff; font-weight: 600; padding-left: 5px;">
                            <i>*) Registration Date</i>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- @endif --}}
<!-- Plugins JS -->
<script src="{{ asset('front/assets/js/plugins.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.data-cp').prop('readonly', true);
    });

    function __join(id) {
        if (id != '-') {
            var pecah = id.split('|');
            $('#cp_name').val(pecah[0]);
            $('#cp_phone').val(pecah[1]);
            $('#cp_email').val(pecah[2]);
            $('#reg_date').val(pecah[3]);
        } else {
            $('#cp_name').val('No Contact');
            $('#cp_phone').val('No Contact');
            $('#cp_email').val('No Contact');
            $('#reg_date').val('Not Specified');
        }
        $('#modal_cp').modal('show');
        var token = "{{ csrf_token() }}";
        var id = "{{ $detail->id }}";
        // $.ajax({
        //     url: "{{ route('event.interest') }}",
        //     type: 'post',
        //     data: {'_token':token,id:id},
        //     dataType: 'json'
        // });
    }

    function __joinSupplier(id, user_id) {
        // Proses pendaftaran pameran, apabila yang mendaftar belum mengisi data produk tidak bisa
        // mendaftar pameran dan diminta mengisi data produk terlebih dahulu, dan produknya harus sudah diverifikasi oleh admin.
        
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('check.eksproduct') }}",
            type: 'post',
            data: {
                '_token': token,
                user_id: user_id
            },
            dataType: 'json',
            success: function(data) {
               if(data.status){
                    Swal.fire({
                        icon: 'question',
                        title: 'Ingin Mendaftar Menjadi Peserta?',
                        confirmButtonText: "Daftar",
                        cancelButtonText: "Batal",
                        showCancelButton: true,
                    }).then(function(result) {
                        if (result.value) {
                            var token = "{{ csrf_token() }}";
                            $.ajax({
                                url: "{{ route('event.interest') }}",
                                type: 'post',
                                data: {
                                    '_token': token,
                                    id: id
                                },
                                dataType: 'json',
                                success: function(data) {
                                    if (data == 'failed') {
                                        Swal.fire({
                                            icon: 'error',
                                            text: "Your company has been already registered for this trade event",
                                            showConfirmButton: true
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'success',
                                            text: "Your company has registered as participant in this trade event, we will contact you soon......",
                                            showConfirmButton: true
                                        });
                                    }
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: "Batal Daftar",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
               }else{
                    Swal.fire({
                        icon: 'warning',
                        text: "Untuk mendaftar Anda harus mempunyai setidaknya 1 produk yang sudah diverifikasi oleh Admin",
                    });
               }
            }
        });
        
    }

    function notif() {
        alert("@lang('frontend.lbl13')");
    }
</script>
@include('frontend.layouts.footer')