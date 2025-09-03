@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Profil & Password</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <br>
                        <div>
				{{Form::open(['url' => 'updateperwakilans','method' => 'post'])}}
				<?php 
				$qe = DB::select("select * from itdp_admin_users where id='".$id."'");
				foreach($qe as $eq){
				if($eq->type == "DINAS PERDAGANGAN"){
					$tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and a.id='".$id."' ");
				}else{
					$tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_ln b where a.id_admin_ln = b.id and a.id='".$id."' ");
				}
				foreach($tq as $qt){
				?>
				<input type="hidden" value="<?php echo $id; ?>" name="ida">
				<input type="hidden" value="<?php echo $qt->idb; ?>" name="idb">
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Type',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
					  <input type="hidden" name="types" id="types" value="<?php echo $eq->type; ?>">
						  <select class="form-control" id="type" name="type" disabled></select>



				      </div>

				    </div>
				</div>
				<?php if($qt->type=="DINAS PERDAGANGAN"){ ?>
					<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Province',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
					<input type="hidden" name="country" value="<?php echo $qt->id_country; ?>">
						<select class="form-control" name="countrys" disabled>
						<!-- <option>DJPEN</option> -->
						<option value="">-- Choose Country --</option>
						<?php $mst = DB::select("select * from mst_province order by province_en asc"); 
						foreach($mst as $cu){
						?>
						<option <?php if($qt->id_country==$cu->id){ echo "selected"; } ?> value="<?php echo $cu->id; ?>"><?php echo $cu->province_en; ?></option>
						<?php } ?>
						
						</select>
					</div>
					</div>
				</div>
				<?php } else { ?>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Country',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<select class="form-control" name="country" required>
						<!-- <option>DJPEN</option> -->
						<option value="">-- Choose Country --</option>
						<?php $mst = DB::select("select id,mst_country_group_id,country from mst_country order by country asc"); 
						foreach($mst as $cu){
						?>
						<option <?php if($qt->country==$cu->id){ echo "selected"; } ?> value="<?php echo $cu->id; ?>"><?php echo $cu->country; ?></option>
						 <?php } ?>
						<?php /* $mst = DB::select("select * from mst_group_country order by group_country asc"); 
						foreach($mst as $cu){
						
						<option <?php if($qt->id_country==$cu->id){ echo "selected"; } ?> value="<?php echo $cu->id; ?>"><?php echo $cu->group_country; ?></option>
						 } */ ?>
						
						</select>
					</div>
					</div>
				</div>
				<?php } ?>
				
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Email',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="email" class="form-control" name="email" value="<?php echo $eq->email; ?>" required>
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Telp',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="phone" value="<?php echo $qt->telp; ?>" required>
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Nama Kantor',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="username" value="<?php echo $qt->username; ?>">
						<input type="hidden" class="form-control" name="pejabat" value="<?php echo $qt->nama; ?>" required>
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Website',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="web" value="<?php echo $qt->website; ?>" required>
						
					</div>
					</div>
				</div>
				<!--
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Username',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						
					</div>
					</div>
				</div>
				-->
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Password',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="password" class="form-control" name="password">
						<span><font color="red">Alert ! Dont fill it, if dont want password change !</font></span>
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Status',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<select class="form-control" name="status" required>
							<option value="">-- Choose Status --</option>
							<option <?php if($qt->status==1){ echo "selected"; } ?> value="1">Aktif</option>
							<option <?php if($qt->status==0){ echo "selected"; } ?> value="0">Tidak Aktif</option>
						</select>
					</div>
					</div>
				</div>
				
				<div align="left">
				<a class="btn btn-danger" href="{{ URL::previous() }}">Cancel</a>
				<input class="btn btn-primary" type="submit" value=" Update">
				</div>
				<?php } } ?>
				{{Form::close()}}
          	 	
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')

<script>

	$(document).ready(function () {
		$('#type').select2({
			allowClear: true,
			placeholder: 'Select Type',
			ajax: {
				url: "{{route('admin.perwakilan.type')}}",
				dataType: 'json',
				delay: 250,
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								text: item.type,
								// text: item.desc_eng ,
								id: item.type,
							}
						})
					};
				},
				cache: true
			}
		});
		@isset($id)
		var type = "{{$eq->type}}";
		if (type != null) {
			$.ajax({
				type: 'GET',
				url: "{{route('admin.perwakilan.type')}}",
				data: { code: type }
			}).then(function (data) {
				var option = new Option( data[0].type, data[0].type, true, true);
				// var option = new Option(data[0].desc_eng, data[0].id, true, true);

				$('#type').append(option).trigger('change');
			});
		}
		@endisset
	})
</script>
