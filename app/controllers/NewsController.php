<?php
  class NewsController extends BaseController
  {

    public function showAll() {
      $news = News::all();

      return View::make('news.show-all')
        ->with('news', $news)
        ->with('page_title', 'News');
    }

    public function getAdd() {
      return View::make('news.add')
        ->with('page_title', 'Add a News Item');
    }

    public function postAdd() {
      $validator = Validator::make(
        Input::all(), News::$rules
      );
      if ($validator->fails()) {
        return Redirect::route('news-add')
          ->withErrors($validator)
          ->withInput();
      }
      $user_id = Auth::user()->id;

      $new = News::create(
        array(
          'title' => Input::get('title'),
          'url' => Input::get('url'),
          'description' => Input::get('description'),
          'user_id' => $user_id,
          'permalink' => Tools::permalink(Input::get('title'))
        )
      );
      if (Input::hasFile('cover_image')) {
        $media = new Media;
        $cover_image = $media->addMedia('cover_image', $new, $user_id, 'news-add');
        $new
        ->update(
          array(
            'cover_image' => $cover_image,
          ));
      }
      $new->save();

      return Redirect::route('news')
        ->with('status', 'alert-success')
        ->with('global', 'You have successfully added a new artist/partner.');
    }

    public function getEdit($id) {
      $news = News::find($id);
      return View::make('news.edit')
        ->with('news', $news)
        ->with('page_title', 'Edit ' . $news->title)
        ->with('id', $id);
    }

    public function postEdit() {
      $newsItem = News::find(Input::get('id'));

      $validator = Validator::make(
        Input::all(), News::$rulesEdit
      );
      if ($validator->fails()) {
        return Redirect::back()
          ->withErrors($validator)
          ->withInput();
      }
      $user_id = Auth::user()->id;

      $newsItem->update(
        array(
          'title' => Input::get('title'),
          'url' => Input::get('url'),
          'description' => Input::get('description'),
          'user_id' => $user_id,
          'permalink' => Tools::permalink(Input::get('title'))
        )
      );
      if (Input::hasFile('cover_image')) {
        $cover_image = Media::addMedia('cover_image', $newsItem, $user_id, 'back');
        $newsItem
        ->update(
          array(
            'cover_image' => $cover_image,
          ));
      }
      $newsItem->save();
      return Redirect::route('news')
        ->with('status', 'alert-success')
        ->with('global', 'You have successfully added a new artist/partner.');
    }
    public function removeNews($id) {
      $news = News::find($id);
      $name = $news->title;
      $news->delete();
      return Redirect::route('account')
        ->with('status', 'alert-success')
        ->with('global', 'You just deleted ' . $name);
    }
  }