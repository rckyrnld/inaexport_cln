@include('frontend.layouts.header')

<style>
    .zoom-effect {
        position: relative;
        overflow: hidden;
    }

    .kotak {
        position: absolute;

    }

    .zoom-effect:hover {
        -webkit-transform: scale(1.08);
        transform: scale(1.08);
    }

    .kotak img {
        -webkit-transition: 0.4s ease;
        transition: 0.4s ease;
    }

    @media screen and (max-width: 564px) {
        .kotak img {
            max-width: 220px;
            max-height: 220px;

        }

        /* .zoom-effect {
            height: 150px;
        } */
    }

    @media screen and (min-width: 565px) {
        .kotak img {
            max-width: 220px;
            max-height: 220px;

        }

        /* .zoom-effect {
            height: 150px;
        } */
    }

    @media screen and (min-width: 664px) {
        .kotak img {
            max-width: 220px;
            max-height: 220px;

        }

        /* .zoom-effect {
            height: 150px;
        } */
    }

    @media screen and (min-width: 767px) {
        .kotak img {
            max-width: 220px;
            max-height: 220px;

        }

        /* .zoom-effect {
            height: 150px;
        } */
    }

    @media screen and (min-width: 1600px) {
        .kotak img {
            max-width: 220px;
            max-height: 220px;
        }

        /* .zoom-effect {
            height: 200px;
        } */
    }

    .search {
        border-left: 2px solid #1a70bb;
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
        height: 40px;
    }

</style>

<div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12">
                <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                    <ul>
                        <li><a href="{{ url('/') }}">@lang('frontend.proddetail.home')</a></li>
                        <li>News</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <form class="form-horizontal" action="{{ url('/') }}/front_end/news/search" method="POST"
                    role="search" style="margin-top: 7px">
                    {{ csrf_field() }}
                    <div class="input-group" style="">
                        <input style="" type="text" class="form-control search"
                            placeholder="Search a keyword to search news" name="q">
                        <button
                            style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                            class="btn input-group-text search" type="submit">Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--shop area start -->
<div class="shop_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="detail-sidebar-artikel">
                    <h3 style="color: #114777"><b> News </b></h3>
                    <hr>

                    <div class="container">
                        <div class="row">
                            @forelse ($news as $row)
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">

                                    <div class="row pb-4 pr-4">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 py-0 px-0">
                                            <div class="zoom-effect">
                                                    <div style="
                                                        height: 200px;
                                                        width: 200px;
                                                        background-color: #e8e8e4;
                                                        justify-content: center;
                                                        display:table-cell;
                                                        vertical-align:middle;
                                                        text-align:center;
                                                        border-radius: 10px;
                                                        ">
                                                        <img src="{{ asset('uploads/News/' . $row->gambar) }}"
                                                            style="border-radius:7px; object-fit: cover;">
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-sm-6 col-lg-6 pl-lg-4 pl-sm-0">
                                            <div class="card-body-right">
                                                <div class="row">
                                                    <a href="{{ route('detail-artikel', $row->judul_seo) }}"
                                                        style="font-size:16pt; text-align:left" class=""
                                                        class="third-child"
                                                        style="color:#fff;"><b>{{ $row->judul }}</b>
                                                    </a>
                                                </div>
                                                <div class="row">
                                                    <p style="font-size:12pt; color: rgba(51, 51, 51, 0.541)">
                                                        <b><?php echo date('d M Y', strtotime($row->tanggal)); ?>
                                                            {{-- ,{{ $row->jam }} (UTC+7) --}}
                                                        </b>
                                                    </p>
                                                </div>
                                                <div class="row">
                                                    <p style="font-size:10pt; color: rgba(0, 0, 0, 0.541)">
                                                        {{ mb_strimwidth(strip_tags($row->isi_artikel), 0, 97, '...') }}
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @empty
                                <p>There is no news today</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--pagination start-->
    <div class="pagination justify-content-center mt-3">
        {{ $news->links('vendor.pagination.bootstrap-4') }}
        {{ $news->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
    </div>
    <!--pagination end-->
</div>
<!--shop area end-->

<!-- Plugins JS -->
<script src="{{ asset('front/assets/js/plugins.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
@include('frontend.layouts.footer')
<script type="text/javascript">
</script>
