<?php 

class AccountController extends BaseController {
	public function getAccount() {
		return View::make('account');
	}

	public function getCreate() {
		return View::make('account.create');
	}

	public function getLogin() {
		return View::make('account.login');
	}

	public function getLogout() {
		Auth::logout();
		return Redirect::route('account')
			->with('status', 'alert-success')
			->with('global', 'You have been logged out.');
	}

	public function postLogin() {
		$validator = Validator::make(Input::all(), User::$loginRules);

		if ( $validator->fails() ) {
			return Redirect::route('account-login')
			->withErrors($validator)
			->withInput();
		} else {
			$auth = Auth::attempt(array(
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'active' => 1
			));
			// Redirect to the last page.
			if ( $auth ){
				return Redirect::intended(route('account'));
			}
			else {
				echo '<pre>';
				print_r($auth);
				echo '</pre>';
				return Redirect::route('account-login')
					->with('status', 'alert-danger')
					->with('global', 'There was a problem with your username / password. Have you activated your account?');
			}
		}
		return Redirect::route('account-login')
			->with('status', 'alert-danger')
			->with('global', 'There was a problem >.< Have you activated your account?');
	}

	public function postCreate() {
		$validator = Validator::make(Input::all(), User::$rules);

		if ( $validator->fails() ) {
			return Redirect::route('account-create')
				->withErrors($validator)
				->withInput();
		} else {
			// create that account info we want to put into the DB

			// Activation Code
			$code = str_random(60);

			$user = User::create(array(
				'email' => Input::get('email'),
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password')),
				'code' => $code,
				'active' => 0
			));

			if ($user) {

				// Send email
				Mail::send('emails.auth.activate', 
					array(
						'link' => URL::route('account-activate', $code), 
						'username' => Input::get('username')
					),
					function($message) use ($user) {
							$message
								->to($user->email, $user->username)
								->subject('Activate your account');
					});

				return Redirect::route('account')
					->with('status', 'alert-success')
					->with('global', 'Your account has been created. Please check your email.');
			}
		}
	}

	public function getActivate($code) {
		$user = User::where('code', '=', $code)->where('active', '=', 0);

		if ( $user->count() ) {
			$user = $user->first();
			echo '<pre>';
			print_r($user);
			echo '</pre>';

			$user->active = 1;
			$user->code = '';
			if ($user->save()) {
				return  Redirect::route('account')
					->with('status', 'alert-success')
					->with('global', 'Activated. You can now sign in.');
			}	
		}
		// If code is not correct, redirect.
		return  Redirect::route('account')
			->with('status', 'alert-warning')
			->with('global', 'Something went wrong! >.< Please try again.');
	}

	public function getChangePwd() {
		return View::make('account.password');
	}

	public function postChangePwd() {
		$validator = Validator::make(Input::all(), 
			array(
				'old_password'=>'required|alpha_num|between:6,12',
				'password'=>'required|alpha_num|between:6,12|confirmed',
				'password_confirmation'=>'required|alpha_num|between:6,12',
			)
		);
		if ( $validator->fails() ) {
			return Redirect::route('account-change-pwd')
				->withErrors($validator);
		}
		else {
			$user_id = Auth::user()->id;
			$user = User::find($user_id);

			$old_pwd = Input::get('old_password');
			$new_pwd = Input::get('password');

			if (Hash::check($old_pwd, Auth::user()->password)) {
				// Just check to make sure they arn't being dumb
				if (Hash::check($new_pwd, Auth::user()->password)) {
					return Redirect::route('account')
						->with('status', 'alert-warning')
						->with('global', 'It appears this is already your password.');
				}
				$user->password = Hash::make($new_pwd);
				$user->save();
				return Redirect::route('account')
					->with('status', 'alert-success')
					->with('global', 'Your password has been saved.');
			}
			else {
				return Redirect::route('account-change-pwd')
				->with('status', 'alert-warning')
				->with('global', 'You entered the wrong password.');
			}
			return Redirect::route('account-change-pwd')
				->with('status', 'alert-warning')
				->with('global', 'Your password could not be changed :/');
		}
	}
}

?>