@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#updated { background-color: #28bd4a; color: white; white-space: pre; height: 35px;}
	#updated:hover {background-color: #08b32e}
    .btn.donlod:hover,.btn.donlod:active,.btn.donlod{color: white;}
    /* Style the tab */
    .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab span {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      padding: 8px 10px;
      transition: 0.3s;
      font-size: 17px;
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
                    <h5> Data User Guide</h5>
                </div>
                <div class="box-body bg-light">
                    <form action="{{route('user-guide.update')}}" class="form-horizontal" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                        <table width="60%" border="0">
                            <tr>
                                <td width="20%" style="text-align:left !important; font-size: 14px; font-weight: 600; color: inherit;">User Guide</td>
                                <td width="20%">
                                  <select class="form-control" name="group" style="height: 37px;" required/>
                                    <option value="" style="display: none;">Select Group</option> 
                                    <option value="1" style="">Admin</option> 
                                    <option value="4" style="">Representative</option> 
                                    <option value="2" style="">Exporter</option> 
                                    <option value="3" style="">Buyer</option> 
                                  </select>
                                </td>
                                <td width="40%"><input type="file" class="form-control" name="file" accept="application/msword, application/pdf" required/></td>
                                <td width="15%" style="text-align:left !important; padding-left: 10px; padding-right: 10px;"><button type="submit" class="btn" id="updated">Update</button></td>
                            </tr>
                        </table>
                    </form>
                    <hr>
                    <div class="tab">
                        <span class="tablinks">History</span>
                    </div>
                    <div class="tabcontent" style="display: block;">
                        <div class="box-body">
                            <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
                                <thead class="text-white" style="background-color: #1089ff;">
                                  <tr>
                                      <th width="10%">No</th>
                                      <th>Group User</th>
                                      <th>Version</th>
                                      <th>Last Update</th>
                                      <th width="15%">Action</th>
                                  </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
<script type="text/javascript">
	$(document).ready(function () {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user-guide.getData') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'group', name: 'group'},
                {data: 'name_version', name: 'name_version', orderable: false},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>