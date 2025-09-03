@include('frontend.layouts.header_table')
<style type="text/css">
    .chat-container {
        width: 100%;
        background-color: white;
        border-radius: 30px;
    }

    .chat-header {
        width: 100%;
        height: 5%;
        background-color: #1a7688;
        border-radius: 30px 30px 0px 0px;
        padding: 2% 2% 2% 3%;

    }

    .chat-user {
        font-size: 15px;
        font-family: 'Verdana';
    }

    .chat-body {
        height: 375px;
        max-height: 500px;
        overflow-y: scroll;
        overflow-x: hidden;
        padding: 2%;
        font-size: 15px;
        background-color: #c9d3de;
    }

    .chat-footer {
        width: 100%;
        height: 5%;
        border-top: 2px solid #87c4ee;
        border-radius: 0px 0px 30px 30px;
        padding: 1% 1% 1% 1%;
        background-color: #c9d3de;
    }

    .chat-message {
        border: 1.5px solid #4088C6;
        height: 100%;
        width: 100%;
        border-radius: 10px;
        resize: none;
        padding: 1%;
        font-size: 15px;
    }

    .chat-me {
        background: #64abe4;
        border-radius: 10px 0px 10px 10px;
        width: 400px;
        padding: 10px;
        color: black;
    }

    .chat-other {
        background: #DDEFFD;
        border-radius: 0px 10px 10px 10px;
        width: 400px;
        padding: 10px;
        color: black;
    }

    #uploading2 {
        cursor: pointer;
        transition: 0.3s;
    }

    #uploading2:hover {
        opacity: 0.7;
    }

    #sendmessage {
        cursor: pointer;
        transition: 0.3s;
    }

    #sendmessage:hover {
        opacity: 0.7;
    }

    .chat-back:hover {
        opacity: 0.7;
    }

    button.closedmodal {
        padding: 0;
        background-color: transparent;
        border: 0;
        -webkit-appearance: none;
    }

    .closedmodal {
        float: right;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
    }

    .modal-header .closedmodal {
        padding: 1rem;
        margin: -1rem -1rem -1rem auto;
    }

    .closedmodal:hover {
        color: #fff;
    }

</style>
<?php
$loc = app()->getLocale();
?>
<!--product details start  background-color: #1A70BB;  -->
<div class="product_details mt-20" style="margin-bottom: 0px !important; margin-top: 0px; font-size: 14px;">
    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="chat-container">
                    <div class="chat-header">
                        <div class="row">
                            <div class="col-md-1">
                                <br>
                                <a href="{{ url('/front_end/history') }}" style="width: 100%; height: 100%;"
                                    class="chat-back">
                                    <i class="fa fa-arrow-left" aria-hidden="true"
                                        style="color: #1A70BB; font-size: 40px;"></i>
                                </a>
                            </div>
                            <!-- <div class="col-md-1" style="padding-left: 0px;">
                          <img src="{{ asset('front/assets/icon/user.png') }}" alt="" width="100%" />
                        </div> -->
                            <div class="col-md-4" style="padding-left: 0px;">
                                <span class="chat-user" style=""><b>
                                        <font color="white">Chat</font>
                                    </b></span>
                                <br>
                                <span class="chat-user" style="text-transform: capitalize;"><b>
                                        <font color="white">{{ getCompanyName($data->id_itdp_company_user) }}</font>
                                    </b>&nbsp;&nbsp;<img src="{{ asset('front/assets/icon/icon-exportir.png') }}"
                                        alt="" /></span>
                                <br>

                                <?php $ry = $data->id_itdp_company_user; ?>
                                @if (Cache::has('user-is-eksmp-' . $ry))
                                    <span class="text-success">
                                        <font color="white">Online</font>
                                    </span>
                                @else
                                    <span class="text-secondary">
                                        <font color="white">Offline</font>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="chat-body" id="fg1" style="color:black!important;">
                        <div class="row" id="rchat">
                            <?php
                            $datenya = null;
                            ?>
                            @foreach ($messages as $msg)
                                @if ($msg->sender == $id_user)
                                    <div class="col-md-12">
                                        @if ($datenya == null)
                                            <?php
                                            $datenya = date('d-m-Y', strtotime($msg->created_at));
                                            $pecah = explode('-', $datenya);
                                            $hari = $pecah[0];
                                            if ($pecah[1] == 1) {
                                                $bulan = 'Januari';
                                            } elseif ($pecah[1] == 2) {
                                                $bulan = 'Februari';
                                            } elseif ($pecah[1] == 3) {
                                                $bulan = 'Maret';
                                            } elseif ($pecah[1] == 4) {
                                                $bulan = 'April';
                                            } elseif ($pecah[1] == 5) {
                                                $bulan = 'Mei';
                                            } elseif ($pecah[1] == 6) {
                                                $bulan = 'Juni';
                                            } elseif ($pecah[1] == 7) {
                                                $bulan = 'Juli';
                                            } elseif ($pecah[1] == 8) {
                                                $bulan = 'Agustus';
                                            } elseif ($pecah[1] == 9) {
                                                $bulan = 'September';
                                            } elseif ($pecah[1] == 10) {
                                                $bulan = 'Oktober';
                                            } elseif ($pecah[1] == 11) {
                                                $bulan = 'November';
                                            } elseif ($pecah[1] == 12) {
                                                $bulan = 'Desember';
                                            } else {
                                                $bulan = '';
                                            }
                                            $thnn = $pecah[2];
                                            $fix = $bulan . ' ' . $hari . ',' . $thnn;
                                            ?>
                                            <center>
                                                <i>
                                                    {{ $fix }}
                                                </i>
                                            </center><br>
                                        @else
                                            @if ($datenya != date('d-m-Y', strtotime($msg->created_at)))
                                                <?php
                                                $datenya = date('d-m-Y', strtotime($msg->created_at));
                                                $pecah = explode('-', $datenya);
                                                $hari = $pecah[0];
                                                if ($pecah[1] == 1) {
                                                    $bulan = 'Januari';
                                                } elseif ($pecah[1] == 2) {
                                                    $bulan = 'Februari';
                                                } elseif ($pecah[1] == 3) {
                                                    $bulan = 'Maret';
                                                } elseif ($pecah[1] == 4) {
                                                    $bulan = 'April';
                                                } elseif ($pecah[1] == 5) {
                                                    $bulan = 'Mei';
                                                } elseif ($pecah[1] == 6) {
                                                    $bulan = 'Juni';
                                                } elseif ($pecah[1] == 7) {
                                                    $bulan = 'Juli';
                                                } elseif ($pecah[1] == 8) {
                                                    $bulan = 'Agustus';
                                                } elseif ($pecah[1] == 9) {
                                                    $bulan = 'September';
                                                } elseif ($pecah[1] == 10) {
                                                    $bulan = 'Oktober';
                                                } elseif ($pecah[1] == 11) {
                                                    $bulan = 'November';
                                                } elseif ($pecah[1] == 12) {
                                                    $bulan = 'Desember';
                                                } else {
                                                    $bulan = '';
                                                }
                                                $thnn = $pecah[2];
                                                $fix = $bulan . ' ' . $hari . ',' . $thnn;
                                                ?>
                                                <center>
                                                    <i>
                                                        {{ $fix }}
                                                    </i>
                                                </center><br>
                                            @endif
                                        @endif
                                        <div class="row pull-right">
                                            <div class="col-md-10">
                                                <label class="label chat-me">
                                                    @if ($msg->file == null)
                                                        {{ $msg->messages }}<br>
                                                    @else
                                                        <a href="{{ url('/') . '/uploads/ChatFileInquiry/' . $msg->id }}/{{ $msg->file }}"
                                                            target="_blank" class="atag"
                                                            style="color: green;">{{ $msg->file }}</a><br><br>
                                                        {{ $msg->messages }}<br>
                                                    @endif
                                                    <span
                                                        style="float: right;">{{ date('H:i', strtotime($msg->created_at)) }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div><br>
                                @else
                                    <!-- <div class="col-md-1"></div> -->
                                    <div class="col-md-12">
                                        @if ($datenya == null)
                                            <?php
                                            $datenya = date('d-m-Y', strtotime($msg->created_at));
                                            $pecah = explode('-', $datenya);
                                            $hari = $pecah[0];
                                            if ($pecah[1] == 1) {
                                                $bulan = 'Januari';
                                            } elseif ($pecah[1] == 2) {
                                                $bulan = 'Februari';
                                            } elseif ($pecah[1] == 3) {
                                                $bulan = 'Maret';
                                            } elseif ($pecah[1] == 4) {
                                                $bulan = 'April';
                                            } elseif ($pecah[1] == 5) {
                                                $bulan = 'Mei';
                                            } elseif ($pecah[1] == 6) {
                                                $bulan = 'Juni';
                                            } elseif ($pecah[1] == 7) {
                                                $bulan = 'Juli';
                                            } elseif ($pecah[1] == 8) {
                                                $bulan = 'Agustus';
                                            } elseif ($pecah[1] == 9) {
                                                $bulan = 'September';
                                            } elseif ($pecah[1] == 10) {
                                                $bulan = 'Oktober';
                                            } elseif ($pecah[1] == 11) {
                                                $bulan = 'November';
                                            } elseif ($pecah[1] == 12) {
                                                $bulan = 'Desember';
                                            } else {
                                                $bulan = '';
                                            }
                                            $thnn = $pecah[2];
                                            $fix = $bulan . ' ' . $hari . ',' . $thnn;
                                            
                                            ?>
                                            <center>
                                                <i>
                                                    {{ $fix }}
                                                </i>
                                            </center><br>
                                        @else
                                            @if ($datenya != date('d-m-Y', strtotime($msg->created_at)))
                                                <?php
                                                $datenya = date('d-m-Y', strtotime($msg->created_at));
                                                $pecah = explode('-', $datenya);
                                                $hari = $pecah[0];
                                                if ($pecah[1] == 1) {
                                                    $bulan = 'Januari';
                                                } elseif ($pecah[1] == 2) {
                                                    $bulan = 'Februari';
                                                } elseif ($pecah[1] == 3) {
                                                    $bulan = 'Maret';
                                                } elseif ($pecah[1] == 4) {
                                                    $bulan = 'April';
                                                } elseif ($pecah[1] == 5) {
                                                    $bulan = 'Mei';
                                                } elseif ($pecah[1] == 6) {
                                                    $bulan = 'Juni';
                                                } elseif ($pecah[1] == 7) {
                                                    $bulan = 'Juli';
                                                } elseif ($pecah[1] == 8) {
                                                    $bulan = 'Agustus';
                                                } elseif ($pecah[1] == 9) {
                                                    $bulan = 'September';
                                                } elseif ($pecah[1] == 10) {
                                                    $bulan = 'Oktober';
                                                } elseif ($pecah[1] == 11) {
                                                    $bulan = 'November';
                                                } elseif ($pecah[1] == 12) {
                                                    $bulan = 'Desember';
                                                } else {
                                                    $bulan = '';
                                                }
                                                $thnn = $pecah[2];
                                                $fix = $bulan . ' ' . $hari . ',' . $thnn;
                                                ?>
                                                <center>
                                                    <i>
                                                        {{ $fix }}
                                                    </i>
                                                </center><br>
                                            @endif
                                        @endif
                                        <div class="row">
                                            <div class="col-md-10">
                                                <label class="label chat-other">
                                                    @if ($msg->file == null)
                                                        {{ $msg->messages }}<br>
                                                    @else
                                                        <a href="{{ url('/') . '/uploads/ChatFileInquiry/' . $msg->id }}/{{ $msg->file }}"
                                                            target="_blank" class="atag"
                                                            style="color: green;">{{ $msg->file }}</a><br><br>
                                                        {{ $msg->messages }}<br>
                                                    @endif
                                                    <span
                                                        style="color: #555; float: right;">{{ date('H:i', strtotime($msg->created_at)) }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div><br>
                                    <!-- <div class="col-md-1"></div> -->
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="chat-footer">
                        <div class="row">
                            <div class="col-md-1">
                                <a class="" data-toggle="modal" data-target="#modalInvoice"><img
                                        src="{{ asset('front/assets/icon/plus-circle.png') }}" alt="" width="100%"
                                        id="uploading2" /></a>
                                <!-- <input type="file" id="upload_file2" name="upload_file2" style="display: none;" /> -->
                                <!-- <input type="hidden" name="sender2" id="sender2" value="{{ $id_user }}">
                            <input type="hidden" name="id_inquiry2" id="id_inquiry2" value="{{ $inquiry->id }}">
                            <input type="hidden" name="type2" id="type2" value="{{ $inquiry->type }}">
                            <input type="hidden" name="receiver2" id="receiver2" value="{{ $data->id_itdp_company_user }}">
                            <input type="hidden" name="statusmsg2" id="statusmsg2" value="{{ $inquiry->status }}"> -->
                                </form>
                            </div>
                            <div class="col-md-10" style="padding-left: 0px;">
                                <textarea id="messages2" name="messages2" rows="2" class="chat-message"></textarea>
                            </div>
                            <div class="col-md-1" style="padding-left: 0px;">
                                <a onclick="kirimpesan()"><img src="{{ asset('front/assets/icon/send-message.png') }}"
                                        alt="" width="70%" id="sendmessagessss" /></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>
</div>
<!--product details end-->

<!-- Modal Invoice -->
<div class="modal fade" id="modalInvoice" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2e899e; color:white;">
                <h6>Upload Proof of Payment</h6>
                <button type="button" class="closedmodal" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('front.inquiry.fileChat') }}" method="post" enctype="multipart/form-data"
                id="uploadform2">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label><b>File Upload</b></label>
                        </div>
                        <div class="form-group col-sm-7">
                            <input type="hidden" name="sender2" id="sender2" value="{{ $id_user }}">
                            <input type="hidden" name="id_inquiry2" id="id_inquiry2" value="{{ $inquiry->id }}">
                            <input type="hidden" name="type2" id="type2" value="{{ $inquiry->type }}">
                            <input type="hidden" name="receiver2" id="receiver2"
                                value="{{ $data->id_itdp_company_user }}">
                            <input type="hidden" name="statusmsg2" id="statusmsg2" value="{{ $inquiry->status }}">
                            <input type="file" id="upload_file2" name="upload_file2">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label><b>Note</b></label>
                        </div>
                        <div class="form-group col-sm-7">
                            <textarea class="form-control" name="msgfile2" id="msgfile2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <font color="white">Upload</font>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
if ($loc == 'ch') {
    $alertimage = '抱歉，无法发送此文件。';
    $alertmsg = '抱歉，无法发送此消息。';
} elseif ($loc == 'in') {
    $alertimage = 'Maaf, Dokumen ini tidak dapat dikirim.';
    $alertmsg = 'Maaf, Pesan ini tidak dapat dikirim.';
} else {
    $alertimage = 'Sorry, this document cannot be sent.';
    $alertmsg = 'Sorry, this message cannot be sent.';
}
?>

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function() {
        var con = document.getElementById("fg1");
        con.scrollTop = con.scrollHeight;
        $('.select2').select2();
        setInterval(function() {

            var token = $('meta[name="csrf-token"]').attr('content');
            x = $('#id_inquiry2').val();
            $.get('{{ URL::to('refreshchatnj/') }}/' + x, {
                _token: token
            }, function(data) {
                $('#rchat').html(data);
                var con = document.getElementById("fg1");
                con.scrollTop = con.scrollHeight;
            });
        }, 2000);
    });

    function kirimpesan() {
        var sender = $('#sender2').val();
        var receiver = $('#receiver2').val();
        var id_inquiry = $('#id_inquiry2').val();
        //alert(id_inquiry)
        var type = $('#type2').val();
        var msg = $('textarea#messages2').val();
        var status = $('#statusmsg2').val();
        var token = $('meta[name="csrf-token"]').attr('content');

        // if(status == 3 || status == 4 || status == 5){
        if (status == 4 || status == 5) {
            alert("{{ $alertmsg }}");
            $('textarea#messages2').val("");
        } else {
            $.ajax({
                url: "{{ route('front.inquiry.sendChat') }}",
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
                    if (response == 1) {
                        // location.reload();
                    } else {
                        // alert("This message is not delivered!");
                        // location.reload();
                    }
                }
            });
        }
        x = id_inquiry;
        $.get('{{ URL::to('refreshchatnj/') }}/' + x, {
            _token: token
        }, function(data) {
            $('#rchat').html(data);
            $('#messages2').val('');
        });

    }
</script>
