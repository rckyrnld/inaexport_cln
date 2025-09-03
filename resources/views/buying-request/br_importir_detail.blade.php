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
    .form-control {
        font-size: 13px !important;
        height: calc(2.25rem + 8px);
        line-height: 2;
        padding: .375rem .75rem;
    }

    .select2-container--default .select2-selection--single {
        height: calc(2.25rem + 2px);
        font-size: 13px !important;
        line-height: 1.5;
        padding: .375rem .75rem;
        border-color: lightgrey;
    }

    .select2 {
        border-color: lightgrey;
    }

    .btn {
        border-radius: 3px;
    }

</style>

<!--product area start-->
<section class="product_area mb-50">
    <div class="container">
        <div class="tab-content" id="tabing-product">
            <div class="breadcrumb_content">
                <ul>
                    <li><a href="{{ url('front_end') }}">@lang("login.forms.home")</a></li>
                    <li>Edit Buying Request</li>
                </ul>
            </div>
            <div class="form-row" style="font-size:12px;">
                <!--<img style="width:100%!important;" src="{{ url('assets') }}/assets/images/07-Form-Request_01.png" alt="." >-->
                <form class="form-horizontal" method="POST" action="{{ url('br_importir_update') }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <?php 
				$pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
				foreach($pesan as $ryu){
			?>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="box-body">
                                <br><br>

                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <label><b>What product do you looking for?<font color="red"> (*)</font>
                                            </b></label>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        <input type="text" style="color:black;" value="<?php echo $ryu->subyek; ?>"
                                            name="subyek" id="subyek" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <select style="color:black;font-size:13px; " class="form-control" name="valid"
                                            id="valid">
                                            <option <?php if ($ryu->valid == '3') {
    echo 'selected';
} ?> value="3">Valid within 3 day</option>
                                            <option <?php if ($ryu->valid == '5') {
    echo 'selected';
} ?> value="5">Valid within 5 day</option>
                                            <option <?php if ($ryu->valid == '7') {
    echo 'selected';
} ?> value="7">Valid within 7 day</option>
                                            <option <?php if ($ryu->valid == '15') {
    echo 'selected';
} ?> value="15">Valid within 15 day</option>
                                            <option <?php if ($ryu->valid == '30') {
    echo 'selected';
} ?> value="30">Valid within 30 day</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <label><b>Category</b></label>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <?php // echo $ryu->id_csc_prod;
                                        $ms1 = DB::select('select id,nama_kategori_en from csc_product order by id asc');
                                        ?>
                                        <select style="color:black;" class="form-control select2" multiple
                                            name="category" id="category">
                                            <option value="">-- Select Category --</option>
                                            <?php foreach($ms1 as $val1){ ?>
                                            <option <?php
$oc = explode(',', $ryu->id_csc_prod);
if (empty($oc[0])) {
    $a1 = '';
} else {
    $a1 = $oc[0];
}
if (empty($oc[1])) {
    $a2 = '';
} else {
    $a2 = $oc[1];
}
if (empty($oc[2])) {
    $a3 = '';
} else {
    $a3 = $oc[2];
}
if (empty($oc[3])) {
    $a4 = '';
} else {
    $a4 = $oc[3];
}
if (empty($oc[4])) {
    $a5 = '';
} else {
    $a5 = $oc[4];
}

if ($a1 == $val1->id || $a2 == $val1->id || $a3 == $val1->id || $a4 == $val1->id || $a5 == $val1->id) {
    echo 'selected';
}
?> value="<?php echo $val1->id; ?>">
                                                <?php echo $val1->nama_kategori_en; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                                <div id="t2">
                                    <input type="hidden" name="t2s" id="t2s" value="0">
                                </div>
                                <div id="t3">
                                    <input type="hidden" name="t3s" id="t3s" value="0">
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <label><b>Product Specification<font color="red"> (*)</font></b></label>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <textarea style="color:black;" name="spec" id="spec"
                                            class="form-control"><?php echo $ryu->spec; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <label><b>Estimated order</b></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label><b>Targeted price (FOB)</b></label>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class="form-row">
                                            <div class="col-sm-6"><input style="color:black;" type="number"
                                                    value="<?php echo $ryu->eo; ?>" name="eo" id="eo"
                                                    class="form-control"> </div>
                                            <div class="col-sm-5"> <select style="color:black;"
                                                    class="form-control" name="neo" id="neo">
                                                    <option value="Dozen" @if ($ryu->neo == 'Dozen')selected @endif>Dozen</option>
                                                    <option value="Grams" @if ($ryu->neo == 'Grams') selected @endif>Grams</option>
                                                    <option value="Kilograms" @if ($ryu->neo == 'Kilograms') selected @endif>Kilograms
                                                    </option>
                                                    <option value="Liters" @if ($ryu->neo == 'Liters') selected @endif>Liters</option>
                                                    <option value="Meters" @if ($ryu->neo == 'Meters') selected @endif>Meters</option>
                                                    <option value="Packs" @if ($ryu->neo == 'Packs') selected @endif>Packs</option>
                                                    <option value="Pairs" @if ($ryu->neo == 'Pairs') selected @endif>Pairs</option>
                                                    <option value="Pieces" @if ($ryu->neo == 'Pieces') selected @endif>Pieces</option>
                                                    <option value="Sets" @if ($ryu->neo == 'Sets') selected @endif>Sets</option>
                                                    <option value="Tons" @if ($ryu->neo == 'Tons') selected @endif>Tons</option>
                                                    <option value="Unit" @if ($ryu->neo == 'Unit') selected @endif>Unit</option>
                                                </select></div>
                                        </div>


                                    </div>
                                    <div class="form-group col-sm-6">

                                        <div class="form-row">
                                            <div class="col-sm-7"><input style="color:black;" type="text"
                                                    value="<?php if (empty($ryu->tp)) {
                                                    } else {
                                                        echo number_format($ryu->tp, 0, ',', '.');
                                                    } ?>" name="tp" id="tp"
                                                    class="form-control amount"></div>
                                            <div class="col-sm-5 mt-2">
                                                <b style="font-size:14px">USD</b>
                                                <!-- <select style="color:black;" class="form-control" name="ntp" id="ntp">
    <option  <?php if ($ryu->ntp == 'SAR') {
    echo 'selected';
} ?> value="SAR">Arab Saudi Riyal(SAR)</option>
    <option  <?php if ($ryu->ntp == 'BND') {
    echo 'selected';
} ?> value="BND">Brunei Dollar(BND)</option>
    <option  <?php if ($ryu->ntp == 'CNY') {
    echo 'selected';
} ?> value="CNY">China Yuan(CNY)</option>
    <option  <?php if ($ryu->ntp == 'IQD') {
    echo 'selected';
} ?> value="IQD">Dinar Irak(IQD)</option>
    <option  <?php if ($ryu->ntp == 'AED') {
    echo 'selected';
} ?> value="AED">Dirham Uni Emirat Arab(AED)</option>
    <option  <?php if ($ryu->ntp == 'USD') {
    echo 'selected';
} ?> value="USD">Dollar Amerika Serikat(USD)</option>
    <option  <?php if ($ryu->ntp == 'AUD') {
    echo 'selected';
} ?> value="AUD">Dollar Australia(AUD)</option>
    <option  <?php if ($ryu->ntp == 'HKD') {
    echo 'selected';
} ?> value="HKD">Dollar Hong Kong(HKD)</option>
    <option  <?php if ($ryu->ntp == 'SGD') {
    echo 'selected';
} ?> value="SGD">Dollar Singapura(SGD)</option>
    <option  <?php if ($ryu->ntp == 'TWD') {
    echo 'selected';
} ?> value="TWD">Dollar Taiwan Baru(TWD)</option>
    <option  <?php if ($ryu->ntp == 'EUR') {
    echo 'selected';
} ?> value="EUR">Euro(EUR)</option>
    <option  <?php if ($ryu->ntp == 'PHP') {
    echo 'selected';
} ?> value="PHP">Peso Filipina(PHP)</option>
    <option  <?php if ($ryu->ntp == 'GBP') {
    echo 'selected';
} ?> value="GBP">Pound Sterling(GBP)</option>
    <option  <?php if ($ryu->ntp == 'MYR') {
    echo 'selected';
} ?> value="MYR">Ringgit Malaysia(MYR)</option>
    <option  <?php if ($ryu->ntp == 'INR') {
    echo 'selected';
} ?> value="INR">Rupee India(INR)</option>
    <option  <?php if ($ryu->ntp == 'IDR') {
    echo 'selected';
} ?> value="IDR">Rupiah Indonesia(IDR)</option>
    <option  <?php if ($ryu->ntp == 'THB') {
    echo 'selected';
} ?> value="THB">Thai Baht(THB)</option>
    <option  <?php if ($ryu->ntp == 'VND') {
    echo 'selected';
} ?> value="VND">Vietnam Dong(VND)</option>
    <option  <?php if ($ryu->ntp == 'KRW') {
    echo 'selected';
} ?> value="KRW">Won Korea(KRW)</option>
    <option  <?php if ($ryu->ntp == 'JPY') {
    echo 'selected';
} ?> value="JPY">Yen Jepang(JPY)</option>
   </select> -->
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="box-body">
                                <br><br>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <label><b>Location of delivery</b></label>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <?php
                                        $ms2 = DB::select('select id,country from mst_country order by country asc');
                                        ?>
                                        <select style="color: black;" class="form-control select2" name="country"
                                            id="country">
                                            <option value="">-- Select Country --</option>
                                            <?php foreach($ms2 as $val2){ ?>
                                            <option class="form-control" <?php if ($ryu->id_mst_country == $val2->id) {
    echo 'selected';
} ?>
                                                value="<?php echo $val2->id; ?>"><?php echo $val2->country; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        <input style="color:black;" type="text" value="<?php echo $ryu->city; ?>" name="city"
                                            id="city" class="form-control" placeholder="City/State">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        {{-- <label><b>Shipping & Payment conditions</b></label> --}}
                                    </div>
                                    <div class="form-group col-sm-12">
                                        {{-- <textarea style="color:black;" value="" name="ship" id="ship"
                                            class="form-control">{{ $ryu->shipping }}</textarea> --}}
                                    </div>

                                </div>
                                <div class="form-row">
                                    {{-- <div class="col-sm-12">
                                        <label><b>Add attachment (Relevant to a request)</b></label>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <!-- <input style="color:black;" type="file" value="" name="doc" id="doc" class="form-control" > -->
                                        <input style="color:black;" type="file" value="" name="doc" id="doc"
                                            class="form-controlz" required><br>
                                        <span>
                                            <font color="red">* accept word, excel, ppt & pdf</font>
                                        </span><br>
                                        If you want open document you upload before click <a download
                                            href="{{ asset('uploads/buy_request/' . $ryu->files) }}">This</a>
                                    </div> --}}

                                </div>



                            </div>

                        </div>



                        <div class="col-sm-12">
                            <div align="right">
                                <a href="{{ url('front_end/history') }}" class="btn btn-md btn-danger rounded"><i
                                        class="fa fa-arrow-left"></i> Back</a>
                                <a onclick="simpanbr()" class="btn btn-md btn-success rounded">
                                    <font color="white"><i class="fa fa-save"></i> Update</i>
                                </a>


                            </div>
                        </div>

                        <?php } ?>
                </form>
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
                                <center>
                                    <font color="black">
                                        <h4> Update Success ! </h4><br> You Want Broadcast Buying Request Now ?
                                    </font>
                                </center>
                            </div>
                            <div class="modal-footer" id="mf">

                                <a href="{{ url('front_end/history') }}" type="button" class="btn btn-info">Go To
                                    History List</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
                <script>
                    $('#neo').change(function() {
                        $('#fob').html('(FOB/' + $('#neo').val() + ')')
                    });

                    function simpanbr() {
                        //alert($('#category').val());
                        var formData = new FormData();

                        formData.append('subyek', $('#subyek').val());
                        formData.append('valid', $('#valid').val());
                        formData.append('category', $('#category').val());
                        formData.append('spec', $('#spec').val());
                        formData.append('eo', $('#eo').val());
                        formData.append('neo', $('#neo').val());
                        formData.append('tp', $('#tp').val());
                        formData.append('ntp', $('#ntp').val());
                        formData.append('country', $('#country').val());
                        formData.append('city', $('#city').val());
                        formData.append('ship', $('#ship').val());
                        formData.append('id_br', <?php echo $id; ?>);
                        formData.append('_token', '{{ csrf_token() }}');
                        // formData.append('image', $('input[type=file]')[0].files[0]);

                        // var token = $('meta[name="csrf-token"]').attr('content');
                        if (category == "") {
                            alert("Please complete the field !")
                        } else {

                            $.ajax({
                                type: "POST",
                                url: '{{ url('/br_importir_update') }}',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(data) {
                                    console.log(data);
                                    $('#mf').append(data);
                                },
                                error: function(data, textStatus, errorThrown) {
                                    console.log(data);

                                },
                            });



                            $("#myModal").modal("show");

                        }
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


                    $(function() {

                        $('.amount').keyup(function() {
                            $(this).val(formatAmount($(this).val()));
                        });

                    });

                    /*
                    function t1(){
                    	$('#t2').html('');
                    	$('#t3').html('');
                    	var t1 = $('#category').val();
                    	var token = $('meta[name="csrf-token"]').attr('content');
                    		$.get('{{ URL::to('ambilt2/') }}/'+t1,{_token:token},function(data){
                    			$("#t2").html(data);
                    			$("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
                    			 $('.select2').select2();
                    			
                    		 })
                    }
                    function t2(){
                    	$('#t3').html('');
                    	var t2 = $('#t2s').val();
                    	var token = $('meta[name="csrf-token"]').attr('content');
                    		$.get('{{ URL::to('ambilt3/') }}/'+t2,{_token:token},function(data){
                    			$("#t3").html(data);
                    			 $('.select2').select2();
                    			
                    		 })
                    }
                    */
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
                    $(document).ready(function() {
                        $('.select2').select2();
                    });

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



            </div>


        </div>

    </div>
    </div>
</section>
<!--product area end-->

@include('frontend.layouts.footer')
<?php $quertreject = DB::select('select * from mst_template_reject order by id asc'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();

        $('#tablebureq').DataTable({
            /* processing: true,
             serverSide: true,
             ajax: "{{ route('front.datatables.br3') }}",
             columns: [
                 {data: 'row', name: 'row'},
                 {data: 'col1', name: 'col1'},
                 {data: 'col2', name: 'col2'},
                 {data: 'col3', name: 'col3'},
                 {data: 'col4', name: 'col4'},
                 {data: 'col5', name: 'col5'},
                 {data: 'col6', name: 'col6'}
                 
             ],
             fixedColumns: true */
        });
    });
</script>
<script>
    function xy(a) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{ URL::to('ambilbroad/') }}/' + a, {
            _token: token
        }, function(data) {
            $("#isibroadcast").html(data);

        })
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
            $("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
            $('.select2').select2();

        })
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
    $(document).ready(function() {
        $('.select2').select2();
    });

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
</script>
