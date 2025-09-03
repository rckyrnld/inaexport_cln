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

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 35px !important;
        }

        .custom-select,
        .custom-file-control,
        .custom-file-control:before,
        select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
            height: 45px !important;
        }

        #table th {
            color: white;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Category Product</h3>
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

                    <a id="tambah" href="{{ route('management.category-product.create') }}" class="btn btn-primary ml-4"><i
                            class="fa fa-plus-circle"></i>
                        Add</a>
                    <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-show"> <i
                            class="fa fa-hashtag"></i> Setting Show </button>
                    <br><br>
                    <div class="table-responsive">
                        <table id="table" class="table  table-bordered table-striped table-hover" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>Product (EN)</center>
                                    </th>
                                    <th>
                                        <center>Product (INA)</center>
                                    </th>
                                    <th width="20%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- MODAL EO -->
                <div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Show on Home</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                                    action="{{ route('management.category-product.home') }}">
                                    {{ csrf_field() }}
                                    <?php
                                    for ($i = 1; $i <= 3; $i++) {
                                        ${"cat_$i"} = cat_prod_home($i);
                                        $sub[$i-1] = cat_prod_sub_home(${"cat_$i"},$i);
                                    }
                                    ?>
                                    <table width="100%" cellpadding="5">
                                        <tr>
                                            <td>Category 1</td>
                                            <td colspan="4">
                                                <select class="form-control" id="cat1" required name="cat1"
                                                    style="width:100%;" onchange="changeCat(1)">
                                                    <option></option>
                                                    @foreach ($product as $data)
                                                        <option value="{{ $data->id }}" @if ($data->id == $cat_1) selected @endif>
                                                            {{ $data->nama_kategori_en }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub 1</td>
                                            <td>
                                                <select class="form-control sub1" id="sub1_1" required name="sub1_1"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_1, 0, (isset($sub[0][0])) ? $sub[0][0] : 0); @endphp
                                                </select>
                                            </td>
                                            <td>Sub 2</td>
                                            <td>
                                                <select class="form-control sub1" id="sub1_2" required name="sub1_2"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_1, 0, (isset($sub[0][1])) ? $sub[0][1] : 0); @endphp
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub 3</td>
                                            <td>
                                                <select class="form-control sub1" id="sub1_3" required name="sub1_3"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_1, 0, (isset($sub[0][2])) ? $sub[0][2] : 0); @endphp
                                                </select>
                                            </td>
                                            <td>Sub 4</td>
                                            <td>
                                                <select class="form-control sub1" id="sub1_4" required name="sub1_4"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_1, 0, (isset($sub[0][3])) ? $sub[0][3] : 0); @endphp
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub 5</td>
                                            <td>
                                                <select class="form-control sub1" id="sub1_5" required name="sub1_5"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_1, 0, (isset($sub[0][4])) ? $sub[0][4] : 0); @endphp
                                                </select>
                                            </td>
                                            <td>Sub 6</td>
                                            <td>
                                                <select class="form-control sub1" id="sub1_6" required name="sub1_6"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_1, 0, (isset($sub[0][5])) ? $sub[0][5] : 0); @endphp
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Category 2</td>
                                            <td colspan="4">
                                                <select class="form-control" id="cat2" required name="cat2"
                                                    style="width:100%;" onchange="changeCat(2)">
                                                    <option></option>
                                                    @foreach ($product as $data)
                                                        <option value="{{ $data->id }}" @if ($data->id == $cat_2) selected @endif>
                                                            {{ $data->nama_kategori_en }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub 1</td>
                                            <td>
                                                <select class="form-control sub2" id="sub2_1" required name="sub2_1"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_2, 0, (isset($sub[1][0])) ? $sub[1][0] : 0); @endphp
                                                </select>
                                            </td>
                                            <td>Sub 2</td>
                                            <td>
                                                <select class="form-control sub2" id="sub2_2" required name="sub2_2"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_2, 0, (isset($sub[1][1])) ? $sub[1][1] : 0); @endphp
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub 3</td>
                                            <td>
                                                <select class="form-control sub2" id="sub2_3" required name="sub2_3"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_2, 0, (isset($sub[1][2])) ? $sub[1][2] : 0); @endphp
                                                </select>
                                            </td>
                                            <td>Sub 4</td>
                                            <td>
                                                <select class="form-control sub2" id="sub2_4" required name="sub2_4"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_2, 0, (isset($sub[1][3])) ? $sub[1][3] : 0); @endphp
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub 5</td>
                                            <td>
                                                <select class="form-control sub2" id="sub2_5" required name="sub2_5"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_2, 0, (isset($sub[1][4])) ? $sub[1][4] : 0); @endphp
                                                </select>
                                            </td>
                                            <td>Sub 6</td>
                                            <td>
                                                <select class="form-control sub2" id="sub2_6" required name="sub2_6"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_2, 0, (isset($sub[1][5])) ? $sub[1][5] : 0); @endphp
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Category 3</td>
                                            <td colspan="4">
                                                <select class="form-control" id="cat3" required name="cat3"
                                                    style="width:100%;" onchange="changeCat(3)">
                                                    <option></option>
                                                    @foreach ($product as $data)
                                                        <option value="{{ $data->id }}" @if ($data->id == $cat_3) selected @endif>
                                                            {{ $data->nama_kategori_en }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub 1</td>
                                            <td>
                                                <select class="form-control sub3" id="sub3_1" required name="sub3_1"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_3, 0, (isset($sub[2][0])) ? $sub[2][0] : 0); @endphp
                                                </select>
                                            </td>
                                            <td>Sub 2</td>
                                            <td>
                                                <select class="form-control sub3" id="sub3_2" required name="sub3_2"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_3, 0, (isset($sub[2][1])) ? $sub[2][1] : 0); @endphp
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub 3</td>
                                            <td>
                                                <select class="form-control sub3" id="sub3_3" required name="sub3_3"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_3, 0, (isset($sub[2][2])) ? $sub[2][2] : 0); @endphp
                                                </select>
                                            </td>
                                            <td>Sub 4</td>
                                            <td>
                                                <select class="form-control sub3" id="sub3_4" required name="sub3_4"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_3, 0, (isset($sub[2][3])) ? $sub[2][3] : 0); @endphp
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sub 5</td>
                                            <td>
                                                <select class="form-control sub3" id="sub3_5" required name="sub3_5"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_3, 0, (isset($sub[2][4])) ? $sub[2][4] : 0); @endphp
                                                </select>
                                            </td>
                                            <td>Sub 6</td>
                                            <td>
                                                <select class="form-control sub3" id="sub3_6" required name="sub3_6"
                                                    style="width:100%;">
                                                    <option></option>
                                                    @php getKategoriLevel2($cat_3, 0, (isset($sub[2][5])) ? $sub[2][5] : 0); @endphp
                                                </select>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
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
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $(".alert").slideDown(300).delay(1000).slideUp(300);
                        $('#table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('management.category-product.getData') }}",
                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
                                    width: 5,
                                    className: "text-center"
                                },
                                {
                                    data: 'nama_kategori_en',
                                    name: 'nama_kategori_en'
                                },
                                {
                                    data: 'nama_kategori_in',
                                    name: 'nama_kategori_in'
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
                                    return "<div class='text-wrap width-200'>" + data + "</div>";
                                },
                                targets: 1
                            }],
                            "language": {
                                "paginate": {
                                    "previous": "<i class='fa fa-angle-left'/></>",
                                    "next": "<i class='fa fa-angle-right'/></>"
                                }
                            }
                        });

                        $('#cat1').select2({
                            placeholder: 'Select Category'
                        });
                        $('#cat2').select2({
                            placeholder: 'Select Category'
                        });
                        $('#cat3').select2({
                            placeholder: 'Select Category'
                        });
                        $('#cat4').select2({
                            placeholder: 'Select Category'
                        });
                        $('#cat5').select2({
                            placeholder: 'Select Category'
                        });
                        $('#cat6').select2({
                            placeholder: 'Select Category'
                        });
                    });

                    function changeCat(pos) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        var id = $( "#cat"+pos+" option:selected" ).val();
                        var p1 = '?id=' + id;
                        $(".sub"+pos).html('');
                        $.get('{{URL::to("management/category-product/home/level_2")}}/'+p1,{_token:token},function(data){
                            $(".sub"+pos).html(JSON.parse(data));
                        })
                    }
                </script>
                @include('footer')

            @endsection
