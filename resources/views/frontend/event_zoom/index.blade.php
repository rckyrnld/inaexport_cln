@include('frontend.layouts.header')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.css" rel="stylesheet">
<style type="text/css">
    .form-control:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
    }

    .search {
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
    }

    .sel-event {
        height: 100%;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        padding-left: 5px;
        background-color: #f7f7f7;
        border-left: 2px solid #1a70bb;
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
    }

    .css-title {
        font-family: arial;
        font-weight: 530;
        font-size: 18px;
        color: black !important;
    }

    .search-event {
        width: 100%;
    }

    .custom-card {
        float: left !important;
        border: 1px solid rgba(35, 35, 51, .08) !important;
        box-shadow: 0 2px 2px #ccc !important;
        border-radius: 8px !important;
        margin: 0 30px 30px 0 !important;
        min-height: 220px !important;
        position: relative !important;
    }

    .custom-card>.title {
        font-size: 24px;
        max-height: 68px;
        overflow: hidden;
        padding-bottom: 10px;
    }

    p.title-event {
        font-size: 22px;
        font-family: "Lato", Helvetica, Arial
    }

    div.date-event {
        font-size: 15px;
        font-family: "Lato", Helvetica, Arial;
        color: #F26D21;
        font-weight: 700;
        padding-bottom: -5px;
    }

    .header img {
        float: left;
    }

    .header h2 {
        position: relative;
        top: 3px;
        left: -10px;
    }

    .btn-rounded {
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        margin-top: -2px;
        padding: 0 12px;
        height: 32px;
        line-height: 32px;
        min-width: 112px;
        border-radius: 8px;
        margin-right: 40px;
    }

    .title-duration {
        padding-bottom: 15px;
    }

    .cardzoom:hover {
        text-decoration: none;
        background-color: #f4f4f5;
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

    .cardzoom button.active {
        background-color: #1a70bb;
        color: white;
    }

    .card-body:hover {
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

     .select2 {
        width: 72% !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }

</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12">
                <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                    <ul>
                        <li><a href="{{ url('/') }}">@lang("frontend.proddetail.home")</a></li>
                        <li>Business Matching</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <form class="form-horizontal" enctype="multipart/form-data" method="GET"
                    action="{{ url('/front_end/event_zoom') }}">
                    {{ csrf_field() }}
                    <div class="input-group search-event" style="margin-top: 7px">
                        <div class="input-group-prepend">
                            <select id="search" name="search" class="sel-event">
                                <option value="topic" @if ($searchEvent == 'topic') selected @endif>Topic</option>
                                <option value="date" @if ($searchEvent == 'date') selected @endif>Date</option>
                            </select>
                        </div>
                        <input type="text" id="search_topic" name="search_topic" class="form-control search"
                        style="height: 40px"
                            placeholder="Search" autocomplete="off" @if ($searchEvent == 'topic') value="{{ $parameter }}" @endif>

                        <input type="month" id="search_date" name="search_date" class="form-control search"
                            style="height: 40px"
                            placeholder="Search" autocomplete="off" @if ($searchEvent == 'date') value="{{ $parameter }}" @endif>
                        @if (isset($parameter))
                            @if ($parameter != null)
                                <a href="{{ url('/front_end/event_zoom') }}" class="btn btn-sm btn-default"
                                    style=" border-top: 2px solid #1a70bb; border-right: 2px solid #1a70bb;border-bottom: 2px solid #1a70bb;border-left: 2px solid #1a70bb;"
                                    title="Reset All Filter"><span class="fa fa-close"></span></a>
                            @endif
                        @endif
                        <div class="input-group-prepend">
                            <button type="submit" class="input-group-text submit rounded"
                                style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;background-color: #ffe300;color: #1d7bff;font-weight: bold;border-top: #1a70bb solid 2px;border-right: #1a70bb solid 2px;border-bottom: #1a70bb solid 2px;"
                                title="Search">&nbsp;Search&nbsp;</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<div class="container" style="background-color: white; padding-bottom: 3%;">
    <div class="row mt-4">
        <div class="col col-lg-6 col-md-12 pl-3">
            <span style="color: #114777;">
                <div class="header">
                    <img src="{{ asset('image/zoomlogo.png') }}" width="80" />
                    <h2><b>@lang('frontend.event_zoom.title')</b></h2>
                </div>
            </span>
        </div>
        <div class="col col-lg-6 col-md-12 text-right">

        </div>
    </div>
    <div class="row pt-4">
        @foreach ($zoom_event as $key => $ze)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card custom-card w-100 cardzoom">
                    <div class="card-body">
                        <p class="title-event"><b>{{ $ze->topic }}</b></p>
                        <?php date_default_timezone_set('Asia/Jakarta'); ?>
                        <p class="">
                        <div class="row align-items-center h-100">
                            <div class="ml-3">
                                <i class="far fa-calendar-alt" style="color: #F26D21;"></i>
                            </div>
                            <div class="date-event">
                                <span
                                    class="ml-2">{{ strtoupper(date('d M Y', strtotime($ze->start_time))) }}
                                    <br><span
                                        class="ml-2"></span>{{ date('H:i', strtotime($ze->start_time)) }}
                                    (UTC+7)
                            </div>
                        </div>
                        @php
                            $return = false;
                            $now = \Carbon\Carbon::now();
                            $check_expired = \Carbon\Carbon::parse($ze->start_time) > $now ? false : true;
                        @endphp

                        @if ($check_expired == false)
                            <div class="row ml-3">
                                &nbsp;(<div class="count_down"
                                    d-date="{{ date('F d, Y H:i', strtotime($ze->start_time)) }}"></div>)
                            </div>
                        @else
                            <div class="row ml-3">
                                &nbsp;(It has been passed)
                            </div>
                        @endif

                        </p>
                        <span class=""> <i class="fas fa-map-marker-alt"></i>
                            @lang('frontend.event_zoom.country'): {{ $ze->country->country }}
                        </span><br>
                        <span class="title-duration"><i class="far fa-clock"></i>
                            @lang('frontend.event_zoom.duration'): {{ $ze->duration }}
                            @lang('frontend.event_zoom.minute')</span>
                        @if ($check_expired == false)
                            @if (in_array($ze->id, $joined_zoom_room_verified))
                                <div class="row">
                                    <span data-toggle="modal" data-target="#exampleModalUserInvited"
                                        class="btn-user-invited pl-3" data-join-url="{{ $ze->join_url }}"
                                        data-meeting-id="{{ $ze->meeting_id }}"
                                        data-password="{{ $ze->password }}">
                                        <a class="btn btn-success btn-rounded text-white" data-toggle="tooltip"
                                            data-placement="top"
                                            title="@lang('frontend.event_zoom.join')">@lang('frontend.event_zoom.join')</a>
                                    </span>
                                </div>
                            @elseif (in_array($ze->id, $joined_zoom_room_unverified))
                                <button type="button"
                                    class="btn btn-secondary btn-rounded btn-join disabled">@lang('frontend.event_zoom.waiting_verify')</button>
                            @else
                                <button type="button" class="btn btn-primary btn-rounded btn-join"
                                    onclick="join({{ $ze->id }})">@lang('frontend.event_zoom.register_now')</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center pt-4">
        {{ $zoom_event->links('vendor.pagination.bootstrap-4') }}
        {{ $zoom_event->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
    </div>
</div>

<div class="modal fade" id="exampleModalUserInvited" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Meeting Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="border: none !important; left: 92% !important; padding-top: 13px;">&times;</button>
            </div>
            <div class="modal-body">
                <table class="" id="invited-user-table" style="width:100%">
                    <tbody>
                        <tr>
                            <td width="25%">Zoom Meeting ID</td>
                            <td width="5%">:</td>
                            <td><label class="meeting-id-value"></label></td>
                        </tr>
                        <tr>
                            <td width="25%">Password</td>
                            <td width="5%">:</td>
                            <td><label class="password-value"></label></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center"><a class="btn btn-success rounded join-url-value"
                                    target="_blank" data-toggle="tooltip" data-placement="top"
                                    title="@lang('frontend.event_zoom.join')"
                                    href="#">@lang('frontend.event_zoom.join')</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPromptLogin" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose Login Page</h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"
                    style="border: none !important; left: 92% !important; padding-top: 13px;">&times;</button>
            </div>
            <div class="modal-body">
                <p>@lang('frontend.event_zoom.click_register')</p>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ url('/login?redirect='.encrypt('business_matching')) }}" class="btn btn-primary rounded">Login Company</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ url('/admin?redirect='.encrypt('business_matching')) }}" class="btn btn-primary rounded">Login Perwakilan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-close rounded" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('frontend.layouts.footer')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="{{ asset('vendor/jquerycountdown/jquery.countdown.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var search = "{{ $searchEvent }}";
        if (search == 'topic') {
            $('#search_topic').show();
            $('#search_date').hide();
        } else if (search == 'date') {
            $('#search_topic').hide();
            $('#search_date').show();
        } else {
            $('#search_topic').show();
            $('#search_date').hide();
        }

        $('#search').on('change', function() {
            let thisValue = this.value;
            if (thisValue == 'topic') {
                $('#search_date').hide();
                $('#search_topic').show();
            } else {
                $('#search_date').show();
                $('#search_topic').hide();
            }
        });

    })

    function join(zoom_room_id) {
        @if (Auth::guard('eksmp')->user() || Auth::user())
            Swal.fire({
            title: 'Are you sure?',
            text: "You want to register this meeting",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
            if (result.isConfirmed) {
            Swal.fire({
            title: 'Please Wait...',
            html: '<div class="loader"></div>',
            allowOutsideClick: false,
            showConfirmButton: false
            });
            var token = "{{ csrf_token() }}";
            let itdp_admin_user_id;
            let itdp_company_user_id;
            @if (Auth::user() != null)
                itdp_admin_user_id = "{{ Auth::user()->id }}"
        
            @else
                itdp_company_user_id = "{{ Auth::guard('eksmp')->user()->id }}"
        
            @endif
            $.ajax({
            url: "{{ url('front_end/event_zoom/join_event') }}",
            type: 'post',
            data:
            {'_token':token,itdp_company_user_id:itdp_company_user_id,itdp_admin_user_id:itdp_admin_user_id,zoom_room_id:zoom_room_id},
            dataType: 'json'
            })
            .done(function(data){
            window.location.href = "{{ url('/front_end/event_zoom') }}"
            });
        
            }
            });
        
        @else
        
            // alert("@lang('frontend.event_zoom.click_register')");
            // window.location.href = "{{ url('/login') }}";
            $('#ModalPromptLogin').modal('show');
            return false;
        @endif
    }

    $('.btn-user-invited').click(function() {
        $('.meeting-id-value').html($(this).attr('data-meeting-id'));
        $('.password-value').html($(this).attr('data-password'));
        $('a.join-url-value').attr("href", $(this).attr('data-join-url'))
    });

    $('button.btn-close').click(function() {
        $("#ModalPromptLogin").modal('hide');
    })

    $('.count_down').countdown({
        day: {
            text: 'd ',
        },
        hour: {
            text: 'h ',
        },
        minute: {
            text: 'm ',
        },
        second: {
            text: 's',
        },
    });
</script>
