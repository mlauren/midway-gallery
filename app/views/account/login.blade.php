@extends('layout.main')

@section('content')
	<!-- Using the Form helper class automatically generates a CSRF token -->
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">Login</div>
			<div class="panel-body">
				{{ Form::open(array('url'=>URL::route('account-login-post'), 'method'=>'post', 'class'=>'form-signup')) }}
				    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				    	@if($errors->has('email'))
			                <label class="control-label" for="inputError1">
			                    @foreach($errors->get('email') as $error)
			                        {{ $error }} <br />
			                    @endforeach
			                </label>
			            @endif
			            {{ Form::label('email', 'Email', array('class' => 'control-label')); }}
				        {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email')) }}
				    </div>

				    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				    	@if($errors->has('password'))
			                <label class="control-label" for="inputError1">
			                    @foreach($errors->get('password') as $error)
			                        {{ $error }} <br />
			                    @endforeach
			                </label>
			            @endif
			            {{ Form::label('email', 'Password', array('class' => 'control-label')); }}
				        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password', 'type' => 'password')) }}
				    </div>
				    {{ Form::submit('Sign in', array('class'=>'btn btn-default'))}}
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop