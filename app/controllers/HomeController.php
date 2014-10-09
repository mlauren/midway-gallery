<?php

  class HomeController extends BaseController
  {
    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'layout.main';

    public function home()
    {
      return View::make('home')
        ->with('page_title', 'Home');
    }

  }
