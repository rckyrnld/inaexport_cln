{{-- @include('header') --}}
@extends('header2')
@section('content')
    <style type="text/css">
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
        .select2-container .select2-selection--single {
		box-sizing: border-box;
		cursor: pointer;
		display: block;
		height: 35px !important;
        }
        .custom-select, .custom-file-control, .custom-file-control:before, select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
            height: 35px !important;
        }

    </style>
    <!-- Page content -->
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
    <div class="col-md-12">
        {{ csrf_field() }}
        <div class="card">
            @foreach($data as $val)
                <div class="card-header border-bottom">
                    <h3 class="mt-0">Detail Tujuan Ekspor</h3>
                </div>
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-sm-3 mb-2">
                            <label><b>Year</b></label>
                            <select class="atc form-control select2" disabled required id="year" name="year">
                                <option value="">- Select Years -</option>
                                @foreach ($years as $sa)
                                    <option value="{{ $sa }}"
                                        {{ $val->tahun == $sa ? 'selected' : '' }}>
                                        {{ $sa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-3 mb-2">
                            <label><b>Country</b></label>
                            <select class="atc form-control select2" disabled required id="country" name="country">
                                <option value="">- Pilih Country -</option>
                                @foreach ($country as $sa)
                                    <option value="{{ $sa->id }}"
                                        {{ $val->id_mst_country == $sa->id ? 'selected' : '' }}>
                                        {{ $sa->country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-3 mb-2">
                            <label><b>Ratio Export</b></label>
                            <input disabled type="text" value="{{ str_replace(".",",", $val->rasio_persen )}}" class="form-control persen"
                                name="ratio_export" id="ratio_export">
                            <input type="hidden" value="{{ $val->id }}" class="form-control" name="id_sales"
                                id="id_sales">
                        </div>
                    </div>


                    <div class="form-row rightbtn">
                        <div class="form-group col-sm-12">
                            <a style="color: white" href="{{ URL::previous() }}"
                               class="btn btn-danger"><i style="color: white"></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{--            </form>--}}
    </div>
</div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    @include('footer')
    <script type="text/javascript">
    $('.persen').inputmask({
            alias: "decimal",
            digits: 2,
            repeat: 3,
            digitsOptional: false,
            decimalProtect: true,
            groupSeparator: ".",
            placeholder: '0',
            radixPoint: ",",
            radixFocus: true,
            autoGroup: true,
            autoUnmask: false,
            onBeforeMask: function(value, opts) {
                return value;
            },
            removeMaskOnSubmit: true
        });
        $(function() {
            $(".alert").slideDown(300).delay(1000).slideUp(300);
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ticket_support.getData.admin') }}",
                columns: [{
                        data: 'row',
                        name: 'row'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'subyek',
                        name: 'subyek'
                    },
                    {
                        data: 'main_messages',
                        name: 'main_messages'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap width-200'>" + data + "</div>";
                    },
                    targets: 4
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap width-200'>" + data + "</div>";
                    },
                    targets: 5
                }],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });
        });
    </script>
@endsection
