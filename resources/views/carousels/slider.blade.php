@extends('carousels.app')
@section('title', 'Carousels')
@section('content')

<style>
    img{
        height: 500px;
    }
</style>
<div class="container-fluid mt-5">
    @if($carousels->count() > 0)
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
  @foreach($carousels as $index => $carousel)
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{$index}}" class="{{$index==0 ? 'active' : ''}}" aria-current="true" aria-label="Slide {{$index + 1}}"></button>
 @endforeach
  </div>
  <div class="carousel-inner">
  @foreach($carousels as $index => $carousel)
    <div class="carousel-item {{$index==0 ? 'active' : ''}}">
      <img src="{{asset('/images/'.optional($carousel)->image_name)}}" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>{{$carousel->image_type}}</h5>
      </div>
    </div>
   @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
@else
    <h1 class="text-center">No Image</h1>
@endif
<div class="container d-flex justify-content-center align-items-center mt-2">
    <a href="{{route('carousels')}}" class="btn btn-success ">View Carosels</a>
</div>
</div>
@endsection