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

        th {
            text-align: center;
        }

        td {
            color: black;
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
                    <h3 class="mb-0">List Country</h3>
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
                    <a id="tambah" href="{{ route('master.country.create') }}" class="btn btn-primary ml-4"><i
                            class="fa fa-plus-circle"></i>
                        Add</a>
                    <a id="export" href="{{ route('master.country.export') }}" class="btn" target="_blank"><i
                            class="fa fa-print"></i> Export </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-hover" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>BPS Code</th>
                                    <th>Country</th>
                                    <th>Group</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                        </table>
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
        {{-- var msg = '{{Session::get('alert')}}'; --}}
        {{-- var exist = '{{Session::has('alert')}}'; --}}
        {{-- if(exist){ --}}
        {{-- alert(msg); --}}
        {{-- } --}}

        $(document).ready(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#table').DataTable({
                "order": [
                    [1, "asc"]
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('master.country.getData') }}",
                columns: [{
                        data: 'kode_bps',
                        name: 'kode_bps',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'group_country',
                        name: 'group_country'
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
