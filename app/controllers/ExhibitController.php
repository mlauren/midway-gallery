<?php

class ExhibitController extends BaseController {

    /**
     * Display the form for adding exhibits.
     */
    public function getAdd() {
        return View::make('exhibits.add');
    }

    /**
     * Edit a single exhibit.
     */
    public function editSingle($id) {
        $exhibit = Exhibit::find($id);

        if ($exhibit->count()) {
            $imageGroup = $exhibit->media;
            return  View::make('exhibits.edit-single')
                    ->with('exhibit', $exhibit)
                    ->with('imageGroup', $imageGroup);
        }
        return App::abort(404);
    }

    public function postEditSingle() {
        // Validate form fields
        $validator = Validator::make(
            array(
                'title' => Input::get('title'),
                'video' => Input::get('video'),
            ), Exhibit::$rules
        );
        if ( $validator->fails() ) {
            return Redirect::intended('account')
                ->withErrors($validator)
                ->withInput();
        }
        // Validate images
        $files = Input::file('file');
        foreach($files as $file) {
            $rules = array(
               'file' => 'required|mimes:png,gif,jpeg|max:20000'
            );
            $validator = Validator::make(array('file' => $file), $rules);
            if ($validator->fails()) {
                return Redirect::route('exhibits-add')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
    }

    /**
     * Huge method for analyzing Exhibit forms.
     * @todo Add more methods to the Exhibit model
     */
    public function postAdd() {
        // Validate form fields
        $validator = Validator::make(
            array(
                'title' => Input::get('title'),
                'video' => Input::get('video'),
            ), Exhibit::$rules
        );
        if ( $validator->fails() ) {
            return Redirect::route('exhibits-add')
                ->withErrors($validator)
                ->withInput();
        }
        // Validate images
        $files = Input::file('file');
        foreach($files as $file) {
            $rules = array(
               'file' => 'required|mimes:png,gif,jpeg|max:20000'
            );
            $validator = Validator::make(array('file' => $file), $rules);
            if ($validator->fails()) {
                return Redirect::route('exhibits-add')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        $user_id = Auth::user()->id;
        $cleanTitle = Exhibit::permalink(Input::get('title'));
        
        $exhibit = Exhibit::firstOrNew(
            array(
                'user_id' => $user_id,
                'title' => Input::get('title'),
                'permalink'=>$cleanTitle,
                'details' => Input::get('details'),
                'video' => Input::get('video'),
                'published'=> (bool)Input::get('published')
            )
        );
        if ($exhibit) {
            $exhibit->save();
            foreach($files as $file) {
                $currentMo = date('Y_M');
                $destination = "uploads/$currentMo";
                $filename = $file->getClientOriginalName();
                // $cleanFilename = Exhibit::permalink($filename);
                // Move the new file into the uploads directory
                $uploadSuccess = $file->move($destination, "$filename");
                $imgOrigDestination = $destination . '/' . $filename;

                // Check to make sure that upload was successful and add the content
                if($uploadSuccess) 
                {
                    $imageMinDestination = $destination . '/min_' . $filename;
                    $imageMin = Image::make($imgOrigDestination)->crop(250, 250, 10, 10)->save($imageMinDestination);                    
                    $media = Media::firstOrNew(
                        array(
                            'user_id' => $user_id,
                            'img_min' => $imageMinDestination,
                            'img_big' => $imgOrigDestination
                        )
                    );
                    if($media) {
                        // Saves the media and adds the appropriate foreign keys for the exhibit
                        $media->save();
                        $mysave = $exhibit->media()->save($media);
                    }
                    else {
                        return Redirect::intended(route('exhibits-add'))
                            ->with('status', 'alert-danger')
                            ->with('global', 'Something went wrong with uploading your images. :/');
                    }
                }
            }
            return Redirect::route('exhibits-show-single', $exhibit->permalink)
                ->with('status', 'alert-success')
                ->with('global', 'You have successfully created an exhibit.');
        }
    }

    /**
     * Display a single exhibit.
     */
    public function single($name) {
        $exhibit = Exhibit::where('permalink', '=', $name);

        if ($exhibit->count()) {
            $exhibit = $exhibit->first();            
            $imageGroup = $exhibit->media;
            return  View::make('exhibits.show-single')
                    ->with('exhibit', $exhibit)
                    ->with('imageGroup', $imageGroup);
        }
        return App::abort(404);
    }



}




?>