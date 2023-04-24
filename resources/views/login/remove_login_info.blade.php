<!DOCTYPE html>
	<head>
		 @if(env('HIDE_FLAG') == "external")
		      <title>Adani Student</title>
		      <link rel="icon" type="image/png" href="{{ env('LOGIN_BRAND_LOGO_FEVICON') }}" />
		  @else
		      <title>IEUK Student</title>
		      <link rel="icon" type="image/png" href="{{ asset('public/images/favicon.png') }}" />
		  @endif
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="{{ asset('public/css/base.css') }}">
		<link rel="stylesheet" href="{{ asset('public/css/main.css') }}">    
	</head>
	<body>
		<div id="content-wrap">
			<main class="row">
				<header class="site-header">
					<div class="logo">
						<img src="{{ url('public/images/image.png') }}" width="500px">
					</div> 
				</header>
				<div class="twelve columns">
					<h1>Your session has now expired.</h1>
					<p>To access the content close this tab and return to the course page and login again.</p>
					<hr>
				</div>
			</main>
		</div>
	</body>
</html>