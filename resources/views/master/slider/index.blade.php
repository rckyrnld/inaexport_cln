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
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Slider</h3>
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
                    <a id="tambah" href="{{ url('tambah-slide') }}" class="btn btn-primary ml-4"><i
                            class="fa fa-plus-circle"></i>
                        Add</a>
                    <br><br>

                    <div class="table-responsive">
                        <table id="example1" class="table table-striped table-hover">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>File</center>
                                    </th>
                                    <th>
                                        <center>Note</center>
                                    </th>
                                    <th>
                                        <center>Publish</center>
                                    </th>
                                    <th width="20%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 
                                $data = DB::select("select * from mst_slide order by id desc"); 
                                $no = 1;
                                foreach($data as $val){
							?>

                                <tr>
                                    <td width="5%">
                                        <center>{{ $no }}<center>
                                    </td>
                                    <td width="20%"><img src="{{ asset('uploads/slider') }}{{ '/' . $val->file_img }}"
                                            width="120px"></td>
                                    <td width="35%">{{ $val->keterangan }}</td>
                                    <td><?php if ($val->publish == 1) {
                                        echo 'Yes';
                                    } else {
                                        echo 'No';
                                    } ?></td>
                                    <td width="10%">
                                        <center>
                                            <a href="{{ url('edit-slide/' . $val->id) }}" class="btn btn-success">
                                                <font color="white"><i class="fa fa-edit"></i></font>
                                            </a>
                                            <a href="{{ url('hapus-slide/' . $val->id) }}" class="btn btn-danger">
                                                <font color="white"><i class="fa fa-trash"></i></font>
                                            </a>
                                        </center>
                                    </td>
                                </tr>
                                <?php $no++; } ?>
                            </tbody>
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
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('master.port.getData') }}",
                columns: [{
                        data: 'name_port',
                        name: 'name_port'
                    },
                    {
                        data: 'province_en',
                        name: 'province_en'
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
        });
    </script>

    @include('footer')

@endsection
