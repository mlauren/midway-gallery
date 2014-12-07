<div class="slide-container unassigned col-md-11"{{ isset($slide) ? ' data-order="' . $slide->slide_order . '" data-id="' . $slide->id . '"'  : '' }}>
  <div class="col-md-1 col-sm-1 col-xs-1 icon-column-padding">
    <div class="drag-order"><i class="fa fa-arrows fa-2x"></i></div>
  </div>

  <div class="col-md-11 col-sm-11 col-xs-11 border-left">

    <div class="col-md-6 col-sm-6 col-xs-6">

      <div id="img-preview-container" class="col-md-5 col-xs-5 col-sm-5">
        @if ( isset($slide) )
          @if(null != $slide->media)
            <img id="img-preview" class="img-responsive" src="{{ $slide->media->img_min }}" />
            <h4 class="img-preview-remove"><a href="" >X</a></h4>
            <h4 class="img-preview-overlay">Preview</h4>
          @else
            <div id="img-preview" class="panel panel-default">
              <div class="panel-body"> No Image Available </div>
            </div>
          @endif
        @else
          <div id="img-preview" class="panel panel-default">
            <div class="panel-body"> No Image Available </div>
          </div>
        @endif
      </div>
      <div class="col-md-7 col-sm-7 col-xs-7 border-left">
        <div id="slide-image">
          {{-- Hide this and allow it to be activated by hidden field --}}
          <div class="form-group">
            <label for="file">Slide Image</label>
            <input type="file" id="file">
            <p class="help-block">Upload some type of image.</p>
          </div>
        </div>
      </div>

    </div>

    <div class="col-md-5 col-sm-5 col-xs-5 border-left border-right">

      <div class="col-md-12 form-group info-add">
        {{ Form::label('title', 'Title (Optional)', array('class' => 'control-label')); }}
        @if (isset($slide) && isset($slide->slide_title))
          {{ Form::text('title', $slide->slide_title, array('class'=>'form-control')) }}
        @else
          {{ Form::text('title', null, array('class'=>'form-control')) }}
        @endif
      </div>
      <div class="col-md-12 form-group info-add">
        {{ Form::label('details', 'Subtitle (Optional)', array('class' => 'control-label')); }}
        @if (isset($slide) && isset($slide->slide_text))
          {{ Form::text('details', $slide->slide_text, array('class'=>'form-control')) }}
        @else
          {{ Form::text('details', null, array('class'=>'form-control')) }}
        @endif
      </div>

    </div>
    <div class="col-md-1 col-sm-1 col-xs-1 icon-column-padding">
      @if(isset($slide))
        {{ Form::hidden('data-id', $slide->id) }}
      @else
        {{ Form::hidden('data-id', null) }}
      @endif
      <a href="" class="remove-slide"> <i class="fa fa-times fa-2x"></i></a>
    </div>
  </div>
  <hr class="col-md-12" />
</div>