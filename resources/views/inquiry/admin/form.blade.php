{{-- @include('header') --}}
@extends('header2')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ url($url) }}"
                id="formnya">
                {{ csrf_field() }}
                <div class="card">
                    {{-- <div class="box-divider m-0"></div> --}}
                    {{-- <div class="box-body"> --}}
                    {{-- <br> --}}
                    {{-- <div class="row">
                                <label class="col-md-12">
                                    <h5><b>Form Inquiry</b></h5>
                                </label>
                            </div><br><br> --}}
                    <div class="card-header border-bottom">
                        <h3 class="mb-0">Form Inquiry</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label><b>Kind of Subject</b></label>
                            </div>
                            <div class="col-md-5">
                                <!-- <select class="form-control" name="kos" id="kos" required>
                                                <option value="" style="display: none;"> - Select Kind of Subject - </option>
                                                <option value="offer to sell" @if ($data != null)@if ($data->jenis_perihal_en == 'offer to sell') selected @endif @endif>Offer to Sell</option>
                                                <option value="offer to buy" @if ($data != null)@if ($data->jenis_perihal_en == 'offer to buy') selected @endif @endif>Offer to Buy</option>
                                                <option value="consultation" @if ($data != null)@if ($data->jenis_perihal_en == 'consultation') selected @endif @endif>Consultation</option>
                                            </select> -->
                                <b>Offer to Buy</b>
                                <input type="hidden" name="kos" id="kos" value="offer to buy" class="form-control"
                                    required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-2">
                                <label><b>Product Name</b></label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="prodname" name="prodname" autocomplete="off"
                                    @if ($data != null) value="{{ $data->prodname }}" @endif required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-2">
                                <label><b>Date</b></label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="dateinquiry" name="dateinquiry"
                                    autocomplete="off" @if ($data != null) value="{{ $data->date }}" @endif required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-2">
                                <label><b>Subject</b></label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="subject" name="subject" autocomplete="off"
                                    @if ($data != null) value="{{ $data->subyek_en }}" @endif required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-2">
                                <label><b>Messages</b></label>
                            </div>
                            <div class="col-md-7">
                                <textarea class="form-control" id="messages"
                                    name="messages">@if ($data != null){{ $data->messages_en }} @endif</textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-2">
                                <label><b>File</b></label>
                            </div>
                            <div class="col-md-5">
                                @if ($mode == 'add' || $mode == 'edit')
                                    <input type="file" class="form-control upload1" id="file" name="file"
                                        accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel,.ppt,.pptx,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,.pdf,application/pdf"
                                        required><br>
                                @endif
                                @if ($data != null)
                                    @if ($data->file == '')
                                        <input type="text" class="btn btn-default" value="Dokumen Kosong" autocomplete="off"
                                            readonly style="color: orange; text-align: center;">
                                    @else
                                        <a href="{{ url('/') }}/uploads/Inquiry/{{ $data->id }}/{{ $data->file }}"
                                            target="_blank" class="btn btn-default" style="color: orange;"><i
                                                class="fa fa-download"></i>&nbsp;{{ $data->file }} </a>
                                    @endif
                                @endif
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-2">
                                <label><b>Duration</b></label>
                            </div>
                            <div class="col-md-5">
                                <select class="form-control select2" name="duration" id="duration" required>
                                    <option value="" style="display: none;"> - Select Duration - </option>
                                    <option value="None" @if ($data != null) @if ($data->duration == 'None') selected @endif @endif>None</option>
                                    <option value="1 week" @if ($data != null) @if ($data->duration == '1 week') selected @endif @endif>Valid for 1 Week</option>
                                    <option value="2 weeks" @if ($data != null) @if ($data->duration == '2 weeks') selected @endif @endif>Valid for 2 Weeks</option>
                                    <!-- <option value="3 weeks" @if ($data != null) @if ($data->duration == '3 weeks') selected @endif @endif>Valid for 3 Weeks</option> -->
                                    <option value="1 month" @if ($data != null) @if ($data->duration == '1 month') selected @endif @endif>Valid for 1 Month</option>
                                    <option value="2 months" @if ($data != null) @if ($data->duration == '2 months') selected @endif @endif>Valid for 2 Months</option>
                                    <!-- <option value="3 months" @if ($data != null) @if ($data->duration == '3 months') selected @endif @endif>Valid for 3 Months</option>
                                                <option value="4 months" @if ($data != null) @if ($data->duration == '4 months') selected @endif @endif>Valid for 4 Months</option>
                                                <option value="5 months" @if ($data != null) @if ($data->duration == '5 months') selected @endif @endif>Valid for 5 Months</option> -->
                                    <option value="6 months" @if ($data != null) @if ($data->duration == '6 months') selected @endif @endif>Valid for 6 Months</option>
                                </select>
                            </div>
                        </div><br><br><br>
                        <div class="row">
                            <div class="col-md-10">
                                <div style="float: right;">
                                    <a href="{{ url('/inquiry_admin') }}" class="btn btn-danger">Cancel</a>
                                    <button type="button" class="btn btn-primary" id="btnsubmit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- </div> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $('.upload1').on('change', function(evt) {
            var size = this.files[0].size;
            if (size > 5000000) {
                //     if(size > 20000){
                $(this).val("");
                alert('image size must less than 5MB');
            } else {

            }
        })
        $(document).ready(function() {

            CKEDITOR.replace('messages');

            $('.select2').select2({
                'placeholder': '- Select Product -',
                allowClear: true,
            });

            $("#dateinquiry").flatpickr({
                allowInput: true,
                altInput: true,
                altFormat: "j F Y  ( H:i )",
                dateFormat: "Y-m-d H:i:ss",
                enableTime: true,
            });

            $('#btnsubmit').on('click', function() {
                var prodname = $('#prodname').val();
                var kos = $('#kos').val();
                var date = $('#dateinquiry').val();
                var subject = $('#subject').val();
                var messages = CKEDITOR.instances.messages.getData();
                var duration = $('#duration').val();

                if (prodname == "") {
                    alert("Product Name is empty, Please fill in!");
                } else if (kos == "") {
                    alert("Kind of Subject is empty, Please fill in!");
                } else if (date == "") {
                    alert("Date is empty, Please fill in!");
                } else if (subject == "") {
                    alert("Subject is empty, Please fill in!");
                }
                // else if(messages == ""){
                //     alert("Messages is empty, Please fill in!");
                // }
                else {
                    $('#formnya').submit();
                }
            })
        })
    </script>

    @include('footer')
@endsection
