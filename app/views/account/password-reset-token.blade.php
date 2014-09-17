@extends('layout.main')

@section('content')
	@if (Session::has('error'))
	  {{ trans(Session::get('reason')) }}
	@endif
	{{ Form::open(array('route' => array('account-password-update', $token), 'method' => 'post', 'class'=>'form-signup form-horizontal')) }}
 
		<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
			@if($errors->has('email'))
                <label class="control-label" for="inputError1">
                    @foreach($errors->get('email') as $error)
                        {{ $error }} <br />
                    @endforeach
                </label>
            @endif
  			{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
		</div>
	 	<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
	 		@if($errors->has('password'))
                <label class="control-label" for="inputError2">
                    @foreach($errors->get('password') as $error)
                        {{ $error }} <br />
                    @endforeach
                </label>
            @endif
  			{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'New Password')) }}
  			@if($errors->has('password_confirmation'))
                <label class="control-label" for="inputError2">
                    @foreach($errors->get('password_confirmation') as $error)
                        {{ $error }} <br />
                    @endforeach
                </label>
            @endif
  			{{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
	 	</div>
		{{ Form::hidden('token', $token) }}

		<p>{{ Form::submit('Submit', array('class'=>'btn btn-default btn-block')) }}</p>
	 
	{{ Form::close() }}
@stop