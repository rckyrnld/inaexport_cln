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
    #set_reminder.nav-link.active, #set_inquiry.nav-link.active {
        background-color: #40bad2 !important;
        color: white !important;
    }

</style>
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-bottom">
                <h3 class="mb-0">List Inquiry</h3>
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
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#reminder" id="set_reminder" data-toggle="tab"><h5><b>Reminder</b></h5></a></li>
                        <li class="nav-item"><a class="nav-link" href="#inquiry" id="set_inquiry" data-toggle="tab"><h5><b>Inquiry</b></h5></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="reminder">
                            <br>
                            <div class="table-responsive">
                                <table id="tablereminder" class="table table-striped table-hover" style="text-transform: capitalize;">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                    <tr>
                                        <th width="5%">
                                            <center>No</center>
                                        </th>
                                        <th>
                                            <center>Created By</center>
                                        </th>
                                        <th>
                                            <center>Creater Status</center>
                                        </th>
                                        <th>
                                            <center>Subject</center>
                                        </th>
                                        <th>
                                            <center>Date</center>
                                        </th>
                                        <!-- <th>
                                            <center>Kind of Subject</center>
                                        </th> -->
                                        <th>
                                            <center>Duration</center>
                                        </th>
                                        <th>
                                            <center>Origin</center>
                                        </th>
                                        <th width="20%">
                                            <center>Action</center>
                                        </th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="inquiry">
                            <br>
                            <div class="table-responsive">
                                <table id="tableinquiry" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                    <tr>
                                        <th width="5%">
                                        <center>No</center>
                                        </th>
                                        <th>
                                        <center>Category Product</center>
                                        </th>
                                        <th>
                                            <center>Created By</center>
                                        </th>
                                        <th>
                                            <center>Creater Status</center>
                                        </th>
                                        <th>
                                        <center>Subject</center>
                                        </th>
                                        <th>
                                        <center>Date</center>
                                        </th>
                                        <!-- <th>
                                        <center>Kind Of Subject</center>
                                        </th> -->
                                        <th width="15%">
                                        <center>Messages</center>
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

<script>
    $(document).ready(function () {
        $('#tablereminder').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('eksportir.inquiry.getData', 1) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
               {data: 'created_by', name: 'created_by'},
               {data: 'creater_status', name: 'creater_status'},
                {data: 'subject', name: 'subject'},
                {data: 'date', name: 'date'},
				 {data: 'duration', name: 'duration'},
               /* {data: 'kos', name: 'kos'}, */
                {data: 'origin', name: 'origin'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });

        $('#tableinquiry').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('eksportir.inquiry.getData', 2) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category', name: 'category'},
               {data: 'created_by', name: 'created_by'},
               {data: 'creater_status', name: 'creater_status'},
                {data: 'subject', name: 'subject'},
                {data: 'date', name: 'date'},
              /*  {data: 'kos', name: 'kos'}, */
                {data: 'msg', name: 'msg'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
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