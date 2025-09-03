{{-- @include('header') --}}
@extends('header2')
<link rel="stylesheet" href="{{ url('/') }}/vendor/datatable/dataTables.responsive.css" type="text/css" />
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

        .table th {
            color: white;
            text-align: center;
        }

        table.dataTable.dtr-inline.collapsed tbody td:first-child:before {
            top: 14px;
        }

        .hidden_plus:before {
            display: none !important;
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
                    <h3 class="mb-0">List Product</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    <div class="">
                        <table id="tablebrands" class="table table-striped table-hover display responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Code</center>
                                    </th>
                                    <th>
                                        <center>Product Name</center>
                                    </th>
                                    <th class="none">
                                        <center>Color</center>
                                    </th>
                                    <th class="none">
                                        <center>Size</center>
                                    </th>
                                    <th class="none">
                                        <center>Raw Material</center>
                                    </th>
                                    <th>
                                        <center>Capacity</center>
                                    </th>
                                    <th>
                                        <center>Price (USD)</center>
                                    </th>
                                    <th>
                                        <center>Description Product</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
                                    <th>
                                        <center>Information</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>

                        </table>
                        <br>
                        <div class="offset-lg-11">
                            <a style="color: white" href="{{ url('eksportir/listeksportir/' . $id_profil) }}"
                                class="btn btn-danger"><i style="color: white"></i>
                                Back
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    @include('footer')
    <script src="{{ url('/') }}/vendor/datatable/dataTables.responsive.js"></script>
    <script>
        $(document).ready(function() {
            let myTable = $('#tablebrands').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                scrollX: true,
                responsive: true,
                ajax: "{{ route('datatables.eksproduct_admin', $id_profil) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'code_en',
                        name: 'code_en'
                    },
                    {
                        data: 'prodname_en',
                        name: 'prodname_en'
                    },
                    {
                        data: 'color_en',
                        name: 'color_en'
                    },
                    {
                        data: 'size_en',
                        name: 'size_en'
                    },
                    {
                        data: 'raw_material_en',
                        name: 'raw_material_en'
                    },
                    {
                        data: 'capacity',
                        name: 'capacity'
                    },
                    {
                        data: 'price_usd',
                        name: 'price_usd'
                    },
                    {
                        data: 'product_description',
                        name: 'product_description'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'information',
                        name: 'information'
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
                        return "<div class='text-wrap' style='width:200px'>" + data + "</div>";
                    },
                    targets: 2
                },{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:250px'>" + data + "</div>";
                    },
                    targets: 8
                },{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:200px'>" + data + "</div>";
                    },
                    targets: 10
                }],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left' /></>",
                        "next": "<i class='fa fa-angle-right' /></>"
                    }
                }
            });


        });

        // Remove plus sign when no data available in table
        setTimeout(function() {
            if ($(".dataTables_empty")[0]) {
                $(".table.dataTable.dtr-inline.collapsed tbody td:first-child").addClass("hidden_plus");
            }
        }, 1000);
    </script>
@endsection
