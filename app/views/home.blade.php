@extends('layout.main')

@section('content')

<div class="home-slides col-md-12">
  @foreach( $slides as $slide )
    @if($slide->media)
      <div class="slick-slide">
        <img src="{{ $slide->media->img_big }}" />
      </div>
    @endif
  @endforeach
</div>

@stop

@section('scripts')

<script>
  $(document).ready(function(){
    $('.home-slides').slick({
      dots: true,
      infinite: true,
      speed: 300,
      autoplay: true,
      autoplaySpeed: 9000,
      slidesToShow: 1,
      adaptiveHeight: true,
      prevArrow: '<i class="slide-prev fa fa-chevron-left"></i>',
      nextArrow: '<i class="slide-next fa fa-chevron-right"></i>'
    });
  });
</script>
@stop