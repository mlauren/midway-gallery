<?php
  class Slides extends Eloquent
  {
    protected $table = 'slides';

    protected $fillable = array(
      'slide_image', 'slide_title', 'slide_text', 'slide_order'
    );

    public function media()
    {
        return $this->hasOne('Media', 'slide_id');
    }

  }