<?php
class ArtistController extends BaseController {

  public function getArtists() {
    $artists = Artist::all();
    return View::make('artist')
      ->with('artists', $artists)
      ->with('page_title', 'Artists and Partners');
  }

  public function getArtist($name) {
    $artist = Artist::where('permalink', '=', $name);
    $artist = $artist->first();
    $inside_image = Media::find($artist->inside_image);
    return View::make('artists.single')
          ->with('artist', $artist)
          ->with('inside_image', $inside_image);
  }

  public function getAddArtist() {
    return View::make('artists.add')
      ->with('page_title', 'Add an Artist');
  }

  public function getEditArtist($id) {
    $artist = Artist::find($id);
    return View::make('artists.edit')
      ->with('artist', $artist)
      ->with('page_title', 'Edit ' . $artist->title);
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
      $cover_image = $media->addMedia('cover_image', $artist, $user_id, 'partner-add');
    }
    if (Input::hasFile('inside_image')) {
      $media = new Media;
      $inside_image = $media->addMedia('inside_image', $artist, $user_id, 'partner-add');
    }
    $artist
      ->update(
        array(
          'cover_image' => $cover_image,
          'inside_image' => $inside_image
      ));
    $artist->save();
    return Redirect::route('artists-show-single', $artist->permalink)
      ->with('status', 'alert-success')
      ->with('global', 'You have successfully added a new artist/partner.');
  }

  public function postEditArtist($id) {
    $artist = Artist::find($id);
    $validator = Validator::make(
      Input::all(), array(
        'name'=>'required|min:3|max:50',
        'cover_image'=>'required|mimes:jpeg,bmp,png|between:0,4000',
        'inside_image'=>'required|mimes:jpeg,bmp,png|between:0,10000',
        'credentials'=>'min:3|max:70'
      )
    );
    if ($validator->fails()) {
      return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }
    $user_id = Auth::user()->id;
    $created_at = strtotime(Input::get('created_at'));
    $created_at = date('Y-m-d H:i:s', $created_at);

    $artist->update(
      array(
        'name' => Input::get('name'),
        'credentials' => Input::get('credentials'),
        'description' => Input::get('description'),
        'created_at' => $created_at,
        'user_id' => $user_id,
        'permalink' => Tools::permalink(Input::get('name'))
      )
    );
    if (Input::hasFile('cover_image')) {
      $media = new Media;
      $cover_image = $media->addMedia('cover_image', $artist, $user_id, 'partner-add');
    }
    if (Input::hasFile('inside_image')) {
      $media = new Media;
      $inside_image = $media->addMedia('inside_image', $artist, $user_id, 'partner-add');
    }
    $artist
      ->update(
        array(
          'cover_image' => $cover_image,
          'inside_image' => $inside_image
        ));
    $artist->save();
    return Redirect::route('artists-show-single', $artist->permalink)
      ->with('status', 'alert-success')
      ->with('global', 'You have successfully updated' . $artist->name);
  }

  public function removeArtist($id) {
    $artist = Artist::find($id);
    $name = $artist->name;
    $artist->delete();
    return Redirect::route('account')
      ->with('status', 'alert-success')
      ->with('global', 'You just deleted ' . $name);
  }

}