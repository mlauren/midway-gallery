@extends('layout.main')

@section('content')
	Home
	@if(Auth::check())
		<p>Hello, {{ Auth::user()->username }}.</p>
	@else
		<p>Sign in</p>
	@endif
@stop