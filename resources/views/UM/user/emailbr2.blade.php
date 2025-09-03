{{--<p>{{$nama}} was created Buy Request</p>--}}
<!-- <ol>
    <ul>Name : {{$nama}}</ul>
    <ul>Username : {{$username}}</ul>
    <ul>Password : {{$password}}</ul>
</ol> -->
<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail3.png" alt="." >
        <p style="text-align: left">Yth. {{($bu== '-')? '':$bu." "}}{{$company}},</P>
        <p style="text-align: left">Terdapat buying request baru dari {{($bur== '-')? '':$bur." "}}{{$nama}}, apabila anda berminat silahkan meresponnya segera.</p>
        <p style="text-align: left"> Untuk melihat buying request tersebut, silahkan login <a href="{{url('br_list/')}}">disini</a>.</p>
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
    </div>
</div>