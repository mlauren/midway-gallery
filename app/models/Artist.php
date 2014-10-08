<?php

class Artist extends Eloquent {

  /**
   * Properties that can be mass assigned
   *
   * @var array
   */
  protected $fillable = array('name', 'cover_image', 'credentials', 'description', 'inside_image', 'created_at', 'user_id', 'permalink');

  public static $rules = array(
    'name'=>'unique:artists,name|required|min:3|max:50',
    'cover_image'=>'required|mimes:jpeg,bmp,png|between:0,4000',
    'inside_image'=>'required|mimes:jpeg,bmp,png|between:0,10000',
    'credentials'=>'min:3|max:70'
  );
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'artists';

  /**
   * Define my relationship to media
   */
  public function media()
  {
    return $this->morphMany('Media', 'mediable');
  }


}