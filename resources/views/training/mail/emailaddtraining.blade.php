<style>
    .button{
        background: #8bbbe8;
        padding: 10px 12px;
        border-radius: 3px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        -webkit-transition-duration: 0.4s; /* Safari */
        transition-duration: 0.4s;
        cursor: pointer;
        color: black;
    }

    .button:hover{
        background: #afcde8;
    }
</style>
<img height="20%" width="100%" src="{{url('assets')}}/assets/images/headeremail.jpg" alt="." >
<img height="50%" width="100%" src="{{url('assets')}}/assets/images/icon isi pengumuman.jpg" alt="." >
<p style="color: #8bbbe8; font-size: 20px;">Information</p>
<hr>
<p>Yth. {{$company}},</P>
<p>Terdapat event baru dari {{$pengirim}}, apabila anda berminat silahkan meresponnya segera.</p>
<p> Untuk melihat event tersebut, silahkan login <a href="{{url('login/')}}">disini</a>.</p>
<img height="30%" width="100%" src="{{url('assets')}}/assets/images/footeremail.jpg" alt="." >