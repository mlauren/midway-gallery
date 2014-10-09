<?php
class News extends Eloquent
{
  public static $rules = array(
    'title'=>'unique:news,title|required|min:3|max:50',
    'url' => 'url',
    'cover_image'=>'required|mimes:jpeg,bmp,png|between:0,4000',
  );
  public static $rulesEdit = array(
    'title'=>'required|min:3|max:50',
    'url' => 'url',
    'cover_image'=>'required|mimes:jpeg,bmp,png|between:0,4000',
  );

  protected $fillable = array(
    'user_id', 'title', 'permalink', 'description', 'cover_image', 'url', 'created_at'
  );

  protected $table = 'news';

  public function media()
  {
    return $this->morphMany('Media', 'mediable');
  }
}