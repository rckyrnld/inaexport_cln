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

        /* .card {
                            background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                        }
                        .card-header {
                            background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                        } */

        #users-table th {
            color: white;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Representative</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <a href="{{ url('tambahperwakilan') }}" class="btn btn-primary ml-4"><i class="fa fa-plus-circle"></i>
                        Add</a>
                    <br></br>
                    <div class="table-responsive">
                        <table id="users-table" class="table table-striped table-hover">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Nama Kantor</center>
                                    </th>
                                    <th>
                                        <center>Scope</center>
                                    </th>
                                    <th>
                                        <center>Type</center>
                                    </th>
                                    <th>
                                        <center>Email</center>
                                    </th>
                                    <th>
                                        <center>Website</center>
                                    </th>


                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--
                                            <?php $i=1; foreach($data as $row){ ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><center><?php echo $row->name; ?></center></td>
                                                <td><center><?php echo $row->email; ?></center></td>
                                                <td><center><?php echo $row->website; ?></center></td>
                                                
                                                
                                                <td><center><?php if ($row->id_group == 4) {
                                                    echo 'Perwadag';
                                                } else {
                                                    echo 'Dinas';
                                                } ?></center></td>
                                                <td><center><?php echo $row->type; ?></center></td>
                                                <td><center>
                                                <a class="btn btn-danger" href="{{ url('hapusperwakilan/' . $row->id) }}"><i class="fa fa-trash"></i> Hapus</a>
                                                </center></td>
                                            </tr> 
                                            <?php $i++; } ?>
                                            -->
                            </tbody>

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
        $(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('getpw') }}",
                columns: [{
                        data: 'row',
                        name: 'row',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'f1',
                        name: 'f1'
                    },
                    {
                        data: 'f6',
                        name: 'f6',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'f7',
                        name: 'f7',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'f2',
                        name: 'f2'
                    },
                    {
                        data: 'f3',
                        name: 'f3'
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
                columnDefs: [{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap width-200'>" + data + "</div>";
                    },
                    targets: 1
                }],
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
