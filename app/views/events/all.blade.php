@extends('layout.main')

@section('content')
    <div class="row">
        @foreach( $events as $event )
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-8">
                            <h3>{{ $event->title }}
                               @if(Auth::check())
                                    <a href="/events/{{$event->id}}/edit"><i class="fa fa-pencil-square-o"></i></a>
                                @endif
                                @if( $event->social )
                                    <a href="{{ $event->social }}" alt="facebook event"><i class="fa fa-facebook"></i></a>
                                @endif
                            </h3>
                            <h3>
                                 <small>
                                    {{ date('m/d/Y g:i A', strtotime($event->event_time)) }}
                                    {{ !empty($event->event_time_end) ? '- ' . date('m/d/Y g:i A', strtotime($event->event_time_end)) : '' }}
                                 </small>
                            </h3>
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
