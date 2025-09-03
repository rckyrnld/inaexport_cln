{{-- @include('header') --}}
@extends('header2')
@section('content')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
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

        .modal-md {
            width: 600px;
        }

        .style-font {
            font-size: 18px;
            font-weight: 700;
            color: black;
        }

        #broadcast {
            background-color: #29bbd8;
        }

        #broadcast:hover {
            background-color: #1cabc7;
        }

        #close {
            background-color: #f92222;
        }

        #close:hover {
            background-color: #f10000;
        }

        .toggle.btn.btn-info {
            width: 50% !important;
        }

        .toggle.btn.btn-default.off {
            width: 50% !important;
        }

        #tambah {
            background-color: #1a9cf9;
            color: white;
            white-space: pre;
        }

        #tambah:hover {
            background-color: #148de4
        }

        .table th {
            color: white;
            text-align: center;
        }

    </style>
    &nbsp;

    {{-- <div class="container"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                {{-- <div class="box-header">
                </div> --}}
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List News</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <a id="tambah" href="{{ route('news.create') }}" class="btn pl-3 ml-4"><i
                            class="fa fa-plus-circle"></i>&nbsp;Add</a>

                    <div class="table-responsive pt-4 pl-0 pr-0">
                        <table id="table" class="table align-items-center table-striped table-hover"
                            data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Judul</th>
                                    <th>Tgl Posting</th>
                                    <th width="8%">Aktif</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Broadcast -->
    <div class="modal fade" id="modal_broadcast" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" style="background-color: transparent;">
                <div class="modal-body" style="height: 220px; background-color: #ffc000; border-radius: 6px;">
                    {!! Form::open(['url' => route('newsletter.broadcast'), 'class' => 'form-horizontal', 'files' => true]) !!}
                    <input type="hidden" name="newsletter" id="newsletter">
                    <div class="row" style="margin-bottom: 30px;">
                        <div class="col-md-12 style-font" align="center">Validation</div>
                    </div>
                    <div class="row justify-content-center" style="margin-bottom: 30px;">
                        <div class="col-md-10 style-font" align="center">Are you sure to share this information to
                            Newsletter ?</div>
                    </div>
                    <table width="100%">
                        <tr>
                            <td width="50%" class="text-right pr-2"><button type="submit" class="btn text-white" id="broadcast"
                                    style="width: 70%">Broadcast</button></td>
                            <td width="50%"><button class="btn text-white" id="close" data-dismiss="modal"
                                    aria-label="Close" style="width: 70%">Cancel</button></td>
                        </tr>
                    </table>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".alert").not("#alert_box").slideDown(300).delay(2000).slideUp(500);
            $('#company').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": 3
                }]
            });
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('news.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
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
                ],
                columnDefs: [{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:500px'>" + data + "</div>";
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
            $('input[type="checkbox"]').on('change', function(event) {
                $('#alert_box').removeClass("alert-success");
                $('#alert_box').removeClass("alert-danger");
                var ambilsemua = this.value;
                var ambil = ambilsemua.split('|');
                if (confirm('Are you sure?')) {
                    var id = 'toggle_company_' + ambil[0];
                    $.ajax({
                        method: "POST",
                        url: "{{ route('newsletter.toggleCompany') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: ambilsemua
                        }
                    }).done(function(msg) {
                        if (msg == 'Success') {
                            if (ambil[1] == 1) {
                                var hasil = ambil[0] + '|2';
                            } else {
                                var hasil = ambil[0] + '|1';
                            }
                            $('#' + id).val(hasil);
                            $('#alert_box').addClass("alert-success");
                            $('#alert_message').html("Success change status");
                            $('#alert_box').slideDown(300).delay(1000).slideUp(500);
                        } else {
                            $('#alert_box').addClass("alert-danger");
                            $('#alert_message').html("Failed change status");
                            $('#alert_box').slideDown(300).delay(1000).slideUp(500);

                            if (ambil[1] == 1) {
                                $('#' + id).unbind();
                                $('#' + id).bootstrapToggle('on')
                                $('#' + id).bind('change', toggle_company);
                            } else {
                                $('#' + id).unbind();
                                $('#' + id).bootstrapToggle('off')
                                $('#' + id).bind('change', toggle_company);
                            }
                        }
                    });
                } else {
                    if (ambil[1] == 1) {
                        $(this).unbind();
                        $(this).bootstrapToggle('on')
                        $(this).bind('change', toggle_company);
                    } else {
                        $(this).unbind();
                        $(this).bootstrapToggle('off')
                        $(this).bind('change', toggle_company);
                    }
                }
            });
        });

        function toggle_company() {
            $('#alert_box').removeClass("alert-success");
            $('#alert_box').removeClass("alert-danger");
            var ambilsemua = this.value;
            var ambil = ambilsemua.split('|');
            if (confirm('Are you sure?')) {
                var id = 'toggle_company_' + ambil[0];
                $.ajax({
                    method: "POST",
                    url: "{{ route('newsletter.toggleCompany') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: ambilsemua
                    }
                }).done(function(msg) {
                    if (msg == 'Success') {
                        if (ambil[1] == 1) {
                            var hasil = ambil[0] + '|2';
                        } else {
                            var hasil = ambil[0] + '|1';
                        }
                        $('#' + id).val(hasil);
                        $('#alert_box').addClass("alert-success");
                        $('#alert_message').html("Success change status");
                        $('#alert_box').slideDown(300).delay(1000).slideUp(500);
                    } else {
                        $('#alert_box').addClass("alert-danger");
                        $('#alert_message').html("Failed change status");
                        $('#alert_box').slideDown(300).delay(1000).slideUp(500);

                        if (ambil[1] == 1) {
                            $('#' + id).unbind();
                            $('#' + id).bootstrapToggle('on')
                            $('#' + id).bind('change', toggle_company);
                        } else {
                            $('#' + id).unbind();
                            $('#' + id).bootstrapToggle('off')
                            $('#' + id).bind('change', toggle_company);
                        }
                    }
                });
            } else {
                if (ambil[1] == 1) {
                    $(this).unbind();
                    $(this).bootstrapToggle('on')
                    $(this).bind('change', toggle_company);
                } else {
                    $(this).unbind();
                    $(this).bootstrapToggle('off')
                    $(this).bind('change', toggle_company);
                }
            }
        }

        function broadcast(id) {
            $('#newsletter').val(id);
            $('#modal_broadcast').modal('show');
        }
    </script>
@endsection
