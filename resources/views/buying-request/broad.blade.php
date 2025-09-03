
<div class="modal-body">
<?php 
								$pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
								foreach($pesan as $ryu){
									?>
<div class="form-row">
		<div class="col-sm-3">
		<label><b>@lang("login.forms.by2")</b></label>
		</div>
		<div class="form-group col-sm-6">
			<input type="text" readonly style="color:black;" value="<?php echo strtoupper($ryu->subyek); ?>" name="cmp" id="cmp" class="form-control" >
		</div>
		
	</div>
<div class="form-row">
		<div class="col-sm-3">
		<label><b>@lang("login.forms.by3")</b></label>
		</div>
		<div class="form-group col-sm-6">
			<?php 
			
$cr = explode(',',$ryu->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				echo $semuacat;
									
			?>
			
			
		</div>
		
	</div>
	
								<?php } ?>
        </div>
        <div class="modal-footer" style="background-color:#2e899e; color:white;">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><font color="white">Close</font></button>
          <a style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" href="{{ url('br_importir_bc/'.$id) }}" class="btn btn-warning"><font color="white">Send</font></a>
        </div>