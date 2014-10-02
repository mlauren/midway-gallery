<?php

class Artist extends Eloquent {

  /**
   * Properties that can be mass assigned
   *
   * @var array
   */
  protected $fillable = array('name', 'cover_image', 'credentials', 'description', 'inside_image', 'created_at');

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