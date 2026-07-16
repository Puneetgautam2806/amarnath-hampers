@extends('backoffice.master_layout')
@section('title', 'Create PromoBanner')
@section('content')
<div class='card'>
  <div class='card-header'><h5>Create PromoBanner</h5></div>
  <div class='card-body'>
    <form action='{{ route('promo_banners.store') }}' method='POST'>
      @csrf
      <p>Placeholder for form fields</p>
      <button type='submit' class='btn btn-primary'>Save</button>
    </form>
  </div>
</div>
@endsection