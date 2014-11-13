<h1><a href="/">Midway</a></h1>
<ul class="list-inline">
    <li><a href="/exhibits">Exhibitions</a></li>
    <li><a href="/artists">Artists</a></li>
    <li><a href="/events">Events</a></li>
    <li><a href="/news">News</a></li>
    @if(Auth::check())
    	<li><a href="/account"><i class="fa fa-pencil-square-o"></i>Go Back</a></li>
	@endif
</ul>
