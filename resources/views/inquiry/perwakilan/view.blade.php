@include('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <label class="col-md-10">
                            <h5><b>Details Inquiry</b></h5>
                        </label>
                        <div class="col-md-2">
                            <a href="{{url('/inquiry_perwakilan/')}}" class="btn btn-danger" style="float: right;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back</a>
                        </div>
                    </div><br><br>
                    <?php $category = getProductCategoryInquiry($data->id);
                        if($category != ''){
                            if($category == strip_tags($category)) {
                                $category = substr($category, 2);
                            }
                        }
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <label><b>Product Name</b></label>
                        </div>
                        <div class="col-md-4">
                            {{$data->prodname}}
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label><b>Product Category</b></label>
                        </div>
                        <div class="col-md-4">
                            <span style="text-transform: capitalize;">@if($category =='') - @else <?php echo $category?> @endif</span>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label><b>Kind of Subject</b></label>
                        </div>
                        <div class="col-md-4">
                            <span style="text-transform: capitalize;">{{$data->jenis_perihal_en}}</span>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label><b>Date</b></label>
                        </div>
                        <div class="col-md-4">
                            {{date('d F Y H:i', strtotime($data->date))}}
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label><b>Subject</b></label>
                        </div>
                        <div class="col-md-4">
                            {{$data->subyek_en}}
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label><b>Messages</b></label>
                        </div>
                        <div class="col-md-7">
                            <?php echo $data->messages_en; ?>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label><b>File</b></label>
                        </div>
                        <div class="col-md-4">
                            @if($data->file == "")
                                <input type="text" class="btn btn-default" value="Dokumen Kosong" autocomplete="off" readonly style="color: orange; text-align: center;">
                            @else
                                <a href="{{ url('/') }}/uploads/Inquiry/{{$data->id}}/{{ $data->file }}" target="_blank" class="btn btn-default" style="color: orange;"><i class="fa fa-download"></i>&nbsp;{{ $data->file }} </a>
                            @endif
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label><b>Duration</b></label>
                        </div>
                        <div class="col-md-4">
                            <span style="text-transform: capitalize;">
                                @if($data->duration != "None")
                                    Valid for {{$data->duration}}
                                @else
                                    {{$data->duration}}
                                @endif
                            </span>
                        </div>
                    </div><br><br>
                    <div class="row">
                        <label class="col-md-12">
                            <h5><b>List Company / Eksportir</b></h5>
                        </label>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tablecompany" class="table  table-bordered table-striped" style="text-transform: capitalize;">
                                    <thead class="text-white" style="background-color: #1089ff;">
                                        <tr>
                                          <th width="5%">
                                            <center>No</center>
                                          </th>
                                          <th>
                                            <center>Company</center>
                                          </th>
                                          <th>
                                            <center>Date</center>
                                          </th>
                                          <th>
                                            <center>Status</center>
                                          </th>
                                          <th width="20%">
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
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#tablecompany').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('perwakilan.inquiry.getDataCompany', $data->id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'company', name: 'company'},
                {data: 'date', name: 'date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>

@include('footer')
