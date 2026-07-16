@extends('frontend.layouts.app')
@section('content')
<div class='container my-5'>
  <h1 class='mb-4'>Our Blog</h1>
  <div class='row'>
    @foreach($posts as $post)
    <div class='col-md-4 mb-4'>
      <div class='card h-100'>
        @if($post->featured_image)
          <img src='{{ asset($post->featured_image) }}' class='card-img-top' alt='...'>
        @endif
        <div class='card-body'>
          <h5 class='card-title'>{{ $post->title }}</h5>
          <p class='card-text'>{{ $post->excerpt }}</p>
          <a href='{{ route('blog.show', $post->slug) }}' class='btn btn-primary'>Read More</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
