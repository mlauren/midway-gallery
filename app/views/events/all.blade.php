@extends('layout.main')

@section('content')
    <div class="row">
        @foreach( $events as $event )
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="col-md-12">{{ $event->title }}
                            @if(Auth::check())
                                <a href="/events/{{$event->id}}/edit"><i class="fa fa-pencil-square-o"></i></a>
                            @endif
                            @if( $event->social )
                                <a href="{{ $event->social }}" alt="facebook event"><i class="fa fa-facebook"></i></a>
                            @endif
                            <br><small>{{ $event->address }}</small>
                        </h3>

                        <div class="{{ $event->image ? 'col-md-8' : 'col-md-12' }}">
                            <h3>
                                 <small>
                                    {{ date('m/d/Y g:i A', strtotime($event->event_time)) }}
                                    {{ !empty($event->event_time_end) ? '- ' . date('m/d/Y g:i A', strtotime($event->event_time_end)) : '' }}
                                 </small>
                            </h3>
                            @if( $event->exhibit_id != 0 )
                                <a href="/exhibits/{{ Exhibit::find($event->exhibit_id)->permalink }}">
                                    {{ Exhibit::find($event->exhibit_id)->title }}
                                </a>
                            @endif
                            <p>{{ $event->details }}</p>
                        </div>

                        @if(Media::find($event->image))
                            <div class="col-md-4">
                                <img class="img-responsive" src="{{ Media::find($event->image)->img_big }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
