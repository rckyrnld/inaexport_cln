{{-- @include('header') --}}
@extends('header2')
@section('content')
    <style type="text/css">
        th {
            text-align: center;
        }

        td {
            color: black;
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
    </style>
    <!-- Page content -->
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                {{-- <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <!-- Header Title -->
                </div> --}}
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List CS Admin</h3>
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
                    <div class="table-responsive pt-4">
                        <table id="table" class="table align-items-center table-flush table-hover table-striped" data-plugin="dataTable">
                            <thead class="text-white" style="background-color:#6B7BD6;">
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Messages</th>
                                    <th>Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    @include('footer')
    <script type="text/javascript">
        $(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ticket_support.getData.admin') }}",
                
                columns: [{
                        data: 'row',
                        name: 'row',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'subyek',
                        name: 'subyek',
                    },
                    {
                        data: 'main_messages',
                        name: 'main_messages'
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
                        return "<div class='text-wrap' style='width:100px !important'>" + data + "</div>";
                    },
                    targets: 1
                }, { 
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap width-100'>" + data + "</div>";
                    },
                    targets: 3
                }, { 
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap width-20'>" + data + "</div>";
                    },
                    targets: 4    
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap width-100'>" + data + "</div>";
                    },
                    targets: 5
                },{
                    width: 70,
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
@endsection