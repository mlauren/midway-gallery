<div class="slide-container unassigned col-md-10" data-id data-order>
  <div class="col-md-1">
    <div class="drag-order"><i class="fa fa-arrows fa-3x"></i></div>
  </div>

  <div class="col-md-11">

    <div class="col-md-4">
      <h4><a href="/" class="drag_order"> <i class="fa fa-plus-circle fa-lg"></i> Upload Image</a></h4>

      <div id="slide_image">
        {{-- Hide this and allow it to be activated by hidden field --}}
        {{ Form::label('file', 'Image Files', array('class' => 'control-label')); }}
        {{ Form::file('file', array('class' => 'file')) }}
      </div>
    </div>

    <div class="col-md-8">
      <div class="col-md-6">
        {{ Form::label('title', 'Title (Optional)', array('class' => 'control-label')); }}
        {{ Form::text('title', null, array('class'=>'form-control')) }}
      </div>
      <div class="col-md-6">
        {{ Form::label('details', 'Details (Subtitle) (Optional)', array('class' => 'control-label')); }}
        {{ Form::text('details', null, array('class'=>'form-control')) }}
      </div>
    </div>
  </div>
  <hr />
</div>
