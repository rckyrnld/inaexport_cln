<style>
    .list-group-item {
        background-color: #e9e9ff;
        border: none;
    }

    .eksporter-product {
        padding: 5% 1% 5% 1%;
    }

    .eksporter-product .list-group-item {
        background-color: white;
    }

    .a-eksporter {
        text-decoration: none;
        color: black;
        height: auto;
    }

    @media only screen and (max-width: 767px) {
        .a-eksporter {
            height: auto;
        }
    }

    .a-eksporter:hover {
        text-decoration: none;
    }

    .eksporter_img {
        width: 50%;
    }

    .name-eksporter {
        font-size: 13px;
    }

    .single_product {
        padding: 10px 8px 18px 18px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin: 1px;
    }

    .btneksportir:hover {
        text-decoration: none;
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }


    .eksporter-product .list-group a:hover {
        background-color: #e9e9ff;
    }

    .caption-btn {
        float: right;
        margin-right: 0px;
    }

    table,
    th,
    tr,
    td {
        text-align: left !important;
    }

    .cardreport:hover {
        text-decoration: none;
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

    .cardreport button.active {
        color: white;
    }

</style>

@extends('header2')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Supplier Report (Total Data: {{ number_format($copesan) }})</h3>
                </div>

                <div class="card-body">
                    <div class="row mb-2 ml-4 mt-2">
                        <div class="col-lg-12">
                            @php
                                $cari_kategori = request()->get('cari_kategori');
                            @endphp
                            <form class="mb-0" method="post" action="{{ url('annual_sales/cetak') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="kat" value="{{ $kategori }}">
                                <input type="hidden" name="cari_company" value="{{ $q }}">
                                <button type="submit" class="btn btn-success"
                                    style="color: white; margin-top:-20px; margin-left:-10px"><i
                                        class="fa fa-download"></i>&nbsp;
                                    Export Excel
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-8">
                            <form class="form-horizontal" enctype="multipart/form-data" method="GET"
                                action="{{ url('/') }}/eksportir/admin">
                                <div class="row">
                                    <div class="ml-3 mt-2">
                                        <select onchange="this.form.submit()" class="form-control" id="cari_kategori"
                                            name="cari_kategori" placeholder="Choose Product Categories"
                                            style="width:100% !important;">
                                            <option value="">-- Choose Product Categories --</option>
                                            @foreach ($categoryutama as $cu)
                                                {
                                                <option value="{{ $cu->id }}"
                                                    @if (isset($kategori)) @if ($kategori == $cu->id)
                                            selected @endif
                                                    @endif>
                                                    {{ $cu->nama_kategori_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="q_hidden" value="{{ $q }}">
                            </form>
                        </div>
                        <div class="col-12 col-sm-4 text-right">
                            <form action="{{ url('/') }}/eksportir/admin/dinas_search" method="POST" role="search">
                                {{ csrf_field() }}
                                <div class="input-group pr-4">
                                    <input style="border-top-left-radius: 15px; border-bottom-left-radius:15px;" type="text"
                                        class="form-control" name="q" placeholder="Search Company..." autocomplete="off"
                                        value="{{ $q }}">
                                    <div class="input-group-append">
                                        <button
                                            style="font-weight:bold; background-color: #ffe300; color: #1d7bff; border-top-right-radius: 15px; border-bottom-right-radius:15px; margin-right:-20px"
                                            type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                            Search
                                        </button>
                                    </div>
                                    <input type="hidden" name="idKategori" value="{{ $kategori }}">
                                    <input type="hidden" name="idProvinsi" value="{{ $provinsi }}">
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="card-body">
                    <div class="col-md-4" style="float: right; margin-top:-20px">

                    </div>
                </div> --}}




                    <!--exporter report start -->
                    <div class="row shop_wrapper">
                        @foreach ($pesan as $eks)
                            <div class="col-lg-4 col-md-6 col-12 pb-4">
                                <div class="single_product mt-3 cardreport"
                                    style="padding-bottom: 0px; margin-bottom: 10px;">
                                    <div class="product_content grid_content h-100 d-flex flex-column table-responsive"
                                        style="margin-top: 0px;">
                                        <div
                                            style="height: 50px; margin-top:20px; margin-left:15px; margin-right:15px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
                                            <center>
                                                <b>{{ $eks->company }},{{ $eks->nmbadanusaha }}</b>
                                            </center>
                                        </div>
                                        {{-- <div class="eksporter-product" style="overflow-y: auto;"> --}}
                                        <div class="list-group m-3" style="font-size: 12.5px;">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td style="vertical-align:top;overflow:hidden; white-space:nowrap;">
                                                            Alamat</td>
                                                        <td style="vertical-align:top; width: 15px;">:</td>
                                                        <td style="vertical-align:top">
                                                            @if ($eks->addres != null)
                                                                {{ $eks->addres }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="vertical-align:top;overflow:hidden; white-space:nowrap;">
                                                            E-mail</td>
                                                        <td style="vertical-align:top; width: 15px;">:</td>
                                                        <td style="vertical-align:top">
                                                            @if ($eks->email != null)
                                                                {{ $eks->email }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="vertical-align:top;overflow:hidden; white-space:nowrap;">
                                                            PIC</td>
                                                        <td style="vertical-align:top; width: 15px;">:</td>
                                                        <td style="vertical-align:top">
                                                            <?php
                                                            $namapicnya = '';
                                                            $no = 0;
                                                            $datapic = DB::table('itdp_contact_eks')
                                                                ->where('id_itdp_profil_eks', $eks->id)
                                                                ->get();
                                                            if (count($datapic) > 0) {
                                                                foreach ($datapic as $namapic) {
                                                                    if ($no == 0) {
                                                                        $namapicnya .= $namapic->name;
                                                                    }
                                                                    // else {
                                                                    //     $namapicnya .= ', ' . $namapic->name;
                                                                    // }
                                                                    $no++;
                                                                }
                                                            }
                                                            ?>
                                                            @if ($namapicnya != null)
                                                                {{ $namapicnya }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="vertical-align:top;overflow:hidden; white-space:nowrap;">
                                                            Telephone</td>
                                                        <td style="vertical-align:top; width: 15px;">:</td>
                                                        <td style="vertical-align:top">
                                                            <?php
                                                            $telppicnya = '';
                                                            $no2 = 0;
                                                            
                                                            $datapic2 = DB::table('itdp_contact_eks')
                                                                ->where('id_itdp_profil_eks', $eks->id)
                                                                ->get();
                                                            if (count($datapic2) > 0) {
                                                                foreach ($datapic2 as $telppic) {
                                                                    if ($no2 == 0) {
                                                                        $telppicnya .= $telppic->phone;
                                                                    }
                                                                    // else {
                                                                    //     $telppicnya .= ', ' . $telppic->phone;
                                                                    // }
                                                                    $no2++;
                                                                }
                                                            }
                                                            ?>
                                                            @if ($telppicnya != null)
                                                                {{ $telppicnya }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="vertical-align:top;overflow:hidden; white-space:nowrap;">
                                                            Verify Date</td>
                                                        <td style="vertical-align:top; width: 15px;">:</td>
                                                        <td style="vertical-align:top">
                                                            @if (empty($eks->verified_at) || $eks->verified_at == null)
                                                                -
                                                            @else
                                                                {{ date('d F Y', strtotime($eks->verified_at)) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="width: 110px;vertical-align:top;;overflow:hidden; white-space:nowrap;">
                                                            Kategori Produk</td>
                                                        <td style="vertical-align:top; width: 15px;">:</td>
                                                        <td style="vertical-align:top">
                                                            <?php
                                                            $catnya = [];
                                                            $categoryutama = DB::table('csc_product')
                                                                ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product')
                                                                ->select('csc_product.id', 'csc_product.level_1', 'csc_product.level_2', 'csc_product.nama_kategori_en', 'csc_product.nama_kategori_in', 'csc_product.nama_kategori_chn', 'csc_product.created_at', 'csc_product.updated_at', 'csc_product.type', 'csc_product.logo')
                                                                ->groupby('csc_product.id', 'csc_product.level_1', 'csc_product.level_2', 'csc_product.nama_kategori_en', 'csc_product.nama_kategori_in', 'csc_product.nama_kategori_chn', 'csc_product.created_at', 'csc_product.updated_at', 'csc_product.type', 'csc_product.logo')
                                                            
                                                                ->where('id_itdp_profil_eks', $eks->id)
                                                                ->where('csc_product_single.status', 2)
                                                                ->orderBy('nama_kategori_en', 'ASC')
                                                                ->get();
                                                            
                                                            if (count($categoryutama) > 0) {
                                                                foreach ($categoryutama as $cat) {
                                                                    $catnya[] = $cat->nama_kategori_en;
                                                                }
                                                            }
                                                            ?>
                                                            @if (count($catnya) > 0)
                                                                {{ implode(', ', $catnya) }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        {{-- </div> --}}

                                        <div class="eksporter-detail mt-auto"
                                            style="border-top: 1px solid #DDEFFD; padding: 2%;">
                                            <center>
                                                {{-- <a
                                            href="{{url('front_end/list_perusahaan/view/' . $param = $eks->id_user . '-' . getCompanyName($eks->id_user))}}"
                                            class="btn btneksportir cardreport" target="_blank" style="border-radius: 15px; background-color: #ffe300; color:#1d7bff; font-size : 14px; font-weight : bold;
                                                    width : 150 px;">View Profile</a>
                                        </a> --}}

                                                <a href="{{ url('front_end/list_perusahaan/view/' . ($param = $eks->id_user . '-' . getCompanyName($eks->id_user) . '-' . $kategori)) }}"
                                                    class="btn cardreport" style="border-radius: 10px; background-color: #ffe300; color:#1d7bff; font-size : 13px; font-weight : bold;
                                                                                    width : 80 px;">Detail</a>
                                                </a>

                                                <a target="_blank"
                                                    href="{{ url('/front_end/listeksportir/cetakpdfnew/' . $eks->id) }}"
                                                    class="btn btn-success">
                                                    <i class="fa fa-download"></i>
                                                </a>

                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--exporter report end -->
                </div>
                <div class="pagination justify-content-center">
                    {{ $pesan->links('vendor.pagination.bootstrap-4') }}
                    {{ $pesan->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
                </div>
                {{-- @if ($copesan > 12)
            <div class="pagination justify-content-center">
                {{ $pesan->links('vendor.pagination.bootstrap-4') }}
                {{ $pesan->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
            </div>
            @endif --}}

            </div>
        </div>
    </div>
    </div>
    {{-- <div class="table-responsive pt-4 pl-0 pr-0">
    <table id="tableeksportir" class="table align-items-center table-flush" data-plugin="dataTable">
        <thead class="thead-light">
            <tr role="row">
                <th>No</th>
                <th>
                    <center>Company</center>
                </th>
                <th>
                    <center>Address</center>
                </th>
                <th>
                    <center>Province</center>
                </th>
                <th>
                    <center>Email</center>
                </th>
                <th>
                    <center>PIC Name</center>
                </th>
                <th>
                    <center>PIC Telephone</center>
                </th>
                <th>
                    <center>Verify Date</center>
                </th>

                <th>
                    <center>Action</center>
                </th>
            </tr>
        </thead>
        <tbody>

        </tbody>

    </table>
</div>
</div>
</div>
</div>
</div>
</div> --}}
    <script type="text/javascript">
        // $(function () {
        //     $('#tableeksportir').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('datatables.reporteksportir') }}",
        //         columns: [
        //             {data: 'DT_RowIndex', name: 'DT_RowIndex',width: '10%',orderable: false, searchable: false},
        //             {data: 'company', name: 'itdp_profil_eks.company',width: '10%',orderable: true, searchable: true},
        //             {data: 'addres', name: 'itdp_profil_eks.addres',width: '10%',orderable: true, searchable: true},
        //             {data: 'province', name: 'mst_province.province_en',width: '10%',orderable: true, searchable: true},
        //             {data: 'email', name: 'itdp_company_users.email',width: '10%',orderable: true, searchable: true},
        //             {data: 'pic_name', name: 'pic_name',width: '10%',orderable: false, searchable: false},
        //             {data: 'pic_telp', name: 'pic_telp',width: '10%',orderable: false, searchable: false},
        //             {data: 'verify_date', name: 'itdp_company_users.verified_at',width: '10%',orderable: true, searchable: true},  
        //             {
        //                 data: 'action', name: 'action', orderable: false, searchable: false
        //             }
        //         ],
        //         "language": {
        //                 "paginate": {
        //                     "previous": "<i class='fa fa-angle-left'/></>",
        //                     "next": "<i class='fa fa-angle-right'/></>"
        //                 }
        //             }

        //     });
        // });
    </script>

    @include('footer')
@endsection
