@extends('header2')
@section('content')
    @php
    use Carbon\Carbon;
    @endphp
    <style>
        body {
            font-family: Arial;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 8px 10px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Buying Request Exporter</h3>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="example1" class="table table-striped table-hover">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Produk</center>
                                    </th>
                                    {{-- <th>
								<center>Creator Status</center>
							</th> --}}
                                    <th>
                                        <center>Negara Buyer</center>
                                    </th>
                                    <th>
                                        <center>Buyer</center>
                                    </th>
                                    {{-- <th>
								<center>Category</center>
							</th> --}}
                                    <th>
                                        <center>Durasi</center>
                                    </th>
                                    {{-- <th>
								<center>Expired at</center>
							</th> --}}
                                    <th>
                                        <center>Status</center>
                                    </th>
                                    <th width="18%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nt = 1; foreach($data as $ruu){ ?>
                                <tr>
                                    <td><?php echo $nt; ?></td>
                                    {{-- <td> --}}
                                    <?php
                                    // if($ruu->by_role == 1|| $ruu->by_role == 4){
                                    // 	echo "-";
                                    // }else if($ruu->by_role == 3){
                                    // 	$userstatus = DB::select("select a.status from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$ruu->id_pembuat."'");
                                    // 	foreach($userstatus as $imp){
                                    // 		if($imp->status == 1){
                                    // 			echo "Verified";
                                    // 		}else{
                                    // 			echo "Not Verified";
                                    // 		}
                                    
                                    // 	}
                                    // }
                                    ?>
                                    {{-- </td> --}}
                                    <td><?php echo $ruu->subyek; ?></td>
                                    <td>
                                        @php
                                            $country = DB::table('mst_country')->select('country')->where('id', $ruu->id_mst_country)->first();
                                            echo (isset($country)) ? $country->country : '-';
                                        @endphp
                                    </td>
                                    <td>
                                        <?php
                                        if ($ruu->by_role == 1) {
                                            echo 'Admin';
                                        } elseif ($ruu->by_role == 4) {
                                            $usre = DB::select("select name from itdp_admin_users where id='" . $ruu->id_pembuat . "'");
                                            foreach ($usre as $imp) {
                                                echo $imp->name;
                                            }
                                        } elseif ($ruu->by_role == 3) {
                                            $usre = DB::select("select b.company from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $ruu->id_pembuat . "'");
                                            foreach ($usre as $imp) {
                                                echo $imp->company;
                                            }
                                        }
                                        ?></td>
                                    {{-- <td> --}}
                                    <?php
                                    // $cr = explode(',',$ruu->id_csc_prod);
                                    // $hitung = count($cr);
                                    // $semuacat = "";
                                    // for($a = 0; $a < ($hitung - 1); $a++){
                                    // 	$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
                                    // 	foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
                                    // 	$semuacat = $semuacat."- ".$napro."<br>";
                                    // }
                                    // echo $semuacat;
                                    /*
                                    							$ms1 = DB::select("select id,nama_kategori_en from csc_product where id='".$ruu->id_csc_prod_cat."'");
                                    							foreach($ms1 as $c1){ 
                                    							echo $c1->nama_kategori_en; 
                                    							}
                                    							*/
                                    ?>
                                    {{-- </td> --}}
                                    <td>
                                        @php
                                            $now = Carbon::now()->startOfDay();
                                            $compare = Carbon::parse($ruu->date)
                                                ->startOfDay()
                                                ->addDays($ruu->valid);
                                            if ($compare->gt($now)) {
                                                $d = (int) $compare->diffInDays($now) . ' Day(s)';
                                            } else {
                                                $d = 'Expired';
                                            }
                                            echo $d;
                                        @endphp
                                    </td>
                                    <td>
                                        <?php if ($ruu->status_join == '1') {
                                            echo 'Menunggu verifikasi dari buyer';
                                        } elseif ($ruu->status_join == '2') {
                                            echo 'Negosiasi';
                                        } elseif ($ruu->status_join == '4') {
                                            echo 'Deal';
                                        } else {
                                            echo '-';
                                        }
                                        
                                        ?>
                                    </td>
                                    <td>
                                        <center>
                                            <?php  if($ruu->status_join == null){ ?>
                                            <a href="{{ url('br_save_join/' . $ruu->idb) }}" class="btn btn-success"
                                                title="Join">
                                                <font color="white">Join</font>
                                            </a>
                                            <?php }else if($ruu->status_join == 1){ ?>
                                            Menunggu Verifikasi
                                            <?php }else if($ruu->status_join == 2){ ?>
                                            <a href="{{ url('br_chat/' . $ruu->idb) }}" class="btn btn-info" title="Chat">
                                                <font color="white"><i class="fa fa-comment"></i></font>
                                            </a>
                                            <?php }else if($ruu->status_join == 4){ ?>
                                            <a href="{{ url('br_chat/' . $ruu->idb) }}" class="btn btn-success"
                                                title="View">
                                                <font color="white"><i class="fa fa-eye"></i></font>
                                            </a>
                                            <?php } ?>
                                        </center>
                                    </td>
                                </tr>
                                <?php $nt++; } ?>

                            </tbody>

                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>



    @include('footer')

@endsection
