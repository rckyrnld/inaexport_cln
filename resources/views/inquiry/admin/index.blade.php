@extends('header2')
@section('content')
    <style>
        #set_admin.nav-link.active,
        #set_perwakilan.nav-link.active,
        #set_importir.nav-link.active {
            background-color: #40bad2 !important;
            color: white !important;
        }

        /*CSS MODAL*/
        .modal-lg {
            width: 700px;
        }

        .modal-header {
            background-color: #84afd4;
            color: white;
            font-size: 20px;
            text-align: center;
        }

        .modal-body {
            height: 250px;
        }

        .modal-content {
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            overflow: hidden;
        }

        .modal-footer {
            background-color: #84afd4;
            color: white;
            font-size: 20px;
            text-align: center;
        }
        .card {
            background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
        }
        .card-header {
            background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                {{-- <div class="box-divider m-0"></div> --}}
                {{-- <div class="box-header bg-light">
                    <h5><i></i> List Inquiry</h5><br>
                    <a class="btn" href="{{ url('/inquiry_admin/create') }}"
                        style="background-color: #1089ff; color: white;"><i class="fa fa-plus-circle"></i> Add</a>
                </div> --}}
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Inquiry</h3><br>

                </div>
                <div class="card-body"">
                        <a class=" btn" href="{{ url('/inquiry_admin/create') }}"
                    style="background-color: #1089ff; color: white;"><i class="fa fa-plus-circle"></i> Add</a>
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
                    {{-- <div class="col-md-14"> --}}
                    <div class="nav-wrapper">
                        {{-- <div id="exTab2" class="container"> --}}
                        {{-- <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" href="#admin" id="set_admin"
                                        data-toggle="tab">
                                        <h6><b>Admin</b></h6>
                                    </a></li>
                                <li class="nav-item"><a class="nav-link" href="#perwakilan" id="set_perwakilan"
                                        data-toggle="tab">
                                        <h6><b>Representative</b></h6>
                                    </a></li>
                                <li class="nav-item"><a class="nav-link" href="#importir" id="set_importir"
                                        data-toggle="tab">
                                        <h6><b>Buyer</b></h6>
                                    </a></li>
                            </ul> --}}
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                                    href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                                    aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                                    href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                                    aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>Representative</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                                    href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3"
                                    aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>Buyer</a>
                            </li>
                        </ul>
                    </div>
                    {{-- <div class="tab-content">
                    <div class="tab-pane active" id="admin">
                        <br> --}}
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                            aria-labelledby="tabs-icons-text-1-tab">
                            <div class="table-responsive">
                                <table id="tableadmin" class="table  align-items-center table-striped table-hover"
                                    style="text-transform: capitalize;">
                                    <thead class="text-white" style="background-color: #1089ff;">
                                        <tr>
                                            <th width="5%">
                                                <center>No</center>
                                            </th>
                                            <th>
                                                <center>Category Product</center>
                                            </th>
                                            <th>
                                                <center>Subject</center>
                                            </th>
                                            <th>
                                                <center>Date</center>
                                            </th>
                                            <th>
                                                <center>Kind Of Subject</center>
                                            </th>
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
                        <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                            aria-labelledby="tabs-icons-text-2-tab">
                            <div class="table-responsive">
                                <table id="tableperwakilan" class="table  align-items-center table-striped table-hover">
                                    <thead class="text-white" style="background-color: #1089ff;">
                                        <tr>
                                            <th width="5%">
                                                <center>No</center>
                                            </th>
                                            <th>
                                                <center>Representative Name</center>
                                            </th>
                                            <th>
                                                <center>Category Product</center>
                                            </th>
                                            <th>
                                                <center>Subject</center>
                                            </th>
                                            <th>
                                                <center>Date</center>
                                            </th>
                                            <th>
                                                <center>Kind Of Subject</center>
                                            </th>
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
                        <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                            aria-labelledby="tabs-icons-text-3-tab">
                            <div class="table-responsive">
                                <table id="tableimportir" class="table  align-items-center table-striped table-hover"
                                    style="text-transform: capitalize;">
                                    <thead class="text-white" style="background-color: #1089ff;">
                                        <tr>
                                            <th width="5%">
                                                <center>No</center>
                                            </th>
                                            <th>
                                                <center>Company Name</center>
                                            </th>
                                            <th>
                                                <center>Category Product</center>
                                            </th>
                                            <th>
                                                <center>Subject</center>
                                            </th>
                                            <th>
                                                <center>Date</center>
                                            </th>
                                            <th>
                                                <center>Kind Of Subject</center>
                                            </th>
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

    <!-- The Modal -->
    <div class="modal fade" id="modalBroadcast">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4>
                        <center><b>Broadcast Inquiry</b></center>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                        action="{{ url('/inquiry_admin/broadcasting') }}" id="formnya">
                        {{ csrf_field() }}
                        <br><br>
                        <div class="row">
                            <div class="col-md-3">
                                <label style="font-size: 15px;"><b>Subject</b></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="subjectnya" id="subjectnya" class="form-control" readonly>
                                <input type="hidden" name="idnya" id="idnya" class="form-control">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-3">
                                <label style="font-size: 15px;"><b>Category Product</b></label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control" id="categori" style="width: 100% !important;" width="90%"
                                    name="categori[]" multiple="multiple" required>{{ optionCategory() }}
                                </select>
                            </div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <center>
                                    <button type="submit" class="btn btn-primary"
                                        style="width: 20%; margin-right: 4%;">Send</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                        style="width: 20%;">Close</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">

                </div>

            </div>
        </div>
    </div>

    @include('footer')

    <script>
        $(document).ready(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#tableadmin').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.inquiry.getDataAdmin') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'kos',
                        name: 'kos'
                    },
                    {
                        data: 'msg',
                        name: 'msg'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });

            $('#tableperwakilan').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.inquiry.getPerwakilan') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'kos',
                        name: 'kos'
                    },
                    {
                        data: 'msg',
                        name: 'msg'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });

            $('#tableimportir').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.inquiry.getDataImportir') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'kos',
                        name: 'kos'
                    },
                    {
                        data: 'msg',
                        name: 'msg'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });

            //kategori broadcast
            $('#categori').select2({
                sorter: function(data) {
                    return data.sort(function(a, b) {
                        return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                    });
                }
            }).on("select2:select", function(e) {
                $('.select2-selection__rendered li.select2-selection__choice').sort(function(a, b) {
                    return $(a).text() < $(b).text() ? -1 : $(a).text() > $(b).text() ? 1 : 0;
                }).prependTo('.select2-selection__rendered');
            });
        });

        function broadcastInquiry(isi) {
            var isi = isi.split('|');
            var id = parseInt(isi[1]);
            var subject = isi[0];

            $('#idnya').val(id);
            $('#subjectnya').val(subject);
            $('#modalBroadcast').modal('show');
        }
    </script>
@endsection
