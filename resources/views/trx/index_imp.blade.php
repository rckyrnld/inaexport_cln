@include('frontend.layouts.header_table')
<style type="text/css">
    .nav-me {
        width: 200px !important;
        font-size: 16px !important;
        background-color: white !important;
        border: 2px solid #ADC2A9 !important;
        color: #ADC2A9 !important;
        border-radius: 30px !important;
        text-align: center;
        margin-right: 3px;
    }

    .nav-me.active {
        background-color: #ADC2A9 !important;
        color: white !important;
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
        border-bottom: 1px solid #fff;
    }

    .table td,
    .table th {
        font-size: 0.8125rem;
        white-space: nowrap;
    }

    .dataTables_wrapper {
        font-size: 0.875rem;
    }

    .table th {
        color: white;
    }

</style>

<!--slider area start-->
<?php
$loc = app()->getLocale();
if ($loc == 'ch') {
    $lct = 'chn';
} elseif ($loc == 'in') {
    $lct = 'in';
} else {
    $lct = 'en';
}
?>

<!--product area start-->
{{-- <div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{url('/')}}">@lang("login.forms.home")</a></li>
                        <li>List Transaction</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Transaction</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped" id="example" style="width: 100%; table-layout: fixed">
                        <thead class="text-dark" style="background-color: #6B7BD6; color: white;">
                            <th>
                                <center>No</center>
                            </th>
                            <th>
                                <center>Origin</center>
                            </th>
                            <th>
                                <center>Exporter</center>
                            </th>
                            <th>
                                <center>Type Tracking</center>
                            </th>
                            <th>
                                <center>No Tracking</center>
                            </th>
                            <th>
                                <center>Link Tracking</center>
                            </th>
                            <th>
                                <center>Status</center>
                            </th>
                            <th>
                                <center>Created At</center>
                            </th>
                            <th>
                                <center>Action</center>
                            </th>
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
                                    <center><?php if ($ruu->id_eksportir == 0 || $ruu->id_eksportir == null) {
                                    } else {
                                        $carieks = DB::select("select b.* from itdp_company_users a, itdp_profil_eks b where a.id='" . $ruu->id_eksportir . "' and a.id_profil = b.id");
                                        foreach ($carieks as $eks) {
                                            echo $eks->badanusaha . ' ' . $eks->company;
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
                                    <center><?php echo '<a target="_blank" href="' . $ruu->link_tracking . '">' . $ruu->link_tracking . '</a>'; ?></center>
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

                                        <a href="{{ url('detailtrx/' . $ruu->id_transaksi) }}" class="btn btn-success"
                                            title="Detail">
                                            <font color="white"><i class="fa fa-list"></i></font>
                                        </a>


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
<br>
<br>

@include('frontend.layouts.footer_history')
<?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });

        $('#tablebureq').DataTable({
            /* processing: true,
             serverSide: true,
             ajax: "{{ route('front.datatables.br3') }}",
             columns: [
                 {data: 'row', name: 'row'},
                 {data: 'col1', name: 'col1'},
                 {data: 'col2', name: 'col2'},
                 {data: 'col3', name: 'col3'},
                 {data: 'col4', name: 'col4'},
                 {data: 'col5', name: 'col5'},
                 {data: 'col6', name: 'col6'}
                 
             ],
             fixedColumns: true */
        });
    });
</script>
<script>
    function xy(a) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilbroad/') }}/' + a, {
            _token: token
        }, function(data) {
            $("#isibroadcast").html(data);

        })
    }

    function t1() {
        $('#t2').html('');
        $('#t3').html('');
        var t1 = $('#category').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilt2/') }}/' + t1, {
            _token: token
        }, function(data) {
            $("#t2").html(data);
            $("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
            $('.select2').select2();

        })
    }

    function t2() {
        $('#t3').html('');
        var t2 = $('#t2s').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilt3/') }}/' + t2, {
            _token: token
        }, function(data) {
            $("#t3").html(data);
            $('.select2').select2();

        })
    }

    function nv() {
        var a = $('#staim').val();
        if (a == 2) {
            $('#sh1').html(
                '<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id; ?>"><?php echo $qr->nama_template; ?></option><?php } ?></select></div></div>'
            )
        } else {
            $('#sh1').html(' ');
            $('#sh2').html(' ');
        }
    }

    function ketv() {
        var a = $('#template_reject').val();
        if (a == 1) {
            $('#sh2').html(
                '<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>'
            )
        }
    }
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
    // $(document).ready(function () {

    // })
    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#' + tabname).addClass('active');
    }
</script>
