@extends('layout.main')

@section('content')
	{{ Form::open(array('url'=>URL::route('account-password-reset-post'), 'method'=>'post', 'class'=>'form-horizontal')) }}
		<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
			{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
		</div>
		{{ Form::submit('Submit', array('class'=>'btn btn-large btn-default btn-block'))}} 
	{{ Form::close() }}
@stop