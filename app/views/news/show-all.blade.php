@extends('layout.main')

@section('sidebar')

@stop

@section('content')
    @foreach($news as $newsItem)
        <div class="panel panel-default row">
            <div class="col-md-4">
                <img class="img-responsive" src="{{ Media::find($newsItem->cover_image)->img_big }}" />
            </div>
            <div class="col-md-8">
                @if(Auth::check())
                    <a href="/news/{{$newsItem->id}}/edit"><i class="fa fa-pencil-square-o"></i></a>
                @endif
                <h3>{{$newsItem->title}}</h3>
                {{$newsItem->description}}
            </div>
        </div>
    @endforeach
@stop