<style>
    .list-group-item {
        background-color: #e9e9ff;
        border: none;
    }

    .eksporter-product {
        padding: 5% 1% 5% 1%;
    }

    .eksporter-product .list-group-item {
        background-color: white;
    }

    .a-eksporter {
        text-decoration: none;
        color: black;
        height: auto;
    }

    @media only screen and (max-width: 767px) {
        .a-eksporter {
            height: auto;
        }
    }

    .a-eksporter:hover {
        text-decoration: none;
    }

    .eksporter_img {
        width: 50%;
    }

    .name-eksporter {
        font-size: 13px;
    }

    .single_product {
        padding: 10px 8px 18px 18px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin: 1px;
    }

    /* .eksporter-detail:hover{
        background-color: #e9e9ff;
    } */

    .eksporter-detail a:hover {
        text-decoration: none;
    }

    .eksporter-product .list-group a:hover {
        background-color: #e9e9ff;
    }

    .caption-btn {
        float: right;
        margin-right: 0px;
    }

    table,
    th,
    tr,
    td {
        text-align: left !important;
    }

    /* .card {
        background: radial-gradient(circle at top left, #E0F1F3, #BDF1DA);
    }
    .card-header {
        background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
    } */
    .single_product {
        background-color: #fff;
    }

    .cardevent:hover {
        text-decoration: none;
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

    .cardevent button.active {
        color: white;
    }

</style>

@extends('header2')
@section('content')
    <meta name=”csrf-token” content=”{{ csrf_token() }}”>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Trade Event</h3>
                </div>
                <div class="card-body">
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

                        @if (Auth::user()->id_group == 11)
                            <span class="btn" style="margin-top:-20px; margin-left:-10px"></i>&nbsp;</span>
                        @else
                            <a class="btn" href="{{ url('event/create') }}"
                                style="background-color: #1089ff; color: white; margin-top:-20px; margin-left:-10px"><i
                                    class="fa fa-plus-circle"></i>&nbsp; Add
                            </a>

                        @endif

                        <div class="col-md-5" style="float: right; margin-top:-20px">
                            <form action="{{ url('/') }}/event/search" method="POST" role="search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input style="border-top-left-radius: 15px; border-bottom-left-radius:15px;" type="text"
                                        class="form-control" name="q" placeholder="Search Menu Name..."
                                        autocomplete="off" value="{{ $q }}">
                                    <button
                                        style="font-weight:bold; background-color: #ffe300; color: #1d7bff; border-top-right-radius: 15px; border-bottom-right-radius:15px; margin-right:-20px"
                                        type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--exporter report start -->
                    <div class="row shop_wrapper">
                        @foreach ($e_detail as $ed)
                            <div class="col-lg-3 col-md-4 col-12 ">
                                <div class="single_product mt-3 cardevent"
                                    style="padding-bottom: 0px; margin-bottom: 10px; ">
                                    <div class="product_content grid_content" style="margin-top: 0px;">
                                        <div style="height: 100px; margin-top:20px; margin-left:15px; margin-right:15px">
                                            <center>
                                                <div class="imge">
                                                    @if ($ed->image_1 !== null)
                                                        <?php $topZ = 'margin-top: -100px;'; ?>
                                                        <img src="{{ url('/') }}/uploads/Event/Image/{{ $ed->id }}/{{ $ed->image_1 }}"
                                                            class="img-fluid img-thumbnail" style="height: 140px;">
                                                    @else
                                                        <?php $topZ = 'margin-top: -145px;'; ?>
                                                        <img src="{{ url('/') }}/image/event/NoPicture.png"
                                                            alt="No Picture" class="img-fluid" style="height: 140px;">
                                                    @endif
                                                </div>
                                                <div align="right">
                                                    @if ($ed->status_en == 'Verified')
                                                        <img src="{{ url('/') }}/image/event/ceklis.png"
                                                            class="">
                                                    @endif
                                                </div>
                                            </center>

                                        </div>

                                        <div class="eksporter-product" style="overflow-y: auto; margin-top:60px">
                                            <div class="list-group" style="font-size: 12px;height: 100px;">
                                                <?php
                                                $title = $ed->event_name_en;
                                                if (strlen($title) > 43) {
                                                    $cut_text = substr($title, 0, 43);
                                                    if ($title[43 - 1] != ' ') {
                                                        // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                        $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                        $cut_text = substr($title, 0, $new_pos);
                                                    }
                                                    $titleName = $cut_text . '...';
                                                } else {
                                                    $titleName = $title;
                                                }
                                                ?>
                                                <table border="0" style="width: 100%;">
                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            {{ $titleName }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            <b>Start Date - End Date</b>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            {{ date('d M Y', strtotime($ed->start_date)) }} -
                                                            {{ date('d M Y', strtotime($ed->end_date)) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 15px;">
                                                            Participants: <a style="text-decoration: none;"
                                                                href="javascript:void(0)" data-toggle="modal"
                                                                data-event-id="{{ $ed->id }}"
                                                                data-event-name="{{ $titleName }}"
                                                                class="btn-participants"
                                                                data-target="#exampleModalParticipant">{{ count($ed->participants) }}</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        @if (Auth::user()->id_group != 11)
                                            <div class="eksporter-detail"
                                                style="border-top: 1px solid #DDEFFD; padding: 4%;">
                                                <center>
                                                    <a onclick="ihid(<?php echo $ed->id; ?>)" style="display: none;"
                                                        data-toggle="modal" data-target="#myModal" class="btn btn-info"
                                                        title="Broadcast">
                                                        <font color="white"><i class="fa fa-bullhorn"></i></font>
                                                    </a>
                                                    <a href="{{ url('/') }}/event/edit/{{ $ed->id }}"
                                                        class="btn btn-warning">
                                                        <font color="white"><i class="fa fa-edit"></i></font>
                                                    </a>
                                                    <a onclick="return confirm('Are You Sure ?')"
                                                        href="{{ url('/') }}/event/delete/{{ $ed->id }}"
                                                        class="btn btn-danger" title="Delete"><i
                                                            class="fa fa-trash"></i></a>
                                                </center>
                                            </div>
                                        @endif

                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--exporter report end -->
                    <br>

                    <div class="pagination justify-content-center">
                        {{ $e_detail->links('vendor.pagination.bootstrap-4') }}
                        {{ $e_detail->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
                    </div>

                </div>

            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#2e899e; font-color:#fff !important">
                    <h3 style="color:#FFF">Broadcast Event</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <form id="formId" action="{{ url('event/bcevent') }}" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="col-sm-12">
                                <p>
                                    <center>Are you sure Broadcast this event ?</center>
                                </p>
                                <input type="hidden" id="idet" name="idet">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">
                            <font color="white">Broadcast</font></a>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalParticipant" aria-labelledby="exampleModalLabel" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-lg-1">
                        <h6 class="modal-title" id="exampleModalLabel">Participant(s)</h6>
                    </div>
                    <div class="col-lg-10 d-flex justify-content-center">
                        <h4><span id="title-event"></span></h4>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="border: none !important; left: 92% !important; padding-top: 13px;"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                </div>

                <div class="row d-flex justify-content-end mb-2 mr-4">
                    <button class="btn btn-md btn-success" id="btn-export-participant">Export XLS</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="participants-table">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Company</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Contact Person</th>
                                    <th class="text-center">Register At</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <input id="event_id" type="hidden" name="event_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-4 mb-2 btn-close-invitation"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function ihid(x) {
            $('#idet').val(x);
        }

        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }

        $(document).ready(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#tableexd').DataTable();

            var tableUser = $('#participants-table').DataTable({
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                },
                "autoWidth": false,
                'columnDefs': [{
                    "targets": 0, // your case first column
                    "width": 30,
                    "className": "text-center"
                }, {
                    "targets": 1, // your case first column
                    "className": "text-left"
                }, {
                    "targets": 5, // your case first column
                    "width": 150,
                    "className": "text-center"
                }]
            });

            $('.btn-participants').click(function() {
                $("#title-event").html($(this).attr('data-event-name'));
                var event_id = $(this).attr('data-event-id');
                var event_name = $(this).attr('data-event-name');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $(
                            'meta[name="csrf-token"]'
                        ).attr('content')
                    }
                });

                var token = $('meta[name="csrf-token"]').attr('content');
                tableUser.clear();
                $.ajax({
                    url: "{{ url('event/getParticipants') }}",
                    method: "GET",
                    data: {
                        event_id: event_id,
                        token: token
                    },
                }).done(function(response) {
                    if (response.status == 200) {
                        
                        $.each(response.data, function(row) {
                            let url = "{{ url('front_end/list_perusahaan/view') }}" +
                                '/' + this.id;
                            let company =
                                `<a target="_blank" href="${url}">${this.company}</a>`

                            let email =
                                `<a target="_blank" href="mailto:${this.email}">${this.email}</a>`
                            tableUser.row.add([
                                this.no,
                                company,
                                email,
                                this.phone,
                                this.contact_person,
                                this.created_at
                            ]);
                        });
                        tableUser.draw();

                        $("#btn-export-participant").attr('data-event-id', event_id);
                        $("#btn-export-participant").attr('data-event-name', event_name);
                    }
                })
            });
        });

        $("#btn-export-participant").click(function() {
            let event_id = $(this).attr('data-event-id');
            let event_name = $(this).attr('data-event-name');

            var query = {
                event_id: event_id,
                event_name: event_name
            }
            var url = "{{ url('event/export_participants') }}?" + $.param(query)

            window.location = url;
        });
    </script>

    @include('footer')
@endsection
