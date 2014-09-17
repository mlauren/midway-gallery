@if(Auth::check())
	<ul class="list-group">
	@foreach(Exhibit::has('media')->get() as $exhibit)
		<li class="list-group-item">
		{{ HTML::link('/exhibits/' . $exhibit->permalink, $exhibit->title) }}
		<span class="badge">{{ HTML::link('/exhibits/' . $exhibit->id . '/edit', 'edit') }}</span>
		</li>
	@endforeach
	</ul>
@endif