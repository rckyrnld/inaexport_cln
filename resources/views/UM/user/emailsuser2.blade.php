<p>Dear user, </P>
<p>please verify your account</p>
<p>The following username and password are registered at the Ministry of Trade's InaExport.id :</p>
<ol>
    <ul>Name : {{$company}}</ul>
    <ul>Email : {{$email}}</ul>
    {{--<ul>Username : {{$username}}</ul>--}}
    {{--<ul>Password : {{$password}}</ul>--}}
</ol>



{{--@if(isset($user))--}}
{{--    <p>Don't forget to upload some required documents</p>--}}
{{--    <ul>--}}
{{--        <li>NPWP(mandatory)</li>--}}
{{--        <li>TDP(optional)</li>--}}
{{--        <li>SIUP(optional)</li>--}}
{{--        <li>NIB(mandatory)</li>--}}
{{--    </ul>--}}
{{--@endif--}}

click <a href="{{url('verifypembeli/'.$id2)}}">here</a> for activation account !.


<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{url('assets/assets/images/headeremail3.png')}}" alt="." >
        <p style="text-align: left">Dear {{$company}},</p>
        <p style="text-align: left">Thank you for registering your company account at inaexport.</p>
{{--        <p style="text-align: left">Terima kasih telah melakukan pendaftaran akun perusahaan anda di inaexport.</p>--}}
{{--        <p style="text-align: left">Segera verifikasi akun tersebut dengan cara mengunggah dokumen perusahaan (SIUP, NIB dan NPWP perusahaan) pada aplikasi inaexport.</p>--}}
        <img height="100%" width="580px" src="{{url('assets/assets/images/headeremail3.png')}}" alt="." >
    </div>
</div>


