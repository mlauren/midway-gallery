@extends('layout.backend')

@section('content')
	@if(Auth::check())
		<h2><small>Hello, {{ Auth::user()->username }}.</small></h2>
		<div class="col-md-4">
			@include('layout.sidebar')
		</div>
		<div class="col-md-4">
			@include('layout.sidebar-artists-edit')
		</div>
		<div class="col-md-4">
			@include('layout.sidebar')
		</div>
	@endif

@stop