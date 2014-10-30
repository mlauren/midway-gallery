@extends('layout.main')

@section('sidebar')
    <div class="col-md-4">
        @include('layout.sidebar-exhibits-show')
    </div>
@stop

@section('content')
	<div class="col-md-8">
		<h3>{{ $exhibit->title }}
		@if(Auth::check()) 
			<a href="/exhibits/{{$exhibit->id}}/edit"><i class="fa fa-pencil-square-o"></i></a>
		@endif
		</h3>
		@if(isset($exhibit->details))
			<p>{{ $exhibit->details }}</p>
		@endif
		@if(isset($exhibit->video))
			@if (isset($videoEmbed['source']))
				@if($videoEmbed['source'] == 'vimeo')
					<iframe src="//player.vimeo.com/video/{{ $videoEmbed['id'] }}" width="640" height="480" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				@endif
				@if($videoEmbed['source'] == 'youtube')
					<iframe src="http://www.youtube.com/embed/{{ $videoEmbed['id'] }}" width="640" height="480" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				@endif
			@endif
		@endif
		{{-- Display the images --}}
		@foreach($imageGroup as $image)
			{{ HTML::image($image->img_big, $exhibit->title) }}
		@endforeach
		@if(isset($assignedGroup))
			@foreach ($assignedGroup as $image)
				{{ HTML::image($image->img_big, $exhibit->title, array('class' => 'img-responsive')) }}
			@endforeach
		@endif
	</div>
@stop
