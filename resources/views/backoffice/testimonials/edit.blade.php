@extends('backoffice.master_layout')
@section('title', 'Edit Testimonial')
@section('content')
<div class='card'>
  <div class='card-header'><h5>Edit Testimonial</h5></div>
  <div class='card-body'>
    <form action='{{ route('testimonials.update', $item->id ?? $page->id ?? 0) }}' method='POST'>
      @csrf @method('PUT')
      <p>Placeholder for form fields</p>
      <button type='submit' class='btn btn-primary'>Update</button>
    </form>
  </div>
</div>
@endsection