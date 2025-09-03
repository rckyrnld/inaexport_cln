<style>
    .table-light {
        background-color: #fff !important;
    }
    .table-active{
        background-color:  #f7f7f7 !important;
    }
    .table-bordered td, .table-bordered th {
        border: 1px solid #dee2e6 !important;
    }
</style>

@extends('header2')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    <?php
					$qe = DB::select("select * from itdp_admin_users where id='".$id."'");
					foreach($qe as $eq){
					if($eq->type == "DINAS PERDAGANGAN"){
						$tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and a.id='".$id."' ");
					}else{
						$tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_ln b where a.id_admin_ln = b.id and a.id='".$id."' ");
					}
					foreach($tq as $qt){
                    $mst = DB::select("select * from mst_province where id='".$qt->id_country."'");
                    $benua = DB::select("select * from mst_group_country where id='".$qt->id_country."'");
					?>

                    <div class="sidebar_widget">
                        <div class="widget_inner">
                            <div class="widget_list widget_categories mt-2 mb-2">
                                <center><h2><b>{{ $qt->username }}</b><h2></center>
                                       <center> <h4>{{ $eq->type }}<h4></center>
                                        <hr>
                                        <table style="margin-top:-10px" class="table table-bordered table-light black">
                                            <?php if($eq->type=="DINAS PERDAGANGAN"){ ?>
                                                
                                            <?php } else { ?>
                                                <tr>
                                                    <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Benua</td>
                                                    <td style="color:black !important; font-size:14px !important" width="30%">
                                                        @foreach($benua as $be)
                                                        {{$be->group_country}}
                                                        @endforeach
                                                    </td>
                                                    <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">City</td>
                                                    <td style="color:black !important; font-size:14px !important" width="30%">
                                                        <?php if ($qt->city == null){ ?>
                                                            -
                                                        <?php } else { 
                                                            $city = DB::select("select * from mst_city where id='".$qt->city."'");
                                                        ?>
                                                            @foreach($city as $ci)
                                                            {{$ci->city}}
                                                            @endforeach

                                                        <?php }?>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                            <tr>
                                                <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Scope</td>
                                                <td style="color:black !important; font-size:14px !important" width="30%">
                                                    <?php if($eq->type=="DINAS PERDAGANGAN"){ ?>
                                                        Domestic
                                                    <?php } else { ?>
                                                        Overseas
                                                    <?php } ?>
                                                </td>
                                                <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">
                                                    <?php if($eq->type=="DINAS PERDAGANGAN"){ ?>
                                                        Province
                                                    <?php } else { ?>
                                                        Main Country
                                                    <?php } ?>  
                                                </td>

                                                <td style="color:black !important; font-size:14px !important" width="30%">
                                                    <?php if($eq->type=="DINAS PERDAGANGAN"){ ?>
                                                        @foreach($mst as $pro)
                                                            {{ $pro->province_en }}
                                                        @endforeach
                                                    <?php } else { ?>
                                                        <?php
                                                            $country_pecah = explode(',', $qt->country);
                                                            foreach ($country_pecah as $key => $cp) {
                                                            $pecah = DB::select("select id,mst_country_group_id,country from mst_country where id='".$cp."'");
                                                        ?>
                                                            @foreach($pecah as $cu)
                                                                <a class="btn btn-sm btn-light" style="cursor:default">{{ $cu->country }}</a>
                                                            @endforeach
                                                        <?php  } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Nama</td>
                                                <td style="color:black !important; font-size:14px !important" width="30%">{{ $qt->nama }}</td>
                                                <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Jabatan</td>
                                                <td style="color:black !important; font-size:14px !important" width="30%">{{ $qt->kepala }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Email</td>
                                                <td style="color:black !important; font-size:14px !important" width="30%">{{ $eq->email }}</td>
                                                <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Telepon</td>
                                                <td style="color:black !important; font-size:14px !important" width="30%">{{ $qt->telp }}</td>
                                            </tr>
                                                <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Website</td>
                                                <td style="color:black !important; font-size:14px !important" width="30%">{{ $qt->website }}</td>
                                                <td style="color:black !important; font-size:14px !important" width="20%" class="table-active">Status</td>
                                                <td style="color:black !important; font-size:14px !important" width="30%">
                                                    <?php if($qt->status==1){ ?>
                                                        <a class="btn btn-sm btn-success" style="cursor:default; color:white">Aktif</a>
                                                    <?php } else { ?>
                                                        <a class="btn btn-sm btn-danger" style="cursor:default; color:white">Tidak Aktif</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </table>
                    
                        <div align="right">
                            <a class="btn btn-danger mt-3" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
                        </div>

                    <?php } } ?>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
@endsection