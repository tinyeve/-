<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>思维笔记</title>

<!--  <link href="{{asset('/css/app.css')}}" rel="stylesheet">  -->
 <link href="{{asset('/css/bootstrap.css')}}" rel="stylesheet">
<link href='//fonts.googleapis.com/css?family=Roboto:400,300'
	rel='stylesheet' type='text/css'>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">思维笔记</a>
			</div>
			<div class="collapse navbar-collapse"
				id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">首页</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if( Auth::guest() )
					<li><a href="{{ url('/webauth/login') }}">登录</a></li>
					<li><a href="{{ url('/webauth/register') }}">注册</a></li> 
					@else
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href=" {{ url('/web/index') }}">会员主页</a></li>
							<li><a href=" {{ url('/webauth/logout') }}">退出登录</a></li>
						</ul>
					</li>
					@endif

				</ul>
			</div>
		</div>
	</nav>
	@yield('content')

	<script
		src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script
		src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

	<!--         <div class="container">  -->
	<!--             <div class="content"> -->
	<!--                 <div class="title">Laravel 5</div> -->
	<!--             </div> -->
	<!--         </div> -->
</body>
</html>
