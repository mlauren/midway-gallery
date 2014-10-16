<?php
class EventController extends BaseController
{
  public function viewAll()
  {

  }

  public function add()
  {
    $exhibits = Tools::displayAllPubExhibits();
    $states = Tools::displayUSStates();
    return View::make('events.add')
      ->with('states', $states)
      ->with('exhibits', $exhibits);
  }

  public function postAdd()
  {

  }

  public function edit($id)
  {
    $states = Tools::displayUSStates();
    return View::make('events.edit')
      ->with('states', $states)
      ->with('id', $id);
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