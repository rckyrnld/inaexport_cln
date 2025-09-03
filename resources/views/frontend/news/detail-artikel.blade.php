@include('frontend.layouts.header')
<div style="background-image:url('./../assets/assets/versi 1/Asset 23 (1).png') !important">
    <div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                        <ul>
                            <li><a href="{{ url('/') }}">@lang('frontend.proddetail.home')</a></li>
                            <li>News</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="container" style="margin-top: -15px">
        <div class="row">
            <div class="col-lg-8 mb-4 p-4">
                <img src="{{ asset('uploads/News/gambar_header/' . $news->gambar_header) }}" class="img-fluid"
                    style="max-height: 390px;">
                <div class="detail-content mt-4">
                    <h3> {{ $news->judul }} </h3>
                    <p style="font-size:12px; color: rgb(163, 161, 161)"><?php echo date('d M Y', strtotime($news->tanggal)); ?>, {{ $news->jam }}
                        (UTC+7)
                    <br>
                    <span style="font-size:12px; color: rgb(163, 161, 161)">Read by : {{ number_format($readBy,0,",",".") }}</span> 
                    </p>
                    <br>
                    <div class="detail-body" style="margin-top: -40px">
                        <p>
                            {!! $news->isi_artikel !!}
                        </p>
                    </div>


                </div>
            </div>
            <div class="col-lg-4">
                <div class="detail-sidebar-artikel">
                    <h4 class="mt-4"> Artikel Lainnya </h4>
                    <hr>
                    <div class="media">
                        <div class="row">
                            @forelse ($artikel as $row)
                                <div class="col-12 mb-2">
                                    <div style="
                                        height: 160px;
                                        width: 160px;
                                        background-color: #e8e8e4;
                                        justify-content: center;
                                        display:table-cell;
                                        vertical-align:middle;
                                        text-align:center;
                                        border-radius: 10px;
                                        ">
                                        <img src="{{ asset('uploads/News/' . $row->gambar) }}" class="img-responsive"
                                            style="border-radius: 10px;">
                                    </div>
                                    <a href="{{ route('detail-artikel', $row->judul_seo) }}"
                                        style="margin-right:50%; font-size:13px; text-align:left; color: #001466"
                                        class="py-2" class="third-child"
                                        style="color:#fff;"><br><b>{{ $row->judul }}</b></a>
                                </div>
                            @empty
                                <p>Data masih kosong</p>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.layouts.footer')
