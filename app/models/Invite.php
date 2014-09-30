<?php
 
class Invite extends Eloquent {
 
  /**
   * Properties that can be mass assigned
   *
   * @var array
   */
  protected $fillable = array('code', 'email');


  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'media';

  public function getValidInviteByCode($code)
  {
    return $this->model->where('code', '=', $code)
                       ->where('claimed_at', '=', null)
                       ->first();
  }
 
}
