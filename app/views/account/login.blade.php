@extends('layout.main')

@section('content')
	<!-- Using the Form helper class automatically generates a CSRF token -->
	{{ Form::open(array('url'=>URL::route('account-login-post'), 'method'=>'post', 'class'=>'form-signup form-horizontal')) }}
	 
	    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	    	@if($errors->has('email'))
                <label class="control-label" for="inputError1">
                    @foreach($errors->get('email') as $error)
                        {{ $error }} <br />
                    @endforeach
                </label>
            @endif
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
	        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password', 'type' => 'password')) }}
	    </div>
	    {{ Form::submit('Sign in', array('class'=>'btn btn-large btn-default btn-block'))}}
	{{ Form::close() }}
@stop