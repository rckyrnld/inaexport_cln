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

        .table th {
            color: white;
            text-align: center;
        }

    </style>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Product</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    <!-- <div class="table-responsive"> -->
                    <table id="tablebrands" class="table table-striped table-hover">
                        <thead class="text-white" style="background-color: #6B7BD6;">
                            <tr>
                                <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                    <center>No</center>
                                </th>
                                {{-- <th style="width:30px!important;padding-left:2px;padding-right:5px;"> <center>
                                    Code
                                </center></th> --}}
                                <th style="width:5px!important;padding-left:2px;padding-right:5px;">
                                    <center>
                                        Product Name
                                    </center>
                                </th>
                                <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                    <center>
                                        Supplier
                                    </center>
                                </th>
                                {{-- <th style="width:20px!important;padding-left:2px;padding-right:5px;"><center>
                                    Color
                                </center></th> --}}
                                {{-- <th style="width:30px!important;padding-left:2px;padding-right:5px;">
                                    <center>
                                        Size
                                    </center>
                                </th> --}}
                                {{-- <th style="width:10px!important;padding-left:2px;padding-right:5px;">
                                    <center>
                                        Raw Material
                                    </center>
                                </th> --}}
                                {{-- <th style="width:30px!important;padding-left:2px;padding-right:5px;">
                                    <center>
                                        Capacity
                                    </center>
                                </th>
                                <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                    <center>
                                        Price (USD)
                                    </center>
                                </th>
                                <th style="width:30px!important;padding-left:2px;padding-right:5px;">
                                    <center>
                                        Description Product
                                    </center>
                                </th> --}}
                                <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                    <center>
                                        Status
                                    </center>
                                </th>
                                {{-- <th style="width:20px!important;padding-left:2px;padding-right:5px;"><center>
                                    Information
                                </center></th> --}}
                                <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                    <center>
                                        Action
                                    </center>
                                </th>
                            </tr>
                        </thead>

                    </table>
                    <br>
                    <!-- </div> -->
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
                <!--<div class="modal-body">
                                                                                      1
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    </div> -->
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#tablebrands').DataTable({
                processing: true,
                serverSide: true,
                scrollX: 200,
                scroller: {
                    loadingIndicator: true
                },
                ajax: "{{ route('datatables.eksproduct_admin_un', $id_profil) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        sWidth: '20px'
                    },
                    // {
                    //     data: 'code_en', 
                    //     name: 'code_en',
                    //     sWidth: '30px'
                    // },
                    {
                        data: 'prodname_en',
                        name: 'prodname_en',
                        sWidth: '10px'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name',
                        sWidth: '20px'
                    },
                    // {
                    //     data: 'color_en', 
                    //     name: 'color_en',
                    //     sWidth: '20px'
                    // },
                    // {
                    //     data: 'size_en',
                    //     name: 'size_en',
                    //     sWidth: '30px'
                    // },
                    // {
                    //     data: 'raw_material_en',
                    //     name: 'raw_material_en',
                    //     sWidth: '30px'
                    // },
                    // {
                    //     data: 'capacity',
                    //     name: 'capacity',
                    //     sWidth: '30px'
                    // },
                    // {
                    //     data: 'price_usd',
                    //     name: 'price_usd',
                    //     sWidth: '20px'
                    // },
                    // {
                    //     data: 'product_description',
                    //     name: 'product_description',
                    //     sWidth: '30px'
                    // },
                    {
                        data: 'status',
                        name: 'status',
                        sWidth: '20px'
                    },
                    // {
                    //     data: 'information', 
                    //     name: 'information',
                    //     sWidth: '20px'
                    // },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        sWidth: '20px'
                    },
                ],
                bAutoWidth: false,
                // columnDefs: [{
                //     render: function(data, type, full, meta) {
                //         return "<div class='text-wrap' style='width:150px'>" + data + "</div>";
                //     },
                //     targets: 1
                // }, {
                //     render: function(data, type, full, meta) {
                //         return "<div class='text-wrap' style='width:150px'>" + data + "</div>";
                //     },
                //     targets: 2
                // }, {
                //     render: function(data, type, full, meta) {
                //         return "<div class='text-wrap' style='width:200px'>" + data + "</div>";
                //     },
                //     targets: 4
                // }, {
                //     render: function(data, type, full, meta) {
                //         return "<div class='text-wrap' style='width:150px'>" + data + "</div>";
                //     },
                //     targets: 3
                // }, {
                //     render: function(data, type, full, meta) {
                //         return "<div class='text-wrap' style='width:80px'>" + data + "</div>";
                //     },
                //     targets: 8
                // }],
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
