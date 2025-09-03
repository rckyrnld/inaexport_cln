@include('frontend.layouts.header')


<!--slider area start-->
<?php
$loc = app()->getLocale();
if ($loc == 'ch') {
    $lct = 'chn';
} elseif ($loc == 'in') {
    $lct = 'in';
} else {
    $lct = 'en';
}
?>
<style>
    .select-dropdown {
        position: static;
    }

    .select-dropdown .select-dropdown--above {
        margin-top: 336px;
    }

    #select2-country-results {
        font-size: 11px !important;
    }

    #select2-category-results {
        font-size: 11px !important;
    }

    .select2-container--default {
        width: 100% !important;
    }

    .select2-search__field {
        font-size: 10.5px !important;
    }

    #select2-t2s-results {
        font-size: 11px !important;
    }

    #select2-t3s-results {
        font-size: 11px !important;
    }

    .modal {
        overflow-y: auto !important;
    }

    .loader {
        position: fixed;
        left: 50%;
        top: 50%;
        z-index: 3;
        width: 120px;
        height: 120px;
        margin: -76px 0 0 -76px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    .grey_loading {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: grey;
        z-index: 2;
        opacity: 0.5;
    }

    .select2-container,
    .select2-dropdown,
    .select2-search,
    .select2-results {
        -webkit-transition: none !important;
        -moz-transition: none !important;
        -ms-transition: none !important;
        -o-transition: none !important;
        transition: none !important;
    }

</style>
<!--product area start-->
<div id='grey_loading' class="grey_loading" tabindex="1" style="display: none;"></div>
<div id='loader' class="loader" style="display: none;"></div>

<!-- Select Category -->
<div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="catModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="catModalLabel">Click Here to Select Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-sm-4">
                        <div class="col-sm-12">
                            <label><b>@lang("login.forms.by3") (<font color="red">*</font>)</b></label>
                        </div>
                        
                        <div class="form-group col-sm-12" style="font-size: 12px !important;">
                            <?php
                            $ms1 = DB::select('select id,nama_kategori_en from csc_product where level_1 = 0 and level_2 = 0 order by nama_kategori_en asc');
                            ?>
                            <select style="color:black;font-size: 12px !important; " size="13" class="column J-noselect"
                                name="category[]" id="category" onchange="t1()" required form="form_br">
                                {{-- <option value="">@lang("login.forms.by11")</option> --}}
                                <?php foreach($ms1 as $val1){ ?>
                                <option value="<?php echo $val1->id; ?>"><?php echo $val1->nama_kategori_en; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="t2">
                            <input type="hidden" name="t2s" id="t2s" value="0" form="form_br">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="t3">
                            <input type="hidden" name="t3s" id="t3s" value="0" form="form_br">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary mr-auto rounded" data-dismiss="modal">Confirm</button>
            </div>
        </div>
    </div>
</div>

<section class="product_area mb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <br>
                </div>

            </div>
        </div>

        <div class="tab-content" id="tabing-product">
            <div class="breadcrumb_content">
                <ul>
                    <li><a href="{{ url('') }}">@lang("login.forms.home")</a></li>
                    <li>@lang("login.forms.br")</li>
                </ul>
            </div>
            <div class="form-row" style="font-size:12px;">

                <div class="col-md-6">
                    <div class="box-body">
                        <br>
                        <img width="100%" height="10px" src="{{ url('assets') }}/assets/images/07-Form-Request_01.png">
                        <div style="font-size:17px;padding-left:10px;padding-right:10px;">
                            <p><b>@lang("login.lbl5")</b>
                            </p>
                            <p style="font-size:16px;">@lang("login.lbl6") <br> @lang("login.lbl7")
                                <br> @lang("login.lbl8")
                            </p>
                        </div>
                    </div>

                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-5">


                    <div class="box-body" style="color:black; font-size:13px;">
                        <br>

                        <form class="form-horizontal" method="POST" action="{{ url('br_importir_save_new') }}"
                            enctype="multipart/form-data" id="form_br" onsubmit="return mySubmitFunction()">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label>
                                        <h5><b>@lang("login.forms.by1")</b></h5>
                                    </label>
                                </div>
                                <div class="col-sm-12">
                                    <label>
                                        <h5 style="text-transform: uppercase;"><b>{{$get_perusahaan->company}},{{$get_perusahaan->badanusaha}}</b></h5>
                                    </label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by2") (<font color="red">*</font>)</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <input type="text" style="color:black;font-size:12px;" value="{{ $subyek }}"
                                        name="subyek" id="subyek" class="form-control">
                                </div>
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by3") (<font color="red">*</font>)</b></label> :
                                    {{-- <select name="category" id="category" class="form-input select span16 J-noselect" cz-css="form-inline span16">
                                        <option class="option" value="unselect" style="display: none; color: menutext;">Please select</option><option value="nhpasQEVtmJx">Construction &amp; Decoration»Building Glass»Tempered Glass</option>
                                        <option class="option" value="unfind" style="color: menutext;">Don't find? Choose my category.</option>
                                    </select> --}}
                                    {{-- <a data-toggle="modal" data-target="#catModal" id="labelcat" href="#">
                                        Click Here to Select Category
                                    </a> --}}
                                </div>
                                <div class="col-sm-12">
                                    <a data-toggle="modal" data-target="#catModal" id="labelcat" href="#">
                                        Click Here to Select Category
                                    </a>
                                    <input type="hidden" name="val_category" id="val_category" value="">
                                    <input type="hidden" name="gabungan" id="gabungan" value="">
                                    <input type="hidden" name="gabungan2" id="gabungan2">
                                </div>
                                <br><br>
                            </div>
                            <br />
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by4") (<font color="red">*</font>)</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <textarea style="color:black;font-size:12px;" name="spec" id="spec"
                                        class="form-control">{{ $spec }}</textarea>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-5">
                                    <label><b>@lang("login.forms.by5")</b></label>
                                </div>
                                <div class="col-sm-5">
                                    <label><b>@lang("login.forms.by15")</b></label>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="form-row">
                                        <div class="col-sm-5">
                                            <input style="color:black;font-size:12px; height:46px;" value="{{ $eo }}"
                                                type="text" name="eo" id="eo" class="form-control order">
                                        </div>
                                        <div class="col-sm-5">
                                            <select class="form-control" style="font-size:12px;height: 31px;"
                                                name="neo" id="neo">
                                                <option value="">@lang("login.forms.by14")</option>

                                                <option value="Dozen" @if ($neo == 'Dozen') selected @endif>Dozen</option>
                                                <option value="Grams" @if ($neo == 'Grams') selected @endif>Grams</option>
                                                <option value="Kilograms" @if ($neo == 'Kilograms') selected @endif>Kilograms</option>
                                                <option value="Liters" @if ($neo == 'Liters') selected @endif>Liters</option>
                                                <option value="Meters" @if ($neo == 'Meters') selected @endif>Meters</option>
                                                <option value="Packs" @if ($neo == 'Packs') selected @endif>Packs</option>
                                                <option value="Pairs" @if ($neo == 'Pairs') selected @endif>Pairs</option>
                                                <option value="Pieces" @if ($neo == 'Pieces') selected @endif>Pieces</option>
                                                <option value="Sets" @if ($neo == 'Sets') selected @endif>Sets</option>
                                                <option value="Tons" @if ($neo == 'Tons') selected @endif>Tons</option>
                                                <option value="Unit" @if ($neo == 'Unit') selected @endif>Unit</option>

                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by6") <span id="fob">(FOB /
                                                {{ $neo }})</span></b></label>
                                </div>
                                <div class="form-group col-sm-12">

                                    <div class="form-row">
                                        <div class="col-sm-5"><input style="color:black;font-size:12px;height: 46px;"
                                                type="text" value="<?php if (empty($tp)) {
} else {
    echo number_format($tp, 0, ',', '.');
} ?>" name="tp" id="tp"
                                                class="form-control amount">
                                        </div>
                                        <div class="col-sm-5"><label><b>USD</b></label>
                                            <select style="font-size:12px;height: 31px;" class="form-control d-none"
                                                disabled name="ntp" id="ntp">
                                                <option value="USD" selected>Dollar Amerika Serikat(USD)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by7") (<font color="red">*</font>)</b></label>
                                </div>
                                
                                <div class="form-group col-sm-6" style="font-size: 12px !important;">
                                    <?php
                                    $ms2 = DB::select('select id,country from mst_country order by country asc');
                                    ?>
                                    <select style="color:black;font-size:12px;height: 40px;"
                                        style="border-color: rgba(120, 130, 140, 0.5)!important; border-radius: 0.25rem!important; color: inherit!important; font-size: 12px!important;"
                                        class="form-control select2" name="country" id="country" required>
                                        <option value="">@lang("login.forms.by12")</option>
                                        @foreach($country as $data)
                                        <option value="{{ $data->id }}" @if ($data->id == $profile->country) selected @endif>
                                                                {{ $data->country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input style="color:black;font-size:12px;height:46px;" type="text" value="" name="city"
                                        id="city" class="form-control" placeholder="City / State">
                                </div>
                            </div>
                            <div class="form-row">
                                {{-- <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by8")</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <textarea style="color:black;font-size:12px;" value="" name="ship" id="ship"
                                        class="form-control"></textarea>
                                </div> --}}
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by10_2") (<font color="red">*</font>)</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <select style="color:black;font-size:12px;height: 31px;" class="form-control"
                                        name="valid" id="valid" required>
                                        {{-- <option value="">@lang("login.forms.by10")</option> --}}
                                        {{-- <option value="0" @if ($valid == 0) selected @endif>None</option> --}}
                                        {{-- <option value="1" @if ($valid == 1) selected @endif>Valid within 1 day</option> --}}
                                        <option value="3" @if ($valid == 3) selected @endif>Valid within 3 day</option>
                                        <option value="5" @if ($valid == 5) selected @endif>Valid within 5 day</option>
                                        <option value="7" @if ($valid == 7) selected @endif>Valid within 7 day</option>
                                        <option value="15" @if ($valid == 15) selected @endif>Valid within 15 days</option>
                                        <option value="30" @if ($valid == 30) selected @endif>Valid within 30 days</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-now">
                            <div class="col-sm-12">
                                <div class="checkbox">
                                    <br/>
                                    <p>To further increase the inquiry response rate, this information can also be addressed to all Inaexport members</p>
                                    <input class="eksportir" name="publish" type="checkbox" id="publish" value="true">
                                    <label for="publish">I agree, this inquiry reply by others members of inaexport</label>
                                </div>
                            </div>
                        </div>
                            <div class="">
                        <center>
                            <a href="{{ url('/supliers') }}" class="btn btn-danger"><i
                                    class="fa fa-arrow-left"
                                    aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.cancel')</a>
                            <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-paper-plane"
                                    aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.submit')</button>
                        </center>
                    </div>
                        </form>
                    </div>
                </div>


                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#2e899e; color:white;">
                                <h6>Broadcast
                                    Buying Request</h6>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>

                            </div>
                            <div id="isibroadcast"></div>
                            <div class="modal-body">
                                <font color="black"> You Want Broadcast Buying Request Now ?</font>
                            </div>
                            <div class="modal-footer" id="mf">

                                <a href="{{ url('front_end/history') }}" type="button" class="btn btn-info">Go To
                                    History List</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal" id="myModal2" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#2e899e; color:white;">
                                <h6>Broadcast Buying Request</h6>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div id="isibroadcast2"></div>
                            <!--<div class="modal-body">
                        1
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div> -->
                        </div>
                    </div>
                </div>
                <!--<a href="{{ url('br_importir_add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add Buying Request</a><br><br> -->

            </div>

        </div>
    </div>
</section>
<!--product area end-->

@include('frontend.layouts.footer')
<?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $('.order').inputmask({
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
    var checkbuttonbroadcast = 0;

    function simpanbr() {
        var formData = new FormData();

        // formData.append('subyek', $('#subyek').val());
        // formData.append('valid', $('#valid').val());
        // formData.append('category', $('#category').val());
        // formData.append('t2s', $('#t2s').val());
        // formData.append('t3s', $('#t3s').val());
        // formData.append('spec', $('#spec').val());
        // formData.append('eo', $('#eo').val());
        // formData.append('neo', $('#neo').val());
        // formData.append('tp', $('#tp').val());
        // formData.append('ntp', $('#ntp').val());
        // formData.append('country', $('#country').val());
        // formData.append('city', $('#city').val());
        // formData.append('ship', $('#ship').val());
        // formData.append('_token', '{{ csrf_token() }}');
        // formData.append('image', $('input[type=file]')[0].files[0]);
        // var token = $('meta[name="csrf-token"]').attr('content');
        if (document.getElementById("val_category").value != 1) {
            alert("Please Select at least 1 Category")
            return false;
        }
        
        $("#myModal2").modal("show");
        yz({
            category: $('#category').val(),
            sub_category_1: $('#t2s').val(),
            sub_category_2: $('#t3s').val(),
            subyek: $('#subyek').val(),
        });
            // $.ajax({
            //     type: "POST",
            //     url: '{{ url('/br_importir_save') }}',
            //     data: formData,
            //     contentType: false,
            //     processData: false,
            //     beforeSend: function() {
            //         $("#grey_loading").show();
            //         $("#loader").show();
            //     },
            //     success: function(data) {
            //         // if(checkbuttonbroadcast < 1){
            //         //     $('#mf').append(data);
            //         //     checkbuttonbroadcast = 1;
            //         // }else{
            //         //     console.log('gak ditambah lagi');
            //         // }
            //         yz(data);
            //     },
            //     complete: function(data) {
            //         $("#grey_loading").hide();
            //         $("#loader").hide();
            //         console.log("complete");
            //     },
            //     error: function(data, textStatus, errorThrown) {
            //         console.log(data);

            //     },
            // });



            // // $("#myModal").modal("show"); 
        }

    function formatAmountNoDecimals(number) {
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(number)) {
            number = number.replace(rgx, '$1' + '.' + '$2');
        }
        return number;
    }

    function formatAmount(number) {

        // remove all the characters except the numeric values
        number = number.replace(/[^0-9]/g, '');

        // set the default value
        if (number.length == 0) number = "0.00";
        else if (number.length == 1) number = "0.0" + number;
        else if (number.length == 2) number = "0." + number;
        else number = number.substring(0, number.length - 2) + '.' + number.substring(number.length - 2, number.length);

        // set the precision
        number = new Number(number);
        number = number.toFixed(2); // only works with the "."

        // change the splitter to ","
        number = number.replace(/\./g, '');

        // format the amount
        x = number.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';

        return formatAmountNoDecimals(x1) + x2;
    }


    var dataeksportir = [];

    function calldata() {
        var id = $('#id_laporan').val();
        $.ajax({
                method: "POST",
                url: "{!! url('getdatapiliheksportir') !!}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_laporan: id
                }
            })
            .done(function(data) {
                $.each(data, function(i, val) {
                    $param = 1;
                    $('#tabelpiliheksportir').DataTable().row.add(['<a href=' +
                        "{{ url('perusahaan/') }}/" + val.id + ' target="_blank">' + val.company +
                        '</a>',
                        '<center><div class="checkbox"><input class="eksportir" name="eksportir" type="checkbox" value="' +
                        val.id + '"></div></center>'
                    ]).draw();

                    // $('#tabelpiliheksportir').DataTable().row.add([val.company]).draw();
                });
            });


    }


    function savecheckall() {
        $.each($("input[name='eksportir']:checked"), function() {
            val = $(this).val();
            if (dataeksportir.includes(val)) {} else {
                $('input:checkbox[value=' + val + ']').attr('disabled', true)
                dataeksportir.push($(this).val());
            }
        });
        $("input[name='checkall']").prop('checked', false);
    }

    function broadcast() {
        var id = $('#id_buyingrequest').val();
        var publish = $('#publish').prop("checked");

        var formData = new FormData();

        formData.append('subyek', $('#subyek').val());
        formData.append('valid', $('#valid').val());
        formData.append('category', $('#category').val());
        formData.append('t2s', $('#t2s').val());
        formData.append('t3s', $('#t3s').val());
        formData.append('spec', $('#spec').val());
        formData.append('eo', $('#eo').val());
        formData.append('neo', $('#neo').val());
        formData.append('tp', $('#tp').val());
        formData.append('ntp', $('#ntp').val());
        formData.append('country', $('#country').val());
        formData.append('city', $('#city').val());
        formData.append('ship', $('#ship').val());
        formData.append('publish', $('#publish').val());
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('image', $('input[type=file]')[0].files[0]);

        var dataeksportir = [];
        // dataTable.rows().nodes().to$().find('input[name="eksportir"]').each(function(){
        //     dataeksportir.push($(this).val());
        // })
        $.each($("input[name='eksportir']:checked"), function() {
            var val = $(this).val();
            if (dataeksportir.includes(val)) {} else {
                dataeksportir.push($(this).val());
            }
        });
        var form_data = new FormData();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}'
            }
        });
        let id_csc_buying_request;
        $.ajax({
            type: "POST",
            url: '{{ url('/br_importir_save') }}',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $("#grey_loading").show();
                $("#loader").show();
            },
            success: function(data) {
                // if(checkbuttonbroadcast < 1){
                //     $('#mf').append(data);
                //     checkbuttonbroadcast = 1;
                // }else{
                //     console.log('gak ditambah lagi');
                // }
                form_data.append('dataeksportir', dataeksportir);
                form_data.append('publish', publish)
                form_data.append('id', data);

                $.ajax({
                        method: "POST",
                        url: "{{ route('broadcastbuyingrequest.imp') }}",
                        data: form_data,
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        error: function(){
                            window.location = '{{ url('front_end/history') }}';
                        }
                    })
                    .done(function(e) {
                        window.location = '{{ url('front_end/history') }}';
                        // window.location = '{{ url('/br_list') }}';
                    });

            },
            complete: function(data) {
                $("#grey_loading").hide();
                $("#loader").hide();
                console.log("complete");
            },
            error: function(data, textStatus, errorThrown) {
                console.log(data);

            },
        });
    }
    // var checkedValue = $('.eksportirterpilih:checked').val();
    function isEmptyM(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }


    $(function() {
        $("#tabelpiliheksportir").DataTable({
            processing: true,
            orderable: false,
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan MENU entri",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                info: "Menampilkan START sampai END dari TOTAL entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari MAX entri keseluruhan)",
                infoPostFix: "",
                search: "Cari:",
                url: "",
                infoThousands: ".",
                loadingRecords: "Sedang memproses...",
                paginate: {
                    first: "<<",
                    last: ">>",
                    next: "Selanjutnya",
                    previous: "Sebelum"
                },
                aria: {
                    sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                    sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                }
            }
        });

    });
</script>
<script type="text/javascript">
    function buk() {
        if (confirm('You Must Login First !')) {
            window.location.href = "{{ URL::to('/login') }}";
        } else {}
        // alert('You Need Login as Importir !');
    }

    function bak() {
        if (confirm('You Must Login First !')) {
            window.location.href = "{{ URL::to('/login') }}";
        } else {}
        {{-- alert('You Must Login First ! <a href="{{URL::to('/login')}}">Go to Login Page</a>'); --}}
        {{-- window.location.href = "{{URL::to('restaurants/20')}}" --}}
    }

    $(document).ready(function() {
        $('.select2').select2({
            dropdownPosition: 'below'
        });

    });
</script>
<script>
    function catLabel() {
        var text = 'Select Category';
        var category = $('#category option:selected').text();
        if (category != '') {
            text = category;
            document.getElementById("val_category").value = 1;
            var cat1 = $('#t2s option:selected').text();
            if (cat1 != '') {
                text += ' » ' + cat1;
            }
            var cat2 = $('#t3s option:selected').text();
            if (cat2 != '') {
                text += ' » ' + cat2;
            }
        }
        $('#labelcat').html(text);
    }

    function xy(a) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilbroad/') }}/' + a, {
            _token: token
        }, function(data) {
            $("#isibroadcast").html(data);

        })
        $('.cobas2').select2();
    }

    function yz(a) {

        console.log(a);
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilbroad2') }}/?category=' + a.category + '&sub_category_1=' + a.sub_category_1 +
            '&sub_category_2=' + a.sub_category_2 + '&subyek=' + a.subyek + '', {
                _token: token
            },
            function(data) {
                $("#isibroadcast2").html(data);
                calldata();

            })

        $("#myModal").modal("hide");
        $("#myModal2").modal("show");

    }

    function t1() {
        $('#t2').html('');
        $('#t3').html('');
        var t1 = $('#category').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilt2/') }}/' + t1, {
            _token: token
        }, function(data) {
            $("#t2").html(data);
            $("#t3").html(
                '<input type="hidden" name="t3s" id="t3s" value="0" size="13" class="column J-noselect">');
            $('.select2').select2();
        })
        document.getElementById("gabungan2").value = t1 ;
        catLabel();
    }

    function t2() {
        $('#t3').html('');
        var t2 = $('#t2s').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilt3/') }}/' + t2, {
            _token: token
        }, function(data) {
            $("#t3").html(data);
            $('.select2').select2();
        })
        document.getElementById("gabungan").value = t2;
        // console.log(t2);
        catLabel()
    }

    function t3() {
        catLabel();
    }

    function nv() {
        var a = $('#staim').val();
        if (a == 2) {
            $('#sh1').html(
                '<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id; ?>"><?php echo $qr->nama_template; ?></option><?php } ?></select></div></div>'
                )
        } else {
            $('#sh1').html(' ');
            $('#sh2').html(' ');
        }
    }

    function ketv() {
        var a = $('#template_reject').val();
        if (a == 1) {
            $('#sh2').html(
                '<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>'
                )
        }
    }

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<script type="text/javascript">
    // $(document).ready(function () {

    // })

    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#' + tabname).addClass('active');
    }

    $('#neo').change(function() {
        $('#fob').html('(FOB/' + $('#neo').val() + ')')
    });
</script>
