@if(Auth::check())
	<h3>Exhibits <a href="/exhibit-add"><span class="badge pull-right">+New</span></a></h3>
	<ul class="list-group">
	<h5>Published:</h5>
	@foreach(DB::table('exhibits')->where('published', '=', 1)->get() as $exhibit)
		<li class="list-group-item">
		{{ HTML::link('/exhibits/' . $exhibit->permalink, $exhibit->title) }}
		<a href="/exhibits/{{ $exhibit->id }}/edit"><span class="pull-right badge">edit</span></a>
		</li>
	@endforeach

	@if(DB::table('exhibits')->where('published', '=', 0)->get() != null)
		<h5>Unpublished:</h5>
		@foreach(DB::table('exhibits')->where('published', '=', 0)->orderBy('updated_at', 'desc')->get() as $exhibit)
			<li class="list-group-item">
			{{ HTML::link('/exhibits/' . $exhibit->permalink, $exhibit->title) }}
			<a href="/exhibits/{{ $exhibit->id }}/edit"><span class="pull-right badge">edit</span></a>
			</li>
		@endforeach
	@endif
	
	@if(DB::table('exhibits')->where('autodraft', '=', 1)->get() != null)
		<h5>AutoDraft:</h5>
		@foreach(DB::table('exhibits')->where('autodraft', '=', 1)->get() as $exhibit)
			<li class="list-group-item">
			{{ HTML::link('/exhibits/' . $exhibit->permalink, $exhibit->title) }}
			<a href="/exhibits/{{ $exhibit->id }}/edit"><span class="pull-right badge">edit</span></a>
			</li>
		@endforeach
	@endif
	</ul>
@endif
