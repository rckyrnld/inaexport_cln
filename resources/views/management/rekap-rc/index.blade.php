@extends('header2')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                    <h3 class="mb-0">Market Research Recapitulation</h3>
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

                    <div class="card shadow">
                        <div class="card-body pl-0 pr-0">
                            <h3 style="text-align: center">Based on Market Research Title</h3>
                            <br>
                            <div class="row">
                                <div class="col-md-10"></div>
                                <div class="col-md-1"><button class="btn btn-primary" id="cetakrc"><i
                                            class="fas fa-print"></i> Print XLX</button></div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="tablerc" class="table align-items-center table-striped table-hover"
                                    data-plugin="dataTable">
                                    <thead class="text-white" style="background-color: #6B7BD6;">
                                        <tr>
                                            <th>No</th>
                                            <th>Market Research</th>
                                            <th>Download</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <divc class="card-body pl-0 pr-0">
                            <h3 style="text-align: center">Based on Company</h3>
                            <br>
                            <div class="row">
                                <div class="col-md-10"></div>
                                <div class="col-md-1"><button class="btn btn-primary" id="cetakcomp"><i
                                            class="fas fa-print"></i> Print XLX</button></div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="tablecomp" class="table table-striped table-hover" style="/*display: none*/"
                                    data-plugin="dataTable">
                                    <thead class="text-white" style="background-color: #6B7BD6;">
                                        <tr>
                                            <th>No</th>
                                            <th>Company Name</th>
                                            <th>Download</th>
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
            $("#tanggal_awal").flatpickr({
                allowInput: true,
                // altInput: true,
                // altFormat: "j F Y  ( H:i )",
                dateFormat: "d-m-Y",
                // enableTime: true,
            });

            $("#tanggal_akhir").flatpickr({
                allowInput: true,
                // altFormat: "j F Y  ( H:i )",
                // altInput: true,
                dateFormat: "d-m-Y",
                // enableTime: true,
            });
        });
        $(document).ready(function() {

            var table = $('#tablerc').DataTable({
                "processing": true,
                "serverSide": true,
                "retrieve": true,
                "ajax": {
                    "url": '{!! route('rekaprc1.getData') !!}',
                    "dataType": "json",
                    "type": "GET",
                    "data": function(data) {
                        data._token = '{{ csrf_token() }}';
                        // data.tipe = $('#tipe').val();
                        // data.tanggalawal = $('#tanggal_awal').val();
                        // data.tanggalakhir = $('#tanggal_akhir').val();
                    }
                    {{-- {_token: '{{csrf_token()}}', _id:$('#tahun').val(),_status : $('#status').val()} --}}
                },
                "columns": [{
                        data: 'no',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'rc'
                    },
                    {
                        data: 'download'
                    },
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });

            var table2 = $('#tablecomp').DataTable({
                "processing": true,
                "serverSide": true,
                "retrieve": true,
                "ajax": {
                    "url": '{!! route('rekaprc2.getData') !!}',
                    "dataType": "json",
                    "type": "GET",
                    "data": function(data) {
                        data._token = '{{ csrf_token() }}';
                    }
                    {{-- {_token: '{{csrf_token()}}', _id:$('#tahun').val(),_status : $('#status').val()} --}}
                },
                "columns": [{
                        data: 'no',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'company'
                    },
                    {
                        data: 'download'
                    },
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });

            $('#cetakrc').on('click', function(e) {
                console.log('ke klik');
                window.location.href = "{{ route('cetakrc1.printcsv') }}";
            });

            $('#cetakcomp').on('click', function(e) {
                console.log('ke klik');
                window.location.href = "{{ route('cetakrc2.printcsv') }}";
            });

            {{-- $('#btnrc').on('click', function (e) { --}}
            {{-- console.log('ke klik'); --}}
            {{-- window.location.href = "{{route('cetakrc1.printcsv')}}"; --}}
            {{-- }); --}}

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

        function isEmptyM(obj) {
            for (var key in obj) {
                if (obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        }

        function clicksend() {
            var tipe = $('#tipe').val();
            var tanggal_awal = $('#tanggal_awal').val();
            var tanggal_akhir = $('#tanggal_akhir').val();

            console.log(tipe);
            console.log(tanggal_awal);
            console.log(tanggal_akhir);

            if (tipe != 0 && tanggal_awal != null && tanggal_akhir != null) {
                document.getElementById('table').removeAttribute("style");
                $("#table").dataTable().fnDestroy()
                var table = $('#table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "retrieve": true,
                    "ajax": {
                        "url": '{!! route('rekapang.getData') !!}',
                        "dataType": "json",
                        "type": "GET",
                        "data": function(data) {
                            data._token = '{{ csrf_token() }}';
                            data.tipe = $('#tipe').val();
                            data.tanggalawal = $('#tanggal_awal').val();
                            data.tanggalakhir = $('#tanggal_akhir').val();
                        }
                        {{-- {_token: '{{csrf_token()}}', _id:$('#tahun').val(),_status : $('#status').val()} --}}
                    },
                    "columns": [{
                            data: 'no'
                        },
                        {
                            data: 'nama_perusahaan'
                        },
                        {
                            data: 'tanggal_register'
                        },
                        {
                            data: 'tanggal_verifikasi'
                        },
                    ],
                    language: {
                        processing: "Sedang memproses...",
                        lengthMenu: "Tampilkan _MENU_ entri",
                        zeroRecords: "Tidak ditemukan data yang sesuai",
                        emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                        infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                        infoPostFix: "",
                        search: "Cari:",
                        url: "",
                        infoThousands: ".",
                        loadingRecords: "Sedang memproses...",
                        paginate: {
                            first: "<<",
                            last: ">>",
                            next: "Selanjutnya",
                            previous: "Sebelum"
                        },
                        aria: {
                            sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                            sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                        }
                    }
                });
            } else {
                alert('choose user type, start date , end date');
            }
        }
    </script>

    @include('footer')

@endsection
