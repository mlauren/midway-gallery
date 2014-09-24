@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Create Account</div>
        <div class="panel-body">
        <!-- Using the Form helper class automatically generates a CSRF token -->
        {{ Form::open(array('url'=>URL::route('account-create-post'), 'method'=>'post', 'class'=>'form-signup')) }}

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                @if($errors->has('email'))
                    <label class="control-label" for="inputError1">
                        @foreach($errors->get('email') as $error)
                            {{ $error }} <br />
                        @endforeach
                    </label>
                @endif
                {{ Form::label('email', 'Email', array('class' => 'control-label')); }}
                {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
            </div>
         
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                @if($errors->has('username'))
                    <label class="control-label" for="inputError1">
                        @foreach($errors->get('username') as $error)
                            {{ $error }} <br />
                        @endforeach
                    </label>
                @endif
                {{ Form::label('username', 'UserName', array('class' => 'control-label')); }}
                {{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'User Name')) }}
            </div>

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                
                @if($errors->has('password'))
                    <label class="control-label" for="inputError1">
                        @foreach($errors->get('password') as $error)
                            {{ $error }} <br />
                        @endforeach
                    </label>
                @endif
                {{ Form::label('password', 'Password', array('class' => 'control-label')); }}
                {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
                {{ Form::label('password_confirmation', 'Password Again', array('class' => 'control-label')); }}
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
            {{ Form::submit('Register', array('class'=>'btn btn-default'))}}
        {{ Form::close() }}
    </div>
@stop