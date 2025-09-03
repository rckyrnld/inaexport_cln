@extends('header2')
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
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats position-relative">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total Member (Eks)</h5>
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
                <a href="{{url('chart/total_member')}}" class="stretched-link" style="color:white"> </a>
                    {{-- <p class="mt-3 mb-0 text-sm">
                      <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                      <span class="text-nowrap">Since last month</span>
                    </p> --}}
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total Market Research</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $rc_total }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                            <i class="ni ni-chart-pie-35"></i>
                        </div>
                    </div>
                </div>
                <a href="{{url('chart/total_rc')}}" class="stretched-link" style="color:white">Go somewhere</a>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
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
                <a href="{{url('chart/total_inquiry')}}" class="stretched-link" style="color:white">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
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
                <a href="{{url('chart/total_buying_request')}}" class="stretched-link" style="color:white">Go somewhere</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
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
                <a href="{{url('chart/total_event')}}" class="stretched-link" style="color:white">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
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
                <a href="{{url('chart/total_training')}}" class="stretched-link" style="color:white">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
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
                <a href="{{url('chart/total_rep')}}" class="stretched-link" style="color:white">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
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
                <a href="{{url('chart/total_income')}}" class="stretched-link" style="color:white">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-mb-12">
        <div class="card card-stats">
            <div class="box">
                <div class="box-divider m-0"></div>
                @if(Request::segment(2) == "total_member")
                @include('Dashboard.Admin.chart_member')
                @elseif (Request::segment(2) == "total_rc")
                @include('Dashboard.Admin.chart_rc')
                @elseif (Request::segment(2) == "total_inquiry")
                @include('Dashboard.Admin.chart_inquiry')
                @elseif (Request::segment(2) == "total_buying_request")
                @include('Dashboard.Admin.chart_total_buying_request')
                @elseif (Request::segment(2) == "total_event")
                @include('Dashboard.Admin.chart_event')
                @elseif (Request::segment(2) == "total_training")   
                @include('Dashboard.Admin.chart_training') 
                @elseif (Request::segment(2) == "total_rep")
                @include('Dashboard.Admin.chart_rep')
                @elseif (Request::segment(2) == "total_income")
                @include('Dashboard.Admin.chart_income')
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- <div class="card-stats">
        <div class="card-body">
            <div class="col-md-12">
                <div class="card-body"></div>
                @if(Request::segment(2) == "total_member")
                @include('Dashboard.Admin.chart_member')
                @elseif (Request::segment(2) == "total_rc")
                @include('Dashboard.Admin.chart_rc')
                @elseif (Request::segment(2) == "total_inquiry")
                @include('Dashboard.Admin.chart_inquiry')
                @elseif (Request::segment(2) == "total_buying_request")
                @include('Dashboard.Admin.chart_total_buying_request')
                @elseif (Request::segment(2) == "total_event")
                @include('Dashboard.Admin.chart_event')
                @elseif (Request::segment(2) == "total_training")   
                @include('Dashboard.Admin.chart_training') 
                @elseif (Request::segment(2) == "total_rep")
                @include('Dashboard.Admin.chart_rep')
                @elseif (Request::segment(2) == "total_income")
                @include('Dashboard.Admin.chart_income')
                @endif
            </div>
        </div>
    </div> -->
    <!-- <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12">
                <div class="box">
                    <div class="box-divider m-0"></div>
                    @if(Request::segment(2) == "total_member")
                    @include('Dashboard.Admin.chart_member')
                    @elseif (Request::segment(2) == "total_rc")
                    @include('Dashboard.Admin.chart_rc')
                    @elseif (Request::segment(2) == "total_inquiry")
                    @include('Dashboard.Admin.chart_inquiry')
                    @elseif (Request::segment(2) == "total_buying_request")
                    @include('Dashboard.Admin.chart_total_buying_request')
                    @elseif (Request::segment(2) == "total_event")
                    @include('Dashboard.Admin.chart_event')
                    @elseif (Request::segment(2) == "total_training")   
                    @include('Dashboard.Admin.chart_training') 
                    @elseif (Request::segment(2) == "total_rep")
                    @include('Dashboard.Admin.chart_rep')
                    @elseif (Request::segment(2) == "total_income")
                    @include('Dashboard.Admin.chart_income')
                    @endif
                    
                </div>
            </div>
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

                    </div> --}}
                </div>
            </div>
        </div>
    </div> -->
</div>

{{-- <footer class="footer pt-0">
    <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6">
            <div class="copyright text-center  text-lg-left  text-muted">
            &copy; 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
            </div>
        </div>
        <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
            <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
            </li>
            <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
            </li>
            </ul>
        </div>
    </div>
</footer> --}}
{{-- <div class="container">
    <div class="row">
        <div class="col-md-12">
            
        </div>
    </div>
</div> --}}
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
        var data = JSON.parse('<?php echo addcslashes(json_encode($zeke), '\'\\'); ?>');
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
        var data = JSON.parse('<?php echo addcslashes(json_encode($Statistik), '\'\\'); ?>');
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
        var data = JSON.parse('<?php echo addcslashes(json_encode($User), '\'\\'); ?>');
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
        var data_year = JSON.parse('<?php echo addcslashes(json_encode($Inquiry), '\'\\'); ?>');
        var data_top = JSON.parse('<?php echo addcslashes(json_encode($Top_Inquiry), '\'\\'); ?>');
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
        var data_year = JSON.parse('<?php echo addcslashes(json_encode($Buying), '\'\\'); ?>');
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
        var data_year = JSON.parse('<?php echo addcslashes(json_encode($Event), '\'\\'); ?>')
        var data_top = JSON.parse('<?php echo addcslashes(json_encode($Top_Event), '\'\\'); ?>')
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
        var data_year = JSON.parse('<?php echo addcslashes(json_encode($Training), '\'\\'); ?>');
        var data_top = JSON.parse('<?php echo addcslashes(json_encode($Top_Training), '\'\\'); ?>');
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
        var data_company = JSON.parse('<?php echo addcslashes(json_encode($Top_Company_Download), '\'\\'); ?>');
        var data_rc = JSON.parse('<?php echo addcslashes(json_encode($Top_Downloaded_RC), '\'\\'); ?>');

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


@include('footer')

@endsection