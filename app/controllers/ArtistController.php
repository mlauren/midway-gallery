<?php
class ArtistController extends BaseController {

  public function getArtists() {
    return View::make('artist');
  }

  public function getArtist($name) {
    $artist = Artist::where('permalink', '=', $name);
    $artist = $artist->first();
    $inside_image = Media::find($artist->inside_image);
    var_dump($artist->inside_image);
    return View::make('artists.single')
          ->with('artist', $artist)
          ->with('inside_image', $inside_image);
  }

  public function getAddArtist() {
    return View::make('artists.add');
  }

  public function getEditArtist($id) {
    $artist = Artist::find($id);
    return View::make('artists.edit')
      ->with('artist', $artist);
  }

  public function postAddArtist() {
    $validator = Validator::make(
      Input::all(), Artist::$rules
    );
    if ($validator->fails()) {
      return Redirect::route('partner-add')
        ->withErrors($validator)
        ->withInput();
    }
    $user_id = Auth::user()->id;

    $artist = Artist::create(
      array(
        'name' => Input::get('name'),
        'credentials' => Input::get('credentials'),
        'description' => Input::get('description'),
        'user_id' => $user_id,
        'permalink' => Tools::permalink(Input::get('name'))
      )
    );
    if (Input::hasFile('cover_image')) {
      $media = new Media;
      $cover_image = $media->addMedia('cover_image', $artist, $user_id);
    }
    if (Input::hasFile('inside_image')) {
      $media = new Media;
      $inside_image = $media->addMedia('inside_image', $artist, $user_id);
    }
    $artist
      ->update(
        array(
          'cover_image' => $cover_image,
          'inside_image' => $inside_image
      ));
    $artist->save();
    return Redirect::route('partner-add')
        ->with('status', 'alert-success')
        ->with('global', 'You have successfully added a new artist/partner.');
  }

  public function postEditArtist() {

  }

}