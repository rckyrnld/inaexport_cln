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

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 35px !important;
    }

    .custom-select,
    .custom-file-control,
    .custom-file-control:before,
    select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
        height: 45px !important;
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
                <h3 class="mb-0">{{ $pageTitle }}</h3>
            </div>
            <div class="card-body pl-9 pr-9 pt-0">
                <div class="col-md-12">
                    <br>
                    <div class="table-responsive">

                        <table id="member_table" class="table table-striped table-hover">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th style="text-align:center;width: 30px;">
                                        No
                                    </th>
                                    <th style="text-align:center;">
                                        Provinsi
                                    </th>
                                    <th style="text-align:center;">
                                        Jumlah
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $na = 1;
                                foreach ($member as $mem) {
                                    ?>
                                    <tr>
                                        <td style="text-align: left; width:50px"><?php echo $na; ?></td>
                                        <td style="text-align: left;"><?php echo $mem->province_in; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($mem->jumlah,0,",",".") ?></td>
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
<link rel="stylesheet" href="{{url('assets')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" type="text/css" />
<script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="{{url('assets')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="{{url('assets')}}/html/scripts/plugins/datatable.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#member_table').DataTable({
            "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
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
    $(function() {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
    });

    // ajax: "{{ url('geteksportir') }}",  
    // data: {filternya : yangdiselect},
    // "data": {_token: '{{ csrf_token() }}'}
</script>

@include('footer')
@endsection