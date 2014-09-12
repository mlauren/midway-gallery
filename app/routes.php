<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@home'
	));
/*
| View account section (GET)
*/
Route::get('/account', array(
	'as' => 'account',
	'uses' => 'AccountController@getAccount'
));

/*
| Authenticated Group
*/
Route::group(array('before' => 'auth'), function() {


	/*
	| CSRF protection
	*/
	Route::group(array('before' => 'csrf'), function() {

		/*
		| Change Password (POST)
		*/
		Route::post('/account/change-pwd', array(
			'as' => 'account-change-pwd-post',
			'uses' => 'AccountController@postChangePwd'
		));
	});

	/*
	| Get Change Password Form
	*/
	Route::get('/account/change-pwd', array(
		'as' => 'account-change-pwd',
		'uses' => 'AccountController@getChangePwd'
	));

	/*
	| Logout
	*/
	Route::get('/account/logout', array(
		'as' => 'account-logout',
		'uses' => 'AccountController@getLogout'
	));

});


/*
| Unauthenticated Group
| Check to make sure the user is not authenticated
*/
Route::group(array('before' => 'guest'), function() {

	/*
	| CSRF protection
	*/
	Route::group(array('before' => 'csrf'), function() {
		/*
		| Create account (POST)
		*/
		Route::post('/account/create', array(
			'as' => 'account-create-post',
			'uses' => 'AccountController@postCreate'
		));
		/*
		| Login (POST)
		*/
		Route::post('/account/login', array(
			'as' => 'account-login-post',
			'uses' => 'AccountController@postLogin'
		));
	});

	/*
	| Reset Password (POST)
	*/
	Route::post('/account/password-reset', array(
		'as' => 'account-password-reset-post',
		'uses' => 'PasswordController@postRemind'
	));

	/*
	| Reset Password Page With Token (GET)
	*/
	Route::get('/account/password-reset/{token}', array(
		'as' => 'account-password-reset-token',
		'uses' => 'PasswordController@getRemindToken'
	));
	

	/*
	| Reset Password Page With Token (GET)
	*/
	Route::post('/account/password-reset/{token}', array(
		'as' => 'account-password-update',
		'uses' => 'PasswordController@postUpdatePwdWithToken'
	));

	/*
	| Reset Password Page (GET)
	*/
	Route::get('/account/password-reset', array(
		'as' => 'account-password-reset',
		'uses' => 'PasswordController@remind'
	));

	/*
	| Create account (GET)
	*/
	Route::get('/account/create', array(
		'as' => 'account-create',
		'uses' => 'AccountController@getCreate'
	));

	/*
	| Login (GET)
	*/
	Route::get('/account/login', array(
		'as' => 'account-login',
		'uses' => 'AccountController@getLogin'
	));

	Route::get('/account/activate/{code}', array(
		'as' => 'account-activate',
		'uses' => 'AccountController@getActivate'
	));
});