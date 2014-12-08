<?php

class SlideshowController extends BaseController {

  public $recordType = 'Slides';

  /*
  | Get the page that displays the form to
  | configure and add new slides
  */
  public function getEditSlides() {
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
  | Function to delete and remove Media from Slide.
  */
  public function postRemoveMedia() {
    $id = Input::get('data-id');
    $record = Slides::find($id);
    // Remove Media Helper Function
    $removeMedia = Media::removePrevMedia($record);
    if ( $removeMedia != false ) {
      return Response::json(array(
        'success' => true
      ));
    }
    return Response::json(array(
      'success' => false
    ));
  }

  /*
  | Function to add text data to the
  | slide object
  */
  public function postAddText() {
    $type = Input::get('txtType');
    $value = Input::get('txtValue');
    $id = Input::get('data-id');
    $record = Slides::find($id);

    if ( $type == 'title' && !empty($value) ) {
      $record->slide_title = $value;
      $record->save();
      return Response::json(array(
        'success' => true
      ));
    }

    if ( $type == 'details' && !empty($value) ) {
      $record->slide_text = $value;
      $record->save();
      return Response::json(array(
        'success' => true
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

}
