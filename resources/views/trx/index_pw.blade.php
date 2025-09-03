@extends('header2')
@section('content')
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
    .select2-container .select2-selection--single {
      box-sizing: border-box;
      cursor: pointer;
      display: block;
      height: 45px !important;
    }
    .custom-select, .custom-file-control, .custom-file-control:before, select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
      height: 45px !important;
    }

</style>
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-bottom">
                <h3 class="mb-0">Selling Transaction Admin</h3>
            </div>
            <div class="card-body">
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
                <div class="tab">
                  <button class="tablinks active" onclick="openCity(event, 'London')"><font size="3px">Selling</font></button>
                  <button class="tablinks" onclick="openCity(event, 'Paris')"><font size="3px">Report</font></button>
                </div>
                <div id="London" class="tabcontent" style="display:block;">
                  <div class="table-responsive">
                    <table id="example1" class="table table-striped table-hover">
                      <thead class="text-white" style="background-color: #C4C4C4;">
                      <tr>
                          <th>No</th>
        
                          <th>
                              <center>Origin</center>
                          </th>
                          <th>
                              <center>Buyer</center>
                          </th>
                          <th>
                              <center>Indonesian Exporter</center>
                          </th>
        
                          <th>
                              <center>Type Tracking</center>
                          </th>
                          <th>
                              <center>No Tracking</center>
                          </th>
                          <th>
                              <center>Link Tracking</center>
                          </th>
                          <th>
                              <center>Status</center>
                          </th>
                          <th>
                              <center>Created At</center>
                          </th>
                          <th width="18%">
                              <center>Action</center>
                          </th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php $nt = 1; foreach($data as $ruu){ ?>
                        <tr>
                          <td><?php echo $nt; ?></td>
                          <td>
                            <div align="left"><?php if($ruu->origin == 1){ echo "Inquiry"; }else if($ruu->origin == 2){ echo "Buying Request"; }?></div>
                          </td>
                          <td>
                            <div align="left"><?php if($ruu->by_role == 1){ echo "Admin"; }else if($ruu->by_role == 4){ echo "Perwakilan"; }else{ 
                              $usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$ruu->id_pembuat."'"); 
                              foreach($usre as $imp){ echo "".$imp->badanusaha." ".$imp->company; }
                              } ?>
                            </div>
                          </td>
                          <td>
                            <div align="left"><?php 
                              if($ruu->id_eksportir == 0 || $ruu->id_eksportir == null){
                              }else{
                              $carieks = DB::select("select b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil=b.id and a.id='".$ruu->id_eksportir."'");
                              foreach($carieks as $eks){ echo $eks->badanusaha." ".$eks->company; }
                              } ?>
                            </div>
                          </td>
                          <td>
                            <center><?php echo $ruu->type_tracking; ?></center>
                          </td>
                          <td>
                            <center><?php echo $ruu->no_tracking; ?></center>
                          </td>
                          <td>
                            <center><?php echo '<a target="_blank" href="'.$ruu->link_tracking.'">'.$ruu->link_tracking.'</a>'; ?></center>
                          </td>
                          <td>
                            <center><?php if($ruu->status_transaksi == 1){ echo "<span class='badge bg-success' style='color: #fff;'>Already Sent</span>"; }else{ echo "<span class='badge bg-danger' style='color: #fff;'>On Process</span>"; } ?></center>
                          </td>
                          <td>
                            <center><?php if($ruu->status_transaksi == 1){ echo "<font >".$ruu->created_at."</font>"; }else{ echo " "; } ?></center>
                          </td>
                          <td>
                            <?php if($ruu->status_transaksi == 1){ ?>
                            {{--<a href="{{ url('br_trx2/'.$ruu->id_transaksi) }}" class="btn btn-info"><font color="white"><i class="fa fa-list"></i>&nbsp; View</font></a>--}}
                              <a href="{{ url('br_trx2/'.$ruu->id_transaksi) }}" class="btn btn-info" data-toggle="tooltip" title="View"><font color="white"><i class="fa fa-eye"></i></font></a>
                            <?php }else { ?>
                            {{--<a href="{{ url('br_trx2/'.$ruu->id_transaksi) }}" class="btn btn-success"><font color="white"><i class="fa fa-truck"></i>&nbsp; Send</font></a>--}}
                            <a href="{{ url('br_trx2/'.$ruu->id_transaksi) }}" class="btn btn-success" data-toggle="tooltip" title="Send"><font color="white"><i class="fa fa-truck"></i></font></a>
                            <center>
                            <?php } ?>
                            </center>
                          </td>
                        </tr>
                        <?php $nt++; } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div id="Paris" class="tabcontent">
                  <div class="box-body">
                    <div class="form-row">
                      <div class="form-group col-sm-2">
                        <b>Buyer</b>
                      </div>
                      <div class="form-group col-sm-3">
                        <select id="buyer" name="buyer" class="form-control">
                          <option value="0">- All -</option>
                          <option value="1">Admin</option>
                          <option value="4">Representative</option>
                          <option value="3">Importer</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-2">
                        <b>Source</b>
                      </div>
                      <div class="form-group col-sm-3">
                        <select id="origin" name="origin" class="form-control">
                          <option value="0">- All -</option>
                          <option value="2">Buying Request</option>
                          <option value="1">Inquiry</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-2">
                        <b></b>
                      </div>
                      <div class="form-group col-sm-2">
                        <a onclick="ambillist()" class="btn btn-info"><font color="white">&nbsp;Search&nbsp;&nbsp;</font></a>
                      </div>
                    </div>
                    <hr>
                    <br>
                    <div align="right">
                      <center><h5>List Transaction</h5></center><div id="btx"><!-- <a class="btn btn-success" style="font-align:right;"><font color="white"><i class="fa fa-download"></i> Export Excel</font></a>--></div>
                    </div>
                    <br>
                    <div class="form-row"><br>
                      <br>
                      <table id="example2s" class="table table-striped table-hover">
                        <thead class="text-white" style="background-color: #C4C4C4;">
                          <tr>
                              <th>No</th>
                            <th>
                              <center>Origin</center>
                            </th>
                            <th>
                              <center>Buyer</center>
                            </th>
                            <th>
                              <center>Indonesian Exporter</center>
                            </th>
                            <th>
                              <center>Type Tracking</center>
                            </th>
                            <th>
                              <center>No Tracking</center>
                            </th>
                            <th>
                              <center>Status</center>
                            </th>
                          </tr>
                        </thead>
                        <tbody id="ambillist"></tbody>
                      </table>
                    </div>
                  </div>
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
  function ambillist(){
    var buyer = $('#buyer').val();
    var origin = $('#origin').val();
    var cetakurl = '{{URL::to("cetaktrx/")}}/'+buyer+'/'+origin;
    $("#btx").html('<a href="'+cetakurl+'" class="btn btn-success" style="font-align:right;"><font color="white"><i class="fa fa-download"></i> Export Excel</font></a>');
    var token = $('meta[name="csrf-token"]').attr('content');
      $.get('{{URL::to("caritab/")}}/'+buyer+'/'+origin,{_token:token},function(data){
        $("#ambillist").html(data);
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
      {data: 'f6', name: 'f6', orderable: false, searchable: false },
      {data: 'f7', name: 'f7', orderable: false, searchable: false},
      {data: 'action', name: 'action', orderable: false, searchable: false
      }
    ],
    "language": {
      "paginate": {
        "previous": "<i class='fa fa-angle-left'/></>",
        "next": "<i class='fa fa-angle-right'/></>"
      }
    }
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
      {data: 'f6', name: 'f6', orderable: false, searchable: false},
      {data: 'f7', name: 'f7', orderable: false, searchable: false},
      {data: 'action', name: 'action', orderable: false, searchable: false }
      ],
      "language": {
      "paginate": {
          "previous": "<i class='fa fa-angle-left'/></>",
          "next": "<i class='fa fa-angle-right'/></>"
        }
      }
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
    }],
    "language": {
      "paginate": {
          "previous": "<i class='fa fa-angle-left'/></>",
          "next": "<i class='fa fa-angle-right'/></>"
        }
    }
  });
});
</script>



@include('footer')

@endsection