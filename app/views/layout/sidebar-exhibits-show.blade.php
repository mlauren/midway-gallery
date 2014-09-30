<h3>Exhibits</h3>
<ul class="list-group">
	@foreach(DB::table('exhibits')->where('published', '=', 1)->orderBy('created_at', 'desc')->get() as $exhibit)
		<li class="list-group-item">
		{{ HTML::link('/exhibits/' . $exhibit->permalink, $exhibit->title) }}
		</li>
	@endforeach
</ul>