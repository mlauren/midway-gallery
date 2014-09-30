@extends('layout.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Reset Password</div>
        <div class="panel-body">
        	<!-- Using the Form helper class automatically generates a CSRF token -->
        	{{ Form::open(array('url'=>URL::route('account-change-pwd-post'), 'method'=>'post', 'class'=>'form-signup')) }}

        		<div class="form-group {{ $errors->has('old_password') ? 'has-error' : '' }}">
                    
                    @if($errors->has('old_password'))
                        <label class="control-label" for="inputError1">
                            @foreach($errors->get('old_password') as $error)
                                {{ $error }} <br />
                            @endforeach
                        </label>
                    @endif
                    {{ Form::label('old_password', 'Old Password', array('class' => 'control-label')); }}
                    {{ Form::password('old_password', array('class'=>'form-control', 'placeholder'=>'Old Password')) }}
                </div>

        	    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    
                    @if($errors->has('password'))
                        <label class="control-label" for="inputError1">
                            @foreach($errors->get('password') as $error)
                                {{ $error }} <br />
                            @endforeach
                        </label>
                    @endif
                    {{ Form::label('password', 'New Password', array('class' => 'control-label')); }}
                    {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'New Password')) }}
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    @if($errors->has('password'))
                        <label class="control-label" for="inputError1">
                            @foreach($errors->get('password') as $error)
                                {{ $error }} <br />
                            @endforeach
                        </label>
                    @endif
                    {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
                </div>
        	    {{ Form::submit('Submit', array('class'=>'btn btn-large btn-default'))}}
        	{{ Form::close() }}
        </div>
    </div>
@stop