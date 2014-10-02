<?php
class InviteController extends BaseController {

  public function store() {
    $invite = new Invite;
    $invite = $invite->create(Input::all());
  }
}
