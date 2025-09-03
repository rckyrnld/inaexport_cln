@include('frontend.layouts.header')
<?php
$loc = app()->getLocale();
if ($loc == 'ch') {
    $lct = 'chn';
    $by = '通过';
    $order = '最小订购量 : ';
} elseif ($loc == 'in') {
    $lct = 'in';
    $by = 'Oleh';
    $order = 'Min Order : ';
} else {
    $lct = 'en';
    $by = 'By';
    $order = 'Min Order : ';
}
?>

<style>
    .tab {
        overflow: scroll;
        border: 1px solid #ccc;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: #5e72e4;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 8px 10px;
        transition: 0.3s;
        font-size: 17px;
    }

    .tab li:hover {
        background-color: #000;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #5e72e4 !important;
    }

    /* Create an active/current tablink class */
    .tab a.active {
        background-color: #5e72e4;
    }

    /* Style the tab content */
    .tabcontent {
        padding: 4px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .list-group-item {
        background-color: #e9e9ff;
        ;
        border: none;
    }

    .eksporter_img {
        border-radius: 50%;
        width: 200px;
        height: 200px;
        object-fit: scale-down;
    }

    .panel-srv {
        color: black;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
    }

    .href-name {
        color: black;
    }

    .href-name:hover {
        text-decoration: none;
    }

    .href-company {
        text-transform: capitalize;
        font-size: 11px;
        font-family: 'Open Sans', sans-serif;
        /*color: black;*/
    }

    .href-company:hover {
        text-decoration: none;
        color: black !important;
    }

    .href-category {
        text-transform: capitalize;
        font-size: 11px !important;
        font-family: 'Open Sans', sans-serif;
    }

    .href-category:hover {
        text-decoration: none;
    }

    .single_product:hover {
        box-shadow: 0 0 15px rgba(178, 221, 255, 1);
    }

    .table-light {
        background-color: #fff;
    }

    .table-active {
        background: radial-gradient(circle at top left, #F0FDFF 10%, #EDF7FF);
    }

    .headernya {
        border-top-left-radius: 25px !important;
        border-top-right-radius: 25px !important;
        border-bottom-left-radius: 25px !important;
        border-bottom-right-radius: 25px !important;
    }

    .tblnya {
        width: 910px;
    }

    .tblnyamodal {
        width: 760px;
    }

    .accordionnya {
        background: radial-gradient(circle at top left, #F0FDFF 10%, #EDF7FF);
        margin-bottom: 30px;
        border-radius: 30px;
    }

    .namecompany {
        /* text-shadow: 1px 1Px 20px #74A9B4; */
        color: #205871;
    }

    .tab-pane li a.active {
        text-shadow: 1px 1Px 20px #74A9B4;
    }

    .form-group {
        margin: 5px;
    }

    .buttonnya {
        font-size: 14px;
        background-size: 70px;
        background-color: #ffe300;
        border-radius: 20px;
        border-color: #e9fdeb;
        color: #1d7bff;
        width: 130px;
    }

    .tabmin a.active {
        background-color: #1a70bb !important;
        color: white !important;
        border-radius: 10px !important;
    }

    .tablinks.active {
        background-color: #1a70bb !important;
    }


    .tabmin a {
        width: 200px;
    }

    .tabmin a:hover {
        background-color: #1a70bb;
        color: white;
        border-radius: 10px;
    }

    .kotak img {
        width: 250px;
        height: 160px;
        border-radius: 5px;
    }

    .detail-certif p {
        margin: 2px;
    }

    .kontennya:hover {
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

    .bd-toc {
        position: relative;
        overflow: hidden;
    }

    .nav-wrapper {
        width: 100%;
        height: 50px;
        position: -webkit-sticky;
        position: sticky;
        top: 0;
    }

    .nav-link {
        transition: all 0.2s;
    }

    /* #myTopnav{
        position:fixed;
        width:20%;
        top:-100px;
    } */

    a.scroll.active {
        background-color: #1a70bb !important;
    }

    /* .card-body {
        margin-bottom : -1.5rem
    } */

    .cards {
        margin-bottom: -1.5rem
    }

    p {
        margin-bottom: -0.05rem;
    }

    hr {
        margin-bottom: -0.03rem;
        margin-top: -0.03rem;
    }

    .isi {
        padding-left: -0.5rem !important;
    }

    /* Mobile responsive company description*/
    @media only screen and (min-width: 500px) {
        .company-description {
            right: 0px;
        }
    }

    @media only screen and (min-width: 700px) {
        .company-description {
            right: 26px;
        }
    }


    @media only screen and (min-width: 900px) {
        .company-description {
            right: 51px;
        }
    }

    @media only screen and (min-width: 1000px) {
        .company-description {
            right: 55px;
        }
    }

    @media only screen and (min-width: 1200px) {
        .company-description {
            right: 68px;
        }
    }

    #tabs-icons-text-4,
    #tabs-icons-text-5,
    #tabs-icons-text-6,
    #tabs-icons-text-7,
    #tabs-icons-text-8,
    #tabs-icons-text-9,
    #tabs-icons-text-10 {
        margin-top: -100px;
        padding-top: 100px;
    }

    /* End of Mobile responsive company description*/
</style>

<!-- Select Category -->
<div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="catModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="catModalLabel">Click Here to Select Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-sm-4">
                        <div class="col-sm-12">
                            <label><b>@lang("login.forms.by3") (<font color="red">*</font>)</b></label>
                        </div>
                        <div class="form-group col-sm-12" style="font-size: 12px !important;">
                            <?php
                            // $ms1 = DB::select('select id,nama_kategori_en from csc_product where level_1 = 0 and level_2 = 0 order by nama_kategori_en asc');
                            $ms1 = DB::table('csc_product AS a')
                                ->join('csc_product_single AS b', 'b.id_csc_product', '=', 'a.id')
                                ->select('a.id', 'a.nama_kategori_en')
                                ->where('level_1', 0)
                                ->where('level_2', 0)
                                ->where('b.id_itdp_company_user', $id)
                                ->where('b.status', 2)
                                ->orderBy('nama_kategori_en', 'asc')
                                ->groupBy('a.id', 'a.nama_kategori_en')
                                ->get();
                            ?>
                            <select style="color:black;font-size: 12px !important; " size="13" class="column J-noselect"
                                name="category[]" id="category" onchange="t1()" {{-- required --}} form="form_br">
                                <option value="">@lang("login.forms.by11")</option>
                                <?php foreach($ms1 as $val1){ ?>
                                <option value="{{ $val1->id }}">{{ $val1->nama_kategori_en }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-sm-4">
                        <div id="t2">
                            <input type="hidden" name="t2s" id="t2s" value="0" form="form_br">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="t3">
                            <input type="hidden" name="t3s" id="t3s" value="0" form="form_br">
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary mr-auto rounded" data-dismiss="modal">Confirm</button>
            </div>
        </div>
    </div>
</div>
<!--Select Category End-->


<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-5">
                <div class="breadcrumb_content" style="padding-bottom: 0px;">
                    <ul>
                        <li><a href="{{ url('/') }}">@lang('frontend.proddetail.home')</a></li>
                        <li><a href="{{ url('/front_end/list_perusahaan') }}">@lang('frontend.home.eksporter')</a>
                        </li>
                        <li>@lang('frontend.liseksportir.detailtitle')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <?php
    //Image
    $img1 = $data->foto_profil;
    
    if ($img1 == null) {
        $isimg1 = '/front/assets/img/logo/logonew.png';
    } else {
        $image1 = 'uploads/Profile/Eksportir/' . $data->id_user . '/' . $img1;
        if (file_exists($image1)) {
            $isimg1 = '/uploads/Profile/Eksportir/' . $data->id_user . '/' . $img1;
        } else {
            $isimg1 = '/front/assets/img/logo/logonew.png';
        }
    }
    $param = $data->id_user . '-' . getCompanyName($data->id_user);
    $param2 = getExBadan($data->id_user);
    ?>

    <!--shop  area start-->
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!--sidebar widget start-->
                    <center>
                        <img src="{{ url('/') }}{{ $isimg1 }}" alt="" class="eksporter_img"
                            style="background-color:rgb(237 237 237 / 50%)">
                    </center>
                    <center>
                        <h3 class="" style="color: #205871; text-transform: uppercase;">
                            <b>{{ $data->company }}, {{ $data->nmbadanusaha }}</b>
                        </h3>
                    </center>
                    @php
                    $alamat = $data->addres . ', ' . $data->city;
                    @endphp

                    <center>
                        <h5 style="text-transform: Capitalize; line-height: 12pt">
                            @php
                            $new_alamat = '';
                            $b = '';
                            for ($a = 85; $a >= 0; $a--) {
                            $sub_alamat = substr($alamat, $a, 1);
                            if ($sub_alamat == ' ') {
                            $new_alamat = substr($alamat, 0, $a);
                            $b = $a;
                            break;
                            }
                            }
                            @endphp

                            {{ $new_alamat . '' . substr($alamat, $b) }}
                        </h5>
                    </center>
                    <center style="line-height: 12pt;">
                        <h5>
                            {{ getProvinceName($data->id_mst_province, $lct) }} - INDONESIA
                        </h5>
                    </center>

                    <br>
                    <div class="nav-wrappers" style="margin-top:-35px">
                        <ul class="nav nav-pills flex-column flex-md-row" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 {{ $tabName == 'about-us' ? 'active show' : '' }}"
                                    id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab"
                                    aria-controls="tabs-icons-text-1" aria-selected="true">ABOUT US</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 {{ $tabName == 'products' ? 'active show' : '' }}"
                                    id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab"
                                    aria-controls="tabs-icons-text-2" aria-selected="false">PRODUCTS</a>
                            </li>
                            @if (!empty(Auth::guard('eksmp')->user()))
                            @if (Auth::guard('eksmp')->user()->id_role != 2)
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 @if (isset($cat) && isset($send)) active @endif"
                                    id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab"
                                    aria-controls="tabs-icons-text-3" aria-selected="false">SEND
                                    INQUIRY</a>
                            </li>
                            @endif

                            @elseif(!empty(Auth::user()))
                            @if (Auth::user()->id_group != 5 && Auth::user()->id_group != 11)
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 @if (isset($cat) && isset($send)) active @endif"
                                    id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab"
                                    aria-controls="tabs-icons-text-3" aria-selected="false">SEND
                                    INQUIRY</a>
                            </li>
                            @endif
                            @endif


                        </ul>
                    </div>
                    <hr style="margin-top:0px">


                    <div class="tab-content">

                        <!--ABOUT US-->
                        <div class="tab-pane fade {{ $tabName == 'about-us' ? 'active show' : '' }}"
                            id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab"
                            style="overflow-x: auto;">
                            {{-- <div class="card-body text-lg-right text-right" style="margin-top:-12px"> --}}
                                
                                <a class="btn buttonnya text-center float-right" target="_blank" style="margin-top:10px; margin-bottom: 10px;"
                                    href="{{ url('/front_end/listeksportir/cetakpdfnew/' . $data->id) }}">
                                    <i class="fa fa-download"></i> Print PDF
                                </a>
                            {{-- </div> --}}
                            <div class="shop_area" style="margin-top: 40px;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-12 order-2" style="margin-top: -10px" id="main">
                                            <div class="tab-content" id="myTabContent">
                                                <!--Company Profile End-->
                                                <div class="tab-pane fade show active" id="tabs-icons-text-4"
                                                    aria-labelledby="tabs-icons-text-4">
                                                    <div class="card-body cards" style="text-align: justify;">
                                                        <h4 class="namecompany">COMPANY PROFILE</h4>
                                                        <a class="anchorjs-link" href="#overview"
                                                            aria-labelledby="overview"></a>
                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Description
                                                            </div>
                                                            <div class="col-sm-1">
                                                                :
                                                            </div>
                                                            <div class="col-sm-8 company-description">
                                                                @if ($data->description != null)
                                                                {{ $data->description }}
                                                                @else
                                                                -
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Business Type
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @if ($data->nmtype != null)
                                                                {{ $data->nmtype }}
                                                                @else
                                                                -
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Main Product
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @if ($data->main_product != null)
                                                                {{ $data->main_product }}
                                                                @else
                                                                -
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Year of Establishment
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @if ($data->year_establish != null)
                                                                {{ $data->year_establish }}
                                                                @else
                                                                -
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{-- <div class="row">
                                                            <div class="col-sm-3">
                                                                Export Percentage
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @forelse ($annual as $ann)
                                                                {{ $ann->nilai_persen }} %
                                                                @empty
                                                                -
                                                                @endforelse
                                                            </div>
                                                        </div> --}}
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Scale of Business
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @if ($data->nmsize != null)
                                                                {{ $data->nmsize }}
                                                                @else
                                                                -
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Email
                                                            </div>
                                                            <div class="col-sm-9">
                                                                :
                                                                @if (empty($data->email) || $data->email == null)
                                                                -
                                                                @else
                                                                {{ $data->email }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                PIC
                                                            </div>
                                                            <div class="col-sm-9">
                                                                :
                                                                @php
                                                                $namapicnya = '';
                                                                $no = 0;
                                                                $datapic = DB::table('itdp_contact_eks')
                                                                ->where('id_itdp_profil_eks', $data->id)
                                                                ->get();
                                                                if (count($datapic) > 0) {
                                                                foreach ($datapic as $namapic) {
                                                                if ($no == 0) {
                                                                $namapicnya .= $namapic->name;
                                                                }else {
                                                                $namapicnya .= ', ' . $namapic->name;
                                                                }
                                                                $no++;
                                                                }
                                                                }
                                                                @endphp
                                                                @if (empty($namapicnya) || $namapicnya == null)
                                                                -
                                                                @else
                                                                {{ $namapicnya }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Telephone
                                                            </div>
                                                            <div class="col-sm-9">
                                                                :
                                                                @php
                                                                $telppicnya = '';
                                                                $no2 = 0;

                                                                $datapic2 = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id_profil='$data->id' limit 1");
                                                                foreach ($datapic2 as $key => $value) {
                                                                    # code...
                                                                    $telppicnya .= $value->phone;
                                                                }
                                                                
                                                                @endphp
                                                                @if (empty($telppicnya) || $telppicnya == null)
                                                                -
                                                                @else
                                                                {{ $telppicnya }}
                                                                @endif
                                                            </div>
                                                        </div>




                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Verify Date
                                                            </div>
                                                            <div class="col-sm-9">
                                                                :
                                                                @if (empty($data->verified_at) || $data->verified_at ==
                                                                null)
                                                                -
                                                                @else
                                                                {{ date('d F Y', strtotime($data->verified_at)) }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Kategori Produk
                                                            </div>
                                                            <div class="col-sm-9">
                                                                :
                                                                @php
                                                                $catnya = '';
                                                                $no3 = 0;
                                                                $categoryutama1 = DB::table('csc_product')
                                                                ->join('csc_product_single', 'csc_product.id',
                                                                'csc_product_single.id_csc_product')
                                                                ->select('csc_product.nama_kategori_en')
                                                                ->groupby('csc_product.nama_kategori_en')
                                                                ->where('id_itdp_profil_eks', $data->id)
                                                                ->where('csc_product_single.status', 2)
                                                                ->get()->pluck('nama_kategori_en')->toArray();
                                                                if (count($categoryutama1) > 0) {
                                                                $catnya = implode(', ', $categoryutama1);
                                                                } else {
                                                                $catnya = '-';
                                                                }
                                                                @endphp
                                                                {{ $catnya }}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- Company Profile End -->

                                                <!-- Trade Capacity-->
                                                <div class="tab-pane fade show active" id="tabs-icons-text-5"
                                                    aria-labelledby="tabs-icons-text-5">
                                                    <div class="card-body cards">
                                                        <h4 class="namecompany">TRADE CAPACITY</h4>
                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Intl. Commercial Terms
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @if ($data->incoterm != null)
                                                                {{ $data->incoterm }}
                                                                @else
                                                                -
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Terms of Payment
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @if ($data->payment != null)
                                                                {{ $data->payment }}
                                                                @else
                                                                -
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Export Year
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @forelse ($annual as $ann)

                                                                {{ $ann->tahun }}
                                                                @empty
                                                                -
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Export Percentage
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @forelse ($annual as $ann)
                                                                {{ $ann->nilai_persen }} %
                                                                @empty
                                                                -
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Total Annual Revenue
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @forelse ($annuals as $anns)
                                                                {{ number_format($anns->suma, 0, '.', '.') }}
                                                                @empty
                                                                -
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Export Market
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @forelse ($market as $ma)
                                                                {{ $ma->country }}
                                                                @empty
                                                                -
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                Export Port
                                                            </div>
                                                            <div class="col-sm-9">
                                                                : @forelse ($port as $po)
                                                                {{ $po->name_port }}
                                                                @empty
                                                                -
                                                                @endforelse
                                                            </div>
                                                        </div>





                                                    </div>
                                                </div>
                                                <!-- Trade Capacity End -->

                                                <!-- Production Capacity -->
                                                <div class="tab-pane fade show active" id="tabs-icons-text-6"
                                                    aria-labelledby="tabs-icons-text-6">
                                                    <div class="card-body cards" style="border-radius:10%">
                                                        <h4 class="namecompany">PRODUCTION CAPACITY</h4>
                                                        <hr>
                                                        {{-- @forelse($capacity as $cap) --}}
                                                        {{-- <p> Factory Address: {{$cap->factory_address}}</p>
                                                        <p> Total Manpower: {{$cap->jumlah_manpower}}</p>
                                                        <p> Production Capacity: {{$cap->kapasitas_terpakai_persen}}</p>
                                                        --}}
                                                        {{-- <div class="card-body"> --}}
                                                            {{-- <div class="" style="border-radius:10px"> --}}

                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        Factory Address
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        :
                                                                        @if ($data->addres != null)
                                                                        {{ $data->addres }}
                                                                        @else
                                                                        -
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        Total Manpower
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        :
                                                                        @if ($data->employe != null)
                                                                        {{ $data->employe }}
                                                                        @else
                                                                        -
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        Production Capacity
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        : @forelse ($capacity as $ca)
                                                                        Own Production :
                                                                        <b>{{ number_format($ca->sendiri_persen, 2, ',',
                                                                            ',') }}
                                                                            %</b>,
                                                                        Outside Production:
                                                                        <b>{{ number_format($ca->outsourcing_persen, 2,
                                                                            ',', ',') }}
                                                                            %</b>
                                                                        @empty
                                                                        -
                                                                        @endforelse
                                                                    </div>
                                                                </div>




                                                                {{--
                                                            </div> --}}
                                                            {{-- @empty
                                                            <p>
                                                                <center>No Data Available</center>
                                                            </p>
                                                            @endforelse --}}
                                                        </div>
                                                    </div>
                                                    <!--Production Capacity End-->

                                                    <!-- Exhibition -->
                                                    <div class="tab-pane fade show active" id="tabs-icons-text-7"
                                                        aria-labelledby="tabs-icons-text-7">
                                                        <div class="card-body cards">
                                                            <h4 class="namecompany">EXHIBITION PARTICIPATION</h4>
                                                            <hr>

                                                            <div class="card accordionnya" style="margin-top: 7px;">
                                                                <div class="card-header headernya" id="heading10">
                                                                    <h5 class="mb-0">
                                                                        <button class="btn btn-link collapsed"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapse10"
                                                                            aria-expanded="flas"
                                                                            aria-controls="collapse10"
                                                                            style="color: #204051;">
                                                                            <b>Exhibition</b>
                                                                        </button>
                                                                    </h5>
                                                                </div>
                                                                <div id="collapse10" class="collapse show"
                                                                    aria-labelledby="heading10"
                                                                    data-parent="#accordion">
                                                                    <div class="card-body">
                                                                        <div class="tab-pane fade show active"
                                                                            id="tabs-icons-text-1" role="tabpanel"
                                                                            aria-labelledby="tabs-icons-text-1-tab"
                                                                            style="overflow-x: auto;">
                                                                            <table id="tableexhibition"
                                                                                class="table table-striped table-hover tblnya">
                                                                                <thead class="text-black"
                                                                                    style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                                                    <tr>
                                                                                        <th>
                                                                                            <center>No</center>
                                                                                        </th>
                                                                                        <th>
                                                                                            <center>Exhibition</center>
                                                                                        </th>
                                                                                        <th>
                                                                                            <center>Year</center>
                                                                                        </th>
                                                                                        {{-- <th>
                                                                                            <center>Country</center>
                                                                                        </th> --}}
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row btn-link" style="color:black">
                                                                <a style="margin-top:-30px; margin-left:20px"
                                                                    data-toggle="modal" data-target="#modalExhib">
                                                                    <i class="fa fa-arrow-right"></i> More Exhibition
                                                                    Participation</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Exhibition End -->

                                                    <!-- Certificate -->
                                                    <div class="tab-pane fade show active" id="tabs-icons-text-8"
                                                        aria-labelledby="tabs-icons-text-8">
                                                        <div class="card-body cards">
                                                            <h4 class="namecompany">CERTIFICATE</h4>
                                                            <hr>
                                                            <div class="col-lg-6"
                                                                style="padding-top:10px; padding-bottom: -10px;">
                                                                <div class="row">
                                                                    @forelse ($certificate as $certif)
                                                                    <div class="col-6">
                                                                        <div class="kontennya kotak">
                                                                            <img style="cursor:pointer"
                                                                                data-toggle="modal"
                                                                                data-target="#modalCertificate{{ $certif->id }}"
                                                                                src="{{ asset('uploads/Certificate/' . $certif->id_itdp_profil_eks . '/' . $certif->image) }}"
                                                                                style="border-radius: 7px">
                                                                            <a
                                                                                style="color:#205871; text-transform: Capitalize;"><b>
                                                                                    <center>{{ $certif->name }}
                                                                                    </center>
                                                                                </b></a>
                                                                        </div>
                                                                    </div>
                                                                    @empty
                                                                    <p>
                                                                        <center>No Data Available</center>
                                                                    </p>
                                                                    @endforelse

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Certificate End -->

                                                    <!-- List Brand -->
                                                    <div class="tab-pane fade show active" id="tabs-icons-text-9"
                                                        aria-labelledby="tabs-icons-text-9">
                                                        <div class="card-body cards">
                                                            <h4 class="namecompany">BRANDS</h4>
                                                            <hr>

                                                            <div class="card accordionnya" style="margin-top: 7px;">
                                                                <div class="card-header headernya" id="headingOne">
                                                                    <h5 class="mb-0">
                                                                        <button class="btn btn-link"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapseOne"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseOne"
                                                                            style="color: #204051;">
                                                                            <b>Brand</b>
                                                                        </button>
                                                                    </h5>
                                                                </div>
                                                                <div id="collapseOne" class="collapse show"
                                                                    aria-labelledby="headingOne"
                                                                    data-parent="#accordion">
                                                                    <div class="card-body">
                                                                        <div class="tab-pane fade show active"
                                                                            id="tabs-icons-text-1" role="tabpanel"
                                                                            aria-labelledby="tabs-icons-text-1-tab"
                                                                            style="overflow-x: auto;">
                                                                            <table id="tablebrands"
                                                                                class="table table-striped table-hover tblnya">
                                                                                <thead class="text-black"
                                                                                    style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                                                    <tr>
                                                                                        <th>
                                                                                            <center>No</center>
                                                                                        </th>
                                                                                        <th>
                                                                                            <center>Brand</center>
                                                                                        </th>
                                                                                        <th>
                                                                                            <center>Year</center>
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row btn-link" style="color:black">
                                                                <a style="margin-top:-30px; margin-left:20px"
                                                                    data-toggle="modal" data-target="#modalBrand">
                                                                    <i class="fa fa-arrow-right"></i> More Brands</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Brands End-->

                                                    <!-- Country Patent Brand -->
                                                    <div class="tab-pane fade show active" id="tabs-icons-text-10"
                                                        aria-labelledby="tabs-icons-text-10">

                                                        <div class="card-body cards">
                                                            <h4 class="namecompany">BRAND PATENT COUNTRY</h4>
                                                            <hr>

                                                            <div class="card accordionnya" style="margin-top: 7px;">
                                                                <div class="card-header headernya" id="headingTwo">
                                                                    <h5 class="mb-0">
                                                                        <button class="btn btn-link collapsed"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapseTwo"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseTwo"
                                                                            style="color: #204051;">
                                                                            <b>Brand Patent Country</b>
                                                                        </button>
                                                                    </h5>
                                                                </div>
                                                                <div id="collapseTwo" class="collapse show"
                                                                    aria-labelledby="headingTwo"
                                                                    data-parent="#accordion">
                                                                    <div class="card-body">
                                                                        <div class="tab-pane fade show active"
                                                                            id="tabs-icons-text-1" role="tabpanel"
                                                                            aria-labelledby="tabs-icons-text-1-tab"
                                                                            style="overflow-x: auto;">
                                                                            <table id="tableCountry"
                                                                                class="table table-striped table-hover tblnya">
                                                                                <thead class="text-black"
                                                                                    style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                                                    <tr>
                                                                                        <th>
                                                                                            <center>No</center>
                                                                                        </th>
                                                                                        <th>
                                                                                            <center>Brand</center>
                                                                                        </th>
                                                                                        <th>
                                                                                            <center>Country</center>
                                                                                        </th>

                                                                                        <th>
                                                                                            <center>Year</center>
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row btn-link" style="color:black">
                                                                <a style="margin-top:-30px; margin-left:20px"
                                                                    data-toggle="modal" data-target="#modalPatent">
                                                                    <i class="fa fa-arrow-right"></i> More Brand Patent
                                                                    Country</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Brand Patent Country End-->

                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-sm-12" id="sticky-sidebar">
                                                <div>
                                                    <nav class="">
                                                        <ul class="nav nav-tabs topnav d-block" id="myTopnav"
                                                            role="tablist">
                                                            <li class="nav-item tabmin">
                                                                <a class="scroll tablink nav-link mb-sm-3 mb-md-0 active"
                                                                    data-toggle="tab" target="_self" role="tab"
                                                                    href="#tabs-icons-text-4">Company Profile</a>
                                                            </li>
                                                            <li class="nav-item tabmin">
                                                                <a class="scroll tablink nav-link mb-sm-3 mb-md-0"
                                                                    data-toggle="tab" target="_self" role="tab"
                                                                    href="#tabs-icons-text-5">Trade Capacity</a>
                                                            </li>
                                                            <li class="n d-blockav-item tabmin ">
                                                                <a class="scroll tablink nav-link mb-sm-3 mb-md-0"
                                                                    data-toggle="tab" target="_self" role="tab"
                                                                    href="#tabs-icons-text-6">Production Capacity</a>
                                                            </li>
                                                            <li class="nav-item tabmin">
                                                                <a class="scroll tablink nav-link mb-sm-3 mb-md-0"
                                                                    data-toggle="tab" target="_self" role="tab"
                                                                    href="#tabs-icons-text-7">Exhibition
                                                                    Participation</a>
                                                            </li>
                                                            <li class="nav-item tabmin">
                                                                <a class="scroll tablink nav-link mb-sm-3 mb-md-0"
                                                                    data-toggle="tab" target="_self" role="tab"
                                                                    href="#tabs-icons-text-8">Certificate</a>
                                                            </li>
                                                            <li class="nav-item tabmin">
                                                                <a class="scroll tablink nav-link mb-sm-3 mb-md-0"
                                                                    data-toggle="tab" target="_self" role="tab"
                                                                    href="#tabs-icons-text-9">Brands</a>
                                                            </li>
                                                            <li class="nav-item tabmin">
                                                                <a class="scroll tablink nav-link mb-sm-3 mb-md-0"
                                                                    data-toggle="tab" target="_self" role="tab"
                                                                    href="#tabs-icons-text-10">Brand Patent Country</a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- All Pop up -->



                            <!--Pop up untuk exhibition Participation-->
                            <div id="modalExhib" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Exhibition Participation</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <table id="tableexhibitionModal"
                                                class="table table-striped table-hover tblnyamodal">
                                                <thead class="text-black"
                                                    style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>
                                                            <center>No</center>
                                                        </th>
                                                        <th>
                                                            <center>Exhibition</center>
                                                        </th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                        {{-- <th>
                                                            <center>Country</center>
                                                        </th> --}}
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--pop up exhibition participation end-->

                            <!--Pop up untuk brands-->
                            <div id="modalBrand" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Brands</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <table id="tablebrandsModal"
                                                class="table table-striped table-hover tblnyamodal">
                                                <thead class="text-black"
                                                    style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>
                                                            <center>No</center>
                                                        </th>
                                                        <th>
                                                            <center>Brand</center>
                                                        </th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--pop up brands end-->

                            <!--Pop up untuk brand patent country -->
                            <div id="modalPatent" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Brand Patent Country</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <table id="tableCountryModal"
                                                class="table table-striped table-hover tblnyamodal">
                                                <thead class="text-black"
                                                    style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>
                                                            <center>No</center>
                                                        </th>
                                                        <th>
                                                            <center>Brand</center>
                                                        </th>
                                                        <th>
                                                            <center>Country</center>
                                                        </th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--pop up brand patent country end-->

                            <!-- All Pop Up End -->

                            <!--PRODUCT-->
                            <div class="tab-pane fade {{ $tabName == 'products' ? 'active show' : '' }}"
                                id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                <div class="shop_area shop_reverse">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-12">
                                                <!--sidebar widget start-->
                                                <aside class="sidebar_widget">
                                                    <div class="widget_inner" style="background : #e9e9ff !important">
                                                        <div class="widget_list widget_categories"
                                                            style="background : #e9e9ff; !important">
                                                            <h2>@lang('frontend.liseksportir.category')</h2>
                                                            <div class="list-group list-group-flush"
                                                                style="background : #e9e9ff; font-size:14px;"
                                                                id="catlist">
                                                                <a href="{{ url('/front_end/list_perusahaan/view/' . $id . '-' . $nama_perusahaan . '/all') }}#tabs-icons-text-2-tab"
                                                                    class="list-group-item">All Categories</a>
                                                                @foreach ($categoryutama as $cu)
                                                                <?php
                                                                // $catprod1 = getCategoryLevel(1, $cu->id, '');
                                                                $catprod1 = getSubCategoryPerusahaan($id, $cu->id);
                                                                // dd($catprod1);
                                                                $nk = 'nama_kategori_' . $lct;
                                                                if ($cu->$nk == null) {
                                                                    $nk = 'nama_kategori_en';
                                                                }
                                                                ?>
                                                                @if (count($catprod1) == 0)
                                                                {{-- <a
                                                                    href="{{ url('/perusahaan-kategori-profil/' . $cu->id . '/' . slugifyTitle($cu->$nk)) }}#tabs-icons-text-2-tab"
                                                                    --}} <a href="#tabs-icons-text-2-tab"
                                                                    class="list-group-item">{{ $cu->$nk }}</a>
                                                                @else
                                                                <a onclick="openCollapse('{{ $cu->id }}')"
                                                                    href="#menus{{ $cu->id }}" class="list-group-item"
                                                                    data-toggle="collapse" data-parent="#MainMenu">
                                                                    {{ $cu->$nk }} <i class="fa fa-chevron-down"
                                                                        aria-hidden="true"
                                                                        style="float: right; margin-right: -10px;"
                                                                        id="fontdrop{{ $cu->id }}"></i></a>
                                                                <div class="collapse" id="menus{{ $cu->id }}">
                                                                    @foreach ($catprod1 as $cat1)
                                                                    {{-- <a
                                                                        href="{{ url('/perusahaan-kategori-profil/' . $cat1->id . '/' . slugifyTitle($cat1->$nk)) }}#tabs-icons-text-2-tab"
                                                                        --}} <a
                                                                        href="{{ url('/front_end/list_perusahaan/view/' . $id . '-' . $nama_perusahaan . '/' . $cat1->id) }}#tabs-icons-text-2-tab"
                                                                        class="list-group-item">{{ $cat1->$nk }}</a>
                                                                    @endforeach
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </aside>
                                                <!--sidebar widget end-->
                                            </div>

                                            <div class="col-lg-9 col-md-12">
                                                <div class="card-body mb--7">
                                                    <h4>All Products</h4>
                                                    <hr>
                                                </div>

                                                <div id="colapseproduct" class="collapse show"
                                                    aria-labelledby="headingprod" data-parent="#accordion"
                                                    style="padding: 17px;">
                                                    <form class="form-horizontal" enctype="multipart/form-data"
                                                        method="GET"
                                                        action="{{ url('/front_end/list_perusahaan/view/' . $param) }}"
                                                        id="formvekssort">
                                                        {{ csrf_field() }}
                                                        <select name="shortprodeks" id="shortprodeks"
                                                            style="border: none;">
                                                            <option value="" @if (isset($sortby)) @if ($sortby=='' )
                                                                selected @endif @endif>
                                                                @lang('frontend.liseksportir.default')</option>
                                                            <option value="new" @if (isset($sortby)) @if ($sortby=='new'
                                                                ) selected @endif @endif>
                                                                @lang('frontend.liseksportir.newest')</option>
                                                            <option value="asc" @if (isset($sortby)) @if ($sortby=='asc'
                                                                ) selected @endif @endif>
                                                                @lang('frontend.liseksportir.prodnm')</option>
                                                        </select>
                                                    </form>

                                                    <div class="row shop_wrapper">
                                                        @foreach ($product as $pro)
                                                        <?php
                                                        //new or not
                                                        if (date('m', strtotime($pro->created_at)) == date('m')) {
                                                            $dis = '';
                                                        } else {
                                                            $dis = 'display: none;';
                                                        }
                                                        
                                                        //category
                                                        $cat1 = getCategoryName($pro->id_csc_product, $lct);
                                                        $cat2 = getCategoryName($pro->id_csc_product_level1, $lct);
                                                        $cat3 = getCategoryName($pro->id_csc_product_level2, $lct);
                                                        
                                                        if ($cat3 == '-') {
                                                            if ($cat2 == '-') {
                                                                $categorynya = $cat1;
                                                                $idcategory = $pro->id_csc_product;
                                                            } else {
                                                                $categorynya = $cat2;
                                                                $idcategory = $pro->id_csc_product_level1;
                                                            }
                                                        } else {
                                                            $categorynya = $cat3;
                                                            $idcategory = $pro->id_csc_product_level2;
                                                        }
                                                        
                                                        //Image
                                                        $img1 = $pro->image_1;
                                                        $img2 = $pro->image_2;
                                                        
                                                        if ($img1 == null) {
                                                            $isimg1 = '/image/notAvailable.png';
                                                        } else {
                                                            $image1 = 'uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img1;
                                                            if (file_exists($image1)) {
                                                                $isimg1 = '/uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img1;
                                                            } else {
                                                                $isimg1 = '/image/notAvailable.png';
                                                            }
                                                        }
                                                        
                                                        $cekImage = explode('.', $img1);
                                                        $sizeImg = 210;
                                                        $padImg = '0px';
                                                        if ($cekImage[count($cekImage) - 1] == 'png') {
                                                            $sizeImg = 190;
                                                            $padImg = '10px 5px 0px 5px';
                                                        }
                                                        $minorder = '-';
                                                        $minordernya = '-';
                                                        if ($pro->minimum_order != null) {
                                                            $minorder = $pro->minimum_order;
                                                            if (strlen($minorder) > 18) {
                                                                $cut_desc = substr($minorder, 0, 18);
                                                                if ($minorder[18 - 1] != ' ') {
                                                                    $new_pos = strrpos($cut_desc, ' ');
                                                                    $cut_desc = substr($minorder, 0, $new_pos);
                                                                }
                                                                $minordernya = $cut_desc . '...';
                                                            } else {
                                                                $minordernya = $minorder;
                                                            }
                                                        }
                                                        $ukuran = '340px';
                                                        if (!empty(Auth::guard('eksmp')->user())) {
                                                            if (Auth::guard('eksmp')->user()->status == 1) {
                                                                $ukuran = '375px';
                                                            }
                                                        }
                                                        
                                                        if ($img2 == null) {
                                                            $isimg2 = '/image/notAvailable.png';
                                                        } else {
                                                            $image2 = 'uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img2;
                                                            if (file_exists($image2)) {
                                                                $isimg2 = '/uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img2;
                                                            } else {
                                                                $isimg2 = '/image/notAvailable.png';
                                                            }
                                                        }
                                                        ?>
                                                        <div class="col-lg-4 col-md-4 col-12 ">
                                                            <div class="single_product"
                                                                style="height: {{ $ukuran }}; background-color: #fdfdfc; padding: 0px !important;">
                                                                <div class="pro-type" style="{{ $dis }}">
                                                                    <span class="pro-type-content">
                                                                        @if ($loc == 'ch')
                                                                        新
                                                                        @elseif($loc == 'in')
                                                                        BARU
                                                                        @else
                                                                        NEW
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <?php
                                                                //cut prod name
                                                                $num_char = 29;
                                                                $prodn = getProductAttr($pro->id, 'prodname', $lct);
                                                                if (strlen($prodn) > 29) {
                                                                    $cut_text = substr($prodn, 0, $num_char);
                                                                    if ($prodn[$num_char - 1] != ' ') {
                                                                        // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                                        $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                                        $cut_text = substr($prodn, 0, $new_pos);
                                                                    }
                                                                    $prodnama = $cut_text . '...';
                                                                } else {
                                                                    $prodnama = $prodn;
                                                                }
                                                                
                                                                //cut company
                                                                $num_charp = 25;
                                                                $compname = getCompanyName($pro->id_itdp_company_user);
                                                                if (strlen($compname) > 25) {
                                                                    $cut_text = substr($compname, 0, $num_charp);
                                                                    if ($compname[$num_charp - 1] != ' ') {
                                                                        // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                                        $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                                        $cut_text = substr($compname, 0, $new_pos);
                                                                    }
                                                                    $companame = $cut_text . '...';
                                                                } else {
                                                                    $companame = $compname;
                                                                }
                                                                
                                                                $num_chark = 32;
                                                                if (strlen($categorynya) > 32) {
                                                                    $cut_text = substr($categorynya, 0, $num_chark);
                                                                    if ($categorynya[$num_chark - 1] != ' ') {
                                                                        // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                                        $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                                        $cut_text = substr($categorynya, 0, $new_pos);
                                                                    }
                                                                    $category = $cut_text . '...';
                                                                } else {
                                                                    $category = $categorynya;
                                                                }
                                                                ?>
                                                                <div class="product_thumb" align="center"
                                                                    style="background-color: #e8e8e4; height: 210px; border-radius: 10px 10px 0px 0px; vertical-align: middle;">
                                                                    <a class="primary_img"
                                                                        href="{{ url('front_end/product/' . $pro->id) }}"
                                                                        onclick="GoToProduct('{{ $pro->id }}', event, this)"><img
                                                                            src="{{ url('/') }}{{ $isimg1 }}" alt=""
                                                                            style="vertical-align: middle; height: {{ $sizeImg }}px; border-radius: 10px 10px 0px 0px; padding: {{ $padImg }}"></a>
                                                                    <!-- <a class="secondary_img" href="{{ url('front_end/product/' . $pro->id) }}"><img src="{{ url('/') }}{{ $isimg2 }}" alt=""></a> -->
                                                                </div>
                                                                <div class="product_name grid_name"
                                                                    style="padding: 0px 13px 0px 13px;">
                                                                    <p class="manufacture_product">
                                                                        <a href="{{ url('front_end/list_product/category/' . $idcategory) }}"
                                                                            title="{{ $categorynya }}"
                                                                            class="href-category">{{ $category }}</a>
                                                                    </p>
                                                                    <h3>
                                                                        <a href="{{ url('front_end/product/' . $pro->id) }}"
                                                                            title="{{ $prodn }}" class="href-name"
                                                                            onclick="GoToProduct('{{ $pro->id }}', event, this)"><b>{{
                                                                                $prodnama }}</b></a>
                                                                    </h3>
                                                                    <span
                                                                        style="font-size: 12px; font-family: 'Open Sans', sans-serif; ">
                                                                        @if (!empty(Auth::guard('eksmp')->user()))
                                                                        @if (Auth::guard('eksmp')->user()->status == 1)
                                                                        Price :
                                                                        @if (is_numeric($pro->price_usd))
                                                                        <?php
                                                                                    $pricenya = "$ " . number_format($pro->price_usd, 0, ',', '.');
                                                                                    $price = $pricenya;
                                                                                    ?>
                                                                        @else
                                                                        <?php
                                                                                    $price = $pro->price_usd;
                                                                                    if (strlen($price) > 25) {
                                                                                        $cut_text = substr($price, 0, 25);
                                                                                        if ($price[25 - 1] != ' ') {
                                                                                            $new_pos = strrpos($cut_text, ' ');
                                                                                            $cut_text = substr($price, 0, $new_pos);
                                                                                        }
                                                                                        $pricenya = $cut_text . '...';
                                                                                    } else {
                                                                                        $pricenya = $price;
                                                                                    }
                                                                                    ?>
                                                                        @endif
                                                                        <span style="color: #fd5018;"
                                                                            title="{{ $price }}">
                                                                            {{ $pricenya }}
                                                                        </span>
                                                                        <br>
                                                                        @endif
                                                                        @endif

                                                                        {{ $order }}<span title="{{ $minorder }}">{{
                                                                            $minordernya }}</span><br>
                                                                        <a href="{{ url('front_end/list_perusahaan/view/' . $param) }}"
                                                                            title="{{ $compname }}"
                                                                            class="href-company"><span
                                                                                style="color: black;">{{ $by
                                                                                }}</span>&nbsp;&nbsp;{{ $companame
                                                                            }}</a>
                                                                    </span>
                                                                </div>
                                                                <div class="product_content list_content"
                                                                    style="width: 100%;">
                                                                    <div class="left_caption">
                                                                        <div class="product_name">
                                                                            <h3>
                                                                                <a href="{{ url('front_end/product/' . $pro->id) }}"
                                                                                    title="{{ $prodn }}"
                                                                                    class="href-name"
                                                                                    style="font-size: 15px !important;"
                                                                                    onclick="GoToProduct('{{ $pro->id }}', event, this)"><b>{{
                                                                                        $prodn }}</b></a>
                                                                            </h3>
                                                                            <h3>
                                                                                <a href="{{ url('front_end/list_perusahaan/view/' . $param) }}"
                                                                                    title="{{ $compname }}"
                                                                                    class="href-company"><span
                                                                                        style="color: black;">by</span>&nbsp;&nbsp;{{
                                                                                    $compname }}</a>
                                                                            </h3>
                                                                        </div>
                                                                        <div class="product_desc">
                                                                            <?php
                                                                            $proddesc = getProductAttr($pro->id, 'product_description', $lct);
                                                                            $num_desc = 350;
                                                                            if (strlen($proddesc) > $num_desc) {
                                                                                $cut_desc = substr($proddesc, 0, $num_desc);
                                                                                if ($proddesc[$num_desc - 1] != ' ') {
                                                                                    // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                                                    $new_pos = strrpos($cut_desc, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                                                    $cut_desc = substr($proddesc, 0, $new_pos);
                                                                                }
                                                                                $product_desc = $cut_desc . '...';
                                                                            } else {
                                                                                $product_desc = $proddesc;
                                                                            }
                                                                            $product_desc = strip_tags($product_desc, '<br><i><b><u><hr>');
                                                                            $capacitynya = '-';
                                                                            if ($pro->capacity != null) {
                                                                                if ($loc == 'ch') {
                                                                                    $capacitynya = '库存 ' . $pro->capacity . ' 件';
                                                                                } elseif ($loc == 'in') {
                                                                                    $capacitynya = $pro->capacity . ' dalam persediaan';
                                                                                } else {
                                                                                    $capacitynya = $pro->capacity . ' in stock';
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <?php echo $product_desc; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="right_caption">
                                                                        <div class="text_available">
                                                                            <p>
                                                                                @lang('frontend.available'):
                                                                                <span>{{ $capacitynya }}</span>
                                                                            </p>
                                                                        </div>
                                                                        <div class="price_box">
                                                                            @if (!empty(Auth::guard('eksmp')->user()))
                                                                            @if (Auth::guard('eksmp')->user()->status ==
                                                                            1)
                                                                            <span class="current_price">
                                                                                @if (is_numeric($pro->price_usd))
                                                                                $
                                                                                {{ number_format($pro->price_usd, 0,
                                                                                ',', '.') }}
                                                                                @else
                                                                                <span style="font-size: 13px;">
                                                                                    {{ $pro->price_usd }}
                                                                                </span>
                                                                                @endif
                                                                            </span>
                                                                            @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <br>
                                                    @if ($coproduct > 12)
                                                    <div class="pagination" style="float: right;">
                                                        {{ $product->links('vendor.pagination.bootstrap-4') }}
                                                        {{ $product->total() == 0 ?
                                                        Lang::get('frontend.event_zoom.no_result') : '' }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END PRODUCT-->

                            @if (!empty(Auth::guard('eksmp')->user()) || !empty(Auth::user()))
                            <!-- SEND INQUIRY -->
                            <div class="tab-pane fade @if (isset($cat) && isset($send)) active show @endif"
                                id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <div class="shop_area shop_reverse">
                                    <div class="container">
                                        <form class="form-horizontal" method="POST"
                                            action="{{ url('br_importir_save_new') }}" enctype="multipart/form-data"
                                            id="form_br">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id_eks" id="id_eks" value="{{ $data->id_user }}">
                                            <div class="row">
                                                <div class="form-row">
                                                    <div class="col-sm-12">
                                                        <label>
                                                            <h5><b>@lang("login.forms.by1")</b></h5>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <label><b>@lang("login.forms.by2") (<font color="red">*</font>
                                                            )</b></label>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <input type="hidden" style="color:black;font-size:12px;" value=""
                                                        name="subyek" id="subyek" class="form-control" required>
                                                    @php
                                                    $prod = DB::table('csc_product_single')
                                                    ->where('id_itdp_company_user', $id)
                                                    ->where('csc_product_single.status', 2)
                                                    ->orderBy('prodname_en')
                                                    ->get();
                                                    @endphp
                                                    <select style="color:black;font-size:12px;height: 31px;" style="border-color: rgba(120, 130, 140, 0.5)!important;
                                                            border-radius: 0.25rem!important;
                                                            color: inherit!important; font-size: 12px!important;"
                                                        class="form-control select2" name="subyek2" id="subyek2"
                                                        onchange="selectProduct()" required>
                                                        <option value="" disabled selected>@lang("login.forms.by14")
                                                        </option>
                                                        @foreach ($prod as $val)
                                                        <option value="@php echo $val->id; @endphp"
                                                            style="font-size:12px;">
                                                            {{ $val->prodname_en }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="col-sm-12">
                                                    <label><b>@lang("login.forms.by3") (<font color="red">*</font>
                                                            )</b></label> :
                                                    <select name="category" id="category"
                                                        class="form-input select span16 J-noselect"
                                                        cz-css="form-inline span16">
                                                        <option class="option" value="unselect"
                                                            style="display: none; color: menutext;">Please select
                                                        </option>
                                                        <option value="nhpasQEVtmJx">Construction &amp;
                                                            Decoration»Building Glass»Tempered Glass</option>
                                                        <option class="option" value="unfind" style="color: menutext;">
                                                            Don't find? Choose my category.</option>
                                                    </select>
                                                    <a data-toggle="modal" data-target="#catModal" id="labelcat"
                                                        href="#">
                                                        Click Here to Select Category
                                                    </a>
                                                    <input type="hidden" name="val_category" id="val_category" value="">
                                                    <input type="hidden" name="gabungan" id="gabungan" value="">
                                                    <input type="hidden" name="gabungan2" id="gabungan2">
                                                </div> --}}
                                                <div class="col-sm-12">
                                                    <label><b>@lang("login.forms.by4") (<font color="red">*</font>
                                                            )</b></label>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <textarea style="color:black;font-size:12px;" name="spec" id="spec"
                                                        class="form-control"></textarea>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label><b>@lang("login.forms.by5")</b></label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label><b>@lang("login.forms.by15")</b></label>
                                                </div>


                                                <div class="form-group col-sm-12">
                                                    <div class="form-row">
                                                        <div class="col-sm-4">
                                                            <input style="height:45px; color:black;font-size:12px;"
                                                                type="text" value="" type="number" min="1" name="eo"
                                                                id="eo" class="form-control amount">
                                                        </div>


                                                        <div class="col-sm-2">
                                                            <select class="form-control"
                                                                style="font-size:13px;height: 31px;" name="neo"
                                                                id="neo">
                                                                <option value="" disabled selected>
                                                                    @lang("login.forms.by14")
                                                                </option>
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

                                                <div class="col-sm-12">
                                                    <label><b>@lang("login.forms.by6") <span
                                                                id="fob">(FOB)</span></b></label>
                                                </div>

                                                <div class="form-group col-sm-12">
                                                    <div class="form-row">
                                                        <div class="col-sm-4" style="font-size: 12px !important;">
                                                            <input style="height:45px; color:black;font-size:12px;"
                                                                type="text" value="<?php if (empty($tp)) {
                                                                } else {
                                                                    echo number_format($R, 0, ',', '.');
                                                                } ?>" name="tp" id="tp" class="form-control amount">
                                                        </div>
                                                        <div class="col-sm-1 mt-2">
                                                            <b>USD</b>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label><b>@lang("login.forms.by7") (<font color="red">*</font>
                                                            )</b></label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label><b>@lang("login.forms.bw2") (<font color="red">*</font>
                                                            )</b></label>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <div class="form-row">
                                                        <div class="col-sm-4" style="font-size: 12px !important;">
                                                            <?php
                                                            $ms2 = DB::select('select id,country from mst_country order by country asc');
                                                            $id_mst_country = isset($profile) ? $profile->id_mst_country : '';
                                                            ?>
                                                            <select style="color:black;font-size:12px;height: 31px;"
                                                                style="border-color: rgba(120, 130, 140, 0.5)!important;
                                                            border-radius: 0.25rem!important;
                                                            color: inherit!important; font-size: 12px!important;"
                                                                class="form-control select2" name="country" id="country"
                                                                required>
                                                                <?php foreach($ms2 as $val2){ ?>
                                                                <option value="<?php echo $val2->id; ?>"
                                                                    style="font-size:12px;" @if ($val2->id ==
                                                                    $id_mst_country) selected @endif>
                                                                    <?php echo $val2->country; ?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input style="height:45px; color:black;font-size:12px;"
                                                                type="text" value="" name="city" id="city"
                                                                class="form-control"
                                                                placeholder='@lang("login.forms.bw2")'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label><b>@lang("login.forms.by10_2") (<font color="red">*
                                                            </font>
                                                            )</b></label>
                                                </div>
                                                <br />
                                                <div class="form-group col-sm-4">
                                                    <select style="color:black;font-size:12px;height: 31px;"
                                                        class="form-control" name="valid" id="valid" required>
                                                        {{-- <option value="">@lang("login.forms.by10")</option> --}}
                                                        {{-- <option value="0">None</option>
                                                        <option value="1">Valid within a day</option> --}}
                                                        <option value="3">Valid within 3 days</option>
                                                        <option value="5">Valid within 5 days</option>
                                                        <option value="7">Valid within 7 days</option>
                                                        <option value="15">Valid within 15 days</option>
                                                        <option value="30">Valid within 30 days</option>
                                                    </select>
                                                </div>


                                                {{-- <div class="col-sm-12">
                                                    <label><b>@lang("login.forms.by8")</b></label>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <textarea style="color:black;font-size:12px;" value="" name="ship"
                                                        id="ship" class="form-control"></textarea>
                                                </div> --}}

                                                {{-- <div class="col-sm-12">
                                                    <label><b>@lang("login.forms.by9")</b></label>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <input style="color:black;" type="file" value="" name="doc" id="doc"
                                                        class="form-controlz" required><br>
                                                    <span>
                                                        <font color="red">* accept word, excel, ppt & pdf</font>
                                                    </span>
                                                </div> --}}

                                                <div class="col-sm-12">
                                                    <div class="checkbox">
                                                        <br />
                                                        <p>To further increase the inquiry response rate, this
                                                            information can also be addressed to all Inaexport
                                                            members
                                                        </p>
                                                        <input class="eksportir" name="publish" type="checkbox"
                                                            id="publish" value="true">
                                                        <label for="publish">I agree, this inquiry reply by others
                                                            members
                                                            of inaexport</label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <center>
                                                        <a href="{{ url('/supliers') }}" class="btn btn-danger"><i
                                                                class="fa fa-arrow-left"
                                                                aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.cancel')</a>
                                                        <button type="submit" class="btn btn-primary" id="btnsubmit"><i
                                                                class="fa fa-paper-plane"
                                                                aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.submit')</button>
                                                    </center>
                                                </div>
                                            </div>
                                    </div>
                                    </form>
                                </div>

                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#2e899e; color:white;">
                                                <h6>Broadcast
                                                    Buying Request</h6>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">&times;</button>
                                            </div>
                                            <div id="isibroadcast"></div>
                                            <div class="modal-body">
                                                <font color="black"> You Want Broadcast Buying Request Now ?</font>
                                            </div>
                                            <div class="modal-footer" id="mf">

                                                <a href="{{ url('front_end/history') }}" type="button"
                                                    class="btn btn-info">Go To History List</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="myModal2" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#2e899e; color:white;">
                                                <h6>Broadcast Buying Request</h6>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>

                                            </div>
                                            <div id="isibroadcast2"></div>
                                            <!--<div class="modal-body">
                                        1
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div> -->
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- SEND INQUIRY END -->
                    @endif


                </div>

            </div>

        </div>

    </div>


    <!--Pop up untuk Certificate-->

    @foreach ($certificate as $certif)
    <div id="modalCertificate{{ $certif->id }}" class="modal fade" aria-labelledby="exampleModalLabel" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-transform: Capitalize;">{{ $certif->name }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {{-- <a style="color:#205871; text-transform: Capitalize;"><b>
                        <center>{{ $certif->name }}</center>
                    </b></a> --}}
                <div class="modal-body">
                    <center><img
                            src="{{ asset('uploads/Certificate/' . $certif->id_itdp_profil_eks . '/' . $certif->image) }}"
                            style="border-radius:7px"></center>

                    <div class="card-body">
                        <table class="table table-bordered table-light table1">
                            <tbody>
                                <tr>
                                    <td width="20%" class="table-active">
                                        <b> Reference No </b>
                                    </td>
                                    <td width="30%">
                                        {{ $certif->no_ref }}
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="table-active">
                                        <b> Category </b>
                                    </td>
                                    <td width="30%">
                                        {{ $certif->category }}
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="table-active">
                                        <b> Type of Certificate </b>
                                    </td>
                                    <td width="30%">
                                        {{ $certif->type }}
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="table-active">
                                        <b> This Certificate Valid From </b>
                                    </td>
                                    <td width="50%">
                                        <b>{{ date('d M Y', strtotime($certif->start_date)) }}</b>
                                        Until
                                        <b>{{ date('d M Y', strtotime($certif->end_date)) }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!--pop up exhibition certificate end-->



    <!-- Plugins JS -->
    <script src=""></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    @include('frontend.layouts.footer')

    <script>
        function selectProduct() {
        var subyek = $('#subyek2 option:selected').text();
        $('#subyek').val(subyek);
    }

    $('#tablebrands').DataTable({
        processing: true,
        serverSide: true,
        bPaginate: false,
        bLengthChange: true,
        bFilter: false,
        bInfo: false,
        bAutoWidth: false,
        ajax: "{{ url('front_end/data-brand/' . $id) }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'merek',
                name: 'merek'
            },

            {
                data: 'tahun_merek',
                name: 'tahun_merek'
            },

        ]
    });

    $('#tablebrandsModal').DataTable({
        processing: true,
        serverSide: true,
        bPaginate: false,
        bLengthChange: true,
        bFilter: false,
        bInfo: false,
        bAutoWidth: false,
        ajax: "{{ url('front_end/data-brand-modal/' . $id) }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'merek',
                name: 'merek'
            },

            {
                data: 'tahun_merek',
                name: 'tahun_merek'
            },

        ]
    });

    $('#tableCountry').DataTable({
        processing: true,
        serverSide: true,
        bPaginate: false,
        bLengthChange: true,
        bFilter: false,
        bInfo: false,
        bAutoWidth: true,
        ajax: "{{ url('front_end/country_patern_brand/' . $id) }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'merek',
                name: 'merek'
            },
            {
                data: 'country',
                name: 'country'
            },
            {
                data: 'tahun',
                name: 'tahun'
            },
        ]
    });

    $('#tableCountryModal').DataTable({
        processing: true,
        serverSide: true,
        bPaginate: false,
        bLengthChange: true,
        bFilter: false,
        bInfo: false,
        bAutoWidth: false,
        ajax: "{{ url('front_end/country_patern_brand_modal/' . $id) }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'merek',
                name: 'merek'
            },
            {
                data: 'country',
                name: 'country'
            },
            {
                data: 'tahun',
                name: 'tahun'
            },
        ]
    });

    $('#tableexhibition').DataTable({
        processing: true,
        serverSide: true,
        bPaginate: false,
        bLengthChange: false,
        bFilter: false,
        bInfo: false,
        bAutoWidth: false,
        ajax: "{{ url('front_end/data-exhib/' . $id) }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'event_name_en',
                name: 'event_name_en'
            },
            {
                data: 'tahun',
                name: 'tahun'
            }
            // {
            //     data: 'country',
            //     name: 'country'
            // }
        ]
    });

    $('#tableexhibitionModal').DataTable({
        processing: true,
        serverSide: true,
        bPaginate: false,
        bLengthChange: true,
        bFilter: false,
        bInfo: false,
        bAutoWidth: false,
        ajax: "{{ url('front_end/data-exhib-modal/' . $id) }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'event_name_en',
                name: 'event_name_en'
            },
            {
                data: 'tahun',
                name: 'tahun'
            }
            // {
            //     data: 'country',
            //     name: 'country'
            // }
        ]
    });
    </script>


    <script type="text/javascript">
        $('.tablink').on('click', function(e) {
        $('li a').removeClass("active");
        $(this).addClass("active");
    });

    $('a.scroll').on('click', function(e) {
        var href = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(href).offset().top
        }, 'slow');
        e.preventDefault();
    });
    </script>

    <script type="text/javascript">
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
        removeMaskOnSubmit: true
    });

    function openCity(evt, Tabname) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#' + tabname).addClass('active');
    }

    $('#neo').change(function() {
        $('#fob').html('(FOB/' + $('#neo').val() + ')')
    });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
        $(".alert").slideDown(300).delay(1000).slideUp(300);




        $('#tableexdes').DataTable({
            processing: true,
            serverSide: true,
            bPaginate: false,
            bLengthChange: false,
            bFilter: true,
            bInfo: false,
            bAutoWidth: false,
            ajax: "{{ url('front_end/data-capacity/' . $id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'kapasitas_terpakai_persen',
                    name: 'kapasitas_terpakai_persen'
                },
            ]
        });
        $('#tableprocap').DataTable({
            processing: true,
            serverSide: true,
            bPaginate: false,
            bLengthChange: false,
            bFilter: true,
            bInfo: false,
            bAutoWidth: false,
            ajax: "{{ url('front_end/data-procap/' . $id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'sendiri_persen',
                    name: 'sendiri_persen'
                },
                {
                    data: 'outsourcing_persen',
                    name: 'outsourcing_persen'
                },
            ]
        });



        //end data 
        $("#shortprodeks").on('change', function() {
            $('#formvekssort').submit();
        })

        $("#shortsrveks").on('change', function() {
            $('#formsrvsort').submit();
        })

        $('#grid').on('click', function() {
            $('.product_thumb').css({
                "margin-top": "0px",
                "border-radius": "10px 10px 0px 0px"
            });
        })

        $('#list').on('click', function() {
            $('.product_thumb').css({
                "margin-top": "60px",
                "border-radius": "0px 10px 10px 0px"
            });
        });


    });

    function GoToProduct(id, e, obj) {
        e.preventDefault();
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('product.hot') }}",
            type: 'post',
            data: {
                '_token': token,
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response == 'ok') {
                    location.href = obj.href;
                }
            }
        });
    }

    function openlink() {
        window.location = "{{ url('br_importir_add/suplaier/' . $id) }}";

    }

    function exportData() {
        window.location = "{{ url('/front_end/listeksportir/cetakpdfnew/' . $data->id) }}";
    }
    </script>
    <?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script>
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
        removeMaskOnSubmit: true
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
    $('#eo').inputmask({
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
        }
    });
    var checkbuttonbroadcast = 0;

    function simpanbr() {
        var formData = new FormData();

        // formData.append('subyek', $('#subyek').val());
        // formData.append('valid', $('#valid').val());
        // formData.append('category', $('#category').val());
        // formData.append('t2s', $('#t2s').val());
        // formData.append('t3s', $('#t3s').val());
        // formData.append('spec', $('#spec').val());
        // formData.append('eo', $('#eo').val());
        // formData.append('neo', $('#neo').val());
        // formData.append('tp', $('#tp').val());
        // formData.append('ntp', $('#ntp').val());
        // formData.append('country', $('#country').val());
        // formData.append('city', $('#city').val());
        // formData.append('ship', $('#ship').val());
        // formData.append('_token', '{{ csrf_token() }}');
        // formData.append('image', $('input[type=file]')[0].files[0]);
        // var token = $('meta[name="csrf-token"]').attr('content');
        if (document.getElementById("val_category").value != 1) {
            alert("Please Select at least 1 Category")
            return false;
        }

        $("#myModal2").modal("show");
        yz({
            category: $('#category').val(),
            sub_category_1: $('#t2s').val(),
            sub_category_2: $('#t3s').val(),
            subyek: $('#subyek').val(),
        });
        // $.ajax({
        //     type: "POST",
        //     url: '{{ url('/br_importir_save') }}',
        //     data: formData,
        //     contentType: false,
        //     processData: false,
        //     beforeSend: function() {
        //         $("#grey_loading").show();
        //         $("#loader").show();
        //     },
        //     success: function(data) {
        //         // if(checkbuttonbroadcast < 1){
        //         //     $('#mf').append(data);
        //         //     checkbuttonbroadcast = 1;
        //         // }else{
        //         //     console.log('gak ditambah lagi');
        //         // }
        //         yz(data);
        //     },
        //     complete: function(data) {
        //         $("#grey_loading").hide();
        //         $("#loader").hide();
        //         console.log("complete");
        //     },
        //     error: function(data, textStatus, errorThrown) {
        //         console.log(data);

        //     },
        // });



        // // $("#myModal").modal("show"); 
    }

    function formatAmountNoDecimals(number) {
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(number)) {
            number = number.replace(rgx, '$1' + '.' + '$2');
        }
        return number;
    }

    function formatAmount(number) {

        // remove all the characters except the numeric values
        number = number.replace(/[^0-9]/g, '');

        // set the default value
        if (number.length == 0) number = "0.00";
        else if (number.length == 1) number = "0.0" + number;
        else if (number.length == 2) number = "0." + number;
        else number = number.substring(0, number.length - 2) + '.' + number.substring(number.length - 2, number.length);

        // set the precision
        number = new Number(number);
        number = number.toFixed(2); // only works with the "."

        // change the splitter to ","
        number = number.replace(/\./g, '');

        // format the amount
        x = number.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';

        return formatAmountNoDecimals(x1) + x2;
    }


    var dataeksportir = [];

    function calldata() {
        var id = $('#id_laporan').val();
        $.ajax({
                method: "POST",
                url: "{!! url('getdatapiliheksportir') !!}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_laporan: id
                }
            })
            .done(function(data) {
                $.each(data, function(i, val) {
                    $param = 1;
                    $('#tabelpiliheksportir').DataTable().row.add(['<a href=' +
                        "{{ url('perusahaan/') }}/" + val.id + ' target="_blank">' + val
                        .company +
                        '</a>',
                        '<center><div class="checkbox"><input class="eksportir" name="eksportir" type="checkbox" value="' +
                        val.id + '"></div></center>'
                    ]).draw();

                    // $('#tabelpiliheksportir').DataTable().row.add([val.company]).draw();
                });
            });


    }


    function savecheckall() {
        $.each($("input[name='eksportir']:checked"), function() {
            val = $(this).val();
            if (dataeksportir.includes(val)) {} else {
                $('input:checkbox[value=' + val + ']').attr('disabled', true)
                dataeksportir.push($(this).val());
            }
        });
        $("input[name='checkall']").prop('checked', false);
    }

    function broadcast() {
        var id = $('#id_buyingrequest').val();
        var publish = $('#publish').prop("checked");

        var formData = new FormData();

        formData.append('subyek', $('#subyek').val());
        formData.append('valid', $('#valid').val());
        formData.append('category', $('#category').val());
        formData.append('t2s', $('#t2s').val());
        formData.append('t3s', $('#t3s').val());
        formData.append('spec', $('#spec').val());
        formData.append('eo', $('#eo').val());
        formData.append('neo', $('#neo').val());
        formData.append('tp', $('#tp').val());
        formData.append('ntp', $('#ntp').val());
        formData.append('country', $('#country').val());
        formData.append('city', $('#city').val());
        formData.append('ship', $('#ship').val());
        formData.append('publish', $('#publish').val());
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('image', $('input[type=file]')[0].files[0]);

        var dataeksportir = [];
        // dataTable.rows().nodes().to$().find('input[name="eksportir"]').each(function(){
        //     dataeksportir.push($(this).val());
        // })
        $.each($("input[name='eksportir']:checked"), function() {
            var val = $(this).val();
            if (dataeksportir.includes(val)) {} else {
                dataeksportir.push($(this).val());
            }
        });
        var form_data = new FormData();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}'
            }
        });
        let id_csc_buying_request;
        $.ajax({
            type: "POST",
            url: '{{ url('/br_importir_save') }}',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $("#grey_loading").show();
                $("#loader").show();
            },
            success: function(data) {
                // if(checkbuttonbroadcast < 1){
                //     $('#mf').append(data);
                //     checkbuttonbroadcast = 1;
                // }else{
                //     console.log('gak ditambah lagi');
                // }
                form_data.append('dataeksportir', dataeksportir);
                form_data.append('publish', publish)
                form_data.append('id', data);

                $.ajax({
                        method: "POST",
                        url: "{{ route('broadcastbuyingrequest.imp') }}",
                        data: form_data,
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        error: function() {
                            window.location = '{{ url('front_end/history') }}';
                        }
                    })
                    .done(function(e) {
                        window.location = '{{ url('front_end/history') }}';
                        // window.location = '{{ url('/br_list') }}';
                    });

            },
            complete: function(data) {
                $("#grey_loading").hide();
                $("#loader").hide();
                console.log("complete");
            },
            error: function(data, textStatus, errorThrown) {
                console.log(data);

            },
        });
    }
    // var checkedValue = $('.eksportirterpilih:checked').val();
    function isEmptyM(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }


    $(function() {
        $("#tabelpiliheksportir").DataTable({
            processing: true,
            orderable: false,
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan MENU entri",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                info: "Menampilkan START sampai END dari TOTAL entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari MAX entri keseluruhan)",
                infoPostFix: "",
                search: "Cari:",
                url: "",
                infoThousands: ".",
                loadingRecords: "Sedang memproses...",
                paginate: {
                    first: "<<",
                    last: ">>",
                    next: "Selanjutnya",
                    previous: "Sebelum"
                },
                aria: {
                    sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                    sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                }
            }
        });

    });
    </script>
    <script type="text/javascript">
        function buk() {
        if (confirm('You Must Login First !')) {
            window.location.href = "{{ URL::to('/login') }}";
        } else {}
        // alert('You Need Login as Importir !');
    }

    function bak() {
        if (confirm('You Must Login First !')) {
            window.location.href = "{{ URL::to('/login') }}";
        } else {}
        {{-- alert('You Must Login First ! <a href="{{URL::to('/login')}}">Go to Login Page</a>'); --}}
        {{-- window.location.href = "{{URL::to('restaurants/20')}}" --}}
    }

    $(document).ready(function() {
        $('.select2').select2({
            dropdownPosition: 'below'
        });

    });
    </script>
    <script>
        function catLabel() {
        var text = 'Select Category';
        var category = $('#category option:selected').text();
        if (category != '') {
            text = category;
            document.getElementById("val_category").value = 1;
            var cat1 = $('#t2s option:selected').text();
            if (cat1 != '') {
                text += ' » ' + cat1;
            }
            var cat2 = $('#t3s option:selected').text();
            if (cat2 != '') {
                text += ' » ' + cat2;
            }
        }
        $('#labelcat').html(text);
    }

    function xy(a) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilbroad/') }}/' + a, {
            _token: token
        }, function(data) {
            $("#isibroadcast").html(data);

        })
        $('.cobas2').select2();
    }

    function yz(a) {

        console.log(a);
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilbroad2') }}/?category=' + a.category + '&sub_category_1=' + a.sub_category_1 +
            '&sub_category_2=' + a.sub_category_2 + '&subyek=' + a.subyek + '', {
                _token: token
            },
            function(data) {
                $("#isibroadcast2").html(data);
                calldata();

            })

        $("#myModal").modal("hide");
        $("#myModal2").modal("show");

    }

    function t1() {
        $('#t2').html('');
        $('#t3').html('');
        var t1 = $('#category').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilt2/') }}/' + t1 + '/' + {{ $id }}, {
            _token: token
        }, function(data) {
            $("#t2").html(data);
            $("#t3").html(
                '<input type="hidden" name="t3s" id="t3s" value="0" size="13" class="column J-noselect">');
            $('.select2').select2();
        })
        document.getElementById("gabungan2").value = t1;
        catLabel();
    }

    function t2() {
        $('#t3').html('');
        var t2 = $('#t2s').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilt3/') }}/' + t2, {
            _token: token
        }, function(data) {
            $("#t3").html(data);
            $('.select2').select2();
        })
        document.getElementById("gabungan").value = t2;
        // console.log(t2);
        catLabel()
    }

    function t3() {
        catLabel();
    }

    function nv() {
        var a = $('#staim').val();
        if (a == 2) {
            $('#sh1').html(
                '<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id; ?>"><?php echo $qr->nama_template; ?></option><?php } ?></select></div></div>'
            )
        } else {
            $('#sh1').html(' ');
            $('#sh2').html(' ');
        }
    }

    function ketv() {
        var a = $('#template_reject').val();
        if (a == 1) {
            $('#sh2').html(
                '<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>'
            )
        }
    }

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    </script>
    <script type="text/javascript">
        // $(document).ready(function () {

    // })

    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#' + tabname).addClass('active');
    }

    $('#neo').change(function() {
        $('#fob').html('(FOB/' + $('#neo').val() + ')')
    });

    $(function() {
        if (window.location.href.indexOf("page") > -1) {
            $('a[href="#tabs-icons-text-2"]').tab('show');
        }
    })
    </script>