{{--<p>Dear Admin, </P>--}}
{{--<p>You Had Created Ticketing</p>--}}
{{--<hr>--}}
{{--<ol>--}}
{{--    <ul>Name : {{$username}}</ul>--}}
{{--    <ul>Email : {{$email}}</ul>--}}
{{--</ol>--}}
{{--<hr>--}}
{{--<p>--}}
{{--  {{$main_messages}}--}}
{{--</p>--}}
{{--<hr>--}}
{{--click <a href="{{url('front_end/ticketing_support/view', $id)}}">Here</a>.--}}

<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail3.png" alt="." >
        <p style="text-align: left;">Yth.{{($bu== '-')? '':$bu}} {{$company}},</p>

        <p style="text-align: left;">Terima kasih menggunakan layanan Ticketing inaexport. Nomor tiket anda adalah {{$ticketing}}</p>
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
    </div>
</div>