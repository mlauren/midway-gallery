<?php

  class ExhibitController extends BaseController
  {

    /**
     * Display the form for adding exhibits.
     */
    public function getAdd()
    {
      return View::make('exhibits.add');
    }

    /**
     * Edit a single exhibit.
     */
    public function editSingle($id)
    {
      $exhibit = Exhibit::find($id);
      $mediaIDs = json_decode($exhibit->media_ids);
      $assignedGroup = array();
      $imageGroup = array();
      if ($exhibit->count()) {
        // Get the order of media_ids and pass it in to assigned image group
        if (!is_null($mediaIDs)) {
          foreach ($mediaIDs as $mediaID) {
            $media = Media::find($mediaID);
            $imageGroup[] = $media;
          }
        }
        $assignedImageGroup = DB::table('media')
          ->where('mediable_id', '=', $exhibit->id)
          ->where('mediable_type', '=', 'Exhibit')
          ->orderBy('updated_at', 'desc')
          ->get();
        if (isset($assignedImageGroup) && !is_null($mediaIDs)) {
          foreach ($assignedImageGroup as $media) {
            if (!in_array($media->id, $mediaIDs)) {
              $assignedGroup[] = $media;
            }
          }
        }
        return View::make('exhibits.edit-single')
          ->with('id', $id)
          ->with('exhibit', $exhibit)
          ->with('imageGroup', $imageGroup)
          ->with('assignedGroup', $assignedGroup);
      }
      return App::abort(404);

    }

    public function postEditSingle()
    {
      // Validate form fields
      $id = Input::get('id');
      $exhibit = Exhibit::find($id);
      $validator = Exhibit::makeEditValidator(Input::get('title'), Input::get('video'));
      if ($validator->fails()) {
        return Redirect::back()
          ->withErrors($validator)
          ->withInput();
      }
      // Validate images if they are present and ajax hasn't run
      if (Input::hasFile('file')) {
        $files = Input::file('file');
        foreach ($files as $file) {
          $validator = Validator::make(
            array('file' => $file),
            array('file' => 'mimes:png,gif,jpeg|max:20000')
          );
          if ($validator->fails()) {
            return Redirect::back()
              ->withErrors($validator)
              ->withInput();
          }
        }
      }
      //2014-09-30 15:19:05
      $created_at = strtotime(Input::get('created_at'));
      $created_at = date('Y-m-d H:i:s', $created_at);

      $user_id = Auth::user()->id;
      $cleanTitle = Exhibit::permalink(Input::get('title'));
      $exhibit->update(
        array(
          'user_id' => $user_id,
          'title' => Input::get('title'),
          'permalink' => $cleanTitle,
          'created_at' => $created_at,
          'details' => Input::get('details'),
          'video' => Input::get('video'),
          'published' => (bool)Input::get('published')
        )
      );
      $exhibit->save();
      if (Input::hasFile('file')) {
        foreach ($files as $file) {
          $currentMo = date('Y_M');
          $destination = "uploads/$currentMo";
          $filename = $file->getClientOriginalName();
          $filename = Exhibit::string_convert($filename);
            // $cleanFilename = Exhibit::permalink($filename);
          // Move the new file into the uploads directory
          $uploadSuccess = $file->move($destination, "$filename");
          $imgOrigDestination = $destination . '/' . $filename;

          // Check to make sure that upload was successful and add the content
          if ($uploadSuccess) {
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
              return Redirect::back()
                ->with('status', 'alert-danger')
                ->with('global', 'Something went wrong with uploading your images. :/');
            }
          }
        }
      }
      return Redirect::route('exhibits-show-single', $exhibit->permalink)
        ->with('global', 'You have successfully updated ' . $exhibit->title . '.');
    }

    /**
     * Huge method for analyzing Exhibit forms.
     * @todo change this method so that it puts and updates
     */
    public function postAdd()
    {
      // Validate form fields
      $exhibit = Exhibit::find(Input::get('id'));


      $validator = Validator::make(
        array(
          'title' => Input::get('title'),
          'video' => Input::get('video'),
        ), Exhibit::$rules
      );
      if ($validator->fails()) {
        if (!count($exhibit)) {
          return Redirect::route('exhibits-add')
            ->withErrors($validator)
            ->withInput();
        } else {
          return Redirect::to('exhibits/' . $exhibit->id . '/edit')
            ->withErrors($validator)
            ->withInput();
        }
      }
      // Validate images
      if (Input::hasFile('file')) {
        $files = Input::file('file');
        foreach ($files as $file) {
          $rules = array(
            'file' => 'mimes:png,gif,jpeg|max:20000'
          );
          $validator = Validator::make(array('file' => $file), $rules);
          if ($validator->fails()) {
            return Redirect::route('exhibits-add')
              ->withErrors($validator)
              ->withInput();
          }
        }
      }
      $user_id = Auth::user()->id;
      $cleanTitle = Exhibit::permalink(Input::get('title'));

      $exhibit = Exhibit::findOrCreate(Input::get('id'));
      $exhibit->update(
        array(
          'user_id' => $user_id,
          'title' => Input::get('title'),
          'permalink' => $cleanTitle,
          'details' => Input::get('details'),
          'video' => Input::get('video'),
          'published' => (bool)Input::get('published'),
          'autodraft' => false
        )
      );
      $mediaIDs = array();

      if ($exhibit) {
        $exhibit->save();
        if (Input::hasFile('file')) {
          $files = Input::file('file');
          foreach ($files as $file) {
            $currentMo = date('Y_M');
            $destination = "uploads/$currentMo";
            $filename = $file->getClientOriginalName();
            $filename = Exhibit::string_convert($filename);
            // $cleanFilename = Exhibit::permalink($filename);
            // Move the new file into the uploads directory
            $uploadSuccess = $file->move($destination, "$filename");
            $imgOrigDestination = $destination . '/' . $filename;

            // Check to make sure that upload was successful and add the content
            if ($uploadSuccess) {
              $imageMinDestination = $destination . '/min_' . $filename;
              $imageMin = Image::make($imgOrigDestination)->crop(250, 250, 10, 10)->save($imageMinDestination);

              // Saves the media and adds the appropriate foreign keys for the exhibit
              $media = $exhibit->media()->create([
                'user_id' => $user_id,
                'img_min' => $imageMinDestination,
                'img_big' => $imgOrigDestination
              ]);
              $exhibit->media()->save($media);
              $mediaIDs[] = $media->id;

            }
          }
        }
        $exhibit->media_ids = json_encode($mediaIDs);
        $exhibit->save();
        return Redirect::route('exhibits-show-single', $exhibit->permalink)
          ->with('status', 'alert-success')
          ->with('global', 'You have successfully created an exhibit.');
      }
    }

    /**
     * Remove a single exhibit.
     */
    public function postRemoveSingle($id)
    {
      $exhibit = Exhibit::find($id);
      $name = $exhibit->title;
      $exhibit->delete();
      return Redirect::route('account')
        ->with('status', 'alert-success')
        ->with('global', 'You just deleted ' . $name);
    }

    /**
     * Display a single exhibit.
     */
    public function single($name)
    {
      $exhibit = Exhibit::where('permalink', '=', $name);
      $exhibit = $exhibit->first();
      $mediaIDs = json_decode($exhibit->media_ids);
      $assignedGroup = array();
      $imageGroup = array();
      if ($exhibit->count()) {
        // Get the order of media_ids and pass it in to assigned image group
        if (!is_null($mediaIDs)) {
          foreach ($mediaIDs as $mediaID) {
            $media = Media::find($mediaID);
            $imageGroup[] = $media;
          }
        }
        $assignedImageGroup = DB::table('media')
          ->where('mediable_id', '=', $exhibit->id)
          ->where('mediable_type', '=', 'Exhibit')
          ->orderBy('updated_at', 'desc')
          ->get();
        if (isset($assignedImageGroup) && !is_null($mediaIDs)) {
          foreach ($assignedImageGroup as $media) {
            if (!in_array($media->id, $mediaIDs)) {
              $assignedGroup[] = $media;
            }
          }
        }
        if (isset($exhibit->video)) {
          $videoEmbed = array();
          $re = "/(?:http:\\/\\/|https:\\/\\/)(?:www.)?(vimeo|youtube).com\\/(?:watch\\?v=)?(.*?)(?:\\z|&)/";
          preg_match($re, $exhibit->video, $out);
          if (isset($out[1])) {
            $videoEmbed['source'] = $out[1];
            $videoEmbed['id'] = $out[2];
          }
        }
        return View::make('exhibits.show-single')
          ->with('videoEmbed', $videoEmbed)
          ->with('exhibit', $exhibit)
          ->with('imageGroup', $imageGroup)
          ->with('assignedGroup', $assignedGroup);
      }
      return App::abort(404);
    }

    public function exhibitAddEmpty()
    {
      $exhibit = Exhibit::create(
        array(
          'published' => false,
          'autodraft' => true
        )
      );
      return Response::json(
        array(
          'success' => true,
          'id' => $exhibit->id
        )
      );
    }

    public function showAll() {
      $exhibits = DB::table('exhibits')->where('published', '=', 1)->get();
      return View::make('exhibits.all')
        ->with('exhibits', $exhibits);
    }

  }

?>
