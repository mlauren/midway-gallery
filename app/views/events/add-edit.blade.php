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
		{{ Form::text('title', $event->title or null, array('class'=>'form-control')) }}
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
		{{ Form::textarea('details', $event->details or null, array('class'=>'form-control details-wysi')) }}

		@if($errors->has('details'))
			@foreach($errors->get('details') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
	<div class="form-group {{ $errors->has('social') ? 'has-error' : '' }}">
		{{ Form::label('social', '"Social Media"', array('class' => 'control-label')); }}
		{{ Form::text('social', $event->social or null, array('class'=>'form-control')) }}
		<p class="help-block">If this event has a corresponding social media link please paste it here.</p>
		@if($errors->has('social'))
			@foreach($errors->get('social') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
	<div class="form-group {{ $errors->has('social') ? 'has-error' : '' }}">
        {{ Form::label('address', '"Address"', array('class' => 'control-label')); }}
        <p class="help-block">Does your event have a physical address you would like to share?</p>
        {{ Form::text('address', $address[0] or null, array('class'=>'form-control')) }}
        {{ Form::text('city', $address[1] or null, array('class'=>'form-control')) }}
        {{ Form::select('state', $address[2] or null, array('class'=>'form-control')) }}
        {{ Form::text('zip', $address[3] or null, array('class'=>'form-control')) }}
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
