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
                    <h3 class="mb-0">Pajak</h3>
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
                    <a href="{{ url('/eksportir/tambah_taxes') }}" class="btn btn-primary pl-2 ml-4"><i
                            class="fa fa-plus-circle"></i>
                        Add</a><br><br>
                    <div class="table-responsive">
                        <table id="tabletaxes" class="table table-striped table-hover">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Year</center>
                                    </th>
                                    <th>
                                        <center>Laporan PPH</center>
                                    </th>
                                    <th>
                                        <center>Laporan PPN</center>
                                    </th>
                                    <th>
                                        <center>Laporan Pasal 21</center>
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
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        $(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#tabletaxes').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('datatables.taxes') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'tahun',
                        name: 'tahun',
                        className: "text-left"
                    },
                    {
                        data: 'laporan_pph',
                        name: 'laporan_pph'
                    },
                    {
                        data: 'laporan_ppn',
                        name: 'laporan_ppn'
                    },
                    {
                        data: 'laporan_psl21',
                        name: 'laporan_psl21'
                    },
                    {
                        data: 'setor_pph',
                        name: 'setor_pph',
                        render: $.fn.dataTable.render.number('.', '.', 0, ''),
                        className: "text-right"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: 40,
                        className: "text-center"
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
