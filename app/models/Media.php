<?php
class Media extends Eloquent {

	/*
	public static $rules = array(
		'title'=>'required|min:3|max:50',
		'video'=>'active_url',
		'media'=>'required|mimes:png,gif,jpeg|max:20000',
		'published'=>'required'
	);
	*/

	
	protected $fillable = array(
		'user_id', 'img_min', 'img_big', 'mediable_id', 'mediable_type', 'slide_id'
	);

	/**
	 * Define my relationship to other objects 
	 */
	public function mediable()
  {
      return $this->morphTo();
  }

  /**
   * Define my relationship to slides 
   */
  public function slide()
  {
    return $this->belongsTo('Slides');
  }

  /**
   * Remove relationship to media 
   */
  public static function removePrevMedia($obj) {
    $media = $obj->media()->get();
    if (!empty($media)) {
      foreach ( $media as $media ) {
        $media = $media->delete();
      }
      return true;
    }
    return false;
  }

  /**
   * Define my relationship to media 
   */
  public static function validateMedia($file) {
    if ($file->isValid()) {
      $validator = Validator::make(
        array('file' => $file),
        array('file' => 'mimes:png,gif,jpeg|max:50000')
      );
      return $validator;
    }
  }

  public static function moveAndSaveMediaFiles($file) {
    // Process the image and return the location for
    // its small cropped image
    $currentMo = date('Y_M');
    $destination = "uploads/$currentMo";
    $filename = $file->getClientOriginalName();
    $filename = Exhibit::string_convert($filename);

    $uploadSuccess = $file->move($destination, "$filename");
    if ($uploadSuccess) {
      $imgOrigDest = $destination . '/' . $filename;
      $imageMinDest = $destination . '/min_' . $filename;
      $imageMin = Image::make($imgOrigDest)->crop(250, 250, 10, 10)->save($imageMinDest);

      // -- return an array that returns the info neccessary to create a media object
      return array(
        'imageMinDest' => $imageMinDest,
        'imgOrigDest' => $imgOrigDest
      );
    }
    return false;
  }

  public static function saveMediaToObjParent($morphParentObj, $user_id, $imageMinDest, $imgOrigDest) {
    // Saves the media and adds the appropriate foreign keys for the exhibit
    $media = $morphParentObj->media()->create([
      'user_id' => $user_id,
      'img_min' => $imageMinDest,
      'img_big' => $imgOrigDest
    ]);
    if ( $media )
      $morphParentObj->media()->save($media);
      return $media;
    return false;
  }

  public static function addMedia($fileName, $objType, $user_id, $route) {
		$file = Input::file($fileName);
    $currentMo = date('Y_M');
    $destination = "uploads/$currentMo";
    $filename = $file->getClientOriginalName();
    $filename = Exhibit::string_convert($filename);
    // $cleanFilename = Exhibit::permalink($filename);
    // Move the new file into the uploads directory
    $uploadSuccess = $file->move($destination, "$filename");
    $imgOrigDestination = $destination . '/' . $filename;

    // Check to make sure that upload was successful and add the content
    if ($uploadSuccess) {
      $imageMinDestination = $destination . '/min_' . $filename;
      $imageMin = Image::make($imgOrigDestination)->crop(250, 250, 10, 10)->save($imageMinDestination);

      // Saves the media and adds the appropriate foreign keys for the exhibit
      $media = $objType->media()->create([
        'user_id' => $user_id,
        'img_min' => $imageMinDestination,
        'img_big' => $imgOrigDestination
      ]);
      $objType->media()->save($media);
      return $media->id;
    }
    else {
      if ( $route == 'back' ) {
        return Redirect::back()
          ->with('status', 'alert-error')
          ->with('global', 'Something went wrong with uploading your photos.');
      }
      return Redirect::route($route)
        ->with('status', 'alert-error')
        ->with('global', 'Something went wrong with uploading your photos.');
    }
  }

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'media';
}


?>