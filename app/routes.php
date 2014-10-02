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
    |
    |
    | Artist Related GET Routes:
    |
    |
    */
    /*
    | Show All the artists
    */
    Route::get('/artists', array(
      'as' => 'artists-show-all',
      'uses' => 'ArtistController@getArtists'
    ));



  /*
  |
  |
  | Exhibit Related GET Routes:
  |
  |
  */
  /*
  | Show All the exhibits
  */
  Route::get('/exhibits', function () {
    $recent_exhibit = DB::table('exhibits')->orderBy('created_at', 'desc')->first();
    var_dump($recent_exhibit);

    return Redirect::to('/exhibits/' . $recent_exhibit->permalink);
  });
  /*
  | Show single exhibit
  */
  Route::get('/exhibits/{name}', array(
    'as' => 'exhibits-show-single',
    'uses' => 'ExhibitController@single'
  ));

  /*
  | Authenticated Group
  */
  Route::group(array('before' => 'auth'), function () {


    /*
    | CSRF protection
    */
    Route::group(array('before' => 'csrf'), function () {

      /*
      | Change Password (POST)
      */
      Route::post('/account/change-pwd', array(
        'as' => 'account-change-pwd-post',
        'uses' => 'AccountController@postChangePwd'
      ));

      /*
      | Change Password (POST)
      */
      Route::post('/account/change-pwd', array(
        'as' => 'account-change-pwd-post',
        'uses' => 'AccountController@postChangePwd'
      ));

      /*
      |
      |
      | Artist Related POST Routes:
      |
      |
      */
      Route::post('/partner-add', array(
        'as' => 'partner-add-post',
        'uses' => 'ArtistController@postAddArtist'
      ));


        /*
        |
        |
        | Exhibit Related POST Routes:
        |
        |
        */
      Route::post('/exhibit-add', array(
        'as' => 'exhibits-add-post',
        'uses' => 'ExhibitController@postAdd'
      ));

      /*
      | Form to add exhibit
      */
      Route::post('/exhibits/{id}/edit', array(
        'as' => 'exhibits-edit-post',
        'uses' => 'ExhibitController@postEditSingle'
      ));
    });


    /*
    | Invites
    */
    Route::post('invite', array(
      'uses' => 'InviteController@store',
      'as' => 'invite.store'
    ));

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
    /*
    |
    |
    | Media Related AJAX Routes:
    |
    |
    */
    /*
    | Media removes media and detaches it from parent:
    */
    Route::post('/media/{id}/remove', array(
      'as' => 'media-remove-unlink',
      'uses' => 'MediaController@postRemoveMedia'
    ));
    /*
    | Media adds media and attaches it to parent id:
    */
    Route::post('/media-add', array(
      'as' => 'media-add-link',
      'uses' => 'MediaController@postAddMedia'
    ));

    /*
    | Media adds media and attaches it to parent id:
    */
    Route::post('/media-add-id-order', array(
      'as' => 'media-add-id-order',
      'uses' => 'MediaController@postUpdateMediaIDsOrder'
    ));

    /*
    |
    |
    | Exhibit Related POST AJAX:
    | Post an exhibit that is empty and autosave
    |
    */
    Route::post('/exhibit-add-empty', array(
      'as' => 'exhibit-add-empty',
      'uses' => 'ExhibitController@exhibitAddEmpty'
    ));


    /*
    |
    |
    | Exhibit Related GET Routes:
    |
    |
    */
    /*
    | Form to add artist
    */
    Route::get('/partner-add', array(
      'as' => 'partner-add',
      'uses' => 'ArtistController@getAddArtist'
    ));

    /*
    |
    |
    | Exhibit Related GET Routes:
    |
    |
    */
    /*
    | Form to add exhibit
    */
    Route::get('/exhibit-add', array(
      'as' => 'exhibits-add',
      'uses' => 'ExhibitController@getAdd'
    ));
    /*
    | Form to add exhibit
    */
    Route::get('/exhibits/{id}/edit', array(
      'as' => 'exhibits-edit-single',
      'uses' => 'ExhibitController@editSingle'
    ));
    /*
    | Link to remove exhibit
    */
    Route::get('/exhibits/{id}/remove', array(
      'as' => 'exhibits-remove-single',
      'uses' => 'ExhibitController@postRemoveSingle'
    ));

  });


  /*
  | Unauthenticated Group
  | Check to make sure the user is not authenticated
  */
  Route::group(array('before' => 'guest'), function () {

    /*
    | CSRF protection
    */
    Route::group(array('before' => 'csrf'), function () {
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

      /*
      | Reset Password (POST)
      */
      Route::post('/account/password-reset', array(
        'as' => 'account-password-reset-post',
        'uses' => 'PasswordController@postRemind'
      ));

      /*
      | Post Reset Password Page With Token (GET)
      */
      Route::post('/account/password-reset/{token}', array(
        'as' => 'account-password-update',
        'uses' => 'PasswordController@postUpdatePwdWithToken'
      ));

    });

    /*
    | Reset Password Page With Token (GET)
    */
    Route::get('/account/password-reset/{token}', array(
      'as' => 'account-password-reset-token',
      'uses' => 'PasswordController@getRemindToken'
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