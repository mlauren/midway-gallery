@extends('layout.main')

@section('sidebar')

@stop

@section('content')
    @foreach($news as $newsItem)
        <div class="panel panel-default row">
            <div class="col-md-4">
                <img style="margin: 15px 0;" class="img-responsive img-rounded" src="{{ Media::find($newsItem->cover_image)->img_big }}" />
            </div>
            <div class="col-md-8">
                <h3>{{$newsItem->title}}
                    @if(Auth::check())
                        <a href="/news/{{$newsItem->id}}/edit"><i class="fa fa-pencil-square-o"></i></a>
                    @endif
                </h3>
                {{$newsItem->description}}
            </div>
        </div>
    @endforeach
@stop