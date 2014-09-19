@extends('layout.main')

@section('content')

{{ Form::open(array('url'=>URL::route('exhibits-add-post'), 'files' => true, 'method'=>'post', 'class'=>'form-horizontal')) }}
	<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
		{{ Form::label('title', 'Exhibit Title', array('class' => 'control-label')); }}
		{{ Form::text('title', null, array('class'=>'form-control')) }}
		@if($errors->has('title'))
			@foreach($errors->get('title') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
	<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
		{{ Form::label('details', 'Exhibit Details', array('class' => 'control-label')); }}
		{{ Form::textarea('details', null, array('class'=>'form-control')) }}
		
		@if($errors->has('details'))
			@foreach($errors->get('details') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
	<div class="form-group {{ $errors->has('video') ? 'has-error' : '' }}">
		{{ Form::label('video', 'Video', array('class' => 'control-label')); }}
		{{ Form::text('video', null, array('class'=>'form-control')) }}
		<p class="help-block">URL for a video</p>
		@if($errors->has('video'))
			@foreach($errors->get('video') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
	<div class="form-group {{ $errors->has('file') || $errors->has('media') ? 'has-error' : '' }}">
		{{ Form::label('file[]', 'Image Files', array('class' => 'control-label')); }}
		{{ Form::file('file[]', array('multiple' => true, 'class' => 'field')) }}
		<p class="help-block">Upload some images associated with the exhibit.</p>
		@if($errors->has('file'))
			@foreach($errors->get('file') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
	    @endif
	</div>

	<div class="form-group">
		{{ Form::checkbox('published', 'true', true) }} {{ Form::label('file', 'Published??', array('class' => 'control-label')); }}
		<p class="help-block">Un-check this if you do not want to display this content.</p>
	</div>

	{{ Form::submit('Submit', array('class'=>'btn btn-large btn-default btn-block'))}} 
{{ Form::close() }}

@stop
