<style>
    .table-light {
        background-color: #fff !important;
    }

    .table-active {
        background-color: #f8f8f8 !important;
    }

    /* .table th, .table td {
        padding: 1rem;
    } */

    .table-bordered td,
    .table-bordered th {
        border: 0.1px solid #dee2e6 !important;
    }

    .table {
        width: 100%;
    }

    .table td,
    .table th {
        padding: 0.75rem;
        vertical-align: top;
        border: 1px solid #dee2e6;
    }
</style>
<center>
    <h2><b>DETAIL @foreach ($data as $datanya)
            {{$company = $datanya->company }}
            @endforeach</b>
        <h2>
</center>
<hr>

<!--Product-->
<h4><b>Product</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Code</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            {{ $pro->code_en }}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Product Name</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            {{ $pro->prodname_en }}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Color</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            {{ $pro->color_en }}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Size</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            {{ $pro->size_en }}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Raw Material</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            {{ $pro->raw_material_en }}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Capacity</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            {{ $pro->capacity }}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Price (USD)</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            {{ $pro->price_usd }}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Description
            Product</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            {{ $pro->product_description }}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Status</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            <?php if($pro->status == 1){ ?>
            <?php if($pro->show == 1){ ?>
            <a class="btn btn-sm btn-success" style="cursor:default; color:white">Publish - Not Verified</a>
            <?php } else { ?>
            <a class="btn btn-sm btn-success" style="cursor:default; color:white">Unpublish - Not Verified</a>
            <?php } ?>
            <?php } else if($pro->status == 2) { ?>
            <?php if($pro->show == 1){ ?>
            <a class="btn btn-sm btn-danger" style="cursor:default; color:white">Publish - Verified</a>
            <?php } else { ?>
            <a class="btn btn-sm btn-danger" style="cursor:default; color:white">Unpublish - Verified</a>
            <?php } ?>
            <?php } else if($pro->status == 3) { ?>
            <?php if($pro->show == 1){ ?>
            <a class="btn btn-sm btn-danger" style="cursor:default; color:white">Publish - Verified Rejected</a>
            <?php } else { ?>
            <a class="btn btn-sm btn-danger" style="cursor:default; color:white">Unpublish - Verified Rejected</a>
            <?php } ?>
            <?php } else { ?>
            <a class="btn btn-sm btn-danger" style="cursor:default; color:white">Deleted</a>
            <?php } ?>
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Information</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($product as $pro)
            {{ $pro->information }}
            @endforeach
        </td>
    </tr>
</table>


<!--Annual Sales-->
<h4><b>Annual Sales</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">

    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Company</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($annual as $co)
            {{ $co->company }}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Address</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($annual as $co)
            {{ $co->addres }}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Province</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($annual as $co)
            {{ $co->province_en }}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Email</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($annual as $co)
            {{ $co->email }}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">PIC Name</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($annual as $co)
            <?php 
                                    $namapicnya = '';
                                    $no = 0;
                                    $datapic = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks' , $co->id)->get();
                                    if(count($datapic) > 0  ){
                                        foreach($datapic as $namapic){
                                            if($no == 0){
                                                $namapicnya .=  $namapic->name;
                                                }else{
                                                $namapicnya .= ', ' . $namapic->name;
                                            }
                                            $no++;
                                        }
                                    }
                                    ?>
            {{$namapicnya}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">PIC Telephone
        </td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($annual as $co)
            <?php 
                                    $telppicnya = '';
                                    $no2 = 0;

                                    $datapic2 = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks' , $co->id)->get();
                                    if(count($datapic2) > 0  ){
                                        foreach($datapic2 as $telppic){
                                            if($no2 == 0){
                                                $telppicnya .=  $telppic->phone;
                                            }else{
                                                $telppicnya .= ', ' . $telppic->phone;
                                            }
                                            $no2++;
                                        }
                                    }
                                    ?>
            {{$telppicnya}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Verify Date</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($annual as $co)
            {{ $co->verified_at }}
            @endforeach
        </td>
    </tr>
</table>


<!--Brand-->
<h4><b>Brand</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Brand</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($brand as $br)
            {{ $br->merek}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Meaning of brand
        </td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($brand as $br)
            {{ $br->arti_merek}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Month</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($brand as $br)
            {{ $br->bulan_merek}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Year</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($brand as $br)
            {{ $br->tahun_merek}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Copyright Number
        </td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($brand as $br)
            {{ $br->paten_merek}}
            @endforeach
        </td>
    </tr>
</table>

<!--Country Patent Brand-->
<h4><b>Country Patent Brand</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Brand</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($country as $coun)
            {{ $coun->merek}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Country</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($country as $coun)
            {{ $coun->country}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Month</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($country as $coun)
            {{ $coun->bulan}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Year</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($country as $coun)
            {{ $coun->tahun}}
            @endforeach
        </td>
    </tr>
</table>

<!--Production Capacity-->
<h4><b>Production Capacity</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Year</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($procap as $ca)
            {{ $ca->tahun}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Outside
            Production (%)</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($procap as $ca)
            {{ $ca->sendiri_persen}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Outside
            Production (%)</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($procap as $ca)
            {{ $ca->outsourcing_persen}}
            @endforeach
        </td>
    </tr>
</table>

<!--Export Destination-->
<h4><b>Export Destination</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Year</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($exdes as $ex)
            {{ $ex->tahun}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Country</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($exdes as $ex)
            {{ $ex->country}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Ratio Export</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($exdes as $ex)
            {{ $ex->rasio_persen}}
            @endforeach
        </td>
    </tr>
</table>

<!--Port of Loading-->
<h4><b>Port Of Loading</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Port</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($portland as $port)
            {{ $port->name_port}}
            @endforeach
        </td>
    </tr>
</table>

<!--Exhibition-->
<h4><b>Exhibition</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Exhibition</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($exhib as $ex)
            {{ $ex->id_itdp_eks_event_profil}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Booth Area</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($exhib as $ex)
            {{ $ex->luas_boot}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Value Contract
        </td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($exhib as $ex)
            {{ $ex->nilai_kontrak}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Subsidi DJPEN
        </td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($exhib as $ex)
            <?php if($ex->subsidi == 'N'){ ?>
            <a class="btn btn-sm btn-success" style="cursor:default; color:white">Tidak Aktif</a>
            <?php } else { ?>
            <a class="btn btn-sm btn-danger" style="cursor:default; color:white">Aktif</a>
            <?php } ?>


            @endforeach
        </td>
    </tr>
</table>

<!--Capacity Utilization-->
<h4><b>Capacity Utilization</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Year</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($capacity as $ca)
            {{ $ca->tahun}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Used Capacity
        </td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($capacity as $ca)
            {{ $ca->kapasitas_terpakai_persen}}
            @endforeach
        </td>
    </tr>
</table>

<!--Raw Material-->
<h4><b>Raw Material</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Year</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($raw as $ra)
            {{ $ra->tahun}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">From Domestic
        </td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($raw as $ra)
            {{ $ra->lokal_persen}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Overseas</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($raw as $ra)
            {{ $ra->impor_persen}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Value From
            Dosmetic</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($raw as $ra)
            {{ $ra->nilai_impor}}
            @endforeach
        </td>
    </tr>

</table>

<!--Labor-->
<h4><b>Labor</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Year</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($labor as $la)
            {{ $la->tahun}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Local Employee
        </td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($labor as $la)
            {{ $la->lokal_orang}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Foreign Worker
        </td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($labor as $la)
            {{ $la->asing_orang}}
            @endforeach
        </td>
    </tr>
</table>

<!--Consultant-->
<h4><b>Consultant</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Name</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($consultan as $co)
            {{ $co->nama_pegawai}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Position</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($consultan as $co)
            {{ $co->jabatan}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Phone</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($consultan as $co)
            {{ $co->telepon}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Problem</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($consultan as $co)
            {{ $co->masalah}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Solution</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($consultan as $co)
            {{ $co->solusi}}
            @endforeach
        </td>
    </tr>
</table>

<!--Training-->
<h4><b>Training</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Training</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($training as $tr)
            {{ $tr->nama_training}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Organizer</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($training as $tr)
            {{ $tr->penyelenggara}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Start Date</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($training as $tr)
            {{ $tr->tanggal_mulai}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Due Date</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($training as $tr)
            {{ $tr->tanggal_selesai}}
            @endforeach
        </td>
    </tr>
</table>

<!--Tax-->
<h4><b>Tax</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Year</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($tax as $ta)
            {{ $ta->tahun}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Report PPH</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($tax as $ta)
            {{ $tax->laporan_pph}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Report PPN</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($tax as $ta)
            {{ $ta->laporan_ppn}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Report Pasal 21
        </td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($tax as $ta)
            {{ $ta->laporan_psl21}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Total PPH</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($tax as $ta)
            {{ $ta->setor_pph}}
            @endforeach
        </td>
    </tr>

</table>

<!--Contact-->
<h4><b>Contact</b></h4>
<table style="margin-bottom:25px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Name</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($contact as $co)
            {{ $co->name}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">position</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($contact as $co)
            {{ $co->job_title}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Phone</td>
        <td style="color:black !important; font-size:14px !important" width="80%">
            @foreach($contact as $co)
            {{ $co->phone}}
            @endforeach
        </td>
    </tr>
</table>

<!--Service-->
<h4><b>Service</b></h4>
<table style="margin-bottom:10px" class="table table-bordered table-light black">
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Name</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($service as $se)
            {{ $se->nama_en}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Field of Works
        </td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($service as $se)
            {{ $se->bidang_en}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Skills</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($service as $se)
            {{ $se->skill_en}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Experience(DN/LN)
        </td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($service as $se)
            {{ $se->pengalaman_en}}
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Links</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($service as $se)
            {{ $se->link}}
            @endforeach
        </td>
        <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Status</td>
        <td style="color:black !important; font-size:14px !important" width="30%">
            @foreach($service as $se)
            {{ $se->merek}}
            @endforeach
        </td>
    </tr>
</table>

</div>
</div>
</div>

{{-- <script type="text/javascript">
    window.print();
</script> --}}