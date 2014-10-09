@extends('layout.main')

@section('content')
    @foreach($artists as $artist)
        <div class="col-md-3">
            <h4>
                {{ link_to_route('artists-show-single', $artist->name, $parameters = array('name' => $artist->permalink)) }}
            </h4>
            <a href="{{ URL::route('artists-show-single', $artist->permalink) }}">
                <img src="/{{ Media::find($artist->cover_image)->img_min }}" />
            </a>
        </div>
    @endforeach
@stop
