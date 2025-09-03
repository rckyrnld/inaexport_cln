@include('frontend.layouts.header')
<style type="text/css">
    input[type="text"], input[type="text"]:focus {
        border-color: #d6d9daad;
    }
</style>
<?php
$loc = app()->getLocale();
?>

<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.html">@lang("frontend.proddetail.home")</a></li>
                            <li>@lang("frontend.tracking.goods")</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--breadcrumbs area end-->

<!-- Error Start -->
<div id="error_message" class="product_d_info" style="background-color: #dcecf5; margin-bottom: 0px; display: none;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <center>
                    <h3><b><span style="color: #7f7f7f;"><div id="status_error"></div></span></b></h3>
                </center>
            </div>
        </div>
    </div>
</div>
<!-- Error End -->

<!-- Search Tracking start-->
<div class="product_d_info" style="background-color: #ddeffd; margin-bottom: 0px; padding-bottom: 6%;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
            <center>
                <div class="col-lg-8 col-md-8">
                <h4><b>@lang("frontend.tracking.goods")</b></h4><br>
                    <table width="100%" border="0" cellpadding="5">
                        <tr>
                            <th>@lang("frontend.tracking.kurir")</th>
                            <td>
                                <select class="form-control" name="type" id="type" data-toggle="tooltip"
                                        data-trigger="manual" title="Please Select Tracking First">
                                    <option value="" style="display: none;">@lang("frontend.tracking.select")</option>
                                    @foreach($kurir as $val)
                                        <option value="{{$val->api}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>@lang("frontend.tracking.number")</th>
                            <td><input type="text" autocomplete="true" name="number" id="number" class="form-control"
                                       data-toggle="tooltip" data-trigger="manual" title="Please Input Number"></td>
                            <td style="text-align: center; ">
                                <button type="submit" class="btn btn-info" style="font-size: 12px; width: 100%; font-weight: bold;" onclick="track()"><i class="fa fa-search"></i>&nbsp;&nbsp;@lang("button-name.search")</button>
                            </td>
                        </tr>
                    </table>
                    <div id="loading" style="padding-top: 3%"></div>
                </div>
            </center>
            </div>
        </div>
    </div>
</div>
<!-- Search Tracking end-->

<div id="tracking" style="display: none;">
<!-- Result Tracking start-->
<div class="product_d_info" style="background-color: #dcecf5; margin-top: 0px;margin-bottom: 0px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <center>
                    <h2><b><span id="color_status_event" style="color: #20af0f;"><div id="status_event"></div></span></b></h2>
                    <h5><div id="time_last_event"></div></h5>
                    <div id="delivered" style="font-size: 16px; display: none;">
                        <br>
                        <b>DELIVERED</b><p>
                        <span style="font-size: 15px">Signed for by : <span id="signed"></span></span>
                    </div><br>
                    <table width="30%" style="text-align: center; font-size: 15px">
                        <tr>
                            <td width="40%" style="font-weight: bold;">FROM</td>
                            <td rowspan="2" width="20%"><img src="{{asset('front/assets/icon/tracking_plane.png')}}"></td>
                            <td width="40%" style="font-weight: bold;">TO</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;color: grey;"><div id="origin"></div></td>
                            <td style="vertical-align: top;color: grey;"><div id="destinasi"></div></td>
                        </tr>
                    </table>
                </center>
            </div>
        </div>
    </div>
</div>
<!-- Result Tracking end-->

<!-- Histori Tracking start-->
<div id="histori" class="product_d_info" style="background-color: #ddeffd; margin-top: 0px; margin-bottom: 0px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-10 col-md-10">
                <h5>
                    <b>Travel Histori</b>
                </h5>
                <br>
                <table width="100%" class="table table-borderless table-striped" style="color: white">
                    <thead>
                        <tr class="bg-info">
                            <td style="text-align: center;" width="22%">Date</td>
                            <td style="text-align: center;" width="48%" colspan="2">Activity</td>
                            <td style="text-align: center;" width="30%">Location</td>
                        </tr>
                    </thead>
                    <tbody style="background-color: #bedeef; color: black" id="tbody_tracking"></tbody>
                </table>
            </div>
            <div class="col-lg-1 col-md-1"></div>
        </div>
    </div>
</div>
<!-- Histori Tracking end-->
</div>

<div style="margin-bottom: 8%; margin-top: 0px"></div>

@include('frontend.layouts.footer')
<script type="text/javascript">
    var list_status = {
        'pending': 'Pending',
        'transit': 'Transit',
        'pickup': 'Pickup',
        'delivered': 'Delivered',
        'undelivered': 'Undelivered',
        'notfound': '',
        'exception': '',
        'expired': 'Expired'
    };

    var sub_status_nf = {
        'notfound001': 'Information Received',
        'notfound002': 'Not Found'
    };

    var sub_status_ex = {
        'exception001': 'Exception',
        'exception002': 'Information Received',
        'exception003': 'Information Received',
        'exception004': 'The Package is Unclaimed',
        'exception005': 'The Package was Sent Back to the Sender',
        'exception006': 'The Package is Retained by Customs',
        'exception007': 'The Package is Damaged',
        'exception008': 'The Package is Canceled'
    }

    function color(param){
        switch(param){
            case 'delivered':
                return '#20af0f';
                break;
            case 'exception':
                return '#daca08';
                break;
            case 'notfound':
                return '#84837f';
                break;
            default :
                return '#2c9ada';
        }
    }

    function track() {
        if ($('#type').val() == '') {
            $('#type').tooltip('toggle');
            setTimeout(function () {
                $('#type').tooltip('toggle');
            }, 1000);

        } else if ($('#number').val() == '') {
            $('#number').tooltip('toggle');
            setTimeout(function () {
                $('#number').tooltip('toggle');
            }, 1000);

        } else {
            $('.histori').remove();
            var type = $('#type').val();
            var api = type.split('|');

            var number = $('#number').val();
            $('#tracking').hide();
            $('#error_message').hide();
            $('#loading').show();
            $('#loading').html('<div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div>');
            $('.progress-bar').animate({width: "50%"}, 100);

            $.ajax({
                url: "{{route('api.tracking')}}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": type,
                    "number": number
                },
                dataType: 'json',
                statusCode: {
                    500: function () {
                        end_loading();
                        $('#status_error').html('Server Busy! Please Try Again.');
                        $('#error_message').show('slow');
                    },
                    200: function (response) {
                        end_loading();
                        // console.log(response.data.items[0].status);
                        switch (response.meta.code) {
                            case 200:
                                var histori = '';
                                var status = response.data.status;
                                var sub_status = response.data.substatus;
                                var signed = response.data.singed_by;
                                var origin = response.data.original_country;
                                var destinasi = response.data.destination_country;
                                var track = response.data.origin_info.trackinfo;

                                var last_time = new Date(response.data.lastUpdateTime);
                                var options = { weekday: 'long', year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' };
                                last_time = last_time.toLocaleDateString("en-US", options);
                                last_time = last_time.split(',');

                                $('#color_status_event').css({'color': color(status)});

                                if (origin == null || typeof origin === 'undefined' || origin.length == 0) {
                                    $('#origin').html('Unknown');
                                } else {
                                    $('#origin').html(origin);
                                }

                                if (destinasi == null || typeof destinasi === 'undefined' || destinasi.length == 0) {
                                    $('#destinasi').html('Unknown');
                                } else {
                                    $('#destinasi').html(destinasi);
                                }

                                if (sub_status == null || sub_status == '') {
                                    var message = list_status[status];
                                } else {
                                    if (status == 'notfound') {
                                        var message = sub_status_nf[sub_status];
                                    } else {
                                        var message = sub_status_ex[sub_status];
                                    }
                                }
                                    
                                $('#status_event').html(message);
                                if(last_time[0] == "Invalid Date"){
                                    $('#time_last_event').hide();
                                } else {
                                    $('#time_last_event').show();
                                    $('#time_last_event').html(last_time[0]+last_time[1]+' at'+last_time[2]);
                                }

                                if(status == 'delivered' && signed != null ){
                                    $('#signed').html(signed);
                                    $('#delivered').show();
                                } else {
                                    $('#delivered').hide();
                                }

                                if (track !== null) {
                                    var tanggal = '';
                                    var output_tgl = '';
                                    for (var i = 0; i < track.length; i++) {    
                                        var waktu = new Date(track[i].Date);
                                        waktu = waktu.toLocaleDateString("en-US", options);
                                        waktu = waktu.split(', ');
                                        if(tanggal == waktu[1]){
                                            output_tgl = '';
                                        } else {
                                            output_tgl = waktu[0]+', '+waktu[1];
                                        }
                                        histori += '<tr class="histori"><td>'+ output_tgl +'</td><td width="10%">'+ waktu[2] +'</td><td>'+ track[i].StatusDescription +'</td><td>'+ track[i].Details +'</td></tr>';
                                        tanggal = waktu[1];
                                    }
                                    $('#histori').show();
                                } else {
                                    $('#histori').hide();
                                }

                                $('#tbody_tracking').append(histori);
                                $('#tracking').show('slow');
                                break;
                            case 4014:
                                $('#status_error').html('Tracking Number is Invalid');
                                $('#error_message').show('slow');
                                break;
                            case 429:
                                $('#status_error').html('Exceeded API limits.');
                                $('#error_message').show('slow');
                                break;
                            case 4031:
                                $('#status_error').html('Purchase not found or Delivery not done yet !');
                                $('#error_message').show('slow');
                                break;
                            default:
                                $('#status_error').html('Unknown Error !');
                                $('#error_message').show('slow');
                        }
                    }
                }
            });
        }
    }

    function end_loading() {
        $('.progress-bar').animate({width: "100%"}, 100);
        setTimeout(function () {
            $('.progress-bar').css({width: "100%"});
            setTimeout(function () {
                $('.my-box').html();
            }, 100);
            $('#loading').hide();
        }, 500);
    }

</script>