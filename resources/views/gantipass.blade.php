@include('header')
        
         &nbsp;

<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
       {{-- <div class="box-header">
       </div> --}}
       <div class="box-divider m-0"></div>
      <form id="" method="POST" action="{{ url('updatepass') }}"class="form-horizontal form-label-left">
      <div class="box-body">
	  <br>
	  <?php foreach($queryxp as $val1){ ?>
      	  <div class="form-group row">
		  <div class="col-sm-1"></div>
										<label class="col-sm-3 col-form-label"><b>Nama User</b></label>
										<div class="col-sm-5">
											{{ csrf_field() }}
											<input type="text" name="name" id="name" value="<?php echo $val1->name; ?>" class="form-control" readonly>
										</div>
										
					</div>
			 <div class="form-group row">
		  <div class="col-sm-1"></div>
										<label class="col-sm-3 col-form-label"><b>Ganti Password</b></label>
										<div class="col-sm-5">
											<input type="password" name="password" id="password" value="" class="form-control" required>
										</div>
										
					</div>
					
	  <?php } ?>
	  	<div class="modal-footer">
							<a href="{{url('')}}" class="btn btn-danger"><font color="white">Kembali</font></a>
							<button type="submit" class="btn btn-success" id="btn-savez" value="add">Simpan</button>
						</div>
</div>
</font>
</div>
</div>
</div>
</div>
&nbsp;


@include('footer')