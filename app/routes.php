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
  | Exhibit Related GET Routes:
  |
  |
  */
  /*
  | Show All the exhibits
  */
  Route::get('/exhibits', array(
    'as' => 'exhibits',
    'uses' => 'ExhibitController@showAll'
  ));
  /*
  | Show single exhibit
  */
  Route::get('/exhibits/{name}', array(
    'as' => 'exhibits-show-single',
    'uses' => 'ExhibitController@single'
  ));
  /*
  |
  |
  | Artists Related GET Routes:
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
  | Show a single artists profile
  */
  Route::get('/artists/{name}', array(
    'as' => 'artists-show-single',
    'uses' => 'ArtistController@getArtist'
  ));


  /*
  |
  |
  | News Related GET Routes:
  |
  |
  */
  /*
  | Show All the news
  */
  Route::get('/news', array(
    'as' => 'news',
    'uses' => 'NewsController@showAll'
  ));

  /*
  |
  |
  | Event Related GET Routes:
  |
  |
  */
  /*
  | Show All the events
  */
  Route::get('/events', array(
    'as' => 'events',
    'uses' => 'EventController@viewAll'
  ));
  /*
  |
  |
  | News Related GET Routes:
  |
  |
  */
  /*
  | Show All the exhibits
  */
  Route::get('/news', array(
    'as' => 'news',
    'uses' => 'NewsController@showAll'
  ));
  /*
  |
  |
  | Slideshow related GET Routes
  |
  |
  */

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
      | Form to edit artist
      */
      Route::post('/partner/{id}/edit', array(
        'as' => 'partner-edit-post',
        'uses' => 'ArtistController@postEditArtist'
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

      /*
      |
      |
      | Exhibit Related POST Routes:
      |
      |
      */
      Route::post('/event-add', array(
        'as' => 'event-add-post',
        'uses' => 'EventController@postAdd'
      ));
      /*
      | Form to add exhibit
      */
      Route::post('/events/{id}/edit', array(
        'as' => 'events-edit-post',
        'uses' => 'EventController@postEdit'
      ));

      /*
      |
      |
      | News Related POST Routes:
      |
      |
      */
      /*
      | Form to edit artist
      */
      Route::post('/news-add', array(
        'as' => 'news-add-post',
        'uses' => 'NewsController@postAdd'
      ));
      /*
      | Form to edit artist
      */
      Route::post('/news/{id}/edit', array(
        'as' => 'news-edit-post',
        'uses' => 'NewsController@postEdit'
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
    | Media removes media and detaches it from news parent:
    */
    Route::post('/event-media/{id}/remove', array(
      'as' => 'event-media-remove-unlink',
      'uses' => 'EventController@postRemoveMedia'
    ));
    /*
    | Media removes media and detaches it from news parent:
    */
    Route::post('/news-media/{id}/remove', array(
      'as' => 'news-media-remove-unlink',
      'uses' => 'NewsController@postRemoveMedia'
    ));
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
    | Slideshow related POST AJAX
    |
    |
    */
    /*
    | Slideshow Add
    */
    Route::post('/slide-add', array(
      'as' => 'slideshow-add-single',
      'uses' => 'SlideshowController@postAddAutoSave'
    ));
    /*
    | Slideshow Reorder
    */
    Route::post('/slide-reorder', array(
      'as' => 'slideshow-reorder',
      'uses' => 'SlideshowController@postUpdateOrder'
    ));

    /*
    | Specific function that deals with adding media
    */
    Route::post('/slide-edit-media', array(
      'as' => 'slideshow-edit-images',
      'uses' => 'SlideshowController@postAddMedia'
    ));

    /*
    | Slideshow Edit
    */
    Route::post('/slide-edit', array(
      'as' => 'slideshow-edit-single',
      'uses' => 'SlideshowController@postEditSlides'
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
    | Form to edit artist
    */
    Route::get('/partner/{id}/edit', array(
      'as' => 'partner-edit',
      'uses' => 'ArtistController@getEditArtist'
    ));
    /*
    | Form to edit artist
    */
    Route::get('/partner/{id}/delete', array(
      'as' => 'partner-delete',
      'uses' => 'ArtistController@removeArtist'
    ));


    /*
    |
    |
    | News Related GET Routes:
    |
    |
    */
    /*
    | Form to add artist
    */
    Route::get('/news-add', array(
      'as' => 'news-add',
      'uses' => 'NewsController@getAdd'
    ));
    /*
    | Form to edit artist
    */
    Route::get('/news/{id}/edit', array(
      'as' => 'news-edit',
      'uses' => 'NewsController@getEdit'
    ));
    /*
    | Delete artist
    */
    Route::get('/news/{id}/delete', array(
      'as' => 'news-delete',
      'uses' => 'NewsController@removeNews'
    ));

    /*
    |
    |
    | Events Related GET Routes:
    |
    |
    */
    /*
    | Form to add artist
    */
    Route::get('/event-add', array(
      'as' => 'event-add',
      'uses' => 'EventController@add'
    ));
    /*
    | Form to edit artist
    */
    Route::get('/events/{id}/edit', array(
      'as' => 'events-edit',
      'uses' => 'EventController@edit'
    ));
    /*
    | Delete artist
    */
    Route::get('/events/{id}/delete', array(
      'as' => 'events-delete',
      'uses' => 'EventController@delete'
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

    /*
    |
    |
    | Slideshow Related GET Routes:
    |
    |
    */
    /*
    | Slideshow Edit
    */
    Route::get('/slideshow-edit', array(
      'as' => 'slideshow-edit',
      'uses' => 'SlideshowController@getEditSlides'
    ));

    /*
    | Individual page to be used by ajax in order to add a form
    */
    Route::get('/slide-add', array(
      'as' => 'slide-add',
      'uses' => 'SlideshowController@getAddSingle'
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
    Route::group(array('before' => 'csrf'), function() {
      /**
       * Invite
       *
       * The route to create a new Invite
       */
      Route::post('invite', array(
        'uses' => 'InviteController@account',
        'as' => 'invite-account'
      ));

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