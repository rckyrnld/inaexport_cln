<div align="center" style="width: 100%">
  <div align="center" style="width: 580px;">
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail3.png" alt="." >
    <p style="text-align: left">Dear <?php if(isset($receiver)){ echo $receiver; }else{ echo "-"; }; ?>, </P>
    <p style="text-align: left"><?php if(isset($bu)){ echo $bu; }else{ echo ""; }; ?>{{$username}} Had Joined To Your Buying Request</p>
    <hr>
    <!-- <ol>
        <ul>Name : {{$username}}</ul>
        <ul>Email : {{$email}}</ul>
    </ol>
    <hr>-->
    <p style="text-align: left">
      <!-- {{$main_messages}} -->
    </p>
    <p style="text-align: left">click <a href="{{url('/br_list')}}">Here</a>.</p>
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
  </div>
</div>