@include('frontend.layouts.header')
<?php
$loc = app()->getLocale();
if (Auth::guard('eksmp')->user()) {
    if (Auth::guard('eksmp')->user()->id_role == 2) {
        $id_user = Auth::guard('eksmp')->user()->id;
    } else {
        $id_user = '0';
    }
} else {
    $id_user = '0';
}

?>
<style type="text/css">
    img.rc {
        max-width: 100%;
        max-height: 100%;
        border-radius: 10px;
    }

    .detail_rc {
        color: #1a70bb;
        font-family: 'Myriad-pro' !important;
        font-size: 14px;
    }

    .a-modif:hover {
        text-decoration: none;
        background-color: #f4f4f5;
    }

    .a-modif.small {
        height: 100%;
        border-radius: 10px;
        background-color: white;
    }

    .form-control:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
    }

    .search {
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
        height: 40px;
    }

    .kontennya:hover {
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

    .sel-event {
        height: 100%;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        padding-left: 5px;
        background-color: #f7f7f7;
        border-left: 2px solid #1a70bb;
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
    }

    .css-title {
        font-family: arial;
        font-weight: 530;
        font-size: 18px;
        color: black !important;
    }

    .search-event {
        width: 100%;
    }

    .tabcontent {
        display: none;
    }

    .tablinks {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    .tabmin button.active {
        background-color: #1a70bb;
        color: white;
    }

    .select2-selection__rendered {
        line-height: 32px !important;
        float: left !important;
    }

    .select2-container .select2-selection--single {
        height: 37px !important;
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
    }

    .select2-container {
        float: left !important;
    }

    .select2-selection__arrow {
        height: 40px !important;
    }

    /*@media only screen and (max-width: 767px) {
      .search-event{
        width: 100%;
      }
    }
    @media only screen and (max-width: 479px) {
      .search-event{
        width: 100%;
      }
    }*/

    .select2 {
        width: 72% !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }

    .select2-selection__clear {
        position: absolute !important;
        right: 23px !important;
        top: 5px;
    }
</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area mb-4" style="background-color:rgba(0,0,0,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5">
                <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                    <ul>
                        <li><a href="{{ url('/') }}">@lang("frontend.proddetail.home")</a></li>
                        <li>Trade Event</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div id="search-all">
                    <form class="form-horizontal" enctype="multipart/form-data" method="GET"
                        action="{{ url('/front_end/event') }}" style="margin-top: 7px">
                        {{ csrf_field() }}
                        <div class="input-group search-event">
                            <div class="input-group-prepend">
                                <select id="search" name="search" class="sel-event">
                                    <option value="1" @if ($searchEvent==1) selected @endif>Name</option>
                                    <option value="2" @if ($searchEvent==2) selected @endif>Date</option>
                                    <option value="3" @if ($searchEvent==3) selected @endif>Country</option>
                                    <option value="4" @if ($searchEvent==4) selected @endif>Product</option>
                                </select>
                            </div>
                            <input type="text" id="search_name" name="nama" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent==1) value="{{ $param }}"
                                @endif>
                            {{-- <input type="date" id="search_date" name="tanggal" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent==2) value="{{$param}}" @endif>
                            --}}
                            <input type="month" id="search_date" name="tanggal" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent==2) value="{{ $param }}"
                                @endif>
                            <!-- <div id="boxselect2"> -->
                            <select class="form-control select2 search " name="country" id="search_country"
                                style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;">
                                <option value=""></option>
                            </select>
                            <select class="form-control select2 search " name="product" id="search_product"
                                style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;">
                                <option value=""></option>
                            </select>
                            @if (isset($param))
                            @if ($param != null)
                            <a href="{{ url('/front_end/event') }}" class="btn btn-sm btn-default"
                                style=" border-top: 2px solid #1a70bb; border-right: 2px solid #1a70bb;border-bottom: 2px solid #1a70bb;border-left: 2px solid #1a70bb;"
                                title="Reset All Filter"><span class="fa fa-close"></span></a>
                            @endif
                            @endif
                            <!-- </div> -->
                            <div class="input-group-prepend">
                                <button type="submit" class="input-group-text submit search"
                                    style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                                    title="Search">&nbsp;Search&nbsp;</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="search-indonesia" style="display: none;">
                    <form class="form-horizontal" enctype="multipart/form-data" method="GET"
                        action="{{ url('/front_end/event') }}" style="margin-top: 7px">
                        {{ csrf_field() }}
                        <div class="input-group search-event">
                            <div class="input-group-prepend">
                                <select id="search2" name="search2" class="sel-event">
                                    <option value="1" @if ($searchEvent2==1) selected @endif>Name</option>
                                    <option value="2" @if ($searchEvent2==2) selected @endif>Date</option>
                                    <option value="3" @if ($searchEvent2==3) selected @endif>Country</option>
                                    <option value="4" @if ($searchEvent2==4) selected @endif>Product</option>
                                </select>
                            </div>
                            <input type="text" id="search_name2" name="nama" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent2==1) value="{{ $param2 }}"
                                @endif>
                            {{-- <input type="date" id="search_date2" name="tanggal" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent2==2) value="{{$param2}}"
                                @endif> --}}
                            <input type="month" id="search_date2" name="tanggal" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent2==2) value="{{ $param2 }}"
                                @endif>
                            <select class="form-control select2 search " name="country" id="search_country2"
                                style="width:70%;height:40px; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;">
                                <option value=""></option>
                            </select>
                            <select class="form-control select2 search " name="product" id="search_product2"
                                style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;">
                                <option value=""></option>
                            </select>
                            @if (isset($param2))
                            @if ($param2 != null)
                            <a href="{{ url('/front_end/event') }}" class="btn btn-sm btn-default"
                                style=" border-top: 2px solid #1a70bb; border-right: 2px solid #1a70bb;border-bottom: 2px solid #1a70bb;border-left:2px solid #1a70bb;"
                                title="Reset All Filter"><span class="fa fa-close"></span></a>
                            @endif
                            @endif
                            <div class="input-group-prepend">
                                <button type="submit" id="submit2" class="input-group-text submit"
                                    style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                                    title="Search">&nbsp;Search&nbsp;</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="search-foreign" style="display: none;">
                    <form class="form-horizontal" enctype="multipart/form-data" method="GET"
                        action="{{ url('/front_end/event') }}" style="margin-top: 7px">
                        {{ csrf_field() }}
                        <div class="input-group search-event">
                            <div class="input-group-prepend">
                                <select id="search3" name="search3" class="sel-event">
                                    <option value="1" @if ($searchEvent3==1) selected @endif>Name</option>
                                    <option value="2" @if ($searchEvent3==2) selected @endif>Date</option>
                                    <option value="3" @if ($searchEvent3==3) selected @endif>Country</option>
                                    <option value="4" @if ($searchEvent3==4) selected @endif>Product</option>
                                </select>
                            </div>
                            <input type="text" id="search_name3" name="nama" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent3==1) value="{{ $param3 }}"
                                @endif>
                            {{-- <input type="date" id="search_date3" name="tanggal" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent3==2) value="{{$param3}}"
                                @endif> --}}
                            <input type="month" id="search_date3" name="tanggal" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent3==2) value="{{ $param3 }}"
                                @endif>
                            <select class="form-control select2 search " name="country" id="search_country3"
                                style="width:70%;height:40px; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;">
                                <option value=""></option>
                            </select>
                            <select class="form-control select2 search " name="product" id="search_product3"
                                style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;">
                                <option value=""></option>
                            </select>
                            @if (isset($param3))
                            @if ($param3 != null)
                            <a href="{{ url('/front_end/event') }}" class="btn btn-sm btn-default"
                                style=" border-top: 2px solid #1a70bb; border-right: 2px solid #1a70bb;border-bottom: 2px solid #1a70bb;border-left: 2px solid #1a70bb;"
                                title="Reset All Filter"><span class="fa fa-close"></span></a>
                            @endif
                            @endif
                            <div class="input-group-prepend">
                                <button type="submit" id="submit3" class="input-group-text submit search"
                                    style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                                    title="Search">&nbsp;Search&nbsp;</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<div style="background-color: white;">
    <div class="container ">
        <ul class="nav nav-tabs" id="tab1">
            <li class="nav-item tabmin">
                <button class="tablinks rounded-top" id="buttonall"
                    onclick="openTab(event, 'all')">@lang("frontend.jdl_event1")</button>
                {{-- <a class="nav-link show active" data-toggle="tab" id="all" href="#all">All</a> --}}
            </li>
            <li class="nav-item tabmin">
                <button class="tablinks rounded-top" id="buttonindonesia"
                    onclick="openTab(event, 'indonesia')">@lang("frontend.jdl_event2")</button>
                {{-- <a class="nav-link show" data-toggle="tab" id="indonesia" href="#indonesia">Indonesia</a> --}}
            </li>
            <li class="nav-item tabmin">
                <button class="tablinks rounded-top" id="buttonforeign"
                    onclick="openTab(event, 'foreign')">@lang("frontend.jdl_event3")</button>
                {{-- <a class="nav-link show" data-toggle="tab" id="foreign" href="#foreign">Foreign</a> --}}
            </li>
        </ul>
    </div>
    {{-- tab all start --}}
    <div class="tabcontent" id="all" style="display:none;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6" style="padding-right: 0px;"><br>
                    <span style="color: #114777;">
                        <h2><b>@lang("frontend.jdl_event")</b></h2>
                    </span>
                </div>
                <div class="col-md-6 col-lg-6" align="right"><br>

                </div>
                <!--       <div class="col-md-6 col-lg-3"></div> -->
            </div><br>
            @if ($page > 1 || $searchEvent != null)
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row shop_wrapper">
                        @endif
                        @foreach ($e_detail as $key => $ed)
                        <?php
                            $tag = '';
                            $nowDate = Carbon\Carbon::now();
                            $limit = Carbon\Carbon::parse($ed->limit)->endOfDay();
                            if ($ed->limit != '' && $limit->gte($nowDate)) {
                                $tag = '<div class="hot-type" style="left: 57%; top: 88px; width: 200px; font-size: 13px;"><span class="hot-type-content" style="background: #009688;">REGISTER OPEN</span></div>';
                            }
                        ?>
                        @if ($page == 1 && $searchEvent == null)
                        @if ($key == 0 || $key == 4 || $key == 8)
                        <div class="form-group row utama" style="height: 100%;margin-bottom: unset">
                            @endif
                            @endif

                            @if ($page == 1 && $searchEvent == null)
                            <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                                <a href="{{ url('/front_end/join_event/') }}/{{ $ed->id }}" class="a-modif">
                                    <?php $size = 162;
                            $num_char = 25; ?>
                                    {!! $tag !!}
                                    <div class="kontennya"
                                        style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px; border: 2px solid #e7e7e7;">
                                        @else
                                        <div class="col-lg-3 col-md-3 col-12 second a-modif small" style="margin-bottom: 24px;">
                                            <a href="{{ url('/front_end/join_event/') }}/{{ $ed->id }}" class="a-modif">
                                                {!! $tag !!}
                                                <div class="kontennya"
                                                    style="width: 100%;padding: 12px; background-color: #f8f8f8; margin-bottom:unset; border-radius: 10px;border: 2px solid #e7e7e7;">
                                                    <?php $size = 162;
                                            $num_char = 25; ?>
                                                    @endif

                                                    @if ($page == 1 && $searchEvent == null)
                                                    @if ($key > 0 && $key < 5) {{-- @if ($key==1) <div
                                                        class="form-group row" style="height: 100%;">
                                                        @endif --}}
                                                        <!-- <div class="col-lg-6 col-md-6 col-12 a-modif" style="height: 50%; border-radius: 10px; background-color: white;">
                        {{-- <?php $size = 162;
$num_char = 25; ?> --}}
                        <div class="kontennya" style="width: 100%;padding: 12px; margin-bottom: 10px; background-color: #f8f8f8; border-radius: 10px"> -->
                                                        @endif
                                                        @endif
                                                        <?php
                if ($loc == 'ch') {
                    if ($ed->event_name_chn != null) {
                        $title = $ed->event_name_chn;
                    } else {
                        $title = $ed->event_name_en;
                    }
                } elseif ($loc == 'in') {
                    if ($ed->event_name_in != null) {
                        $title = $ed->event_name_in;
                    } else {
                        $title = $ed->event_name_en;
                    }
                } else {
                    $title = $ed->event_name_en;
                }
                
                if (date('Y-m-d', strtotime($ed->start_date)) == date('Y-m-d', strtotime($ed->end_date))) {
                    $tanggal = date('d M Y', strtotime($ed->start_date));
                } elseif (date('Y-m', strtotime($ed->start_date)) == date('Y-m', strtotime($ed->end_date))) {
                    $tanggal = date('d', strtotime($ed->start_date)) . ' - ' . date('d M Y', strtotime($ed->end_date));
                } else {
                    $tanggal = date('d M Y', strtotime($ed->start_date)) . ' - ' . date('d M Y', strtotime($ed->end_date));
                }
                
                $lokasi = EventPlaceName($ed->id_event_place, $loc);
                
                if (Auth::guard('eksmp')->user()) {
                    $id_ = Auth::guard('eksmp')->user()->id;
                    $data = DB::table('event_company_add')
                        ->where('id_itdp_profil_eks', $id_)
                        ->where('id_event_detail', $ed->id)
                        ->first();
                    if ($data) {
                        $statt = $data->status;
                    } else {
                        $statt = null;
                    }
                } else {
                    $statt = null;
                }
                
                $image = 'uploads/Event/Image/' . $ed->id . '/' . $ed->image_1;
                if ($ed->image_1 != null || $ed->image_1 != '') {
                    if (file_exists($image)) {
                        $image = 'uploads/Event/Image/' . $ed->id . '/' . $ed->image_1;
                    } else {
                        $image = '/image/event/NoPicture.png';
                    }
                } else {
                    $image = '/image/event/NoPicture.png';
                }
                
                if (strlen($title) > $num_char - 5) {
                    $cut_text = substr($title, 0, $num_char - 5);
                    if ($title[$num_char - 5 - 1] != ' ') {
                        $new_pos = strrpos($cut_text, ' ');
                        $cut_text = substr($title, 0, $new_pos);
                    }
                    $titleName = $cut_text . '...';
                } else {
                    $titleName = $title;
                }
                
                if (strlen($lokasi) > $num_char + 11) {
                    $cut_text = substr($lokasi, 0, $num_char + 11);
                    if ($lokasi[$num_char + 11 - 1] != ' ') {
                        $new_pos = strrpos($cut_text, ' ');
                        $cut_text = substr($lokasi, 0, $new_pos);
                    }
                    $lokasiName = $cut_text . '...';
                } else {
                    $lokasiName = $lokasi;
                }
                ?>

                                                        <div
                                                            style="width: 100%; height: 75%; margin: auto; text-align: center;">
                                                            <img class="rc fix-image" src="{{ url('/') }}/{{ $image }}"
                                                                style="height: 200px;width: 200px;">
                                                        </div>
                                                        <div style="height: 25%; padding-top: 5px;">
                                                            <span class="css-title" title="{{ $title }}">{{ $titleName
                                                                }}<span class="badge badge-primary"
                                                                    style="font-size: 11px !important; vertical-align: middle; background-color: #387bbf; margin-left: 10px;">{{
                                                                    getDataInterest($ed->id) }}&nbsp;&nbsp;<i
                                                                        class="fa fa-eye"></i></span></span><br>
                                                            <span class="detail_rc" title="{{ $lokasi }}">
                                                                <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{
                                                                $tanggal }}
                                                                <br>
                                                                <i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;{{
                                                                $lokasiName }}<br>
                                                            </span>
                                                        </div>
                                            </a>
                                        </div>
                                    </div>
                                    @if ($page == 1 && $searchEvent == null)
                                    @if ($key == 3 || $key == 7)
                            </div>
                            <br>
                            @endif
                            {{-- Bisa Jadi Disini Nambah Tutup DIV nya --}}
                            @endif

                            @endforeach

                            @if ($page > 1)
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <br><br>
            <div class="row">
                <div class="container">
                    <div class="row justify-content-center" align="center" id="paginate1">
                        {{ $e_detail->fragment('page_a')->render('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            <br>
            @if ($page == 1)
        </div>
    </div>
    @else
</div>
@endif


{{-- Ditambah 2 Div Jangan Dihapus Karena Kalo Dihapus Divnya, maka tab lain gak akan bisa diliat start --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- Ditambah 2 Div Jangan Dihapus Karena Kalo Dihapus Divnya, maka tab lain gak akan bisa diliat end --}}
{{-- tab all end --}}
{{-- tab indonesia start --}}
<div class="tabcontent" id="indonesia" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6" style="padding-right: 0px;"><br>
                <span style="color: #114777;">
                    <h2><b>@lang("frontend.jdl_event")</b></h2>
                </span>
            </div>
            <div class="col-md-6 col-lg-6" align="right"><br>

            </div>
            <!--       <div class="col-md-6 col-lg-3"></div> -->
        </div><br>
        @if ($page2 > 1 || $searchEvent2 != null)
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row shop_wrapper">
                    @endif
                    @foreach ($e_detail2 as $key2 => $ed2)
                    <?php
                        $tag = '';
                        $nowDate = Carbon\Carbon::now();
                        $limit = Carbon\Carbon::parse($ed2->limit)->endOfDay();
                        if ($ed2->limit != '' && $limit->gte($nowDate)) {
                            $tag = '<div class="hot-type" style="left: 57%; top: 88px; width: 200px; font-size: 13px;"><span class="hot-type-content" style="background: #009688;">REGISTER OPEN</span></div>';
                        }
                    ?>
                    @if ($page2 == 1 && $searchEvent2 == null)
                    @if ($key2 == 0 || $key2 == 4 || $key2 == 8)
                    <div class="form-group row utama" style="height: 100%;margin-bottom: unset">
                        @endif
                        @endif

                        @if ($page2 == 1 && $searchEvent2 == null)
                        <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                            <a href="{{ url('/front_end/join_event/') }}/{{ $ed2->id }}" class="a-modif">
                                <?php $size = 162;
                        $num_char = 25; ?>
                                {!! $tag !!}
                                <div class="kontennya"
                                    style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px; border: 2px solid #e7e7e7;">
                                    @else
                                    <div class="col-lg-3 col-md-3 col-12 second a-modif small" style="margin-bottom: 24px;">
                                        <a href="{{ url('/front_end/join_event/') }}/{{ $ed2->id }}" class="a-modif">
                                            {!! $tag !!}
                                            <div class="kontennya"
                                                style="width: 100%;padding: 12px; background-color: #f8f8f8; margin-bottom:unset; border-radius: 10px;border: 2px solid #e7e7e7;">
                                                <?php $size = 162;
                                        $num_char = 25; ?>
                                                @endif

                                                @if ($page2 == 1 && $searchEvent2 == null)
                                                @if ($key2 > 0 && $key2 < 5) {{-- @if ($key2==1) <div
                                                    class="form-group row" style="height: 100%;">
                                                    @endif --}}
                                                    <!-- <div class="col-lg-6 col-md-6 col-12 a-modif" style="height: 50%; border-radius: 10px; background-color: white;">
                        {{-- <?php $size = 162;
$num_char = 25; ?> --}}
                        <div class="kontennya" style="width: 100%;padding: 12px; margin-bottom: 10px; background-color: #f8f8f8; border-radius: 10px"> -->
                                                    @endif
                                                    @endif
                                                    <?php
            if ($loc == 'ch') {
                if ($ed2->event_name_chn != null) {
                    $title = $ed2->event_name_chn;
                } else {
                    $title = $ed2->event_name_en;
                }
            } elseif ($loc == 'in') {
                if ($ed2->event_name_in != null) {
                    $title = $ed2->event_name_in;
                } else {
                    $title = $ed2->event_name_en;
                }
            } else {
                $title = $ed2->event_name_en;
            }
            
            if (date('Y-m-d', strtotime($ed2->start_date)) == date('Y-m-d', strtotime($ed2->end_date))) {
                $tanggal = date('d M Y', strtotime($ed2->start_date));
            } elseif (date('Y-m', strtotime($ed2->start_date)) == date('Y-m', strtotime($ed2->end_date))) {
                $tanggal = date('d', strtotime($ed2->start_date)) . ' - ' . date('d M Y', strtotime($ed2->end_date));
            } else {
                $tanggal = date('d M Y', strtotime($ed2->start_date)) . ' - ' . date('d M Y', strtotime($ed2->end_date));
            }
            
            $lokasi = EventPlaceName($ed2->id_event_place, $loc);
            
            if (Auth::guard('eksmp')->user()) {
                $id_ = Auth::guard('eksmp')->user()->id;
                $data = DB::table('event_company_add')
                    ->where('id_itdp_profil_eks', $id_)
                    ->where('id_event_detail', $ed2->id)
                    ->first();
                if ($data) {
                    $statt = $data->status;
                } else {
                    $statt = null;
                }
            } else {
                $statt = null;
            }
            
            $image = 'uploads/Event/Image/' . $ed2->id . '/' . $ed2->image_1;
            if ($ed2->image_1 != null || $ed2->image_1 != '') {
                if (file_exists($image)) {
                    $image = 'uploads/Event/Image/' . $ed2->id . '/' . $ed2->image_1;
                } else {
                    $image = '/image/event/NoPicture.png';
                }
            } else {
                $image = '/image/event/NoPicture.png';
            }
            
            if (strlen($title) > $num_char - 5) {
                $cut_text = substr($title, 0, $num_char - 5);
                if ($title[$num_char - 5 - 1] != ' ') {
                    $new_pos = strrpos($cut_text, ' ');
                    $cut_text = substr($title, 0, $new_pos);
                }
                $titleName = $cut_text . '...';
            } else {
                $titleName = $title;
            }
            
            if (strlen($lokasi) > $num_char + 11) {
                $cut_text = substr($lokasi, 0, $num_char + 11);
                if ($lokasi[$num_char + 11 - 1] != ' ') {
                    $new_pos = strrpos($cut_text, ' ');
                    $cut_text = substr($lokasi, 0, $new_pos);
                }
                $lokasiName = $cut_text . '...';
            } else {
                $lokasiName = $lokasi;
            }
            ?>

                                                    <div
                                                        style="width: 100%; height: 75%; margin: auto; text-align: center;">
                                                        <img class="rc fix-image" src="{{ url('/') }}/{{ $image }}"
                                                            style="height: 200px;width: 200px;">
                                                    </div>
                                                    <div style="height: 25%; padding-top: 5px;">
                                                        <span class="css-title" title="{{ $title }}">{{ $titleName
                                                            }}<span class="badge badge-primary"
                                                                style="font-size: 11px !important; vertical-align: middle; background-color: #387bbf; margin-left: 10px;">{{
                                                                getDataInterest($ed2->id) }}&nbsp;&nbsp;<i
                                                                    class="fa fa-eye"></i></span></span><br>
                                                        <span class="detail_rc" title="{{ $lokasi }}">
                                                            <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{
                                                            $tanggal }}
                                                            <br>
                                                            <i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;{{
                                                            $lokasiName }}<br>
                                                        </span>
                                                    </div>
                                        </a>
                                    </div>
                                </div>


                                @if ($page2 == 1 && $searchEvent2 == null)
                                @if ($key2 == 3 || $key2 == 7)
                        </div>
                        <br>
                        @endif
                        {{-- Bisa Jadi Disini Nambah Tutup DIV nya --}}
                        @endif

                        @endforeach
                        @if ($page2 > 1)
                    </div>
                </div>
            </div>
            @endif
        </div>
        <br><br>
        <div class="row">
            <div class="container">
                <div class="row justify-content-center" align="center" id="paginate2">
                    {{ $e_detail2->fragment('page_b')->render('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        <br>
        <!-- </div> -->

        @if ($page2 == 1)
    </div>
</div>
@else
</div>
@endif


{{-- </div> --}}
{{-- tab indonesia end --}}


{{-- tab foreign start --}}
<div class="tabcontent" id="foreign" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6" style="padding-right: 0px;"><br>
                <span style="color: #114777;">
                    <h2><b>@lang("frontend.jdl_event")</b></h2>
                </span>
            </div>
            <div class="col-md-6 col-lg-6" align="right"><br>

            </div>
            <!--       <div class="col-md-6 col-lg-3"></div> -->
        </div><br>
        @if ($page3 > 1 || $searchEvent3 != null)
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row shop_wrapper">
                    @endif
                    @foreach ($e_detail3 as $key3 => $ed3)
                    <?php
                        $tag = '';
                        $nowDate = Carbon\Carbon::now();
                        $limit = Carbon\Carbon::parse($ed->limit)->endOfDay();
                        if ($ed->limit != '' && $limit->gte($nowDate)) {
                            $tag = '<div class="hot-type" style="left: 57%; top: 88px; width: 200px; font-size: 13px;"><span class="hot-type-content" style="background: #009688;">REGISTER OPEN</span></div>';
                        }
                    ?>
                    @if ($page3 == 1 && $searchEvent3 == null)
                    @if ($key3 == 0 || $key3 == 4 || $key3 == 8)
                    <div class="form-group row utama" style="height: 100%;margin-bottom: unset">
                        @endif
                        @endif

                        @if ($page3 == 1 && $searchEvent3 == null)
                        <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                            <a href="{{ url('/front_end/join_event/') }}/{{ $ed3->id }}" class="a-modif">
                                <?php $size = 162;
                        $num_char = 25; ?>
                                {!! $tag !!}
                                <div class="kontennya"
                                    style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px; border: 2px solid #e7e7e7;">
                                    @else
                                    <div class="col-lg-3 col-md-3 col-12 second a-modif small" style="margin-bottom: 24px;">
                                        <a href="{{ url('/front_end/join_event/') }}/{{ $ed3->id }}" class="a-modif">
                                            {!! $tag !!}
                                            <div class="kontennya"
                                                style="width: 100%;padding: 12px; background-color: #f8f8f8; margin-bottom:unset; border-radius: 10px; border: 2px solid #e7e7e7;">
                                                <?php $size = 162;
                                        $num_char = 25; ?>
                                                @endif

                                                @if ($page3 == 1 && $searchEvent3 == null)
                                                @if ($key3 > 0 && $key3 < 5) {{-- @if ($key3==1) <div
                                                    class="form-group row" style="height: 100%;">
                                                    @endif --}}
                                                    <!-- <div class="col-lg-6 col-md-6 col-12 a-modif" style="height: 50%; border-radius: 10px; background-color: white;">
                        {{-- <?php $size = 162;
$num_char = 25; ?> --}}
                        <div class="kontennya" style="width: 100%;padding: 12px; margin-bottom: 10px; background-color: #f8f8f8; border-radius: 10px"> -->
                                                    @endif
                                                    @endif
                                                    <?php
                                                        if ($loc == 'ch') {
                                                            if ($ed3->event_name_chn != null) {
                                                                $title = $ed3->event_name_chn;
                                                            } else {
                                                                $title = $ed3->event_name_en;
                                                            }
                                                        } elseif ($loc == 'in') {
                                                            if ($ed3->event_name_in != null) {
                                                                $title = $ed3->event_name_in;
                                                            } else {
                                                                $title = $ed3->event_name_en;
                                                            }
                                                        } else {
                                                            $title = $ed3->event_name_en;
                                                        }
                                                        
                                                        if (date('Y-m-d', strtotime($ed3->start_date)) == date('Y-m-d', strtotime($ed3->end_date))) {
                                                            $tanggal = date('d M Y', strtotime($ed3->start_date));
                                                        } elseif (date('Y-m', strtotime($ed3->start_date)) == date('Y-m', strtotime($ed3->end_date))) {
                                                            $tanggal = date('d', strtotime($ed3->start_date)) . ' - ' . date('d M Y', strtotime($ed3->end_date));
                                                        } else {
                                                            $tanggal = date('d M Y', strtotime($ed3->start_date)) . ' - ' . date('d M Y', strtotime($ed3->end_date));
                                                        }
                                                        
                                                        $lokasi = EventPlaceName($ed3->id_event_place, $loc);
                                                        
                                                        if (Auth::guard('eksmp')->user()) {
                                                            $id_ = Auth::guard('eksmp')->user()->id;
                                                            $data = DB::table('event_company_add')
                                                                ->where('id_itdp_profil_eks', $id_)
                                                                ->where('id_event_detail', $ed3->id)
                                                                ->first();
                                                            if ($data) {
                                                                $statt = $data->status;
                                                            } else {
                                                                $statt = null;
                                                            }
                                                        } else {
                                                            $statt = null;
                                                        }
                                                        
                                                        $image = 'uploads/Event/Image/' . $ed3->id . '/' . $ed3->image_1;
                                                        if ($ed3->image_1 != null || $ed3->image_1 != '') {
                                                            if (file_exists($image)) {
                                                                $image = 'uploads/Event/Image/' . $ed3->id . '/' . $ed3->image_1;
                                                            } else {
                                                                $image = '/image/event/NoPicture.png';
                                                            }
                                                        } else {
                                                            $image = '/image/event/NoPicture.png';
                                                        }
                                                        
                                                        if (strlen($title) > $num_char - 5) {
                                                            $cut_text = substr($title, 0, $num_char - 5);
                                                            if ($title[$num_char - 5 - 1] != ' ') {
                                                                $new_pos = strrpos($cut_text, ' ');
                                                                $cut_text = substr($title, 0, $new_pos);
                                                            }
                                                            $titleName = $cut_text . '...';
                                                        } else {
                                                            $titleName = $title;
                                                        }
                                                        
                                                        if (strlen($lokasi) > $num_char + 11) {
                                                            $cut_text = substr($lokasi, 0, $num_char + 11);
                                                            if ($lokasi[$num_char + 11 - 1] != ' ') {
                                                                $new_pos = strrpos($cut_text, ' ');
                                                                $cut_text = substr($lokasi, 0, $new_pos);
                                                            }
                                                            $lokasiName = $cut_text . '...';
                                                        } else {
                                                            $lokasiName = $lokasi;
            }
            ?>

                                                    <div
                                                        style="width: 100%; height: 75%; margin: auto; text-align: center;">
                                                        <img class="rc fix-image" src="{{ url('/') }}/{{ $image }}"
                                                            style="height: 200px;width: 200px;">
                                                    </div>
                                                    <div style="height: 25%; padding-top: 5px;">
                                                        <span class="css-title" title="{{ $title }}">{{ $titleName
                                                            }}<span class="badge badge-primary"
                                                                style="font-size: 11px !important; vertical-align: middle; background-color: #387bbf; margin-left: 10px;">{{
                                                                getDataInterest($ed3->id) }}&nbsp;&nbsp;<i
                                                                    class="fa fa-eye"></i></span></span><br>
                                                        <span class="detail_rc" title="{{ $lokasi }}">
                                                            <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{
                                                            $tanggal }}
                                                            <br>
                                                            <i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;{{
                                                            $lokasiName }}<br>
                                                        </span>
                                                    </div>
                                        </a>
                                    </div>
                                </div>

                                @if ($page3 == 1 && $searchEvent3 == null)
                                @if ($key3 == 3 || $key3 == 7)
                        </div>
                        <br>
                        @endif
                        {{-- Bisa Jadi Disini Nambah Tutup DIV nya --}}
                        @endif

                        @endforeach

                        @if ($page3 > 1)
                    </div>
                </div>
                @endif

            </div>
            <br><br>
            <div class="row">
                <div class="container">
                    <div class="row justify-content-center" align="center" id="paginate3">
                        {{ $e_detail3->fragment('page_c')->render('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            <br>
            <!-- </div> -->


            @if ($page3 == 1)
        </div>
    </div>
    @else
</div>
@endif
{{-- tab foreign end --}}
</div>
<input type="hidden" id="urlprev" value="">

<div style="margin-top: 0px; margin-bottom: 5%; background-color: white;"></div>
</div>
@include('frontend.layouts.footer')
<script type="text/javascript">
    // document.onload
    // $('#paginate1').click(function(){
    //
    // });
    // $('#paginate2').click(function(){
    //     document.getElementById('indonesia').style.display = "block";
    // });
    // $('#paginate3').click(function(){
    //     alert('paginate3');
    // });

    function openTab(evt, Tabname) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        $('#' + Tabname).show();
        $('#button' + Tabname).addClass('active');
        var halaman = Tabname;
        if (Tabname == 'all') {
            localStorage.setItem("tabevent", "all");
            document.getElementById('all').style.display = "block";

            document.getElementById('search-all').style.display = "block";
            document.getElementById('search-indonesia').style.display = "none";
            document.getElementById('search-foreign').style.display = "none";
        } else if (Tabname == 'indonesia') {
            localStorage.setItem("tabevent", "indonesia");
            document.getElementById('indonesia').style.display = "block";

            document.getElementById('search-all').style.display = "none";
            document.getElementById('search-indonesia').style.display = "block";
            document.getElementById('search-foreign').style.display = "none";
        } else if (Tabname == 'foreign') {
            localStorage.setItem("tabevent", "foreign");
            document.getElementById('foreign').style.display = "block";

            document.getElementById('search-all').style.display = "none";
            document.getElementById('search-indonesia').style.display = "none";
            document.getElementById('search-foreign').style.display = "block";
        }
    }




    $(document).ready(function() {

        var tabnya = localStorage.getItem("tabevent");
        if (tabnya == "all") {
            $("#buttonall").click();
        } else if (tabnya == "indonesia") {
            $('#buttonindonesia').click();
        } else if (tabnya == "foreign") {
            $('#buttonforeign').click();
        } else {
            // ditambahin disini;
            $("#buttonall").click();
        }

        $('#search_country').select2({
            allowClear: true,
            placeholder: 'Search Country',
            ajax: {
                url: "{{ route('countryevent.getcountryall') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item.id);
                            return {
                                text: item.country,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#search_product').select2({
            allowClear: true,
            placeholder: 'Search Category Product',
            ajax: {
                url: "{{ route('categoryevent.getcategoryallevent') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item.id);
                            return {
                                text: item.nama_kategori_en,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#search_product2').select2({
            allowClear: true,
            placeholder: 'Search Category Product',
            ajax: {
                url: "{{ route('categoryevent.getcategoryindonesiaevent') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item.id);
                            return {
                                text: item.nama_kategori_en,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#search_product3').select2({
            allowClear: true,
            placeholder: 'Search Category Product',
            ajax: {
                url: "{{ route('categoryevent.getcategoryforeignevent') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item.id);
                            return {
                                text: item.nama_kategori_en,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        var searchEvent = "{{ isset($searchEvent) ? $searchEvent : '' }}";
        if (searchEvent == 3) {
            console.log(searchEvent);
            var param = "{{ isset($param) ? $param : '' }}";
            if (param != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('countryevent.getcountryall') }}",
                    data: {
                        code: param
                    }
                }).then(function(data) {
                    var option = new Option(data[0].country, data[0].id, true, true);

                    $('#search_country').append(option).trigger('change');
                });
            }
        } else if (searchEvent == 4) {
            var param = "{{ isset($param) ? $param : '' }}";
            if (param != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('categoryevent.getcategoryallevent') }}",
                    data: {
                        code: param
                    }
                }).then(function(data) {
                    var option = new Option(data[0].nama_kategori_en, data[0].id, true, true);

                    $('#search_product').append(option).trigger('change');
                });
            }
        }

        var searchEvent = "{{ isset($searchEvent) ? $searchEvent : '' }}";
        if (searchEvent == 3) {
            console.log(searchEvent);
            var param = "{{ isset($param) ? $param : '' }}";
            if (param != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('countryevent.getcountryall') }}",
                    data: {
                        code: param
                    }
                }).then(function(data) {
                    var option = new Option(data[0].country, data[0].id, true, true);

                    $('#search_country').append(option).trigger('change');
                });
            }
        }


        $('#search_country2').select2({
            allowClear: true,
            placeholder: 'Search Country',
            ajax: {
                url: "{{ route('countryevent.getcountryindonesia') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item);
                            return {
                                text: item.country,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        var searchEvent2 = "{{ isset($searchEvent2) ? $searchEvent2 : '' }}";
        if (searchEvent2 == 3) {
            var param2 = "{{ isset($param2) ? $param2 : '' }}";
            if (param2 != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('countryevent.getcountryindonesia') }}",
                    data: {
                        code: param2
                    }
                }).then(function(data) {
                    var option = new Option(data[0].country, data[0].id, true, true);

                    $('#search_country2').append(option).trigger('change');
                });
            }
        } else if (searchEvent2 == 4) {
            var param2 = "{{ isset($param2) ? $param2 : '' }}";
            if (param2 != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('categoryevent.getcategoryindonesiaevent') }}",
                    data: {
                        code: param2
                    }
                }).then(function(data) {
                    var option = new Option(data[0].nama_kategori_en, data[0].id, true, true);

                    $('#search_product2').append(option).trigger('change');
                });
            }
        }

        $('#search_country3').select2({
            allowClear: true,
            placeholder: 'Search Country',
            ajax: {
                url: "{{ route('countryevent.getcountryforeign') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item);
                            return {
                                text: item.country,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        var searchEvent3 = "{{ isset($searchEvent3) ? $searchEvent3 : '' }}";
        if (searchEvent3 == 3) {
            var param3 = "{{ isset($param3) ? $param3 : '' }}";
            if (param3 != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('countryevent.getcountryforeign') }}",
                    data: {
                        code: param3
                    }
                }).then(function(data) {
                    var option = new Option(data[0].country, data[0].id, true, true);

                    $('#search_country3').append(option).trigger('change');
                });
            }
        } else if (searchEvent3 == 4) {
            var param3 = "{{ isset($param3) ? $param3 : '' }}";
            if (param3 != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('categoryevent.getcategoryforeignevent') }}",
                    data: {
                        code: param3
                    }
                }).then(function(data) {
                    var option = new Option(data[0].nama_kategori_en, data[0].id, true, true);

                    $('#search_product3').append(option).trigger('change');
                });
            }
        }


        $(window).on('load hashchange', function() {

            var tab_id = location.hash || '';
            // Remove the hash (i.e. `#`)
            tab_id = tab_id.substring(1);
            //

            if (tab_id) {
                if (tab_id == 'page_a') {
                    document.getElementById('all').style.display = "block";
                    document.getElementById('indonesia').style.display = "none";
                    document.getElementById('foreign').style.display = "none";

                    document.getElementById('search-all').style.display = "block";
                    document.getElementById('search-indonesia').style.display = "none";
                    document.getElementById('search-foreign').style.display = "none";
                } else if (tab_id == 'page_b') {
                    document.getElementById('all').style.display = "none";
                    document.getElementById('indonesia').style.display = "block";
                    document.getElementById('foreign').style.display = "none";

                    document.getElementById('search-all').style.display = "none";
                    document.getElementById('search-indonesia').style.display = "block";
                    document.getElementById('search-foreign').style.display = "none";
                } else if (tab_id == 'page_c') {
                    document.getElementById('all').style.display = "none";
                    document.getElementById('indonesia').style.display = "none";
                    document.getElementById('foreign').style.display = "block";

                    document.getElementById('search-all').style.display = "none";
                    document.getElementById('search-indonesia').style.display = "none";
                    document.getElementById('search-foreign').style.display = "block";
                }
            }
            // else {
            //     document.getElementById('all').style.display = "block";
            //     document.getElementById('indonesia').style.display = "none";
            //     document.getElementById('foreign').style.display = "none";
            // }
        });


        if (window.innerWidth <= 760) {
            $('.fix-image').css('height', '162px');
        }

        var search = "{{ $searchEvent }}";
        if (search == 2) {
            console.log('a');
            $('#search_name').hide();
            $('#search_country').hide();
            $('#search_country').next('.select2-container').hide();
            $('#search_product').next('.select2-container').hide();
        } else if (search == 3) {
            $('#search_name').hide();
            $('#search_date').hide();
            $('#search_country').next('.select2-container').show();
            $('#search_product').next('.select2-container').hide();
        } else if (search == 4) {
            $('#search_name').hide();
            $('#search_date').hide();
            $('#search_country').hide();
            $('#search_country').next('.select2-container').hide();
            $('#search_product').next('.select2-container').show();
        } else {
            $('#search_date').hide();
            $('#search_country').hide();
            $('#search_country').next('.select2-container').hide();
            $('#search_product').next('.select2-container').hide();
        }

        var search2 = "{{ $searchEvent2 }}";
        if (search2 == 2) {
            $('#search_name2').hide();
            $('#search_country2').hide();
            $('#search_country2').next('.select2-container').hide();
            $('#search_product2').next('.select2-container').hide();
        } else if (search2 == 3) {
            $('#search_name2').hide();
            $('#search_date2').hide();
            $('#search_country2').next('.select2-container').show();
            $('#search_product2').next('.select2-container').hide();
        } else if (search2 == 4) {
            $('#search_name2').hide();
            $('#search_date2').hide();
            $('#search_country2').hide();
            $('#search_country2').next('.select2-container').hide();
            $('#search_product2').next('.select2-container').show();
        } else {
            $('#search_date2').hide();
            $('#search_country2').hide();
            $('#search_country2').next('.select2-container').hide();
            $('#search_product2').next('.select2-container').hide();
        }

        var search3 = "{{ $searchEvent3 }}";
        if (search3 == 2) {
            $('#search_name3').hide();
            $('#search_country3').hide();
            $('#search_country3').next('.select2-container').hide();
            $('#search_product3').next('.select2-container').hide();
        } else if (search3 == 3) {
            $('#search_name3').hide();
            $('#search_date3').hide();
            $('#search_country3').next('.select2-container').show();
            $('#search_product3').next('.select2-container').hide();
        } else if (search3 == 3) {
            $('#search_name3').hide();
            $('#search_date3').hide();
            $('#search_country3').next('.select2-container').hide();
            $('#search_product3').next('.select2-container').show();
        } else {
            $('#search_date3').hide();
            $('#search_country3').next('.select2-container').hide();
            $('#search_product3').next('.select2-container').hide();
        }

        $('#search').on('change', function() {
            var pilihan = this.value;
            if (pilihan == 1) {
                $('#search_name').show();
                $('#search_date').hide();
                $('#search_country').hide();
                $('#search_product').hide();

                $('#search_date').val('');
                $('#search_country').val('');
                $('#search_country').next('.select2-container').hide();
                $('#search_product').next('.select2-container').hide();
            } else if (pilihan == 2) {
                $('#search_name').hide();
                $('#search_date').show();
                $('#search_country').hide();
                $('#search_product').hide();

                $('#search_name').val('');
                $('#search_country').val('');
                $('#search_country').next('.select2-container').hide();
                $('#search_product').next('.select2-container').hide();
            } else if (pilihan == 3) {
                $('#search_name').hide();
                $('#search_date').hide();
                $('#search_country').show();
                $('#search_product').hide();

                $('#search_name').val('');
                $('#search_date').val('');
                $('#search_country').next('.select2-container').show();
                $('#search_product').next('.select2-container').hide();
            } else {
                $('#search_name').hide();
                $('#search_date').hide();
                $('#search_country').hide();
                $('#search_product').show();

                $('#search_name').val('');
                $('#search_date').val('');
                $('#search_country').next('.select2-container').hide();
                $('#search_product').next('.select2-container').show();
            }
        });

        $('#search2').on('change', function() {
            var pilihan = this.value;
            if (pilihan == 1) {
                $('#search_name2').show();
                $('#search_date2').hide();
                $('#search_country2').hide();
                $('#search_product2').hide();

                $('#search_date2').val('');
                $('#search_country2').val('');
                $('#search_country2').next('.select2-container').hide();
                $('#search_product2').next('.select2-container').hide();
            } else if (pilihan == 2) {
                $('#search_name2').hide();
                $('#search_date2').show();
                $('#search_country2').hide();
                $('#search_product2').hide();

                $('#search_name2').val('');
                $('#search_country2').val('');
                $('#search_country2').next('.select2-container').hide();
                $('#search_product2').next('.select2-container').hide();
            } else if (pilihan == 3) {
                $('#search_name2').hide();
                $('#search_date2').hide();
                $('#search_country2').show();
                $('#search_product2').hide();

                $('#search_name2').val('');
                $('#search_date2').val('');
                $('#search_country2').next('.select2-container').show();
                $('#search_product2').next('.select2-container').hide();
            } else {
                $('#search_name2').hide();
                $('#search_date2').hide();
                $('#search_country2').hide();
                $('#search_product2').show();

                $('#search_name2').val('');
                $('#search_date2').val('');
                $('#search_country2').next('.select2-container').hide();
                $('#search_product2').next('.select2-container').show();
            }
        });

        $('#search3').on('change', function() {
            var pilihan = this.value;
            if (pilihan == 1) {
                $('#search_name3').show();
                $('#search_date3').hide();
                $('#search_country3').hide();
                $('#search_product3').hide();

                $('#search_date3').val('');
                $('#search_country3').val('');
                $('#search_country3').next('.select2-container').hide();
                $('#search_product3').next('.select2-container').hide();
            } else if (pilihan == 2) {
                $('#search_name3').hide();
                $('#search_date3').show();
                $('#search_country3').hide();
                $('#search_product3').hide();

                $('#search_name3').val('');
                $('#search_country3').val('');
                $('#search_country3').next('.select2-container').hide();
                $('#search_product3').next('.select2-container').hide();
            } else if (pilihan == 3) {
                $('#search_name3').hide();
                $('#search_date3').hide();
                $('#search_country3').show();
                $('#search_product3').hide();

                $('#search_name3').val('');
                $('#search_date3').val('');
                $('#search_country3').next('.select2-container').show();
                $('#search_product3').next('.select2-container').hide();
            } else {
                $('#search_name3').hide();
                $('#search_date3').hide();
                $('#search_country3').hide();
                $('#search_product3').show();

                $('#search_name3').val('');
                $('#search_date3').val('');
                $('#search_country3').next('.select2-container').hide();
                $('#search_product3').next('.select2-container').show();
            }
        });
    })

    // function reset(){
    //     $('#search_name').val('');
    //     $('#search_date').val('');
    //     $('#search_country').val('');

    //     $('#submit').click();
    // }



    $(window).bind('hashchange', function() {
        alert('tes');
    });

    // $('.pagination').onclick()
</script>