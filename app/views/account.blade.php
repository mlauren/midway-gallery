@extends('layout.backend')

@section('content')
	@if(Auth::check())
		<h2 class="col-md-12"><small>Hello, {{ Auth::user()->username }}.</small></h2>
		<div class="col-md-4">
			@include('layout.sidebar')
		</div>
		<div class="col-md-4">
			@include('layout.sidebar-artists-edit')
		</div>
		<div class="col-md-4">
			@include('layout.sidebar-news-edit')
		</div>
		<div class="col-md-4">
			@include('layout.sidebar-events-edit')
		</div>
	@endif

@stop