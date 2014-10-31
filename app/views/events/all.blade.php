@extends('layout.main')

@section('content')
    {{-- var_dump($events)  --}}
    @foreach( $events as $event )
        <div class="panel panel-default row">
            <div class="{{ (bool)$event->media ? 'col-md-8' : 'col-md-12'}}" >
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
            @foreach( $event->media as $key => $image )
                @if(  $key == 0  )
                    <div class="col-md-4">
                        <img style="margin: 15px 0;" class="img-responsive img-rounded" src="{{ $image->img_big }}">
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach
@stop
