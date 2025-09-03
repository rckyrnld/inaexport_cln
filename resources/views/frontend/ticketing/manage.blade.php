@include('frontend.layouts.header')

<style type="text/css">
    .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: show;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Remove Arrow flatpickr */
    .flatpickr-prev-month {
        display: none;
    }

    .flatpickr-next-month {
        display: none;
    }

    /* Transparent Overlay */
    .loading:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));

        background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
        /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

</style>

<div class="loading" id="loader" style="display:none;">Loading&#8230;</div>

<!--breadcrumbs area start-->
<div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-5">
                <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                    <ul>
                        <li><a href="#">@lang('frontend.history.ticket')</a></li>
                        <li>@lang('frontend.ticket_title')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<link rel="stylesheet" href="{{ url('assets') }}/style.css" type="text/css" />
<!--product details start-->
<div class="product_details mt-20"
    style="background-color: #ddeffd; margin-bottom: 0px !important; margin-top: 0px; font-size: 14px;">
    <div class="container">
        <br><br>
        <div class="content">
            <div class="section" style="background-color: #ddeffd">
                <div class="container">
                    <div class="card no-transition">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9 text-center text-md-left">
                                    <span class="pl-0 float-left ticket-bg text-danger d-none d-sm-block">Ticket ID:
                                        #{{ !empty($ticket['id']) ? $ticket['id'] : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="cbp_tmtimeline">
                                <li>
                                    <div class="cbp_tmlabel">
                                        <div class="media-body">
                                            <h2 class="media-heading">
                                                {{ !empty($ticket['subject']) ? $ticket['subject'] : '-' }}</h2>
                                            <hr>
                                            {!! !empty($ticket['content']) ? $ticket['content'] : '-' !!}
                                            <div class="media-footer">
                                                <a href="javascript:void(0)" class="btn btn-link">
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    {{ !empty($ticket['name']) ? $ticket['name'] : '-' }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cbp_tmicon bg-info d-none d-sm-block"><i class="fas fa-ticket-alt"></i>
                                    </div>
                                </li>
                                @foreach ($answer as $val)
                                    @if ($val['file'] == 0 && $val['operatorid'] == 0)
                                        <li>
                                            <div class="d-none d-sm-block cbp_tmicon bg-info"> <i
                                                    class="fa fa-user"></i></div>
                                            <div class="cbp_tmlabel">
                                                <div id="edit-content34">{!! !empty($val['content']) ? $val['content'] : '-' !!}</div>
                                                <div class="media-footer">
                                                    <a href="javascript:void(0)" class="btn btn-success btn-link">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        {{ !empty($ticket['name']) ? $ticket['name'] : '-' }}
                                                    </a>
                                                    <button type="button" class="btn btn-link btn-round"><i
                                                            class="fa fa-clock"></i>
                                                        {{ date('d-m-Y H:i:s', strtotime($val['sent'])) }}</button>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($val['file'] == 0 && $val['operatorid'] != 0)
                                        <li>
                                            <div class="d-none d-sm-block cbp_tmicon bg-green"> <i
                                                    class="fa fa-life-ring"></i></div>
                                            <div class="cbp_tmlabel">
                                                <div id="edit-content35">{!! !empty($val['content']) ? $val['content'] : '-' !!}</div>
                                                <div class="media-footer">
                                                    <a href="javascript:void(0)" class="btn btn-success btn-link">
                                                        <i class="fa fa-user" aria-hidden="true"></i> inaexport
                                                        helpdesk admin</a>
                                                    <button type="button" class="btn btn-link btn-round"><i
                                                            class="fa fa-clock"></i>
                                                        {{ date('d-m-Y H:i:s', strtotime($val['sent'])) }}</button>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($val['file'] == 1 && $val['operatorid'] == 0)
                                        <li>
                                            <div class="d-none d-sm-block cbp_tmicon  bg-orange"> <i
                                                    class="fa fa-file-archive"></i></div>
                                            <div class="cbp_tmlabel">
                                                <div id="file-delete32">Following file <a
                                                        href="{{ 'https://support.inaexport.id//files/support/' . $ticket['id'] . '/' . $val['content'] }}"
                                                        target="_blank"
                                                        class="btn btn-warning btn-sm">{{ !empty($val['content']) ? substr($val['content'], 17) : '-' }}</a>
                                                    has been attached to this ticket.</div>
                                                <div class="media-footer">
                                                    <a href="javascript:void(0)" class="btn btn-success btn-link">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        {{ !empty($ticket['name']) ? $ticket['name'] : '-' }}
                                                    </a>
                                                    <button type="button" class="btn btn-link btn-round"><i
                                                            class="fa fa-clock"></i>
                                                        {{ date('d-m-Y H:i:s', strtotime($val['sent'])) }}</button>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                                <li id="formanswer" style="{{ $ticket['status'] == 'Closed' ? 'display:none' : '' }}">
                                    <div class="cbp_tmicon bg-gray d-none d-sm-block" id="reply"> <i
                                            class="fa fa-paper-plane"></i></div>
                                    <div class="cbp_tmlabel">
                                        <form method="post" class="jak_form"
                                            action="{{ route('front.ticket.addanswer') }}"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group show_editor">
                                                <input type="hidden" name="ticketid" value="{{ $ticket['id'] }}">
                                                <textarea required id="konten" class="form-control" name="contents"></textarea>
                                                <script>
                                                    var konten = document.getElementById("konten");
                                                    CKEDITOR.replace(konten, {
                                                        language: 'en-gb',
                                                        height: 255
                                                    });
                                                    CKEDITOR.config.removePlugins = 'image,pwimage';
                                                </script>
                                            </div>
                                            <p>Upload attachments</p>
                                            <input type="file" name="file" id="file" class="form-control">
                                            <sub>Allowed file types: .zip, .rar, .jpg, .jpeg, .png, .gif</sub>
                                            <div class="clearfix"></div>
                                            <div class="show_editor">
                                                <br>
                                                <button type="submit" class="btn btn-success btn-block" id="sendTM">Send
                                                    <i id="loader" class="fa fa-spinner fa-pulse"
                                                        style="display: none;"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-profile no-transition  margin-top-0">
                                <div class="card-cover"
                                    style="background-image: url('https://support.inaexport.id/template/business/img/card-project4.jpg')">
                                </div>
                                <div class="card-avatar border-white">
                                    <a href="#avatar">
                                        <img src="{{ url('image/nia-01-01.jpg') }}"
                                            alt="{{ !empty($ticket['name']) ? $ticket['name'] : '-' }}">
                                    </a>
                                </div>
                                <div class="card-body">

                                    <h4 class="card-title">{{ !empty($ticket['name']) ? $ticket['name'] : '-' }}
                                    </h4>
                                    <p>{{ !empty($ticket['email']) ? $ticket['email'] : '-' }}</p>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="text-left">Department</td>
                                                <td class="text-left">
                                                    {{ !empty($ticket['department']) ? $ticket['department'] : '-' }}
                                                </td>
                                                <td class="text-center"><span
                                                        class="badge badge-pill badge-success"><i class="fa fa-building"
                                                            aria-hidden="true"></i></span></td>
                                            </tr>
                                            <tr id="trstatus">
                                                <td class="text-left">Status</td>
                                                @if ($ticket['status'] == 'Open')
                                                    <td class="text-left"><span
                                                            class="badge badge-pill badge-primary">Open</span></td>
                                                @elseif($ticket['status'] == 'Closed')
                                                    <td class="text-left"><span
                                                            class="badge badge-pill badge-success">Closed</span></td>
                                                @elseif($ticket['status'] == 'Await Reply')
                                                    <td class="text-left"><span
                                                            class="badge badge-pill badge-warning">Await Reply</span>
                                                    </td>
                                                @elseif($ticket['status'] == 'Soft Closed')
                                                    <td class="text-left"><span
                                                            class="badge badge-pill badge-primary">Soft Closed</span>
                                                    </td>
                                                @elseif($ticket['status'] == 'All')
                                                    <td class="text-left"><span
                                                            class="badge badge-pill badge-default">All</span></td>
                                                @else
                                                    <td class="text-left"><span
                                                            class="badge badge-pill badge-default">-</span></td>
                                                @endif

                                                <td class="text-center"><span
                                                        class="badge badge-pill badge-default"><i class="fa fa-clock"
                                                            aria-hidden="true"></i></span></td>
                                            </tr>
                                            <tr id="trstatusclosed" style="display: none">
                                                <td class="text-left">Status</td>
                                                <td class="text-left"><span
                                                        class="badge badge-pill badge-success">Closed</span></td>
                                                <td class="text-center"><span
                                                        class="badge badge-pill badge-default"><i class="fa fa-clock"
                                                            aria-hidden="true"></i></span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Priority</td>
                                                <td class="text-left"><span
                                                        class="badge badge-pill badge-secondary">{{ !empty($ticket['priority']) ? $ticket['priority'] : '-' }}</span>
                                                </td>
                                                <td class="text-center"><span
                                                        class="badge badge-pill badge-secondary"><i
                                                            class="fa fa-fire" aria-hidden="true"></i></span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Option</td>
                                                <td class="text-left">
                                                    {{ !empty($ticket['title']) ? $ticket['title'] : '-' }}</td>
                                                <td class="text-center"><span
                                                        class="badge badge-pill badge-info"><i class="fa fa-comment"
                                                            aria-hidden="true"></i></span></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    @if ($ticket['status'] != 'Closed')
                                        <div id="divstatus">
                                            <h5 style="float: left" class="card-title space-bot">Status</h5>
                                            <div class="form-group">
                                                <label for="jak_status"
                                                    class="bmd-label-floating sr-only">Status</label>
                                                <select name="jak_status" id="jak_status" class="form-control">
                                                    <option value="1"
                                                        {{ $ticket['status'] == 'Open' ? 'selected' : '' }}>Open
                                                    </option>
                                                    <option value="4"
                                                        {{ $ticket['status'] == 'Closed' ? 'selected' : '' }}>Closed
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="lblstatus" style="color: red;float: left;display: none">*Status berubah
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card card-with-shadow no-transition">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Involved Supporters</h5>
                                    <div class="accounts-suggestion">
                                        <ul class="list-unstyled">
                                            <li class="account space-top">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="avatar text-center">
                                                            <img src="{{ url('image/nia-01-01.jpg') }}" alt="inaexport"
                                                                class="img-circle img-no-padding img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 description-section">
                                                        <span class="h6">inaexport</span>
                                                        <br>
                                                        <span class="text-muted"><small></small></span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card no-transition">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 text-left">
                                    <div class="row float-left pl-2 pr-1">
                                        <a href="{{ route('front.ticket.index') }}"
                                            class="btn btn-outline-info btn-round"><i class="fa fa-arrow-left"></i>
                                            Kembali</a>
                                    </div>
                                </div>
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

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function() {

        $("#jak_status").change(function() {

            let id = "{{ $ticket['id'] }}";
            let url = "{{ route('ticket_support.changestatus') }}";

            $.getJSON(url, {
                id: id,
                status: this.value
            }, function(data, status) {
                $('#lblstatus').fadeIn('fast').delay(1000).fadeOut('fast');
                $('#formanswer').hide();
                $('#divstatus').hide();
                $('#trstatus').hide();
                $('#trstatusclosed').show();
            });

        })
    });
</script>
