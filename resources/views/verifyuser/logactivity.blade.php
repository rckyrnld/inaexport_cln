@include('header')
<style>
table, th, tr, td {
    text-align: left;
}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i>List Activity</h5>
					<br>
				
                </div>
		<table width="30%" style="margin-left:20px!Important; font-text : 13px!important;">
		<?php 
		$cariwkwk = DB::select("select * from itdp_company_users where id='".$id."' ");
		foreach($cariwkwk as $cw){
		?>
		<tr>
			<td width="40%"><b>Email</b></td>
			<td width="10%">:</td>
			<td width="50%"><?php echo $cw->email; ?></td>
		</tr>
		<tr>
			<td width="40%"><b>Role</b></td>
			<td width="10%">:</td>
			<td width="50%"><?php if($cw->id_role == 2){ echo "Indonesian Exporter";}else{ echo "Buyer"; }?></td>
		</tr>
		<?php } ?>
		</table>
		<br>	
				
                <div class="box-body bg-light">
				
				       <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th><center>No</center></th>
									<th>
                                        <center>Date Time</center>
                                    </th>
									<th>
                                        <center>Activity</center>
                                    </th>
									
                                    <th width="20%">
                                        <center>Keterangan</center>
                                    </th>
									
                                </tr>
                                </thead>
								<tbody>
								<?php $nt = 1; 
								$data = DB::select("select * from log_user where id_user='".$id."' order by id_log desc ");
								foreach($data as $ruu){ ?>
								<tr>
									<td><center><?php echo $nt; ?></center></td>
									<td><center><?php echo $ruu->date." ".$ruu->waktu; ?></center></td>
									<td>
									<?php 
									if($ruu->id_activity == 0){ echo "Login"; }else{
									$carieksportir = DB::select("select * from mst_activiy where id_activity='".$ruu->id_activity."' limit 1");
									
										foreach($carieksportir as $ce){
											echo $ce->activity_name;
										}
									
									}
									?>
									</td>
									<td style="text-align:left!important;">
									<?php if($ruu->id_activity == 0){ echo "had login"; }else{ echo $ruu->keterangan; } ?>
									</td>
									</tr>
								
								<?php $nt++; } ?>
								
								</tbody>

                            </table>
                       
         

  


            </div>

        </div>
    </div>
</div>
 <script>
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
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad2/")}}/'+a,{_token:token},function(data){
			$("#isibroadcast").html(data);
			
		 })
}
</script>
<script type="text/javascript">
    $(function () {
        $('#users-table0').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getcsc0') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                {data: 'f4', name: 'f4'},
                {
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
		
		$('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getcsc') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                {data: 'f4', name: 'f4'},
                {
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
		$('#users-table3').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getcsc3') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                {data: 'f4', name: 'f4'},
                {
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
    });
</script>


@include('footer')
