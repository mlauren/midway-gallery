

@extends('layout.backend')

@section('content')
  <div class="col-md-10">
    <h2>Slides</h2>
    <h3><a href="/" class="add-slide-object"><i class="fa fa-plus-circle fa-lg"></i> Add New</a></h3>
  </div>
  {{ Form::open() }}
    {{-- Remove unassigned and add assigned record --}}
    {{-- You shouldn't have to see this if you don't want to --}}
    <div class="slide-group col-md-12">
      @if($slides)
        @foreach($slides as $slide)
          @include('slideshow.add')
        @endforeach
      @endif
    </div>

    <div class="col-md-12">
      {{ Form::submit('Submit', array('class'=>'btn btn-large btn-default')) }}
    </div>
  {{ Form::close() }}
@stop

@section('scripts')
    @parent
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js') }}

    {{ HTML::script('/packages/custom_javascripts/site-add-slides.js') }}


@stop