@extends('header2')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css" rel="stylesheet">
<link rel="stylesheet" href="sweetalert2.min.css">

<style type="text/css">
    .nav-me {
        width: 200px !important;
        font-size: 16px !important;
        border: 2px solid #C4C4C4 !important;
        color: #5F5F5F !important;
        border-radius: 30px !important;
        text-align: center;
        margin-right: 3px;
    }

    .nav-me.active {
        background-color: #C4C4C4 !important;
        color: white !important;
    }

    .nav-me:hover {
        text-decoration: none;
        background-color: #f4f4f5;
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

    .myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        width: 40px;
    }

    .myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        .nav-me.active {
            background-color: #C4C4C4 !important;
            color: white !important;
        }

        .nav-me:hover {
            text-decoration: none;
            background-color: #f4f4f5;
            box-shadow: 0 0 15px rgba(194, 216, 255, 1)
        }

        .myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            width: 40px;
        }

        .myImg:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content,
        #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        .table thead th {
            font-size: 0.70rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-bottom: 1px solid #e9ecef;
        }

        .table td,
        .table th {
            font-size: 0.8125rem;
            white-space: nowrap;
        }

        .dataTables_wrapper {
            font-size: 0.875rem;
        }

        .text-left {
            text-align: left !important;
        }

        .tombol_aksi {
            font-size: 15px;
            padding-bottom: 0px;
            padding-top: 0px;
            padding-left: 4px;
            padding-right: 4px;
        }

        tr.passed {
            background-color: #c1c1c1;
        }

        .text-wrap {
            white-space: normal;
        }

        .width-150 {
            width: 150px;
        }
</style>

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Business Matching</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    <div class="tab-content">


                        <div class="tab-pane fade show active" id="new" role="tabpanel">
                            <br>
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="">
                                        @if ($message = Session::get('success'))
                                        <div class="alert alert-success" id="success-alert">
                                            <button type="button" class="close" data-dismiss="alert">x</button>
                                            <strong>Success!</strong>
                                        </div>
                                        @endif
                                        @if ($message = Session::get('error'))
                                        <div class="alert alert-danger alert-block" style="text-align: center">
                                            {{-- <button type="button" class="close" data-dismiss="alert">×</button>
                                            --}}
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif

                                        @if (Auth::user() != '' && (Auth::user()->id_group == 1 ||
                                        Auth::user()->id_group == 8))
                                        <a href="{{ url('video_conference/add_update_video_conference_data') }}"
                                            class="btn btn-primary ml-4"><i class="fa fa-plus-circle"></i>
                                            Add</a><br><br>
                                        @endif
                                        <table id="table_bm_list" class="table table-striped table-hover wrap"
                                            style="width: 100%;" data-plugin="dataTable">
                                            <thead class="text-dark" style="background-color: #6B7BD6;">
                                                <tr>
                                                    <th style="color: white;text-align: center;">No</th>
                                                    <th style="color: white;text-align: center;">Zoom Meeting ID</th>
                                                    <th style="color: white;text-align: center;">Password</th>
                                                    <th style="color: white;text-align: center;">Topic</th>
                                                    <th style="color: white;text-align: center;">Join Url</th>
                                                    <th style="color: white;text-align: center;">Start Time</th>
                                                    <th style="color: white;text-align: center;">Duration (minute)</th>
                                                    <th style="color: white;text-align: center;">Status</th>
                                                    @if (Auth::user() != '' && (Auth::user()->id_group == 1 ||
                                                    Auth::user()->id_group == 8))
                                                    <th style="color: white;text-align: center;">Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody align="left">
                                                <?php
                                                $na = 1;
                                                foreach ($data as $ryu) {
                                                    ?>
                                                <tr>
                                                    <td style="text-align: left;">
                                                        <?php echo $na; ?>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <?php echo $ryu->zoom_room->meeting_id; ?>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <?php echo $ryu->zoom_room->password; ?>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <?php echo $ryu->zoom_room->topic; ?>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <a href="<?php echo $ryu->zoom_room->join_url; ?>">
                                                            <?php echo $ryu->zoom_room->join_url; ?>
                                                        </a>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <?php
                                                            if($ryu->zoom_room->start_time != ''){
                                                                echo date('d F Y H:i', strtotime($ryu->zoom_room->start_time));
                                                            }
                                                        ?>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <?php echo $ryu->zoom_room->duration; ?>
                                                    </td>

                                                    <td style="text-align: left;">
                                                        <?php if ($ryu->is_verified == true || $ryu->is_verified == 1) { ?>
                                                        Terverifikasi
                                                        <?php } else { ?>
                                                        Belum di Approve
                                                        <?php } ?>
                                                    </td>
                                                    @if (Auth::user() != '' && (Auth::user()->id_group == 1 ||
                                                    Auth::user()->id_group == 8))
                                                    <td style="text-align: left;">
                                                        <a href="{{ url('video_conference/add_update_video_conference_data/' . $ryu->video_conference_id) }}"
                                                            class="btn btn-primary btn-sm" title="edit"><i
                                                                class="fa fa-pencil-square-o"
                                                                style="color: white;"></i></a>
                                                        <a href="{{ url('video_conference/hapus_video_conference_data/' . $ryu->video_conference_id) }}"
                                                            onclick="myFunction()" class="btn btn-danger btn-sm"
                                                            title="hapus"><i class="fa fa-trash"
                                                                style="color: white;"></i></a>
                                                    </td>
                                                    @endif

                                                </tr>
                                                <?php $na++;
                                                } ?>

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
</div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table_bm_list').DataTable({
            scrollX: true,
            "language": {
            "paginate": {
            "previous": "<i class='fa fa-angle-left' /></>",
            "next": "<i class='fa fa-angle-right' /></>"
            }
            },
            columnDefs: [
            {
            render: function (data, type, full, meta) {
            return "<div class='text-wrap width-150'>" + data + "</div>";
            },
            targets: 4
            }
            ],
            autoWidth: false
        });
        $("#success-alert").hide();
        $("#myWish").click(function showAlert() {
            $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                $("#success-alert").slideUp(500);
            });
        });
    });

    function myFunction() {
        let text = "Are You sure?";
        if (confirm(text) == true) {
            text = "OK!";
        } else {
            text = "cancel!";
        }
        document.getElementById("demo").innerHTML = text;
    }
</script>
@include('footer')
@endsection