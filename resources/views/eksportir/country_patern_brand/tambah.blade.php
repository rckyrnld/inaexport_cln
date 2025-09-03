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

        .rightbtn {
            float: left;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 35px !important;
        }

        .custom-select,
        .custom-file-control,
        .custom-file-control:before,
        select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
            height: 35px !important;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Form Tambah Negara Paten Merek</h3>
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
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ url($url) }}">
                        {{ csrf_field() }}

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Brand</b></label>
                                <select class="atc form-control select2" required id="brand" name="brand">
                                    <option value="">- Choose Brand -</option>
                                    @foreach ($brand as $sat)
                                        <option value="{{ $sat->id }}">{{ $sat->merek }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Country</b></label>
                                <select class="atc form-control select2" required id="country" name="country">
                                    <option value="">- Choose Country -</option>
                                    @foreach ($country as $sa)
                                        <option value="{{ $sa->id }}">{{ $sa->country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Month</b></label>
                                <select class="form-control select2" id="bulan" name="bulan" required>
                                    <option value="00">--Select Month--</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Year</b></label>
                                <select class="atc form-control select2" required id="year" name="year" required>
                                    <option value="">- Select Years -</option>
                                    @foreach ($years as $sa)
                                        <option value="{{ $sa }}">{{ $sa }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row rightbtn">
                            <div class="form-group col-sm-12">
                               
                                <a style="color: white" href="{{ url('/eksportir/country_patern_brand') }}"
                                    class="btn btn-danger">
                                    Back
                                </a>
                                <button class="btn btn-primary" type="submit"> Submit

                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @include('footer')

@endsection
