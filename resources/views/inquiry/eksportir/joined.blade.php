@include('header')
<style>
    .img_upl {
        border: 1px dashed #6fccdd;
        background: transparent;
    }
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><b>Details Inquiry</b></h5>
                </div>
                <div class="box-body bg-light">
                    <div class="row">
                        <label class="col-md-3"><b>Product Name</b></label>
                        <div class="col-md-7">
                            @if($product != NULL)
                            {{$product->prodname_en}}
                            @else
                            {{$inquiry->prodname}}
                            @endif
                        </div>
                    </div><br>
                    @if($inquiry->type == 'importir')
                        @if($product != NULL)
                        <div class="row">
                            <label class="col-md-3"><b>Category Product</b></label>
                            <div class="col-md-7">
                                <?php
                                    $cat1 = getCategoryName($product->id_csc_product, "en");
                                    $cat2 = getCategoryName($product->id_csc_product_level1, "en");
                                    $cat3 = getCategoryName($product->id_csc_product_level2, "en");

                                    if($cat1 == "-"){
                                      echo $cat1;
                                    }else{
                                      if($cat2 == "-"){
                                        echo $cat1;
                                      }else{
                                        if($cat3 == "-"){
                                          echo $cat1." > ".$cat2;
                                        }else{
                                          echo $cat1." > ".$cat2." > ".$cat3;
                                        }
                                      }
                                    }
                                  ?>
                            </div>
                        </div><br>
                        @endif
                    @else 
                        <?php $category = getProductCategoryInquiry($inquiry->id);
                            if($category != ''){
                                if($category == strip_tags($category)) {
                                    $category = substr($category, 2);
                                }
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-3">
                                <label><b>Category Product</b></label>
                            </div>
                            <div class="col-md-4">
                                <span style="text-transform: capitalize;">@if($category =='') - @else <?php echo $category?> @endif</span>
                            </div>
                        </div><br>
                    @endif
                    <div class="row">
                        <label class="col-md-3"><b>Kind Of Subject</b></label>
                        <div class="col-md-7">
                            {{$inquiry->jenis_perihal_en}}
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>Date</b></label>
                        <div class="col-md-7">
                            {{date('d F Y',strtotime($inquiry->date))}}
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>Subject</b></label>
                        <div class="col-md-7">
                            {{$inquiry->subyek_en}}
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>Messages</b></label>
                        <div class="col-md-7">
                            <?php echo $inquiry->messages_en; ?>
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>File</b></label>
                        <div class="col-md-7">
                            @if($inquiry->file == "")
                                <input type="text" class="btn btn-default" value="Dokumen Kosong" autocomplete="off" readonly style="color: orange; text-align: center;">
                            @else
                                <a href="{{ url('/').'/uploads/Inquiry/'.$inquiry->id }}/{{ $inquiry->file }}" target="_blank" class="btn btn-default" style="color: orange;">{{$inquiry->file}}</a>
                            @endif
                        </div>
                    </div><br><br>
                    <div class="row">
                        <div class="col-md-10">
                            <center>
                                <a href="{{url('/inquiry/accept_chat')}}/{{$inquiry->id}}" class="btn btn-primary" style="width: 100px; margin-right: 10px;">Join</a>
                                <a href="{{url('/inquiry')}}" class="btn btn-danger" style="width: 100px;">Cancel</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
</script>

@include('footer')
