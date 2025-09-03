    @include('frontend.layouts.header')
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
    <?php
    $loc = app()->getLocale();
    if ($loc == "ch") {
        $lct = "chn";
        $by = "通过";
        $order = "最小订购量 : ";
    } else if ($loc == "in") {
        $lct = "in";
        $by = "Oleh";
        $order = "Min Order : ";
    } else {
        $lct = "en";
        $by = "By";
        $order = "Min Order : ";
    }
    ?>
    <style>
        #catlist {
            font-size: 12px;
            color: #037CFF;
        }

        .list-group-item {
            background-color: #DDEFFD;
            border: none;
        }

        .eksporter_img {
            border-radius: 50%;
            width: 14%;
        }

        .panel-srv {
            /*background-color: silver;*/
            color: black;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
        }

        .href-name {
            color: black;
        }

        .href-name:hover {
            text-decoration: none;
        }

        .href-company {
            text-transform: capitalize;
            font-size: 11px;
            font-family: 'Open Sans', sans-serif;
            /*color: black;*/
        }

        .href-company:hover {
            text-decoration: none;
            color: black !important;
        }

        .href-category {
            text-transform: capitalize;
            font-size: 11px !important;
            font-family: 'Open Sans', sans-serif;
        }

        .href-category:hover {
            text-decoration: none;
            /*color: #2777d0 !important;*/
        }

        .single_product:hover {
            box-shadow: 0 0 15px rgba(178, 221, 255, 1);
        }

        .table-light {
            background-color: #d9dbdf;
        }

        .accordionnya {
            margin-bottom: 30px;
            border-radius: 30px;
        }

        .headernya {

            border-top-left-radius: 25px !important;
            border-top-right-radius: 25px !important;
            border-bottom-left-radius: 25px !important;
            border-bottom-right-radius: 25px !important;
        }

        .buttonnya {
            font-size: 14px;
            background-size: 16px;
            background-color: #ffe300;
            border-radius: 20px;
            border-color: #e9fdeb;
            color: #1d7bff;
            width: 137px;
            height: 41px;
        }

        .tblnya {
            width: 1170px;
        }

        .widget_inner {
            background: radial-gradient(circle at top left, #F0FDFF 10%, #EDF7FF);
        }

        .table1 {
            background: radial-gradient(circle at top left, #FFFEED, #F4FFF1);
        }

        .accordionnya {
            background: radial-gradient(circle at top left, #F0FDFF 10%, #EDF7FF);
        }
        .namecompany{
            text-shadow: 1px 1Px 20px #74A9B4;
        }
    </style>
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="breadcrumb_content" style="padding-bottom: 0px;">
                        <ul>
                            <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                            <li><a href="{{url('/front_end/list_perusahaan')}}">@lang('frontend.home.eksporter')</a></li>
                            <li>@lang('frontend.liseksportir.detailtitle')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--breadcrumbs area end-->

        <?php
        //Image
        $img1 = $data->foto_profil;

        if ($img1 == NULL) {
            $isimg1 = '/front/assets/icon/icon logo.png';
        } else {
            $image1 = 'uploads/Profile/Eksportir/' . $data->id_user . '/' . $img1;
            if (file_exists($image1)) {
                $isimg1 = '/uploads/Profile/Eksportir/' . $data->id_user . '/' . $img1;
            } else {
                $isimg1 = '/front/assets/icon/icon logo.png';
            }
        }
        $param = $data->id_user . '-' . getCompanyName($data->id_user);
        $param2 = getExBadan($data->id_user);
        ?>

        <!--shop  area start-->
        <div class="shop_area shop_reverse">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!--sidebar widget start-->
                        <aside class="sidebar_widget">
                            <div class="widget_inner">
                                <div class="widget_list widget_categories">
                                    <center>
                                        <img src="{{url('/')}}{{$isimg1}}" alt="" class="eksporter_img" style="background-color:#FFFFFF">
                                    </center>
                                    {{-- <br> --}}
                                    @php
                                    // dd($data);
                                    @endphp
                                    <center><h3 class="namecompany" style="color: #205871; text-transform: uppercase;"><b>{{$data->company}},{{$data->badanusaha}}</b></h3></center>
                                    <center><h5 style="text-transform: Capitalize;"><i class="fas fa-map-marker-alt">&nbsp;&nbsp;</i>{{$data->city}}, {{getProvinceName($data->id_mst_province, $lct)}}</h5></center>
                                    <br>
                                    <center>
                                        <h5 style="text-transform: uppercase;">{{$data->description}}</h5>
                                    </center>
                                    {{-- <table border="0" style="width: 100%; font-size: 13px;">

                                        <tr>
                                            <td>
                                                <b>@lang('frontend.liseksportir.website')</b>
                                            </td>
                                            <td>:</td>
                                            <td><a target="_blank" href="http://{{$data->website}}">{{$data->website}}</a></td>
                                    </tr>

                                    </table>
                                    <hr>
                                    <h6 style="text-transform: uppercase;"><b>@lang('frontend.liseksportir.address')</b></h6>
                                    <p style="font-size: 13px;">
                                        {{$data->addres}}, {{$data->city}}, {{getProvinceName($data->id_mst_province, $lct)}}
                                    </p> --}}
                                    <hr>
                                    {{-- <span style="font-size: 13px;">--}}
                                    {{-- @if($loc == "ch")--}}
                                    {{-- 或通过电子邮件与出口商联系：--}}
                                    {{-- @elseif($loc == "in")--}}
                                    {{-- Atau hubungi eksportir melalui email:--}}
                                    {{-- @else--}}
                                    {{-- Or contact exporter via email :--}}
                                    {{-- @endif--}}
                                    {{-- <br>--}}
                                    {{-- <span style="color: #007bff;">{{$data->email}}</span>--}}
                                    {{-- </span>--}}
                                    <table class="table table-bordered table-light table1">
                                        <tbody>
                                            <tr>
                                                <td width="20%" class="table-active">
                                                    <b> @lang("frontend.event.scope") </b>
                                                </td>
                                                <td width="30%">
                                                    @if($loc == 'in')
                                                    {{SOB($data->id_eks_business_size)}}
                                                    @else
                                                    {{SOB_EN($data->id_eks_business_size)}}
                                                    @endif
                                                </td>
                                                <td width="20%" class="table-active">
                                                    <b> @lang("frontend.event.type") </b>
                                                </td>
                                                <td width="30%">
                                                    @if($loc == 'in')
                                                    {{TOB($data->id_business_role_id)}}
                                                    @else
                                                    {{TOB_EN($data->id_business_role_id)}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" class="table-active">
                                                    <b> No. of Employees </b>
                                                </td>
                                                <td width="30%">
                                                    {{($data->employe != null) ? $data->employe : '-'}}
                                                </td>
                                                <td width="20%" class="table-active">
                                                    <b> Phone </b>
                                                </td>
                                                <td width="30%">
                                                    {{($data->phone != null) ? $data->phone : '-'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" class="table-active">
                                                    <b> Website </b>
                                                </td>
                                                <td width="30%">
                                                    {{($data->website != null) ? $data->website : '-'}}
                                                </td>
                                                <td width="20%" class="table-active">
                                                    <b> Email </b>
                                                </td>
                                                <td width="30%">
                                                    {{($data->email != null) ? $data->email : '-'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" class="table-active">
                                                    <b> Export To </b>
                                                </td>
                                                <td width="30%">
                                                    <ul>
                                                        @forelse ($negara_eks as $eks)
                                                        <li>{{$eks->country}}</li>
                                                        @empty
                                                        <li>Not Specified</li>
                                                        @endforelse
                                                    </ul>
                                                </td>
                                                <td width="20%" class="table-active">
                                                    <b> Product(s) Sold </b>
                                                </td>
                                                <td width="30%">
                                                    <ul>
                                                        @foreach ($categories as $c)
                                                        <li>{{$c->nama_kategori_en}}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="20%" class="table-active">
                                                    <b> Addres </b>
                                                </td>
                                                <td width="30%">
                                                    <ul>
                                                        {{($data->addres != null) ? $data->addres : '-'}}
                                                    </ul>
                                                </td>
                                                <td width="20%" class="table-active">
                                                    <b> City </b>
                                                </td>
                                                <td width="30%">
                                                    <ul>
                                                        {{($data->city != null) ? $data->city : '-'}}
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="" style="margin-left: 535px;">
                                        <button onclick="openlink()" class="buttonnya">
                                            Add Inquery
                                        </button>
                                        <button class="buttonnya" onclick="exportData()" style="margin-left: 370px;">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                            Print
                                        </button>
                                        <!-- <a target="_blank" href="{{ url('/front_end/listeksportir/cetakpdf/'.$data->id) }}"  class="buttonnya" style="margin-left: 370px;">
                                            <i class="fa fa-download"></i> Export PDF
                                        </a> -->
                                    </div>

                                    <!-- <span style="">&nbsp;<b>&nbsp;@lang("frontend.cu-add-visit") :</b></span><br> -->
                                    <!-- <span style="font-size: 13px;">
                                        {{($data->addres != null) ? $data->addres : '-'}}, {{($data->city != null) ? $data->city : '-'}}, {{($data->id_mst_province != null) ? getProvinceName($data->id_mst_province, $lct) : '-'}} {{($data->postcode != null) ? $data->postcode : '-'}}
                                    </span> -->
                                </div>
                            </div>
                        </aside>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <!-- sidebar widget end-
                        sidebar widget start
                        <aside class="sidebar_widget">
                            <div class="widget_inner">
                                <div class="widget_list widget_categories">
                                    
                                    {{-- <span style="text-transform: uppercase;"><b>@lang("frontend.cu-cu")</b></span><br>
                                    <span style="font-size: 13px;">
                                        @if($loc == "ch")
                                            你需要更多信息？
                                        @elseif($loc == "in")
                                            Apakah Anda memerlukan informasi lebih lanjut?
                                        @else
                                            Do you need more information?
                                        @endif
                                    </span>
                                    <br>
                                    <span style="color: red; font-size: 13px;">
                                        @if($loc == "ch")
                                            给我们发信息！
                                        @elseif($loc == "in")
                                            Kirim pesan kepada kami!
                                        @else
                                            Send us a message!
                                        @endif
                                    </span>
                                    <br><br>
                                    <form action="{{url('/contact-us/send/')}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="text" id="id" class="form-control integer" name="name" autocomplete="off" placeholder="@lang("frontend.cu-fullname")" style="font-size: 13px;" required>
                                                <input type="hidden" name="urlnya" id="urlnya" value="/front_end/list_perusahaan/view/{{$param}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="email" class="form-control" name="email" autocomplete="off" placeholder="@lang("frontend.cu-email")" style="font-size: 1z3px;" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="subyek" autocomplete="off" placeholder="@lang("frontend.cu-subyek")" style="font-size: 13px;" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <textarea class="form-control" name="message" id="message" placeholder="@lang("frontend.cu-message")" style="font-size: 13px;" rows="3"></textarea>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <button class="btn button_form" type="submit" style="font-weight:bold; font-size: 13px; width: 100%; border-radius: 15px; background-color: #ffe300; color:#1d7bff">@lang("button-name.submit")</button>
                                            </div>
                                        </div>
                                    </form> --}}
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="email" class="form-control" name="email" autocomplete="off" placeholder="@lang(" frontend.cu-email")" style="font-size: 1z3px;" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="subyek" autocomplete="off" placeholder="@lang(" frontend.cu-subyek")" style="font-size: 13px;" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="message" id="message" placeholder="@lang(" frontend.cu-message")" style="font-size: 13px;" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button class="btn button_form" type="submit" style="font-weight:bold; font-size: 13px; width: 100%; border-radius: 15px; background-color: #ffe300; color:#1d7bff">@lang("button-name.submit")</button>
                                    </div>
                                </div>
                                </form> --}}
                            </div>
                        </aside>
                        <sidebar widget end
                    </div> -->
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- List Brand -->
                            <div class="card accordionnya" style="margin-top: 14px;">
                                <div class="card-header headernya" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="color: #204051;">
                                            <b>Brand</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">

                                            <table id="tablebrands" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            Brand
                                                        </th>
                                                        <th>
                                                            <center>Meaning Of Brand</center>
                                                        </th>
                                                        <th>
                                                            <center>Month</center>
                                                        </th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                        <th>
                                                            <center>Copyright Number</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Country Patent Brand -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color: #204051;">
                                            <b>Country Patent Brand</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">

                                            <table id="tableCountry" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            <center>Brand</center>
                                                        </th>
                                                        <th>
                                                            <center>Country</center>
                                                        </th>
                                                        <th>
                                                            <center>Month</center>
                                                        </th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- product capacity -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="flas" aria-controls="collapseThree" style="color: #204051;">
                                            <b>Product Capacity</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tableprocap" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>
                                                            <center>No</center>
                                                        </th>
                                                        <th>
                                                            <center>
                                                                Year
                                                            </center>
                                                        </th>
                                                        <th>
                                                            <center>Own Production (%)</center>
                                                        </th>
                                                        <th>
                                                            <center>Outside Production (%)</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- List Capacity Utilization -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingfour">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="flas" aria-controls="collapsefour" style="color: #204051;">
                                            <b>Capacity Utilization</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapsefour" class="collapse show" aria-labelledby="headingfour" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tableexdes" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                        <th>
                                                            <center>Used Capacity</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Raw Material -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingfive">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="flas" aria-controls="collapsefive" style="color: #204051;">
                                            <b>Raw Material</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapsefive" class="collapse show" aria-labelledby="headingfive" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tableraw" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                        <th>
                                                            <center>From Domestic</center>
                                                        </th>
                                                        <th>
                                                            <center>Overseas</center>
                                                        </th>
                                                        <th>
                                                            <center>Value From Domestic</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Annual Sales -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingsix">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="flas" aria-controls="collapsesix" style="color: #204051;">
                                            <b>Annual Sales</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapsesix" class="collapse show" aria-labelledby="headingsix" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tablesales" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            Year
                                                        </th>
                                                        <th>
                                                            <center>Value (USD)</center>
                                                        </th>
                                                        <th>
                                                            <center>Percentage (%)</center>
                                                        </th>
                                                        <th>
                                                            <center>Export Value (USD)</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- labor -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headinseven">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="flas" aria-controls="collapseseven" style="color: #204051;">
                                            <b>Labor</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseseven" class="collapse show" aria-labelledby="headinseven" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tablelabor" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                        <th>
                                                            <center>Local Employe</center>
                                                        </th>
                                                        <th>
                                                            <center>Foreign Worker</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Taxes -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingeight">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseeight" aria-expanded="flas" aria-controls="collapseeight" style="color: #204051;">
                                            <b>Taxes</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseeight" class="collapse show" aria-labelledby="headingeight" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tabletaxes" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                        <th>
                                                            <center>Report PPH</center>
                                                        </th>
                                                        <th>
                                                            <center>Report PPN</center>
                                                        </th>
                                                        <th>
                                                            <center>Report Pasal 21</center>
                                                        </th>
                                                        <th>
                                                            <center>Total PPH</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Export Destination -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingnine">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseniine" aria-expanded="flas" aria-controls="collapseniine" style="color: #204051;">
                                            <b>Export Destination</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseniine" class="collapse show" aria-labelledby="headingnine" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tabledesti" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            <center>Year</center>
                                                        </th>
                                                        <th>
                                                            <center>Country</center>
                                                        </th>
                                                        <th>
                                                            <center>Ratio Export</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Port Of Landing -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingten">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseten" aria-expanded="flas" aria-controls="collapseten" style="color: #204051;">
                                            <b>Port Of Landing</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseten" class="collapse show" aria-labelledby="headingten" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tableportland" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            <center>Port</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- exhibition -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="heading10">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="flas" aria-controls="collapse10" style="color: #204051;">
                                            <b>Exhibition</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse10" class="collapse show" aria-labelledby="heading10" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tableexhibition" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>
                                                            <center>No</center>
                                                        </th>
                                                        <th>
                                                            <center> Exhibition</center>
                                                        </th>
                                                        <th>
                                                            <center>Booth Area</center>
                                                        </th>
                                                        <th>
                                                            <center>Value Contract</center>
                                                        </th>
                                                        <th>
                                                            <center>Subsidy DGNED</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- training -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingelev">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapselev" aria-expanded="flas" aria-controls="collapselev" style="color: #204051;">
                                            <b>Training</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapselev" class="collapse show" aria-labelledby="headingelev" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <table id="tabletrain" class="table table-striped table-hover tblnya">
                                                <thead class="text-black" style="background: radial-gradient(circle at top left, #FFFEED, #F4FFF1); ">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>
                                                            <center>Training</center>
                                                        </th>
                                                        <th>
                                                            <center>Organizer</center>
                                                        </th>
                                                        <th>
                                                            <center>Start Date</center>
                                                        </th>
                                                        <th>
                                                            <center>Due Date</center>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- product -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingprod">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#colapseproduct" aria-expanded="flas" aria-controls="colapseproduct" style="color: #204051;">
                                            <b>Product</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="colapseproduct" class="collapse show" aria-labelledby="headingprod" data-parent="#accordion" style="padding: 17px;">
                                    <div class="breadcrumb_content">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_perusahaan/view/'.$param)}}" id="formvekssort">
                                            {{ csrf_field() }}
                                            <select name="shortprodeks" id="shortprodeks" style="border: none;">
                                                <option value="" @if(isset($sortby)) @if($sortby=="" ) selected @endif @endif>@lang('frontend.liseksportir.default')</option>
                                                <option value="new" @if(isset($sortby)) @if($sortby=="new" ) selected @endif @endif>@lang('frontend.liseksportir.newest')</option>
                                                <option value="asc" @if(isset($sortby)) @if($sortby=="asc" ) selected @endif @endif>@lang('frontend.liseksportir.eksporternm')</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="row shop_wrapper">
                                        @foreach($product as $pro)
                                        <?php
                                        //new or not
                                        if (date('m', strtotime($pro->created_at)) == date('m')) {
                                            $dis = "";
                                        } else {
                                            $dis = "display: none;";
                                        }

                                        //category
                                        $cat1 = getCategoryName($pro->id_csc_product, $lct);
                                        $cat2 = getCategoryName($pro->id_csc_product_level1, $lct);
                                        $cat3 = getCategoryName($pro->id_csc_product_level2, $lct);

                                        if ($cat3 == "-") {
                                            if ($cat2 == "-") {
                                                $categorynya = $cat1;
                                                $idcategory = $pro->id_csc_product;
                                            } else {
                                                $categorynya = $cat2;
                                                $idcategory = $pro->id_csc_product_level1;
                                            }
                                        } else {
                                            $categorynya = $cat3;
                                            $idcategory = $pro->id_csc_product_level2;
                                        }

                                        //Image
                                        $img1 = $pro->image_1;
                                        $img2 = $pro->image_2;

                                        if ($img1 == NULL) {
                                            $isimg1 = '/image/notAvailable.png';
                                        } else {
                                            $image1 = 'uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img1;
                                            if (file_exists($image1)) {
                                                $isimg1 = '/uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img1;
                                            } else {
                                                $isimg1 = '/image/notAvailable.png';
                                            }
                                        }

                                        $cekImage = explode('.', $img1);
                                        $sizeImg = 210;
                                        $padImg = '0px';
                                        if ($cekImage[(count($cekImage) - 1)] == 'png') {
                                            $sizeImg = 190;
                                            $padImg = '10px 5px 0px 5px';
                                        }
                                        $minorder = '-';
                                        $minordernya = '-';
                                        if ($pro->minimum_order != null) {
                                            $minorder = $pro->minimum_order;
                                            if (strlen($minorder) > 18) {
                                                $cut_desc = substr($minorder, 0, 18);
                                                if ($minorder[18 - 1] != ' ') {
                                                    $new_pos = strrpos($cut_desc, ' ');
                                                    $cut_desc = substr($minorder, 0, $new_pos);
                                                }
                                                $minordernya = $cut_desc . '...';
                                            } else {
                                                $minordernya = $minorder;
                                            }
                                        }
                                        $ukuran = '340px';
                                        if (!empty(Auth::guard('eksmp')->user())) {
                                            if (Auth::guard('eksmp')->user()->status == 1) {
                                                $ukuran = '375px';
                                            }
                                        }

                                        if ($img2 == NULL) {
                                            $isimg2 = '/image/notAvailable.png';
                                        } else {
                                            $image2 = 'uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img2;
                                            if (file_exists($image2)) {
                                                $isimg2 = '/uploads/Eksportir_Product/Image/' . $pro->id . '/' . $img2;
                                            } else {
                                                $isimg2 = '/image/notAvailable.png';
                                            }
                                        }
                                        ?>
                                        <div class="col-lg-3 col-md-4 col-12 ">
                                            <div class="single_product" style="height: {{$ukuran}}; background-color: #fdfdfc; padding: 0px !important;">
                                                <div class="pro-type" style="{{$dis}}">
                                                    <span class="pro-type-content">
                                                        @if($loc == "ch")
                                                        新
                                                        @elseif($loc == "in")
                                                        BARU
                                                        @else
                                                        NEW
                                                        @endif
                                                    </span>
                                                </div>
                                                <?php
                                                //cut prod name
                                                $num_char = 29;
                                                $prodn = getProductAttr($pro->id, 'prodname', $lct);
                                                if (strlen($prodn) > 29) {
                                                    $cut_text = substr($prodn, 0, $num_char);
                                                    if ($prodn[$num_char - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                        $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                        $cut_text = substr($prodn, 0, $new_pos);
                                                    }
                                                    $prodnama = $cut_text . '...';
                                                } else {
                                                    $prodnama = $prodn;
                                                }

                                                //cut company
                                                $num_charp = 25;
                                                $compname = getCompanyName($pro->id_itdp_company_user);
                                                if (strlen($compname) > 25) {
                                                    $cut_text = substr($compname, 0, $num_charp);
                                                    if ($compname[$num_charp - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                        $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                        $cut_text = substr($compname, 0, $new_pos);
                                                    }
                                                    $companame = $cut_text . '...';
                                                } else {
                                                    $companame = $compname;
                                                }

                                                $num_chark = 32;
                                                if (strlen($categorynya) > 32) {
                                                    $cut_text = substr($categorynya, 0, $num_chark);
                                                    if ($categorynya[$num_chark - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                        $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                        $cut_text = substr($categorynya, 0, $new_pos);
                                                    }
                                                    $category = $cut_text . '...';
                                                } else {
                                                    $category = $categorynya;
                                                }
                                                ?>
                                                <div class="product_thumb" align="center" style="background-color: #e8e8e4; height: 210px; border-radius: 10px 10px 0px 0px; vertical-align: middle;">
                                                    <a class="primary_img" href="{{url('front_end/product/'.$pro->id)}}" onclick="GoToProduct('{{$pro->id}}', event, this)"><img src="{{url('/')}}{{$isimg1}}" alt="" style="vertical-align: middle; height: {{$sizeImg}}px; border-radius: 10px 10px 0px 0px; padding: {{$padImg}}"></a>
                                                    <!-- <a class="secondary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a> -->
                                                </div>
                                                <div class="product_name grid_name" style="padding: 0px 13px 0px 13px;">
                                                    <p class="manufacture_product">
                                                        <a href="{{url('front_end/list_product/category/'.$idcategory)}}" title="{{$categorynya}}" class="href-category">{{$category}}</a>
                                                    </p>
                                                    <h3>
                                                        <a href="{{url('front_end/product/'.$pro->id)}}" title="{{$prodn}}" class="href-name" onclick="GoToProduct('{{$pro->id}}', event, this)"><b>{{$prodnama}}</b></a>
                                                    </h3>
                                                    <span style="font-size: 12px; font-family: 'Open Sans', sans-serif; ">
                                                        @if(!empty(Auth::guard('eksmp')->user()))
                                                        @if(Auth::guard('eksmp')->user()->status == 1)
                                                        Price :
                                                        @if(is_numeric($pro->price_usd))
                                                        <?php
                                                        $pricenya = "$ " . number_format($pro->price_usd, 0, ",", ".");
                                                        $price = $pricenya;
                                                        ?>
                                                        @else
                                                        <?php
                                                        $price = $pro->price_usd;
                                                        if (strlen($price) > 25) {
                                                            $cut_text = substr($price, 0, 25);
                                                            if ($price[25 - 1] != ' ') {
                                                                $new_pos = strrpos($cut_text, ' ');
                                                                $cut_text = substr($price, 0, $new_pos);
                                                            }
                                                            $pricenya = $cut_text . '...';
                                                        } else {
                                                            $pricenya = $price;
                                                        }
                                                        ?>
                                                        @endif
                                                        <span style="color: #fd5018;" title="{{$price}}">
                                                            {{$pricenya}}
                                                        </span>
                                                        <br>
                                                        @endif
                                                        @endif

                                                        {{$order}}<span title="{{$minorder}}">{{$minordernya}}</span><br>
                                                        <a href="{{url('front_end/list_perusahaan/view/'.$param)}}" title="{{$compname}}" class="href-company"><span style="color: black;">{{$by}}</span>&nbsp;&nbsp;{{$companame}}</a>
                                                    </span>
                                                </div>
                                                <div class="product_content list_content" style="width: 100%;">
                                                    <div class="left_caption">
                                                        <div class="product_name">
                                                            <h3>
                                                                <a href="{{url('front_end/product/'.$pro->id)}}" title="{{$prodn}}" class="href-name" style="font-size: 15px !important;" onclick="GoToProduct('{{$pro->id}}', event, this)"><b>{{$prodn}}</b></a>
                                                            </h3>
                                                            <h3>
                                                                <a href="{{url('front_end/list_perusahaan/view/'.$param)}}" title="{{$compname}}" class="href-company"><span style="color: black;">by</span>&nbsp;&nbsp;{{$compname}}</a>
                                                            </h3>
                                                        </div>
                                                        <div class="product_desc">
                                                            <?php
                                                            $proddesc = getProductAttr($pro->id, 'product_description', $lct);
                                                            $num_desc = 350;
                                                            if (strlen($proddesc) > $num_desc) {
                                                                $cut_desc = substr($proddesc, 0, $num_desc);
                                                                if ($proddesc[$num_desc - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                                    $new_pos = strrpos($cut_desc, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                                    $cut_desc = substr($proddesc, 0, $new_pos);
                                                                }
                                                                $product_desc = $cut_desc . '...';
                                                            } else {
                                                                $product_desc = $proddesc;
                                                            }
                                                            $product_desc = strip_tags($product_desc, "<br><i><b><u><hr>");
                                                            $capacitynya = '-';
                                                            if ($pro->capacity != null) {
                                                                if ($loc == "ch") {
                                                                    $capacitynya = '库存 ' . $pro->capacity . ' 件';
                                                                } else if ($loc == 'in') {
                                                                    $capacitynya = $pro->capacity . ' dalam persediaan';
                                                                } else {
                                                                    $capacitynya = $pro->capacity . ' in stock';
                                                                }
                                                            }
                                                            ?>
                                                            <?php echo $product_desc; ?>
                                                        </div>
                                                    </div>
                                                    <div class="right_caption">
                                                        <div class="text_available">
                                                            <p>
                                                                @lang('frontend.available'):
                                                                <span>{{$capacitynya}}</span>
                                                            </p>
                                                        </div>
                                                        <div class="price_box">
                                                            @if(!empty(Auth::guard('eksmp')->user()))
                                                            @if(Auth::guard('eksmp')->user()->status == 1)
                                                            <span class="current_price">
                                                                @if(is_numeric($pro->price_usd))
                                                                $ {{number_format($pro->price_usd,0,",",".")}}
                                                                @else
                                                                <span style="font-size: 13px;">
                                                                    {{$pro->price_usd}}
                                                                </span>
                                                                @endif
                                                            </span>
                                                            @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <br>
                                    @if($coproduct > 12)
                                    <div class="pagination" style="float: right;">
                                        {{ $product->links('vendor.pagination.bootstrap-4') }}
                                        {{ $product->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!-- service -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingservice">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseservice" aria-expanded="flas" aria-controls="collapseservice" style="color: #204051;">
                                            <b>Service</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseservice" class="collapse show" aria-labelledby="headingservice" data-parent="#accordion">
                                    <div class="col-4" style="text-align: left;">
                                        <div class="breadcrumb_content">
                                            <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_perusahaan/view/'.$param)}}" id="formsrvsort">
                                                {{ csrf_field() }}
                                                <select name="shortsrveks" id="shortsrveks" style="border: none;">
                                                    <option value="" @if(isset($sortbysrv)) @if($sortbysrv=="" ) selected @endif @endif>@lang('frontend.liseksportir.default')</option>
                                                    <option value="new" @if(isset($sortbysrv)) @if($sortbysrv=="new" ) selected @endif @endif>@lang('frontend.liseksportir.newest')</option>
                                                    <option value="asc" @if(isset($sortbysrv)) @if($sortbysrv=="asc" ) selected @endif @endif>@lang('frontend.liseksportir.eksporternm')</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-8" style="text-align: right;">
                                        <div class="breadcrumb_content">
                                            <div class="page_amount">
                                                <p>
                                                    @if($loc == "ch")
                                                    <b>找到{{count($service)}}个服务</b>
                                                    @elseif($loc == "in")
                                                    <b>{{count($service)}} Pelayanan</b> ditemukan
                                                    @else
                                                    <b>{{count($service)}} Services</b> Found
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($service as $srv)
                                        <div class="col-lg-12 col-md-4 col-12" style="margin-bottom: 2%;">
                                            <div class="panel-srv">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5><b>{{getServiceAttribute($srv->id ,'nama', $lcts)}}</b></h5>
                                                    </div>
                                                </div>
                                                <hr style="margin-top: 0px;">
                                                <div class="row" style="font-size: 13px;">
                                                    <div class="col-md-6">
                                                        <label><b>Field of Work :</b></label><br>
                                                        <?php
                                                        $bidang = getServiceAttribute($srv->id, 'bidang', $lcts);
                                                        $bid = explode(', ', $bidang);
                                                        for ($b = 0; $b < count($bid); $b++) {
                                                            echo $bid[$b] . '<br>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><b>Skills :</b></label><br>
                                                        {{getServiceAttribute($srv->id ,'skill', $lcts)}}
                                                    </div>
                                                    <br>
                                                </div><br>
                                                <div class="row" style="font-size: 13px;">
                                                    <div class="col-md-6">
                                                        <label><b>Experiences :</b></label><br>
                                                        <?php echo getServiceAttribute($srv->id, 'pengalaman', $lcts); ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><b>Links :</b></label><br>
                                                        <?php echo getServiceAttribute($srv->id, 'link', ''); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- maps -->
                            <div class="card accordionnya">
                                <div class="card-header headernya" id="headingmaps">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsemaps" aria-expanded="flas" aria-controls="collapsemaps" style="color: #204051;">
                                            <b>Maps</b>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapsemaps" class="collapse show" aria-labelledby="headingmaps" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                                            <div class="mapouter">
                                                <div class="gmap_canvas">
                                                    <iframe width="100%" height="400px" id="gmap_canvas" src="https://maps.google.com/maps?q=PT%20Maxxima&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net/blog/torguard-promo-code/"></a>
                                                </div>
                                                <style>
                                                    .mapouter {
                                                        position: relative;
                                                        text-align: right;
                                                        width: 100%;
                                                    }

                                                    .gmap_canvas {
                                                        overflow: hidden;
                                                        background: none !important;
                                                        width: 100%;
                                                    }
                                                </style>
                                            </div>
                                            <span style="font-size: 13px;">
                                        {{($data->addres != null) ? $data->addres : '-'}}, {{($data->city != null) ? $data->city : '-'}}, {{($data->id_mst_province != null) ? getProvinceName($data->id_mst_province, $lct) : '-'}} {{($data->postcode != null) ? $data->postcode : '-'}}
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                </div>
            </div>
        </div>
    </div>
    <!--shop  area end-->
    <!-- Plugins JS -->

    <script src=""></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    @include('frontend.layouts.footer')
    <script type="text/javascript">
        $(document).ready(function() {
            //data tabel
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#tabletrain').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-training/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_training',
                        name: 'nama_training'
                    },
                    {
                        data: 'penyelenggara',
                        name: 'penyelenggara'
                    },
                    {
                        data: 'tanggal_mulai',
                        name: 'tanggal_mulai'
                    },
                    {
                        data: 'tanggal_selesai',
                        name: 'tanggal_selesai'
                    },
                ]
            });
            $('#tableexhibition').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-exhib/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'id_itdp_eks_event_profil',
                        name: 'id_itdp_eks_event_profil'
                    },
                    {
                        data: 'luas_boot',
                        name: 'luas_boot'
                    },
                    {
                        data: 'nilai_kontrak',
                        name: 'nilai_kontrak'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ]
            });
            $('#tableportland').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-portland/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name_port',
                        name: 'name_port'
                    },
                ]
            });
            $('#tabledesti').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-desti/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'rasio_persen',
                        name: 'rasio_persen'
                    },
                ]
            });
            $('#tabletaxes').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-tax/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'laporan_pph',
                        name: 'laporan_pph'
                    },
                    {
                        data: 'laporan_ppn',
                        name: 'laporan_ppn'
                    },
                    {
                        data: 'laporan_psl21',
                        name: 'laporan_psl21'
                    },
                    {
                        data: 'setor_pph',
                        name: 'setor_pph'
                    },
                ]
            });
            $('#tablelabor').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-labor/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'lokal_orang',
                        name: 'lokal_orang'
                    },
                    {
                        data: 'asing_orang',
                        name: 'asing_orang'
                    },
                ]
            });
            $('#tablesales').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-sales/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'nilai',
                        name: 'nilai'
                    },
                    {
                        data: 'nilai_persen',
                        name: 'nilai_persen'
                    },
                    {
                        data: 'nilai_ekspor',
                        name: 'nilai_ekspor'
                    },
                ]
            });
            $('#tableraw').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-raw/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'lokal_persen',
                        name: 'lokal_persen'
                    },
                    {
                        data: 'impor_persen',
                        name: 'impor_persen'
                    },
                    {
                        data: 'nilai_impor',
                        name: 'nilai_impor'
                    },
                ]
            });
            $('#tableexdes').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-capacity/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'kapasitas_terpakai_persen',
                        name: 'kapasitas_terpakai_persen'
                    },
                ]
            });
            $('#tableprocap').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-procap/'.$id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'sendiri_persen',
                        name: 'sendiri_persen'
                    },
                    {
                        data: 'outsourcing_persen',
                        name: 'outsourcing_persen'
                    },
                ]
            });
            $('#tableCountry').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/country_patern_brand/'.$id)  }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'merek',
                        name: 'merek'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'bulan',
                        name: 'bulan'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },

                ]
            });
            $('#tablebrands').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: "{{ url('front_end/data-brand/'.$id)  }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'merek',
                        name: 'merek'
                    },
                    {
                        data: 'arti_merek',
                        name: 'arti_merek'
                    },
                    {
                        data: 'bulan_merek',
                        name: 'bulan_merek'
                    },
                    {
                        data: 'tahun_merek',
                        name: 'tahun_merek'
                    },
                    {
                        data: 'paten_merek',
                        name: 'paten_merek'
                    },
                ]
            });
            //end data 
            $("#shortprodeks").on('change', function() {
                $('#formvekssort').submit();
            })

            $("#shortsrveks").on('change', function() {
                $('#formsrvsort').submit();
            })

            $('#grid').on('click', function() {
                $('.product_thumb').css({
                    "margin-top": "0px",
                    "border-radius": "10px 10px 0px 0px"
                });
            })

            $('#list').on('click', function() {
                $('.product_thumb').css({
                    "margin-top": "60px",
                    "border-radius": "0px 10px 10px 0px"
                });
            });
        });

        function GoToProduct(id, e, obj) {
            e.preventDefault();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{route('product.hot')}}",
                type: 'post',
                data: {
                    '_token': token,
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response == 'ok') {
                        location.href = obj.href;
                    }
                }
            });
        }

        function openlink() {
            window.location = "{{url('br_importir_add/suplaier/'.$id)}}";

        }

        function exportData() {
            window.location = "{{url('/front_end/listeksportir/cetakpdf/'.$data->id)}}";
        }
    </script>