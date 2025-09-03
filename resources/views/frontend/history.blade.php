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
</style>
<!--breadcrumbs area start-->
{{-- <div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                        <li>@lang('frontend.history.title')
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!--breadcrumbs area end-->

<!--product details start-->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">History Inquiry</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    <div class="tab-content">
                        <?php if (Auth::guard('eksmp')->user()->id_role == 3) { ?>

                        <div class="tab-pane fade show active" id="new" role="tabpanel">
                            <br>
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="">
                                        <table id="tablebureqnew" class="table table-striped table-hover"
                                            style="width: 100%; table-layout: fixed;" data-plugin="dataTable">
                                            <thead class="text-dark" style="background-color: #6B7BD6;">
                                                <tr>
                                                    <th style="color: white;">
                                                        <center>No</center>
                                                    </th>
                                                    {{-- <th>
                                                        <center>Type</center>
                                                    </th> --}}
                                                    <th style="color: white;">
                                                        <center>Product</center>
                                                    </th>
                                                    {{-- <th>
                                                        <center>Category</center>
                                                    </th>
                                                    <th>
                                                        <center>Created at</center>
                                                    </th> --}}
                                                    <th style="widht:76px;color: white;">
                                                        <center>Duration</center>
                                                    </th>
                                                    {{-- <th style="color: white;">
                                                        <center>Status</center>
                                                    </th> --}}
                                                    <th style="color: white;">
                                                        <center>Supplier</center>
                                                    </th>
                                                    <th style="color:white;">
                                                        <center>Action</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!--product details end-->

<!-- The Modal -->
<!-- <div id="modalImage" class="modal">
    <button type="button" class="close" data-dismiss="modal">&times;</buttontype="button">
    <center>
      <img class="modal-content" id="img01">
    </center>
    <div id="caption"></div>
  </div> -->

<div class="modal" id="modalImage">
    <div class="modal-dialog">
        <!-- <div class="modal-content"> -->
        <button type="button" class="close" data-dismiss="modal">&times;</button><br><br>
        <img class="modal-content" id="img01">
        <!-- </div> -->
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2e899e; color:white;">
                <h6>Broadcast Buying Request</h6>
                <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>

            </div>
            <div id="isibroadcast"></div>
            <!--<div class="modal-body">
          1
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
        </div>
    </div>
</div>

@include('frontend.layouts.footer_history')
<script type="text/javascript">
    function xy(a) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilbroad2/') }}/' + a, {
            _token: token
        }, function(data) {
            $("#isibroadcast").html(data);
            calldata();

        })
    }
    // function xy(a){
    // 	var token = $('meta[name="csrf-token"]').attr('content');
    // 		$.get('{{ URL::to('ambilbroad/') }}/'+a,{_token:token},function(data){
    // 			$("#isibroadcast").html(data);

    // 		 })
    // 	$('.cobas2').select2();

    // }


    var dataeksportir = [];

    function calldata() {
        var id = $('#id_laporan').val();
        $.ajax({
                method: "POST",
                url: "{!! url('getdatapiliheksportir') !!}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_laporan: id
                }
            })
            .done(function(data) {
                $.each(data, function(i, val) {
                    $('#tabelpiliheksportir').DataTable().row.add([val.company,
                        '<center><div class="checkbox"><input class="eksportir" name="eksportir" type="checkbox" value="' +
                        val.id + '"></div></center>'
                    ]).draw();

                    // $('#tabelpiliheksportir').DataTable().row.add([val.company]).draw();
                });
            });


    }


    function savecheckall() {
        $.each($("input[name='eksportir']:checked"), function() {
            val = $(this).val();
            if (dataeksportir.includes(val)) {} else {
                $('input:checkbox[value=' + val + ']').attr('disabled', true)
                dataeksportir.push($(this).val());
            }
        });
        $("input[name='checkall']").prop('checked', false);
    }

    function broadcast() {
        var id = $('#id_buyingrequest').val();
        var publish = $('#publish').prop("checked");
        // var dataeksportir = [];
        // dataTable.rows().nodes().to$().find('input[name="eksportir"]').each(function(){
        //     dataeksportir.push($(this).val());
        // })
        $.each($("input[name='eksportir']:checked"), function() {
            var val = $(this).val();
            if (dataeksportir.includes(val)) {} else {
                dataeksportir.push($(this).val());
            }
        });
        if (!isEmptyM(dataeksportir)) {
            var form_data = new FormData();
            form_data.append('id', id);
            form_data.append('dataeksportir', dataeksportir);
            form_data.append('publish', publish);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }
            });
            $.ajax({
                    method: "POST",
                    url: "{{ route('broadcastbuyingrequest.imp') }}",
                    data: form_data,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                })
                .done(function(e) {
                    window.location = '{{ url('front_end / history ') }}';
                    // window.location = '{{ url('/br_list') }}';
                });
        } else {
            alert('make sure to checked at least one exporter');
        }
    }
    // var checkedValue = $('.eksportirterpilih:checked').val();
    function isEmptyM(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }


    $(document).ready(function() {
        var tbl = $('#tablebureqnew').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            ajax: "{{ route('front.datatables.br.new') }}",
            fixedColumns: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    width: 5,
                    className: "text-center"
                },
                // {
                //     data: 'type',
                //     name: 'type',
                //     className: "text-left"
                // },
                {
                    data: 'col1',
                    name: 'col1',
                    width: 150,
                    className: "text-left"
                },
                // {
                //     data: 'col2',
                //     name: 'col2',
                //     className: "text-left"
                // },
                // {
                //     data: 'col3',
                //     name: 'col3',
                //     className: "text-left"
                // },
                {
                    data: 'col4',
                    name: 'col4',
                    width: 150,
                    className: "text-left"
                },
                // {
                //     data: 'col5',
                //     name: 'col5',
                //     width: 150,
                //     className: "text-left"
                // },
                {
                    data: 'col6',
                    name: 'col6',
                    width: 250,
                    className: "text-left"
                },
                {
                    data: 'col7',
                    name: 'col7',
                    orderable: false,
                    searchable: false,
                    width: 40,
                    className: "text-center"
                }
            ],
            fixedColumns: true,
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });

        $("#tabelpiliheksportir").DataTable({
            processing: true,
            orderable: false,
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan MENU entri",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                info: "Menampilkan START sampai END dari TOTAL entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari MAX entri keseluruhan)",
                infoPostFix: "",
                search: "Cari:",
                url: "",
                infoThousands: ".",
                loadingRecords: "Sedang memproses...",
                paginate: {
                    first: "<<",
                    last: ">>",
                    next: "Selanjutnya",
                    previous: "Sebelum"
                },
                aria: {
                    sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                    sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                }
            }
        });
    });

    function openImage(img) {
        var url = "{{ url('/') }}/" + img;
        $('#modalImage').modal('show');
        $('#img01').attr("src", url);
    }

    function deleteAct(obj){
        var r=confirm("Are you sure you want to delete?");
        if (r==true) {
            window.location = obj.getAttribute("href");
        } else {
            return false;
        }
    }
</script>