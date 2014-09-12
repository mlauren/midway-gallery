@extends('layout.main')

@section('content')
	Account
	@if(Auth::check())
		<p>Hello, {{ Auth::user()->username }}.</p>
	@else
		<p>Not Signed in</p>
	@endif
@stop