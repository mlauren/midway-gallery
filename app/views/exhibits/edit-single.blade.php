@extends('layout.main')

@section('content')

{{ HTML::link('', 'XXXDelete') }}

{{ Form::open(array('route'=>array('exhibits-edit-post', $id), 'files' => true, 'method'=>'post', 'class'=>'form-horizontal')) }}
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
    <div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
        {{ Form::label('details', 'Exhibit Details', array('class' => 'control-label')); }}
        {{ Form::textarea('details', $exhibit->details, array('class'=>'form-control')) }}
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
        <div id="image-preview"></div>
        {{ Form::file('file[]', ['multiple' => true], ['class' => 'field']) }}
        <p class="help-block">Upload some images associated with the exhibit.</p>
        @if($errors->has('file'))
            @foreach($errors->get('file') as $error)
                <p class="help-block">
                    <strong>{{ $error }}</strong>
                </p>
            @endforeach
        @endif
        <div id="response"></div>
        <ul id="image-list">
        </ul>
        <div id="image-preview-exists">
            @foreach($imageGroup as $image)
                <div class="img-min-preview">
                    {{ HTML::image($image->img_min, $exhibit->title) }}
                    {{ HTML::link(URL::route('media-remove-unlink', $image->id), 'X', array('class' => 'media-remove')) }}
                </div>
            @endforeach
        </div>
    </div>

    <div class="form-group">
        {{ Form::checkbox('published', 'true', $exhibit->published) }} {{ Form::label('file', 'Published??', array('class' => 'control-label')); }}
        <p class="help-block">Un-check this if you do not want to display this content.</p>
    </div>
    {{ Form::hidden('id', $id) }}

    {{ Form::submit('Submit', array('class'=>'btn btn-large btn-default btn-block')) }}
{{ Form::close() }}

@stop
