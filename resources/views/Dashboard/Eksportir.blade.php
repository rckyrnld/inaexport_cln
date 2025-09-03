@extends('header2')
@section('content')

<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<link rel="stylesheet" href="{{url('/')}}/css/single_product.css" type="text/css" />
&nbsp;

<style type="text/css">
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
    .highcharts-drilldown-axis-label {
        text-decoration: none !important;
        color: #4c4d61 !important;
        fill: #4c4d61 !important;
    }

    .top_data {
        display: inline-block;
        min-width: 50%;
    }
    #set_admin.nav-link.active, #set_perwakilan.nav-link.active, #set_importir.nav-link.active {
        background-color: #40bad2 !important;
        color: white !important;
    }
</style>
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="nav-active-border b-primary top box">
                    <div class="nav nav-md">
                        <a class="nav-link active" data-toggle="tab" data-target="#tab1" @if($jumlah == 0) onclick="alert('There is no data in this tab')" @endif>
                            <i class="fa fa-plus-circle"></i> Product List
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab2" @if($top_product == null) onclick="alert('There is no data in this tab')" @endif>
                            <i class="fa fa-plus-circle"></i> Top Product
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab3" @if($incomes == null) onclick="alert('There is no data in this tab')" @endif>
                            <i class="fa fa-plus-circle"></i> Incomes
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab4" @if($interest == null) onclick="alert('There is no data in this tab')" @endif>
                            <i class="fa fa-plus-circle"></i> Event & Training
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content p-3 mb-3">
                        <div class="tab-pane animate fadeIn text-muted active show" id="tab1">
                            <div class="row">
                            @if($jumlah != 0)
                                @foreach($product as $key => $data)
                                <?php
                                // Set Category 
                                    $cat1 = getCategoryName($data->id_csc_product, 'en');
                                    $cat2 = getCategoryName($data->id_csc_product_level1, 'en');
                                    $cat3 = getCategoryName($data->id_csc_product_level2, 'en');

                                    if($cat3 == "-"){
                                        if($cat2 == "-"){
                                            $categorynya = $cat1;
                                            $idcategory = $data->id_csc_product;
                                        }else{
                                            $categorynya = $cat2;
                                            $idcategory = $data->id_csc_product_level1;
                                        }
                                    }else{
                                        $categorynya = $cat3;
                                        $idcategory = $data->id_csc_product_level2;
                                    }
                                // Set Image
                                    $img1 = $data->image_1;
                                    if($img1 == NULL){
                                        $isimg1 = '/image/notAvailable.png';
                                    }else{
                                        $image1 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$img1; 
                                        if(file_exists($image1)) {
                                          $isimg1 = '/uploads/Eksportir_Product/Image/'.$data->id.'/'.$img1;
                                        }else {
                                          $isimg1 = '/image/notAvailable.png';
                                        }  
                                    }
                                    $cekImage = explode('.', $img1);
                                    $padImg = '0px';
                                    if($cekImage[(count($cekImage)-1)] == 'png'){
                                        $padImg = '10px 10px 10px 10px';
                                    }
                                // Set Data
                                    $minorder = '-';
                                    $minordernya = '-';
                                    if($data->minimum_order != null){
                                        $minorder = $data->minimum_order;
                                        if(strlen($minorder) > 28){
                                            $cut_desc = substr($minorder, 0, 28);
                                            if ($minorder[28 - 1] != ' ') { 
                                                $new_pos = strrpos($cut_desc, ' '); 
                                                $cut_desc = substr($minorder, 0, $new_pos);
                                            }
                                            $minordernya = $cut_desc . '...';
                                        }else{
                                            $minordernya = $minorder;
                                        }
                                    }
                                    $num_char = 28;
                                    $prodn = getProductAttr($data->id, 'prodname', 'en');
                                    if(strlen($prodn) > $num_char){
                                        $cut_text = substr($prodn, 0, $num_char);
                                        if ($prodn[$num_char - 1] != ' ') { 
                                            $new_pos = strrpos($cut_text, ' '); 
                                            $cut_text = substr($prodn, 0, $new_pos);
                                        }
                                        $prodnama = $cut_text . '...';
                                    }else{
                                        $prodnama = $prodn;
                                    }

                                    $num_chark = 32;
                                    if(strlen($categorynya) > 32){
                                        $cut_text = substr($categorynya, 0, $num_chark);
                                        if ($categorynya[$num_chark - 1] != ' ') { 
                                            $new_pos = strrpos($cut_text, ' '); 
                                            $cut_text = substr($categorynya, 0, $new_pos);
                                        }
                                        $category = $cut_text . '...';
                                    }else{
                                        $category = $categorynya;
                                    }
                                    $param = $data->id_itdp_company_user.'-'.getCompanyName($data->id_itdp_company_user);
                                ?>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="single_product"  style="border: 0px!important;height: 345px; background-color: #fdfdfc; padding: 0px !important;">
                                        <div class="product_thumb" align="center" style="background-color: #e8e8e4; height: 210px; border-radius: 0px 0px 0px 0px; position: relative;">
                                            <a class="primary_img" href="{{url('front_end/product/'.$data->id)}}" onclick="GoToProduct('{{$data->id}}', event, this)" target="_blank"><img src="{{url('/')}}{{$isimg1}}" alt="" style="vertical-align: middle; height: 210px; width:235px;  border-radius: 0px 0px 0px 0px; padding: {{$padImg}}"></a>
                                        </div>
                                        <div class="product_name grid_name" style="padding: 0px 13px 0px 13px;">
                                            <p class="manufacture_product" style="color: #007bff;">
                                                <a href="{{url('front_end/list_product/category/'.$idcategory)}}" title="{{$categorynya}}" class="href-category" target="_blank">{{$category}}</a>
                                            </p>
                                            <h3 style="color: black;">
                                                <a href="{{url('front_end/product/'.$data->id)}}" title="{{$prodn}}" class="href-name" onclick="GoToProduct('{{$data->id}}', event, this)" target="_blank"><b>{{$prodnama}}</b></a>
                                            </h3>
                                            <span style="font-size: 12px; font-family: 'Open Sans', sans-serif; ">
                                                @if(is_numeric($data->price_usd))
                                                    <?php 
                                                        $pricenya = "$ ".number_format($data->price_usd,0,",",".");
                                                        $price = $pricenya;
                                                    ?>
                                                @else
                                                    <?php 
                                                        $price = $data->price_usd;
                                                        if(strlen($price) > 30){
                                                            $cut_text = substr($price, 0, 30);
                                                            if ($price[30 - 1] != ' ') { 
                                                                $new_pos = strrpos($cut_text, ' ');
                                                                $cut_text = substr($price, 0, $new_pos);
                                                            }
                                                            $pricenya = $cut_text . '...';
                                                        }else{
                                                            $pricenya = $price;
                                                        }
                                                    ?>
                                                @endif
                                                <span style="color: #fd5018;" title="{{$price}}">
                                                    {{$pricenya}}
                                                </span>
                                                <br>

                                                <span style="color: black;">Min Order: <span title="{{$minorder}}">{{$minordernya}}</span></span><br>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="justify-content-center">
                                    <h3>No Data</h3>
                                </div>
                            @endif
                            </div>
                            <br>
                            @if($jumlah > 8)
                                <div class="row justify-content-center">
                                    <div class="pagination">
                                        {{ $product->links('vendor.pagination.bootstrap-4') }}
                                        {{ $product->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab2">
                            @if($top_product != null)
                            <div class="row">
                                <div id="product" style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                            <br>
                            <a id="export_pdf_1" class="btn btn-success"><font color="white"><i class="fa fa-download"></i> Export PDF</font></a>
                            @else
                            <div class="row justify-content-center">
                                <h3>No Data</h3>
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab3">
                            @if($incomes != null)
                            <div class="row">
                                <div id="incomes" style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                            <br>
                            <a id="export_pdf_2" class="btn btn-success"><font color="white"><i class="fa fa-download"></i> Export PDF</font></a>
                            @else
                            <div class="row justify-content-center">
                                <h3>No Data</h3>
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab4">
                            @if($interest != null)
                            <div class="row">
                                <div id="interest" style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                            <br>
                            <a id="export_pdf_3" class="btn btn-success"><font color="white"><i class="fa fa-download"></i> Export PDF</font></a>
                            @else
                            <div class="row justify-content-center">
                                <h3>No Data</h3>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
&nbsp;

<script type="text/javascript">

    $(document).ready(function () {
        $('#table').dataTable({
            columnDefs: [
              { orderable: false, targets: [4] }
            ]
        });
        Highcharts.setOptions({
            lang: {
                drillUpText: '◁ Back to Top'
            }
        });

        @if($top_product != null)
        product();
        @endif
        @if($incomes != null)
        incomes();
        @endif
        @if($interest != null)        
        interest();
        @endif
    });

    @if($top_product != null)
    function product() {
        var data = JSON.parse('<?php echo addcslashes(json_encode($top_product), '\'\\'); ?>');
        var defaultTitle = "Best-Selling Product";
        var drilldownTitle = "Best-Selling Product";

        var chart_user = Highcharts.chart('product', {
            chart: {
                type: 'column',
                events: {
                    drilldown: function (e) {
                        // chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
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
                enabled: false
            }
        });
        $('#export_pdf_1').click(function() {
          Highcharts.exportCharts([chart_user], {
            type: 'application/pdf'
          });
        });
    }
    @endif

    @if($incomes != null)
    function incomes() {
        var data = JSON.parse('<?php echo addcslashes(json_encode($incomes), '\'\\'); ?>');
        var defaultTitle = "Total Incomes";
        var drilldownTitle = "Total Incomes";

        var chart_user = Highcharts.chart('incomes', {
            chart: {
                type: 'line',
                events: {
                    drilldown: function (e) {
                        // chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
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
        $('#export_pdf_2').click(function() {
          Highcharts.exportCharts([chart_user], {
            type: 'application/pdf'
          });
        });
    }
    @endif

    @if($interest != null)
    function interest() {
        var data = JSON.parse('<?php echo addcslashes(json_encode($interest), '\'\\'); ?>');
        var defaultTitle = "Total Interest";
        var drilldownTitle = "Total Interest";

        var chart_user = Highcharts.chart('interest', {
            chart: {
                type: 'column',
                events: {
                    drilldown: function (e) {
                        // chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
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
        $('#export_pdf_3').click(function() {
          Highcharts.exportCharts([chart_user], {
            type: 'application/pdf'
          });
        });
    }
    @endif
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
        '<g transform="translate('+width+', 0 )" '
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