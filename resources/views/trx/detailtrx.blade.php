@include('frontend.layouts.header')


<!--slider area start-->
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
    }else if($loc == "in"){
        $lct = "in";
    }else{
        $lct = "en";
    }
?>

<style>
	.form-control{
		font-size: 13px !important;
	}
	/* .form-row .detail-card {
		border-style: solid;
		border-radius: 12px;
		border-color: #ADC2A9;
		border-width: 2px;
	} */
	.rightbtn {
		float: right;
	}
	.btn {
		border-radius: 4px;
	}
</style>
    <!--product area start-->
    <section class="product_area mb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <br>
                    </div>

                </div>
            </div>
            <div class="tab-content" id="tabing-product">
				<div class="breadcrumb_content">
					<ul>
						<li><a href="{{url('/')}}">@lang("login.forms.home")</a></li>
						<li>Detail Transaction</li>
					</ul>
                </div>
			</div>
			<div class="form-row justify-content-center" style="font-size:12px;">
			<!--<img style="width:100%!important;" src="{{url('assets')}}/assets/images/07-Form-Request_01.png" alt="." >-->
				<div class="col-9 detail-card">
					<br>
					<?php 

					$q3 = DB::select("select * from csc_transaksi where id_transaksi='".$id."'");
					foreach($q3 as $p3){
					?>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Sources</b>
						</div>
						<div class="form-group col-sm-6">
							<input class="form-control" type="text"  value="<?php if($p3->origin == 1){ echo "Inquiry"; }else{ echo "Buying Request"; } ?>" readonly>
							<input type="hidden" name="origin" value="<?php echo $p3->origin; ?>">
							<input type="hidden" name="by_role" value="<?php echo $p3->by_role; ?>">
							<input type="hidden" name="id_pembuat" value="<?php echo $p3->id_pembuat; ?>">
							<input type="hidden" name="id_eksportir" value="<?php echo $p3->id_eksportir; ?>">
						</div>
					</div>
					<?php 
					if($p3->origin == 2){
					$q2 = DB::select("select * from csc_buying_request where id='".$p3->id_terkait."'");
					foreach($q2 as $p2){
					?>
					<div class="form-row">
						<div class="col-md-6">
							<label><b>Category Product</b></label>
						</div>
						<div class="form-group col-md-6">
							<?php
								$prodcat = "";
								if($p2->id_csc_prod != null){
									$prodcat = explode(',',  $p2->id_csc_prod);
									$hitung = count($prodcat);
									$ms1 = DB::select("select id,nama_kategori_en from csc_product where id='".$prodcat[$hitung-2]."'");
								}
							foreach($ms1 as $kc1){ $rto =  $kc1->nama_kategori_en; }
							?>
							<input type="text" class="form-control" value="<?php echo $rto; ?>" readonly>
						</div>
						
					</div>
					<div class="form-row">
						<div class="col-md-6">
						<label><b>Kind of Subject</b></label>
						</div>
						<div class="form-group col-md-6">
							<input type="text" class="form-control" value="Offer to Buy" readonly>
						</div>
						
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Date</b>
						</div>
						<div class="form-group col-sm-6">
							
							<input type="text" class="form-control" value="<?php echo $p2->date; ?>" readonly>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Quantity</b>
						</div>
						<div class="form-group col-sm-4">
							<input type="number" class="form-control" value="<?php echo $p2->eo; ?>" readonly>
						</div>
						<div class="form-group col-sm-2">
							<input type="hidden" name="id1" class="form-control" value="<?php echo $id; ?>">
							<input type="text" class="form-control" value="<?php echo $p2->neo; ?>" readonly>
						</div>
					</div>
					
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Price</b>
						</div>
						<div class="form-group col-sm-4">
							<input type="number" class="form-control" value="<?php echo $p2->tp; ?>" readonly>
						</div>
						<div class="form-group col-sm-2">
							<input type="text" class="form-control" value="<?php echo $p2->ntp; ?>" readonly>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Subject</b>
						</div>
						<div class="form-group col-sm-6">
							
							<input type="text" class="form-control" value="<?php echo $p2->subyek; ?>" readonly>
						</div>
					</div>
					
					
					
					<div class="form-row rightbtn">
						
						<div class="form-group col-sm-5">
							<a  href="{{url('trx_list')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
						</div>
					</div>
				</div>
				<div class="col-1"></div>
				<div class="col-6">
					<br>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Exporter</b>
						</div>
						<div class="form-group col-sm-6">
						<?php 
						$carieks = DB::select("select b.* from itdp_company_users a, itdp_profil_eks b where a.id='".$p3->id_eksportir."'");
						foreach($carieks as $eks){
							$da1 = $eks->badanusaha." ".$eks->company;
							$da2 = $eks->addres." , ".$eks->city;
						}
						?>
							<input type="text" class="form-control" readonly value="<?php echo $da1; ?>" >
						</div>
					</div>
					
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Address Exporter</b>
						</div>
						<div class="form-group col-sm-6">
						
							<textarea class="form-control" readonly ><?php echo $da2; ?></textarea>
						</div>
					</div>
					
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Messages</b>
						</div>
						<div class="form-group col-sm-6">
							<textarea class="form-control" readonly><?php echo $p2->spec; ?></textarea>
						</div>
					</div>
					
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>File</b>
						</div>
						<div class="form-group col-sm-6">
							<a class="btn btn-warning" style="font-size: 13px;" download href="{{asset('uploads/buy_request/'.$p2->files)}}"><i class="fa fa-download"></i> Download File</a>
						</div>
					</div>
					
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Tracking of Type</b>
						</div>
						<div class="form-group col-sm-6">
							<select <?php if($p2->status_trx == 1){ echo "readonly"; }?> class="form-control" name="type_tracking" required readonly>
								<option value="">- Select Tracking Type -</option>
								<option <?php if($p3->type_tracking == "DHL Express"){ echo "selected"; }?> value="DHL Express">DHL Express</option>
								<option <?php if($p3->type_tracking == "DHL Active Tracing"){ echo "selected"; }?> value="DHL Active Tracing">DHL Active Tracing</option>
								<option <?php if($p3->type_tracking == "DHL Global Forwarding"){ echo "selected"; }?> value="DHL Global Forwarding">DHL Global Forwarding</option>
								<option <?php if($p3->type_tracking == "Fedex"){ echo "selected"; }?> value="Fedex">Fedex</option>
								<option <?php if($p3->type_tracking == "Fedex Freight"){ echo "selected"; }?> value="Fedex Freight">Fedex Freight</option>
								<option <?php if($p3->type_tracking == "FedEx Ground"){ echo "selected"; }?> value="FedEx Ground">FedEx Ground</option>
								<option <?php if($p3->type_tracking == "China EMS"){ echo "selected"; }?> value="China EMS">China EMS</option>
								<option <?php if($p3->type_tracking == "Deutsche Post DHL"){ echo "selected"; }?> value="Deutsche Post DHL">Deutsche Post DHL</option>
								<option <?php if($p3->type_tracking == "Other"){ echo "selected"; }?> value="Other">Other</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>No Tracking</b>
						</div>
						<div class="form-group col-sm-6">
							<input class="form-control" readonly type="text" id="no_track" name="no_track" value="<?php echo $p3->no_tracking; ?>" readonly>
							<input class="form-control" type="hidden" id="tipekirim" name="tipekirim" value="" required>
						</div>
					</div>
					<?php } }else{ ?>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Created By</b>
						</div>
						<div class="form-group col-sm-6">
							<?php  if($p3->by_role == 1){ $r = "Admin"; }else if($p3->by_role == 4){ $r = "Representative"; }else{ $r = "Importer"; }  ?>
							<?php if($p3->by_role == 3){
							$carih = DB::select("select a.*,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil=b.id and a.id='".$p3->id_pembuat."'");
							foreach($carih as $ch){
								$nbb = " - ".$ch->badanusaha." ".$ch->company." (".$ch->username.")";
							?>
							<input class="form-control" readonly type="text" id="" name="" value="<?php echo $r." - ".$nbb; ?>" readonly>
							<?php } } ?>
						</div>
					</div>
					<?php
					$idt = $p3->id_terkait;
					$caridt = DB::select("select * from csc_inquiry_br where id='".$idt."'");
					foreach($caridt as $cdt){
						$cd1 = $cdt->id;
						$cd2 = $cdt->id_csc_prod_cat;
						$cd3 = $cdt->id_csc_prod_cat_level1;
						$cd4 = $cdt->id_csc_prod_cat_level2;
						$cd6 = $cdt->to;
					}
					//echo $cd1."aaaa";
					?>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Category</b>
						</div>
						<div class="form-group col-sm-6">
							<!-- ditambah mindy karna sebelumnya kosong -->
						<?php 
								$caripr = DB::select("select * from  csc_product_single where id='".$cd6."'");
								foreach($caripr as $xd){
									echo  '<input readonly type="text" name="category" class="form-control" value="'.$xd->prodname_en.'">';				
								}
						?>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Quantity</b>
						</div>
						<div class="form-group col-sm-3">
							<input type="number" name="eo" class="form-control" value="<?php  if(empty($p3->eo)){ echo "1"; }else{ echo $p3->eo; } ?>" readonly>
						</div>
						<div class="form-group col-sm-3">
							<input type="hidden" name="id_in" class="form-control" value="<?php echo $p3->id_terkait; ?>">
							<select class="form-control" name="neo" id="neo" disabled>
								<option value="">- Choose -</option>
				
								<option <?php if($p3->neo == "Dozen"){ echo "selected"; }?> value="Dozen">Dozen</option>
								<option <?php if($p3->neo == "Grams"){ echo "selected"; }?>value="Grams">Grams</option>
								<option <?php if($p3->neo == "Kilograms"){ echo "selected"; }?>value="Kilograms">Kilograms</option>
								<option <?php if($p3->neo == "Liters"){ echo "selected"; }?> value="Liters">Liters</option>
								<option <?php if($p3->neo == "Meters"){ echo "selected"; }?> value="Meters">Meters</option>
								<option <?php if($p3->neo == "Packs"){ echo "selected"; }?>value="Packs">Packs</option>
								<option <?php if($p3->neo == "Pairs"){ echo "selected"; }?> value="Pairs">Pairs</option>
								<option <?php if($p3->neo == "Pieces"){ echo "selected"; }?> value="Pieces">Pieces</option>
								<option <?php if($p3->neo == "Sets"){ echo "selected"; }?> value="Sets">Sets</option>
								<option <?php if($p3->neo == "Reams"){ echo "selected"; }?> value="Reams">Reams</option>
								<option <?php if($p3->neo == "Tons"){ echo "selected"; }?> value="Tons">Tons</option>
								<option <?php if($p3->neo == "Unit"){ echo "selected"; }?> value="Unit">Unit</option>
								
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Price</b>
						</div>
						<div class="form-group col-sm-3">
				
					<input readonly type="text" name="tp" class="amount form-control" value="<?php  if(empty($p3->tp) || $p3->tp == null ){ echo "0"; }else{ echo number_format($p3->tp,0,',','.'); } ?>">
						</div>
						<div class="form-group col-sm-3">
							<select disabled style="color:black;" class="form-control" name="ntp" id="ntp"><option value="IDR">IDR</option><option value="THB">THB</option><option selected value="USD">USD</option></select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Tracking of Type</b>
						</div>
						<div class="form-group col-sm-6">
							<select <?php if($p3->status_transaksi == 1){ echo "readonly"; }?> class="form-control" name="type_tracking">
								<option value="">- Select Tracking Type -</option>
								<option <?php if($p3->type_tracking == "DHL Express"){ echo "selected"; }?> value="DHL Express">DHL Express</option>
								<option <?php if($p3->type_tracking == "DHL Active Tracing"){ echo "selected"; }?> value="DHL Active Tracing">DHL Active Tracing</option>
								<option <?php if($p3->type_tracking == "DHL Global Forwarding"){ echo "selected"; }?> value="DHL Global Forwarding">DHL Global Forwarding</option>
								<option <?php if($p3->type_tracking == "Fedex"){ echo "selected"; }?> value="Fedex">Fedex</option>
								<option <?php if($p3->type_tracking == "Fedex Freight"){ echo "selected"; }?> value="Fedex Freight">Fedex Freight</option>
								<option <?php if($p3->type_tracking == "FedEx Ground"){ echo "selected"; }?> value="FedEx Ground">FedEx Ground</option>
								<option <?php if($p3->type_tracking == "China EMS"){ echo "selected"; }?> value="China EMS">China EMS</option>
								<option <?php if($p3->type_tracking == "Deutsche Post DHL"){ echo "selected"; }?> value="Deutsche Post DHL">Deutsche Post DHL</option>
								<option <?php if($p3->type_tracking == "Other"){ echo "selected"; }?> value="Other">Other</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>No Tracking</b>
						</div>
						<div class="form-group col-sm-6">
							<input class="form-control" type="text" id="no_track" name="no_track" value="<?php echo $p3->no_tracking; ?>" <?php if($p3->status_transaksi == 1){ echo "readonly"; }?>>
							<input class="form-control" type="hidden" id="tipekirim" name="tipekirim" value="0">
							<input class="form-control" type="hidden" id="id_transaksi" name="id_transaksi" value="<?php echo $p3->id_transaksi;?>">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<b>Link Tracking</b>
						</div>
						<div class="form-group col-sm-6">
							<input class="form-control" type="text" id="link_tracking" name="link_tracking" value="<?php echo $p3->link_tracking; ?>" <?php if($p3->status_transaksi == 1){ echo "readonly"; }?>>
						</div>
					</div>
					<div class="form-row rightbtn">
						
						<div class="form-group col-sm-5">
							<a  href="{{url('trx_list')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
						</div>
					</div>
  
					<?php } }?>
				</div>
			</div>
		</div>
	</section>

@include('frontend.layouts.footer')
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable();
	
	$('#tablebureq').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.br3') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'col1', name: 'col1'},
                {data: 'col2', name: 'col2'},
                {data: 'col3', name: 'col3'},
                {data: 'col4', name: 'col4'},
                {data: 'col5', name: 'col5'},
                {data: 'col6', name: 'col6'}
                
            ],
            fixedColumns: true
        });
} );
</script>
<script>
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad/")}}/'+a,{_token:token},function(data){
			$("#isibroadcast").html(data);
			
		 })
}
function t1(){
	$('#t2').html('');
	$('#t3').html('');
	var t1 = $('#category').val();
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilt2/")}}/'+t1,{_token:token},function(data){
			$("#t2").html(data);
			$("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
			 $('.select2').select2();
			
		 })
}
function t2(){
	$('#t3').html('');
	var t2 = $('#t2s').val();
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilt3/")}}/'+t2,{_token:token},function(data){
			$("#t3").html(data);
			 $('.select2').select2();
			
		 })
}
function nv(){
	var a = $('#staim').val();
	if(a == 2){
		$('#sh1').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id;?>"><?php echo $qr->nama_template;?></option><?php } ?></select></div></div>')
	}else{
		$('#sh1').html(' ');
		$('#sh2').html(' ');
	}
}
function ketv(){
	var a = $('#template_reject').val();
	if(a == 1){
		$('#sh2').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>')
	}
}
$(document).ready(function () {
        $('.select2').select2();
});
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
        $('#'+tabname).addClass('active');
    }
</script>