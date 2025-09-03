<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>You've been unsubscribed</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('front/assets/img/logo/kemendag.png')}}">
    <link rel="stylesheet" href="{{url('assets')}}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <style type="text/css">
    	body{background-color: #f8f8fb;}
    	.card{box-shadow: 0 0 8px rgba(215,217,218);}
    	.card-title{font-weight: 600; color: #e61200; font-size: 30px; padding-bottom: 20px;}
    	.card-text{color: #7b7c82; font-size: 18px; padding-bottom: 20px;}
    </style>
</head>
<body>
	<div class="container" style="margin-top: 6%;">
		<div class="row justify-content-center"><img src="{{asset('front/assets/img/logo/logo.png')}}" alt="" width="180px"></div>
		<div class="row justify-content-center" style="margin-top: 50px;">
			<div class="card" style="width: 35rem; padding: 30px 10px 30px 10px;">
			  <div class="card-body">
			    <h3 class="card-title" align="center">{{$title}}</h3>
			    <p class="card-text" align="center">{{$body}}</p>
			    <div align="center">
			    	<a href="{{url('/contact-us')}}" class="btn btn-primary" style="width: 60%; font-size: 18px; font-weight: 600;">Contact Us</a>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</body>
</html>