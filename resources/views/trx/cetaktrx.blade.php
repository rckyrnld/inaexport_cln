<?php
 header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"br.xls\"");
header("Cache-Control: max-age=0");
?>   
	
 <h5><i></i>List Buying Request <?php echo $pembuat; ?> </h5>
									
									    <table border="1" id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
									<th>
                                        <center>Duration</center>
                                    </th>
                                    <th>
                                        <center>Created By</center>
                                    </th>
									<th>
                                        <center>Address</center>
                                    </th>
                                    
                                   
									<th>
                                        <center>Subyek</center>
                                    </th>
									<th>
                                        <center>Category</center>
                                    </th>
									
									
                                </tr>
                                </thead>
								<tbody>
								<?php $nt = 1; foreach($data as $ruu){ ?>
								<tr>
									<td><?php echo $nt; ?></td>
									<td><center>
									<?php 
									
									if($ruu->valid == 0){ echo "Selesai"; }else{ ?>
									Valid for <?php echo $ruu->valid; ?> days
									<?php } ?>
									</center></td>
									<td>
									<?php 
								if($ruu->by_role == 1){
									echo "Admin";
								}else if($ruu->by_role == 4){
									echo "Perwakilan";
								}else if($ruu->by_role == 3){
									$usre = DB::select("select b.company from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$ruu->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo $imp->company; 
									}
								}
									?></td>
									<td><?php 
									if($ruu->by_role == 1){
									$co = $ruu->id_mst_country;
				$naco ="";
				$caric = DB::select("select * from mst_country where id='".$co."'");
				foreach($caric as $cc){ $naco = $cc->country; }
				echo $naco." ,".$ruu->city;
								}else if($ruu->by_role == 4){
									$co = $ruu->id_mst_country;
				$naco ="";
				$caric = DB::select("select * from mst_country where id='".$co."'");
				foreach($caric as $cc){ $naco = $cc->country; }
				echo $naco." ,".$ruu->city;
								}else if($ruu->by_role == 3){
									$usre = DB::select("select b.company,b.addres,b.city from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$ruu->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo  $imp->addres." , ".$imp->city; 
									}
								}
									?></td>
									<td><center><?php echo $ruu->subyek; ?></center></td>
									
									
									<td>
									<?php
$cr = explode(',',$ruu->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				echo $semuacat;
									/*
									$ms1 = DB::select("select id,nama_kategori_en from csc_product where id='".$ruu->id_csc_prod_cat."'");
									foreach($ms1 as $c1){ 
									echo $c1->nama_kategori_en; 
									}
									*/
									?>
									</td>
									
									
								</tr>
								<?php $nt++; } ?>
								
								</tbody>

                            </table>
                       

                       
         
