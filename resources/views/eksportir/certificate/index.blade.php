@extends('header2')
@section('content')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
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

        .modal-md {
            width: 600px;
        }

        .style-font {
            font-size: 18px;
            font-weight: 700;
            color: black;
        }

        #broadcast {
            background-color: #29bbd8;
        }

        #broadcast:hover {
            background-color: #1cabc7;
        }

        #close {
            background-color: #f92222;
        }

        #close:hover {
            background-color: #f10000;
        }

        .toggle.btn.btn-info {
            width: 50% !important;
        }

        .toggle.btn.btn-default.off {
            width: 50% !important;
        }

        #tambah {
            background-color: #1a9cf9;
            color: white;
            white-space: pre;
        }

        #tambah:hover {
            background-color: #148de4
        }

    </style>

    {{-- <div class="container"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Sertifikat</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    <div class="tab-content p-3 mb-3">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block" style="text-align: center">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block" style="text-align: center">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <a id="tambah" href="{{ url('/eksportir/certificate_create') }}" style="background-color: #6B7BD6;" 
                        class="btn btn-primary pl-2 ml-4"> <i
                                class="fa fa-plus-circle"></i> Add </a>

                        <div class="table-responsive pt-4 pl-0 pr-0">
                            <table id="table" class="table align-items-center table-striped table-hover"
                                data-plugin="dataTable">
                                <thead class="text-white" style="background-color: #6B7BD6;">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sertfikat</th>
                                        <th>Gambar</th>
                                        <th>No Referensi</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Action</th>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $(".alert").not("#alert_box").slideDown(300).delay(2000).slideUp(500);
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('certificate.getData') }}",

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'no_ref',
                        name: 'no_ref'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'type',
                        name: 'type'
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
                        return "<div class='text-wrap' style='width:100px'>" + data + "</div>";
                    },
                    targets: 1
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:200px'>" + data + "</div>";
                    },
                    targets: 2
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
