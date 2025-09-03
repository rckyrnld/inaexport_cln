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
        <p style="text-align: left">Dear {{($bu== '-')? '':$bu." "}}{{$company}},</P>
        <p style="text-align: left">There are responses that have been made by the eksporters, please look immediately.</p>
        <p style="text-align: left">To knows, please enter the Inaexport.id application with an account that is already registered.</p>
        <br>
        <p style="text-align: left">Click <a href="{{url('/front_end/history')}}" class="button">here</a></p>
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
    </div>
</div>