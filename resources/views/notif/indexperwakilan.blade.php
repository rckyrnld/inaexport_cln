@include('header')
<style>
body {font-family: Arial;}

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
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Notif For Admin</h5>
                </div>
				
				
				
				
                <div class="box-body bg-light">
				<div class="form-row">
						
					</div>
				<hr>
				<br>
			           
               <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th width="5%">No</th>
									<th>
                                        <center>From</center>
                                    </th>
                                    <th>
                                        <center>Details</center>
                                    </th>
									<th>
                                        <center>Action</center>
                                    </th>
                                    
                                   
									
                                </tr>
                                </thead>
								<tbody>
								<?php 
								$data = DB::select("select * from notif where untuk_id='".Auth::user()->id."' and status_baca='0' and to_role='4' order by id_notif desc"); 
								$no =1;
								foreach($data as $dt){
								?>
								<tr>
									<td><?php echo $no; ?></td>
									<td><?php echo $dt->dari_nama; ?></td>
									<td><?php echo $dt->keterangan; ?></td>
									<td>
									<?php if($dt->id_terkait == NULL){ ?>
        <a class="btn btn-success" onclick="closenotif(<?php echo $dt->id_notif; ?>)" href="{{url($dt->url_terkait)}}">
             GO TO LINK</a>
        
									<?php }else{ ?>
			  <a class="btn btn-success" onclick="closenotif(<?php echo $dt->id_notif; ?>)" href="{{url($dt->url_terkait.'/'.$dt->id_terkait)}}">
              GO TO LINK</a>
			 
									<?php } ?>
									</td>
								</tr>
								<?php $no++; } ?>
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

function ganti(){
	var a = $('#bct').val();
	// alert(a);
	if(a == 0){
		$('#cb').html('<a href="{{url('allgr/0')}}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
	}else if(a == 1){
		$('#cb').html('<a href="{{url('allgr/1')}}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
	}else if(a == 4){
		$('#cb').html('<a href="{{url('allgr/4')}}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
	}else if(a == 3){
		$('#cb').html('<a href="{{url('allgr/3')}}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
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
