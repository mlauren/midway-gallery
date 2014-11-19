<!DOCTYPE html><html>  <head>    <title>Midway{{ isset($page_title) ? ' - ' . $page_title : '' }}</title>    {{ HTML::style('/bower_resources/bootstrap/dist/css/bootstrap.min.css') }}    {{ HTML::style('/bower_resources/bootstrap/dist/css/bootstrap-theme.min.css') }}    {{ HTML::style('/bower_resources/bootstrap3-wysihtml5/src/bootstrap-wysihtml5.css') }}      {{ HTML::style('/packages/css/styles.css') }}      {{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}    {{ HTML::script('/bower_resources/bootstrap3-wysihtml5/lib/js/wysihtml5-0.3.0.js') }}    {{ HTML::script('https://code.jquery.com/jquery-2.1.1.min.js') }}    {{ HTML::script('/bower_resources/bootstrap/dist/js/bootstrap.min.js') }}    {{ HTML::script('/bower_resources/bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.js') }}    {{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400') }}  </head>  <body>    <div class="container">      <div class="col-md-12">        @include('layout.navigation')        @if(Session::has('global'))          <div class="alert {{ Session::get('status') }}">            {{ Session::get('global') }}          </div>        @endif      </div>        @yield('sidebar')        @yield('content')    </div>    @yield('scripts')    @include('layout.footer')  </body></html>