<?php

class SlideshowController extends BaseController {

	public function getEditSlides() {
		return View::make('slideshow.configure')
			->with('page_title', 'Home');
	}

}