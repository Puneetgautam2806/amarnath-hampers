@extends('backoffice.master_layout')

@section('title', 'Manage Users')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Manage Users</h4>
            <a href="{{ route('createUser') }}" class="btn btn-primary">Add User</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td><strong>{{ $user->id }}</strong></td>
                            <td>{{ $user->name }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge-premium-role">{{ ucfirst($user->usertype) }}</span>
                            </td>
                            <td>
                                @if((int) $user->status === 1)
                                    <span class="badge-premium-active">Active</span>
                                @else
                                    <span class="badge-premium-inactive">Inactive</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $user->created_at?->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
