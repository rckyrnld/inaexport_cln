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
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Tambah Aktivitas Pelatihan</h3>
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
                        {{--<div class="form-row">--}}
                            {{--<div class="form-group col-sm-3 mb-2">--}}
                                {{--<label><b>Name</b></label>--}}
                                {{--<input type="text" class="form-control" name="name">--}}
                                {{-- <select class="atc form-control select2" required id="year" --}}
                                {{-- name="year"> --}}
                                {{-- <option value="">- Select Years -</option> --}}
                                {{-- @foreach ($years as $sa) --}}
                                {{-- <option value="{{$sa}}">{{$sa}}</option> --}}
                                {{-- @endforeach --}}
                                {{-- </select> --}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-row">

                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Training</b></label>
                                <input type="text" class="form-control" name="training">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Start Date</b></label>
                                <input type="date" class="form-control" name="start_date">

                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Due Date</b></label>
                                <input type="date" class="form-control" name="due_date">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Organizer</b></label>
                                <input type="text" class="form-control" name="organizer">
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Inside Outside</b></label>
                                <select class="atc form-control select2" required id="inside_outside" name="inside_outside">
                                    <option value="">- Select Status -</option>
                                    <option value="inside"> Inside </option>
                                    <option value="outside"> Outside </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Lisenced DGNED</b></label>
                                <input type="text" class="form-control" name="lisenced_dgned">
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
                                <label><b>City</b></label>
                                <select class="atc form-control select2" required id="city" name="city">
                                    <option value="">- Select City -</option>
                                    @foreach ($city as $sab)
                                        <option value="{{ $sab->id }}">{{ $sab->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Place Of Training</b></label>
                                <input type="text" class="form-control" name="place_of_training">
                            </div>
                        </div>
                        <div class="form-row rightbtn">
                            <div class="form-group col-sm-12">
                                <a style="color: white" href="{{ url('/eksportir/training') }}" class="btn btn-danger"><i
                                        style="color: white"></i>
                                    Back
                                </a>
                                <button class="btn btn-primary" type="submit">Submit
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
