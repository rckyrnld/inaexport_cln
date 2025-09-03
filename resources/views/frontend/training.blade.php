@include('frontend.layouts.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<?php
  $loc = app()->getLocale();
  if(Auth::guard('eksmp')->user() || Auth::user()){
    $for = "user";
    $message = '';
  } else {
    $for = 'non user';
      if($loc == "ch"){
        $message = "请先登录";
      }elseif($loc == "in"){
        $message = "Silahkan Login Terlebih Dahulu!";
      }else{
        $message = "Please Login to Continue!";
      }
  }

?>
<style type="text/css">
  .modal-body {background-image: url('{{url('/')}}/front/assets/img/cp/bg.png');background-size: cover;background-repeat: no-repeat;width: 100%; margin: 0px; background-color: transparent; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border-top-left-radius: 20px; border-top-right-radius: 20px; height: 380px;}
  .modal-content{ background-color: transparent; border:none; }
  .icon{ width:15%;}
  .cp-data{padding-left: 25px;color: white;font-size: 20px; font-family: arial;}
  i.mod{color: white; font-size: 24px;}
  i.mod:hover{color: red;}
  .training{color : #edf1f5;font-weight: 500; padding-left: 10px;}
  .training_topic{padding-left: 10px;font-weight: 500;font-size: 15px; }
  .btn.training{width: 100%;border-color: #2385d4;border-radius: 20px;}
  .btn.training.join{background-color: #edf1f5;color: #2385d4;}
  .btn.training.joined{background-color: #edf1f5;color: #2385d4;}
</style>
<div class="container">
  <div class="row justify-content-center" style="padding-top: 4%;">
    <div class="col-lg-10 col-md-10">
      <img src="{{asset('front/assets/img/banner list training.png')}}" width="100%">
    </div>
  </div>  
</div>

    <!--Training start-->
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="row shop_wrapper">
                      @foreach($data as $num => $val)
                        <?php
                          if($loc == "en"){
                            $location = $val->location_en;
                            $topic = $val->topic_en;
                            $training = $val->training_en;
                          } else if($loc == "in"){
                            if($val->location_in != null){
                              $location = $val->location_in;
                            } else {
                              $location = $val->location_en;
                            }

                            if($val->topic_in != null){
                              $topic = $val->topic_in;
                            }  else {
                              $topic = $val->topic_en;
                            }

                            if($val->training_in != null){
                              $training = $val->training_in;
                            }  else {
                              $training = $val->training_en;
                            }
                          } else {
                            if($val->location_chn != null){
                              $location = $val->location_chn;
                            } else {
                              $location = $val->location_en;
                            }

                            if($val->topic_chn != null){
                              $topic = $val->topic_chn;
                            }  else {
                              $topic = $val->topic_en;
                            }

                            if($val->training_chn != null){
                              $training = $val->training_chn;
                            }  else {
                              $training = $val->training_en;
                            }
                          }

                          if($val->param){
                            if($val->param == 'Days'){
                              $duration = Lang::get('training.day');
                            } else {
                              $duration = Lang::get('training.week');
                            }
                          } else {
                            $duration = '';
                          }

                          if($for == 'user'){
                            $button = '<button class="btn training join btn-info" onclick="__join(\''.getContactPerson($val->id, 'training').'\', '.$val->id.')">'.Lang::get('training.minat').'</button>';
                          } else {
                            $button = '<button class="btn training join btn-info" onclick="__join()">'.Lang::get('training.minat').'</button>';
                          }
                          $num_char = 25;
                          if(strlen($training) > 25){
                              $cut_text = substr($training, 0, $num_char);
                              if ($training[$num_char - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                  $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                  $cut_text = substr($training, 0, $new_pos);
                              }
                              $trainingName = $cut_text . '...';
                          }else{
                              $trainingName = $training;
                          }

                          $num_chart = 30;
                          if(strlen($topic) > 30){
                              $cut_text = substr($topic, 0, $num_chart);
                              if ($topic[$num_chart - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                  $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                  $cut_text = substr($topic, 0, $new_pos);
                              }
                              $topicName = $cut_text . '...';
                          }else{
                              $topicName = $topic;
                          }

                          if(strlen($location) > 30){
                              $cut_text = substr($location, 0, $num_chart);
                              if ($location[$num_chart - 1] != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                  $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                  $cut_text = substr($location, 0, $new_pos);
                              }
                              $locationName = $cut_text . '...';
                          }else{
                              $locationName = $location;
                          }

                          if(date('Y-m-d', strtotime($val->start_date)) == date('Y-m-d', strtotime($val->end_date))){
                            $tanggal = date('d M Y', strtotime($val->start_date));
                          } else if(date('Y-m', strtotime($val->start_date)) == date('Y-m', strtotime($val->end_date))){
                            $tanggal = date('d', strtotime($val->start_date)).' - '.date('d M Y', strtotime($val->end_date));
                          } else {
                            $tanggal = date('d M Y', strtotime($val->start_date)).' - '.date('d M Y', strtotime($val->end_date));
                          }
                        ?>

                        <div class="col-lg-4 col-md-4 col-12" style="padding-top: 20px;">
                          <div style="background-color: #2385d4; border-radius: 10px; vertical-align: top; height: 100%;">
                            <div class="col" style="height: 100%; padding-top: 15px;">
                              <span style="color: #edf1f5; font-weight: 600; font-size: 20px;" title="{{$training}}"><b>{{$trainingName}}</b></span><br>

                              <span class="training">
                                <i class="fa fa-bullhorn"></i>&nbsp;&nbsp;@lang("training.topic")
                              </span><br>
                              <span class="training_topic" title="{{$topic}}">
                                {{$topicName}}
                              </span>
                              <br>

                              <span class="training">
                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;@lang("training.date")
                              </span><br>
                              <span class="training_topic">
                                {{$tanggal}}
                              </span>
                              <br>

                              <span class="training">
                                <i class="fa fa-clock-o"></i>&nbsp;&nbsp;@lang("training.durasi")
                              </span><br>
                              <span class="training_topic">
                                {{$val->duration}} {{$duration}}
                              </span>
                              <br>

                              <span class="training">
                                <i class="fa fa-street-view"></i>&nbsp;&nbsp;@lang("training.lokasi")
                              </span><br>
                              <span class="training_topic" title="{{$location}}">
                                {{$locationName}}
                              </span>
                              <br><br>
                              <?php echo $button;?><br><br>
                            </div>
                          </div>
                      </div>
                      @endforeach
                    </div>
                </div>
            </div><br><br>
            <div class="row">
              <div class="container">
                <div class="row justify-content-center">
                  {{ $data->render("pagination::bootstrap-4") }}
                </div>
              </div>
            </div>
        </div>
    </div>
    <!--Training end-->

    @if($for == 'user')
    <!-- Modal Contact Person -->
    <div class="modal fade" id="modal_cp" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body" >
                  <table border="0" width="90%" align="center" height="30%">
                    <tr>
                      <td align="right"><i class="fa fa-times mod" data-dismiss="modal"></i></td>
                    </tr>
                  </table>
                  <table border="0" width="80%" align="center" style="margin-top: 10px;">
                    <tr>
                      <td class="icon" align="center"><img src="{{url('/')}}/front/assets/img/cp/nama.png" height="100%"></td>
                      <td class="cp-data" style="text-transform: capitalize;"><span id="cp_name"></span></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div style="height: 8px;">
                          <img src="{{url('/')}}/front/assets/img/cp/line.png" width="100%" height="100%" style="vertical-align: top;">
                        </div>
                      </td>
                    </tr>
                    <tr class="hide1">
                      <td class="icon" align="center"><img src="{{url('/')}}/front/assets/img/cp/phone.png" height="100%"></td>
                      <td class="cp-data"><span id="cp_phone"></span></td>
                    </tr>
                    <tr class="hide1">
                      <td colspan="2">
                        <div style="height: 8px;">
                          <img src="{{url('/')}}/front/assets/img/cp/line.png" width="100%" height="100%" style="vertical-align: top;">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="icon" align="center"><img src="{{url('/')}}/front/assets/img/cp/email.png" height="100%" height="100%"></td>
                      <td class="cp-data"><span id="cp_email"></span></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div style="height: 8px;">
                          <img src="{{url('/')}}/front/assets/img/cp/line.png" width="100%" style="vertical-align: top;">
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
            </div>
        </div>
    </div>
    @endif
@include('frontend.layouts.footer')
<script type="text/javascript">
  function __join(id, id_training){
    var login = "{{$for}}";
    if(login == 'user'){
      if(id != '-'){
        var pecah = id.split('|');
        $('#cp_name').html(pecah[0]);
        if(pecah[1] == ""){
          $('.hide1').hide();
        }else{
          // $('.hide').show();
          $('#cp_phone').html(pecah[1]);
        }
        // $('#cp_phone').html(pecah[1]);
        $('#cp_email').html(pecah[2]);
      } else {
        $('#cp_name').html('No Contact');
        $('#cp_phone').html('No Contact');
        $('#cp_email').html('No Contact');
      }
      var token = "{{ csrf_token() }}";
      var id = id_training;
      $.ajax({
          url: "{{route('training.interest')}}",
          type: 'post',
          data: {'_token':token,id:id},
          dataType: 'json'
      });
      $('#modal_cp').modal('show'); 
    } else {
      alert("{{$message}}");
    }
  }
</script>