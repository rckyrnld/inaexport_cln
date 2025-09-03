@include('header')
<style>
    .mycustom {
        border: solid 1px grey;
        position: relative;
    }
    .mycustom input[type=text] {
        border: none;
        width: 100%;
        margin-top: 5px;
        margin-bottom: 5px;
        padding-right: 123px;
    }
    .mycustom .input-group-prepend {
        position: absolute;
        right: 4px;
        top: 4px;
        bottom: 4px;z-index:9;
    }

    .atag:hover{
        text-decoration: underline;
    }
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-body bg-light">
                    <div class="row">
                        <div class="col-md-10">
                            <h5><b>Details Inquiry</b></h5>  
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div><br><br>
                    <div class="row">
                        <label class="col-md-3"><b>Company Name</b></label>
                        <div class="col-md-7">
                            @if($mode == "perwakilan")
                                {{getCompanyName($data->id_itdp_company_users)}}
                            @elseif($mode == "importir")
                                {{getCompanyNameImportir($inquiry->id_pembuat)}}
                            @endif
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>Product Name</b></label>
                        <div class="col-md-7">
                            {{$prodname}}
                        </div>
                    </div><br>
                    @if($inquiry->type != 'importir')
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
                                <input type="text" class="btn btn-default" value="No File" autocomplete="off" readonly style="color: orange; text-align: center;">
                            @else
                                <a href="{{ url('/').'/uploads/Inquiry/'.$inquiry->id }}/{{ $inquiry->file }}" target="_blank" class="btn btn-default" style="color: orange;">{{$inquiry->file}}</a>
                            @endif
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>Status</b></label>
                        <div class="col-md-7">
                            @if($mode == "perwakilan")
                                <?php if($data->status == 0){ $stat = 1; }else{$stat = $data->status;}?>
                            @elseif($mode == "importir")
                                <?php if($inquiry->status == 0){ $stat = 1; }else{$stat = $inquiry->status;}?>
                            @endif
                            @lang('inquiry.stat'.$stat)
                        </div>
                    </div><br><br>
                    @if($comsg != 0)
                        <div class="row">
                            <div class="col-md-12">
                                <h5><b>Detail Chat</b></h5>  
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="box" style="max-height: 400px; overflow-y: scroll;overflow-x: hidden; padding: 0px 5px 0px 5px;">
                                <br>
                                <div class="row">
                                  <?php
                                    $datenya = NULL;
                                  ?>
                                  @foreach($messages as $msg)
                                      <div class="col-md-1"></div>
                                      <div class="col-md-10">
                                        @if($datenya == NULL)
                                            <?php
                                                $datenya = date('d-m-Y', strtotime($msg->created_at));
                                            ?>
                                            <center>
                                                <i>
                                                    {{$datenya}}
                                                </i>
                                            </center><br>
                                        @else
                                            @if($datenya != date('d-m-Y', strtotime($msg->created_at)))
                                                <?php
                                                    $datenya = date('d-m-Y', strtotime($msg->created_at));
                                                ?>
                                                <center>
                                                    <i>
                                                        {{$datenya}}
                                                    </i>
                                                </center><br>
                                            @endif
                                        @endif
                                        <div class="row">
                                          <div class="col-md-10">
                                            <label class="label" style="background: #eee; border-radius:10px; width:300px; padding: 10px;">
                                                <?php
                                                    if(getCompanyName($msg->sender) != "-"){
                                                        $nama = getCompanyName($msg->sender);
                                                    }else if(getPerwakilanName($msg->sender) != "-"){
                                                        $nama = getPerwakilanName($msg->sender);
                                                    }else if(getCompanyNameImportir($msg->sender) != "-"){
                                                        $nama = getCompanyNameImportir($msg->sender);
                                                    }
                                                ?>
                                                <b>{{$nama}}</b> :<br>
                                                @if($msg->messages == NULL)
                                                    <a href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}" target="_blank" class="atag" style="color: red;">{{$msg->file}}</a><br>
                                                @else
                                                    {{$msg->messages}}<br>
                                                @endif
                                                <span style="color: #555; float: right;">{{date('H:i',strtotime($msg->created_at))}}</span>
                                            </label>
                                          </div>
                                        </div>
                                      </div><br>
                                      <div class="col-md-1"></div>
                                  @endforeach
                                </div><br>
                              </div>
                            </div>
                        </div>
                    @endif
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{url($urlnya)}}" class="btn btn-danger" style="float: right;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
