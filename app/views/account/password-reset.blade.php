@extends('layout.main')

@section('content')
	@if(Session::has('error'))
		{{ trans(Session::get('reason')) }}
	@elseif(Session::has('success'))
		<div class="alert alert-success" role="alert">An email with password reset has been sent.</div>
	@endif


	{{ Form::open(array('url'=>URL::route('account-password-reset-post'), 'method'=>'post', 'class'=>'form-signup form-horizontal')) }}
		<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
			{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
		</div>
		{{ Form::submit('Submit', array('class'=>'btn btn-large btn-default btn-block'))}} 
	{{ Form::close() }}
@stop