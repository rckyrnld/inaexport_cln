{{-- @include('header') --}}
@extends('header2')
@section('content')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
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

        .table th {
            color: white;
            text-align: center;
        }

    </style>
    &nbsp;

    {{-- <div class="container"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                {{-- <div class="box-header">
                </div> --}}
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Local Time</h3>
                </div>
                <div class="card-body pl-0 pr-0">
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
                    {{-- <a id="tambah" href="{{ route('localtime.create') }}" class="btn pl-3 ml-4"><i
                            class="fa fa-plus-circle"></i>&nbsp;Add</a> --}}

                    <div class="table-responsive pt-4 pl-0 pr-0">
                        <table id="table" class="table align-items-center table-striped table-hover"
                            data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Country</th>
                                    <th>Time difference between<br/>  Indonesian Capital (Hours)</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                        </table>
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
                ajax: "{{ route('localtime.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'country',
                        name: 'country',
                        width: 100,
                        className: "text-center"
                    },
                    {
                        data: 'selisih_waktu',
                        name: 'selisih_waktu',
                        width: 5,
                        className: "text-center"
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
                    // render: function(data, type, full, meta) {
                    //     return "<div class='text-wrap' style='width:500px'>" + data + "</div>";
                    // },
                    // targets: 1
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
