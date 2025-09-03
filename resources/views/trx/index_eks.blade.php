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
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="mb-0">Selling Transaction</h3>
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
                        <div class="table-responsive">
                            <table id="example1" class="table table-striped table-hover"  style="width: 100%; table-layout: fixed;">
                                <thead class="text-white" style="background-color: #C4C4C4;">
                                    <tr>
                                        <th>No</th>

                                        <th>
                                            <center>Origin</center>
                                        </th>
                                        <th>
                                            <center>Buyer</center>
                                        </th>

                                        <th>
                                            <center>Type Tracking</center>
                                        </th>
                                        <th>
                                            <center>No Tracking</center>
                                        </th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th>
                                            <center>Created At</center>
                                        </th>
                                        <th width="18%">
                                            <center>Action</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nt = 1; foreach($data as $ruu){ ?>
                                    <tr>
                                        <td><?php echo $nt; ?></td>

                                        <td>
                                            <center><?php if ($ruu->origin == 1) {
                                                echo 'Inquiry';
                                            } elseif ($ruu->origin == 2) {
                                                echo 'Buying Request';
                                            } ?></center>
                                        </td>
                                        <td>
                                            <center><?php if ($ruu->by_role == 1) {
                                                echo 'Admin';
                                            } elseif ($ruu->by_role == 4) {
                                                echo 'Perwakilan';
                                            } else {
                                                $usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $ruu->id_pembuat . "'");
                                                foreach ($usre as $imp) {
                                                    echo 'Importir - ' . $imp->badanusaha . ' ' . $imp->company;
                                                }
                                            } ?></center>
                                        </td>



                                        <td>
                                            <center><?php echo $ruu->type_tracking; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $ruu->no_tracking; ?></center>
                                        </td>
                                        <td>
                                            <center><?php if ($ruu->status_transaksi == 1) {
                                                echo "<span class='badge bg-success' style='color: #fff;'>Already Sent</span>";
                                            } else {
                                                echo "<span class='badge bg-danger' style='color: #fff;'>On Process</span>";
                                            } ?></center>
                                        </td>
                                        <td>
                                            <center><?php if ($ruu->status_transaksi == 1) {
                                                echo '<font >' . $ruu->created_at . '</font>';
                                            } else {
                                                echo ' ';
                                            } ?></center>
                                        </td>
                                        <td>
                                            <center>
                                                <?php if($ruu->status_transaksi == 1){ ?>
                                                <a href="{{ url('input_transaksi/' . $ruu->id_transaksi) }}"
                                                    class="btn btn-info" title="View">
                                                    <font color="white"><i class="fa fa-eye"></i></font>
                                                </a>


                                                <?php }else { ?>
                                                <a href="{{ url('input_transaksi/' . $ruu->id_transaksi) }}"
                                                    class="btn btn-success" title="Send">
                                                    <font color="white"><i class="fa fa-truck"></i></font>
                                                </a>

                                                <?php } ?>
                                            </center>
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


    @include('footer')

@endsection
