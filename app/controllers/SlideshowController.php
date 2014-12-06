<?php

class SlideshowController extends BaseController {

  public $recordType = 'Slides';

  /*
  | Get the page that displays the form to
  | configure and add new slides
  */
  public function getEditSlides() {
    // $slides = Slides::all();
    $slides = Slides::orderBy('slide_order', 'ASC')->get();
    return View::make('slideshow.configure')
      ->with('page_title', 'Slides')
      ->with('slides', $slides);
  }

  /*
  | Get the page that displays the form to
  | add a single slide
  */
  public function getAddSingle() {
    return View::make('slideshow.add');
  }

  /*
  | Function to remove a slide object
  */
  public function postRemove() {
    $record = Slides::find(Input::get('data-id'));
    if ($record->media) {
      $removeMedia = Media::removePrevMedia($record);
      if ( $removeMedia == false ) {
        return Response::json(array(
          'success' => false
        ));
      }
    }
    $deletion = $record->delete();
    return Response::json(array(
      'success' => $deletion
    ));
  }

  /*
  | Function to add an image id to the
  | slide object
  */
  public function postAddMedia() {
    // functionality to add images to record
    if (Input::hasFile('file') && Input::has('data-id'))
    {
      $id = Input::get('data-id');
      $record = Slides::find($id);

      // Removes the Media
      $removePrevMedia = Media::removePrevMedia($record);

      if ( $record != null ) {
        $file = Input::file('file');
        // -- static method that validates file -- //
        $validator = Media::validateMedia($file);
        if ($validator->fails()) {
          return Response::json(array(
            'success' => false,
            'error_msg' => $file->isValid()
          ));
        }

        // -- Move And Save File -- //
        $user_id = Auth::user()->id;
        $files_location = Media::moveAndSaveMediaFiles($file);

        if ($files_location != false) {
          $imageMinDest = $files_location['imageMinDest'];
          $imgOrigDest = $files_location['imgOrigDest'];
          // -- Save the media object -- //
          $mediaSave = Media::saveMediaToObjParent(
            $record, $user_id, $imageMinDest, $imgOrigDest);
          // -- Save the media id to the record object local key -- //
          if ( $mediaSave != false ) {
            $updateRecord = $record->update(array('slide_image' => $mediaSave->id));
            if ( $updateRecord != null ) {
              // ------ return some json ----- //
              return Response::json(array(
                'success' => true,
                'img_min_obj' => $mediaSave->img_min
              ));
            }
          }
        }
        // -- Return some specific errors -- //
        return Response::json(array(
          'success' => false,
          'error_msg' => 'Something went wrong with moving or saving your image.'
        ));
      }
      return Response::json(array(
        'success' => false,
        'error_msg' => $id
      ));
    }
  }

  /*
  | Small function to handle the individual 
  | add response and return an id of the new 
  | object we've created
  */
  public function postAddAutoSave() {
    // --- Create a new object --- //
    $record = Slides::create(
      array(
        'slide_order' => Input::get("data-order"),
        'slide_image' => 'null'
    ));
    $record->save();
    // --- Return object ID response JSON --- //
    if ( $record != null )
      return Response::json(
        array(
          'success' => true,
          'id' => $record->id
        )
      );
    return Response::json(
      array(
        'success' => false,
        'id' => 'Something went wrong'
      )
    );
  }

  /*
  | Small function to update slide order
  */
  public function postUpdateOrder() {
    $id = Input::get("data-id");
    $order = Input::get("data-order");
    // --- Create a new object --- //
    $record = Slides::find($id);

    $record->update(
      array(
        'slide_order' => $order
    ));
    $record->save();
    // --- Return object ID response JSON --- //
    if ( $record != null )
      return Response::json(
        array(
          'success' => true,
        )
      );
    return Response::json(
      array(
        'success' => false,
        'id' => 'Something went wrong'
      )
    );
  }

  /*
  | Function that saves the automatically created
  | function here
  */
  public function testEditSlides($id) {
    // If the id is not being sent to the route,
    // return an error
    if ( empty($id) )
      return Response::json(array(
        'success' => false,
        'error_msg' => 'Something went wrong.'
      ));

    // --- Validate all the Input Values --- //
    $validator = Validator::make(
      array(),
      array()
    );
    // If the validation fails return an error
    if ( $validator->fails() )
      return Response::json(array(
        'success' => false,
        'error' => $validator->messages(),
        'type' => 'validation'
      ));
    // Return an error if there are more than 6 Slides
    // Maybe add a custom validation class for this
    $slidesNum = Slides::all()->count();
    if ( $slidesNum > 6 )
      return Response::json(array(
        'success' => false,
        'error_msg' => 'Only 6 slides are allowed'
      ));
    // --- Find Object by ID --- //
    $record = Slides::find($id);
    if ( $record == null || empty($record) )
      return Response::json(array(
        'success' => false,
        'error_msg' => 'Something went wrong.'
      ));
    // --- Update Object --- //
    $updateRecord = $record->update(

    );
    if ($updateRecord)
      return Response::json(array(
        'success' => true,
        'slide_object' => $updateRecord
      ));
  }

}