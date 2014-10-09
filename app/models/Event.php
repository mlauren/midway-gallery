<?php
  class Event extends Eloquent
  {
    public static $rules = array(
      'title'=>'unique:events,title|required|min:3|max:50',
      'social' => 'url',
      'media'=>'required|mimes:jpeg,bmp,png|between:0,4000',
    );
    public static $rulesEdit = array(
      'title'=>'required|min:3|max:50',
      'url' => 'url',
      'cover_image'=>'required|mimes:jpeg,bmp,png|between:0,4000',
    );

    protected $fillable = array(
      'user_id', 'title', 'permalink', 'details', 'permalink', 'address_title', 'address', 'media', 'exhibit_id', 'created_at'
    );

    protected $table = 'events';

    public function media()
    {
      return $this->morphMany('Media', 'mediable');
    }
  }