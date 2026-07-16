@extends('backoffice.master_layout')
@section('title', 'Create Page')
@section('content')
<div class='card'>
  <div class='card-header'><h5>Create Page</h5></div>
  <div class='card-body'>
    <form action='{{ route('pages.store') }}' method='POST'>
      @csrf
      <p>Placeholder for form fields</p>
      <button type='submit' class='btn btn-primary'>Save</button>
    </form>
  </div>
</div>
@endsection