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
            height: 45px !important;
        }

        input.input-error {
            color: #ff0000;
            border: 1px solid #ff0000;
            box-shadow: 0 0 5px #ff0000;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Form Tambah Bahan Baku</h3>
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
                                <label><b>Year</b></label>
                                <select class="atc form-control select2" required id="year" name="year">
                                    <option value="">- Select Years -</option>
                                    @foreach ($years as $sa)
                                        <option value="{{ $sa }}">{{ $sa }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Domestic (%)</b></label>
                                <input onkeyup="sum();" type="text"
                                    class="form-control amount" max="100" name="domestic" id="domestic">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Overseas (%)</b></label>
                                <input id="overseas" type="text"
                                    class="form-control amount" name="overseas" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3 mb-2">
                                <label><b>Value From Domestic</b></label>
                                <input type="text"
                                    class="form-control rupiah" name="valuefromdomestic">
                            </div>
                        </div>
                        <div class="form-row rightbtn">
                            <div class="form-group col-sm-12">
                                <a style="color: white" href="{{ url('/eksportir/rawmaterial ') }}"
                                    class="btn btn-danger"><i style="color: white"></i>
                                    Back
                                </a>
                                <button class="btn btn-primary" id="btnSubmit" type="submit">Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


@include('footer')

<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>

    $('.rupiah').inputmask({
        alias: "decimal",
        digits: 0,
        repeat: 36,
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

     $('.amount').inputmask({
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


    function sum() {
      var txtFirstNumberValue = $('#domestic').val().replace(',','.');
      var result = 100 - txtFirstNumberValue;
      console.log(result);
      if (!isNaN(result)) {
         $('#overseas').val(result.toString().replace('.', ','));
      }
}

    $("#domestic").keyup(function(){
        var domestic = $('#domestic').val().replace(',','.');
        var max = 100;
        if(domestic > max){
            $('#domestic').addClass('input-error');
            $("#btnSubmit").attr("type","button");
            $("#btnSubmit").attr("onclick","notifAkert()");
        }else{
            $('#domestic').removeClass('input-error');
            $("#btnSubmit").attr("type","submit");
            $("#btnSubmit").attr("onclick","");
        }
    })

    function notifAkert(){
        alert('Domestic Melebihi 100');
    }

    $('#valuefromdomestic').val(result.toString().replace('.', ','));

// window.onload = function () {
//     var textbox = document.getElementById("domestic");
//     var maxVal = 100;
    
//     addEvent(textbox, "keyup", function () {
//         var thisVal = +this.value;
//         this.className = this.className.replace(" input-error ", "");
//         if (isNaN(thisVal) || thisVal > maxVal) {
//             this.className += " input-error ";
//             $("#btnSubmit").attr("type","button");
//             $("#btnSubmit").attr("onclick","notifAkert()");
//         }else{
//             $("#btnSubmit").attr("type","submit");
//             $("#btnSubmit").attr("onclick","");
//         }
//     });
// }; 

function addEvent(element, event, callback) {
    if (element.addEventListener) {
        element.addEventListener(event, callback, false);
    } else if (element.attachEvent) {
        element.attachEvent("on" + event, callback);
    } else {
        element["on" + event] = callback;
    }
}
</script>

@endsection

