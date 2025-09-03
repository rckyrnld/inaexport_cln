<?php // echo bcrypt('abc');die(); ?>
@include('frontend.layouts.header')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <div class="table-responsive">
						

<style>
body {font-family: "Times New Roman";Font-size:1rem;}

input{
	font-family: "Times New Roman";
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
  /*display: none;*/
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}

.img_upl {
    /*border: 1px solid #6fccdd;*/
    border: none;
    background: transparent;
}
</style>


<div class="container" style="font-family: 'Times New Roman'">
	<br>
	<div style="text-align: center;">
		<span><h3><b>Company Profile </b></h3></span>
	</div>
	<br>
	<input type="hidden" name="id_role" value="<?php echo $ida; ?>">
	<input type="hidden" name="id_user" value="<?php echo $idb; ?>">

	<div id="Paris" class="container" style="padding: 20px; justify-content: center">
		<?php
		if($ida == 2){
			//echo "jual";
			$ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$idb' limit 1");
		}else{
			$ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$idb' limit 1");
		}
		foreach($ceq as $ryu){
		$img1 = "front/assets/icon/profile2.png";
		if($ryu->foto_profil != NULL){
			$imge1 = 'uploads/Profile/Eksportir/'.$ryu->id_user.'/'.$ryu->foto_profil;
			if(file_exists($imge1)) {
				$img1 = 'uploads/Profile/Eksportir/'.$ryu->id_user.'/'.$ryu->foto_profil;
			}
		}
		?>
		<input type="hidden" name="idu" value="<?php echo $ryu->id; ?>">

		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-6">
				<div class="form-row">
					<div class="form-group col-sm-4">
						<label><b>Name of Company</b></label>
					</div>

					<div class="form-group col-sm-2">
						{{--		<select name="badanusaha" class="form-control">--}}
						{{--		<option>-</option>--}}



						<input type="text" class="form-control" id="badan_usaha" value="{{$ryu->badanusaha}}" readonly>
					</div>
					{{--		</select>--}}


					<div class="form-group col-sm-6">
						<input type="text" value="<?php echo $ryu->company; ?>" name="company" id="company" class="form-control" readonly>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-sm-4">
						<label><b>Address</b></label>
					</div>
					<div class="form-group col-sm-8">
						<textarea name="addres" id="addres" class="form-control" readonly><?php echo $ryu->addres; ?></textarea>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-sm-4">
						<label><b>City</b></label>
					</div>
					<div class="form-group col-sm-8">
						<textarea name="city" id="city" class="form-control" readonly><?php echo $ryu->city; ?></textarea>

					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-sm-4">
						<label><b>Province</b></label>
					</div>
					<div class="form-group col-sm-8">
						<select name="province" id="province" class="form-control select2" disabled style="width: 100%">
							<?php
							$qc = DB::select("select id,province_en from mst_province order by province_en asc");
							foreach($qc as $cq){
							?>
							<option <?php if($cq->id == $ryu->id_mst_province){ echo "selected"; } ?> value="<?php echo $cq->id; ?>"><?php echo $cq->province_en; ?></option>

							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-sm-4">
						<label><b>Zip Code</b></label>
					</div>
					<div class="form-group col-sm-8">
						<input type="text" value="<?php echo $ryu->postcode; ?>" name="postcode" id="postcode" class="form-control" readonly>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-sm-4">
						<label><b>Fax</b></label>
					</div>
					<div class="form-group col-sm-8">
						<input type="text" value="<?php echo $ryu->fax; ?>" name="fax" id="fax" class="form-control" readonly>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-sm-4">
						<label><b>Website</b></label>
					</div>
					<div class="form-group col-sm-8">
						<input type="text" value="<?php echo $ryu->website; ?>" name="website" id="website" class="form-control" readonly>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-sm-4">
						<label><b>Phone</b></label>
					</div>
					<div class="form-group col-sm-8">
						<input type="text" value="<?php echo $ryu->phone; ?>" name="phone" id="phone" class="form-control" readonly>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<center>
					<div id="ambil_ttd_1" style="width: 50%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
{{--						<button type="button" id="img_1" style="width: 100%;" class="img_upl">--}}
							<br><img src="{{asset($img1)}}" id="image_1_ambil" style="width: 80%;"/>
{{--						</button>--}}
{{--						<input type="file" id="image_1" name="image_1" accept="image/*" style="display: none;" />--}}
						<br><br>
						<center><span style="font-size: 17px;"><b>Profile Photo</b></span></center>
					</div>
					<br>
				</center>
			</div>
		</div>
		<?php } ?>
	</div>
</div>



<script>
</script>
  

                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


@include('frontend.layouts.footer')
