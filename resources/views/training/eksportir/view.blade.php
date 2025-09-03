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

        .modal-body {
            background-image: url('{{ url('/') }}/front/assets/img/cp/bg.png');
            background-size: cover;
            background-repeat: no-repeat;
            width: 100%;
            margin: 0px;
            background-color: transparent;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            height: 380px;
        }

        .modal-content {
            background-color: transparent;
            border: none;
        }

        .icon {
            width: 15%;
        }

        .cp-data {
            padding-left: 25px;
            color: white;
            font-size: 20px;
            font-family: arial;
            text-align: left !important;

            "}
    #times:hover {
                color: red !important;
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
                    <h3 class="mb-0">Training</h3>
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
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-hover" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>No</th>
                                    <th>Training</th>
                                    <th width="10%">Date</th>
                                    <th>Duration</th>
                                    <th>Topic</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Contact Person -->
    <div class="modal fade" id="modal_cp" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <table border="0" width="90%" align="center" height="30%">
                        <tr>
                            <td style="text-align: right !important;"><i class="fa fa-times" id="times"
                                    data-dismiss="modal" style="color: white !important; font-size: 24px !important;"></i>
                            </td>
                        </tr>
                    </table>
                    <table border="0" width="80%" align="center" style="margin-top: 10px;">
                        <tr>
                            <td class="icon" align="center"><img
                                    src="{{ url('/') }}/front/assets/img/cp/nama.png" height="100%"></td>
                            <td class="cp-data" style="text-transform: capitalize;"><span id="cp_name"></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div style="height: 8px;">
                                    <img src="{{ url('/') }}/front/assets/img/cp/line.png" width="100%" height="100%"
                                        style="vertical-align: top;">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="icon" align="center"><img
                                    src="{{ url('/') }}/front/assets/img/cp/phone.png" height="100%"></td>
                            <td class="cp-data"><span id="cp_phone"></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div style="height: 8px;">
                                    <img src="{{ url('/') }}/front/assets/img/cp/line.png" width="100%" height="100%"
                                        style="vertical-align: top;">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="icon" align="center"><img
                                    src="{{ url('/') }}/front/assets/img/cp/email.png" height="100%" height="100%">
                            </td>
                            <td class="cp-data"><span id="cp_email"></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div style="height: 8px;">
                                    <img src="{{ url('/') }}/front/assets/img/cp/line.png" width="100%"
                                        style="vertical-align: top;">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('training.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'training_en',
                        name: 'training_en'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'topic_en',
                        name: 'topic_en'
                    },
                    {
                        data: 'location_en',
                        name: 'location_en'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: 40,
                        className: "text-center"
                    },
                ],
                columnDefs: [{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:300px'>" + data + "</div>";
                    },
                    targets: 4
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:150px'>" + data + "</div>";
                    },
                    targets: 1
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:200px'>" + data + "</div>";
                    },
                    targets: 5
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:80px'>" + data + "</div>";
                    },
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

        function contact_person(id, id_training) {
            if (id != '-') {
                var pecah = id.split('|');
                $('#cp_name').html(pecah[0]);
                $('#cp_phone').html(pecah[1]);
                $('#cp_email').html(pecah[2]);
            } else {
                $('#cp_name').html('No Contact');
                $('#cp_phone').html('No Contact');
                $('#cp_email').html('No Contact');
            }

            var token = "{{ csrf_token() }}";
            var id = id_training;
            $.ajax({
                url: "{{ route('training.interest') }}",
                type: 'post',
                data: {
                    '_token': token,
                    id: id
                },
                dataType: 'json'
            });
            $('#modal_cp').modal('show');
        }
    </script>

    @include('footer')

@endsection
