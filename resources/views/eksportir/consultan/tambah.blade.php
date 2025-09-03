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
            height: 45px !important;
        }

        .rightbtn {
            float: left;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ url($url) }}">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="mb-0">Add Consultan</h3>
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
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Name</b></label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Position</b></label>
                                <input type="text" class="form-control" name="posotion">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Phone</b></label>
                                <input type="text"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    class="form-control" name="phone">
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Official</b></label>
                                <input type="text" class="form-control" name="pejabat">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label for="problem"><b>Problem</b></label>
                                <textarea class="form-control" id="problem" name="problem"></textarea>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-sm-3 mb-2">
                                <label  for="solution"><b>Solution</b></label>
                                <textarea type="text" class="form-control" name="solution" id="solution"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="form-row rightbtn">
                            <div class="form-group col-sm-12 ">
                                <a style="color: white" href="{{ url('/eksportir/consultan') }}" class="btn btn-danger"><i
                                        style="color: white"></i>
                                    Back
                                </a>
                                <button class="btn btn-primary" type="submit">Submit
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <form>
        </div>
    </div>

    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    {{-- <script>
        CKEDITOR.replace('problem');
        CKEDITOR.replace('solution');
    </script> --}}

    @include('footer')

@endsection
