@extends('backoffice.master_layout')

@section('title', 'Manage Menus')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->has('menu_delete'))
        <div class="alert alert-danger">{{ $errors->first('menu_delete') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Manage Menus</h4>
            <a href="{{ route('menus.create') }}" class="btn btn-primary">Add Menu</a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Menu Name</th>
                        <th>Path</th>
                        <th>Type</th>
                        <th>Parent ID</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Permissions</th>
                        <th>Icon</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr>
                            <td>{{ $menu->id }}</td>
                            <td>{{ $menu->category }}</td>
                            <td>{{ $menu->menu_name }}</td>
                            <td>{{ $menu->path }}</td>
                            <td>{{ (int) $menu->is_parent === 1 ? 'Parent' : 'Sub' }}</td>
                            <td>{{ $menu->parent_id }}</td>
                            <td>{{ $menu->orders }}</td>
                            <td>{{ (int) $menu->status === 1 ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $menu->permissions }}</td>
                            <td>{{ $menu->icon }}</td>
                            <td>
                                <a href="{{ route('menus.edit', $menu) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this menu?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No menu records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
