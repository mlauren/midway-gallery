<!DOCTYPE html>
<html>
	<head>
		<title>Midway{{ isset($page_title) ? ' - ' . $page_title : '' }}</title>
	    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js') }}
	    {{ HTML::script('/bower_resources/bootstrap/dist/js/bootstrap.min.js') }}

		{{ HTML::style('/bower_resources/bootstrap3-wysihtml5/lib/css/bootstrap.min.css')}}

	    {{ HTML::style('/packages/css/styles.css') }}
	    {{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}

	    {{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400') }}

	</head>
	<body>
		<div class="container">
			<header class="row">
				<div class="col-md-10">
					@include('layout.menu')
				</div>
			</header>
			@if(Session::has('global'))
				<div class="col-md-12 feedback-container">
					<div class="alert {{ Session::get('status') }}">
						{{ Session::get('global') }}
					</div>
				</div>
			@endif
			@yield('sidebar')
			@yield('content')
		</div>
		@yield('scripts')
		@include('layout.footer')
	</body>
</html>
