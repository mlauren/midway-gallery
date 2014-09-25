@extends('layout.main')

@section('content')
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">Reset Password</div>
			<div class="panel-body">
				{{ Form::open(array('url'=>URL::route('account-password-reset-post'), 'method'=>'post')) }}
					<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
					{{ Form::label('email', 'Email', array('class' => 'control-label')); }}
					{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
					</div>
					{{ Form::submit('Submit', array('class'=>'btn btn-large btn-default'))}}
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop