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
<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail3.png" alt="." >
        <p style="color: #8bbbe8; font-size: 20px;text-align: left">Information</p>
        <hr>
        <p style="text-align: left">Yth. {{($bu== '-')? '':$bu." "}}{{$company}},</P>
        <p style="text-align: left">Terdapat permintaan hubungan baru dari {{$dari}}, apabila anda berminat silahkan meresponnya segera.</p>
        <P style="text-align: left">Untuk melihat permintaan hubungan dagang tersebut, silahkan login <a href="{{url('/login')}}" class="button">disini</a></P>
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
    </div>
</div>


