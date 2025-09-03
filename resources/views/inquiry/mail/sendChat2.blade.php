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
        <p style="text-align: left">Dear {{$receiver}}, </P>
        <p style="text-align: left">{{($bu== '-')? '': $bu." "}}{{$sender}} Respond Chat on Your Inquiry</p>
    <!-- <ol>
            <ul>Name : {{$username}}</ul>
            <ul>Email : {{$email}}</ul>
        </ol>
        <hr>-->
{{--        <p style="text-align: left">--}}
{{--            {{$main_messages}}--}}
{{--        </p>--}}

{{--        <hr>--}}
        <p style="text-align: left;">click <a href="{{url('inquiry/chatting', $id)}}">Here</a>.</p>
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
    </div>
</div>

