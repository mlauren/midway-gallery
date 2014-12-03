<?php

class SlideshowController extends BaseController {

  public $recordType = 'Slides';

  /*
  | Get the page that displays the form to
  | configure and add new slides
  */
  public function getEditSlides() {
    $slides = Slides::all();
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
  | Small function to handle the individual 
  | add response and return an id of the new 
  | object we've created
  */
  public function postAddAutoSave() {
    // --- Create a new object --- //
    $record = Slides::create(
      array(
        'published' => false,
        'autodraft' => true
      )
    );
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
  | Function that saves the automatically created
  | function here
  */
  public function postEditSlides($id) {
    // If the id is not being sent to the route,
    // return an error
    if ( empty($id) )
      return Response::json(array(
        'success' => false,
        'error' => 'Something went wrong.'
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
        'error' => 'Only 6 slides are allowed'
      ));
    // --- Find Object by ID --- //
    $record = Slides::find($id);
    if ( $record == null || empty($record) )
      return Response::json(array(
        'success' => false,
        'error' => 'Something went wrong.'
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

  /*
  | Function that saves the updated
  | order of each slide
  */
  public function postEditSlidesOrder($id) {
    // Take each of the input values based on
    // Inputs -- data-id and data-order
  }

}