<div align="center" style="width: 100%">
  <div align="center" style="width: 580px;">
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail3.png" alt="." >
    <p style="text-align: left">Dear {{$receiver}}, </P>
    <p style="text-align: left">{{($bu== '-')? '': $bu." "}}{{$username}} Respond Chat On Buying Request</p>
    <hr>
    <p style="text-align: left">click <a href="{{url('br_pw_chat', $id)}}">Here</a>.</p>
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
  </div>
</div>
