{{--<p>Dear user, </P>--}}
{{--<p>please verify your account</p>--}}
{{--<p>The following username and password are registered at the Ministry of Trade's InaExport.id :</p>--}}
{{--<ol>--}}
{{--    <ul>Name : {{$nama}}</ul>--}}
{{--    <ul>Email : {{$email}}</ul>--}}
{{--    <ul>Username : {{$username}}</ul>--}}
{{--    <ul>Password : {{$password}}</ul>--}}
{{--</ol>--}}



{{--@if(isset($user))--}}
{{--    <p>Don't forget to upload some required documents</p>--}}
{{--    <ul>--}}
{{--        <li>NPWP(mandatory)</li>--}}
{{--        <li>TDP(optional)</li>--}}
{{--        <li>SIUP(optional)</li>--}}
{{--        <li>NIB(mandatory)</li>--}}
{{--    </ul>--}}
{{--@endif--}}

{{--click <a href="{{url('verifypembeli/'.$id2)}}">here</a> for activation account !.--}}




<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail3.png" alt="." >
        <p style="text-align: left">Dear {{$username}},</p>
        <p style="text-align: left">There is new {{$type}} register to inaexport.id.</p>
        <p style="text-align: left">Click <a href="{{url('/admin')}}">here</a></p>
{{--        <p style="text-align: left">Click <a href="{{url('profil', 2)}}">here</a> to check the new user</p>--}}
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
    </div>
</div>


