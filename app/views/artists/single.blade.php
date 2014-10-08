@extends('layout.backend')

@section('sidebar')

@stop

@section('content')
<h1>{{ $artist->name }}</h1>
<h3>{{ $artist->credentials }}</h3>
<div class="col-md-12">
	<img class="img-responsive col-md-5 pull-right" src="/{{ $inside_image->img_big }}" />
	{{ $artist->description }}
</div>
@stop