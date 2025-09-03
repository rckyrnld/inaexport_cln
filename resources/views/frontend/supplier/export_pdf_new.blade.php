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
    /* header dan footer start*/

    @page {
        margin: 100px 15px;
        /* margin-top: 180px; */
    }

    #head {
        /* position: fixed; */
        top: -90px;
        left: 0px;
        right: 0px;
        /* height: 200px; */

        /** Extra personal styles **/
        /* background-color: #03a9f4; */
        color: black;
        text-align: center;
        line-height: 35px;
        /* padding-bottom: 150px; */
        /* margin-bottom: 150px; */
    }

    footer {
        position: fixed;
        bottom: -100px;
        left: -30px;
        right: -30px;
        height: 40px;

        /** Extra personal styles **/
        background-color: #f8f8f8;
        color: rgba(0, 0, 0, 0.801);
        text-align: center;
        line-height: 15px;
    }

    /* header dan footer end */

    .table-light {
        background-color: #f8f8f8 !important;
        border: none;
    }

    .thead-light th {
        background-color: #ebebeb !important;
    }

    .table-active {
        background-color: #ebebeb !important;
    }

    .table-bordered td,
    .table-bordered th {
        border: 0.1px solid white;
    }

    .table {
        width: 100%;
        border: 0.5px solid black;

    }

    .table td,
    .table th {
        padding: 0.75rem;
        vertical-align: top;
        border: 0.1px solid white;
    }


    .namecompany {
        text-shadow: 1px 1Px 20px #74A9B4;
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

    .judul {
        color: #1a70bb;
        margin-bottom: -0.04;
        margin-top: 15px;
    }


    .eksporter_img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        margin-top: -55px;
        background-color: #FFFFFF" 

    }

    .cards {
        margin-top: -20px;
    }

    .garis {
        margin-top: -30px;
    }

</style>

<?php
//Image
$img1 = $data->foto_profil;

if ($img1 == null) {
    $isimg1 = 'assets/assets/versi 1/logo perusahaan-01.png';
} else {
    $image1 = 'uploads/Profile/Eksportir/' . $data->id_user . '/' . $img1;
    if (file_exists($image1)) {
        $isimg1 = 'uploads/Profile/Eksportir/' . $data->id_user . '/' . $img1;
    } else {
        $isimg1 = 'assets/assets/versi 1/logo perusahaan-01.png';
    }
}
$param = $data->id_user . '-' . getCompanyName($data->id_user);
$param2 = getExBadan($data->id_user);
?>

<!--Header-->
{{-- <center><img src="{{ asset($isimg1) }}"  class = "eksporter_img" style="margin-top: -160px; background-color:#FFFFFF"></center> --}}
<center>
    <h3 style="text-transform: uppercase; margin-top:-60px"><b></b></h3>
</center>
<center>
    <h5 style="text-transform: Capitalize; margin-top:-40px;"></h5>
</center>
{{-- <hr style="margin-top:10px"> --}}
<!--Header End-->

<div id="head">
    <center><img src="{{ asset($isimg1) }}" alt="" class="eksporter_img"></center>
    <center>
        <h3 style="text-transform: uppercase; margin-top:-10px">
            <b>{{ $data->company }},{{ $data->nmbadanusaha }}</b>
        </h3>
    </center>
    @php
        $alamat = $data->addres . ', ' . $data->city;
        // $alamat = "Graha Jepe 9, 2nd/F. Jl. Raya Ragunan No.9, South Jakarta, DKI Jakarta, Indonesia, 12540, South Jakarta South Jakarta Southssdd";
    @endphp
    @if (strlen($alamat) <= 127)
        <center>
            <h5 style="text-transform: Capitalize; margin-top:-37px;">{{ $alamat }},
            </h5>

            <h5 style="margin-top:-38px;">
                {{ getProvinceName($data->id_mst_province, $lct) }} - INDONESIA
            </h5>
        </center>
    @else

        <center>
            <h5 style="text-transform: Capitalize; margin-top:-15px; line-height: 12pt">
                

                {{ $alamat }}
            </h5>
        </center>
        <center style="line-height: 12pt; margin-top: -38px">
            <h5>
                {{ getProvinceName($data->id_mst_province, $lct) }} - INDONESIA
            </h5>
        </center>
    @endif
    <hr style="margin-top:-20px">
</div>

<footer>
    <p>inaexport</p>
</footer>

<!--Company Profile-->
<h4 class="judul"><b>Company Profile</b></h4>
<table border="0" width="100%">
    <tr valign="top">
        <td style="width:222px">
            Description
        </td>
        <td style="width:10px;">:</td>
        <td>
            @if ($data->description != null)
                {{ $data->description }}
            @else
                -
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Business Type
        </td>
        <td>:</td>
        <td>
            @if ($data->nmtype != null)
                {{ $data->nmtype }}
            @else
                -
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Main Product
        </td>
        <td>:</td>
        <td>
            @if ($data->main_product != null)
                {{ $data->main_product }}
            @else
                -
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Year of Establishment
        </td>
        <td>:</td>
        <td>
            @if ($data->year_establish != null)
                {{ $data->year_establish }}
            @else
                -
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Export Percentage
        </td>
        <td>:</td>
        <td>
            @forelse ($annual as $ann)
                {{ $ann->nilai_persen }} %
            @empty
                -
            @endforelse
        </td>
    </tr>
    <tr valign="top">
        <td>
            Scale of Business
        </td>
        <td>:</td>
        <td>
            @if ($data->nmsize != null)
                {{ $data->nmsize }}
            @else
                -
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Email
        </td>
        <td>:</td>
        <td>
           @if (empty($data->email) || $data->email == null)
            -
            @else
            {{ $data->email }}
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            PIC
        </td>
        <td>:</td>
        <td>
           <?php
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
        ?>
        @if (empty($namapicnya) || $namapicnya == null)
        -
        @else
        {{ $namapicnya }}
        @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Telephone
        </td>
        <td>:</td>
        <td>
            <?php
            $telppicnya = '';
            $no2 = 0;
            
            $datapic2 = DB::table('itdp_contact_eks')
                ->where('id_itdp_profil_eks', $data->id)
                ->get();
            if (count($datapic2) > 0) {
                foreach ($datapic2 as $telppic) {
                    if ($no2 == 0) {
                        $telppicnya .= $telppic->phone;
                    }else {
                        $telppicnya .= ', ' . $telppic->phone;
                    }
                    $no2++;
                }
            }
            ?>
            @if (empty($telppicnya) || $telppicnya == null)
            -
            @else
            {{ $telppicnya }}
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Verify Date
        </td>
        <td>:</td>
        <td>
            @if (empty($data->verified_at) || $data->verified_at == null)
            -
            @else
            {{ date('d F Y', strtotime($data->verified_at)) }}
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Kategori Produk
        </td>
        <td>:</td>
        <td>
           @php
        $catnya = '';
        $no3 = 0;
        $categoryutama1 = DB::table('csc_product')
        ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product')
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
        </td>
    </tr>
</table>
<!--Company Profile-->


<!--Trade Capacity-->
<h4 class="judul"><b>Trade Capacity</b></h4>
<table border="0">
    <tr valign="top">
        <td style="width:222px">
            International Commercial Terms
        </td>
        <td style="width:10px">:</td>
        <td>
            @if ($data->incoterm != null)
                {{ $data->incoterm }}
            @else
                -
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Terms of Payment
        </td>
        <td>:</td>
        <td>
            @if ($data->payment != null)
                {{ $data->payment }}
            @else
                -
            @endif
        </td>
    </tr>
    <tr valign="top">
        <td>
            Export Year
        </td>
        <td>:</td>
        <td>
            @forelse ($annual as $ann)

                {{ $ann->tahun }}
            @empty
                -
            @endforelse
        </td>
    </tr>
    <tr valign="top">
        <td>
            Export Percentage
        </td>
        <td>:</td>
        <td>
            @forelse ($annual as $ann)
                {{ $ann->nilai_persen }} %
            @empty
                -
            @endforelse
        </td>
    </tr>
    <tr valign="top">
        <td>
            Total Annual Revenue
        </td>
        <td>:</td>
        <td>
            @forelse ($annuals as $anns)
                {{ number_format($anns->suma, 0, '.', '.') }}
            @empty
                -
            @endforelse
        </td>
    </tr>
    <tr valign="top">
        <td>
            Export Market
        </td>
        <td>:</td>
        <td>
            @forelse ($market as $ma)
                {{ $ma->country }}
            @empty
                -
            @endforelse
        </td>
    </tr>
    <tr valign="top">
        <td>
            Export Port
        </td>
        <td>:</td>
        <td>
            @forelse ($port as $po)
                {{ $po->name_port }}
            @empty
                -
            @endforelse
        </td>
    </tr>
</table>
<!--Trade Capacity End-->


<!--Production Capacity-->
<h4 class="judul"><b>Production Capacity</b></h4>
{{-- @forelse($capacity as $cap) --}}
{{-- <div class="card-body"> --}}
<table border="0">
    <tr valign="top">
        <td style="width:222px">
            Factory Address
        </td>
        <td style="width:10px">:</td>
        <td>
            @if ($data->addres != null)
                {{ $data->addres }}
            @else
                -
            @endif
        </td>
    </tr>

    <tr valign="top">
        <td>
            Total Manpower
        </td>
        <td>:</td>
        <td>

            @if ($data->employe != null)
                {{ $data->employe }}
            @else
                -
            @endif
        </td>
    </tr>

    <tr valign="top">
        <td>
            Production Capacity
        </td>
        <td>:</td>
        <td>
            @forelse ($capacity as $ca)
                Own Production : <b>{{ number_format($ca->sendiri_persen, 2, ',', ',') }} %</b>,
                Outside Production: <b>{{ number_format($ca->outsourcing_persen, 2, ',', ',') }} %</b>
            @empty
                -
            @endforelse
        </td>
    </tr>

</table>
{{-- </div> --}}
{{-- @empty
    <p><center>No Data Available</center></p>
    @endforelse --}}
<!--Production Capacity End-->


<!--Exhibition Participation-->
<h4 class="judul" style="margin-bottom: 10px;"><b>Exhibition Participation</b></h4>
<table style="margin-bottom:35px" class="table table-bordered table-light black">
    <thead class="thead-light">
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
    <tbody>
        @foreach ($exhib as $e => $val)
            <tr>
                <td>
                    {{ $e + 1 }}
                </td>
                <td>
                    {{ $val->event_name_en }}
                </td>
                {{-- <td>
                {{$val->country}}
            </td> --}}
                <td>
                    {{ $val->tahun }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!--Exhibition Participation End-->


<!--Certificate-->
<h4 class="judul cards" style="margin-bottom: 20px;"><b>Certificate</b></h4>
@forelse ($certificate as $certif)
    <div class="col-sm-4">
        <div class="row justify-content-center">
            <div class="kontennya">
                <div class="kotak">
                    <img style="cursor:pointer"
                        src="{{ asset('uploads/Certificate/' . $certif->id_itdp_profil_eks . '/' . $certif->image) }}"
                        style="border-radius:7px">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <a>{{ $certif->name }}</a>
        </div>
    </div>
@empty
    <a>
        <center>No Data Available</center>
    </a>
@endforelse
<!--Certificate End-->


<!--Brands-->
<h4 class="judul" style="margin-bottom: 10px;"><b>Brands</b></h4>
<table style="margin-bottom:35px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>
                Brand
            </th>
            <th>
                <center>Year</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($brand as $br => $val)
            <tr>
                <td>
                    {{ $br + 1 }}
                </td>
                <td>
                    {{ $val->merek }}
                </td>
                <td>
                    {{ $val->tahun_merek }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!--Brands End-->


<!--Country Patent Brand-->
<h4 class="judul cards" style="margin-bottom: 10px;"><b>Brand Patent Country</b></h4>
<table style="margin-bottom:15px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
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
    <tbody>
        @foreach ($country as $c => $val)
            <tr>
                <td>
                    {{ $c + 1 }}
                </td>
                <td>
                    {{ $val->merek }}
                </td>
                <td>
                    {{ $val->country }}
                </td>
                <td>
                    {{ $val->tahun }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!--Country Patent Brand End-->
