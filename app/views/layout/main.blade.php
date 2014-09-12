<!DOCTYPE html>
<html>
	<head>
		<title>Authentication System</title>
		{{ HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css')}}
	    {{ HTML::style('css/main.css')}}
	    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js') }}
	    {{ HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
	</head>
	<body>
		<div class="container">
			@include('layout.navigation')

			@if(Session::has('global'))
					{{ Session::get('global') }}
			@endif

			<div class="col-md-8">
				@yield('content')
			</div>
		</div>
	</body>
</html>