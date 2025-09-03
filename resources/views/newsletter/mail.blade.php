<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		a { text-decoration: none; }
		body { font-family: 'Arial'; }
		#messages { font-size: 16px; }
		img.g-img + div { display:none; }
	</style>
</head>
<body>
	<div style="margin: 0% 18% 0% 18%;">
		<a href="{{url('/')}}" target="_blank"><img src="{{url('/').'/assets/assets/images/headeremail3.png'}}" style="width: 100%;" alt="."></a><br>
		<h2 style="color: skyblue;">Information</h2><hr>
		<span id="messages">
			<?php echo $messages; ?>
		</span>
		@if($file != null)
			<center><img class="g-img" src="{{url('/').'/uploads/Newsletter/File/'.$file}}" style="width: 100%;" alt="."></center>
		@endif
		<br>
		<center>Anda mendapat email ini karena terdaftar sebagai <b>newsletter</b> kami.</center><br>
		<center><a href="{{route('newsletter.unsubscribe',$email_unsub)}}" style="font-weight: 600;" target="_blank"><span style="color: red;">Unsubscribe</span> <span style="color: blue;">newsletter</span></a></center>
		<a href="#" style="cursor: default;"><img src="{{url('/').'/assets/assets/images/footeremail3.png'}}" style="width: 100%; margin-top: 10px;" alt="."></a>
	</div>
</body>
</html>