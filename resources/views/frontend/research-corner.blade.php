@include('frontend.layouts.header')

<?php
if (!empty($bahasa)) {
    $loc = $bahasa;
} else {
    $loc = app()->getLocale();
}
if (Auth::user()) {
    $for = 'admin';
    $message = '';
} elseif (Auth::guard('eksmp')->user()) {
    if (Auth::guard('eksmp')->user()->id_role == 2) {
        if (Auth::guard('eksmp')->user()->status == 1) {
            $for = 'eksportir';
            $message = '';
        } else {
            $for = 'notverified';
            if ($loc == 'ch') {
                $message = '您的公司必须先由管理员验证';
            } elseif ($loc == 'in') {
                $message = 'Perusahaan Anda harus diverifikasi oleh Admin terlebih dahulu.';
            } else {
                $message = 'Your company have to be verified by Admin first.';
            }
        }
    } else {
        $for = 'importir';
        if ($loc == 'ch') {
            $message = '您无权下载';
        } elseif ($loc == 'in') {
            $message = 'Anda tidak memiliki akses untuk mengunduh.';
        } else {
            $message = 'You do not have access to download market information.';
        }
    }
} else {
    $for = 'non user';
    if ($loc == 'ch') {
        $message = '请先登录';
    } elseif ($loc == 'in') {
        $message = 'Silahkan login terlebih dahulu untuk mengunduh market information.';
    } else {
        $message = 'Please Login to to download market information.';
    }
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
        font-family: 'Arial' !important;
    }

    .kontennya:hover {
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }


    .search {
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
        height: 40px;
    }

    .search-event {
        width: 100%;
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

    /* .select2-selection__clear {
        position: absolute !important;
        right: 23px !important;
        top: 5px;
    } */
</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12">
                <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                    <ul>
                        <li><a href="{{ url('/') }}">@lang("frontend.proddetail.home")</a></li>
                        <li>Market Information</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <form class="form-horizontal" enctype="multipart/form-data" method="GET"
                    action="{{ url('/front_end/research-corner') }}">
                    {{ csrf_field() }}
                    <div class="input-group flex-nowrap" style="margin-top: 7px">
                        <div class="input-group search-event">
                            <div class="input-group-prepend">
                                <select id="search" name="search" class="sel-event">
                                    <option value="1" @if ($searchEvent==1) selected @endif>Product</option>
                                    <option value="2" @if ($searchEvent==2) selected @endif>Country</option>
                                </select>
                            </div>
                            <select class="form-control select2 search" name="country" id="search_country"
                                style="height:45px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb; border-radius: 0px !important;">
                                <option value=""></option>
                            </select>
                            <!-- <select class="form-control select2 search " name="nama" id="search_name" style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;" >
                                  <option value=""></option>
                              </select> -->
                            <input type="text" id="search_name" name="nama" class="form-control search"
                                placeholder="Search" autocomplete="off" @if ($searchEvent==1) value="{{ $param }}"
                                @endif>
                            <!--                             
                              <select class="form-control select2 search " name="product" id="search_product" style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;" >
                                  <option value=""></option>
                              </select> -->
                            @if (isset($param))
                            @if ($param != null)
                            <a href="{{ url('/front_end/research-corner') }}" class="btn btn-sm btn-default"
                                style=" border-top: 2px solid #1a70bb; border-right: 2px solid #1a70bb;border-bottom: 2px solid #1a70bb;border-left: 2px solid #1a70bb;"
                                title="Reset All Filter"><span class="fa fa-close"></span></a>
                            @endif
                            @endif
                            <!-- </div> -->
                            <div class="input-group-prepend">
                                {{-- <button type="submit" class="input-group-text submit"
                                    style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; background-color: #1a70bb; border-color: transparent; color: white;"
                                    title="Search">&nbsp;<i class="fa fa-search"></i>&nbsp;</button> --}}
                                <button type="submit" class="input-group-text submit"
                                    style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                                    title="Search">&nbsp;Search&nbsp;</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<div class="shop_area shop_reverse" style="background-color: white; padding-bottom: 3%;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <span style="color: #114777; text-align: left;">
                    <h3><b>Market Information</b></h3>
                </span>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-12">
                <!--sidebar widget start-->
                <aside class="sidebar_widget" style="border-radius: 20px;">
                    <div class="widget_inner" style="background : #e9e9ff !important">
                        <div class="widget_list widget_categories" style="background : #e9e9ff; !important">
                            <form class="form-horizontal" enctype="multipart/form-data" method="GET"
                                action="{{ url('/front_end/research-corner') }}">
                                <?php
                                if ($loc == 'ch') {
                                    $srchcatlang = '搜索类别';
                                    $judul = '類別';
                                } elseif ($loc == 'in') {
                                    $srchcatlang = 'Pilih Kategori';
                                    $judul = 'Kategori';
                                } else {
                                    $srchcatlang = 'Select a Category';
                                    $judul = 'Category';
                                }
                                ?>
                                <h2>{{ $judul }}</h2>
                                <select onchange="this.form.submit()" class="form-control form-control-sm filterSide"
                                    id="cari_kategori" name="cari_kategori" placeholder="{{ $srchcatlang }}')"
                                    style="border:1px solid rgb(170, 170, 170); font-size: 12px;margin-bottom: 20px; border-radius:10px; background: #d1d1e5; color:#000;">
                                    <option value="">-- {{ $srchcatlang }} --</option>
                                    @foreach ($type as $tp)
                                    <option value="{{ $tp->id }}" @if (isset($kategori)) @if ($kategori==$tp->id)
                                        selected @endif
                                        @endif>
                                        {{ $tp->nama_en }}</option>
                                    @endforeach
                                </select>
                                <?php
                                if ($loc == 'ch') {
                                    $srchcatlang = '搜索类别';
                                    $judul = '語';
                                } elseif ($loc == 'in') {
                                    $srchcatlang = 'Pilih Bahasa';
                                    $judul = 'Bahasa';
                                } else {
                                    $srchcatlang = 'Select a language';
                                    $judul = 'Language';
                                }
                                ?>
                                <h2>{{ $judul }}</h2>
                                <select onchange="this.form.submit()" class="form-control form-control-sm filterSide"
                                    id="cari_bahasa" name="cari_bahasa" placeholder="{{ $srchcatlang }}"
                                    style="border:1px solid rgb(170, 170, 170); font-size: 12px;margin-bottom: 20px; border-radius:10px; background: #d1d1e5; color:#000;">
                                    <option value="">-- {{ $srchcatlang }} --</option>
                                    <option value="in" @if (isset($bahasa)) @if ($loc=='in' ) selected @endif @endif>
                                        INDONESIA</option>
                                    <option value="en" @if (isset($bahasa)) @if ($loc=='en' ) selected @endif @endif>
                                        ENGLISH</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </aside>
                <!--sidebar widget end-->
            </div>
            <div class="col-lg-9 col-md-9 col-9">
                <div class="row shop_wrapper">
                    @foreach ($research as $key => $data)
                    <div class="col-lg-4 col-md-4 col-12 a-modif small" style="height: 100%;padding-bottom: 18px;">
                        <?php $size = 162;
                            $num_char = 20; ?>
                        <div class="kontennya"
                            style="width: 100%;padding: 16px; background-color: #f8f8f8; border-radius: 10px">
                            <?php
                                if ($loc == 'ch') {
                                    $title = $data->title_en;
                                    // $date = date('d M Y', strtotime($data->publish_date)).' ( '.date('H:i', strtotime($data->publish_date)).' )';
                                    $date = date('d M Y', strtotime($data->publish_date));
                                } elseif ($loc == 'in') {
                                    $title = $data->title_in;
                                    $date = getTanggalIndo(date('Y-m-d', strtotime($data->publish_date)));
                                } else {
                                    $title = $data->title_en;
                                    $date = date('d M Y', strtotime($data->publish_date));
                                }
                                
                                if ($for == 'admin' || $for == 'eksportir') {
                                    $url = url('/') . '/uploads/Market Research/File/' . $data->exum;
                                } else {
                                    $url = '#';
                                }
                                
                                $image = 'uploads/Market Research/Cover/' . $data->cover;
                                if ($data->cover != null || $data->cover != '') {
                                    if (file_exists($image)) {
                                        $image = 'uploads/Market Research/Cover/' . $data->cover;
                                    } else {
                                        $image = '/image/nia.png';
                                    }
                                } else {
                                    $image = '/image/cover_rc.png';
                                }
                                
                                if (strlen($title) > $num_char) {
                                    $cut_text = substr($title, 0, $num_char);
                                    if ($title[$num_char - 1] != ' ') {
                                        // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                        $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                        $cut_text = substr($title, 0, $new_pos);
                                    }
                                    $titleName = $cut_text . '...';
                                } else {
                                    $titleName = $title;
                                }
                                ?>
                            <div style="width: 100%; height: 75%; margin: auto; text-align: center;">
                                <img class="rc" src="{{ url('/') }}/{{ $image }}" style="height: {{ $size }}px;">
                            </div>
                            <div style="height: 25%; padding-top: 5px;">
                                <span style="font-family: arial; font-weight: 500; font-size: 18px;"
                                    title="{{ $title }}">
                                    <strong style="padding-right: 10px;">{{ $titleName }}</strong>
                                    {{-- <span class="badge badge-primary"
                                        style="font-size: 11px !important; vertical-align: middle; background-color: #387bbf;">{{getDataDownload($data->id)}}&nbsp;&nbsp;<i
                                            class="fa fa-download"></i></span> --}}
                                </span>
                                <br>
                                <span class="detail_rc" style="font-size: 14px;">
                                    <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{ $date }}
                                    <br>
                                    <a href="" class="detail_rc" onclick="__download('{{ $data->id }}', event)"
                                        style="text-decoration: none;"><i
                                            class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;@lang("button-name.donlod")</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <br><br>
                <div class="row">
                    <div class="container">
                        <div class="row justify-content-center" align="center">
                            {{ $research->render('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="redirect" id="redirect" value="market_information">
<?php
if ($loc == 'ch') {
    $alert1 = '您在此类别中没有任何产品';
    $alert2 = '您无权下载。';
} elseif ($loc == 'in') {
    $alert1 = 'Anda tidak memiliki produk dengan kategori ini.';
    $alert2 = 'Anda tidak memiliki akses untuk mengunduh.';
} else {
    $alert1 = 'You do not have any products in this category.';
    $alert2 = 'You do not have access to download.';
}
?>
@include('frontend.layouts.footer')
<script type="text/javascript">
    var login = "{{ $for }}";

    function __download(id, e) {
        e.preventDefault();
        if ("{{ $for }}" == "non user") {
            alert("{{ $message }}");
            if (window.confirm('Are you want go to login page?')) {
                let url = "{{ url('/login?redirect='.encrypt('market_information')) }}"
                window.location = url;
            }
        } else if ("{{ $for }}" == "admin" || "{{ $for }}" == "eksportir") {
            $.ajax({
                url: "{{ route('research-corner.download') }}",
                type: 'get',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if(response == 'nope'){
                        alert("{{ $alert1 }}")
                    } else if(response == 'prohibited') {
                        alert("{{ $alert2 }}")
                    } else if (response != 'nope' || response != 'prohibited') {
                        // console.log(decodeURIComponent(response));
                        window.open(response, '_blank');
                    }
                }
            });
        } else {
            // jika login sebagai buyer atau supplier yang belum terverifikasi
            alert("{{ $message }}");
        }
    }
</script>
<script>
    $(document).ready(function() {

        $('#search_country').select2({
            // allowClear: true,
            placeholder: 'Search Country',
            ajax: {
                url: "{{ route('countryrc.getcountry') }}",
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

        // $('#search_product').select2({
        //     allowClear: true,
        //     placeholder: 'Search Category Product',
        //     ajax: {
        //         url: "{{ route('categoryrc.getcategory') }}",
        //         dataType: 'json',
        //         delay: 250,
        //         processResults: function(data) {
        //             return {
        //                 results: $.map(data, function(item) {
        //                     console.log(item.id);
        //                     return {
        //                         text: item.nama_kategori_en,
        //                         id: item.id
        //                     }
        //                 })
        //             };
        //         },
        //         cache: true
        //     }
        // });


        var search = "{{ $searchEvent }}";
        if (search == 2) {
            $('#search_country').next('.select2-container').show();
            $('#search_name').hide();
            // $('#search_name').next('.select2-container').hide();
            // $('#search_product').next('.select2-container').show();
        } else {

            $('#search_country').next('.select2-container').hide();
            $('#search_name').show();
            // $('#search_name').next('.select2-container').show();
            // $('#search_product').next('.select2-container').hide();
        }
    });


    var searchEvent = "{{ isset($searchEvent) ? $searchEvent : '' }}";
    // if(searchEvent == 1){
    // console.log(searchEvent);
    // var param = "{{ isset($param) ? $param : '' }}";
    // if (param != "") {
    //     $.ajax({
    //         type: 'GET',
    //         url: "{{ route('productrc.getproductrc') }}",
    //         data: { code: param }
    //     }).then(function (data) {
    //     var option = new Option(data[0].title, data[0].id, true, true);

    //     $('#search_name').append(option).trigger('change');
    //     });
    // }
    // }else
    if (searchEvent == 2) {
        console.log(searchEvent);
        var param = "{{ isset($param) ? $param : '' }}";
        if (param != "") {
            $.ajax({
                type: 'GET',
                url: "{{ route('countryrc.getcountry') }}",
                data: {
                    code: param
                }
            }).then(function(data) {
                var option = new Option(data[0].country, data[0].id, true, true);

                $('#search_country').append(option).trigger('change');
            });
        }

    }
    // else if(searchEvent == 2){
    //     console.log(searchEvent);
    //     var param = "{{ isset($param) ? $param : '' }}";
    //     if (param != "") {
    //         $.ajax({
    //             type: 'GET',
    //             url: "{{ route('categoryrc.getcategory') }}",
    //             data: { code: param }
    //         }).then(function (data) {
    //             var option = new Option(data[0].nama_kategori_en, data[0].id, true, true);

    //             $('#search_product').append(option).trigger('change');
    //         });
    //     }
    // }



    $('#search').on('change', function() {
        var pilihan = this.value;
        if (pilihan == 1) {
            $('#search_country').hide();
            $('#search_name').show();
            // $('#search_product').hide();

            $('#search_country').next('.select2-container').hide();
            // $('#search_name').next('.select2-container').show();
            // $('#search_product').next('.select2-container').hide();
        } else if (pilihan == 2) {
            $('#search_country').show();
            $('#search_name').hide();

            // $('#search_product').show();

            $('#search_country').next('.select2-container').show();
            // $('#search_name').next('.select2-container').hide();
            // $('#search_product').next('.select2-container').show();
        }
    });
</script>