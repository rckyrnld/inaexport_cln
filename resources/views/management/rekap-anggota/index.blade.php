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
            text-align: center;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Member Recapitulation</h3>
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
                    <div class="form-group row">
                        <br>
                        <div class="col-md-3">
                            <select id="tipe" class="form-control select2" required>
                                <option value="0"> -- Choose user type --</option>
                                <option value="2">Indonesian Exporter</option>
                                <option value="3">Buyer</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="tanggal_awal" placeholder="Register Date From"
                                style="background-color: white;" readonly required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="tanggal_akhir" placeholder="Register Date Until"
                                style="background-color: white;" readonly required>
                        </div>
                        <div class="col-md-1">
                            <button id="click" onclick="clicksend()" class="btn btn-info"> Send </button>
                        </div>
                        <div class="col-md-1" id="divcetakra" style="display: none">
                            <button class="btn btn-primary" id="cetakra">Print XLX</button>
                        </div>
                    </div>
                    <div class="col-md-14"><br>
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-hover" style="display: none"
                                data-plugin="dataTable">
                                <thead class="text-white" style="background-color: #6B7BD6;">
                                    <tr>
                                        <th>No</th>
                                        <th>Company Name</th>
                                        <th>Register Date</th>
                                        <th>Verification Date</th>
                                    </tr>
                                </thead>
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
            $('#cetakra').on('click', function(e) {
                console.log('ke klik');
                window.location.href = "{{ route('cetakra.printcsv') }}?tipe=" + $('#tipe').val() +
                    "&start=" + $('#tanggal_awal').val() + "&end=" + $('#tanggal_akhir').val();
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
                document.getElementById('divcetakra').removeAttribute("style");
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
                            data: 'no',
                            width: 5,
                            className: "text-center"
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
                    "language": {
                        "paginate": {
                            "previous": "<i class='fa fa-angle-left'/></>",
                            "next": "<i class='fa fa-angle-right'/></>"
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
