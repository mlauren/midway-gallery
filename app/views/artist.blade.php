@extends('layout.main')

@section('content')
    @foreach($artists as $artist)
        <div class="col-md-3">
            <a href="artists/{{ $artist->permalink }}"><h4>{{ $artist->name }}</h4>
                <img src="{{ Media::find($artist->cover_image)->img_min }}" />
            </a>
        </div>
    @endforeach
@stop
