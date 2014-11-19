@extends('layout.main')

@section('sidebar')

@stop

@section('content')
    <div class="row">
        @foreach($news as $newsItem)
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ $newsItem->url ? '<a href="'. $newsItem->url .'">' : '' }}
                            <h3>{{$newsItem->title}}
                               @if(Auth::check())
                                    <a href="/news/{{$newsItem->id}}/edit"><i class="fa fa-pencil-square-o"></i></a>
                                @endif
                            </h3>
                        {{ $newsItem->url ? '</a>' : '' }}
                        <div class="{{$newsItem->cover_image ? 'col-md-8' : 'col-md-12' }}">
                            <p>{{$newsItem->description}}</p>
                        </div>
                        @if(Media::find($newsItem->cover_image))
                            <div class="col-md-4">
                                <img style="margin: 15px 0;" class="img-responsive img-rounded" src="{{ Media::find($newsItem->cover_image)->img_big }}" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
