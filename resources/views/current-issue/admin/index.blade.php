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
                    <h3 class="mb-0">List Trade Update</h3>
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

                    <a href="{{ route('admin.curris.create') }}" class="btn btn-primary ml-4"><i
                            class="fa fa-plus-circle"></i>
                        Add</a><br><br>

                    <div class="table-responsive">
                        <table id="table-curris" class="table table-striped table-hover" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th width="7%">
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>Title (EN)</center>
                                    </th>
                                    <th>
                                        <center>Country</center>
                                    </th>
                                    <th>
                                        <center>Publish Date</center>
                                    </th>
                                    <th width="15%">
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
    <div class="modal fade" id="modal_broadcast" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <table width="100%">
                        <tr>
                            <td width="20%"></td>
                            <td width="60%"><span class="modal-title" id="exampleModalLabel"><b>Broadcast Market
                                        Research</b></span></td>
                            <td width="20%" align="pull-right">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url' => route('admin.research-corner.broadcast'), 'class' => 'form-horizontal', 'files' => true]) !!}
                    <input type="hidden" name="research" id="research">
                    <table width="100%" style="font-size: 15px;" id="Tablemodal">
                        <tr>
                            <td width="30%" style="padding-left: 20px; padding-top: 33px; ">Title Market Research</td>
                            <td width="70%" style="padding-top: 40px;" colspan="2"><input type="text" readonly id="title_en"
                                    name="title_en" class="form-control" style="width: 90% !important;"></td>
                        </tr>
                        <tr>
                            <td width="30%" style="padding-left: 20px; padding-top: 13px;">Categori Product</td>
                            <td width="70%" style="padding-top: 20px;" colspan="2">
                                <select class="form-control" id="categori" style="width: 90% !important;" width="90%"
                                    name="categori[]" multiple="multiple" required>{{ optionCategory() }}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%" style="padding-left: 20px;"></td>
                            <td width="35%" style="padding-top: 40px;">
                                <button type="submit" class="btn btn-info"
                                    style="background-color: #1a9cf9; width: 50%;">Send</button>
                            </td>
                            <td width="35%" style="padding-top: 40px;">
                                <button class="btn btn-danger" style="width: 50%;" data-dismiss="modal"
                                    aria-label="Close">Cancel</button>
                            </td>
                        </tr>
                    </table>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <table width="100%">
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
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
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#table-curris').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.curris.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'title_en',
                        name: 'title_en',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'country',
                        name: 'country',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date',
                        name: 'date'
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
                        return "<div class='text-wrap' style='width:300px'>" + data + "</div>";
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

            $('#categori').select2({
                sorter: function(data) {
                    return data.sort(function(a, b) {
                        return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                    });
                }
            }).on("select2:select", function(e) {
                $('.select2-selection__rendered li.select2-selection__choice').sort(function(a, b) {
                    return $(a).text() < $(b).text() ? -1 : $(a).text() > $(b).text() ? 1 : 0;
                }).prependTo('.select2-selection__rendered');
            });
        });

        function broadcast(id) {
            $('#categori').val('');
            $('#categori').trigger('change');
            var data = id.split("||");
            $('#title_en').val(data[0]);
            $('#research').val(data[1]);
            $('#modal_broadcast').modal('show');
        }
    </script>

    @include('footer')

@endsection
