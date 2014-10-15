@extends('layout.backend')

@section('sidebar')
	<div class="col-md-4">
		@include('layout.sidebar')
	</div>
@stop

@section('content')
<div class="col-md-8">
{{ Form::open(array('url'=>URL::route('exhibits-add-post'), 'files' => true, 'method'=>'post', 'class'=>'form-horizontal')) }}
	<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
		{{ Form::label('title', 'Exhibit Title', array('class' => 'control-label')); }}
		{{ Form::text('title', array('class'=>'form-control', 'value' => $event->title or null)) }}
		@if($errors->has('title'))
			@foreach($errors->get('title') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>

	<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
		{{ Form::label('image', 'Image for event', array('class' => 'control-label')); }}
		{{ Form::file('image', array('multiple' => true, 'class' => 'field')) }}
		<p class="help-block">Image for event</p>
	    <div id="image-preview-exists" data-ex-id=""></div>
	</div>

	{{ Form::hidden('id') }}
	{{ Form::submit('Submit', array('class'=>'btn btn-large btn-default')) }}
{{ Form::close() }}
</div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('/packages/custom_javascripts/load-scripts.js') }}

    {{ HTML::script('/packages/custom_javascripts/media-add-new-exhibit.js') }}

    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js') }}
@stop
