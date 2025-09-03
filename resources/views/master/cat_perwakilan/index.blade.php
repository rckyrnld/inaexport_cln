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

        #tambah {
            background-color: #1a9cf9;
            color: white;
            white-space: pre;
        }

        #tambah:hover {
            background-color: #148de4
        }

        .table th{
            color: white;
            text-align: center;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Representative Category</h3>
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
                    <a style="color:White" data-toggle="modal" data-target="#modal-addw" class="btn btn-primary ml-4"><i
                            class="fa fa-plus-circle"></i>
                        Add</a><br><br>

                    <div class="table-responsive">
                        <table id="example1" class="table table-striped table-hover" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>Type</center>
                                    </th>
                                    <th width="20%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                            $data = DB::select("select * from mst_catper order by id desc");
                            $no = 1;
                            foreach($data as $val){

                            ?>
                                <tr>
                                    <td width="5%">
                                        <center><?php echo $no; ?></center>
                                    </td>
                                    <td><?php echo $val->type; ?></td>
                                    <td width="7%">
                                        <center>
                                            <a onclick="return confirm('Are You Sure ?')"
                                                href="{{ url('hapus-catper/' . $val->id) }}" class="btn btn-danger">
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
    <div class="modal fade" id="modal-addw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="row-col h-v">
            <div class="row-cell v-m">
                <div class="modal-dialog modal-lg">
                    <form id="checkpass" method="POST" action="{{ route('catper.save') }}"
                        class="form-horizontal form-label-left">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #2e899e;">
                                <h5 class="modal-title" id="judul" style="color: white;">
                                    <center>Add Category Representative</center>
                                </h5>
                            </div>
                            <div class="modal-body text-center p-lg" style="background-color: #ffffff;" id="state">
                                <div class="box-header">
                                    <div class="col-md-12">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            {{-- <div class="col-md-4"> --}}
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label" style="color: black;"><b>Category
                                                            Representative</b>
                                                    </label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" style="color: black; text-align: left;" id="catper"
                                                        name="catper" class="form-control" autocomplete="off" required>
                                                </div>
                                            </div>

                                            {{-- </div> --}}
                                            {{-- <div class="col-md-6"> --}}


                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="background-color: #2e899e;">
                                <button type="button" class="btn btn-danger p-x-md" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning" id="btn-savez" value="add">Kirim</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </form>
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
