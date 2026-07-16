@extends('backoffice.master_layout')
@section('title', 'Edit PromoBanner')
@section('content')
<div class='card'>
  <div class='card-header'><h5>Edit PromoBanner</h5></div>
  <div class='card-body'>
    <form action='{{ route('promo_banners.update', $item->id ?? $page->id ?? 0) }}' method='POST'>
      @csrf @method('PUT')
      <p>Placeholder for form fields</p>
      <button type='submit' class='btn btn-primary'>Update</button>
    </form>
  </div>
</div>
@endsection