<?php
 header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"pendapatanall.xls\"");
header("Cache-Control: max-age=0");
?>   
	
List Pendapatan Perusahaan Eksportir	
	<table border="1" id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th><center>No</center></th>
									<th>
                                        <center>Perusahaan Eksportir</center>
                                    </th>
									<th>
                                        <center>Alamat Perusahaan</center>
                                    </th>
                                    <th width="20%">
                                        <center>Jumlah Pendapatan</center>
                                    </th>
									
                                </tr>
                                </thead>
								<tbody>
								<?php $nt = 1; 
								$data = DB::select("select id_eksportir from csc_transaksi where status_transaksi ='1' group by id_eksportir ");
								foreach($data as $ruu){ ?>
								<tr>
									<td><center><?php echo $nt; ?></center></td>
									<td><?php 
									$carieksportir = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='".$ruu->id_eksportir."' limit 1");
									if(count($carieksportir) == 0){
										echo "";
									}else {
										foreach($carieksportir as $ce){
											echo $ce->badanusaha." ".$ce->company;
										}
									}
									?></td>
									<td><?php 
									$carieksportir = DB::select("select b.addres,b.city from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='".$ruu->id_eksportir."' limit 1");
									if(count($carieksportir) == 0){
										echo "";
									}else {
										foreach($carieksportir as $ce){
											echo $ce->addres." ,".$ce->city;
										}
									}
									?></td>
									<td style="text-align:right!important;">
									<?php 
									$caritotal = DB::select("select sum(total)as maxc from csc_transaksi where id_eksportir='".$ruu->id_eksportir."' and status_transaksi ='1'");
									if(count($caritotal) == 0){
										echo "$0";
									}else{
									foreach($caritotal as $ct){
										echo "$".number_format($ct->maxc,2,',','.');
									}
									}
									?>
									</td>
									</tr>
								
								<?php $nt++; } ?>
								
								</tbody>

                            </table>
                       
         
