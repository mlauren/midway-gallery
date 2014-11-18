<h1><a href="/">Midway</a></h1>
<ul class="list-inline">
    <li><a href="/exhibits">Exhibitions</a></li>
    <li><a href="/artists">Artists</a></li>
    <li><a href="/events">Events</a></li>
    <li><a href="/news">News</a></li>
    @if(Auth::check())
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-child"></i>  Account <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="{{ URL::route('account') }}">Administer</a></li>
					<li><a href="{{ URL::route('account-logout') }}">Logout</a></li>
				</ul>
		</li>
	@endif
</ul>
