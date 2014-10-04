<?php

class InviteController extends BaseController {
 
  
 
  /**
   * Create a new invite
   *
   * @return Response
   */
  public function account()
  {
    $invite = $this->repository->create(Input::all());
  }
 
}