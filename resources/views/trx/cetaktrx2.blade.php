<?php
 header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"reporttrx.xls\"");
header("Cache-Control: max-age=0");
?>   
	
 <h5><i></i>List Transaski  </h5>
									
									   <table id="example2s" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
									
									<th>
                                        <center>Origin</center>
                                    </th>
									<th>
                                        <center>Buyer</center>
                                    </th>
									<th>
                                        <center>Eksportir</center>
                                    </th>
									
									 <th>
                                        <center>Type Tracking</center>
                                    </th>
									<th>
                                        <center>No Tracking</center>
                                    </th>
									<th>
                                        <center>Status</center>
                                    </th>
									
                                </tr>
                                </thead>
								<tbody id="ambillist">
								<?php $no = 1; foreach($data as $value) { ?>
<tr>
	<td><?php echo $no; ?></td>
	<td><?php if($value->origin == 1){ echo "Inquiry"; }else { echo "Buying Request"; } ?></td>
	<td><?php if($value->by_role == 1){ echo "Admin"; }else if($value->by_role == 4){ echo "Perwakilan"; }else{ 
									$usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$value->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo "Importir - ".$imp->badanusaha." ".$imp->company; 
									}
									} ?></td>
	<td><?php 
									$carieks = DB::select("select * from itdp_company_users where id='".$value->id_eksportir."'");
									foreach($carieks as $eks){ echo $eks->username; }
									?></td>
	<td><?php echo $value->type_tracking; ?></td>
	<td><?php echo $value->no_tracking; ?></td>
	<td><?php if($value->status_transaksi == 1){ echo "<span class='badge bg-success' style='color: #fff;'>Already Sent</span>"; }else { echo "<span class='badge bg-danger' style='color: #fff;'>On Process</span>"; }  ?></td>
</tr>

<?php $no++; } ?>
								</tbody>
								</table>

                       
         
