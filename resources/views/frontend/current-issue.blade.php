@include('frontend.layouts.header')

<?php
$loc = app()->getLocale();
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
                $message = 'Perusahaan Anda Harus di Verifikasi oleh Admin Terlebih Dahulu.';
            } else {
                $message = 'Your Company Have to be Verified by Admin first.';
            }
        }
    } else {
        $for = 'importir';
        if ($loc == 'ch') {
            $message = '您无权下载';
        } elseif ($loc == 'in') {
            $message = 'Anda Tidak Memiliki Akses untuk Mengunduh.';
        } else {
            $message = 'You do not Have Access to Download.';
        }
    }
} else {
    $for = 'non user';
    if ($loc == 'ch') {
        $message = '请先登录';
    } elseif ($loc == 'in') {
        $message = 'Silahkan Login Terlebih Dahulu.';
    } else {
        $message = 'Please Login to Continue.';
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
        height: 34px !important;
    }

    #table-curris-front_filter {
        display: none;
    }

    .table-responsive .row {
        display: block !important;
    }

    #table-curris-front_wrapper {
        width: 100% !important;
    }

    .table thead th {
        font-size: 0.75rem;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        letter-spacing: 1px;
        text-transform: uppercase;
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

</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                    <ul>
                        <li><a href="{{ url('/') }}">@lang("frontend.proddetail.home")</a></li>
                        <li><label style="color: #999;">@lang("frontend.currentissue.currentissue")</label></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="input-group search-event" style="margin-top: 7px">
                    <div class="input-group-prepend">
                        <select id="search" name="search" class="sel-event">
                            <option value="1">Name</option>
                            <option value="2">Country</option>
                        </select>
                    </div>
                    <select class="form-control select2 search" name="country" id="search_country"
                        style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;">
                        <option value=""></option>
                    </select>
                    <input type="text" id="search_name" name="nama" class="form-control search" onkeyup="checkname()"
                        placeholder="Search" autocomplete="off" value="" style="height:40px;">
                    {{-- <a href="{{ url('/front_end/curris') }}"  class="btn btn-sm btn-default" style=" border-top: 2px solid #1a70bb; border-right: 2px solid #1a70bb;border-bottom: 2px solid #1a70bb;border-left: 2px solid #1a70bb;" title="Reset All Filter"><span class="fa fa-close"></span></a> --}}
                    <button type="button" id="buttonsearch"
                        style="display:none; border-top: 2px solid #1a70bb; border-right: 2px solid #1a70bb;border-bottom: 2px solid #1a70bb;border-left: 2px solid #1a70bb;"
                        class="btn btn-sm btn-default" onclick="checksearch()" title="Reset All Filter"><span
                            class="fa fa-close"></span></button>

                    <div class="input-group-prepend">
                        <button type="button" class="input-group-text submit" onclick="searching()"
                            style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                            title="Search">&nbsp;Search&nbsp;</button>
                    </div>
                </div>
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
                    <h2><b>@lang("frontend.currentissue.currentissue")</b></h2>
                </span>
            </div>
            <div class="col-md-6 col-lg-6" align="right"><br>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><br>
                <div class="table-responsive">
                    <table id="table-curris-front" class="table table-hover table-striped" data-plugin="dataTable"
                        width="100%" style="table-layout: fixed;">
                        <thead class="text-white" style="background-color: #6B7BD6;">
                            <tr>
                                <th>@lang("frontend.currentissue.no")</th>
                                <th>@lang("frontend.currentissue.title")</th>
                                <th>@lang("frontend.currentissue.country")</th>
                                <th>@lang("frontend.currentissue.publishdate")</th>
                                <th>@lang("frontend.currentissue.action")</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
@include('frontend.layouts.footer')
<script type="text/javascript">
    var login = "{{ $for }}";

    function seedetail(id) {
        // if(login == 'eksportir'){
        window.location.href = "{{ url('/front_end/curris/detail') }}/" + id;
        // }else{
        //   alert("{{ $message }}");
        //   window.location.href = "{{ url('/login') }}";

        // }
    }

    function __download(id, e, obj) {
        e.preventDefault();

        if (login == 'admin') {
            window.open(obj.href, '_blank');
        } else if (login == 'eksportir') {
            $.ajax({
                url: "{{ route('research-corner.download') }}",
                type: 'get',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        window.open(obj.href, '_blank');
                    }
                }
            });
        } else {
            alert("{{ $message }}");
            if (login == 'non user') {
                window.location.href = "{{ url('/login') }}";
                // window.location.href = "{{ url('/login') }}";
            }
        }

    }
</script>

<script>
    $(document).ready(function() {
        var tabel = $('#table-curris-front').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('/front_end/curris/getData/') }}",
                data: function(d) {
                    d._token = '{{ csrf_token() }}';
                },
            },
            responsive: true,
            autoWidth: false,
            scrollX: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title_en',
                    name: 'title_en',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'country',
                    name: 'country',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                width: 50,
                targets: 0
            }, {
                width: 650,
                targets: 1
            }, {
                width: 150,
                targets: 2
            }, {
                width: 150,
                targets: 3
            }, {
                width: 50,
                targets: -1
            }],
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            fixedColumns: true,
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });

        $('#search_country').select2({
            allowClear: true,
            placeholder: 'Search Country',
            ajax: {
                url: "{{ route('countryci.getcountry') }}",
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
        $('#search_country').hide();
        $('#search_name').show();
        $('#search_country').next('.select2-container').hide();

    });


    function searching() {
        var yangdiselect = $('#search').val();
        var nama = $('#search_name').val();
        var country = $('#search_country').val();
        $('#table-curris-front').DataTable().destroy();
        console.log(nama);
        console.log(country);
        var table = $('#table-curris-front').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('/front_end/curris/getData/') }}",
                data: function(d) {
                    d.searchnya = yangdiselect;
                    d.searchcountry = country;
                    d.searchnama = nama;
                    d._token = '{{ csrf_token() }}';
                },
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title_en',
                    name: 'title_en',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'country',
                    name: 'country',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [{
                width: 50,
                targets: 0
            }, {
                width: 650,
                targets: 1
            }, {
                width: 50,
                targets: -1
            }],
            fixedColumns: true,
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
    }

    function checksearch() {
        if ($('#search').val() == 1) {
            $('#search_name').val('');
            $('#buttonsearch').css({
                "display": "none"
            });
        } else {
            $('#search_country').empty();
            $('#buttonsearch').css({
                "display": "none"
            });
        }
    }

    function checkname() {
        if ($('#search_name').val() == '') {
            $('#buttonsearch').css({
                "display": "none"
            });
        } else {
            $('#buttonsearch').css({
                "display": "block"
            });
        }

    }

    $("#search_country").change(function() {
        if ($(this).val() == "")
            $('#buttonsearch').css({
                "display": "none"
            });
        else
            $('#buttonsearch').css({
                "display": "block"
            });
    })

    $('#search').on('change', function() {
        var pilihan = this.value;
        if (pilihan == 1) {
            $('#search_country').hide();
            $('#search_name').show();
            $('#search_country').empty();
            $('#search_country').next('.select2-container').hide();
        } else if (pilihan == 2) {
            $('#search_country').show();
            $('#search_name').hide();
            $('#search_name').val('');


            $('#search_country').next('.select2-container').show();
        }
    });
</script>
