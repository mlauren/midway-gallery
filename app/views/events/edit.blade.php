@extends('layout.backend')

@section('sidebar')
	<div class="col-md-4">
	</div>
@stop

@section('content')
<div class="col-md-8">
{{ Form::open(array('url'=>URL::route('exhibits-edit-post', $id), 'files' => true, 'method'=>'post', 'class'=>'form-horizontal')) }}
	<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
		{{ Form::label('title', 'Event Title:', array('class' => 'control-label')); }}
		{{ Form::text( 'title', null, array('class'=>'form-control') ) }}
		@if($errors->has('title'))
			@foreach($errors->get('title') as $error)
			    <p class="help-block">
	                <strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
	<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        {{ Form::label('details', 'Event Details:', array('class' => 'control-label')); }}
        {{ Form::textarea( 'details', null, array('class'=>'form-control') ) }}
        @if($errors->has('details'))
            @foreach($errors->get('details') as $error)
                <p class="help-block">
                    <strong>{{ $error }}</strong>
                </p>
            @endforeach
        @endif
    </div>
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        {{ Form::label('social', 'Social Media Links', array('class' => 'control-label')); }}
        {{ Form::text( 'social', null, array('class'=>'form-control') ) }}
        @if($errors->has('social'))
            @foreach($errors->get('social') as $error)
                <p class="help-block">
                    <strong>{{ $error }}</strong>
                </p>
            @endforeach
        @endif
    </div>
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        {{ Form::label('address1', 'Street Address', array('class' => 'control-label')); }}
        {{ Form::text( 'address1', null, array('class'=>'form-control') ) }}
        @if($errors->has('address1'))
            @foreach($errors->get('address1') as $error)
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
