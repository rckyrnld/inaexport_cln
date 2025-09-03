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

    #button:link,
    #button:visited,
    #button:active {
        color: white;
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

    input:read-only {
        background-color: white !important
    }

    /*CSS MODAL*/
    .modal-lg {
        width: 700px;
    }

    .modal-header {
        background-color: #2e899e;
        ;
        color: white;
        font-size: 20px;
        text-align: center;
    }

    .modal-body {
        height: 300px;
    }

    .modal-content {
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        overflow: hidden;
    }

    .modal-footer {
        background-color: #2e899e;
        ;
        color: white;
        font-size: 20px;
        text-align: center;
    }

    #Tablemodal td {
        text-align: left !important;
    }

    .table th {
        color: white;
        text-align: center;
    }


    /* .card {
                        background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                    }
                    .card-header {
                        background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                    } */
</style>

{{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Market Research</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block" style="text-align: center">
                        {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block mx-4" style="text-align: center">
                        {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if (Auth::user()->id_group != 11)
                    <a id="tambah" href="{{ route('admin.research-corner.create') }}" class="btn pl-2 ml-4"> <i
                            class="fa fa-plus-circle"></i> Add </a>
                    <a href="{{ url('cetakrc') }}" class="btn btn-success pl-2"> <i class="fa fa-download"></i> Export
                        Excel
                    </a>
                    @else
                    <a href="{{ url('cetakrc') }}" class="btn btn-success pl-2 ml-4"> <i class="fa fa-download"></i> Export
                        Excel
                    </a>
                    @endif

                    <div class="table-responsive pt-4 pl-0 pr-0">
                        <table id="table" class="table align-items-center table-striped table-hover"
                            data-plugin="dataTable" style="table-layout: fixed;">
                            <thead class="text-white" style="background-color:#6B7BD6; !important">
                                <tr>
                                    <th width="7%">No</th>
                                    <th>Title (EN)</th>
                                    <th>Type</th>
                                    <th>Country</th>
                                    <th>Download</th>
                                    <th>Publish Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--
</div> --}}

<!-- Modal Broadcast -->
<div class="modal fade" id="modal_broadcast" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <table width="100%">
                    <tr>
                        <td width="20%"></td>
                        <td width="60%"><span class="modal-title" id="exampleModalLabel" style="color:white"><b>
                                    <center>Broadcast Market Research</center>
                                </b></span></td>
                        {{-- <td width="60%"><span class="modal-title" id="exampleModalLabel"><b>Broadcast Market
                                    Research
                                </b></span></td> --}}
                        <td width="20%" align="pull-right">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => route('admin.research-corner.broadcast'), 'class' => 'form-horizontal', 'files'
                => true]) !!}
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
@include('footer')
<script type="text/javascript">
    $(document).ready(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.research-corner.getData') }}",
                deferRender: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'title_en',
                        name: 'title_en'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'download',
                        name: 'download'
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
                        width: 120,
                        className: "text-center"
                    }
                ],
                columnDefs: [{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap width-10'>" + data + "</div>";
                    },
                    targets: 1
                }, {
                    width: 30,
                    targets: 0
                }, {
                    width: 150,
                    targets: -1
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
@endsection