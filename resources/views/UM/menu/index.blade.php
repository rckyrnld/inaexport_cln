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
                    <h3 class="mb-0">Buat Menu</h3>
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

                    <a href="{{ url('menu_add') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Buat Menu</a>
                    <div class="col-md-3" style="float: right;">
                        <form action="{{ url('/') }}/search_menu" method="POST" role="search">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input style="border-top-left-radius: 15px; border-bottom-left-radius:15px;" type="text"
                                    class="form-control" name="q" placeholder="Search Menu Name..." autocomplete="off">
                                <button
                                    style="font-weight:bold; background-color: #1089ff; color: #fff; border-top-right-radius: 15px; border-bottom-right-radius:15px"
                                    type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                    Search
                                </button>
                            </div>
                        </form>
                    </div><br>

                    {{-- <div class="card shadow">
                        <div class="card-body"> --}}
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-hover" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th width="30">
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>Nama Menu</center>
                                    </th>
                                    <th>
                                        <center>Url</center>
                                    </th>
                                    <th>
                                        <center>Urutan</center>
                                    </th>
                                    <th>
                                        <center>Icon</center>
                                    </th>
                                    <th width="200">
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($menu as $res)
                                    @if ($res->parent == 0)
                                        <tr>
                                            <td>
                                                <center>{{ $no++ }}</center>
                                            </td>
                                            <td>
                                                <div align="left"><b>{{ $res->menu_name }}</b></div>

                                            </td>
                                            <td>
                                                <div class='text-wrap' style='width:200px'>{{ $res->url }}</div>
                                            </td>
                                            <td>
                                                <center>{{ $res->order }}</center>
                                            </td>
                                            <td>
                                                <div class='text-wrap' style='width:200px'>{{ $res->icon }}</div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ url('/menu_edit/' . $res->id_menu) }}"
                                                        class="btn btn-warning btn-xs" title="Edit"><i
                                                            class="fa fa-edit text-white"></i></a>

                                                    <a href="{{ url('/menu_delete/' . $res->id_menu) }}"
                                                        class="btn btn-danger btn-xs" title="Hapus"><i
                                                            class="fa fa-trash"></i></a>

                                                    <a href="{{ url('/submenu_add/' . $res->id_menu) }}"
                                                        class="btn btn-primary btn-xs" title="Tambah Submenu"><i
                                                            class="fa fa-plus-circle"></i> Submenu</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach ($menu as $restwo)
                                        @if ($res->id_menu == $restwo->parent)
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <div align="left">{{ $restwo->menu_name }}</div>
                                                </td>
                                                <td>
                                                    <div class='text-wrap' style='width:200px'>{{ $restwo->url }}</div>
                                                </td>
                                                <td>
                                                    <center>{{ $restwo->order }} </center>
                                                </td>
                                                <td>
                                                    <div class='text-wrap' style='width:200px'>{{ $restwo->ket }}</div>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ url('/submenu_edit/' . $restwo->id_menu) }}"
                                                            class="btn btn-warning btn-xs" title="Edit"><i
                                                                class="fa fa-edit text-white"></i></a>
                                                        <a href="{{ url('/menu_delete/' . $restwo->id_menu) }}"
                                                            class="btn btn-danger btn-xs" title="Hapus"><i
                                                                class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- </div>
                    </div> --}}
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

    @include('footer')
@endsection

<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            columnDefs: [{
                width: "80px",
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
