<div class="slide-container unassigned col-md-11"{{ isset($slide) ? ' data-order="' . $slide->slide_order . '" data-id="' . $slide->id . '"'  : '' }}>

  <div class="col-md-1">
    <div class="drag-order"><i class="fa fa-arrows fa-3x"></i></div>
  </div>

  <div class="col-md-11">

    <div class="col-md-4">
      <h4><a href="/" class="upload-image"> <i class="fa fa-plus-circle fa-lg"></i> Upload Image</a></h4>

      <div id="slide-image">
        {{-- Hide this and allow it to be activated by hidden field --}}
        <div class="form-group">
          <label for="file">File input</label>
          <input type="file" id="file">
          <p class="help-block">Upload some type of image.</p>
        </div>
      </div>
      @if(Media::where('slide_id', $slide->id)->firstOrFail())
        <img id="img-preview" src="{{ Media::where('slide_id', $slide->id)->firstOrFail()->img_min }}" />
      @endif
    </div>

    <div class="col-md-8">
      <div class="col-md-5">
        {{ Form::label('title', 'Title (Optional)', array('class' => 'control-label')); }}
        {{ Form::text('title', null, array('class'=>'form-control')) }}
      </div>
      <div class="col-md-5">
        {{ Form::label('details', 'Subtitle (Optional)', array('class' => 'control-label')); }}
        {{ Form::text('details', null, array('class'=>'form-control')) }}
      </div>
      <div class="col-md-2">
        <a href="" class="remove-slide"> <i class="fa fa-times fa-lg"></i></a>
      </div>
      @if(isset($slide))
        {{ Form::hidden('data-id', $slide->id) }}
      @else
        {{ Form::hidden('data-id', null) }}
      @endif
    </div>
  </div>
  <hr class="col-md-12" />
</div>