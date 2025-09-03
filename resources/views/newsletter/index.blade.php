@extends('header2')
@section('content')
    {{-- @include('header') --}}
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

        .table th {
            color: white;
            text-align: cente;
        }

    </style>
    &nbsp;

    {{-- <div class="container"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                {{-- <div class="box-header">
                </div> --}}
                {{-- <div class="card-header border-bottom">
                    <h3 class="mb-0">List News</h3>
                </div> --}}
                <div class="nav-active-border b-primary top box" style="margin-bottom: 0px;">
                    <div class="nav nav-md">
                        <a class="nav-link active" data-toggle="tab" data-target="#tab1">
                            <h5 style="font-size: 18px; font-weight: 600;">List Newsletter</h5>
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab2">
                            <h5 style="font-size: 18px; font-weight: 600;">Company</h5>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content p-3 mb-3">
                        <div class="tab-pane animate fadeIn text-muted active show" id="tab1">
                            <div class="row">
                                <a id="tambah" href="{{ route('newsletter.create') }}" class="btn"> <i
                                        class="fa fa-plus-circle"></i> Add </a>
                            </div><br>
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
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="table" class="table table-striped table-hover" data-plugin="dataTable">
                                        <thead class="text-white" style="background-color :#6B7BD6;">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">About</th>
                                                <th>Messages</th>
                                                <th>Created At</th>
                                                <th width="8%">Status</th>
                                                <th width="5%">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab2">
                            <div id="alert_box" class="alert alert-block" style="text-align: center; display: none;">
                                <strong><span id="alert_message"></span></strong>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="company" class="table table-striped table-hover" data-plugin="dataTable">
                                        <thead class="text-white" style="background-color: #6B7BD6;">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="350px">Company</th>
                                                <th>Email</th>
                                                <th width="200px">Status Newsletter</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($comp as $key => $data)
                                                <?php
                                                if ($data->newsletter == 1) {
                                                    $check = 'checked';
                                                    $value = 1;
                                                } else {
                                                    $check = '';
                                                    $value = 2;
                                                }
                                                ?>
                                                <tr>
                                                    <td>
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td>
                                                        {{ getProfileCompany($data->id_profil) }}
                                                    </td>
                                                    <td>
                                                        {{ $data->email }}
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" {{ $check }} data-toggle="toggle"
                                                            data-on="Active" data-off="Non Active" data-onstyle="info"
                                                            data-offstyle="default"
                                                            value="{{ $data->id }}|{{ $value }}"
                                                            id="toggle_company_{{ $data->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                }],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('newsletter.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    },
                    {
                        data: 'about',
                        name: 'about'
                    },
                    {
                        data: 'messages',
                        name: 'messages'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
