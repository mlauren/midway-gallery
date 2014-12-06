

@extends('layout.backend')

@section('content')
  <div class="col-md-10">
    <h2>Slides</h2>
    <p class="help-block">Images need to be this size. Slides will not show up on the homepage unless they have an image attached to them.</p>
    <p class="help-block">Do not add text to slides unless you want it to show on the slide.</p>
    <h3><a href="/" class="add-slide-object"><i class="fa fa-plus-circle fa-lg"></i> Add New</a></h3>
  </div>
  {{ Form::open() }}
    {{-- Remove unassigned and add assigned record --}}
    {{-- You shouldn't have to see this if you don't want to --}}
    <div class="slide-group col-md-12">
      @if($slides)
        @foreach($slides as $slide)
          @include('slideshow.add', array('slide' => $slide))
        @endforeach
      @endif
    </div>

  {{ Form::close() }}
@stop

@section('scripts')
    @parent
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js') }}

    {{ HTML::script('/packages/custom_javascripts/site-add-slides.js') }}


@stop