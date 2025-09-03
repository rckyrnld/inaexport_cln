@include('header')
<style>
    #set_reminder.nav-link.active, #set_inquiry.nav-link.active {
        background-color: #40bad2 !important;
        color: white !important;
    }
    /*CSS MODAL*/
    .modal-lg{ width: 700px; }
    .modal-header { background-color: #84afd4; color: white; font-size: 20px; text-align: center;}
    .modal-body{ height: 300px; }
    .modal-content { border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border-top-left-radius: 20px; border-top-right-radius: 20px; overflow: hidden;}
    .modal-footer { background-color: #84afd4; color: white; font-size: 20px; text-align: center;}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <div class="row">
                        <div class="col-md-10">
                            <h5><i></i> List Inquiry : {{getPerwakilanName($id)}}</h5>
                        </div>
                        <div class="col-md-2">
                            <a href="{{url('/inquiry_admin')}}" class="btn btn-danger" style="float: right;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                </div>
                <div class="box-body bg-light">
                    <div class="col-md-14">
                        <div class="table-responsive">
                            <table id="tableinquiry" class="table  table-bordered table-striped" style="text-transform: capitalize;">
                                <thead class="text-white" style="background-color: #1089ff;">
                                    <tr>
                                      <th width="5%">
                                        <center>No</center>
                                      </th>
                                      <th>
                                        <center>Category</center>
                                      </th>
                                      <th>
                                        <center>Subject</center>
                                      </th>
                                      <th>
                                        <center>Date</center>
                                      </th>
                                      <th>
                                        <center>Status</center>
                                      </th>
                                      <th>
                                        <center>Action</center>
                                      </th>
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

<script>
    $(document).ready(function () {
        $('#tableinquiry').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.inquiry.getDataPerwakilan', $id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category', name: 'category'},
                {data: 'subject', name: 'subject'},
                {data: 'date', name: 'date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>