<!DOCTYPE html>
<html>
	<head>
		<title> ~~Midway~~ </title>
	    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js') }}

		{{ HTML::script('/bower_resources/bootstrap3-wysihtml5/lib/js/wysihtml5-0.3.0.js') }}
		{{ HTML::script('/bower_resources/bootstrap3-wysihtml5/lib/js/bootstrap.min.js') }}
		{{ HTML::script('/bower_resources/bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.js') }}

		{{ HTML::style('/bower_resources/bootstrap3-wysihtml5/lib/css/bootstrap.min.css')}}
		{{ HTML::style('/bower_resources/bootstrap3-wysihtml5/src/bootstrap-wysihtml5.css') }}

	    {{ HTML::style('/packages/css/styles.css') }}
	    {{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}
	</head>
	<body>
		<div class="container">
			@include('layout.navigation')

			<div class="col-md-12">
				@if(Session::has('global'))
					<div class="alert {{ Session::get('status') }}">
						{{ Session::get('global') }}
					</div>
				@endif
			</div>
				@yield('sidebar')
				@yield('content')
		</div>
		@yield('scripts')
		@include('layout.footer')
	</body>
</html>