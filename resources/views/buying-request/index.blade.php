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

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-shadow">
                    <div class="card-header border-bottom">
                        <h3 class="mb-0">Buying Request</h3>
                    </div>
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
                        {{-- <a href="{{ url('br_add') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i>
                    Add</a><br><br> --}}

                        <div class="col-md-14">
                            <div class="table-responsive">
                                <table id="users-table" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #6B7BD6;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Product Name</center>
                                            </th>
                                            {{-- <th>
                                                <center>Category</center>
                                            </th> --}}
                                            <!-- <th>
                                                <center>Date</center>
                                            </th> -->
                                            <th>
                                                <center>Duration</center>
                                            </th>
                                            <th>
                                                <center>Supplier(s)</center>
                                            </th>
                                            <th width="18%">
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-white">

                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        var dataeksportir = [];

        function xy(a) {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.get('{{ URL::to('ambilbroad2/') }}/' + a, {
                _token: token
            }, function(data) {
                $("#isibroadcast").html(data);
                calldata();

            })
        }

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
                            '<div class="checkbox"><input class="eksportir" name="eksportir" type="checkbox" value="' +
                            val.id + '"></div>'
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
            // var dataeksportir = [];
            // dataTable.rows().nodes().to$().find('input[name="eksportir"]').each(function(){
            //     dataeksportir.push($(this).val());
            // })
            $.each($("input[name='eksportir']:checked"), function() {
                var val = $(this).val();
                if (dataeksportir.includes(val)) {

                } else {
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
                        console.log(e);

                        window.location = "{{ route('br_list.message') }}";
                        // window.location = '{{ url('/br_list') }}';
                    });
            } else {
                alert('make sure to checked at least one exporter');
            }
            // var checkedValue = $('.eksportirterpilih:checked').val();
            function isEmptyM(obj) {
                for (var key in obj) {
                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }


        }
    </script>

    <script type="text/javascript">
        $(function() {

            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('getcscperwakilan') }}",
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
                    // {
                    //     data: 'f4',
                    //     name: 'f4'
                    // },
                    // {
                    //     data: 'f3',
                    //     name: 'f3'
                    // },
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

        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }
    </script>


    @include('footer')

@endsection
