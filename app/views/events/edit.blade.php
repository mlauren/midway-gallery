@extends('layout.backend')

@section('sidebar')
    <div class="col-md-4">
        @include('layout.sidebar-events-edit')
    </div>
@stop

@section('content')
<div class="col-md-8">
    <h4>
        <span class="label label-default pull-right">
            <i class="fa fa-times"></i><a href="{{ URL::route('events-delete', $event->id)  }}">Delete</a>
        </span>
    </h4>
{{ Form::open(array('url'=>URL::route('events-edit-post', $id), 'files' => true, 'method'=>'post', 'class'=>'form-horizontal')) }}
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        {{ Form::label('title', 'Event Title', array('class' => 'control-label')); }}
        {{ Form::text( 'title', $event->title, array('class'=>'form-control') ) }}
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
        {{ Form::textarea( 'details', $event->details, array('class'=>'form-control') ) }}
        @if($errors->has('details'))
            @foreach($errors->get('details') as $error)
                <p class="help-block">
                    <strong>{{ $error }}</strong>
                </p>
            @endforeach
        @endif
    </div>
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        {{ Form::label('social', 'Social Media Link:', array('class' => 'control-label')); }}
        {{ Form::text( 'social', $event->social, array('class'=>'form-control') ) }}
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
            @if( isset($event->event_time) )
                {{ Form::text('event_time', date('m/d/Y g:i A', strtotime($event->event_time)), array('class'=>'form-control datetimepicker6')) }}
            @else
                {{ Form::text('event_time', null, array('class'=>'form-control datetimepicker6')) }}
            @endif
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
            @if( isset($event->event_time_end) )
                {{ Form::text('event_time_end', date('m/d/Y g:i A', strtotime($event->event_time_end)), array('class'=>'form-control datetimepicker6')) }}
            @else
                {{ Form::text('event_time_end', null, array('class'=>'form-control datetimepicker6')) }}
            @endif
            @if($errors->has('event_time'))
                @foreach($errors->get('event_time') as $error)
                    <p class="help-block">
                        <strong>{{ $error }}</strong>
                    </p>
                @endforeach
            @endif
        </div>
    </div>
    <div class="form-group {{ $errors->has('event_time') ? 'has-error' : '' }}">
        {{ Form::label('social', 'Social Media Link:', array('class' => 'control-label')); }}
        {{ Form::text( 'social', $event->social, array('class'=>'form-control') ) }}
        @if($errors->has('social'))
            @foreach($errors->get('social') as $error)
                <p class="help-block">
                    <strong>{{ $error }}</strong>
                </p>
            @endforeach
        @endif
    </div>

    <div class="panel panel-default well form-group">
        <a href="">Insert Address <i class="fa fa-chevron-down"></i></a>
        <div class="form-group">
            <div class="col-md-12"><p class="help-block"> Is there is a place for this event?</p></div>
            <div class="col-md-12">
                {{ Form::label('address_title', 'Name Place:', array('class' => 'control-label')); }}
                {{ Form::text( 'address_title', $event->address_title, array('class'=>'form-control') ) }}
                <p class="help-block"> Does this place have a name?</p>
            </div>
            <div class="col-md-6">
                {{ Form::label('address1', 'Street Address:', array('class' => 'control-label')); }}
                @if( isset($address[0]) )
                    {{ Form::text( 'address1', $address[0], array('class'=>'form-control') ) }}
                @else
                    {{ Form::text( 'address1', null, array('class'=>'form-control') ) }}
                @endif
            </div>
            <div class="col-md-3">
                {{ Form::label('address2', 'City:', array('class' => 'control-label')); }}
                @if( isset($address[1]) )
                    {{ Form::text( 'address2', $address[1], array('class'=>'form-control') ) }}
                @else
                    {{ Form::text( 'address2', null, array('class'=>'form-control') ) }}
                @endif
            </div>
            <div class="col-md-3">
                {{ Form::label('address3', 'State:', array('class' => 'control-label')); }}
                @if( isset($address[2]) )
                    {{ Form::select( 'address3', $states, $address[2], array('class'=>'form-control') ) }}
                @else
                    {{ Form::select( 'address3', $states, null, array('class'=>'form-control') ) }}
                @endif
            </div>
        </div>
    </div>
    <div class="form-group {{ $errors->has('exhibit_id') ? 'has-error' : '' }}">
        {{ Form::label('exhibit_id', 'Related Exhibit:', array('class' => 'control-label')); }}
        <p class="help-block"> Is there a related exhibit on this site?</p>
        {{ Form::select('exhibit_id', $exhibits, $event->exhibit_id, array('class'=>'form-control')) }}
    </div>
    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
        {{ Form::label('image', 'Image for event', array('class' => 'control-label')) }}
        {{ Form::file('image', array('multiple' => true, 'class' => 'field')) }}
        <p class="help-block">Image for event</p>


        <div class="col-xs-6 col-md-3" id="image-preview-exists" data-item-id="{{ $event->id }}">
            @foreach( $event->media as $media )
                @if( $event->image == $media->id)
                   <div class="thumbnail">
                        <a class="media-remove" href="/media/{{$media->id}}/remove">X</a>
                        <img style="margin: 15px 0;" class="img-responsive" src="/{{$media->img_big}}">
                    </div>
                @endif
            @endforeach
        </div>
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
