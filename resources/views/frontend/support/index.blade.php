@include('frontend.layouts.header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
</style>

<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                        <li><a href="#">@lang('frontend.history.ticket')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-divider m-0"></div>
        <div class="box-body bg-light">
          <div class="container">
          <h1> Support </h1>
          <br>
          <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-10">
            <div class="col-md-14"><br>
            <a id="tambah" href="{{route('front.supp.add')}}" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add</a>
              <table id="table" class="table table-bordered table-striped " data-plugin="dataTable">
                <thead class="text-white" style="background-color: #C4C4C4;">
                  <tr>
                    <th>Date</th>
                    <!-- <th>Email</th> -->
                    <th>Subject</th>
                    <th>Massages</th>
                    <!-- <th>Status</th> -->
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="col-sm-1"></div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModal3Label">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-3">
              <label>Date</label>
              </div>
              <div class="col-md-7">
                  <input type="text" autocomplete="off" class="form-control" id="viewdate" name="viewdate"
                          style="font-size: 14px;" required placeholder="Date">
              </div>
          </div>
          <br>
          <div class="row">
              <div class="col-md-3">
              <label>Subject</label>
              </div>
              <div class="col-md-7">
                  <input type="text" autocomplete="off" class="form-control" id="viewsubject" name="viewsubject"
                          style="font-size: 14px;" required placeholder="Subject">
              </div>
          </div>
          <br>
          <div class="row">
              <div class="col-md-3">
                  <label>Description</label>
              </div>
              <div class="col-md-7">
                  <textarea name="viewdesc" id='viewdesc' class="form-control" rows="8" cols="80"
                            title="@lang('inquiry.msg')" style="font-size: 14px;" required> Description </textarea>
              </div> 
          </div>
          <br>
          <div class="row">
              <div class="col-md-3">
                  <label>Screenshot</label>
              </div>
              <div class="col-md-7">
                  <span id='gambar'></span>
              </div>
          </div>
          <br>
          <div class="row" id="jawaban" style="display:none">
              <div class="col-md-3">
              <label>Subject</label>
              </div>
              <div class="col-md-7">
                  <input type="text" autocomplete="off" class="form-control" id="viewsubject" name="viewsubject"
                          style="font-size: 14px;" required placeholder="Subject">
              </div>
          </div>
          <br>
          <div class="row" id="ssan" style="display:none">
              <div class="col-md-3">
              <label>Subject</label>
              </div>
              <div class="col-md-7">
                  <input type="text" autocomplete="off" class="form-control" id="viewsubject" name="viewsubject"
                          style="font-size: 14px;" required placeholder="Subject">
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@include('frontend.layouts.footer')
<script type="text/javascript">
	$(function () {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.supp.data')}}",
            columns: [
			        {data: 'date', name: 'date'},/* 
				      {data: 'email', name: 'email'}, */
              {data: 'subject', name: 'subject'},
				      {data: 'desc', name: 'desc'},/* 
              {data: 'status', name: 'status'}, */
              {data: 'action', name:  'action', orderable: false, searchable: false}
            ]
        });
    });

    function modal(id){
      $('#modal').modal('show');
      var id = $("#"+id.id).data('item');
      
      $.post("{{route('front.supp.data.get')}}",{_token:"{{csrf_token()}}",id:id}, function(res){
          console.log(res);
          var b = JSON.parse(res);
          console.log(b);
          var a = b.date.split('-');

          //console.log(b.date);
          $('#viewdate').val(a[2]+'-'+a[1]+'-'+a[0]);
          $('#viewsubject').val(b.subject);
          $('#viewdesc').val(b.desc);
          $('#gambar').html('<img src="{{url("upload/support")}}/'+b.fileq+'"> ')

          if(b.answer){
            $('#answer').show();
            $('ssan').show();
          }
      });
    }

</script>
