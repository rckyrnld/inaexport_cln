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
                <h3 class="mb-0">List CS Admin</h3>
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

                            <table id="tabletaxes" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #C4C4C4;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Year</center>
                                    </th>
                                    <th>
                                        <center>Report PPH</center>
                                    </th>
                                    <th>
                                        <center>Report PPN</center>
                                    </th>
                                    <th>
                                        <center>Report Pasal 21</center>
                                    </th>
                                    <th>
                                        <center>Total PPH</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>

                            </table>
                            <br>
                            <a style="color: white" href="{{ url('eksportir/listeksportir/'.$id) }}"
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
    $(function () {
        $('#tabletaxes').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/taxes_getdata_admin/'.$id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'tahun', name: 'tahun'},
                {data: 'laporan_pph', name: 'laporan_pph'},
                {data: 'laporan_ppn', name: 'laporan_ppn'},
                {data: 'laporan_psl21', name: 'laporan_psl21'},
                {data: 'setor_pph', name: 'setor_pph'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
@endsection