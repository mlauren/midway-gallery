
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ URL::route('home') }}">Midway</a>
			<a class="navbar-brand" href="{{ URL::route('account') }}"><i class="fa fa-home fa-lg"></i></a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


			<ul class="nav navbar-nav">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog fa-lg"></i> <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu">
					@if(Auth::check())
						<li><a href="{{ URL::route('exhibits-add') }}">Add an Exhibit</a></li>
						<li><a href="{{ URL::route('partner-add') }}">Add An Artist / Affiliate</a></li>
						<li><a href="{{ URL::route('news-add') }}">Add a News Item</a></li>
						<li><a href="{{ URL::route('event-add') }}">Add an Event Item</a></li>
					@endif
				  </ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-child"></i>  Account <span class="caret"></span></a>
		          <ul class="dropdown-menu" role="menu">
		            @if(Auth::check())
						<li><a href="{{ URL::route('account-logout') }}">Logout</a></li>
						<li><a href="{{ URL::route('account-change-pwd') }}">Change Password</a></li>
					@else
						<li><a href="{{ URL::route('account-login') }}">Sign In</a></li>
						<li><a href="{{ URL::route('account-create') }}">Create Account </a></li>
						<li><a href="{{ URL::route('account-password-reset') }}">Reset Password? </a></li>
					@endif
		          </ul>
		        </li>
			</ul>

		</div>
	</div>
</nav>
