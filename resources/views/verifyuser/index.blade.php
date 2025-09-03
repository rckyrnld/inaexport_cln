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

        /* .card {
                        background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                    }
                    .card-header {
                        background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                    } */

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">{{ $pageTitle }}</h3>
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
                    {{-- @if (Auth::user()->id_admin_dn != 0)
                        <a id="tambah" href="{{ route('addexpor') }}" class="btn"> <i
                                class="fa fa-plus-circle"></i> Add </a>
                    @endif --}}
                    <div class="row">
                        <div class="col-md-3 ml-5">
                            <select id="filter" name="filter" class="form-control" onchange="filtering()">
                                <option value="0">Choose Filter</option>
                                <option value="1">Unverified</option>
                                <option value="2">Verified</option>
                                <option value="3">Notverified</option>
                                <option value="4">Membership Unverified</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <div class="table-responsive">

                            <table id="users-table" class="table table-striped table-hover">
                                <thead class="text-white" style="background-color: #6B7BD6;">
                                    {{-- @if (Auth::guard('admin')->user()->grup_user == 11 || Auth::guard('admin')->user()->grup_user == 5) --}}
                                    <tr id="ktr">
                                        <th colspan="14">
                                            <center>
                                                <p id="text-counter">0 data terpilih</p>
                                                <button data-toggle="modal" data-target="#modalMultiDelete"
                                                    class="btn btn-sm btn-danger" id="btn-multidelete" type="button"
                                                    style="display:none;"><i class="fa fa-trash"></i> Hapus </button>
                                                <br><br><button type="button" onclick="checkAll()"
                                                    class="btn btn-info">Select All</button> <button type="button"
                                                    onclick="uncheckAll()" class="btn btn-danger">Uncheck All</button>
                                            </center>
                                        </th>
                                    </tr>
                                    {{-- @endif --}}
                                    <!-- <tr>
                                                <th>No</th>
                                                <th>
                                                    <center>Company</center>
                                                </th>
                                                <th>
                                                    <center>Email</center>
                                                </th>
                                                <th>
                                                    <center>Zip Code</center>
                                                </th>
                     <th>
                                                    <center>Telephone</center>
                                                </th>
                     
                     <th>
                                                    <center>Last Activity</center>
                                                </th>
                                                <th>
                                                    <center>Email Confirmation</center>
                                                </th>
                     <th>
                                                    <center>Verify By Admin</center>
                                                </th>
                                                <th width="10%">
                                                    <center>Verify Date</center>
                                                </th>
                                                <th width="10%">
                                                    <center>Action</center>
                                                </th>
                                            </tr> -->
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            <center><i class="fa fa-check"></i></center>
                                        </th>
                                        <th>
                                            <center>Company</center>
                                        </th>
                                        <th>
                                            <center>Email</center>
                                        </th>
                                        {{-- <th>
                                        <center>PIC Name</center>
                                    </th>
									<th>
                                        <center>PIC Telephone</center>
                                    </th> --}}
                                        <th>
                                            <center>Register Date</center>
                                        </th>
                                        {{-- <th>
                                            <center>Last Activity</center>
                                        </th> --}}
                                        <th>
                                            <center>NPWP</center>
                                        </th>
                                        <th width="10%">
                                            <center>Action</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
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

    {{-- modal multiple deletion --}}
    <div class="modal fade" id="modalMultiDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title updatePJP" id="exampleModalLabel"><i class="fa fa-times"></i> Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div role="content">
                    <div class="widget-body">
                        <div class="row">
                            <div class="modal-body">
                                <div class="col-sm-12" id="catatan">
                                    Apakah anda yakin untuk menghapus <span id="jumlah">0</span> data?
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ url('/verifyuser/delete_multiple') }}" method="post" id="form-multidelete">
                                    {{ csrf_field() }}
                                    <div class="col-sm-12  float-right">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                        <button type="submit" id="button-submit" class="btn btn-success"
                                            style="display:none" form="form-multidelete">Konfirmasi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal multiple deletion --}}

    <script type="text/javascript">
        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }
        $(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: 200,
                scroller: {
                    loadingIndicator: true
                },
                autoWidth: true,
                ajax: "{{ url('geteksportir') }}",
                columns: [{
                        data: 'row',
                        name: 'row',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ceklis',
                        name: 'ceklis',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'company',
                        name: 'itdp_profil_eks.company',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'itdp_company_users.email',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'name', 
                    //     name: 'name', 
                    //     orderable: true, 
                    //     searchable: true
                    // },
                    // {
                    //     data: 'phone', 
                    //     name: 'phone', 
                    //     orderable: true, 
                    //     searchable: true
                    // },
                    {
                        data: 'created_at',
                        name: 'itdp_company_users.created_at',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'keterangan',
                    //     name: 'keterangan',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'npwp',
                        name: 'itdp_profil_eks.npwp',
                        orderable: true,
                        searchable: true
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
                        return "<div>" + data + "</div>";
                    },
                    targets: 2
                }, {
                    width: 25,
                    targets: 0
                }, {
                    width: 100,
                    targets: -1
                }],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                },
                "preDrawCallback": function() {
                    uncheckAll();
                },
                "fnDrawCallback": function() {
                    $('input[type=checkbox]').change(function() {
                        if ($(this).is(':checked')) {
                            c = c + 1;
                            $('#text-counter').html(c + ' data terpilih');
                            $('#jumlah').html(c);
                        } else {
                            c = c - 1;
                            $('#text-counter').html(c + ' data terpilih');
                            $('#jumlah').html(c);
                        }
                        if (c > 0) {
                            $('#button-submit').fadeIn();
                            $('#text-ket').fadeIn();
                            $('#btn-multidelete').fadeIn();
                        } else {
                            $('#button-submit').fadeOut();
                            $('#text-ket').fadeOut();
                            $('#btn-multidelete').fadeOut();
                        }
                    });
                }
            });
        });

        // ajax: "{{ url('geteksportir') }}",  
        // data: {filternya : yangdiselect},
        // "data": {_token: '{{ csrf_token() }}'}

        function filtering() {
            var yangdiselect = $('#filter').val();
            console.log(yangdiselect);
            $('#users-table').DataTable().destroy();
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('geteksportir') }}",
                    data: function(d) {
                        d.filternya = yangdiselect;
                        d._token = '{{ csrf_token() }}';
                    },
                },
                columns: [{
                        data: 'row',
                        name: 'row',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ceklis',
                        name: 'ceklis',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'company',
                        name: 'itdp_profil_eks.company',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'itdp_company_users.email',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'name',
                    //     name: 'name',
                    //     orderable: true,
                    //     searchable: true
                    // },
                    // {
                    //     data: 'phone',
                    //     name: 'phone',
                    //     orderable: true,
                    //     searchable: true
                    // },
                    {
                        data: 'created_at',
                        name: 'itdp_company_users.created_at',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'keterangan',
                    //     name: 'keterangan',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'npwp',
                        name: 'itdp_profil_eks.npwp',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'f8', name: 'f8', orderable: false, searchable: false
                    // },
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
                },
                "preDrawCallback": function() {
                    uncheckAll();
                },
                "fnDrawCallback": function() {
                    $('input[type=checkbox]').change(function() {
                        if ($(this).is(':checked')) {
                            c = c + 1;
                            $('#text-counter').html(c + ' data terpilih');
                            $('#jumlah').html(c);
                        } else {
                            c = c - 1;
                            $('#text-counter').html(c + ' data terpilih');
                            $('#jumlah').html(c);
                        }
                        if (c > 0) {
                            $('#button-submit').fadeIn();
                            $('#text-ket').fadeIn();
                            $('#btn-multidelete').fadeIn();
                        } else {
                            $('#button-submit').fadeOut();
                            $('#text-ket').fadeOut();
                            $('#btn-multidelete').fadeOut();
                        }
                    });
                }
            });

            // table.column( $(this).data('status').search( $(this).val() ).draw();
        }
    </script>

    @include('footer')

    <script type="text/javascript">
        // $(function(){
        var c = 0;

        function checkAll() {
            var arrDelete = document.getElementsByName("deletion[]");
            var len = arrDelete.length;
            for (var i = 0; i < len; i++) {
                if (!arrDelete[i].checked) {
                    arrDelete[i].checked = true;
                    c++;
                }
            }
            if (c > 0) {
                $('#button-submit').fadeIn();
                $('#text-ket').fadeIn();
                $('#btn-multidelete').fadeIn();
            }
            $('#text-counter').html(c + ' data terpilih');
            $('#jumlah').html(c);
        }

        function uncheckAll() {
            var arrDelete = document.getElementsByName("deletion[]");
            var len = arrDelete.length;
            for (var i = 0; i < len; i++) {
                if (arrDelete[i].checked) {
                    arrDelete[i].checked = false;
                    c--;
                }
            }
            $('#text-counter').html(c + ' data terpilih');
            $('#jumlah').html(c);
            if (c < 1) {
                $('#button-submit').fadeOut();
                $('#text-ket').fadeOut();
                $('#btn-multidelete').fadeOut();
            }
        }
        // });
    </script>
@endsection
