@extends('header2')
@section('content')
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

        th {
            text-align: center;
        }

        td {
            color: black;
        }

        #tambah {
            background-color: #1a9cf9;
            color: white;
            white-space: pre;
        }

        #tambah:hover {
            background-color: #148de4
        }

        #export {
            background-color: #28bd4a;
            color: white;
            white-space: pre;
        }

        #export:hover {
            background-color: #08b32e
        }

      
        .table-css {
            color: #fff;
            font-size: 12px;
            font-weight: 600;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    @if ($page == 'create')
                        <h3>Form Training</h3>
                    @elseif($page == 'edit')
                        <h3>Edit Training</h3>
                    @elseif($page == 'view')
                        <h3>View Training
                            <a style="float:right" href="{{ url('admin/training') }}" class="btn btn-danger"
                                name="button">Back</a>
                        </h3>
                    @endif
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($page == 'create')
                        <form action="{{ route('training.store.admin') }}" method="post">
                        @elseif($page == 'edit')
                            <form action="{{ route('training.update.admin', $data->id) }}" method="post">
                    @endif

                    {{-- @if ($page == 'view')
          <a style="float:right" href="{{url('admin/training')}}" class="btn btn-danger" name="button">Back</a>
          <br>
        @endif --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4 mt-2">
                                        <b>Training (EN)</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="text" autocomplete="off" class="form-control dis" name="training_en"
                                            @if ($page != 'create') value="{{ $data->training_en }}" @endif
                                            required>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4 mt-2">
                                        <b>Training (IN)</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" autocomplete="off" class="form-control dis" name="training_in"
                                            @if ($page != 'create') value="{{ $data->training_in }}" @endif
                                            required>
                                    </div>
                                </div>
                                <br>



                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4 mt-2">
                                        <b>Start Date</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" autocomplete="off" class="form-control dis" id="start_date"
                                            name="start_date"
                                            @if ($page != 'create') value="{{ date('Y-m-d', strtotime($data->start_date)) }}" @endif
                                            required>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4 mt-2">
                                        <b>End Date</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" autocomplete="off" class="form-control dis" id="end_date"
                                            name="end_date"
                                            @if ($page != 'create') value="{{ date('Y-m-d', strtotime($data->end_date)) }}" @endif
                                            required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4 mt-2">
                                        <b>Duration</b>
                                    </div>
                                    <div class="col-md-6">
                                        <table width="100%">
                                            <tr>
                                                <td id="dur1" style="padding-right: 10px; width: 60%;">
                                                    <input type="text" autocomplete="off" class="form-control"
                                                        id="duration" name="duration"
                                                        @if ($page != 'create') value="{{ $data->duration }}" @endif
                                                        onkeydown="return false;" onpaste="return false;"
                                                        {{-- oninvalid="this.setCustomValidity('Please make sure your start date and end date is valid')" --}} --}} value="" required>
                                                </td>
                                                <td>
                                                    <input type="text" autocomplete="off" class="form-control dis"
                                                        name="param" value="Days" readonly required>
                                                    {{-- <select class="form-control dis" name="param"> --}}
                                                    {{-- <option value="Days" @if ($page != 'create') @if ($data->param == 'Days') selected @endif @endif>Days</option> --}}
                                                    {{-- <option value="Week" @if ($page != 'create') @if ($data->param == 'Week') selected @endif @endif>Week</option> --}}
                                                    {{-- </select> --}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <b>Topic (EN)</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" autocomplete="off" class="form-control dis" name="topic_en"
                                            @if ($page != 'create') value="{{ $data->topic_en }}" @endif
                                            required>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <b>Topic (IN)</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" autocomplete="off" class="form-control dis" name="topic_in"
                                            @if ($page != 'create') value="{{ $data->topic_in }}" @endif
                                            required>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <b>Location (EN)</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" autocomplete="off" class="form-control dis" name="location_en"
                                            @if ($page != 'create') value="{{ $data->location_en }}" @endif
                                            required>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <b>Location (IN)</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" autocomplete="off" class="form-control dis" name="location_in"
                                            @if ($page != 'create') value="{{ $data->location_in }}" @endif
                                            required>
                                    </div>
                                </div>
                                <br>

                            </div>
                        </div>
                        <br>
                        <br>

                        <h4 class="ml-4"><b>
                                <center>CONTACT PERSON</center>
                            </b></h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4 mt-2">
                                        <b>Full Name</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" autocomplete="off" class="form-control dis" name="cp_name"
                                            @if ($page != 'create') @if ($cp) value="{{ $cp->name }}" @endif
                                            @endif required>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4 mt-2">
                                        <b>Email</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" autocomplete="off" class="form-control dis" name="cp_email"
                                            @if ($page != 'create') @if ($cp) value="{{ $cp->email }}" @endif
                                            @endif required>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <b>Phone</b>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" onblur="this.value=removeSpaces(this.value);" autocomplete="off"
                                            class="form-control dis" name="cp_phone" maxlength="15"
                                            @if ($page != 'create') @if ($cp) value="{{ $cp->phone }}" @endif
                                            @endif>
                                    </div>
                                </div>
                                <br>

                            </div>
                        </div>
                    </div>
                    @if ($page != 'view')
                        <div class="row">
                            <div class="offset-lg-9 text-right">
                                <a href="{{ url('admin/training') }}" class="btn btn-danger" name="button"> Cancel</a>
                                <button type="submit" class="btn btn-primary" name="button" aria-label="Submit"><i
                                        class="fa fa-save" aria-hidden="true"></i> Submit </button>
                            </div>
                        </div>
                    @else
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-11">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead class="text-white" style="background-color: #C4C4C4">
                                        <tr>
                                            <th>No</th>
                                            <th>Company</th>
                                            <th>Interested at</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
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
        $('#start_date').change(function() {
            var dt1 = new Date($('#start_date').val());
            var dt2 = new Date($('#end_date').val());
            if (dt2 == 'Invalid Date') {

            } else {
                if (dt1 > dt2) {
                    alert('End Date Has to be after Start Date');
                    var tes = $('#duration').val('');
                    // console.log(tes);
                    $('#end_date').val(new Date())
                } else {
                    var tes = Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1
                        .getFullYear(), dt1.getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24)) + 1;
                    // var div = document.getElementById('dur1');
                    // var duration = document.getElementById('duration');
                    // duration.parentNode.removeChild(duration);
                    // $('#dur1').append(
                    //     $('<input>', {
                    //         type: 'text',
                    //         name: 'duration',
                    //         id: 'duration',
                    //         onkeydown: 'return false;',
                    //         onpaste: 'return false;',
                    //         oninvalid: 'this.setCustomValidity(\'Please make sure your start date and end date is valid\')',
                    //         class: 'form-control dis',
                    //         autocomplete: 'off',
                    //     })
                    // )
                    // $("#duration").attr('required', '');
                    $('#duration').val(tes);
                }
            }
        });

        $('#end_date').change(function() {
            var dt1 = new Date($('#start_date').val());
            var dt2 = new Date($('#end_date').val());
            if (dt1 > dt2) {
                alert('End Date Has to be after Start Date');
                var tes = $('#duration').val('');
                $('#end_date').val(new Date())
            } else {
                var tes = Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1
                    .getFullYear(), dt1.getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24)) + 1;
                // var div = document.getElementById('dur1');
                // var duration = document.getElementById('duration');
                // duration.parentNode.removeChild(duration);
                // $('#dur1').append(
                //     $('<input>', {
                //         type: 'text',
                //         name: 'duration',
                //         id: 'duration',
                //         onkeydown: 'return false;',
                //         onpaste: 'return false;',
                //         oninvalid: 'this.setCustomValidity(\'Please make sure your start date and end date is valid\')',
                //         class: 'form-control dis',
                //         autocomplete: 'off',
                //     })
                // )
                // $("#duration").attr('required', '');
                $('#duration').val(tes);
            }
        });

        $(document).ready(function() {
            var type = '{{ $page }}';
            @if ($page == 'view')
                $('#table').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('training.getDataInterest', $data->id) }}",
                columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'company', name: 'company'},
                {data: 'interest', name: 'interest'}
                ],
                "language": {
                "paginate": {
                "previous": "<i class='fa fa-angle-left' /></>",
                "next": "<i class='fa fa-angle-right' /></>"
                }
                }
                });
            @endif
            if (type == "view") {
                $('.dis').prop('disabled', true);
            }
        })

        function removeSpaces(string) {
            return string.split(' ').join('');
        }
    </script>

    @include('footer')
@endsection
