@extends('header2')
@section('content')
    <style>
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

        .full-banner {
            width: 100%;
            right: 0;
        }

        .content {
            margin-top: 5%;
        }

        .main-sidebar {
            padding-top: 15%;
        }

        .over {
            overflow: auto;
            max-width: 100%;
        }


        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .select2-container {
            float: left !important;
            width: 75%;
        }

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

        /* .card {
                background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
            }
            .card-header {
                background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
            } */

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
                    <h3 class="mb-0">List Banner</h3>
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
                    <a href="{{ route('master.banner.create') }}" class="btn btn-primary ml-4"><i
                            class="fa fa-plus-circle"></i>
                        Add</a><br><br>
                    <div class="table-responsive">
                        <table id="satu" class="table  table-striped table-hover">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Name</th>
                                    <th>File</th>
                                    <th>Until</th>
                                    <th>Order</th>
                                    <th width="10%">Status</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="modalEdit" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Header</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('master.banner.store', 'update') }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="semua" id="semua">
                        <input type="hidden" name="nocomlain" id="nocomlain">
                        <input type="hidden" name="type" id="type">
                        <div class="form-group row ml-3">
                            <label class="control-label col-md-2">Status</label>
                            <div class="col-md-9">
                                <span>Tidak Aktif</span>
                                <label class="switch">
                                    <input type="checkbox" id="check">
                                    <span class="slider round"></span>
                                </label>
                                <input type="hidden" id="status" name="status" value="0">
                                <span class="mt-3">Aktif</span>
                            </div>
                        </div>
                        <div id="pilihcompany" style="display: none;">
                            <div class="form-group row ml-3">
                                <label class="control-label col-md-2 mt-2" for="date">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nama" id="nama" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row ml-3">
                                <label class="control-label col-md-2" for="date">Active Until</label>
                                <div class="col-md-6">
                                    <input type="Date" class="form-control" name="s_date" id="s_date" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row ml-3">
                                <label class="control-label col-md-2" for="order">Order</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="order" min="1" onkeyup="checkorder()"
                                        id="order" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row ml-3">
                                <label class="control-label col-md-2" for="date">Company Name</label>
                                <div class="col-md-6">
                                    <select class="form-control search " name="company_name" id="company_name"
                                        style="width:75%;float: left !important;">
                                        <option value=""></option>
                                    </select>
                                    <br><br><br>
                                    <!-- <input type="re" class="form-control" name="s_date" id="s_date" autocomplete="off" required> -->
                                    <button type="button" class="btn btn-primary" onclick="addcompanyname()">Add</button>
                                </div>
                            </div>

                            <div class=" form-group row">
                                <div class="col-md-11 ml-3">
                                    Company List that are not from selected Category
                                </div>
                            </div>
                            <table id="companylain" class="table table-bordered table-striped table-hover">
                                <thead class="text-white" style="background-color:#C4C4C4">
                                    <tr>
                                        <th>No</th>
                                        <th>Company</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <!-- <tbody id="companylain">

                    </tbody> -->
                            </table>
                            <div class="row judulcompany">
                                <div class="col-md-11 ml-3">
                                    Company List from selected Category
                                </div>
                            </div>
                            <div class="row judulcompany" align="right">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6" style="color: black !important;">
                                    <input type='checkbox' class='checkall' name='checkall' id='checkall' value=''> Check
                                    All
                                </div>
                            </div>
                            <table id="company" class="table table-bordered table-striped table-hover">
                                <thead class="text-white" style="background-color:#C4C4C4">
                                    <tr>
                                        <th>No</th>
                                        <th>Company</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                            <!-- <div class="row">
                    <div class="col-md-9">
                    </div>
                    <div class="col-md-3">
                      <button onclick="savecheckall()" type="button" class="btn btn-primary" title="save selected company in this page">Save</button>
                    </div>
                  </div> -->
                        </div>

                    </div>

                    <br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="simpanupdate()">Simpan</button>
                    </div>


                </form>
            </div>

        </div>
    </div>

    <div id="modalEdit2" class="modal fade" role="dialog" style="padding-top: 0px;padding-bottom: 0px;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Header</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('master.banner.store', 'update') }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="id2" id="id2">
                        <input type="hidden" name="semua2" id="semua2">
                        <input type="hidden" name="tidaksemua2" id="tidaksemua2">
                        <input type="hidden" name="type2" id="type2">
                        <div class="form-group row ml-3">
                            <label class="control-label col-md-2 mt-2">Status</label>
                            <div class="col-md-9">
                                <span>Tidak Aktif</span>
                                <label class="switch">
                                    <input type="checkbox" id="check2">
                                    <span class="slider round"></span>
                                </label>
                                <input type="hidden" id="status2" name="status2" value="0">
                                <span>Aktif</span>
                            </div>
                        </div>
                        <div id="pilihcompany2" style="display: none;">
                            <div class="form-group row ml-3">
                                <label class="control-label col-md-2 mt-2" for="date">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nama2" id="nama2" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row ml-3">
                                <label class="control-label col-md-2 mt-2" for="date">Active Until</label>
                                <div class="col-md-6">
                                    <input type="Date" class="form-control" name="s_date2" id="s_date2" autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row ml-3">
                                <label class="control-label col-md-2 mt-2" for="order2">Order</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="order2" min="1"
                                        onkeyup="checkorder2()" id="order2" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row ml-3">
                                <label class="control-label col-md-2 mt-2" for="date">Company Name</label>
                                <div class="col-md-6">
                                    <select class="form-control search " name="company_name2" id="company_name2"
                                        style="width:75%;float: left !important;">
                                        <option value=""></option>
                                    </select>
                                    <br><br><br>
                                    <!-- <input type="re" class="form-control" name="s_date" id="s_date" autocomplete="off" required> -->
                                    <button type="button" class="btn btn-primary" onclick="addcompanyname2()">Add</button>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <div class="col-md-11 ml-3">
                                    Company List that are not from selected Category
                                </div>
                            </div>
                            <table id="companylain2" class="table table-bordered table-striped table-hover">
                                <thead class="text-white" style="background-color:#C4C4C4">
                                    <tr>
                                        <th>No</th>
                                        <th>Company</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                            <br><br>
                            <div class="row judulcompany2">
                                <div class="col-md-11 ml-3">
                                    Company List from selected Category
                                </div>
                            </div>
                            <div class="row judulcompany2" align="right">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6" style="color: black !important;">
                                    <input type='checkbox' class='checkall2' name='checkall2' id='checkall2' value=''> Check
                                    All
                                    <input type='checkbox' class='uncheckall2' name='uncheckall2' id='uncheckall2' value=''>
                                    UnCheck All
                                </div>
                            </div>
                            <table id="company2" class="table table-bordered table-striped table-hover">
                                <thead class="text-white" style="background-color:#C4C4C4">
                                    <tr>
                                        <th>No</th>
                                        <th>Company</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                            <br><br>
                            <!-- <div class="row">
                    <div class="col-md-9">
                    </div>
                    <div class="col-md-3">
                      <button onclick="savecheckall2()" type="button" class="btn btn-primary" title="save selected company in this page">Save</button>
                    </div>
                  </div> -->
                            <div class="form-group">
                                <label class="control-label col-md-3">File Image</label>
                                <div class="col-md-9">
                                    <input type="file" class="form-control" name="file" id="file"><br>
                                    <a href="" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-download"
                                            aria-hidden="true"></i>&nbsp;&nbsp;Previous Document</a><br>
                                    <input type="hidden" name="lastest_file" id="lastest_file" value="fileimagenya">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="simpanupdate2()">Simpan</button>
                    </div>
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
        var idbanner = 0;
        var idbanner2 = 0;
        var totalcomlain1 = 0;
        var totalcomlain2 = 0;
        var counter = [];
        var dataeksportir = [];
        var dataeksportirlain = [];
        var dataeksportir2 = [];
        var dataeksportir2lain = [];

        $(document).ready(function() {
            $('select.select2:not(.normal)').each(function() {
                $(this).select2({
                    dropdownParent: $(this).parent().parent()
                });
            });
            $.fn.modal.Constructor.prototype._enforceFocus = function() {};
            $('#company_name').select2({
                // dropdownParent: $('#modalEdit'),
                allowClear: true,
                placeholder: 'Select Company Name',
                ajax: {
                    url: "{{ route('banner.companyname') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        // var query = {
                        //     search: params.term,
                        //     idbanner: $('#id').val()
                        // }
                        var query = {
                            search: params.term,
                            idbanner: $('#id').val()
                        }
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.company,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $('#company_name2').select2({
                // dropdownParent: $('#modalEdit2'),
                allowClear: true,
                placeholder: 'Select Company Name',
                ajax: {
                    url: "{{ route('banner.companyname') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        // var query = {
                        //     search: params.term,
                        //     idbanner: $('#id').val()
                        // }
                        var query = {
                            search: params.term,
                            idbanner: $('#id2').val()
                        }
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.company,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });
        $(document).on("click", ".btnDelete", function() {
            $(this).closest("tr").remove();
            var id = $(this).closest("tr").attr('id');
            var index = dataeksportirlain.indexOf(id);
            console.log(index);
            if (index > -1) {
                dataeksportirlain.splice(index, 1);
            }
            console.log(dataeksportirlain);
        });

        $(document).on("click", ".btnDelete2", function() {
            $(this).closest("tr").remove();
            var id = $(this).closest("tr").attr('id');
            var index = dataeksportirlain2.indexOf(id);
            console.log(index);
            if (index > -1) {
                dataeksportirlain2.splice(index, 1);
            }
            console.log(dataeksportirlain2);
        });

        $(document).ready(function() {
            $("#company").DataTable({
                processing: true,
                columnDefs: [{
                    "orderable": false,
                    "targets": 2
                }],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });
            $("#company2").DataTable({
                processing: true,
                columnDefs: [{
                    "orderable": false,
                    "targets": 2
                }],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });
            $("#companylain").DataTable({
                processing: true,
                columnDefs: [{
                    "orderable": false,
                    "targets": 2
                }],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }

            });
            // untuk di modal tambah yang geser aktif dan tidak aktif
            $('#check').change(function() {
                if ($(this).is(':checked')) {
                    $('#status').val(1);
                    var type = $('#type').val();
                    if (type == 2) {
                        $('#company').hide();
                        $('#company_wrapper').hide();
                        $('.judulcompany').hide();
                    } else {
                        $('#company').DataTable().clear().draw();
                        $.ajax({
                                method: "POST",
                                url: "{{ route('master.banner.getCompany') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: idbanner,
                                    tipe: 'kategori'
                                }
                            })
                            .done(function(data) {
                                $.each(data, function(i, val) {
                                    // get company
                                    $('#company').DataTable().row.add([val.no,
                                        '<a target="_blank" href="{{ url('eksportir/listeksportir') }}/' +
                                        val.id + '">' + val.company + '</a>',
                                        '<div class="checkbox"><input class="masuk" type="checkbox" value="' +
                                        val.id + '" data-id="' + val.id +
                                        '" name="comp" ></div>'
                                    ]).draw();

                                });
                            });

                    }
                    $('#companylain').DataTable().clear().draw();
                    $.ajax({
                            method: "POST",
                            url: "{{ route('master.banner.getCompany') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: idbanner,
                                tipe: 'lain'
                            }
                        })
                        .done(function(data) {
                            $.each(data, function(i, val) {
                                // get company
                                $('#companylain').DataTable().row.add([val.no,
                                    '<a target="_blank" href="{{ url('eksportir/listeksportir') }}/' +
                                    val.id + '">' + val.company + '</a>',
                                    '<div><button type="button" class="btn btn-danger"  onclick="destroycompanylain(' +
                                    val.id + ')">Delete</button></div>'
                                ]).draw();

                            });
                        });
                    $('#pilihcompany').show();
                } else {
                    $('#status').val(2);
                    $('#pilihcompany').hide();
                }
            });
            // untuk di modal edit yang geser aktif dan tidak aktif
            $('#check2').change(function() {
                if ($(this).is(':checked')) {
                    var type = $('#type2').val();
                    if (type == 2) {
                        check2active('takadacat');
                    } else {
                        check2active('adacat');
                    }
                } else {
                    $('#status2').val(2);
                    $('#pilihcompany2').hide();
                }
            });

            $('#satu').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": '{!! route('master.banner.getData') !!}',
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: '{{ csrf_token() }}'
                    }
                },
                "columns": [{
                        data: 'no'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'file'
                    },
                    {
                        data: 'until'
                    },
                    {
                        data: 'order'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'aksi'
                    },
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });
            $('#modalEdit').on('show.bs.modal', function(e) {
                $('#id').val('');
                $('#nama').val('');
                $('#nocomlain').val('');
                $('#type').val('');
                $('#company').DataTable().clear().draw();
                $('#companylain').DataTable().clear().draw();
                idbanner = $(e.relatedTarget).data('edit-id');
                namebanner = $(e.relatedTarget).data('edit-name');
                order = $(e.relatedTarget).data('edit-order');
                type = $(e.relatedTarget).data('edit-type');
                var totalcompanylain = $(e.relatedTarget).data('edit-comlain');
                if (totalcompanylain == null) {
                    totalcomlain1 = 1;
                } else {
                    totalcomlain1 = totalcompanylain + 1;
                }
                console.log(totalcompanylain);
                $('#nocomlain').val(totalcompanylain);
                $('#id').val(idbanner);
                $('#nama').val(namebanner);
                $('#order').val(order);
                $('#type').val(type);

            });

            // ini yang bikin select2 bisa jalan di modal bootstrap yang di firefox dan chrome
            $.fn.modal.Constructor.prototype.enforceFocus = $.noop;
            $('#modalEdit2').on('show.bs.modal', function(e) {
                $('#company2').DataTable().clear().draw();
                idbanner2 = $(e.relatedTarget).data('edit-id');
                namebanner2 = $(e.relatedTarget).data('edit-name');
                order2 = $(e.relatedTarget).data('edit-order');
                type2 = $(e.relatedTarget).data('edit-type');
                $('#id2').val(idbanner2);
                $('#nama2').val(namebanner2);
                $('#order2').val(order2);
                $('#type2').val(type2);
                checkbanner2 = $(e.relatedTarget).data('check-id');
                endatbanner2 = $(e.relatedTarget).data('endat-id');
                filebanner2 = $(e.relatedTarget).data('image-id');
                if (checkbanner2 == 1) {
                    $('#check2').prop("checked", true);
                    if (type2 == 2) {
                        check2active('takadacat');
                    } else {
                        check2active('adacat');
                    }
                } else {
                    $('#check2').prop("checked", false);
                }
                //untuk set beberapa data bawaan
                endatbanner2 = $(e.relatedTarget).data('endat-id');
                filebanner2 = $(e.relatedTarget).data('image-id');
                console.log(endatbanner2);
                var from = endatbanner2.split("-");
                var f = new Date(from[2], from[1] - 1, from[0]);
                var day = ("0" + f.getDate()).slice(-2);
                var month = ("0" + (f.getMonth() + 1)).slice(-2);
                var date = f.getFullYear() + "-" + (month) + "-" + (day);
                $('#s_date2').val(date);
                //untuk hidden file
                $('#modalEdit2 input[name="lastest_file"]').each(function() {
                    var text = $(this).val();
                    $(this).val(text.replace('fileimagenya', filebanner2));
                });
                //untuk file previous
                var hrefnya = "{{ url('/') . '/uploads/banner/' }}" + filebanner2;
                $("#modalEdit2 a").attr("href", hrefnya);
            });
            $('#checkall').change(function() {
                if (this.checked) {
                    $('#semua').val(1);
                } else {
                    $('#semua').val(0);
                    $("input[name='comp']").prop('checked', false);
                    // dataeksportir = [];
                }
            });
            $('#checkall2').change(function() {
                if (this.checked) {
                    $('#semua2').val(1);
                } else {
                    console.log('masuk sini');
                    $('#semua2').val(0);
                    $("input[name='comp2']").prop('checked', false);
                    // dataeksportir2 = [];
                }
            });
            $('#uncheckall2').change(function() {
                if (this.checked) {
                    $('#tidaksemua2').val(1);
                } else {
                    console.log('masuk sini');
                    $('#tidaksemua2').val(0);
                    // $("input[name='comp2']").prop('checked', false);
                    // dataeksportir2 = [];
                }
            });
        });

        //untuk yang check uncheck dataeksportir
        $('body').on('click', '.masuk', function() {
            var id = $(this).data('id');
            if ($(this).prop("checked") == true) {
                dataeksportir.push(id);

                if ($("input[name='checkall']").prop("checked") == true) {
                    $("input[name='checkall']").prop('checked', false);
                }
            } else if ($(this).prop("checked") == false) {
                console.log(id);
                var index = dataeksportir.indexOf(id);
                console.log(index);
                if (index > -1) {
                    console.log('hapusin dataeksportir');
                    dataeksportir.splice(index, 1);
                }
            }
            console.log(dataeksportir);
        });

        //untuk yang check uncheck dataeksportir2
        $('body').on('click', '.masuk2done', function() {
            var id = $(this).data('id');
            if ($(this).prop("checked") == true) {
                console.log('tambahin dataeksportir2');
                dataeksportir2.push(id);
                if ($("input[name='checkall2']").prop("checked") == true) {
                    $("input[name='checkall2']").prop('checked', false);
                }

            } else if ($(this).prop("checked") == false) {
                var index2 = dataeksportir2.indexOf(id);
                if (index2 > -1) {
                    console.log('hapusin dataeksportir2');
                    dataeksportir2.splice(index2, 1);
                }
            }
            console.log(dataeksportir2);
        });

        function addcompanyname() {
            var data = $('#company_name').select2('data');
            var no = totalcomlain1;
            dataeksportirlain.push(data[0].id);
            $.ajax({
                type: 'POST',
                url: "{{ route('master.banner.savecompanylain') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id_banner': $('#id').val(),
                    'id_perusahaan': data[0].id,
                },
                success: function(data) {
                    refreshtablecompanylain();
                    // $('#totaldistance').val(data.distance); 
                }
            });
            // totalcomlain1++;
            $('#company_name').empty();
        }

        function addcompanyname2() {
            var data = $('#company_name2').select2('data');
            // var no =  totalcomlain1;
            // dataeksportirlain.push(data[0].id);
            $.ajax({
                type: 'POST',
                url: "{{ route('master.banner.savecompanylain') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id_banner': $('#id2').val(),
                    'id_perusahaan': data[0].id,
                },
                success: function(data) {
                    refreshtablecompanylain2();
                    // $('#totaldistance').val(data.distance); 
                }
            });
            // totalcomlain1++;
            $('#company_name2').empty();
        }


        //ini untuk yang button save, sementara gak dipake
        function savecheckall() {
            $.each($(".semua:checked"), function() {
                val = $(this).val();
                if (dataeksportir.includes(val)) {} else {
                    $('input:checkbox[value=' + val + ']').attr('disabled', true)
                    dataeksportir.push($(this).val());
                    // $(this).prop('checked', false);
                }
            });
            // $("input[name='checkall']").prop('checked', false);
        }

        //ini untuk yang button save, sementara gak dipake
        function savecheckall2() {
            $.each($(".semua2:checked"), function() {
                val = $(this).val();
                if (dataeksportir2.includes(val)) {} else {
                    $('input:checkbox[value=' + val + ']').attr('disabled', true)
                    dataeksportir2.push($(this).val());
                    // $(this).prop('checked', false);
                }
            });
            // $("input[name='checkall']").prop('checked', false);
        }


        function simpanupdate() {
            var id = $('#id').val();
            // Get today's date
            var todaysDate = new Date();
            var s_date = $('#s_date').val();
            var semua = $('#semua').val();
            var nama = $('#nama').val();
            var order = $('#order').val();
            var status = $('#status').val();
            var type = $('#type').val();

            // $.each($("input[name='comp']:checked"), function(){
            //           var val = $(this).val();
            //           if(dataeksportir.includes(val)){

            //           }else{
            //               dataeksportir.push($(this).val());
            //           }
            // });
            // (s_date != null || s_date != '' || !isEmptyM(s_date) ||
            if (type == 2) {
                if (s_date && nama != null && order != null) {
                    var inputdate = new Date(s_date);
                    if (inputdate.setHours(0, 0, 0, 0) >= todaysDate.setHours(0, 0, 0, 0)) {
                        console.log('lebih dari today');
                        var form_data = new FormData();
                        form_data.append('id', id);
                        form_data.append('dataeksportir', dataeksportir);
                        form_data.append('dataeksportirlain', dataeksportirlain);
                        form_data.append('s_date', s_date);
                        form_data.append('nama', nama);
                        form_data.append('semua', semua);
                        form_data.append('order', order);
                        form_data.append('status', status);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}'
                            }
                        });
                        $.ajax({
                                method: "POST",
                                url: "{{ route('master.banner.store', 'update') }}",
                                data: form_data,
                                contentType: false, // The content type used when sending data to the server.
                                cache: false, // To unable request pages to be cached
                                processData: false,
                            })
                            .done(function(e) {
                                if (e == 'sukses') {
                                    window.location = "{{ route('master.banner.message') }}";
                                } else {
                                    window.location = "{{ route('master.banner.message') }}";
                                }
                            });
                    } else {
                        alert("make sure to choose today's date or after today");
                        // console.log('before today');
                    }
                } else {
                    alert('make sure you already fill all input in the form correctly');
                }
            } else {
                if (s_date && (!isEmptyM(dataeksportir) || semua == 1) && nama != null && order != null) {
                    // if ((!isEmptyM(dataeksportir) || semua == 1) && !s_date) {
                    // Create date from input value
                    var inputdate = new Date(s_date);
                    if (inputdate.setHours(0, 0, 0, 0) >= todaysDate.setHours(0, 0, 0, 0)) {
                        console.log('lebih dari today');
                        var form_data = new FormData();
                        form_data.append('id', id);
                        form_data.append('dataeksportir', dataeksportir);
                        form_data.append('dataeksportirlain', dataeksportirlain);
                        form_data.append('s_date', s_date);
                        form_data.append('nama', nama);
                        form_data.append('semua', semua);
                        form_data.append('order', order);
                        form_data.append('status', status);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}'
                            }
                        });
                        $.ajax({
                                method: "POST",
                                url: "{{ route('master.banner.store', 'update') }}",
                                data: form_data,
                                contentType: false, // The content type used when sending data to the server.
                                cache: false, // To unable request pages to be cached
                                processData: false,
                            })
                            .done(function(e) {
                                if (e == 'sukses') {
                                    window.location = "{{ route('master.banner.message') }}";
                                } else {
                                    window.location = "{{ route('master.banner.message') }}";
                                }
                            });
                    } else {
                        alert("make sure to choose today's date or after today");
                        // console.log('before today');
                    }

                } else {
                    // console.log('masuk gak');
                    alert('make sure you already fill all input in the form correctly');
                }
            }

        }

        function refreshtablecompanylain() {
            $('#companylain').DataTable().clear().draw();
            $.ajax({
                    method: "POST",
                    url: "{{ route('master.banner.getCompany') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: idbanner,
                        tipe: 'lain'
                    }
                })
                .done(function(data) {
                    $.each(data, function(i, val) {
                        // get company
                        $('#companylain').DataTable().row.add([val.no,
                            '<a target="_blank" href="{{ url('eksportir/listeksportir') }}/' + val
                            .id +
                            '">' + val.company + '</a>',
                            '<div><button type="button" class="btn btn-danger"  onclick="destroycompanylain(' +
                            val.id + ')">Delete</button></div>'
                        ]).draw();

                    });
                });
        }

        function refreshtablecompanylain2() {
            $('#companylain2').DataTable().clear().draw();
            $.ajax({
                    method: "POST",
                    url: "{{ route('master.banner.getCompany') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: idbanner2,
                        tipe: 'lain'
                    }
                })
                .done(function(data) {
                    $.each(data, function(i, val) {
                        // get company
                        $('#companylain2').DataTable().row.add([val.no,
                            '<a target="_blank" href="{{ url('eksportir/listeksportir') }}/' + val
                            .id +
                            '">' + val.company + '</a>',
                            '<div><button type="button" class="btn btn-danger"  onclick="destroycompanylain2(' +
                            val.id + ')">Delete</button></div>'
                        ]).draw();

                    });
                });
        }

        function checkorder2() {
            var inputan = $('#order2').val();
            var cariminus = inputan.search("-");
            if (cariminus != "-1") {
                $('#order2').val("");
            }
        }

        function checkorder() {
            var inputan = $('#order').val();
            var cariminus = inputan.search("-");
            if (cariminus != "-1") {
                $('#order').val("");
            }
        }



        // untuk di modal edit yang geser aktif dan tidak aktif
        function check2active(param) {
            $('#status2').val(1);
            if (param == 'adacat') {
                $('#company2').DataTable().clear().draw();
                $.ajax({
                        method: "POST",
                        url: "{{ route('master.banner.getCompany2') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: idbanner2
                        }
                    })
                    .done(function(data) {
                        $.each(data, function(i, val) {
                            if (val.status == 1) {
                                // untuk data company yang sudah dipilih ( jadi di check)
                                // $('#company2').DataTable().row.add([val.no,val.company,'<div class="checkbox"><input class="masuk2done" type="checkbox" value="'+val.id+'" checked disabled name="comp2done" ></div>']).draw();
                                $('#company2').DataTable().row.add([val.no,
                                    '<a target="_blank" href="{{ url('eksportir/listeksportir') }}/' +
                                    val.id + '">' + val.company + '</a>',
                                    '<div class="checkbox"><input class="masuk2done" type="checkbox" value="' +
                                    val.id + '" data-id="' + val.id +
                                    '" checked name="comp2done" ></div>'
                                ]).draw();
                                dataeksportir2.push(val.id);
                            } else {
                                // untuk data company yang belum dipilih ( jadi di uncheck)
                                // $('#company2').DataTable().row.add([val.no,val.company,'<div class="checkbox"><input class="masuk2" type="checkbox" value="'+val.id+'" data-id="'+val.id+'" name="comp2" ></div>']).draw();
                                $('#company2').DataTable().row.add([val.no,
                                    '<a target="_blank" href="{{ url('eksportir/listeksportir') }}/' +
                                    val.id + '">' + val.company + '</a>',
                                    '<div class="checkbox"><input class="masuk2done" type="checkbox" value="' +
                                    val.id + '" data-id="' + val.id + '" name="comp2done" ></div>'
                                ]).draw();

                            }
                        });
                    });
            } else {
                $('#company2').hide();
                $('#company2_wrapper').hide();
                $('.judulcompany2').hide();
            }
            $('#companylain2').DataTable().clear().draw();
            $.ajax({
                    method: "POST",
                    url: "{{ route('master.banner.getCompany') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: idbanner2,
                        tipe: 'lain'
                    }
                })
                .done(function(data) {
                    $.each(data, function(i, val) {
                        // get company
                        $('#companylain2').DataTable().row.add([val.no,
                            '<a target="_blank" href="{{ url('eksportir/listeksportir') }}/' + val
                            .id +
                            '">' + val.company + '</a>',
                            '<div><button type="button" class="btn btn-danger"  onclick="destroycompanylain2(' +
                            val.id + ')">Delete</button></div>'
                        ]).draw();

                    });
                });
            $('#pilihcompany2').show();
        }



        function simpanupdate2() {
            var id = $('#id2').val();
            var s_date = $('#s_date2').val();
            var semua = $('#semua2').val();
            var nama = $('#nama2').val();
            var tidaksemua = $('#tidaksemua2').val();
            var status = $('#status2').val();
            var order = $('#order2').val();
            var file = $('#file').val();
            var lastest_file = $('#lastest_file').val();
            console.log(dataeksportir2);
            console.log(nama);
            // $.each($("input[name='comp2']:checked"), function(){
            //           var val = $(this).val();
            //           if(dataeksportir2.includes(val)){

            //           }else{
            //               dataeksportir2.push($(this).val());
            //           }
            // });
            // (!isEmptyM(dataeksportir2) || semua == 1 ) &&
            if (s_date && (lastest_file != 'fileimagenya' || $file != null) && nama != null) {
                var form_data = new FormData();
                form_data.append('id', id);
                form_data.append('dataeksportir', dataeksportir2);
                form_data.append('s_date', s_date);
                form_data.append('nama', nama);
                form_data.append('hapussemua', tidaksemua);
                form_data.append('order', order);
                form_data.append('semua', semua);
                form_data.append('status', status);
                form_data.append('file', $('#file').prop('files')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}'
                    }
                });
                $.ajax({
                        method: "POST",
                        url: "{{ route('master.banner.store', 'update2') }}",
                        data: form_data,
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                    })
                    .done(function(e) {
                        if (e == 'sukses') {
                            window.location = "{{ route('master.banner.message') }}";
                        } else {
                            window.location = "{{ route('master.banner.message') }}";
                        }
                    });
            } else {
                alert('make sure you already fill all input in the form correctly');
            }
        }



        function destroycompanylain(id) {
            var jawab = confirm('Are You Sure ?');
            if (jawab == true) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('master.banner.deletecompanylain') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id_banner': $('#id').val(),
                        'id_perusahaan': id,
                    },
                    success: function(data) {
                        refreshtablecompanylain();
                        // $('#totaldistance').val(data.distance); 
                    }
                });
            }
        }

        function destroycompanylain2(id) {
            var jawab = confirm('Are You Sure ?');
            if (jawab == true) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('master.banner.deletecompanylain') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id_banner': $('#id2').val(),
                        'id_perusahaan': id,
                    },
                    success: function(data) {
                        refreshtablecompanylain2();
                        // $('#totaldistance').val(data.distance); 
                    }
                });
            }
        }

        function isEmptyM(obj) {
            for (var key in obj) {
                if (obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        }
    </script>

    @include('footer')

@endsection
