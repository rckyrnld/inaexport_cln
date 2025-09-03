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

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            display: block;
            margin: 30px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

    </style>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Inquiry / Buying Request</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    {{-- <div class="row">
                    <div class="form-group col-sm-2 my-2">
                        <b>Created By</b>
                    </div>
                    <div class="form-group col-sm-4">
                        <select id="bct" class="form-control" onchange="ganti()">
                            <option value="0">All</option>
                            <option value="1">Admin</option>
                            <option value="4">Representative</option>
                            <option value="3">Buyer</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <div id="cb"><a href="{{ url('allgr/0') }}" class="btn btn-info" download><i
                                    class="fa fa-download"></i> Export Excel</a></div>
                    </div>
                </div> --}}
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

                    <a href="{{ url('br_add') }}" class="btn btn-primary ml-4"><i class="fa fa-plus-circle"></i>
                        Add</a><br><br>
                    <table id="users-table0" class="table align-items-center table-striped table-hover" width="100%">
                        <thead class="text-white" style="background-color:#6B7BD6; table-layout: fixed;">
                            <tr>
                                <th>No</th>
                                <th>
                                    <center>Product</center>
                                </th>
                                {{-- <th>
                                <center>Category</center>
                            </th> --}}
                                <th>
                                    <center>Negara Buyer</center>
                                </th>
                                <th>
                                    <center>Nama Buyer</center>
                                </th>
                                <th>
                                    <center>Duration</center>
                                </th>
                                <th>
                                    <center>Status</center>
                                </th>
                                <th>
                                    <center>Action</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
                    <h3 style="color:white; align:center">
                        <center>Broadcast Buying Request</center>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div id="isibroadcast"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        function ganti() {
            var a = $('#bct').val();
            // alert(a);
            if (a == 0) {
                $('#cb').html(
                    '<a href="{{ url('allgr/0') }}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
            } else if (a == 1) {
                $('#cb').html(
                    '<a href="{{ url('allgr/1') }}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
            } else if (a == 4) {
                $('#cb').html(
                    '<a href="{{ url('allgr/4') }}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
            } else if (a == 3) {
                $('#cb').html(
                    '<a href="{{ url('allgr/3') }}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
            }
        }

        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

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
                        $('#tabelpiliheksportir').DataTable().row.add(['<left>' + val.company + '</left>',
                            '<left><div class="checkbox"><input class="eksportir" name="eksportir" type="checkbox" value="' +
                            val.id + '"></div></left>'
                        ]).draw();

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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}'
                    }
                });
                $.ajax({
                        method: "POST",
                        url: "{{ route('broadcastbuyingrequest.pw') }}",
                        data: form_data,
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                    })
                    .done(function(e) {
                        window.location = "{{ route('br_list.message') }}";
                        // window.location = '{{ url('/br_list/br_list') }}';
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
    </script>

    <script type="text/javascript">
        $(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#users-table0').DataTable({
                processing: true,
                serverSide: true,
                scrollX: 200,
                scroller: {
                    loadingIndicator: true
                },
                autoWidth: true,
                ajax: "{{ url('getcsc0') }}",
                columns: [
                    // {
                    //     data: 'row',
                    //     name: 'row'
                    // },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'f1',
                        name: 'f1'
                    },
                    // {
                    //     data: 'f4',
                    //     name: 'f4'
                    // },
                    {
                        data: 'f3',
                        name: 'f3'
                    },
                    {
                        data: 'f6',
                        name: 'f6'
                    },
                    {
                        data: 'f2',
                        name: 'f2'
                    },
                    {
                        data: 'f7',
                        name: 'f7',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:150px'>" + data + "</div>";
                    },
                    targets: 2
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:200px'>" + data + "</div>";
                    },
                    targets: 3
                }, {
                    width: 30,
                    targets: 0
                }, {
                    width: 70,
                    targets: -1
                }],
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
                scrollX: 200,
                scroller: {
                    loadingIndicator: true
                },
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
                    // paginate: {
                    //     first: "<<",
                    //     last: ">>",
                    //     next: "Selanjutnya",
                    //     previous: "Sebelum"
                    // },
                    aria: {
                        sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                        sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                    }
                },
                columnDefs: [{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap' style='width:200px'>" + data + "</div>";
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

        function sendMailToSupplier(id, type) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Send mail to supplier",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ url('/send_mail_supplier') }}/" + id + '/' + type;

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: 'json',
                        beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to
                            Swal.fire({
                                title: 'Please Wait...',
                                html: '<div class="loader"></div>',
                                allowOutsideClick: false,
                                showConfirmButton: false
                            });
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Oops...',
                                    text: data.message,
                                });
                            }
                        }
                    });
                }
            })
        }

        function deleteBR(id, action) {
            Swal.fire({
                title: 'Are you sure',
                text: "You want delete this inquiry?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Please Wait...',
                        html: '<div class="loader"></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                    window.location.assign(action + '/' + id)
                }
            })

        }
    </script>

    @include('footer')
@endsection
