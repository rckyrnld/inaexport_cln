<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="Responsive, Bootstrap, BS4" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="../assets/images/logo.svg">
    <meta name="apple-mobile-web-app-title" content="Flatkit">
    <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.svg">

    <!-- style -->

    <link rel="stylesheet" href="{{ url('assets') }}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="{{ url('assets') }}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets') }}/assets/css/app.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets') }}/assets/css/style.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
        type="text/css" />
    <script src="{{ url('assets') }}/libs/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>


    <script src="{{ url('assets') }}/html/scripts/plugins/datatable.js"></script>
    <!-- endbuild -->
</head>

<body style="font-family: " Times New Roman", Times, serif;">


    <div class="d-flex flex-column flex" style="background-color:  #2e899e  ; color: #ffffff">
        <div class="light bg pos-rlt box-shadow"
            style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
            <div class="mx-auto">
                <table border="0" width="100%">
                    <tr>
                        <td width="30%" style="font-size:13px;padding-left:10px"><img height="30px"
                                src="{{ url('assets') }}/assets/images/logo.jpg" alt="."><b>&nbsp;&nbsp;&nbsp;
                                Ministry
                                Of Trade</b></td>
                        <td width="30%">
                            <!-- <center><span class="hidden-folded d-inline"><H5>Form Registrasi Pembeli Baru</H5></span></center> -->
                        </td>
                        <td width="40%" align="right" style="padding-right:10px;">
                            <a href="{{ url('registrasi_pembeli') }}">
                                <font color="white"><i class="fa fa-user"></i> @lang("login.lbl2")</font>
                            </a> &nbsp;&nbsp;&nbsp;<a href="{{ url('registrasi_penjual') }}">
                                <font color="white"><i class="fa fa-user"></i> @lang("login.lbl1")</font>
                            </a> &nbsp;&nbsp;&nbsp;
                            <a href="{{ url('locale/en') }}"><img width="20px" height="15px"
                                    src="{{ asset('negara/en.png') }}"></a>&nbsp;
                            <a href="{{ url('locale/in') }}"><img width="20px" height="15px"
                                    src="{{ asset('negara/in.png') }}"></a>&nbsp;
                            <a href="{{ url('locale/ch') }}"><img width="20px" height="15px"
                                    src="{{ asset('negara/ch.png') }}"></a>&nbsp;&nbsp;&nbsp;
                            <a href="{{ url('login') }}">
                                <font color="white"><i class="fa fa-sign-in"></i>
                                    <?php if(empty(Auth::user()->name) && empty(Auth::guard('eksmp')->user()->username)){ ?>
                                    @lang("login.lbl3")
                                    <?php }else if(empty(Auth::user()->name) && !empty(Auth::guard('eksmp')->user()->username)){	
		echo Auth::guard('eksmp')->user()->username;
	}else if(empty(!Auth::user()->name) && empty(Auth::guard('eksmp')->user()->username)){?>
                                    {{ Auth::user()->name }}
                                    <?php } ?>


                                </font>
                            </a>


                        </td>
                    </tr>
                </table>




            </div>
        </div>
        <div id="content-body" style="padding-left:100px; padding-right:100px ; color: #ffffff">
            <div class="py-2 w-100">


                <div class=""
                    style="text-color:black;padding-left:10px; padding-right:10px; border-radius: 3px;">
                    <br>
                    <form class="form-horizontal" method="POST" action="{{ url('br_importir_save') }}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}


                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="box-body">
                                    <br><br>

                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <label><b>What are you looking for</b></label>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <input type="text" style="color:black;" value="" name="subyek" id="subyek"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <select style="color:black;" class="form-control" name="valid" id="valid">
                                                <option value="7">Valid within 7 day</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <label><b>Category</b></label>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <?php
                                            $ms1 = DB::select("select a.id, a.nama_kategori_en from csc_product a, csc_product_single b 
                                                                                                                                    where a.id = b.id_csc_product or a.id = b.id_csc_product_level1 or a.id = b.id_csc_product_level2
                                                                                                                                    group by a.id,a.nama_kategori_en 
                                                                                                                                    order by a.nama_kategori_en asc");
                                            ?>
                                            <select style="color:black;" class="form-control select2" name="category"
                                                id="category">
                                                <option value="">-- Select Category --</option>
                                                <?php foreach($ms1 as $val1){ ?>
                                                <option value="<?php echo $val1->id; ?>"><?php echo $val1->nama_kategori_en; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>


                                    <div id="t2">
                                        <input type="hidden" name="t2s" id="t2s" value="0">
                                    </div>
                                    <div id="t3">
                                        <input type="hidden" name="t3s" id="t3s" value="0">

                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <label><b>Specification</b></label>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <textarea style="color:black;" value="" name="spec" id="spec" class="form-control"></textarea>
                                        </div>

                                    </div>

                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <label><b>Estimated order quantity</b></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label><b>Targeted price (Estimated total)</b></label>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <div class="form-row">
                                                <div class="col-sm-7"><input style="color:black;" type="number"
                                                        name="eo" id="eo" class="form-control"> </div>
                                                <div class="col-sm-5"> <select style="color:black;"
                                                        class="form-control" name="neo" id="neo">
                                                        <option value="Pieces">Pieces</option>
                                                    </select></div>
                                            </div>


                                        </div>
                                        <div class="form-group col-sm-6">

                                            <div class="form-row">
                                                <div class="col-sm-7"><input style="color:black;" type="number"
                                                        value="" name="tp" id="tp" class="form-control"></div>
                                                <div class="col-sm-5 align-self-center"><label class="control-label">USD</label></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="box-body">
                                    <br><br>
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <label><b>Location of delivery</b></label>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <?php
                                            $ms2 = DB::select('select id,country from mst_country order by country asc');
                                            ?>
                                            <select style="color:black;" style="border-color: rgba(120, 130, 140, 0.5)!important;
    border-radius: 0.25rem!important;
    color: inherit!important;" class="form-control select2" name="country" id="country">
                                                <option value="">-- Select Country --</option>
                                                <?php foreach($ms2 as $val2){ ?>
                                                <option value="<?php echo $val2->id; ?>"><?php echo $val2->country; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <input style="color:black;" type="text" value="" name="city" id="city"
                                                class="form-control" placeholder="City/State">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        {{-- <div class="col-sm-12">
                                            <label><b>Shipping & Payment conditions</b></label>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <textarea style="color:black;" value="" name="ship" id="ship"
                                                class="form-control"></textarea>
                                        </div> --}}

                                    </div>
                                    <div class="form-row">
                                        {{-- <div class="col-sm-12">
                                            <label><b>Add attachment (Relevant to a request)</b></label>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <input style="color:black;" type="file" value="" name="doc" id="doc"
                                                class="form-control">
                                        </div> --}}

                                    </div>

                                </div>
                            </div>



                            <div class="col-sm-12">
                                <div align="right">
                                    <button class="btn btn-md btn-success"><i class="fa fa-save"></i>
                                        Submit</button>
                                    <a href="{{ url('br_importir') }}" class="btn btn-md btn-danger"><i
                                            class="fa fa-arrow-left"></i> Cancel</a>


                                </div>
                            </div>
                    </form>
                    <?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
                    <script>
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



                </div>


            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#example1').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

            $('#example2').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

            $('#yahoo').DataTable({

            });

            $('.select2').select2();
        });
    </script>
    <script type="text/javascript">
        $(function() {
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
                ]
            });
        });
    </script>

    <!-- ############ SWITHCHER START-->
    <div id="setting">
        <div class="setting dark-white rounded-bottom" id="theme">
            <a href="#" data-toggle-class="active" data-target="#theme" class="dark-white toggle">
                <i class="fa fa-gear text-primary fa-spin"></i>
            </a>
            <div class="box-header">
                <a href="https://themeforest.net/item/apply-web-application-admin-template/21072584?ref=flatfull"
                    class="btn btn-xs rounded danger float-right">BUY</a>
                <strong>Theme Switcher</strong>
            </div>
            <div class="box-divider"></div>
            <div class="box-body">
                <p id="settingLayout">
                    <label class="md-check my-1 d-block">
                        <input type="checkbox" name="fixedAside">
                        <i></i>
                        <span>Fixed Aside</span>
                    </label>
                    <label class="md-check my-1 d-block">
                        <input type="checkbox" name="fixedContent">
                        <i></i>
                        <span>Fixed Content</span>
                    </label>
                    <label class="md-check my-1 d-block">
                        <input type="checkbox" name="folded">
                        <i></i>
                        <span>Folded Aside</span>
                    </label>
                    <label class="md-check my-1 d-block">
                        <input type="checkbox" name="container">
                        <i></i>
                        <span>Boxed Layout</span>
                    </label>
                    <label class="md-check my-1 d-block">
                        <input type="checkbox" name="ajax">
                        <i></i>
                        <span>Ajax load page</span>
                    </label>
                    <label class="pointer my-1 d-block" data-toggle="fullscreen" data-plugin="screenfull"
                        data-target="fullscreen">
                        <span class="ml-1 mr-2 auto">
                            <i class="fa fa-expand d-inline"></i>
                            <i class="fa fa-compress d-none"></i>
                        </span>
                        <span>Fullscreen mode</span>
                    </label>
                </p>
                <p>Colors:</p>
                <p>
                    <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
                        <input type="radio" name="theme" value="primary">
                        <i class="primary"></i>
                    </label>
                    <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
                        <input type="radio" name="theme" value="accent">
                        <i class="accent"></i>
                    </label>
                    <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
                        <input type="radio" name="theme" value="warn">
                        <i class="warn"></i>
                    </label>
                    <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
                        <input type="radio" name="theme" value="info">
                        <i class="info"></i>
                    </label>
                    <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
                        <input type="radio" name="theme" value="success">
                        <i class="success"></i>
                    </label>
                    <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
                        <input type="radio" name="theme" value="warning">
                        <i class="warning"></i>
                    </label>
                    <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
                        <input type="radio" name="theme" value="danger">
                        <i class="danger"></i>
                    </label>
                </p>
                <div class="row no-gutters">
                    <div class="col">
                        <p>Brand</p>
                        <p>
                            <label class="radio radio-inline m-0 mr-1 ui-check">
                                <input type="radio" name="brand" value="dark-white">
                                <i class="light"></i>
                            </label>
                            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
                                <input type="radio" name="brand" value="dark">
                                <i class="dark"></i>
                            </label>
                        </p>
                    </div>
                    <div class="col mx-2">
                        <p>Aside</p>
                        <p>
                            <label class="radio radio-inline m-0 mr-1 ui-check">
                                <input type="radio" name="aside" value="white">
                                <i class="light"></i>
                            </label>
                            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
                                <input type="radio" name="aside" value="dark">
                                <i class="dark"></i>
                            </label>
                        </p>
                    </div>
                    <div class="col">
                        <p>Themes</p>
                        <div class="clearfix">
                            <label class="radio radio-inline ui-check">
                                <input type="radio" name="bg" value="">
                                <i class="light"></i>
                            </label>
                            <label class="radio radio-inline ui-check ui-check-color">
                                <input type="radio" name="bg" value="dark">
                                <i class="dark"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <p>Demos</p>
                <div class="text-md">
                    <a href="dashboard.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark"
                        class="no-ajax badge light">0</a>
                    <a href="dashboard.1.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark-white"
                        class="no-ajax badge light">1</a>
                    <a href="dashboard.2.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=white"
                        class="no-ajax badge light">2</a>
                    <a href="dashboard.3.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white"
                        class="no-ajax badge light">3</a>
                    <a href="dashboard.4.html?folded=true&amp;bg=&amp;aside=dark" class="no-ajax badge light">4</a>
                    <a href="dashboard.5.html?folded=true&amp;bg=&amp;aside=dark&amp;brand=dark"
                        class="no-ajax badge light">5</a>
                    <a href="dashboard.6.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white"
                        class="no-ajax badge light">6</a>
                    <a href="dashboard.7.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark"
                        class="no-ajax badge light">7</a>
                    <a href="dashboard.8.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white"
                        class="no-ajax badge light">8</a>
                    <a href="rtl.html?folded&amp;bg=" class="no-ajax badge light">RTL</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ############ SWITHCHER END-->

    <!-- build:js scripts/app.min.js -->
    <!-- jQuery -->
    <script src="{{ url('assets') }}/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ url('assets') }}/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="{{ url('assets') }}/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- core -->
    <script src="{{ url('assets') }}/libs/pace-progress/pace.min.js"></script>
    <script src="{{ url('assets') }}/libs/pjax/pjax.js"></script>

    <script src="{{ url('assets') }}/html/scripts/lazyload.config.js"></script>
    <script src="{{ url('assets') }}/html/scripts/lazyload.js"></script>
    <script src="{{ url('assets') }}/html/scripts/plugin.js"></script>
    <script src="{{ url('assets') }}/html/scripts/nav.js"></script>
    <script src="{{ url('assets') }}/html/scripts/scrollto.js"></script>
    <script src="{{ url('assets') }}/html/scripts/toggleclass.js"></script>
    <script src="{{ url('assets') }}/html/scripts/theme.js"></script>
    <script src="{{ url('assets') }}/html/scripts/ajax.js"></script>
    <script src="{{ url('assets') }}/html/scripts/app.js"></script>
    <!-- endbuild -->
</body>

</html>
