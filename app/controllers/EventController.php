<?php
class EventController extends BaseController
{
  public function viewAll()
  {
    return View::make('events.all');
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
    $validator = Validator::make(
      array(
        'title' => Input::get('title'),
        'social' => Input::get('social'),
        'media' => Input::get('image')
      ),
      array(
        'title'=>'unique:events,title|required|min:3|max:50',
        'social' => 'url',
        'media'=>'mimes:jpeg,bmp,png|between:0,4000'
      )
    );
    if ( $validator->fails() ) {
      return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }
    $address = array(Input::get('address1'), Input::get('address2'), Input::get('address3'));
    $address = SiteEvents::makeAddress($address);
    $user_id = Auth::user()->id;

    $event = SiteEvents::create(
      array(
        'user_id' => $user_id,
        'permalink' => Tools::permalink(Input::get('title')),
        'title' => Input::get('title'),
        'details' => Input::get('details'),
        'social' => Input::get('social'),
        'address_title' => Input::get('address_title'),
        'address' => $address,
        'exhibit_id' => (int)Input::get('exhibit_id')
      )
    );

    if ( Input::hasFile('image') )
    {
      $media = Media::addMedia('image', $event, $user_id, 'back');
    }
    $event->save();
    return Redirect::route('events')
      ->with('status', 'alert-success')
      ->with('global', 'You have successfully added a new event.');
  }

  /**
   *
   * Function to process existing event types
   * @param $id
   * @return mixed
   */
  public function edit($id)
  {
    $event = SiteEvents::find($id);
    $exhibits = Tools::displayAllPubExhibits();
    $states = Tools::displayUSStates();

    $address = SiteEvents::extractAddress($event->address);

    return View::make('events.edit')
      ->with('states', $states)
      ->with('id', $id)
      ->with('address', $address)
      ->with('event', $event)
      ->with('exhibits', $exhibits);
  }

  public function postEdit($id)
  {
    $event = SiteEvents::find($id);
    $validator = Validator::make(
      array(
        'title' => Input::get('title'),
        'social' => Input::get('social'),
        'media' => Input::get('image')
      ),
      array(
        'title'=>'min:3|max:50',
        'social' => 'url',
        'media'=>'mimes:jpeg,bmp,png|between:0,4000'
      )
    );
    if ( $validator->fails() ) {
      return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }
    $address = array(Input::get('address1'), Input::get('address2'), Input::get('address3'));
    $address = SiteEvents::makeAddress($address);
    $user_id = Auth::user()->id;

    $event->update(
      array(
        'user_id' => $user_id,
        'permalink' => Tools::permalink(Input::get('title')),
        'title' => Input::get('title'),
        'details' => Input::get('details'),
        'social' => Input::get('social'),
        'address_title' => Input::get('address_title'),
        'address' => $address,
        'exhibit_id' => (int)Input::get('exhibit_id')
      )
    );

    if ( Input::hasFile('image') )
    {
      $media = Media::addMedia('image', $event, $user_id, 'back');
    }
    $event->save();
    return Redirect::route('events')
      ->with('status', 'alert-success')
      ->with('global', 'You have successfully updated ' . $event->title . '.');

  }

  public function delete($id)
  {
    $event = SiteEvents::find($id);
    $name = $event->name;
    $event->delete();
    return Redirect::route('account')
      ->with('status', 'alert-success')
      ->with('global', 'You just deleted ' . $name);
  }

  public function setPostVarIfExists() {
    // $address = ;
  }


}