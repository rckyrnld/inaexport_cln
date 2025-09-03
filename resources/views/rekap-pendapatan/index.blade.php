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
                    <h3 class="mb-0">List Company Incomes</h3>
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
                    <a href="{{ url('exportpendapatanall') }}" class="btn btn-success ml-4"><i class="fa fa-download"></i>
                        Export Excel</a>
                    <br><br>

                    <div class="table responsive">
                        <table id="example1" class="table table-striped table-hover">
                            <thead class="text-white" style="background-color:#6B7BD6 !important">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>Exporter</center>
                                    </th>
                                    <th>
                                        <center>Address Company</center>
                                    </th>
                                    <th width="20%">
                                        <center>Incomes</center>
                                    </th>
                                    <th width="18%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nt = 1; 
								$data = DB::select("select id_eksportir from csc_transaksi where status_transaksi ='1' group by id_eksportir ");
								foreach($data as $ruu){ ?>
                                <tr>
                                    <td width="5%">
                                        <center><?php echo $nt; ?></center>
                                    </td>
                                    <td><?php
                                    $carieksportir = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='" . $ruu->id_eksportir . "' limit 1");
                                    if (count($carieksportir) == 0) {
                                        echo '';
                                    } else {
                                        foreach ($carieksportir as $ce) {
                                            echo $ce->badanusaha . ' ' . $ce->company;
                                        }
                                    }
                                    ?></td>
                                    <td><?php
                                    $carieksportir = DB::select("select b.addres,b.city from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='" . $ruu->id_eksportir . "' limit 1");
                                    if (count($carieksportir) == 0) {
                                        echo '';
                                    } else {
                                        foreach ($carieksportir as $ce) {
                                            echo $ce->addres . ' ,' . $ce->city;
                                        }
                                    }
                                    ?></td>
                                    <td style="text-align:right!important;">
                                        <?php
                                        $caritotal = DB::select("select sum(tp)as maxc from csc_transaksi where id_eksportir='" . $ruu->id_eksportir . "' and status_transaksi ='1'");
                                        if (count($caritotal) == 0) {
                                            echo "$0";
                                        } else {
                                            foreach ($caritotal as $ct) {
                                                echo "$" . number_format($ct->maxc, 2, ',', '.');
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td width="5%">
                                        <center><a href="{{ url('detailpendapatan/' . $ruu->id_eksportir) }}"
                                                class="btn btn-warning" title="Detail">
                                                <font color="white"><i class="fa fa-list"></i></font>
                                            </a></center>
                                    </td>
                                </tr>

                                <?php $nt++; } ?>

                            </tbody>

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
                    <h6>Broadcast Buying Request</h6>
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
            })
        }
    </script>
    <script type="text/javascript">
        $(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#users-table0').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('getcsc0') }}",
                columns: [{
                        data: 'row',
                        name: 'row'
                    },
                    {
                        data: 'f1',
                        name: 'f1'
                    },
                    {
                        data: 'f2',
                        name: 'f2'
                    },
                    {
                        data: 'f3',
                        name: 'f3'
                    },
                    {
                        data: 'f4',
                        name: 'f4'
                    },
                    {
                        data: 'f6',
                        name: 'f6',
                        orderable: false,
                        searchable: false
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
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('getcsc') }}",
                columns: [{
                        data: 'row',
                        name: 'row'
                    },
                    {
                        data: 'f1',
                        name: 'f1'
                    },
                    {
                        data: 'f2',
                        name: 'f2'
                    },
                    {
                        data: 'f3',
                        name: 'f3'
                    },
                    {
                        data: 'f4',
                        name: 'f4'
                    },
                    {
                        data: 'f6',
                        name: 'f6',
                        orderable: false,
                        searchable: false
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
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#users-table3').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('getcsc3') }}",
                columns: [{
                        data: 'row',
                        name: 'row'
                    },
                    {
                        data: 'f1',
                        name: 'f1'
                    },
                    {
                        data: 'f2',
                        name: 'f2'
                    },
                    {
                        data: 'f3',
                        name: 'f3'
                    },
                    {
                        data: 'f4',
                        name: 'f4'
                    },
                    {
                        data: 'f6',
                        name: 'f6',
                        orderable: false,
                        searchable: false
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
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });
        });
    </script>
    @include('footer')

@endsection
