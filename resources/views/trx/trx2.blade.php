@extends('header2')
@section('content')
<style>
	body {
		font-family: Arial;
	}

	.select2-container--default .select2-selection--single {
		background-color: #fff !important;
		border: 1px solid rgba(120, 130, 140, 0.5) !important;
		border-radius: 4px !important;
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
<style>
	.chat {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	.chat li {
		margin-bottom: 10px;
		padding-bottom: 5px;
		border-bottom: 1px dotted #B3A9A9;
	}

	.chat li.left .chat-body {
		margin-left: 60px;
	}

	.chat li.right .chat-body {
		margin-right: 10px;
	}


	.chat li .chat-body p {
		margin: 0;
		color: #777777;
	}

	.panel .slidedown .glyphicon,
	.chat .glyphicon {
		margin-right: 5px;
	}

	.panel-body {

		height: 280px;
	}

	::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
		background-color: #F5F5F5;
	}

	::-webkit-scrollbar {
		width: 10px;
		background-color: #F5F5F5;
	}

	::-webkit-scrollbar-thumb {
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
		background-color: #555;
	}
</style>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header border-bottom">
				<h3 class="mb-0"><i class="fas fa-shopping-cart"></i> {{ $pageTitle }}</h3>
			</div>


			<div class="card-body">

				<div class="col-md-12">
					<div class="">

						<form class="form-horizontal" method="POST" action="{{ url('save_trx') }}"
							enctype="multipart/form-data">
							{{ csrf_field() }}
							<?php
								$q2 = DB::select("select * from csc_transaksi where id_transaksi='".$id."'");
								foreach($q2 as $p2){
							?>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Sources</b>
								</div>
								<div class="form-group col-sm-4">
									<?php 
									 echo 'Inquiry/Buying Request';
									?>
									<input type="hidden" name="origin" value="<?php echo $p2->origin; ?>">
									<input type="hidden" name="by_role" value="<?php echo $p2->by_role; ?>">
									<input type="hidden" name="id_pembuat" value="<?php echo $p2->id_pembuat; ?>">
									<input type="hidden" name="id_eksportir" value="<?php echo $p2->id_eksportir; ?>">
								</div>
							</div>
							<?php if($p2->origin == 2){ ?>
							<?php $q3 = DB::select("select * from csc_buying_request where id='".$p2->id_terkait."'");
								foreach($q3 as $p3){
							?>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Created By</b>
								</div>
								<div class="form-group col-sm-4">
									<?php
										$r1 = DB::select("select * from csc_buying_request where id='" . $p2->id_terkait . "'");
										foreach ($r1 as $ip1) {
											$by_role = $ip1->by_role;
											$id_pembuat = $ip1->id_pembuat;
										}
										if ($by_role == 1) {
											$addres = '';
											echo 'Admin';
										} elseif ($by_role == 4) {
											$addres = '';
											echo 'Perwakilan';
										} elseif ($by_role == 3) {
											$usre = DB::select("select b.company,b.badanusaha,b.addres,b.city from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $id_pembuat . "'");
											foreach ($usre as $imp) {
												$addres = $imp->addres . ' , ' . $imp->city;
												echo 'Importir - ' . $imp->badanusaha . ' ' . $imp->company;
											}
										}
									?>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Address</b>
								</div>
								<div class="form-group col-sm-4">
									<?php echo $addres;?>
								</div>

							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Category Product</b>
								</div>
								<div class="form-group col-sm-3">

									<select class="select2 form-control" name="id_product" id="id_product">
										<option <?php if ($p2->id_product == 0) {
											echo 'selected';
											} ?> value="0">-- Choose Category Product --
										</option>
										<?php 
											$namaprod = DB::select("select id,prodname_en from csc_product_single where id_itdp_company_user='".Auth::guard('eksmp')->user()->id."' order by prodname_en asc");
											foreach($namaprod as $np){
										?>
										<option <?php if ($np->id == $p2->id_product) {
											echo 'selected';
											} ?> value="
											<?php echo $np->id; ?>">
											<?php echo $np->prodname_en; ?>
										</option>
										<?php } ?>
									</select>
								</div>

							</div>


							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Kind of Subject</b>
								</div>
								<div class="form-group col-sm-4">
									Offer to buy
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Date</b>
								</div>
								<div class="form-group col-sm-4">
									<?php echo $p3->date; ?>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Quantity</b>
								</div>
								<div class="form-group col-sm-2">
									<input type="number" name="eo" class="form-control" value="<?php echo $p3->eo; ?>">
								</div>
								<div class="form-group col-sm-1">
									<input type="hidden" name="id_br" class="form-control"
										value="<?php echo $p2->id_terkait; ?>">
									<select class="form-control select2" name="neo" id="neo">
										<option value="">- Choose -</option>

										<option <?php if ($p3->neo == 'Dozen') {
											echo 'selected';
											} ?> value="Dozen">Dozen</option>
										<option <?php if ($p3->neo == 'Grams') {
											echo 'selected';
											} ?> value="Grams">Grams</option>
										<option <?php if ($p3->neo == 'Kilograms') {
											echo 'selected';
											} ?>value="Kilograms">Kilograms</option>
										<option <?php if ($p3->neo == 'Liters') {
											echo 'selected';
											} ?> value="Liters">Liters</option>
										<option <?php if ($p3->neo == 'Meters') {
											echo 'selected';
											} ?> value="Meters">Meters</option>
										<option <?php if ($p3->neo == 'Packs') {
											echo 'selected';
											} ?>value="Packs">Packs</option>
										<option <?php if ($p3->neo == 'Pairs') {
											echo 'selected';
											} ?> value="Pairs">Pairs</option>
										<option <?php if ($p3->neo == 'Pieces') {
											echo 'selected';
											} ?> value="Pieces">Pieces</option>
										<option <?php if ($p3->neo == 'Sets') {
											echo 'selected';
											} ?> value="Sets">Sets</option>
										<option <?php if ($p3->neo == 'Tons') {
											echo 'selected';
											} ?> value="Tons">Tons</option>
										<option <?php if ($p3->neo == 'Unit') {
											echo 'selected';
											} ?> value="Unit">Unit</option>

									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Price</b>
								</div>
								<div class="form-group col-sm-2">
									<input type="text" name="tp" class="amount form-control"
										value="<?php echo number_format($p3->tp, 0, ',', '.'); ?>">
								</div>
								<div class="form-group col-sm-1">
									<select style="color:black;" class="form-control select2" name="ntp" id="ntp">

										<option <?php if ($p3->ntp == 'USD') {
											echo 'selected';
											} ?> value="USD">USD
										</option>

									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Subject</b>
								</div>
								<div class="form-group col-sm-4">
									<?php echo $p3->subyek; ?>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Messages</b>
								</div>
								<div class="form-group col-sm-4">
									<?php echo $p3->spec; ?>
									<input type="hidden" id="id_br" value="<?php echo $p3->id; ?>">
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>File</b>
								</div>
								<div class="form-group col-sm-4">
									<a download href="{{ asset('uploads/buy_request/' . $p3->files) }}">
										<?php echo $p3->files; ?>
									</a>
								</div>
							</div>

							<?php } ?>

							<?php }else { ?>
							<!-- Inquiry -->
							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Created By</b>
								</div>
								<div class="form-group col-sm-4">
									<?php if ($p2->by_role == 1) {
                                                echo 'Admin';
                                            } elseif ($p2->by_role == 4) {
                                                echo 'Representative';
                                            } else {
                                                echo 'Importer';
                                            } ?>
									<?php if($p2->by_role == 3){
			$carih = DB::select("select a.*,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil=b.id and a.id='".$p2->id_pembuat."'");
			foreach($carih as $ch){
				echo " - ".$ch->badanusaha." ".$ch->company." (".$ch->username.")";
			?>

									<?php } } ?>
								</div>
							</div>
							<?php
                                    $idt = $p2->id_terkait;
                                    $caridt = DB::select("select * from csc_inquiry_br where id='" . $idt . "'");
                                    foreach ($caridt as $cdt) {
                                        $cd1 = $cdt->id;
                                        $cd2 = $cdt->id_csc_prod_cat;
                                        $cd3 = $cdt->id_csc_prod_cat_level1;
                                        $cd4 = $cdt->id_csc_prod_cat_level2;
                                        $cd5 = $cdt->type;
                                        $cd6 = $cdt->to;
                                    }
                                    //echo $cd1."aaaa";
                                    ?>
							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Category</b>
								</div>
								<div class="form-group col-sm-4">
									<?php
                                            if ($cd5 == 'importir') {
                                                $caripr = DB::select("select * from  csc_product_single where id='" . $cd6 . "'");
                                                foreach ($caripr as $xd) {
                                                    echo $xd->prodname_en;
                                                }
                                                //echo $cd6;
                                            } elseif ($cd5 == 'admin' || $cd5 == 'perwakilan') {
                                                $caripr = DB::select("select * from  csc_inquiry_category where id_inquiry='" . $cd1 . "'");
                                                foreach ($caripr as $xd) {
                                                    $idsao = $xd->id_cat_prod;
                                                    $caripr2 = DB::select("select * from  csc_product where id='" . $idsao . "'");
                                                    foreach ($caripr2 as $xd2) {
                                                        echo $xd2->nama_kategori_en;
                                                    }
                                                }
                                            } else {
                                            }
                                            ?>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Quantity</b>
								</div>
								<div class="form-group col-sm-2">
									<input type="number" name="eo" class="form-control" value="<?php if (empty($p2->eo)) {
                                                    echo '1';
                                                } else {
                                                    echo $p2->eo;
                                                } ?>">
								</div>
								<div class="form-group col-sm-2">
									<input type="hidden" name="id_in" class="form-control"
										value="<?php echo $p2->id_terkait; ?>">
									<select class="form-control" name="neo" id="neo">
										<option value="">- Choose -</option>

										<option <?php if ($p2->neo == 'Dozen') {
											echo 'selected';
											} ?> value="Dozen">Dozen</option>
										<option <?php if ($p2->neo == 'Grams') {
											echo 'selected';
											} ?> value="Grams">Grams</option>
										<option <?php if ($p2->neo == 'Kilograms') {
											echo 'selected';
											} ?>value="Kilograms">Kilograms</option>
										<option <?php if ($p2->neo == 'Liters') {
											echo 'selected';
											} ?> value="Liters">Liters</option>
										<option <?php if ($p2->neo == 'Meters') {
											echo 'selected';
											} ?> value="Meters">Meters</option>
										<option <?php if ($p2->neo == 'Packs') {
											echo 'selected';
											} ?>value="Packs">Packs</option>
										<option <?php if ($p2->neo == 'Pairs') {
											echo 'selected';
											} ?> value="Pairs">Pairs</option>
										<option <?php if ($p2->neo == 'Pieces') {
											echo 'selected';
											} ?> value="Pieces">Pieces</option>
										<option <?php if ($p2->neo == 'Sets') {
											echo 'selected';
											} ?> value="Sets">Sets</option>
										<option <?php if ($p2->neo == 'Tons') {
											echo 'selected';
											} ?> value="Tons">Tons</option>
										<option <?php if ($p2->neo == 'Unit') {
											echo 'selected';
											} ?> value="Unit">Unit</option>

									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Price</b>
								</div>
								<div class="form-group col-sm-2">

									<input type="text" name="tp" class="amount form-control" value="<?php if (empty($p2->tp) || $p2->tp == null) {
                                                    echo '0';
                                                } else {
                                                    echo number_format($p2->tp, 0, ',', '.');
                                                } ?>">
								</div>
								<div class="form-group col-sm-2">
									<select style="color:black;" class="form-control" name="ntp" id="ntp">
										<option value="IDR">IDR</option>
										<option value="THB">THB</option>
										<option selected value="USD">USD</option>
									</select>
								</div>
							</div>


							<?php } ?>


							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Tracking of Type</b>
								</div>
								<div class="form-group col-sm-3">
									<select <?php if ($p2->status_transaksi == 1) {
										echo 'readonly';
										} ?> class="form-control" name="type_tracking">
										<option value="">- Select Tracking Type -</option>
										<option <?php if ($p2->type_tracking == 'DHL Express') {
											echo 'selected';
											} ?> value="DHL Express">DHL Express</option>
										<option <?php if ($p2->type_tracking == 'DHL Active Tracing') {
											echo 'selected';
											} ?> value="DHL Active Tracing">DHL Active Tracing
										</option>
										<option <?php if ($p2->type_tracking == 'DHL Global Forwarding') {
											echo 'selected';
											} ?> value="DHL Global Forwarding">DHL Global
											Forwarding</option>
										<option <?php if ($p2->type_tracking == 'Fedex') {
											echo 'selected';
											} ?> value="Fedex">Fedex</option>
										<option <?php if ($p2->type_tracking == 'Fedex Freight') {
											echo 'selected';
											} ?> value="Fedex Freight">Fedex Freight</option>
										<option <?php if ($p2->type_tracking == 'FedEx Ground') {
											echo 'selected';
											} ?> value="FedEx Ground">FedEx Ground</option>
										<option <?php if ($p2->type_tracking == 'China EMS') {
											echo 'selected';
											} ?> value="China EMS">China EMS</option>
										<option <?php if ($p2->type_tracking == 'Deutsche Post DHL') {
											echo 'selected';
											} ?> value="Deutsche Post DHL">Deutsche Post DHL
										</option>
										<option <?php if ($p2->type_tracking == 'Other') {
											echo 'selected';
											} ?> value="Other">Other</option>
									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>No Tracking</b>
								</div>
								<div class="form-group col-sm-3">
									<input class="form-control" type="text" id="no_track" name="no_track"
										value="<?php echo $p2->no_tracking; ?>" <?php if ($p2->status_transaksi ==
									1) {
									echo 'readonly';
									} ?>>
									<input class="form-control" type="hidden" id="tipekirim" name="tipekirim" value="0">
									<input class="form-control" type="hidden" id="id_transaksi" name="id_transaksi"
										value="<?php echo $p2->id_transaksi; ?>">
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-sm-2">
									<b>Link Tracking</b>
								</div>
								<div class="form-group col-sm-3">
									<input class="form-control" type="text" id="link_tracking" name="link_tracking"
										value="<?php echo $p2->link_tracking; ?>" <?php if ($p2->status_transaksi ==
									1) {
									echo 'readonly';
									} ?>>
								</div>
							</div>

							<div class="form-row">

								<div class="form-group col-sm-5">


									<br>
									<?php  if($p2->status_transaksi != 1){ ?>
									<button style="width:33%;" onclick="getyou(1)" type="submit"
										class="btn btn-info">Submit</button>
									<button style="width:30%;" onclick="getyou(0)" type="submit"
										class="btn btn-warning">
										<font color="white">Draft</font>
									</button>
									<?php  } ?>
									<a style="width:33%;" href="{{ url('trx_list') }}" class="btn btn-danger">Back</a>
									</center>
								</div>
							</div>
					</div>

				</div>

				<?php } ?>
				</form>
				<script>
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
				</script>
				<script>
					function getyou(x) {
                                $('#tipekirim').val(x);
                            }
                            $(document).ready(function() {
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



			</div>
		</div>
	</div>
</div>

@include('footer')
@endsection