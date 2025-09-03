@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
    .btn-eye:active, .btn-eye:hover{ color: white; }
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Buyer</h5>
                </div>

                <div class="box-body bg-light">
                	<button id="tambah" data-toggle="modal" data-target="#modal-filter" class="btn">   <i class="fa fa-filter"></i>  Filter   </button>

                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th>No</th>
                                  <th>Name</th>
					              <th>Country</th>
					              <th width="20%">Action</th>
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

<!-- modal Filter -->
    <div class="modal fade" id="modal-filter" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Filter Buyer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table width="100%" cellpadding="5">
                <tr>
                    <td>Name</td>
                    <td><input type="text" class="form-control" id="name"></td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>
                        <select id="country" class="form-control" style="width: 100%;">
                            <option></option>
                            @foreach($country as $data)
                                <option value="{{$data->id}}">{{$data->country}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="filter" class="btn btn-primary">View</button>
          </div>
        </div>
      </div>
    </div>
@include('footer')
<script type="text/javascript">
	$(document).ready(function () {
        var token = "{{ csrf_token() }}";
        
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            "ajax": {
                "url" : "{{ route('directory.getData') }}",
                "type" : "POST",
                "data" : {
                    '_token' : token,
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'country', name: 'country'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#country').select2({ placeholder: 'Select Country', allowClear: true });

        $('#filter').click(function(){
            $('#modal-filter').modal('hide');
            var name = $('#name').val();
            var country = $('#country').val();
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                destroy: true,
                "ajax": {
                    "url" : "{{ route('directory.getData') }}",
                    "type" : "POST",
                    "data" : {
                        '_token' : token,
                        "country" : country,
                        "name" : name
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'country', name: 'country'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });

    });
</script>