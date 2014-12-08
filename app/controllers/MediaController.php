<?php

  class MediaController extends BaseController
  {

    public function postRemoveMedia($id)
    {
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
      $mediasave = $mediasave ? true : false;
      if ($isAjax) {
        return json_encode($mediasave);
      } else {
        return Redirect::back()
          ->with('status', 'alert-danger')
          ->with('global', 'Something went wrong!');
      }
    }


    /*
    | Function to add an image to a specific exhibit object
    */
    public function postAddExhibitMedia() {
      // functionality to add images to record
      if (Input::hasFile('file') && Input::has('data-id') && Input::has('data-type'))
      {
        $type = Input::get('data-type');
        $id = Input::get('data-id');
        // Retrieve the object type
        $type = new $type;
        $record = $type::find($id);

        // --- Make sure that the class passed into the formdata exists --- //
        if ( null != $record ) {

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
                return Response::json(array(
                  'success' => true,
                  'img_min_dest' => $imageMinDest,
                  'media_id' => $mediaSave->id
                ));
              }
              return Response::json(array(
                'success' => false,
                'error_msg' => 'Your image was not saved.'
              ));
            }
            // -- Return some specific errors -- //
            return Response::json(array(
              'success' => false,
              'error_msg' => 'Something went wrong with moving your image.'
            ));
          }
        }
        return Response::json(array(
          'success' => false,
          'error_msg' => 'Something went wrong.'
        ));
      }
      return Response::json(array(
        'success' => false,
        'error_msg' => 'Something went wrong with adding an image.'
      ));
    }

    public function postUpdateMediaIDsOrder()
    {
      // Find and process media Ids
      $exhibit = Exhibit::find(Input::get('ex_id'));
      $exhibit->update(
        array('media_ids' => json_encode(Input::get('media_ids')))
      );
      $exhibit->save();
      return Response::json(
        array(
          'media_ids' => $exhibit->media_ids
        )
      );
    }


  }

?>