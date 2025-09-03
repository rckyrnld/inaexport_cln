<?php
$loc = app()->getLocale();
if ($loc == "ch") {
    $lct = "chn";
    $by = "通过";
    $order = "最小订购量 : ";
} else if ($loc == "in") {
    $lct = "in";
    $by = "Oleh";
    $order = "Min Order : ";
} else {
    $lct = "en";
    $by = "By";
    $order = "Min Order : ";
}
?>
<style>
    /* @page { margin-top: 120px; margin-bottom: 120px}
    #footer { position: fixed; left: 0px; bottom: -200px; right: 0px; height: 150px; } */

    @page { margin-top: 120px; margin-bottom: 120px}
    footer { position: fixed; bottom: -100px; left: -40px; right: -40px;  height: 200px; }
    p { page-break-after: always}
    p:last-child { page-break-after: never; }
    .table-light {
        background-color: #f8f8f8 !important;
        border:none;
    }

    .thead-light th {
        background-color: #ebebeb !important;
    }

    .table-active {
        background-color: #ebebeb !important;
    }

    /* .table th, .table td {
        padding: 1rem;
    } */

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

    footer {
        position: fixed;
        bottom: -115px;
        height: 40px;
        /* background-color: #752727; */
        color: rgba(0, 0, 0, 0.822);
        text-align: center;
        background-color: #f3f3f3;
    }
</style>

<center>
    <h2><b>{{$data->company}},{{$data->nmbadanusaha}}</b>
        <h2>
</center>
<hr>

<table class="table table-bordered table-light table1">
    <tbody>
        <tr>
            <td width="20%" class="table-active">
                <b> @lang("frontend.event.scope") </b>
            </td>
            <td width="30%" >
                @if($loc == 'in')
                {{SOB($data->id_eks_business_size)}}
                @else
                {{SOB_EN($data->id_eks_business_size)}}
                @endif
            </td>
            <td width="20%" class="table-active">
                <b> @lang("frontend.event.type") </b>
            </td>
            <td width="30%">
                @if($loc == 'in')
                {{TOB($data->id_business_role_id)}}
                @else
                {{TOB_EN($data->id_business_role_id)}}
                @endif
            </td>
        </tr>
        <tr>
            <td width="20%" class="table-active">
                <b> No. of Employee(s) </b>
            </td>
            <td width="30%">
                {{($data->employe != null) ? $data->employe : '-'}}
            </td>
            <td width="20%" class="table-active">
                <b> Phone </b>
            </td>
            <td width="30%">
                {{($data->phone != null) ? $data->phone : '-'}}
            </td>
        </tr>
        <tr>
            <td width="20%" class="table-active">
                <b> Website </b>
            </td>
            <td width="30%">
                {{($data->website != null) ? $data->website : '-'}}
            </td>
            <td width="20%" class="table-active">
                <b> Email </b>
            </td>
            <td width="30%">
                {{($data->email != null) ? $data->email : '-'}}
            </td>
        </tr>
        <tr>
            <td width="20%" class="table-active">
                <b> Export To </b>
            </td>
            <td width="30%">
                <ul>
                    @forelse ($negara_eks as $eks)
                    <li>{{$eks->country}}</li>
                    @empty
                    <li>Not Specified</li>
                    @endforelse
                </ul>
            </td>
            <td width="20%" class="table-active">
                <b> Product(s) Sold </b>
            </td>
            <td width="30%">
                <ul>
                    @foreach ($categories as $c)
                    <li>{{$c->nama_kategori_en}}</li>
                    @endforeach
                </ul>
            </td>
        </tr>

        <tr>
            <td width="20%" class="table-active">
                <b> Addres </b>
            </td>
            <td width="30%">
                <ul>
                    {{($data->addres != null) ? $data->addres : '-'}}
                </ul>
            </td>
            <td width="20%" class="table-active">
                <b> City </b>
            </td>
            <td width="30%">
                <ul>
                    {{($data->city != null) ? $data->city : '-'}}
                </ul>
            </td>
        </tr>
    </tbody>
</table>

<!--Brand-->
<h4><b>Brand</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>
                Brand
            </th>
            <th>
                <center>Meaning Of Brand</center>
            </th>
            <th>
                <center>Month</center>
            </th>
            <th>
                <center>Year</center>
            </th>
            <th>
                <center>Copyright Number</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($brand as $br => $val)
        <tr>
            <td>
                {{$br+1}}
            </td>
            <td>
                {{$val->merek}}
            </td>
            <td>
                {{$val->arti_merek}}
            </td>
            <td>
                {{$val->bulan_merek}}
            </td>
            <td>
                {{$val->tahun_merek}}
            </td>
            <td>
                {{$val->paten_merek}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<!--Country Patent Brand-->
<h4><b>Country Patent Brand</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
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
                <center>Month</center>
            </th>
            <th>
                <center>Year</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($country as $c => $val)
        <tr>
            <td>
                {{$c+1}}
            </td>
            <td>
                {{$val->merek}}
            </td>
            <td>
                {{$val->country}}
            </td>
            <td>
                {{$val->bulan}}
            </td>
            <td>
                {{$val->tahun}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!--Production Capacity-->
<h4><b>Production Capacity</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>
                <center>No</center>
            </th>
            <th>
                <center>
                    Year
                </center>
            </th>
            <th>
                <center>Own Production (%)</center>
            </th>
            <th>
                <center>Outside Production (%)</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($procap as $pc => $val)
        <tr>
            <td>
                {{$pc+1}}
            </td>
            <td>
                {{$val->tahun}}
            </td>
            <td>
                {{$val->sendiri_persen}}
            </td>
            <td>
                {{$val->outsourcing_persen}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!--Capacity Utilization-->
<h4><b>Capacity Utilization</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>
                <center>Year</center>
            </th>
            <th>
                <center>Used Capacity</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($capacity as $ca => $val)
        <tr>
            <td>
                {{$ca+1}}
            </td>
            <td>
                {{$val->tahun}}
            </td>
            <td>
                {{$val->kapasitas_terpakai_persen}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!--Raw Material-->
<h4><b>Raw Material</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>
                <center>Year</center>
            </th>
            <th>
                <center>From Domestic</center>
            </th>
            <th>
                <center>Overseas</center>
            </th>
            <th>
                <center>Value From Domestic</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($raw as $a => $val)
        <tr>
            <td>
                {{$a+1}}
            </td>
            <td>
                {{$val->tahun}}
            </td>
            <td>
                {{$val->lokal_persen}}
            </td>
            <td>
                {{$val->impor_persen}}
            </td>
            <td>
                {{$val->nilai_impor}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!--Anual Sales-->
<h4><b>Anual Sales</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>
                Year
            </th>
            <th>
                <center>Value (USD)</center>
            </th>
            <th>
                <center>Percentage (%)</center>
            </th>
            <th>
                <center>Export Value (USD)</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($sales as $sa => $val)
        <tr>
            <td>
                {{$sa+1}}
            </td>
            <td>
                {{$val->tahun}}
            </td>
            <td>
                {{$val->nilai}}
            </td>
            <td>
                {{$val->nilai_persen}}
            </td>
            <td>
                {{$val->nilai_ekspor}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!--Labor-->
<h4><b>Labor</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>
                <center>Year</center>
            </th>
            <th>
                <center>Local Employe</center>
            </th>
            <th>
                <center>Foreign Worker</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($labor as $lb => $val)
        <tr>
            <td>
                {{$lb+1}}
            </td>
            <td>
                {{$val->tahun}}
            </td>
            <td>
                {{$val->lokal_orang}}
            </td>
            <td>
                {{$val->asing_orang}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!--Export Destination-->
<h4><b>Export Destination</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>
                <center>Year</center>
            </th>
            <th>
                <center>Country</center>
            </th>
            <th>
                <center>Ratio Export</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($desti as $dt => $val)
        <tr>
            <td>
                {{$dt+1}}
            </td>
            <td>
                {{$val->tahun}}
            </td>
            <td>
                {{$val->country}}
            </td>
            <td>
                {{$val->rasio_persen}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!--Port of Loading-->
<h4><b>Port Of Loading</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>
                <center>Port</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($portland as $pl => $val)
        <tr>
            <td>
                {{$pl+1}}
            </td>
            <td>
                {{$val->name_port}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!--Exhibition-->
<h4><b>Exhibition</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>
                <center>No</center>
            </th>
            <th>
                <center> Exhibition</center>
            </th>
            <th>
                <center>Booth Area</center>
            </th>
            <th>
                <center>Value Contract</center>
            </th>
            <th>
                <center>Subsidy DGNED</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($exhib as $x => $val)
        <tr>
            <td>
                {{$x+1}}
            </td>
            <td>
                {{$val->id_itdp_eks_event_profil}}
            </td>
            <td>
                {{$val->luas_boot}}
            </td>
            <td>
                {{$val->nilai_kontrak}}
            </td>
            <td>
                {{$val->status}}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">
                <center>No data available in table</center>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
<!--Training-->
<h4><b>Training</b></h4>
<table style="margin-bottom:25px" class="thead-light table table-bordered table-light black">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>
                <center>Training</center>
            </th>
            <th>
                <center>Organizer</center>
            </th>
            <th>
                <center>Start Date</center>
            </th>
            <th>
                <center>Due Date</center>
            </th>

        </tr>
    </thead>
    <tbody>
        @forelse($training as $T => $val)
        <tr>
            <td>
                {{$T+1}}
            </td>
            <td>
                {{$val->nama_training}}
            </td>
            <td>
                {{$val->penyelenggara}}
            </td>
            <td>
                {{$val->tanggal_mulai}}
            </td>
            <td>
                {{$val->tanggal_selesai}}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">
                <center>No data available in table</center>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<footer>
    <p>inaexport</p>
</footer>




{{-- <script type="text/javascript">
    window.print();
</script> --}}