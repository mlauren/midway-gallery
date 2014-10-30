<?php
  class SiteEvents extends Eloquent
  {
    public static $rules = array(
      'title'=>'unique:events,title|required|min:3|max:50',
      'social' => 'url',
      'media'=>'mimes:jpeg,bmp,png|between:0,4000'
    );
    public static $rulesEdit = array(
      'title'=>'required|min:3|max:50',
      'social' => 'url',
      'media'=>'mimes:jpeg,bmp,png|between:0,4000'
    );

    public static function makeAddress($address)
    {
      return implode(', ', $address);
    }

    public static function extractAddress($address)
    {
      return explode(', ', $address);
    }

    protected $fillable = array(
      'user_id', 'title', 'social', 'details', 'event_time', 'event_time_end', 'permalink', 'address_title', 'address', 'image', 'exhibit_id', 'created_at'
    );

    protected $table = 'events';

    public function media()
    {
      return $this->morphMany('Media', 'mediable');
    }
  }