@extends('frontend.layouts.app')
@section('content')
<div class='container my-5'>
  <div class='row'>
    <div class='col-12'>
      <h1>{{ $page->title }}</h1>
      <hr>
      <div>{!! $page->content !!}</div>
    </div>
  </div>
</div>
@endsection
