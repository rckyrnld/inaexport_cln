@extends('header2')
@section('content')
    <style>
        body {
            font-family: Arial;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff !important;
            border: 1px solid rgba(120, 130, 140, 0.5) !important;
            border-radius: 4px !important;
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
            height: 45px !important;
        }

        .custom-select,
        .custom-file-control,
        .custom-file-control:before,
        select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
            height: 45px !important;
        }

    </style>
    <style>
        .chat {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .chat li {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #B3A9A9;
        }

        .chat li.left .chat-body {
            margin-left: 60px;
        }

        .chat li.right .chat-body {
            margin-right: 10px;
        }


        .chat li .chat-body p {
            margin: 0;
            color: #777777;
        }

        .panel .slidedown .glyphicon,
        .chat .glyphicon {
            margin-right: 5px;
        }

        .panel-body {

            height: 280px;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar {
            width: 10px;
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar-thumb {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #555;
        }

        .loader {
            border: 5px solid #f3f3f3;
            -webkit-animation: spin 1s linear infinite;
            animation: spin 1s linear infinite;
            border-top: 5px solid #555;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 25px;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .img-circle {
            background-color: #FFFFFF;
            margin-bottom: 10px;
            padding: 4px;
            border-radius: 50% !important;
            max-width: 100%;
        }

    </style>
    <div class="padding">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table width="100%">
                            <tr>
                                <td width="50%" valign="top">
                                    <div align="left">

                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                {{-- @if ($cekfile != 0) --}}
                                                @if ($inquiry->type == 'importir')
                                                    @if ($inquiry->status != 3 && $inquiry->status != 4)
                                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                                            data-target="#modalDeal" style="width: 100%; color: white;">Deal
                                                            Inquiry
                                                        </button>
                                                    @endif
                                                @elseif($inquiry->type == "perwakilan" || $inquiry->type == "admin")
                                                    @if ($broadcast->status != 3 && $broadcast->status != 4)
                                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                                            data-target="#modalDeal" style="width: 100%; color: white;">Deal
                                                            Inquiry
                                                        </button>
                                                    @endif
                                                @endif
                                                {{-- @endif --}}
                                            </div>
                                            <div class="col-md-3"></div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h5><b>Details Inquiry</b></h5>
                                            </div>
                                            <div class="col-md-2">

                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <label class="col-md-3"><b>Product Name</b></label>
                                            <div class="col-md-7">
                                                @if ($product != null)
                                                    {{ $product->prodname_en }}
                                                @else
                                                    {{ $inquiry->prodname }}
                                                @endif
                                            </div>
                                        </div><br>
                                        @if ($inquiry->type == 'importir')
                                            @if ($product != null)
                                                <div class="row">
                                                    <label class="col-md-3"><b>Category Product</b></label>
                                                    <div class="col-md-7">
                                                        <?php
                                                        $cat1 = getCategoryName($product->id_csc_product, 'en');
                                                        $cat2 = getCategoryName($product->id_csc_product_level1, 'en');
                                                        $cat3 = getCategoryName($product->id_csc_product_level2, 'en');
                                                        
                                                        if ($cat1 == '-') {
                                                            echo $cat1;
                                                        } else {
                                                            if ($cat2 == '-') {
                                                                echo $cat1;
                                                            } else {
                                                                if ($cat3 == '-') {
                                                                    echo $cat1 . ' > ' . $cat2;
                                                                } else {
                                                                    echo $cat1 . ' > ' . $cat2 . ' > ' . $cat3;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div><br>
                                            @endif
                                        @else
                                            <?php $category = getProductCategoryInquiry($inquiry->id);
                                            if ($category != '') {
                                                if ($category == strip_tags($category)) {
                                                    $category = substr($category, 2);
                                                }
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label><b>Category Product</b></label>
                                                </div>
                                                <div class="col-md-4">
                                                    <span
                                                        style="text-transform: capitalize;">@if ($category == '') - @else <?php echo $category; ?> @endif</span>
                                                </div>
                                            </div><br>
                                        @endif
                                        <div class="row">
                                            <label class="col-md-3"><b>Kind Of Subject</b></label>
                                            <div class="col-md-7">
                                                {{ $inquiry->jenis_perihal_en }}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-md-3"><b>Date</b></label>
                                            <div class="col-md-7">
                                                {{ date('d F Y', strtotime($inquiry->date)) }}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-md-3"><b>Subject</b></label>
                                            <div class="col-md-7">
                                                {{ $inquiry->subyek_en }}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-md-3"><b>Messages</b></label>
                                            <div class="col-md-7">
                                                <?php echo $inquiry->messages_en; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-md-3"><b>File</b></label>
                                            <div class="col-md-7">
                                                @if ($inquiry->file == '')
                                                    <input type="text" class="btn btn-default" value="Dokumen Kosong"
                                                        autocomplete="off" readonly
                                                        style="color: orange; text-align: center;">
                                                @else
                                                    <a href="{{ url('/') . '/uploads/Inquiry/' . $inquiry->id }}/{{ $inquiry->file }}"
                                                        target="_blank" class="btn btn-default"
                                                        style="color: orange;">{{ $inquiry->file }}</a>
                                                @endif
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="col-md-3"><b>Status</b></label>
                                            <div class="col-md-7">
                                                @if ($inquiry->type == 'importir')
                                                    <?php if ($inquiry->status == 0) {
                                                        $stat = 1;
                                                    } else {
                                                        $stat = $inquiry->status;
                                                    } ?>
                                                @elseif($inquiry->type == "perwakilan" || $inquiry->type == "admin")
                                                    <?php if ($broadcast->status == 0) {
                                                        $stat = 1;
                                                    } else {
                                                        $stat = $broadcast->status;
                                                    } ?>
                                                @endif
                                                @lang('inquiry.stat'.$stat)
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!--  <h5><b>Detail Chat</b></h5> -->
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div align="center"><br>
                                                    <div class="row">
                                                    </div>
                                                </div>
                                            </div>
                                </td>
                                <td width="50%" valign="top">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12"
                                                style="background-color: #1a7688;color:white;border-top-left-radius: 13px 13px;border-top-right-radius: 13px 13px;">
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <br>
                                                        <h4 style="color: #fff"><b>Chat</b></h4><br>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <br>
                                                        <!-- <a class="btn btn-info" onclick="rfr()">Refresh</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12"
                                                style="background-color: #def1f1;border-bottom-left-radius: 13px 13px;border-bottom-right-radius: 13px 13px;">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <span class="glyphicon glyphicon-comment"></span>
                                                        <!-- <div class="btn-group pull-right">
                                                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu slidedown">
                                                                                        <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-refresh">
                                                                                        </span>Refresh</a></li>
                                                                                        <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-ok-sign">
                                                                                        </span>Available</a></li>
                                                                                        <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-remove">
                                                                                        </span>Busy</a></li>
                                                                                        <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-time"></span>
                                                                                            Away</a></li>
                                                                                        <li class="divider"></li>
                                                                                        <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-off"></span>
                                                                                            Sign Out</a></li>
                                                                                    </ul>
                                                                                </div> -->
                                                    </div>
                                                    <br>
                                                    <div id="fg1" class="panel-body" style="overflow-y: scroll;">
                                                        <ul class="chat" id="rchat">
                                                            <?php 
                                                        foreach($messages as $msg){
                                                    ?>

                                                            <?php if($msg->sender == $id_user){?>
                                                            <li class="right clearfix"><span class="chat-img pull-right">
                                                                    <img src="https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13"
                                                                        alt="User Avatar" class="img-circle" />
                                                                    <div class="chat-body clearfix pull-right">
                                                                        <div class="header">
                                                                            <strong class=" text-muted"><span
                                                                                    class="pull-right primary-font"></span><b>You</b></strong>
                                                                            <small class="glyphicon glyphicon-time">
                                                                                (<?php
                                                                                $datenya = date('d-m-Y', strtotime($msg->created_at));
                                                                                echo $datenya; ?>)</small>
                                                                        </div>
                                                                        <p>
                                                                            {{ $msg->messages }}
                                                                        </p>
                                                                        <p>
                                                                            <?php if(empty($msg->file)){}else{?>
                                                                            <br><a target="_BLANK"
                                                                                href="{{ url('/') . '/uploads/ChatFileInquiry/' . $msg->id }}/{{ $msg->file }}">
                                                                                <font color="green"><?php echo $msg->file; ?>
                                                                                </font>
                                                                            </a>
                                                                            <?php } ?>
                                                                        </p>
                                                                    </div>
                                                            </li>
                                                            <?php }else{ ?>
                                                            <li class="left clearfix"><span class="chat-img pull-left">
                                                                    <img src="https://place-hold.it/50x50/55C1E7/fff&text=H&fontsize=13"
                                                                        alt="User Avatar" class="img-circle" />
                                                                    <div class="chat-body clearfix">
                                                                        <div class="header">
                                                                            <strong class=" text-muted"><span
                                                                                    class="pull-right primary-font"></span><b>
                                                                                    @if ($inquiry->type == 'importir')
                                                                                        {{ getCompanyNameImportir($msg->sender) }}
                                                                                    @elseif($inquiry->type ==
                                                                                        "perwakilan")
                                                                                        {{ getPerwakilanName($msg->sender) }}
                                                                                    @elseif($inquiry->type == "admin")
                                                                                        {{ getAdminName($msg->sender) }}
                                                                                    @endif
                                                                                </b>
                                                                            </strong>
                                                                            <small class="glyphicon glyphicon-time">
                                                                                (<?php $datenya = date('d-m-Y', strtotime($msg->created_at));
                                                                                echo $datenya; ?>)</small>
                                                                        </div>
                                                                        <p>
                                                                            {{ $msg->messages }}
                                                                        </p>
                                                                        <p>
                                                                            <?php if(empty($msg->file)){}else{?>
                                                                            <br><a target="_BLANK"
                                                                                href="{{ url('/') . '/uploads/ChatFileInquiry/' . $msg->id }}/{{ $msg->file }}">
                                                                                <font color="green"><?php echo $msg->file; ?>
                                                                                </font>
                                                                            </a>
                                                                            <?php } ?>
                                                                        </p>
                                                                    </div>
                                                            </li>
                                                            <?php } ?>


                                                            <?php }  ?>

                                                        </ul>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <div class="input-group">
                                                            <input id="inputan" type="text" class="form-control input-sm"
                                                                placeholder="Type your message here..." />
                                                            <span class="input-group-btn">
                                                                <!--<a  class="btn btn-info" data-toggle="modal" data-target="#myModal2">
                                                                                        <font color="white">  <i class="fa fa-paperclip"></i></font></a> -->

                                                                <a onclick="kirimchat()" class="btn btn-success"
                                                                    id="btn-chat">
                                                                    <font color="white"> <i class="fa fa-paper-plane"></i>
                                                                        Send </font>
                                                                </a>
                                                                <button type="button" class="btn btn-info"
                                                                    data-toggle="modal" data-target="#modalFile"
                                                                    style="border-color: rgba(120, 130, 140, 0.5);">
                                                                    <i class="fa fa-paperclip"></i>
                                                                </button>
                                                                <a class="btn btn-warning" onclick="rfr()"><i
                                                                        class="fa fa-refresh"></i></a>

                                                            </span>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($inquiry->type == 'importir')
                                        @if ($inquiry->status != 4 && $inquiry->status != 5)
                                            <input type="hidden" name="type" id="type" value="{{ $inquiry->type }}">
                                            <input type="hidden" name="id_inquiry" id="id_inquiry"
                                                value="{{ $inquiry->id }}">
                                            <input type="hidden" name="sender" id="sender" value="{{ $id_user }}">
                                            <input type="hidden" name="receiver" id="receiver"
                                                value="{{ $inquiry->id_pembuat }}">


                                        @endif
                                    @elseif($inquiry->type == "perwakilan" || $inquiry->type == "admin")
                                        @if ($broadcast->status != 4 && $broadcast->status != 5)

                                            <input type="hidden" name="type" id="type" value="{{ $inquiry->type }}">
                                            <input type="hidden" name="id_inquiry" id="id_inquiry"
                                                value="{{ $inquiry->id }}">
                                            <input type="hidden" name="sender" id="sender" value="{{ $id_user }}">
                                            <input type="hidden" name="receiver" id="receiver"
                                                value="{{ $inquiry->id_pembuat }}">

                                        @endif
                                    @endif
                                    <br>
                                    <br>
                                    <div align="right">
                                        <a href="{{ url('/inquiry') }}" class="btn btn-danger" style="float: right;"><i
                                                class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                                            Back
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="modalDeal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <center>
                        <h6><b>Are you sure?</b></h6>
                        <br>
                        <a href="{{ url('/inquiry/dealing/' . $inquiry->id . '/1') }}" class="btn btn-primary"
                            style="width: 100px;">Deal</a>&nbsp;OR
                        &nbsp;<a href="{{ url('/inquiry/dealing/' . $inquiry->id . '/2') }}" class="btn btn-danger"
                            style="width: 100px;">Cancel</a>
                    </center>
                    <br><br>
                </div>

                <!-- Modal footer -->
                <!-- <div class="modal-footer">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div> -->

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFile" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#2e899e; color:white;">
                    <h4 class="text-white">Upload File</h4>
                    <button type="button" class="closedmodal text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('eksportir.inquiry.fileChat') }}" method="post" enctype="multipart/form-data"
                    id="uploadform2">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-sm-3">
                                <label><b>File Upload</b></label>
                            </div>
                            <div class="form-group col-sm-7">
                                <input type="hidden" name="sender" id="sender" value="{{ $id_user }}">
                                <input type="hidden" name="id_inquiry" id="id_inquiry" value="{{ $inquiry->id }}">
                                <input type="hidden" name="type" id="type" value="{{ $inquiry->type }}">
                                <input type="hidden" name="receiver" id="receiver" value="{{ $inquiry->id_pembuat }}">
                                <input type="hidden" name="statusmsg" id="statusmsg" value="{{ $inquiry->status }}">
                                <input type="file" id="upload_file" name="upload_file" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-3">
                                <label><b>Note</b></label>
                            </div>
                            <div class="form-group col-sm-7">
                                <textarea class="form-control" name="msgfile2" id="msgfile2" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-submit">
                            <font color="white">Upload</font>
                        </button>
                        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
                        <div class="loader" style="display: none;"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var con = document.getElementById("fg1");
            con.scrollTop = con.scrollHeight;
            $('.select2').select2();
            setInterval(function() {
                a = <?php echo $id; ?>;
                var token = $('meta[name="csrf-token"]').attr('content');
                $.get('{{ URL::to('refreshchatinq3/') }}/' + a, {
                    _token: token
                }, function(data) {
                    $('#rchat').html(data)
                    var con = document.getElementById("fg1");
                    con.scrollTop = con.scrollHeight;
                });
            }, 2000);
        });

        function kirimchat() {

            var sender = $('#sender').val();
            var receiver = $('#receiver').val();
            var id_inquiry = $('#id_inquiry').val();
            var type = $('#type').val();
            var msg = $('#inputan').val();


            $.ajax({
                url: "{{ route('eksportir.inquiry.sendChat') }}",
                type: 'get',
                data: {
                    from: sender,
                    to: receiver,
                    idinquiry: id_inquiry,
                    messages: msg,
                    file: "",
                    typenya: type
                },
                success: function(response) {
                    // console.log(response);
                    if (response == 1) {
                        location.reload();
                    } else {
                        alert("This message is not delivered!");
                        location.reload();
                    }
                }
            });
            $('#rchat').append(
                '<li class="right clearfix"><span class="chat-img pull-right"><img src="https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix pull-right"><div class="header"><strong class=" text-muted"><span class="pull-right primary-font"></span><b>You</b></strong><small class="glyphicon glyphicon-time"> (<?php echo date('Y-m-d H:m:s'); ?>)</small></div><p>' +
                msg + '</p></div></li>');
            $('#inputan').val('');
        }
        $(document).ready(function() {
            var con = document.getElementById("fg1");
            con.scrollTop = con.scrollHeight;
            //Click Image
            // $("#uploading").click(function () {
            //     $("input[id='upload_file']").click();
            // });

            $("#uploading").click(function() {
                // $("input[id='upload_file2']").click();
                $('#modalFile').modal('show');
            });

            // Upload File
            $("#upload_file").on('change', function() {
                if (this.value != "") {
                    $('#uploadform').submit();
                } else {
                    alert('The file cannot be uploaded');
                }
            });

            //Send Message
            $('#messages').keypress(function(event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == '13') {
                    var sender = $('#sender').val();
                    var receiver = $('#receiver').val();
                    var id_inquiry = $('#id_inquiry').val();
                    var type = $('#type').val();
                    var msg = this.value;


                    $.ajax({
                        url: "{{ route('eksportir.inquiry.sendChat') }}",
                        type: 'get',
                        data: {
                            from: sender,
                            to: receiver,
                            idinquiry: id_inquiry,
                            messages: msg,
                            file: "",
                            typenya: type
                        },
                        success: function(response) {
                            // console.log(response);
                            if (response == 1) {
                                location.reload();
                            } else {
                                alert("This message is not delivered!");
                                location.reload();
                            }
                        }
                    });
                }
                event.stopPropagation();
            });

            $("#uploadform2").submit(function(e) {
                $('.btn-submit, .btn-close').hide();
                $('.loader').show();
            });
        })
    </script>

    @include('footer')

@endsection
