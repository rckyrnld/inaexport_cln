<p>Dear pengguna, </P>
<p>Mohon verifikasi akun anda</p>
<p>Pengguna berikut ini telah mendaftar ke aplikasi Kemendag InaExport.id :</p>
<ol>
    <ul>Nama : {{$company}}</ul>
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

<!-- Klik <a href="{{url('verifypembeli/'.$id2)}}">disini</a> untuk aktivasi akun anda!. -->


<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{url('assets/assets/images/headeremail3.png')}}" alt="." >
        <p style="text-align: left">Dear {{$company}},</p>
       <p style="text-align: left">Terima kasih telah melakukan pendaftaran akun perusahaan anda di inaexport.</p>
       <p style="text-align: left">Silahkan <a href="{{url('/login')}}">Login</a>/<a href="{{url('/login')}}">Masuk</a> ke dalam aplikasi untuk melengkapi dokumen perusahaan (NIB dan NPWP)</p>
       <!-- <p style="text-align: left">Segera lakukan verifikasi akun tersebut dengan cara mengunggah dokumen perusahaan (NIB dan NPWP perusahaan) pada aplikasi inaexport.</p> -->
        <img height="100%" width="580px" src="{{url('assets/assets/images/footeremail3.png')}}" alt="." >
    </div>
</div>


