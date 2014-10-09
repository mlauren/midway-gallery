@extends('layout.backend')

@section('sidebar')

@stop

@section('content')
<div class="col-md-8">
{{ Form::open(array('url'=>URL::route('partner-add-post'), 'files' => true, 'method'=>'post', 'class'=>'form-horizontal')) }}
	<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
		{{ Form::label('name', 'Name or Title', array('class' => 'control-label')); }}
		{{ Form::text('name', $artist->name, array('class'=>'form-control')) }}
		@if($errors->has('name'))
			@foreach($errors->get('name') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
	<div class="form-group {{ $errors->has('cover_image') ? 'has-error' : '' }}">
		{{ Form::label('cover_image', 'Cover Image', array('class' => 'control-label')); }}
        {{ Form::file('cover_image', array('class' => 'field')) }}
		@if($errors->has('cover_image'))
			@foreach($errors->get('cover_image') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
	<div class="form-group {{ $errors->has('credentials') ? 'has-error' : '' }}">
		{{ Form::label('credentials', 'Credentials', array('class' => 'control-label')); }}
		{{ Form::text('credentials', $artist->credentials, array('class'=>'form-control')) }}
		@if($errors->has('credentials'))
			@foreach($errors->get('credentials') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
        {{ Form::label('description', 'Description', array('class' => 'control-label')); }}
        {{ Form::textarea('description', $artist->description, array('class'=>'form-control details-wysi')) }}
        @if($errors->has('description'))
            @foreach($errors->get('description') as $error)
                <p class="help-block">
                    <strong>{{ $error }}</strong>
                </p>
            @endforeach
        @endif
    </div>
    <div class="form-group {{ $errors->has('inside_image') ? 'has-error' : '' }}">
        {{ Form::label('inside_image', 'Inside Image', array('class' => 'control-label')); }}
        {{ Form::file('inside_image', array('class' => 'field')) }}
        @if($errors->has('inside_image'))
            @foreach($errors->get('inside_image') as $error)
                <p class="help-block">
                    <strong>{{ $error }}</strong>
                </p>
            @endforeach
        @endif
    </div>
	{{ Form::hidden('id') }}
	{{ Form::submit('Submit', array('class'=>'btn btn-large btn-default')) }}
{{ Form::close() }}
</div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('/bower_resources/moment/moment.js') }}
    {{ HTML::script('/bower_resources/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}
    {{ HTML::script('/packages/custom_javascripts/load-scripts.js') }}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js') }}
@stop
