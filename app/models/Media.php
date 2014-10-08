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
		'user_id', 'img_min', 'img_big', 'mediable_id', 'mediable_type'
	);

	/**
	 * Define my relationship to media 
	 */
	public function mediable()
    {
        return $this->morphTo();
    }

  public function addMedia($fileName, $objType, $user_id) {
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
    	return Redirect::route('partner-add')
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