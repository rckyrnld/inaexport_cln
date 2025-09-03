@include('frontend.layouts.header')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css" rel="stylesheet">
<style type="text/css">
    .form-control:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
    }

    .search {
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
        border-left: 2px solid #1a70bb;
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

    .custom-card {
        float: left !important;
        border: 1px solid rgba(35, 35, 51, .08) !important;
        box-shadow: 0 2px 2px #ccc !important;
        border-radius: 8px !important;
        margin: 0 0px 27px 0 !important;
        min-height: 220px !important;
        position: relative !important;
    }

    .custom-card>.title {
        font-size: 24px;
        max-height: 68px;
        overflow: hidden;
        padding-bottom: 10px;
    }

    p.title-event {
        font-size: 20px;
        font-family: "Lato", Helvetica, Arial
    }

    p.date-event {
        /* font-size: 10px; */
        font-family: "Lato", Helvetica, Arial;
        color: #F26D21;
        font-weight: 700;
        padding-bottom: -5px;
    }

    p {
        margin-top: 0;
        margin-bottom: 0.5rem;
    }

    .header img {
        float: left;
    }

    .header h2 {
        position: relative;
        top: 3px;
        left: -10px;
    }

    .btn-rounded {
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        margin-top: -2px;
        padding: 0 12px;
        height: 32px;
        line-height: 32px;
        min-width: 112px;
        border-radius: 8px;
        margin-right: 40px;
    }

    .title-duration {
        padding-bottom: 15px;
    }

    .cardour:hover {
        text-decoration: none;
        background-color: #f4f4f5;
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

    .cardour button.active {
        background-color: #1a70bb;
        color: white;
    }

    .card-body:hover {
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

    .btn-clear-search {
        display: none;
    }
    table td, table td * {
        vertical-align: top;
    }
    .fa, .fab, .fad, .fal, .far, .fas {
        line-height:inherit;
    }
</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12">
                <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                    <ul>
                        <li><a href="{{ url('/') }}">@lang("frontend.proddetail.home")</a></li>
                        <li>Trade Inquiry</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <form action="{{ url('/') }}/front_end/ourinqueris/search" method="GET" role="search">
                    {{-- {!! csrf_field() !!} --}}
                    <div class="input-group" style="margin-top: 7px;">
                        <input type="text" class="form-control search-field search"
                            placeholder="Enter a keyword to search trade inquiry" style="height: 40px;" name="nama"
                            value="{{ $nama }}">
                        <button type="button" class="btn bg-transparent btn-clear-search"
                            style="margin-left: -40px; z-index: 100;">
                            <i class="fa fa-times"></i>
                        </button>
                        <button
                            style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                            class="btn" type="submit" name="search" id="search">Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<div class="container" style="background-color: white; padding-bottom: 3%;">
    <div class="row mt-4">
        <div class="col col-lg-6 col-md-12 pl-3">
            <span style="color: #black;">
                <div class="header">
                    <h2 style="color: #114777;"><b>Trade Inquiry</b></h2>
                </div>
            </span>
        </div>
        <div class="col col-lg-6 col-md-12 text-right">

        </div>
    </div>
    <div class="row pt-4">
        @if (count($data_inquiry) > 0)
            @foreach ($data_inquiry as $df)
                <div class="col-lg-3 col-md-4 col-sm-6 d-flex align-items-stretch">
                    <div class="card custom-card w-100 cardour">
                        <div class="card-body" style="padding-bottom: 0px;">
                            <p class="title-event"><b>{{ $df['subyek'] }}</b></p>
                            <?php date_default_timezone_set('Asia/Jakarta'); ?>
                            <table>
                                <tr>
                                    <td><i class="fas fa-clock"></i></td>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>{{ strtoupper(date('d M Y', strtotime($df['date']))) }}</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-map-marker"></i></td>
                                    <td>Buyer Dari</td>
                                    <td>:</td>
                                    <td>{{ $df['country'] }}</td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-box"></i></td>
                                    <td>Produk</td>
                                    <td>:</td>
                                    <td>{{ $df['subyek'] }}</td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-weight"></i></td>
                                    <td>Qty. Order</td>
                                    <td>:</td>
                                    <td>{{ $df['eo'] }} {{ $df['neo'] }}</td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-clipboard-check"></i></td>
                                    <td>
                                        @if ($df['valid'] == 0)
                                            Masa Aktif
                                        @else
                                            @if ($df['valid_days'] == 1)
                                                Masa Aktif
                                            @elseif($df['valid_days'] > 1)
                                                Masa Aktif
                                            @elseif ($df['valid_days'] < 1) Masa Aktif @endif
                                        @endif
                                    </td>
                                    <td>:</td>
                                    <td>
                                        @if ($df['valid'] == 0)
                                            Selesai
                                        @else
                                            @if ($df['valid_days'] == 1)
                                                {{ ltrim($df['valid_days'], '0') }} Hari
                                            @elseif($df['valid_days'] > 1)
                                                {{ ltrim($df['valid_days'], '0') }} Hari
                                            @elseif ($df['valid_days'] < 1)Selesai @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="far fa-user"></i></td>
                                    <td width="35%">Di Download</td>
                                    <td>:</td>
                                    <td>
                                        @if ($df['tertarik'] > 0)
                                            {{ $df['tertarik'] }} Perusahaan
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            {{-- <p class="date-event" style="font-size: 13px;"><i class="fas fa-clock"></i> Tanggal :
                                {{ strtoupper(date('d M Y', strtotime($df['date']))) }}
                            </p> --}}
                            {{-- <p>
                                <i class="fa fa-map-marker"></i> Buyer Dari : {{ $df['country'] }}
                            </p> --}}
                            {{-- <p>
                                <i class="fas fa-box"></i> Produk : {{ $df['subyek'] }}
                            </p> --}}
                            {{-- <p>
                                <i class="fas fa-weight"></i> Perkiraan Order : {{ $df['eo'] }} {{ $df['neo'] }}
                            </p> --}}
                            {{-- <p> <i class="fas fa-clipboard-check"></i>
                                @if ($df['valid'] == 0)
                                    Masa Berlaku : No Limit
                                @else
                                    @if ($df['valid_days'] == 1)
                                        Masa Berlaku : {{ ltrim($df['valid_days'], '0') }} Hari
                                    @elseif($df['valid_days'] > 1)
                                        Masa Berlaku : {{ ltrim($df['valid_days'], '0') }} Hari
                                    @elseif ($df['valid_days'] < 1) Masa Berlaku : Selesai @endif
                                @endif
                            </p> --}}
                            {{-- <p>
                                @if ($df['tertarik'] > 0)
                                    <i class="far fa-user"></i> Sudah Di Download : {{ $df['tertarik'] }}
                                @else
                                    <i class="far fa-user"></i> Sudah Di Download : -
                                @endif
                            </p> --}}
                            <?php
                            if (Auth::guard('eksmp')->user()) {
                                if (Auth::guard('eksmp')->user()->id_role == 2) {
                                    $jns = 'eksportir';
                                } elseif (Auth::guard('eksmp')->user()->id_role == 3) {
                                    $jns = 'importir';
                                }
                            } else {
                                $jns = 'not login';
                            }
                            ?>
                            <br>
                            @if ($jns == 'eksportir' && $df['valid_days'] > 0)
                                <button class="mb-4 btn"
                                    style="background-color: #ffe300; border-radius: 20px;color:#1d7bff;" id="interest"
                                    onclick="openInquiry('{{ $jns }}','{{ $df['id'] }}')"><b><i
                                            class="fas fa-download">
                                            Download </i></b></button>
                            @elseif($jns == 'not login' && $df['valid_days'] > 0)
                                <button class="mb-4 btn"
                                    style="background-color: #ffe300; border-radius: 20px;color:#1d7bff;" id="interest"
                                    onclick="openInquiry('{{ $jns }}','{{ $df['id'] }}')"><b> <i
                                            class="fas fa-download">
                                            Download</i></b></button>
                            @elseif($df['valid_days'] > 0)
                                <button class="mb-4 btn"
                                    style="background-color: #ffe300; border-radius: 20px;color:#1d7bff; display:none;"
                                    id="interest"
                                    onclick="openInquiry('{{ $jns }}','{{ $df['id'] }}')"><b><i
                                            class="fas fa-download">
                                            Download</i></b></button>
                            @endif
                        </div>
                    </div>
                </div>

            @endforeach
        @else
            <div class="col-lg-12 d-flex justify-content-center">
                <p>Sorry, We can't find match data</p>
            </div>
        @endif
        <div class="col-lg-12 d-flex justify-content-center pt-4">
            {{-- {{ $datanya->links('vendor.pagination.bootstrap-4') }}
            {{ $datanya->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }} --}}
            {!! str_replace('/?', '?', $data_inquiry->links('pagination::bootstrap-4')) !!}
        </div>
    </div>
</div>
</div>

<?php
$loc = app()->getLocale();
if ($loc == 'ch') {
    $alertnot = '请登录进行查询';
} elseif ($loc == 'in') {
    $alertnot = 'Silahkan Login sebagai supplier untuk mendownload Inquiry.';
} else {
    $alertnot = 'Please sign as a supplier to download the inquiry.';
}
?>
@include('frontend.layouts.footer')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script type="text/javascript">
    function openInquiry(bagian, id) {
        if (bagian == "not login") {
            alert("{{ $alertnot }}");
            if (window.confirm('Are you want go to login page?')) {
                let url = "{{ url('/login?redirect='.encrypt('trade_inquiry')) }}"
                window.location = url;
            }
        } else if (bagian == "eksportir") {
            var url = "{{ url('/ourinquiries_join/') }}"
            window.location = url + "/" + id;
            $.get(
                "{{ route('front_end.get.data.id') }}", {
                    id: id
                },
                function(res) {}
            );
        } else {
            $("#interest").hide();
        }
    }

    $(function() {
        $(".search-field").on("input", function() {
            $(this).next().toggle(this.value != "");
        });
        $(".search-field").on("blur", function() {
            if (this.value == "") $(this).next().fadeOut('medium');
        })
        $(".search-field").on("focus", function() {
            $(this).next().fadeIn('medium');
        })

        $(".btn-clear-search").click(function() {
            $(".search-field").val('');
            $("#search").click();
        })
    })
</script>
