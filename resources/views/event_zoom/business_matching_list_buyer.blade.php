@include('frontend.layouts.header_table')
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

        tr.passed{
            background-color: #c1c1c1;
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
                                        <table id="table_bm_list" class="table table-striped table-hover"
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
                                                </tr>
                                            </thead>
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

@include('frontend.layouts.footer_history')
<script type="text/javascript">
    $(document).ready(function() {
        var tbl = $('#table_bm_list').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            ajax: "{{ route('business_matching_list.business_matching_data') }}",
            fixedColumns: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    width: 5,
                    className: "text-center"
                },
                {
                    data: 'col1',
                    name: 'col1',
                    className: "text-left"
                },
                {
                    data: 'col2',
                    name: 'col2',
                    className: "text-left"
                },
                {
                    data: 'col3',
                    name: 'col3',
                    className: "text-left"
                },
                {
                    data: 'join_url',
                    name: 'join_url',
                    className: "text-left",
                    "width": "10%",
                },
                {
                    data: 'col4',
                    name: 'col4',
                    className: "text-left"
                },
                {
                    data: 'col5',
                    name: 'col5',
                    className: "text-left"
                },
                {
                        data: 'col6',
                        name: 'col6',
                        className: "text-center"
                    },
            ],
            fixedColumns: true,
            "language": {
                processing: "Sedang memproses...",
                loadingRecords: "Sedang memproses...",
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
    });
</script>
