@extends('backoffice.master_layout')
@section('title', 'Manage Posts')
@section('content')
<div class='card'>
  <div class='card-header d-flex justify-content-between align-items-center'>
    <h5>Posts</h5>
    <a href='{{ route('posts.create') }}' class='btn btn-primary'>Add New</a>
  </div>
  <div class='card-body'>
    <table class='table'>
      <thead><tr><th>ID</th><th>Action</th></tr></thead>
      <tbody>
        @foreach($items ?? $pages as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>
            <a href='{{ route('posts.edit', $item->id) }}' class='btn btn-sm btn-info'>Edit</a>
            <form action='{{ route('posts.destroy', $item->id) }}' method='POST' class='d-inline'>
              @csrf @method('DELETE')
              <button class='btn btn-sm btn-danger' type='submit'>Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection