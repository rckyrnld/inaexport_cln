{{-- @include('header') --}}
@extends('header2')
@section('section_style')
    <style>

    </style>
@endsection
@section('section_script')
    {{-- FUSION CHART --}}
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript"
        src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script type="text/javascript" src="{{ url('assets') }}/libs/fusion-chart/Maps/fusioncharts.worldwithcountries.js">
    </script>

    {{-- <script type="text/javascript">
        FusionCharts.ready(function() {
            var chartObj = new FusionCharts({
                type: 'maps/world',
                renderAt: 'chart-container',
                width: '600',
                height: '400',
                dataFormat: 'json',
                dataSource: {
                    "chart": {
                        "caption": "Global Population",
                        "theme": "fusion",
                        "formatNumberScale": "0",
                        "numberSuffix": "M"
                    },
                    "colorrange": {
                        "color": [{
                            "minvalue": "0",
                            "maxvalue": "100",
                            "code": "#D0DFA3",
                            "displayValue": "< 100M"
                        }, {
                            "minvalue": "100",
                            "maxvalue": "500",
                            "code": "#B0BF92",
                            "displayValue": "100-500M"
                        }, {
                            "minvalue": "500",
                            "maxvalue": "1000",
                            "code": "#91AF64",
                            "displayValue": "500M-1B"
                        }, {
                            "minvalue": "1000",
                            "maxvalue": "5000",
                            "code": "#A9FF8D",
                            "displayValue": "> 1B"
                        }]
                    },
                    "data": [{
                        "id": "NA",
                        "value": "515"
                    }, {
                        "id": "SA",
                        "value": "373"
                    }, {
                        "id": "AS",
                        "value": "3875"
                    }, {
                        "id": "EU",
                        "value": "727"
                    }, {
                        "id": "AF",
                        "value": "885"
                    }, {
                        "id": "AU",
                        "value": "32"
                    }]
                }
            });
            chartObj.render();
        });
    </script> --}}
@endsection
@section('content')
    <!-- <script src="https://code.highcharts.com/modules/exporting.js"></script> -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
<script src="https://code.highcharts.com/modules/exporting.js"></script> --}}
    {{-- <style type="text/css">
    .highcharts-drilldown-axis-label {
        text-decoration: none !important;
        color: #4c4d61 !important;
        fill: #4c4d61 !important;
    }

    .top_data {
        display: inline-block;
        min-width: 50%;
    }
</style> --}}
    {{-- <style>
    #set_admin.nav-link.active, #set_perwakilan.nav-link.active, #set_importir.nav-link.active {
        background-color: #40bad2 !important;
        color: white !important;
    }

    /*CSS MODAL*/
    .modal-lg {
        width: 700px;
    }

    .modal-header {
        background-color: #84afd4;
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
        background-color: #84afd4;
        color: white;
        font-size: 20px;
        text-align: center;
    }
</style> --}}
    <!-- Card stats -->
@section('card-dashboard')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats position-relative" style="height:80%">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Members (Eks)</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $member_total }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-active-40"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Member (Buy)</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $member_import_total }}</span>
                        </div>
                    </div>
                    {{-- <a href="{{ url('chart/total_member') }}" class="stretched-link" style="color:white">Go somewhere</a> --}}
                    {{-- <p class="mt-3 mb-0 text-sm">
                      <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                      <span class="text-nowrap">Since last month</span>
                    </p> --}}
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-3 col-md-6">
            <div class="card card-stats position-relative">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Market Research</h5>
                            <span
                                class="h2 font-weight-bold mb-0">{{ array_sum(array_column($rc_total, 'jumlah')) }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-chart-pie-35"></i>
                            </div>
                        </div>
                        <a href="{{ url('chart/total_rc') }}" class="stretched-link" style="color:white">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats position-relative" style="height:80%">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Market Information</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $rc_total }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-chart-pie-35"></i>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="{{ url('chart/total_rc') }}" class="stretched-link" style="color:white">Go somewhere</a> --}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats position-relative" style="height:80%">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Inquiry</h5>
                            <span
                                class="h2 font-weight-bold mb-0">{{ array_sum(array_column($inquiry_total, 'jumlah')) }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-money-coins"></i>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="{{ url('chart/total_inquiry') }}" class="stretched-link" style="color:white">Go somewhere</a> --}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats position-relative" style="height:80%">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Income</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $zeke_total }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-chart-bar-32"></i>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="{{ url('chart/total_income') }}" class="stretched-link" style="color:white">Go somewhere</a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats position-relative" style="height:80%">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Active Event</h5>
                            <span
                                class="h2 font-weight-bold mb-0">{{ array_sum(array_column($event_total, 'jumlah')) }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-active-40"></i>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="{{ url('chart/total_event') }}" class="stretched-link" style="color:white">Go somewhere</a> --}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats position-relative" style="height:80%">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Training</h5>
                            <span
                                class="h2 font-weight-bold mb-0">{{ array_sum(array_column($training_total, 'jumlah')) }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-chart-pie-35"></i>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('chart/total_training') }}" class="stretched-link" style="color:white">Go
                        somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats position-relative" style="height:80%">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Representativ</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $statistik_total }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-money-coins"></i>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="{{ url('chart/total_rep') }}" class="stretched-link" style="color:white">Go somewhere</a> --}}
                </div>
            </div>
        </div>
        {{-- <div class="col-xl-3 col-md-6">
            <div class="card card-stats position-relative" style="height:80%">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Buying Request</h5>
                            <span
                                class="h2 font-weight-bold mb-0">{{ array_sum(array_column($buying_total, 'jumlah')) }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-chart-bar-32"></i>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('chart/total_buying_request') }}" class="stretched-link" style="color:white">Go
                        somewhere</a>
                </div>
            </div>
        </div> --}}

    </div>
@endsection

<!-- Page content -->
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    {{-- <div class="col-xl-8">
            <div class="card bg-default">
              <div class="card-header bg-transparent">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-light text-uppercase ls-1 mb-1">Overview</h6>
                    <h5 class="h3 text-white mb-0">Sales value</h5>
                  </div>
                  <div class="col">
                    <ul class="nav nav-pills justify-content-end">
                      <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark" data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}' data-prefix="$" data-suffix="k">
                        <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                          <span class="d-none d-md-block">Month</span>
                          <span class="d-md-none">M</span>
                        </a>
                      </li>
                      <li class="nav-item" data-toggle="chart" data-target="#chart-sales-dark" data-update='{"data":{"datasets":[{"data":[0, 20, 5, 25, 10, 30, 15, 40, 40]}]}}' data-prefix="$" data-suffix="k">
                        <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                          <span class="d-none d-md-block">Week</span>
                          <span class="d-md-none">W</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <!-- Chart -->
                <div class="chart">
                  <!-- Chart wrapper -->
                  <canvas id="chart-sales-dark" class="chart-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                    <h5 class="h3 mb-0">Total orders</h5>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <!-- Chart -->
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas"></canvas>
                </div>
              </div>
            </div>
          </div> --}}
    {{-- <div class="col-xl-6">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="nav-active-border b-primary top box">
                    <div class="nav nav-md">
                        <a class="nav-link active" data-toggle="tab" data-target="#tab1">
                            <i class="fa fa-plus-circle"></i> Member
                        </a>
                         <a class="nav-link" data-toggle="tab" data-target="#tab2" onclick="cdata2()">
                            <i class="fa fa-plus-circle"></i> Research Corner
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab3">
                            <i class="fa fa-plus-circle"></i> Inquiry
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab4">
                            <i class="fa fa-plus-circle"></i> Buying Request
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab5">
                            <i class="fa fa-plus-circle"></i> Event
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab6">
                            <i class="fa fa-plus-circle"></i> Training
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab7">
                            <i class="fa fa-plus-circle"></i> Representative
                        </a>
						<a class="nav-link" data-toggle="tab" data-target="#tab8">
                            <i class="fa fa-plus-circle"></i> Company Incomes
                        </a> 
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content p-3 mb-3">
                        <div class="tab-pane animate fadeIn text-muted active show" id="tab1">
                            <div class="row">
                                <div id="user_year" style="min-width: 100%; height: 400px; margin: 0 auto;"></div>
                                <a id="export_pdf_1" class="btn btn-success"><font color="white"><i
                                                class="fa fa-download"></i> Export PDF</font></a>
                            </div>
                        </div>
                        {{-- <div class="tab-pane animate fadeIn text-muted" id="tab2">
                            <div class="row">
                                <div id="top_downloader"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                            <br><br><br>
                            <div class="row">
                                <div id="top_rc"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                            <a id="export_pdf_2" class="btn btn-success"><font color="white"><i
                                            class="fa fa-download"></i> Export PDF</font></a>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab3">
                            <div class="row">
                                <div id="inquiry"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <div class="row">
                                <div id="top_inquiry"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <a id="export_pdf_3" class="btn btn-success"><font color="white"><i
                                            class="fa fa-download"></i> Export PDF</font></a>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab4">
                            <div class="row">
                                <div id="buying"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <a id="export_pdf_4" class="btn btn-success"><font color="white"><i
                                            class="fa fa-download"></i> Export PDF</font></a>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab5">
                            <div class="row">
                                <div id="event"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <div class="row">
                                <div id="top_event"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <a id="export_pdf_5" class="btn btn-success"><font color="white"><i
                                            class="fa fa-download"></i> Export PDF</font></a>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab6">
                            <div class="row">
                                <div id="training"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <div class="row">
                                <div id="top_training"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <a id="export_pdf_6" class="btn btn-success"><font color="white"><i
                                            class="fa fa-download"></i> Export PDF</font></a>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab7">
						
                            <div class="row">
                                <div id="statistik"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <a id="export_pdf_7" class="btn btn-success"><font color="white"><i
                                            class="fa fa-download"></i> Export PDF</font></a>
                        </div>
						<div class="tab-pane animate fadeIn text-muted" id="tab8">
                            <div class="row">
                                <div id="zeke" style="min-width: 100%; height: 400px; margin: 0 auto;"></div>

                            </div>
                            <a id="export_pdf_8" class="btn btn-success"><font color="white"><i
                                            class="fa fa-download"></i> Export PDF</font></a>
                        </div>
                    </div>

                </div>
            </div>
          </div> --}}
    {{-- <div class="col-xl-6">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="nav-active-border b-primary top box">
                    <div class="nav nav-md">
                        <a class="nav-link" data-toggle="tab" data-target="#tab2" onclick="cdata2()">
                            <i class="fa fa-plus-circle"></i> Research Corner
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content p-3 mb-3">
                        <div class="tab-pane animate fadeIn text-muted active show" id="tab2">
                            <div class="row">
                                <div id="top_downloader"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                            <br><br><br>
                            <div class="row">
                                <div id="top_rc"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                            <a id="export_pdf_2" class="btn btn-success"><font color="white"><i
                                            class="fa fa-download"></i> Export PDF</font></a>
                        </div>
                    </div>

                </div>
            </div>
          </div> --}}
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header border-bottom">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Total Buyer</h3>
                    </div>
                    {{-- <div class="col text-right">
                    <a href="#!" class="btn btn-sm btn-primary">See all</a>
                  </div> --}}
                </div>
            </div>
            {{-- <div id="container">
                    <div class="loading"> <i class="icon-spinner icon-spin icon-large"></i>
                        Loading data from Google Spreadsheets...</div>
                </div> --}}

            <div id="chart-container" style="text-align: center !important;">FusionCharts XT will load here!</div>
        </div>
    </div>
    <div class="col-9">
        <div class="card" style="background-color: #678983;">
            <div class="card-header border-0" style="background-color: #678983;">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0" style="color: #fff;">Open Ticket</h3>
                        {{-- <b>{{ $ticket_open }} Open</b> Ticket
                            <b>{{ $ticket_close }} Close</b> Ticket --}}
                    </div>
                    {{-- <div class="col text-right">
                            <a href="#!" class="btn btn-sm btn-primary">See all</a>
                        </div> --}}
                </div>
            </div>
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-start table-flush">
                    <thead style="background-color: #B5E0D9;">
                        <tr>
                            <th scope="col">Message</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($message as $pesan)
                            <tr>
                                <td scope="row"
                                    style="max-width: 10px overflow-x: hidden; text-align: left !important;">
                                    <label class="font-weight-bold"
                                        style="color: #fff;">{{ $pesan->main_messages }}</label>
                                </td>
                                <td>
                                    <label class="font-weight-bold"
                                        style="color: #fff;">{{ $pesan->created_at }}</label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card border-10" style="height:40%; background-color:#678983">
            <div class="card-header border-0" style="background-color:#678983">
                <div class="col">
                    <h4 style="color:white" class="card-title text-uppercase text-muted mb-0 text-white">Total Open
                        Ticket</h4>
                    <span style="color:white" class="h1 font-weight-bold mb-0">{{ $ticket_open }}</span>
                </div>
            </div>
        </div>
        <div class="card border-10" style="height:40%; background-color:#678983">
            <div class="card-header border-0" style="background-color:#678983">
                <div class="col">
                    <h4 style="color:white" class="card-title text-uppercase text-muted mb-0 text-white">Total Close
                        Ticket</h4>
                    <span style="color:white" class="h1 font-weight-bold mb-0">{{ $ticket_close }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Footer -->

    {{-- </div> --}}
    {{-- <div class="container">
        <div class="row">
            <div class="col-md-12">
                
            </div>
        </div>
    </div> --}}
@include('footer')
&nbsp;
    {{-- HIGHCHART JS --}}
    <script>
        $(function() {
            // Initiate the chart
            // $('#container').highcharts('Map', {
            //     series: [{
            //         mapData: Highcharts.maps['custom/world']
            //     }]
            // });
        });
    </script>

    {{-- FUSION JS --}}
    <script>
        FusionCharts.ready(function() {
            var worldMap = new FusionCharts({
                type: 'maps/worldwithcountries',
                renderAt: 'chart-container',
                width: '1000',
                height: '600',
                dataFormat: 'json',
                dataSource: {
                    "chart": {
                        "caption": "Total Buyer",
                        "theme": "fusion",
                        "formatNumberScale": "0",
                        "chartLeftMargin": "200",
                        "chartTopMargin": "40",
                        "chartRightMargin": "40",
                        "chartBottomMargin": "40",
                        "numberSuffix": ""
                    },
                    "colorrange": {
                        "color": [{
                            "minvalue": "0",
                            "maxvalue": "100",
                            "code": "#D0DFA3",
                            "displayValue": "< 100"
                        }, {
                            "minvalue": "100",
                            "maxvalue": "500",
                            "code": "#B0BF92",
                            "displayValue": "100-500"
                        }, {
                            "minvalue": "500",
                            "maxvalue": "1000",
                            "code": "#91AF64",
                            "displayValue": "500-1"
                        }, {
                            "minvalue": "1000",
                            "maxvalue": "5000",
                            "code": "#A9FF8D",
                            "displayValue": "> 1"
                        }]
                    },
                    "data": [
                        @foreach ($chart_data_country as $data_country)
                            {
                            "id": "{{ $data_country->chart_code }}",
                            "value": "{{ $data_country->total }}"
                            },
                        @endforeach
                    ]
                }
            }).render();
        });
    </script>

    {{-- <script>
        // Prepare random data
        var data = [
            ['DE.SH', 728],
            ['DE.BE', 710],
            ['DE.MV', 963],
            ['DE.HB', 541],
            ['DE.HH', 622],
            ['DE.RP', 866],
            ['DE.SL', 398],
            ['DE.BY', 785],
            ['DE.SN', 223],
            ['DE.ST', 605],
            ['DE.NW', 237],
            ['DE.BW', 157],
            ['DE.HE', 134],
            ['DE.NI', 136],
            ['DE.TH', 704],
            ['DE.', 361]
        ];

        Highcharts.getJSON('https://cdn.jsdelivr.net/gh/highcharts/highcharts@v7.0.0/samples/data/germany.geo.json',
            function(geojson) {

                // Initialize the chart
                Highcharts.mapChart('container', {
                    chart: {
                        map: geojson
                    },

                    title: {
                        text: 'GeoJSON in Highmaps'
                    },

                    mapNavigation: {
                        enabled: true,
                        buttonOptions: {
                            verticalAlign: 'bottom'
                        }
                    },

                    colorAxis: {
                        tickPixelInterval: 100
                    },

                    series: [{
                        data: data,
                        keys: ['code_hasc', 'value'],
                        joinBy: 'code_hasc',
                        name: 'Random data',
                        states: {
                            hover: {
                                color: '#a4edba'
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            format: '{point.properties.postal}'
                        }
                    }]
                });
            });
    </script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            Highcharts.setOptions({
                lang: {
                    drillUpText: '◁ Back to Top'
                }
            });
            user();
            top_downloader();
            inquiry();
            buying();
            event();
            training();
            statistik();
            zeke();
        });

        function zeke() {
            var data = JSON.parse('<?php echo addcslashes(json_encode($zeke), "\"\\"); ?>');
            var defaultTitle = "Most Hight Company Incomes";
            var drilldownTitle = "Most Hight Company Incomes";

            var chart_user = Highcharts.chart('zeke', {
                chart: {
                    type: 'column',
                    events: {
                        drilldown: function(e) {
                            console.log(e);
                            // chart.setTitle({text: drilldownTitle + e.point.name});
                        },
                        drillup: function(e) {
                            // chart.setTitle({text: defaultTitle});
                        }
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data,
                credits: {
                    enabled: false
                },
                title: {
                    text: defaultTitle
                },
                legend: {
                    enabled: true
                },
                tooltip: {
                    valuePrefix: '$ '
                }
            });
            $('#export_pdf_8').click(function() {
                Highcharts.exportCharts([chart_user], {
                    type: 'application/pdf'
                });
            });
        }

        function statistik() {
            var data = JSON.parse('<?php echo addcslashes(json_encode($Statistik), "\"\\"); ?>');
            var defaultTitle = "Most Active Representative";
            var drilldownTitle = "Most Active Representative";

            var chart_user = Highcharts.chart('statistik', {
                chart: {
                    type: 'column',
                    events: {
                        drilldown: function(e) {
                            console.log(e);
                            // chart.setTitle({text: drilldownTitle + e.point.name});
                        },
                        drillup: function(e) {
                            // chart.setTitle({text: defaultTitle});
                        }
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data,
                credits: {
                    enabled: false
                },
                title: {
                    text: defaultTitle
                },
                legend: {
                    enabled: true
                }
            });
            $('#export_pdf_7').click(function() {
                Highcharts.exportCharts([chart_user], {
                    type: 'application/pdf'
                });
            });
        }

        function user() {
            var data = JSON.parse('<?php echo addcslashes(json_encode($User), "\"\\"); ?>');
            var defaultTitle = "Number of Memberships";
            var drilldownTitle = "Number of Memberships";

            var chart_user = Highcharts.chart('user_year', {
                chart: {
                    type: 'column',
                    events: {
                        drilldown: function(e) {
                            console.log(e);
                            // chart.setTitle({text: drilldownTitle + e.point.name});
                        },
                        drillup: function(e) {
                            // chart.setTitle({text: defaultTitle});
                        }
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data[0],
                credits: {
                    enabled: false
                },
                title: {
                    text: defaultTitle
                },
                legend: {
                    enabled: true
                },
                drilldown: {
                    series: data[1]
                }
            });
            $('#export_pdf_1').click(function() {
                Highcharts.exportCharts([chart_user], {
                    type: 'application/pdf'
                });
            });
        }

        function inquiry() {
            var data_year = JSON.parse('<?php echo addcslashes(json_encode($Inquiry), "\"\\"); ?>');
            var data_top = JSON.parse('<?php echo addcslashes(json_encode($Top_Inquiry), "\"\\"); ?>');
            var defaultTitle = "Number of Inquiry";
            var drilldownTitle = "Amount of Inquiry Year ";

            var chart_inquiry_1 = Highcharts.chart('inquiry', {
                chart: {
                    type: 'column',
                    events: {
                        drilldown: function(e) {
                            // chart.setTitle({text: drilldownTitle + e.point.name});
                        },
                        drillup: function(e) {
                            // chart.setTitle({text: defaultTitle});
                        }
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data_year[0],
                credits: {
                    enabled: false
                },
                title: {
                    text: defaultTitle
                },
                legend: {
                    enabled: true
                },
                drilldown: {
                    series: data_year[1]
                }
            });

            var chart_inquiry_2 = Highcharts.chart('top_inquiry', {
                chart: {
                    type: 'column'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data_top,
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Top Users'
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    useHTML: true,
                    headerFormat: '',
                    pointFormat: '<i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  <span style="color:{point.color}">Number of Inquiry : {point.y}x</span><br/>'
                }
            });
            $('#export_pdf_3').click(function() {
                Highcharts.exportCharts([chart_inquiry_1, chart_inquiry_2], {
                    type: 'application/pdf'
                });
            });
        }

        function buying() {
            var data_year = JSON.parse('<?php echo addcslashes(json_encode($Buying), "\"\\"); ?>');
            var defaultTitle = "Number of Buying Request";
            var drilldownTitle = "Amount of Buying Year ";

            var chart_buying = Highcharts.chart('buying', {
                chart: {
                    type: 'column',
                    events: {
                        drilldown: function(e) {
                            // chart.setTitle({text: drilldownTitle + e.point.name});
                        },
                        drillup: function(e) {
                            // chart.setTitle({text: defaultTitle});
                        }
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data_year[0],
                credits: {
                    enabled: false
                },
                title: {
                    text: defaultTitle
                },
                legend: {
                    enabled: true
                },
                drilldown: {
                    series: data_year[1]
                }
            });
            $('#export_pdf_4').click(function() {
                Highcharts.exportCharts([chart_buying], {
                    type: 'application/pdf'
                });
            });
        }

        function event() {
            var data_year = JSON.parse('<?php echo addcslashes(json_encode($Event), "\"\\"); ?>')
            var data_top = JSON.parse('<?php echo addcslashes(json_encode($Top_Event), "\"\\"); ?>')
            var defaultTitle = "Number of Events";
            var drilldownTitle = "Amount of Events Year ";

            var chart_event = Highcharts.chart('event', {
                chart: {
                    type: 'column',
                    events: {
                        drilldown: function(e) {
                            // chart.setTitle({text: drilldownTitle + e.point.name});
                        },
                        drillup: function(e) {
                            // chart.setTitle({text: defaultTitle});
                        }
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data_year[0],
                credits: {
                    enabled: false
                },
                title: {
                    text: defaultTitle
                },
                legend: {
                    enabled: false
                },
                drilldown: {
                    series: data_year[1]
                }
            });
            var chart_event_2 = Highcharts.chart('top_event', {
                chart: {
                    type: 'column'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data_top,
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Most Interest Event'
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    useHTML: true,
                    headerFormat: '',
                    pointFormat: '<i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  <span style="color:{point.color}">Number of Intereted : {point.y}x</span><br/>'
                }
            });
            $('#export_pdf_5').click(function() {
                Highcharts.exportCharts([chart_event, chart_event_2], {
                    type: 'application/pdf'
                });
            });
        }

        function training() {
            var data_year = JSON.parse('<?php echo addcslashes(json_encode($Training), "\"\\"); ?>');
            var data_top = JSON.parse('<?php echo addcslashes(json_encode($Top_Training), "\"\\"); ?>');
            var defaultTitle = "Number of Trainings";
            var drilldownTitle = "Amount of Training Year ";

            var chart_training = Highcharts.chart('training', {
                chart: {
                    type: 'column',
                    events: {
                        drilldown: function(e) {
                            // chart.setTitle({text: drilldownTitle + e.point.name});
                        },
                        drillup: function(e) {
                            // chart.setTitle({text: defaultTitle});
                        }
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data_year[0],
                credits: {
                    enabled: false
                },
                title: {
                    text: defaultTitle
                },
                legend: {
                    enabled: false
                },
                drilldown: {
                    series: data_year[1]
                }
            });
            var chart_training_2 = Highcharts.chart('top_training', {
                chart: {
                    type: 'column'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data_top,
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Most Interest Training'
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    useHTML: true,
                    headerFormat: '',
                    pointFormat: '<i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  <span style="color:{point.color}">Number of Intereted : {point.y}x</span><br/>'
                }
            });
            $('#export_pdf_6').click(function() {
                Highcharts.exportCharts([chart_training, chart_training_2], {
                    type: 'application/pdf'
                });
            });
        }

        function top_downloader() {
            var data_company = JSON.parse('<?php echo addcslashes(json_encode($Top_Company_Download), "\"\\"); ?>');
            var data_rc = JSON.parse('<?php echo addcslashes(json_encode($Top_Downloaded_RC), "\"\\"); ?>');

            var chart_rc_1 = Highcharts.chart('top_downloader', {
                chart: {
                    type: 'column'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data_company,
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Top 5 Company (Market Research)'
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    useHTML: true,
                    headerFormat: '',
                    pointFormat: '<i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  <span style="color:{point.color}">Number of Downloads : {point.y}x</span><br/>'
                }
            });

            var chart_rc_2 = Highcharts.chart('top_rc', {
                chart: {
                    type: 'column'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                series: data_rc,
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Top Reasearch Corner'
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    useHTML: true,
                    headerFormat: '',
                    pointFormat: '<i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  <span style="color:{point.color}">Downloaded : {point.y}x</span><br/>'
                }
            });
            $('#export_pdf_2').click(function() {
                Highcharts.exportCharts([chart_rc_1, chart_rc_2], {
                    type: 'application/pdf'
                });
            });
        }

        // function exp1() {
        //
        //     //send the div to PDF
        //
        //     html2canvas($("#user_year"), { // DIV ID HERE
        //         onrendered: function (canvas) {
        //             var imgData = canvas.toDataURL('image/png');
        //             var doc = new jsPDF('landscape');
        //             doc.addImage(imgData, 'PDF', 10, 10);
        //             doc.save('sample-file.pdf'); //SAVE PDF FILE
        //         }
        //     });
        //
        // }
    </script>
    <script>
        /**
        * Create a global getSVG method that takes an array of charts as an
        * argument
        */
        Highcharts.getSVG = function(charts) {
            var svgArr = [],
                top = 0,
                width = 0;

            Highcharts.each(charts, function(chart) {
                var svg = chart.getSVG(),
                    // Get width/height of SVG for export
                    svgWidth = +svg.match(
                        /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
                    )[1],
                    svgHeight = +svg.match(
                        /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
                    )[1];

                svg = svg.replace(
                    '<svg',
                    '<g transform="translate(' + width + ', 0 )" '
                );
                svg = svg.replace('</svg>', '</g>');

                width += svgWidth;
                top = Math.max(top, svgHeight);

                svgArr.push(svg);
            });

            return '<svg height="' + top + '" width="' + width +
                '" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
                svgArr.join('') + '</svg>';
        };

        /**
        * Create a global exportCharts method that takes an array of charts as an
        * argument, and exporting options as the second argument
        */
        Highcharts.exportCharts = function(charts, options) {

            // Merge the options
            options = Highcharts.merge(Highcharts.getOptions().exporting, options);

            // Post to export server
            Highcharts.post(options.url, {
                filename: options.filename || 'chart',
                type: options.type,
                width: options.width,
                svg: Highcharts.getSVG(charts)
            });
        };
    </script>
@endsection
