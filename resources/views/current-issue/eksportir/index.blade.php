@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Market Research</h5>
                </div>
                <div class="box-body bg-light">
                    <div class="col-md-14">
		          	 <div class="table-responsive">
					    <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable" style="text-align: center;">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th width="7%">No</th>
					              <th>Title (EN)</th>
					              <th>Type</th>
					              <th>Country</th>
					              <th>Publish Date</th>
					              <th width="23%">Action</th>
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
	$(document).ready(function() {
		$('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('research-corner.getData') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title_en', name: 'title_en'},
                {data: 'type', name: 'type'},
                {data: 'country', name: 'country'},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

	});

    function cek_download(id, e, obj){
      e.preventDefault(); 
      $.ajax({
            url: "{{route('research-corner.download')}}",
            type: 'get',
            data: {id:id},
            dataType: 'json',
            success:function(response){
              if(response == 'nihil'){
                window.open(obj.href, '_blank');
              } else {
                alert('The document has been downloaded');
                location.reload();
              }
            }
        });
    }
</script>