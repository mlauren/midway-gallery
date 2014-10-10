<?php
class ExhibitController extends BaseController
{
  public function viewAll()
  {

  }

  public function add()
  {
    $states = Tools::displayUSStates();
    return View::make('add-edit')
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



}