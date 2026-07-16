@extends('frontend.layouts.app')
@section('content')
<div class='container my-5'>
  <div class='row'>
    <div class='col-12'>
      <h1>{{ $post->title }}</h1>
      <p class='text-muted'>Published on {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</p>
      <hr>
      @if($post->featured_image)
        <img src='{{ asset($post->featured_image) }}' class='img-fluid mb-4' alt='...'>
      @endif
      <div>{!! $post->content !!}</div>
    </div>
  </div>
</div>
@endsection
