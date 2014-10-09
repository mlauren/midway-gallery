<h3>News<a href="/news-add"><span class="badge pull-right">+New</span></a></h3>
<ul class="list-group">
	@foreach(DB::table('news')->orderBy('created_at', 'desc')->get() as $news)
		<li class="list-group-item">
            {{ $news->title }}
            <a href="{{ URL::route('news-edit', $news->id) }}"><span class="pull-right badge">edit</span></a>
        </li>
	@endforeach
</ul>