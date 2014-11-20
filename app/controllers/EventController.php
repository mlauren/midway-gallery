<?php
class EventController extends BaseController
{
  public function viewAll()
  {
    $events = DB::table('events')->orderBy('created_at', 'desc')->get();

    return View::make('events.all')
      ->with('events', $events)
      ->with('address');
  }

  public function add()
  {
    // Add event with option to display states and exhibits
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
        'image' => Input::get('image'),
        'event_time' => Input::get('event_time')
      ),
      array(
        'title'=>'unique:events,title|required|min:3|max:50',
        'social' => 'url',
        'image'=>'mimes:jpeg,bmp,png|between:0,4000',
        'event_time' => 'required'
      )
    );
    if ( $validator->fails() ) {
      return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }
    if (Input::has('address1') &&  Input::has('address2')) {
      $address = array(Input::get('address1'), Input::get('address2'), Input::get('address3'));
      $address = SiteEvents::makeAddress($address);
    }
    else {
      $address = '';
    }
    $user_id = Auth::user()->id;

    $event_time = strtotime(Input::get('event_time'));
    $event_time = date('Y-m-d H:i:s', $event_time);

    $event_time_end = strtotime(Input::get('event_time_end'));
    $event_time_end = date('Y-m-d H:i:s', $event_time_end);

    $event = SiteEvents::create(
      array(
        'user_id' => $user_id,
        'permalink' => Tools::permalink(Input::get('title')),
        'title' => Input::get('title'),
        'details' => Input::get('details'),
        'social' => Input::get('social'),
        'address_title' => Input::get('address_title'),
        'address' => $address,
        'exhibit_id' => (int)Input::get('exhibit_id'),
        'event_time' => $event_time,
        'event_time_end' => $event_time_end
      )
    );

    if ( Input::hasFile('image') )
    {
      $image = Media::addMedia('image', $event, $user_id, 'back');
      $event
      ->update(
        array(
          'image' => $image,
        ));
    }
    if ($event->media) {
      foreach ($event->media as $media) {
        if ( $media->id != $event->image ) {
          $media->remove();
        }
      }
    }
    $event->save();

    return Redirect::route('events')
      ->with('status', 'alert-success')
      ->with('global', 'You have successfully added a new event.');
  }

  public function postRemoveMedia($id) {
    $media = Media::find($id);
    $media = new Media;
    $media->delete();

    $media = Media::find($id);
    $owner = $media->mediable_id;
    $ownerType = $media->mediable_type;
    $owner = $ownerType::find($owner);
    $isAjax = Request::ajax();

    // Disasociate this from its parent exhibit
    foreach ($owner->media as $key => $image) {
      if ($image->id == $id) {
        $owner->media[$key]->update([
          'mediable_id' => 0,
          'mediable_type' => null
        ]);
        $mediasave = $owner->media[$key]->save();
      }
    }
    if ( $mediasave == true ) {
      $outcome = $owner
      ->update(
        array(
          'image' => '',
        ));
    }
    return json_encode($outcome);
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
        'image' => Input::get('image'),
        'event_time' => Input::get('event_time')
      ),
      array(
        'title'=>'min:3|max:50',
        'social' => 'url',
        'image'=>'mimes:jpeg,bmp,png|between:0,4000',
        'event_time' => 'required'
      )
    );
    if ( $validator->fails() ) {
      return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }
    if (Input::has('address1') &&  Input::has('address2')) {
      $address = array(Input::get('address1'), Input::get('address2'), Input::get('address3'));
      $address = SiteEvents::makeAddress($address);
    }
    else {
      $address = null;
    }
    $user_id = Auth::user()->id;

    $event_time = strtotime(Input::get('event_time'));
    $event_time = date('Y-m-d H:i:s', $event_time);
    $event_time_end = strtotime(Input::get('event_time_end'));
    $event_time_end = date('Y-m-d H:i:s', $event_time_end);

    $event->update(
      array(
        'user_id' => $user_id,
        'permalink' => Tools::permalink(Input::get('title')),
        'title' => Input::get('title'),
        'details' => Input::get('details'),
        'social' => Input::get('social'),
        'address_title' => Input::get('address_title'),
        'address' => $address,
        'exhibit_id' => (int)Input::get('exhibit_id'),
        'event_time' => $event_time,
        'event_time_end' => $event_time_end
      )
    );

    if ( Input::hasFile('image') )
    {
      $image = Media::addMedia('image', $event, $user_id, 'back');
      $event
      ->update(
        array(
          'image' => $image,
        ));
    }
    if ($event->media) {
      foreach ($event->media as $media) {
        if ( $media->id != $event->image ) {
          $media->delete();
        }
      }
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