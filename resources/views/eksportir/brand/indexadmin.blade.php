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
                    <h3 class="mb-0">List Brand</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    <div class="table-responsive">

                        <table id="tablebrands" class="table  table-bordered table-striped">
                            <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        Brand
                                    </th>
                                    <th>
                                        <center>Meaning Of Brand</center>
                                    </th>
                                    <th>
                                        <center>Month</center>
                                    </th>
                                    <th>
                                        <center>Year</center>
                                    </th>
                                    <th>
                                        <center>Copyright Number</center>
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
            $('#tablebrands').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('eksportir/brand_getdata_admin/' . $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'merek',
                        name: 'merek'
                    },
                    {
                        data: 'arti_merek',
                        name: 'arti_merek'
                    },
                    {
                        data: 'bulan_merek',
                        name: 'bulan_merek'
                    },
                    {
                        data: 'tahun_merek',
                        name: 'tahun_merek'
                    },
                    {
                        data: 'paten_merek',
                        name: 'paten_merek'
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
