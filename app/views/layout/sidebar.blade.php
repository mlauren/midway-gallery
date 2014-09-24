@if(Auth::check())
	<h3>Exhibits <a href="/exhibit-add"><span class="badge">+New</span></a></h3>
	<ul class="list-group">
	@foreach(Exhibit::all() as $exhibit)
		<li class="list-group-item">
		{{ HTML::link('/exhibits/' . $exhibit->permalink, $exhibit->title) }}
		<a href="/exhibits/{{ $exhibit->id }}/edit"><span class="pull-right badge">edit</span></a></h3>
		</li>
	@endforeach
	</ul>
@endif