@extends('layout.main')

@section('content')
	<h3>{{ $exhibit->title }}</h3>
	@if(isset($exhibit->details))
		<p>{{ $exhibit->details }}</p>
	@endif
	@if(isset($exhibit->video))
		<p>{{ $exhibit->video }}</p>
	@endif
	{{-- Display the images --}}
	@foreach($imageGroup as $image)
		{{ HTML::image($image->img_big, $exhibit->title) }}
	@endforeach
	@if(isset($assignedGroup))
		@foreach ($assignedGroup as $image)
			{{ HTML::image($image->img_big, $exhibit->title) }}
		@endforeach
	@endif
@stop
