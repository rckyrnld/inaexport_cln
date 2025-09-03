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
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header container-fluid">
                    <div class="row">
                        <div class="col-md-10">
                            <h3>Data Produk</h3>
                        </div>
                        <div class="col-md-2">
                            <?php if (empty(Auth::user()->name)) {
                            if (Auth::guard('eksmp')->user()->status == 1) {
                                ?>
                            <a href="{{ url('/eksportir/tambah_product') }}" class="btn btn-block btn-primary pl-2 ml-0"><i
                                    class="fa fa-plus-circle"></i>
                                Add</a>
                            <?php } else { ?>

                            <?php } ?>

                            <?php   } else { ?>

                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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

                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tablebrands" class="table  table-responsive table-striped table-hover"
                                    style="width: 100%;">
                                    <thead class="text-white" style="background-color: #6B7BD6;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Code</center>
                                            </th>
                                            <th>
                                                <center>Product Name</center>
                                            </th>
                                            <!-- <th>
                                            <center>Color</center>
                                            </th>
                                            <th>
                                                <center>Size</center>
                                            </th>
                                            <th>
                                                <center>Raw Material</center>
                                            </th>
                                            <th>
                                                <center>Capacity</center>
                                            </th>
                                             -->
                                            {{-- <th>
                                            <center>Price (USD)</center>
                                        </th>
                                        <th>
                                            <center>Description Product</center>
                                        </th> --}}
                                            <th>
                                                <center>Status</center>
                                            </th>
                                            {{-- <th>
                                            <center>Information</center>
                                        </th> --}}
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

    <script>
        $(document).ready(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#tablebrands').DataTable({
                processing: true,
                serverSide: true,
                "autoWidth": true,
                ajax: "{{ route('datatables.eksproduct') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: '5%',
                        className: "text-center"
                    },
                    {
                        data: 'code_en',
                        name: 'code_en',
                        width: '20%',
                    },
                    {
                        data: 'prodname_en',
                        name: 'prodname_en',
                        width: '50%',
                    },
                    // {
                    //     data: 'color_en',
                    //     name: 'color_en'
                    // },
                    // {
                    //     data: 'size_en',
                    //     name: 'size_en'
                    // },
                    // {
                    //     data: 'raw_material_en',
                    //     name: 'raw_material_en'
                    // },
                    // {
                    //     data: 'capacity',
                    //     name: 'capacity'
                    // },
                    // {
                    //     data: 'price_usd',
                    //     name: 'price_usd'
                    // },
                    // {
                    //     data: 'product_description',
                    //     name: 'product_description'
                    // },
                    {
                        data: 'status',
                        name: 'status',
                        width: '15%',
                    },
                    // {
                    //     data: 'information',
                    //     name: 'information'
                    // },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '10%',
                        className: "text-center"
                    }
                ],

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
