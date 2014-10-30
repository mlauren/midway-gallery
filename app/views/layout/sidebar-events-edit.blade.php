<h3>Events <a href="/event-add"><span class="badge pull-right">+New</span></a></h3>
<ul class="list-group">
	@foreach(DB::table('events')->orderBy('created_at', 'desc')->get() as $event)
		<li class="list-group-item">
		{{ HTML::link('/events/' . $event->permalink, $event->title) }}
		<a href="/events/{{ $event->id }}/edit"><span class="pull-right badge">edit</span></a>
		</li>
	@endforeach
</ul>