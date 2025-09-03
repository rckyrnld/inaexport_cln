@extends('header2')
@section('content')
    <style type="text/css">
        th {
            text-align: center;
        }

        #tambah {
            background-color: #1a9cf9;
            color: white;
            white-space: pre;
        }

        #tambah:hover {
            background-color: #148de4
        }

        #export {
            background-color: #28bd4a;
            color: white;
            white-space: pre;
        }

        #export:hover {
            background-color: #08b32e
        }

        table th {
            width: auto !important;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Training Ekspor</h3>
                </div>
                <div class="card-body pl-0 pr-0">
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
                    @if (Auth::user()->id_group == 11)
                    @else
                        <a id="tambah" href="{{ route('training.create.admin') }}" class="btn ml-4"><i
                                class="fa fa-plus-circle"></i> Add </a>
                    @endif
                    <br><br>
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped table-hover" data-plugin="dataTable">
                            <thead class="text-white" style="background-color:#6B7BD6;">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="5%">Training</th>
                                    <th style="width:5px !important">Topic</th>
                                    <th width="5%">Location</th>
                                    <th width="20%">Date</th>
                                    <th width="20%">Duration</th>
                                    <th width="20%">Status</th>
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
    <script type="text/javascript">
        $(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('training.getData.admin') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'training_en',
                        name: 'training_en'
                    },
                    {
                        data: 'topic_en',
                        name: 'topic_en',
                    },
                    {
                        data: 'location_en',
                        name: 'location_en'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
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
                columnDefs: [{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width-300px'>" + data + "</div>";
                    },
                    targets: 1
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:250px'>" + data + "</div>";
                    },
                    targets: 2
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:200px'>" + data + "</div>";
                    },
                    targets: 3
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:80px'>" + data + "</div>";
                    },
                    targets: 4
                }, {
                    width: 30,
                    targets: 0
                }, {
                    width: 100,
                    targets: -1
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
