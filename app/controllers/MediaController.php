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
        return Redirect::back()->with('global', 'Something went wrong!');
      }
    }

    // Add media to edit form
    public function postAddMedia()
    {
      $isAjax = Request::ajax();
      $parentId = Input::get('id');
      $exhibit = Exhibit::find((int)$parentId);
      $exhibit->save();

      if (Input::hasFile('file')) {

        $file = Input::file('file');

        if ($file->isValid()) {
          $validator = Validator::make(
            array('file' => $file),
            array('file' => 'mimes:png,gif,jpeg|max:20000')
          );
          if ($validator->fails()) {
            return Response::json(array(
              'success' => false,
              'error' => $file->isValid()
            ));
          }
        }

        $user_id = Auth::user()->id;
        // Process the image and return the location for
        // its small cropped image
        $currentMo = date('Y_M');
        $destination = "uploads/$currentMo";
        $filename = $file->getClientOriginalName();

        $uploadSuccess = $file->move($destination, "$filename");
        $imgOrigDestination = $destination . '/' . $filename;
        $imageMinDestination = $destination . '/min_' . $filename;
        $imageMin = Image::make($imgOrigDestination)->crop(250, 250, 10, 10)->save($imageMinDestination);

        // Saves the media and adds the appropriate foreign keys for the exhibit
        $media = $exhibit->media()->create([
          'user_id' => $user_id,
          'img_min' => $imageMinDestination,
          'img_big' => $imgOrigDestination
        ]);
        $exhibit->media()->save($media);
        if (!$media) {
          return Response::json(array(
            'success' => false,
            'error' => 'Uploading and saving your image failed'
          ));
        }
        return Response::json(
          array(
            'success' => true,
            'img_min_dest' => $imageMinDestination,
            'media_id' => $media->id,
            'exhibit_id' => $exhibit->id
          )
        );
      }
    }

    public function postUpdateMediaIDsOrder()
    {
      // Find and process media Ids
      $exhibit = DB::table('exhibits')
        ->where('id', Input::get('ex_id'))
        ->update(array('media_ids' => json_encode(Input::get('media_ids'))));
      $exhibit = Exhibit::find(Input::get('ex_id'));
      return Response::json(
        array(
          'media_ids' => $exhibit->media_ids
        )
      );
    }


  }

?>