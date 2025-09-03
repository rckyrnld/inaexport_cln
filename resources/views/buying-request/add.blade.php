@extends('header2')
@section('content')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
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

	.select2-container--default .select2-selection--single {
		background-color: #fff !important;
		border: 1px solid rgba(120, 130, 140, 0.5) !important;
		border-radius: 4px !important;
	}

	/* Change background color of buttons on hover */
	.tab button:hover {
		background-color: #ddd;
	}

	/* Create an active/current tablink class */
	.tab button.active {
		background-color: #ccc;
	}

	.select2-container .select2-selection--single {
		box-sizing: border-box;
		cursor: pointer;
		display: block;
		height: 35px !important;
	}

	.custom-select,
	.custom-file-control,
	.custom-file-control:before,
	select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
		height: 35px !important;
	}

	.select-dropdown {
		position: static;
	}

	.select-dropdown .select-dropdown--above {
		margin-top: 336px;
	}

	#select2-country-results {
		font-size: 11px !important;
	}

	#select2-category-results {
		font-size: 11px !important;
	}

	.select2-container--default {
		width: 100% !important;
	}

	.select2-search__field {
		font-size: 10.5px !important;
	}

	#select2-t2s-results {
		font-size: 11px !important;
	}

	#select2-t3s-results {
		font-size: 11px !important;
	}

	.modal {
		overflow-y: auto !important;
	}

	.modal-content {
		width: 100% !important;
	}
</style>

<!-- Select Category -->
<div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="catModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="catModalLabel">Select Product Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="col-sm-12">
							<label><b>@lang("login.forms.by3") (<font color="red">*</font>)</b></label>
						</div>
						<div class="form-group col-sm-12" style="font-size: 12px !important;">
							<?php
							$ms1 = DB::select("select id,nama_kategori_en from csc_product where level_1 = 0 and level_2 = 0 order by nama_kategori_en asc");
							?>
							<select style="color:black;font-size: 12px !important; " size="13" class="column J-noselect" name="category[]" id="category" onchange="t1()" required form="form_br">
								<option value="">@lang("login.forms.by11")</option>
								<?php foreach ($ms1 as $val1) { ?>
									<option value="{{ $val1->id }}">{{ $val1->nama_kategori_en }}</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div id="t2">
							<input type="hidden" name="t2s" id="t2s" value="0" form="form_br">
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div id="t3">
							<input type="hidden" name="t3s" id="t3s" value="0" form="form_br">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary mr-auto rounded" data-dismiss="modal">Confirm</button>
			</div>
		</div>
	</div>
</div>
<!--select category end-->

<form class="form-horizontal" method="POST" action="{{ url('br_save') }}" enctype="multipart/form-data" id="form_br">
	{{ csrf_field() }}
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header border-bottom">
					<h3 class="mb-0">Buying Request Add</h3>
				</div>
				<div class="form-row">
					<div class="card-body">
						<div class="col-md-12">
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
							<div class="form-row">
								<div class="col-md-6">
									<label><b>What product do you looking for (<font color="red">*</font>)</b></label>
								</div>
								<div class="col-sm-6">
									<label><b>Inquiry Valid With (Days) (<font color="red">*</font>)</b></label>
								</div>
								<div class="form-group col-sm-6">
									<input type="text" value="" name="cmp" id="cmp" class="form-control">
								</div>
								<div class="form-group col-sm-6">
									<select class="form-control" name="valid" id="valid" required>
										{{-- <option value="0">None</option> --}}
										<option value="3">Valid within 3 days</option>
										<option value="5">Valid within 5 days</option>
										<option value="7">Valid within 7 days</option>
										<option value="15">Valid within 14 days</option>
										<option value="30">Valid within 30 days</option>
									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="col-sm-12">
									<label><b>@lang("login.forms.by3") (<font color="red">*</font>)</b></label> :
									<a data-toggle="modal" data-target="#catModal" id="labelcat" href="#">
										Click Here to Select Category
									</a>
								</div>
							</div>

							<br>

							<div class="form-row">
								<div class="col-sm-12">
									<label><b>Specification (<font color="red">*</font>)</b></label>
								</div>
								<div class="form-group col-sm-12">
									<textarea value="" name="spec" id="spec" class="form-control" required></textarea>
								</div>
							</div>

							{{-- <div id="t2">
							<input type="hidden" name="t2s" id="t2s" value="0">
						</div>
						<div id="t3">
							<input type="hidden" name="t3s" id="t3s" value="0">
						</div> --}}

							<div class="form-row">
								<div class="col-sm-6">
									<label><b>Estimated order quantity</b></label>
								</div>
								<div class="col-sm-6">
									<label><b>Targeted price (Estimated total)</b></label>
								</div>
								<div class="form-group col-sm-6">
									<div class="form-row">
										<div class="col-sm-7"><input type="number" name="eo" id="eo" class="form-control"> </div>
										<div class="col-sm-5">
											<select class="form-control select2" name="neo" id="neo">
												<option value="Dozen">Dozen</option>
                                                <option value="Grams">Grams</option>
                                                <option value="Kilograms">Kilograms</option>
                                                <option value="Liters">Liters</option>
                                                <option value="Meters">Meters</option>
                                                <option value="Packs">Packs</option>
                                                <option value="Pairs">Pairs</option>
                                                <option value="Pieces">Pieces</option>
                                                <option value="Sets">Sets</option>
                                                <option value="Tons">Tons</option>
                                                <option value="Unit">Unit</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group col-sm-6">
									<div class="form-row">
										<div class="col-sm-7"><input type="text" value="" name="tp" id="tp" class="amount form-control"></div>
										<div class="col-sm-5 align-self-center">
											<label class="control-label">USD</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-row">
								<div class="col-sm-6">
									<label><b>Location of delivery (<font color="red">*</font>)</b></label>
								</div>
								<div class="col-sm-6">
									<label><b>City (<font color="red">*</font>)</b></label>
								</div>
								<div class="form-group col-sm-6">
									<?php
									$ms2 = DB::select("select id,country from mst_country order by country asc");
									?>
									<select style="border-color: rgba(120, 130, 140, 0.5)!important;
								border-radius: 0.25rem!important;
								color: inherit!important;" class="form-control select2" name="country" id="country" required>
										<option value="">-- Select Country --</option>
										<?php foreach ($ms2 as $val2) { ?>
											<option value="{{ $val2->id }}">{{ $val2->country }}</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<input type="text" value="" name="city" id="city" class="form-control" placeholder="City/State" required>
								</div>
							</div>
							{{-- <div class="form-row">
								<div class="col-sm-12">
									<label><b>Shipping & Payment conditions</b></label>
								</div>
								<div class="form-group col-sm-12">
									<textarea value="" name="ship" id="ship" class="form-control"></textarea>
								</div>
							</div> --}}
							<div class="form-row">
								{{-- <div class="col-sm-12">
									<label><b>Add attachment (Relevant to a request)</b></label>
								</div>
								<div class="form-group col-sm-12">
									<input type="file" value="" name="doc" id="doc" class="form-control upload1">
								</div> --}}
							</div>
						</div>
						<div class="col-sm-12">
							<div align="right">
								<a href="{{ url()->previous() }}" class="btn btn-md btn-danger rounded">Cancel</a>
								<button class="btn btn-md btn-primary rounded"><i class="fas fa-save"></i> Submit</button>
							</div>
						</div>
						<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background-color:#2e899e; color:white;">
					<h6>Broadcast Buying Request</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div id="isibroadcast"></div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('.select2').select2({
				dropdownPosition: 'below'
			});
		});

		$('.upload1').on('change', function(evt) {
			var size = this.files[0].size;
			if (size > 5000000) {
				// if(size > 20000){
				$(this).val("");
				alert('image size must less than 5MB');
			} else {

			}
		});

		function formatAmountNoDecimals(number) {
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(number)) {
				number = number.replace(rgx, '$1' + '.' + '$2');
			}
			return number;
		}

		function formatAmount(number) {

			// remove all the characters except the numeric values
			number = number.replace(/[^0-9]/g, '');

			// set the default value
			if (number.length == 0) number = "0.00";
			else if (number.length == 1) number = "0.0" + number;
			else if (number.length == 2) number = "0." + number;
			else number = number.substring(0, number.length - 2) + '.' + number.substring(number.length - 2, number.length);

			// set the precision
			number = new Number(number);
			number = number.toFixed(2); // only works with the "."

			// change the splitter to ","
			number = number.replace(/\./g, '');

			// format the amount
			x = number.split(',');
			x1 = x[0];
			x2 = x.length > 1 ? ',' + x[1] : '';

			return formatAmountNoDecimals(x1) + x2;
		}

		$(function() {
			$('.amount').keyup(function() {
				$(this).val(formatAmount($(this).val()));
			});

		});

		function nv() {
			var a = $('#staim').val();
			if (a == 2) {
				$('#sh1').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach ($quertreject as $qr) { ?><option value="<?php echo $qr->id; ?>"><?php echo $qr->nama_template; ?></option><?php } ?></select></div></div>')
			} else {
				$('#sh1').html(' ');
				$('#sh2').html(' ');
			}
		}

		function ketv() {
			var a = $('#template_reject').val();
			if (a == 1) {
				$('#sh2').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>')
			}
		}



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

		function catLabel() {
			var text = 'Select Category';
			var category = $('#category option:selected').text();
			if (category != '') {
				text = category;
				var cat1 = $('#t2s option:selected').text();
				if (cat1 != '') {
					text += ' » ' + cat1;
				}
				var cat2 = $('#t3s option:selected').text();
				if (cat2 != '') {
					text += ' » ' + cat2;
				}
			}

			$('#labelcat').html(text);
		}

		// function t1() {
		//         $('#t2').html('');
		//         $('#t3').html('');
		//         var t1 = $('#category').val();
		//         var token = $('meta[name="csrf-token"]').attr('content');
		//         $.get('{{URL::to("ambilt2/")}}/' + t1, {_token: token}, function (data) {
		//             $("#t2").html(data);
		//             $("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
		//             $('.select2').select2();

		//         })
		//     }

		// function t2() {
		//         $('#t3').html('');
		//         var t2 = $('#t2s').val();
		//         var token = $('meta[name="csrf-token"]').attr('content');
		//         $.get('{{URL::to("ambilt3/")}}/' + t2, {_token: token}, function (data) {
		//             $("#t3").html(data);
		//             $('.select2').select2();

		//         })
		// 	}

		function t1() {
			$('#t2').html('');
			$('#t3').html('');
			var t1 = $('#category').val();
			var token = $('meta[name="csrf-token"]').attr('content');
			$.get('{{URL::to("ambilt2/")}}/' + t1, {
				_token: token
			}, function(data) {
				$("#t2").html(data);
				$("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0" size="13" class="column J-noselect">');
				$('.select2').select2();
			})
			catLabel();
		}

		function t2() {
			$('#t3').html('');
			var t2 = $('#t2s').val();
			var token = $('meta[name="csrf-token"]').attr('content');
			$.get('{{URL::to("ambilt3/")}}/' + t2, {
				_token: token
			}, function(data) {
				$("#t3").html(data);
				$('.select2').select2();
			})
			catLabel()
		}

		function t3() {
			catLabel();
		}
	</script>

	@include('footer')
	@endsection