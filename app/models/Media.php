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
		'user_id', 'img_min', 'img_big'
	);

	/**
	 * Define my relationship to media 
	 */
	public function mediable()
    {
        return $this->morphTo();
    }


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'media';
}


?>