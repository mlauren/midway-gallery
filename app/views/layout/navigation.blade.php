
<nav class="navbar navbar-default" role="navigation">
	<div class="container">
		<ul class="nav navbar-nav">
			<li><a href="{{ URL::route('account') }}">Home </a></li>
			@if(Auth::check())
				<li><a href="{{ URL::route('account-logout') }}">Logout</a></li>
				<li><a href="{{ URL::route('account-change-pwd') }}">Change Password</a></li>  
			@else
				<li><a href="{{ URL::route('account-login') }}">Sign In</a></li>
				<li><a href="{{ URL::route('account-create') }}">Create Account </a></li>
				<li><a href="{{ URL::route('account-password-reset') }}">Reset Password? </a></li>
			@endif
		</ul>
	</div>
</nav>