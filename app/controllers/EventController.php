<?php
class EventController extends BaseController
{
  public function viewAll()
  {

  }

  public function add()
  {

    $states = Tools::displayUSStates();
    return View::make('events.add-edit')
      ->with('states', $states);
  }

  public function postAdd()
  {

  }

  public function edit()
  {
    return View::make('add-edit');
  }

  public function postEdit()
  {

  }

  public function delete()
  {

  }

  public function setPostVarIfExists() {
    // $address = ;
  }


}