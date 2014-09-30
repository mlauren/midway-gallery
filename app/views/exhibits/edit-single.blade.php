@extends('layout.backend')

@section('sidebar')
    <div class="col-md-4">
        @include('layout.sidebar')
    </div>
@stop

@section('content')
<div class="col-md-8">
    <h4><span class="label label-default pull-right"><i class="fa fa-times"></i>{{ HTML::link('/exhibits/' . $id . '/remove', '  Delete') }}
    </span></h4>
    {{ Form::open(array('route'=>array('exhibits-edit-post', $id), 'files' => true, 'method'=>'post', 'class'=>'form-horizontal', 'id' => 'exhibit-edit')) }}
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {{ Form::label('title', 'Exhibit Title', array('class' => 'control-label')); }}
            {{ Form::text('title', $exhibit->title, array('class'=>'form-control')) }}
            @if($errors->has('title'))
                @foreach($errors->get('title') as $error)
                    <p class="help-block">
                        <strong>{{ $error }}</strong>
                    </p>
                @endforeach
            @endif
        </div>
        <div class="form-group">
            {{ Form::label('created_at', 'Created At', array('class' => 'control-label')); }}
            {{ Form::text('created_at', date_format($exhibit->created_at, 'm/d/Y g:i A'), array('class'=>'form-control', 'id'=>'datetimepicker6')) }}
            @if($errors->has('created_at'))
                @foreach($errors->get('created_at') as $error)
                    <p class="help-block">
                        <strong>{{ $error }}</strong>
                    </p>
                @endforeach
            @endif
        </div>
        <div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
            {{ Form::label('details', 'Exhibit Details', array('class' => 'control-label')); }}
            {{ Form::textarea('details', $exhibit->details, array('class'=>'form-control textarea-wysiwyg')) }}
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
            {{ Form::text('video', $exhibit->video, array('class'=>'form-control')) }}
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
            {{ Form::label('file[]', 'Edit Files', array('class' => 'control-label')); }}
            <p class="help-block">Add additional files.</p>
            {{ Form::file('file[]', ['multiple' => true], ['class' => 'field']) }}
            <p class="help-block">Upload some images associated with the exhibit.</p>
            {{-- Adds an ajaxable image preview element --}}
            <ul id="image-list">
            </ul>
            @if($errors->has('file'))
                @foreach($errors->get('file') as $error)
                    <p class="help-block">
                        <strong>{{ $error }}</strong>
                    </p>
                @endforeach
            @endif

            <div id="image-preview-exists" data-ex-id="{{ $id }}">
                @if(!empty($imageGroup))
                    @foreach($imageGroup as $image)
                        <div class="img-min-preview" data-id="{{ $image->id }}">
                            {{ HTML::image($image->img_min, $exhibit->title) }}
                            {{ HTML::link(URL::route('media-remove-unlink', $image->id), 'X', array('class' => 'media-remove')) }}
                        </div>
                    @endforeach
                @endif
                @if(!empty($assignedGroup))
                    @foreach($assignedGroup as $image)
                        <div class="img-min-preview" data-id="{{ $image->id }}">
                            {{ HTML::image($image->img_min, $exhibit->title) }}
                            {{ HTML::link(URL::route('media-remove-unlink', $image->id), 'X', array('class' => 'media-remove')) }}
                        </div>
                    @endforeach
                @endif
            
            </div>
        </div>

        <div class="form-group">
            {{ Form::checkbox('published', 'true', $exhibit->published) }} {{ Form::label('file', 'Published??', array('class' => 'control-label')); }}
            <p class="help-block">Un-check this if you do not want to display this content.</p>
        </div>
        {{ Form::hidden('id', $id) }}

        {{ Form::submit('Submit', array('class'=>'btn btn-large btn-default')) }}
    {{ Form::close() }}
</div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('/bower_resources/moment/moment.js') }}
    {{ HTML::script('/bower_resources/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}

    {{ HTML::script('/packages/custom_javascripts/media-add-new-exhibit.js') }}

    {{ HTML::script('/packages/custom_javascripts/draggable.js') }}

    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js') }}


@stop
