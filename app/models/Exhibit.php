<?php
class Exhibit extends Eloquent {

	public static $rules = array(
		'title'=>'unique:exhibits,title|required|min:3|max:50',
		'video'=>'url',
	);

	protected $fillable = array(
		'user_id', 'title', 'permalink', 'details', 'video', 'media', 'published'
	);

	public static function permalink($title) 
	{
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $title);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
		return $clean;
	}

	/**
	 * Define my relationship to media 
	 */
	public function media()
    {
        return $this->morphMany('Media', 'mediable');
    }

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'exhibits';
}


?>