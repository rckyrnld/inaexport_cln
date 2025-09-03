{{-- @include('header') --}}
@extends('header2')
@section('content')
    <style type="text/css">
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

        .table th {
            color: white;
            text-align: center;
        }

    </style>
    <!-- Page content -->
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                {{-- <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <!-- Header Title -->
                </div> --}}
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Export Destination</h3>
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
                    <div class="table-responsive">

                        <table id="tableexdes" class="table  table-bordered table-striped">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center> Exhibition</center>
                                    </th>
                                    <th>
                                        <center>Booth Area</center>
                                    </th>
                                    <th>
                                        <center>Value Contract</center>
                                    </th>
                                    <th>
                                        <center>Subsidi Djpen</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>

                        </table>
                        <br>
                        <a style="color: white" href="{{ url('eksportir/listeksportir/' . $id) }}"
                            class="btn btn-danger pull-right"><i style="color: white"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    @include('footer')
    <script>
        $(function() {
            $('#tableexdes').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('eksportir/exhibition_getdata_admin/' . $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'id_itdp_eks_event_profil',
                        name: 'id_itdp_eks_event_profil'
                    },
                    {
                        data: 'luas_boot',
                        name: 'luas_boot'
                    },
                    {
                        data: 'nilai_kontrak',
                        name: 'nilai_kontrak'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: 40,
                        className: "text-center"
                    }
                ]
            });
        });
    </script>
@endsection
