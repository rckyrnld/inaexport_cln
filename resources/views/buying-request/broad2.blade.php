<style>
	#tabelpiliheksportir_wrapper {
		width: 100% !important;
	}

	.dataTables_info {
		color: #000000
	}
</style>

<div class="modal-body">
	<?php
								// $pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
								// foreach($pesan as $ryu){
								?>
	{{-- <input type="hidden" id="id_laporan" value="{{$ryu->id_csc_prod}}">
	<input type="hidden" id="id_buyingrequest" value="{{$id}}"> --}}
	<input type="hidden" id="id_laporan" value="{{$category}},{{$sub_category_1}},{{$sub_category_2}}">
	{{-- <input type="hidden" id="id_buyingrequest" value="{{$id}}"> --}}
	<div class="form-row">
		<div class="col-sm-3">
			<label style="color: black !important;"><b>What are you looking for</b></label>
		</div>
		<div class="form-group col-sm-6">
			<input type="text" readonly style="color:black;" value="<?php echo $subyek; ?>" name="cmp" id="cmp"
				class="form-control">
		</div>
	</div>

	<div class="row" align="right">
		<div class="col-md-6">
		</div>
		<div class="col-md-6 pr-4" style="color: black !important;">
			<input type='checkbox' class='checkall' name='checkall' id='checkall' value=''> Check All In This Page
		</div>
	</div>

	<div class="form-row">
		<table class="table table-striped" data-plugin="dataTable" id="tabelpiliheksportir"
			style="width:100%!important;">
			<thead class="text-white" style="background-color:#C4C4C4">
				<tr>
					<th style="width: 70%;">
						<center> Company Name</center>
					</th>
					<!-- <th style="width: 30%;"> <input type='checkbox' class='checkall' name='checkall' id='checkall' value=''>All</th> -->
					<th style="width: 30%;">
						<center> Check </center>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="loading-spinner">
					<td colspan="2">
						<div class="text-center">
							<div class="spinner-grow text-primary" role="status">
								<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-secondary" role="status">
								<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-success" role="status">
								<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-danger" role="status">
								<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-warning" role="status">
								<span class="sr-only">Loading...</span>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<?php
//  }
 ?>
</div>

<div class="row">
	<div class="col-md-1">
	</div>
	<div class="col-md-8">
		<br />
		<p style="color: #000000">To further increase the inquiry response rate, this information can also be addressed
			to all Inaexport members</p>
		<input type="checkbox" id="publish" name="publish" value="">
		<label for="publish" style="color: #000000"> I agree, this inquiry reply by others members of
			inaexport</label><br>
	</div>
	{{-- <div class="col-md-3">
		<button onclick="savecheckall();" class="btn btn-primary"
			title="save selected company in this page">Save</button>
	</div> --}}
</div>

<br>

<div class="modal-footer" style="background-color:#2e899e; color:white;">
	<button style="border-radius: 5px;" type="button" class="btn btn-danger btn-close post-inquiry" data-bs-dismiss="modal">
		<font color="white">Close</font>
	</button>
	{{--<a style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" href="{{ url('br_pw_bc/'.$id) }}"
		class="btn btn-warning">
		<font color="white">Broadcast</font>
	</a>--}}
	<a style="background-color: #d5b824ed!Important;border:#d5b824ed!important;border-radius: 5px;"
		onclick="broadcast()" class="btn btn-warning post-inquiry">
		<font color="white">Send</font>
	</a>
</div>

<script type="text/javascript">
	// $("input[name='eksportir']").change(function() {
		// 	var ischecked= $(this).is(':checked');
		// 	if(!ischecked){
		// 		dataeksportir.filter(val);
		// 		$("input[name='eksportir']").prop('unchecked',false);
		// 	}else{
		// 		if(dataeksportir.includes(val)){

		// 		}else{
		// 			$('input:checkbox[value=' + val + ']').attr('disabled', true);
		// 			dataeksportir.push($(this).val());
		// 		}
		// 	}
		// 	console.log(dataeksportir);
		// })

	$('#checkall').change(function() {
		if(this.checked) {
			if($("input[name='eksportir']").prop('disabled')){

			}else{
				$("input[name='eksportir']").prop('checked', true);
			}

		}else{
			if($("input[name='eksportir']").prop('disabled')){

			}else{
				$("input[name='eksportir']").prop('checked', false);
			}

		}
	});

	$('#publish').change(function(){
		if(this.checked){
			$(this).val('on');
		} else {
			$(this).val('off');
		}
	});
</script>