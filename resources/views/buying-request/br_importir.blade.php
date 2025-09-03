<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8" />
  <title><?php echo $pageTitle; ?></title>
  <meta name="description" content="Responsive, Bootstrap, BS4" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="../assets/images/logo.svg">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.svg">
  
  <!-- style -->

  <link rel="stylesheet" href="{{url('assets')}}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />

  <!-- build:css ../assets/css/app.min.css -->
  <link rel="stylesheet" href="{{url('assets')}}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="{{url('assets')}}/assets/css/app.css" type="text/css" />
  <link rel="stylesheet" href="{{url('assets')}}/assets/css/style.css" type="text/css" />
  <link rel="stylesheet" href="{{url('assets')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" type="text/css" />
   <script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js" ></script>
<script src="{{url('assets')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js" ></script>

<script src="{{url('assets')}}/html/scripts/plugins/datatable.js" ></script>
  <!-- endbuild -->
  <style>
  .table-striped > tbody > tr:nth-child(odd) {
    background-color: rgba(118, 24, 24, 0.18)!important;
    background-clip: padding-box!important;
}
.table-striped > tbody > tr:nth-child(even) {
    background-color: rgba(118, 24, 24, 0.18)!important;
    background-clip: padding-box!important;
}

  </style>
</head>
<body style="font-family: "Times New Roman", Times, serif;">


<div class="d-flex flex-column flex" style="background-color:  #2e899e  ; color: #ffffff">
 <div class="light bg pos-rlt box-shadow" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
    <div class="mx-auto">
	<table border="0" width="100%">
	<tr>
	<td width="30%" style="font-size:13px;padding-left:10px"><img height="30px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ><b>&nbsp;&nbsp;&nbsp; Ministry Of Trade</b></td>
	<td width="30%"><!-- <center><span class="hidden-folded d-inline"><H5>Form Registrasi Pembeli Baru</H5></span></center> --></td>
	<td width="40%" align="right" style="padding-right:10px;">
	<a href="{{url('registrasi_pembeli')}}"><font color="white"><i class="fa fa-user"></i> @lang("login.lbl2")</font></a> &nbsp;&nbsp;&nbsp;<a href="{{url('registrasi_penjual')}}"><font color="white"><i class="fa fa-user"></i> @lang("login.lbl1")</font></a> &nbsp;&nbsp;&nbsp;
	<a href="{{ url('locale/en') }}"><img width="20px" height="15px" src="{{asset('negara/en.png')}}"></a>&nbsp;
	<a href="{{ url('locale/in') }}"><img width="20px" height="15px" src="{{asset('negara/in.png')}}"></a>&nbsp;
	<a href="{{ url('locale/ch') }}"><img width="20px" height="15px" src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
	<a href="{{url('login')}}"><font color="white"><i class="fa fa-sign-in"></i> 
	<?php if(empty(Auth::user()->name) && empty(Auth::guard('eksmp')->user()->username)){ ?>
		@lang("login.lbl3")
	<?php }else if(empty(Auth::user()->name) && !empty(Auth::guard('eksmp')->user()->username)){	
		echo Auth::guard('eksmp')->user()->username;
	}else if(empty(!Auth::user()->name) && empty(Auth::guard('eksmp')->user()->username)){?>
		{{ Auth::user()->name }}
	<?php } ?>
	
	
	</font></a>
	
	
	</td>
	</tr>
	</table>
	
      
       
     
    </div>
  </div>
  <div id="content-body" style="padding-left:100px; padding-right:100px ; color: #ffffff" >
    <div class="py-2 w-100">
	
	
      <div class="" style="text-color:black;padding-left:10px; padding-right:10px; border-radius: 3px;">
	  <br>
	  
	   <?php 
	   if(!empty(Auth::guard('eksmp')->user()->status)){
	   if (Auth::guard('eksmp')->user()->status == 1) {
	   ?>
	   <h5><center>List <?php echo $pageTitle; ?></center></h5>
	   <br><br>
	   
	   <a href="{{ url('br_importir_add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add Buying Request</a><br><br>
		 <table id="example1" border="0" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                               
                                </thead>
								<tbody>
								<?php 
								$pesan = DB::select("select * from csc_buying_request where by_role='3' and id_pembuat='".Auth::guard('eksmp')->user()->id."' order by id desc ");
								foreach($pesan as $ryu){
								?>
								<tr>
								<td><?php echo "<font size='4px'><b>".$ryu->subyek."</b></font><br>";
								$cardata = DB::select("select nama_kategori_en from csc_product where id='".$ryu->id_csc_prod_cat."'");
				 foreach($cardata as $ct){
					 echo $ct->nama_kategori_en."<br>";
				 }
				 echo "Valid until ".$ryu->valid." days<br>";
				 echo $ryu->date;
								?></td>
								<td width="20%"><center>
								<?php if($ryu->status == 0 || $ryu->status == null){ ?>
								<br><a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy(<?php echo $ryu->id; ?>)" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><i class="fa fa-wifi"></i> Broadcast</a><a title="Detail" href="{{ url('br_importir_detail/'.$ryu->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Detail&nbsp;&nbsp;&nbsp;</a>
								<?php }else if($ryu->status == 1 ){ ?>
								<br><a title="Detail" href="{{ url('br_importir_lc/'.$ryu->id) }}" class="btn btn-info"><i class="fa fa-comment"></i> List Chat</a>
								<?php } else if($ryu->status == 4){ ?>
								<br><a title="Detail" href="{{ url('br_importir_lc/'.$ryu->id) }}" class="btn btn-info"><i class="fa fa-comment"></i> List Chat</a>
								<?php } ?>
								</center></td>
								</tr>
								<?php } ?>
								
								</tbody>

                            </table>
	   <?php } else { ?>
	   <h5><center>Pemberitahuan</center></h5>
	   <br><br>
	   <h6><center>" Akun anda belum diverifikasi oleh Admin / Perwakilan, Silahkan Lengkapi Terlebih Dahulu Profil Anda <br><br>Klik <a href="{{url('profil2/3/'.Auth::guard('eksmp')->user()->id)}}">Disini</a> Untuk Melengkapi Profil Anda !
	   <br><br>Lalu Tunggu Sampai Admin / Perwakilan Meng-Verifikasi Akun Anda ! "</center></h6>
	   <?php } } else { ?>
	   <h5><center>Pemberitahuan</center></h5>
	   <br><br>
	   <h6><center>" Halaman Ini Khusus Untuk User Importir "</center></h6>
	   <?php } ?>
					<br>	
		
      </div>
    </div>
  </div>
</div>

 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Broadcast Buying Request</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
		<div id ="isibroadcast"></div>
        <!--<div class="modal-body">
          1
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
<script type="text/javascript">
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad/")}}/'+a,{_token:token},function(data){
			$("#isibroadcast").html(data);
			
		 })
}
  $(function () {
   $('#example1').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
	
	$('#example2').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
	
	$('#yahoo').DataTable({
     
    });

  $('.select2').select2();
 });
 </script>
<script type="text/javascript">
    $(function () {
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
    });
</script>

<!-- ############ SWITHCHER START-->
<div id="setting">
  <div class="setting dark-white rounded-bottom" id="theme">
    <a href="#" data-toggle-class="active" data-target="#theme" class="dark-white toggle">
      <i class="fa fa-gear text-primary fa-spin"></i>
    </a>
    <div class="box-header">
      <a href="https://themeforest.net/item/apply-web-application-admin-template/21072584?ref=flatfull" class="btn btn-xs rounded danger float-right">BUY</a>
      <strong>Theme Switcher</strong>
    </div>
    <div class="box-divider"></div>
    <div class="box-body">
      <p id="settingLayout">
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedAside">
          <i></i>
          <span>Fixed Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedContent">
          <i></i>
          <span>Fixed Content</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="folded">
          <i></i>
          <span>Folded Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="container">
          <i></i>
          <span>Boxed Layout</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="ajax">
          <i></i>
          <span>Ajax load page</span>
        </label>
        <label class="pointer my-1 d-block" data-toggle="fullscreen" data-plugin="screenfull" data-target="fullscreen">
          <span class="ml-1 mr-2 auto">
            <i class="fa fa-expand d-inline"></i>
            <i class="fa fa-compress d-none"></i>
          </span>
          <span>Fullscreen mode</span>
        </label>
      </p>
      <p>Colors:</p>
      <p>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="primary">
          <i class="primary"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="accent">
          <i class="accent"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="warn">
          <i class="warn"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="info">
          <i class="info"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="success">
          <i class="success"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="warning">
          <i class="warning"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="danger">
          <i class="danger"></i>
        </label>
      </p>
      <div class="row no-gutters">
        <div class="col">
          <p>Brand</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="brand" value="dark-white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="brand" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col mx-2">
          <p>Aside</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="aside" value="white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="aside" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col">
          <p>Themes</p>
          <div class="clearfix">
            <label class="radio radio-inline ui-check">
              <input type="radio" name="bg" value="">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline ui-check ui-check-color">
              <input type="radio" name="bg" value="dark">
              <i class="dark"></i>
            </label>
          </div>
        </div>
      </div>
      <p>Demos</p>
      <div class="text-md">
        <a href="dashboard.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">0</a>
        <a href="dashboard.1.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark-white" class="no-ajax badge light">1</a>
        <a href="dashboard.2.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=white" class="no-ajax badge light">2</a>
        <a href="dashboard.3.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">3</a>
        <a href="dashboard.4.html?folded=true&amp;bg=&amp;aside=dark" class="no-ajax badge light">4</a>
        <a href="dashboard.5.html?folded=true&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">5</a>
        <a href="dashboard.6.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">6</a>
        <a href="dashboard.7.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">7</a>
        <a href="dashboard.8.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">8</a>
        <a href="rtl.html?folded&amp;bg=" class="no-ajax badge light">RTL</a>
      </div>
    </div>
  </div>
</div>
<!-- ############ SWITHCHER END-->

<!-- build:js scripts/app.min.js -->
<!-- jQuery -->
  <script src="{{url('assets')}}/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
  <script src="{{url('assets')}}/libs/popper.js/dist/umd/popper.min.js"></script>
  <script src="{{url('assets')}}/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- core -->
  <script src="{{url('assets')}}/libs/pace-progress/pace.min.js"></script>
  <script src="{{url('assets')}}/libs/pjax/pjax.js"></script>

  <script src="{{url('assets')}}/html/scripts/lazyload.config.js"></script>
  <script src="{{url('assets')}}/html/scripts/lazyload.js"></script>
  <script src="{{url('assets')}}/html/scripts/plugin.js"></script>
  <script src="{{url('assets')}}/html/scripts/nav.js"></script>
  <script src="{{url('assets')}}/html/scripts/scrollto.js"></script>
  <script src="{{url('assets')}}/html/scripts/toggleclass.js"></script>
  <script src="{{url('assets')}}/html/scripts/theme.js"></script>
  <script src="{{url('assets')}}/html/scripts/ajax.js"></script>
  <script src="{{url('assets')}}/html/scripts/app.js"></script>
<!-- endbuild -->
</body>
</html>
