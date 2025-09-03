@include('frontend.layouts.header')
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
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

    .badge-default {
        border-color: #888;
        background-color: #888;
    }

    .badge-info {
        border-color: #2CA8FF;
        background-color: #2CA8FF;
    }

    .badge-warning {
        border-color: #FFB236;
        background-color: #FFB236;
    }

    .badge-success {
        border-color: #18ce0f;
        background-color: #18ce0f;
    }

    .badge {
        border-radius: 8px;
        padding: 4px 8px;
        text-transform: uppercase;
        font-size: 0.7142em;
        line-height: 12px;
        border: 1px solid;
        text-decoration: none;
        color: #FFFFFF;
        margin-bottom: 5px;
        border-radius: 0.875rem;
        float: right;
        margin-top: 8px;

    }

    .footer_bottom {
        height: 55px;
    }

    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }

    .pagination>li {
        display: inline;
    }

    .pagination>li>a,
    .pagination>li>span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }

    .pagination>li:first-child>a,
    .pagination>li:first-child>span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .pagination>li:last-child>a,
    .pagination>li:last-child>span {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    .pagination>li>a:hover,
    .pagination>li>span:hover,
    .pagination>li>a:focus,
    .pagination>li>span:focus {
        z-index: 2;
        color: #23527c;
        background-color: #eee;
        border-color: #ddd;
    }

    .pagination>.active>a,
    .pagination>.active>span,
    .pagination>.active>a:hover,
    .pagination>.active>span:hover,
    .pagination>.active>a:focus,
    .pagination>.active>span:focus {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #337ab7;
        border-color: #337ab7;
    }

    .pagination>.disabled>span,
    .pagination>.disabled>span:hover,
    .pagination>.disabled>span:focus,
    .pagination>.disabled>a,
    .pagination>.disabled>a:hover,
    .pagination>.disabled>a:focus {
        color: #777;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #ddd;
    }

    .pagination-lg>li>a,
    .pagination-lg>li>span {
        padding: 10px 16px;
        font-size: 18px;
        line-height: 1.3333333;
    }

    .pagination-lg>li:first-child>a,
    .pagination-lg>li:first-child>span {
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
    }

    .pagination-lg>li:last-child>a,
    .pagination-lg>li:last-child>span {
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
    }

    .pagination-sm>li>a,
    .pagination-sm>li>span {
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
    }

    .pagination-sm>li:first-child>a,
    .pagination-sm>li:first-child>span {
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    .pagination-sm>li:last-child>a,
    .pagination-sm>li:last-child>span {
        border-top-right-radius: 3px;
        border-bottom-right-radius: 3px;
    }

</style>

<div class="loading" id="loader" style="display:none;">Loading&#8230;</div>
<div>
    <div class="breadcrumbs_area" style="background-color:rgba(0,0,0,0.1);">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="mb-15 breadcrumb_content" style="margin-top: -8px">
                        <ul>
                            <li><a href="{{ url('/') }}">@lang('frontend.proddetail.home')</a></li>
                            <li><a href="#">@lang('frontend.history.ticket')</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shop_area shop_reverse" style="background-color: #ddeffd; margin-top: 0px; margin-bottom: 0px; padding-bottom: 20px; padding-top: 20px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-divider m-0"></div>
                    <div class="box-body" style="background-color: #ddeffd">
                        <div class="container">
                            <h3> Ticketing Support </h3>
                            <br>
                            <div class="row">
                                <div class="well" style="padding:0px;width: 100%;">
                                    @if ($help)
                                        <div id="myTabContent1" class="tab-content padding-10">
                                            <div class="tab-pane fade in active" id="link1">
                                                <a style="color: white;margin-right: 8px;"
                                                    class="badge badge-default">All</a>
                                                <a style="color: white;margin-right: 2px;"
                                                    class="badge badge-info">Open</a>
                                                <a style="color: white;margin-right: 2px;"
                                                    class="badge badge-warning">Await
                                                    Reply</a>
                                                <a style="color: white;margin-right: 2px;" class="badge badge-info">Soft
                                                    Closed</a>
                                                <a style="color: white;margin-right: 2px;"
                                                    class="badge badge-success">Closed</a>
                                                <a href="{{ route('front.ticket.create') }}"
                                                    style="border-radius: 5px;margin: 5px"
                                                    class="btn btn-sm btn-success"><i class="fa fa-plus-circle"></i>
                                                    Add</a>
                                                <br><br>
                                                <button
                                                    style="border-radius:5px;float: right;margin-right: 5px;margin-bottom: 5px"
                                                    type="button" id="btn-cari" class="btn btn-sm btn-info"><i
                                                        class="fa fa-search"></i></button>
                                                <input
                                                    style="float: right;margin-right: 5px;margin-bottom: 5px;width: 175px"
                                                    type="text" id="text-cari" placeholder="Search.."
                                                    class="input-sm form-control" />
                                                <select id="select-order"
                                                    style="float: left;margin-left: 5px;margin-bottom: 5px;width: 175px"
                                                    size="1" class="input-sm form-control">
                                                    <option value="">Choose</option>
                                                    <option value="1">Subject</option>
                                                    <option value="2">Department</option>
                                                    <option value="3">Priority</option>
                                                    <option value="4">Status</option>
                                                </select>
                                                <select id="select-sort"
                                                    style="float: left;margin-left: 5px;margin-bottom: 5px;width: 90px"
                                                    size="1" class="input-sm form-control">
                                                    <option value="desc">desc</option>
                                                    <option value="asc">asc</option>
                                                </select>
                                                <table id="table" class="table  table-bordered table-striped"
                                                    data-plugin="dataTable" style="width: 100%;">
                                                    <thead class="text-white" style="background-color: #1089ff;">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Department</th>
                                                            <th>Priority</th>
                                                            <th>Sent</th>
                                                            <th>Last Update</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbod"></tbody>
                                                </table>
                                                <ul style="margin-left: 5px;margin-top: 5px" id="pagination"
                                                    class="pagination-sm"></ul>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-primary" style="font-weight: bold;text-align: center"
                                            role="alert">
                                            Akun belum terdaftar di helpdesk
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    @include('frontend.layouts.footer')

    <script type="text/javascript">
        $(function() {

            var url = "{{ route('ticket_support.getData.seller') }}";
            var page = 1;
            var current_page = 1;
            var total_page = 0;
            var is_ajax_fire = 0;
            var help = "{{ $help }}";

            if (help)
                manageData(null);

            function manageData(search) {

                $.ajax({
                    method: "GET",
                    url: url,
                    data: {
                        page: page,
                        search: null,
                        orderby: null,
                        sort: null
                    },
                    beforeSend: function() {
                        $('#loader').show();
                    }
                }).done(function(val) {

                    $('#loader').hide();

                    total_page = Math.ceil(val.meta.page.total / 10);
                    current_page = page;
                    console.log(total_page)

                    $('#pagination').twbsPagination({
                        totalPages: total_page,
                        visiblePages: total_page,
                        onPageClick: function(event, pageL) {
                            page = pageL;
                            if (is_ajax_fire != 0) {
                                getPageData();
                            }
                        }
                    });

                    manageRow(val.data)
                    is_ajax_fire = 1;
                })
            }

            function getPageData() {

                let order = getOrder($('#select-order').find(":selected").val());
                let sort = $('#select-sort').find(":selected").val();
                let search = $('#text-cari').val();

                $.ajax({
                    method: "GET",
                    url: url,
                    data: {
                        page: page,
                        search: search,
                        orderby: order,
                        sort: sort
                    },
                    beforeSend: function() {
                        $('#loader').show();
                    }
                }).done(function(val) {
                    $('#loader').hide();
                    manageRow(val.data)
                })
            }


            function manageRow(data) {
                var rows = '';

                $.each(data, function(key, value) {
                    var private = value.private == 0 ? '<i class="fa fa-check"></i>' :
                        '<i class="fa fa-times"></i>';
                    var attach = value.private == 0 ? '<i class="fa fa-check"></i>' :
                        '<i class="fa fa-times"></i>';
                    var priority = getPriority(value.priorityid);
                    var ClassColor = getClassColor(value.status);
                    var department = value.department.title;
                    var redirect = '{{ url('front_end/ticketing_support/manage') }}' + '/' + value.id;
                    var initiated = convertMili(value.initiated);
                    var updated = convertMili(value.updated);

                    rows = rows + '<tr class="' + ClassColor + '">';
                    rows = rows + '<td>' + value.subject + '</td>';
                    rows = rows + '<td>' + department + '</td>';
                    rows = rows + '<td><center>' + priority + '</center></td>';
                    rows = rows + '<td><center>' + initiated + '</center></td>';
                    rows = rows + '<td><center>' + updated + '</center></td>';
                    rows = rows + '<td data-id="' + value.id + '">';
                    rows = rows + '<center><a href="' + redirect +
                        '" style="border-radius: 5px" class="btn btn-primary btn-sm edit-user"> <span class="fa fa-edit" aria-hidden="true"></span> Manage</a></center>';
                    rows = rows + '</td>';
                    rows = rows + '</tr>';
                });

                $("tbody#tbod").html(rows);
            }

            function convertMili(timestamp) {

                var url = "{{ url('front_end/ticketing_support/convertmili') }}" + "/" + timestamp;
                var resp = [];
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    async: false,
                    success: function(data) {
                        resp.push(data);
                    },
                    error: function(req, err) {
                        console.log(err);
                    }
                })
                return resp;
            }

            function getPriority(value) {

                if (value == 1)
                    return "Low";
                else if (value == 2)
                    return "Medium";
                else if (value == 3)
                    return "Hard";
                else
                    return "Not Option"
            }

            function getClassColor(value) {

                if (value == 1)
                    return "table-info";
                else if (value == 2)
                    return "table-warning";
                else if (value == 3)
                    return "table-info";
                else
                    return "table-success"
            }

            function getOrder(value) {
                if (value == 1)
                    return "subject";
                else if (value == 2)
                    return "depid";
                else if (value == 3)
                    return "priorityid";
                else if (value == 4)
                    return "status";
            }

            $('#select-order').on('change', function() {
                getPageData()
            });

            $('#select-sort').on('change', function() {
                getPageData()
            });

            $('#btn-cari').on('click', function() {
                getPageData()
            });

        });
    </script>
