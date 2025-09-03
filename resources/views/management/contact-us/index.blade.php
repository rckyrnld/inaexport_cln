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

        /* .card {
                    background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                }
                .card-header {
                    background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                } */

        #table th {
            color: white;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Contact Us</h3>
                </div>
                <div class="card-body pl-0">
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
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-hover" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th width="7%">No</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th width="14%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#2e899e; color:white;">
                    <h6>Broadcast Buying Request</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div id="isibroadcast"></div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".alert").slideDown(300).delay(1000).slideUp(300);
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('management.contact-us.getData') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            width: 5,
                            className: "text-center"
                        },
                        {
                            data: 'fullname',
                            name: 'fullname'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'subyek',
                            name: 'subyek'
                        },
                        {
                            data: 'message',
                            name: 'message'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            width: 40,
                            className: "text-center"
                        }
                    ],
                    columnDefs: [{
                        render: function(data, type, full, meta) {
                            return "<div class='text-wrap' style='width:290px'>" + data + "</div>";
                        },
                        targets: 4
                    }, {
                        render: function(data, type, full, meta) {
                            return "<div class='text-wrap' style='width:180px'>" + data + "</div>";
                        },
                        targets: 3
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
