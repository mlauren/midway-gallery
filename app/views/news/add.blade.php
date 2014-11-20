@extends('layout.backend')

@section('sidebar')
    <div class="col-md-4">
        @include('layout.sidebar-news-edit')
    </div>
@stop

@section('content')

    <div class="col-md-8">
    {{ Form::open(array('url'=>URL::route('news-add-post'), 'files' => true, 'method'=>'post', 'class'=>'form-horizontal')) }}
    	<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    		{{ Form::label('title', 'Title of News Story', array('class' => 'control-label')); }}
    		{{ Form::text('title', null, array('class'=>'form-control')) }}
    		@if($errors->has('title'))
    			@foreach($errors->get('title') as $error)
    	            <p class="help-block">
    	            	<strong>{{ $error }}</strong>
    	            </p>
    	        @endforeach
            @endif
    	</div>
    	<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
            {{ Form::label('url', 'url', array('class' => 'control-label')); }}
            {{ Form::text('url', null, array('class'=>'form-control')) }}
            <p class="help-block">URL for a News Story</p>
            @if($errors->has('url'))
                @foreach($errors->get('url') as $error)
                    <p class="help-block">
                        <strong>{{ $error }}</strong>
                    </p>
                @endforeach
            @endif
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            {{ Form::label('description', 'Description', array('class' => 'control-label')); }}
            {{ Form::textarea('description', null, array('class'=>'form-control details-wysi')) }}
            @if($errors->has('description'))
                @foreach($errors->get('description') as $error)
                    <p class="help-block">
                        <strong>{{ $error }}</strong>
                    </p>
                @endforeach
            @endif
        </div>
        <div class="form-group {{ $errors->has('cover_image') ? 'has-error' : '' }}">
    		{{ Form::label('cover_image', 'Cover Image', array('class' => 'control-label')); }}
            {{ Form::file('cover_image', array('class' => 'file')) }}
    		@if($errors->has('cover_image'))
    			@foreach($errors->get('cover_image') as $error)
    	            <p class="help-block">
    	            	<strong>{{ $error }}</strong>
    	            </p>
    	        @endforeach
            @endif
            <div class="image-preview-exists">
            </div>
    	</div>
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
