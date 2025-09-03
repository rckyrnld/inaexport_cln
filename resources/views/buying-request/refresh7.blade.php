<?php
                          $datenya = NULL;
                        ?>
                        @foreach($messages as $msg)
                          @if($msg->sender == $id_user)
                          <div class="col-md-12">
                            @if($datenya == NULL)
                                <?php
                                   $datenya = date('d-m-Y', strtotime($msg->created_at));
										$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
                                ?>
                                <center>
                                    <i>
										{{$fix}}
                                    </i>
                                </center><br>
                            @else
                                @if($datenya != date('d-m-Y', strtotime($msg->created_at)))
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->created_at));
										$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
                                    ?>
                                    <center>
                                        <i>
                                           {{$fix}}
                                        </i>
                                    </center><br>
                                @endif
                            @endif
                            <div class="row pull-right">
                              <div class="col-md-10">
                                <label class="label chat-me">
                                    @if($msg->file == NULL)
                                        {{$msg->messages}}<br>
                                    @else
                                        <a href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}" target="_blank" class="atag" style="color: green;">{{$msg->file}}</a><br><br>
                                        {{$msg->messages}}<br>
                                    @endif
                                    <span style="float: right;">{{date('H:i',strtotime($msg->created_at))}}</span>
                                </label>
                              </div>
                            </div>
                          </div><br>
                          @else
                          <!-- <div class="col-md-1"></div> -->
                          <div class="col-md-12">
                            @if($datenya == NULL)
                                <?php
                                    $datenya = date('d-m-Y', strtotime($msg->created_at));
									$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
									
                                ?>
                                <center>
                                    <i>
                                        {{$fix}}
                                    </i>
                                </center><br>
                            @else
                                @if($datenya != date('d-m-Y', strtotime($msg->created_at)))
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->created_at));
										$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
                                    ?>
                                    <center>
                                        <i>
                                            {{$fix}}
                                        </i>
                                    </center><br>
                                @endif
                            @endif
                            <div class="row">
                              <div class="col-md-10">
                                <label class="label chat-other">
                                    @if($msg->file == NULL)
                                        {{$msg->messages}}<br>
                                    @else
                                        <a href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}" target="_blank" class="atag" style="color: green;">{{$msg->file}}</a><br><br>
                                        {{$msg->messages}}<br>
                                    @endif
                                    <span style="color: #555; float: right;">{{date('H:i',strtotime($msg->created_at))}}</span>
                                </label>
                              </div>
                            </div>
                          </div><br>
                          <!-- <div class="col-md-1"></div> -->
                          @endif
                        @endforeach