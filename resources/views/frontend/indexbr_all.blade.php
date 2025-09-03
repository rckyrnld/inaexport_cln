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
                            <li><a href="{{url('front_end')}}">@lang("login.forms.home")</a></li>
                            <li>@lang("login.forms.br")</li>
                        </ul>
                    </div>
			<div class="form-row" style="font-size:12px;">
			 <!--<img style="width:100%!important;" src="{{url('assets')}}/assets/images/07-Form-Request_01.png" alt="." >-->
<?php 
			 if(!empty(Auth::guard('eksmp')->user()->id)){
		if(Auth::guard('eksmp')->user()->id_role == 2){
			
?>
<table id="tablebureq3" border="0" class="table table-responsive table-bordered table-striped" style="width: 100%">
                                <thead class="text-white" style="background-color: #1089ff;">
								<th><center>No</center></th>
								<th><center>Subject</center></th>
								<th><center>Category</center></th>
								<th><center>Created at</center></th>
								<th><center>Valid Time</center></th>
								<th><center>Status</center></th>
								<th><center>Created By</center></th>
								<th><center>Aksi</center></th>
                                </thead>
								

                            </table>
			 <?php }else{ ?>
			 
			 <table id="tablebureq2" border="0" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
								<th><center>No</center></th>
								<th><center>Subject</center></th>
								<th><center>Category</center></th>
								<th><center>Created at</center></th>
								<th><center>Valid Time</center></th>
								<th><center>Created By</center></th>
								<th><center>Status</center></th>
                                </thead>
								

                            </table>
			 <?php }}else{ ?>
  
  <table id="tablebureq" border="0" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
								<th><center>No</center></th>
								<th><center>Subject</center></th>
								<th><center>Category</center></th>
								<th><center>Created at</center></th>
								<th><center>Valid Time</center></th>
								<th><center>Created By</center></th>
								<th><center>Status</center></th>
                                </thead>
								

                            </table>

			 <?php } ?>
			<!--<a href="{{ url('br_importir_add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add Buying Request</a><br><br> -->
		
            </div>
                   
            </div>
        </div>
    </section>
    <!--product area end-->

@include('frontend.layouts.footer')
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable();
	
	$('#tablebureq').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.br2') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'col1', name: 'col1'},
                {data: 'col2', name: 'col2'},
                {data: 'col3', name: 'col3'},
                {data: 'col4', name: 'col4'},
                {data: 'col6', name: 'col6'},
                {data: 'col5', name: 'col5'}
                
            ],
            fixedColumns: true
        });
		
		$('#tablebureq2').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.br2') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'col1', name: 'col1'},
                {data: 'col2', name: 'col2'},
                {data: 'col3', name: 'col3'},
                {data: 'col4', name: 'col4'},
                {data: 'col6', name: 'col6'},
                {data: 'col5', name: 'col5'}
                
            ],
            fixedColumns: true
        });
		
		$('#tablebureq3').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.br4') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'col1', name: 'col1'},
                {data: 'col2', name: 'col2'},
                {data: 'col3', name: 'col3'},
                {data: 'col4', name: 'col4'},
				{data: 'col5', name: 'col5'},
                {data: 'col6', name: 'col6'},
                {data: 'aks', name: 'aks'}
                
                
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