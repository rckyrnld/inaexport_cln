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
                    <h3 class="mb-0">List Service</h3>
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
                        <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>Name</th>
                                    <th width="15%">Field of Works</th>
                                    <th width="15%">Skills</th>
                                    <th width="30%">Experiences (DN/LN)</th>
                                    <th width="10%">Links</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                "ordering": false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('service.getData', $id) }}",
                columns: [{
                        data: 'nama_en',
                        name: 'nama_en'
                    },
                    {
                        data: 'bidang_en',
                        name: 'bidang_en'
                    },
                    {
                        data: 'skill_en',
                        name: 'skill_en'
                    },
                    {
                        data: 'pengalaman_en',
                        name: 'pengalaman_en'
                    },
                    {
                        data: 'link',
                        name: 'link'
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
