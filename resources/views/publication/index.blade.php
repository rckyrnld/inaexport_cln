{{-- @include('header') --}}
@extends('header2')
@section('content')
    <style type="text/css">
        th {
            text-align: center;
        }

        td {
            color: black;

        }

        #button:link,
        #button:visited,
        #button:active {
            color: white;
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

        input:read-only {
            background-color: white !important
        }

        /*CSS MODAL*/
        .modal-lg {
            width: 700px;
        }

        .modal-header {
            background-color: #2e899e;
            ;
            color: white;
            font-size: 20px;
            text-align: center;
        }

        .modal-body {
            height: 300px;
        }

        .modal-content {
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            overflow: hidden;
        }

        .modal-footer {
            background-color: #2e899e;
            ;
            color: white;
            font-size: 20px;
            text-align: center;
        }

        #Tablemodal td {
            text-align: left !important;
        }

        .table th {
            color: white;
            text-align: center;
        }
        

        /* .card {
                        background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                    }
                    .card-header {
                        background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
                    } */

    </style>

    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Publication</h3>
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

                    <a id="tambah" href="{{ route('publication.create') }}" class="btn pl-2 ml-4"> <i
                            class="fa fa-plus-circle"></i> Add </a>
                    <!-- <a href="{{ url('cetakrc') }}" class="btn btn-success pl-2"> <i class="fa fa-download"></i> Export
                        Excel
                    </a> -->

                    <div class="table-responsive pt-4 pl-0 pr-0">
                        <table id="table" class="table align-items-center table-striped table-hover" data-plugin="dataTable"
                            style="table-layout: fixed;">
                            <thead class="text-white" style="background-color:#6B7BD6; !important">
                                <tr>
                                    <th width="7%">No</th>
                                    <th>Judul</th>
                                    <th>Type</th>
                                    <th>Tanggal Publish</th>
                                    <th>Cover</th>
                                    <th>File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody align="left">
                                                    <?php
                                                        $na = 1;
                                                        foreach ($data as $val) {
                                                            ?>
                                                        <tr>
                                                            <td style="text-align: left;"><?php echo $na; ?></td>
                                                            <td style="text-align: left;"><?php echo $val->judul; ?></td>
                                                            <td style="text-align: left;"><?php echo $val->tipe; ?></td>
                                                            <td style="text-align: left;"><?php echo $val->publish_date; ?></td>
                                                            <td style="text-align: left;"><a href="{{ url('/').'/uploads/publication/cover/'.$val->cover}}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;Lihat Cover</a></td>
                                                            <td style="text-align: left;"><a href="{{ url('/').'/uploads/publication/file/'.$val->file}}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Download File</a></td>
                                                            <td style="text-align: left;">
                                                                <a href="{{ url('publication/destroy/' . $val->id) }}" onclick="myFunction()" class="btn btn-danger btn-sm" title="hapus"><i class="fa fa-trash" style="color: white;"></i></a>
                                                                <a href="{{ url('publication/edit-data/' . $val->id) }}" class="btn btn-primary btn-sm" title="edit"><i class="fa fa-pencil-square-o" style="color: white;"></i></a>
                                                            </td>
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
    {{-- </div> --}}

    @include('footer')
    <script type="text/javascript">
         $(document).ready(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#table').DataTable();
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
@endsection
