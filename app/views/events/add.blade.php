@extends('layout.backend')

@section('sidebar')
	<div class="col-md-4">
	    @include('layout.sidebar-events-edit')
	</div>
@stop

@section('content')
<div class="col-md-8">
{{ Form::open(array('url'=>URL::route('event-add-post'), 'files' => true, 'method'=>'post', 'class'=>'form-horizontal')) }}
	<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
		{{ Form::label('title', 'Event Title', array('class' => 'control-label')); }}
		{{ Form::text( 'title', null, array('class'=>'form-control') ) }}
		@if($errors->has('title'))
			@foreach($errors->get('title') as $error)
	            <p class="help-block">
	            	<strong>{{ $error }}</strong>
	            </p>
	        @endforeach
        @endif
	</div>
	<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
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
    <div class="form-group {{ $errors->has('social') ? 'has-error' : '' }}">
        {{ Form::label('social', 'Social Media Link:', array('class' => 'control-label')); }}
        {{ Form::text( 'social', null, array('class'=>'form-control') ) }}
        @if($errors->has('social'))
            @foreach($errors->get('social') as $error)
                <p class="help-block">
                    <strong>{{ $error }}</strong>
                </p>
            @endforeach
        @endif
    </div>
    <div class="panel panel-default well form-group">
        <div class="col-md-12"><p class="help-block"> Is there a time for this event?</p></div>
        <div class="col-md-12">

            {{ Form::label('event_time', 'Event Time Starting', array('class' => 'control-label')); }}
            {{ Form::text('event_time', null, array('class'=>'form-control datetimepicker6')) }}
            @if($errors->has('event_time'))
                @foreach($errors->get('event_time') as $error)
                    <p class="help-block">
                        <strong>{{ $error }}</strong>
                    </p>
                @endforeach
            @endif
        </div>
        <div class="col-md-12">
            {{ Form::label('event_time_end', 'Event Time Ending', array('class' => 'control-label')); }}
            {{ Form::text('event_time_end', null, array('class'=>'form-control datetimepicker6')) }}
            @if($errors->has('event_time'))
                @foreach($errors->get('event_time') as $error)
                    <p class="help-block">
                        <strong>{{ $error }}</strong>
                    </p>
                @endforeach
            @endif
        </div>
    </div>

    <div class="panel panel-default well form-group">
        <a href="">Insert Address <i class="fa fa-chevron-down"></i></a>
        <div class="form-group">
            <div class="col-md-12"><p class="help-block"> Is there is a place for this event?</p></div>
            <div class="col-md-12">
                {{ Form::label('address_title', 'Name Place:', array('class' => 'control-label')); }}
                {{ Form::text( 'address_title', null, array('class'=>'form-control') ) }}
                <p class="help-block"> Does this place have a name?</p>

            </div>
            <div class="col-md-6">
                {{ Form::label('address1', 'Street Address:', array('class' => 'control-label')); }}
                {{ Form::text( 'address1', null, array('class'=>'form-control') ) }}
                @if($errors->has('address1'))
                    @foreach($errors->get('address1') as $error)
                        <p class="help-block">
                            <strong>{{ $error }}</strong>
                        </p>
                    @endforeach
                @endif
            </div>
            <div class="col-md-3">
                {{ Form::label('address2', 'City:', array('class' => 'control-label')); }}
                {{ Form::text( 'address2', null, array('class'=>'form-control') ) }}
                @if($errors->has('address2'))
                    @foreach($errors->get('address2') as $error)
                        <p class="help-block">
                            <strong>{{ $error }}</strong>
                        </p>
                    @endforeach
                @endif
            </div>
            <div class="col-md-3">
                {{ Form::label('address3', 'State:', array('class' => 'control-label')); }}
                {{ Form::select( 'address3', $states, null, array('class'=>'form-control') ) }}
                @if($errors->has('address3'))
                    @foreach($errors->get('address3') as $error)
                        <p class="help-block">
                            <strong>{{ $error }}</strong>
                        </p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="form-group {{ $errors->has('exhibit_id') ? 'has-error' : '' }}">
        {{ Form::label('exhibit_id', 'Related Exhibit:', array('class' => 'control-label')); }}
        <p class="help-block"> Is there a related exhibit on this site?</p>
        {{ Form::select('exhibit_id', $exhibits, null, array('class'=>'form-control')) }}
        @if($errors->has('exhibit_id'))
            @foreach($errors->get('exhibit_id') as $error)
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
    {{ HTML::script('/bower_resources/moment/moment.js') }}
    {{ HTML::script('/bower_resources/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}

    {{ HTML::script('/packages/custom_javascripts/load-scripts  .js') }}

    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js') }}
@stop
