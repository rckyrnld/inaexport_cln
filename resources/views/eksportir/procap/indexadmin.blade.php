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
            background-color: #148de4;
        }

        #export {
            background-color: #28bd4a;
            color: white;
            white-space: pre;
        }

        #export:hover {
            background-color: #08b32e;
        }

        .table th {
            color: white;
            text-align: center;
        }

    </style>
    <!-- Page content -->
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Production Capacity</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    <div class="table-responsive">
                        <table id="tableprocap" class="table  table-bordered table-striped">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>
                                            Year
                                        </center>
                                    </th>
                                    <th>
                                        <center>Own Production (%)</center>
                                    </th>
                                    <th>
                                        <center>Outside Production (%)</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>

                        </table>
                        <br>
                        <a style="color: white" href="{{ url('eksportir/listeksportir/' . $id) }}"
                            class="btn btn-danger pull-right"><i style="color: white"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <script>
        $(function() {
            $('#tableprocap').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('eksportir/product_capacity_getdata_admin/' . $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'sendiri_persen',
                        name: 'sendiri_persen'
                    },
                    {
                        data: 'outsourcing_persen',
                        name: 'outsourcing_persen'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: 40,
                        className: "text-center"
                    }
                ]
            });
        });
    </script>
@endsection
