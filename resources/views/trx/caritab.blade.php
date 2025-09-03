<?php $no = 1; foreach($data as $value) { ?>
<tr>
	<td><?php echo $no; ?></td>
	<td style="text-align: left !important;"><?php if($value->origin == 1){ echo "Inquiry"; }else { echo "Buying Request"; } ?></td>
	<td style="text-align: left !important;"><?php if($value->by_role == 1){ echo "Admin"; }else if($value->by_role == 4){ echo "Perwakilan"; }else{ 
									$usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$value->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo "Importir - ".$imp->badanusaha." ".$imp->company; 
									}
									} ?></td>
	<td style="text-align: left !important;"><?php 
									$carieks = DB::select("select * from itdp_company_users where id='".$value->id_eksportir."'");
									foreach($carieks as $eks){ echo $eks->username; }
									?></td>
	<td><?php echo $value->type_tracking; ?></td>
	<td><?php echo $value->no_tracking; ?></td>
	<td><?php if($value->status_transaksi == 1){ echo "<span class='badge bg-success' style='color: #fff;'>Already Sent</span>"; }else { echo "<span class='badge bg-danger' style='color: #fff;'>On Process</span>"; }  ?></td>
</tr>

<?php $no++; } ?>