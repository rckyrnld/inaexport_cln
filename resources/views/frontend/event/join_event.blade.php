@include('frontend.layout.header')
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i>Trade Event</h5>
                </div>

                <div class="box-body bg-light">
                    <div class="col-md-12"><br>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="w3-content w3-display-container">
                                @if($detail->image_1 !== NULL)
                                    <img class="mySlides" src="{{url('/')}}//uploads/Event/Image/{{$detail->id}}/{{$detail->image_1}}" style="width:100%;">
                                @else
                                    <img class="mySlides" src="{{url('/')}}/image/event/NoPicture.png" style="width:100%;height: 7.5cm">
                                @endif

                                @if($detail->image_2 !== NULL)
                                    <img class="mySlides" src="{{url('/')}}//uploads/Event/Image/{{$detail->id}}/{{$detail->image_2}}" style="width:100%;">
                                @else
                                    <img class="mySlides" src="{{url('/')}}/image/event/NoPicture.png" style="width:100%;height: 7.5cm ">
                                @endif

                                @if($detail->image_3 !== NULL)
                                    <img class="mySlides" src="{{url('/')}}//uploads/Event/Image/{{$detail->id}}/{{$detail->image_3}}" style="width:100%;">
                                @else
                                    <img class="mySlides" src="{{url('/')}}/image/event/NoPicture.png" style="width:100%;height: 7.5cm ">
                                @endif

                                @if($detail->image_4 !== NULL)
                                    <img class="mySlides" src="{{url('/')}}//uploads/Event/Image/{{$detail->id}}/{{$detail->image_4}}" style="width:100%;">
                                @else
                                    <img class="mySlides" src="{{url('/')}}/image/event/NoPicture.png" style="width:100%;height: 7.5cm ">
                                @endif

                              <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
                              <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
                            </div><br>
                            <div class="w3-center">
                                <button class="btn btn-primary btn-lg">&nbsp; Join &nbsp;</button>
                            </div>
                          </div>
                          <div class="col-md-6">
                               <div style="padding-left: 3cm;">
                                    <h2><b>{{$detail->event_name_en}}</b></h2>
                                    <h5>{{getTanggalIndo($detail->start_date)}} - {{getTanggalIndo($detail->end_date)}}</h5>
                                    <h5><b>Jenis Event Comodity :</b> {{getEventComodity($detail->event_comodity)}}</h5>
                                    <h5><b>Lokasi :</b> {{getEventPlace($detail->id_event_place)}}</h5>
                                    <h5><b>Kategori Produk :</b> {{getKatagori($detail->id)}}</h5>
                                    <h5><b>Website :</b> {{$detail->website}}</h5><br>
                                    <a href="{{url('/')}}/front_end/event" class="btn btn-danger">Kembali</a>
                                </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>

@include('frontend.layout.footer')