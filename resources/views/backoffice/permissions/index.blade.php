@extends('backoffice.master_layout')

@section('title', 'Permissions')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">User Module Permissions</h4>
            <small class="text-muted">Configure direct module access per user (override role defaults).</small>
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
                        <th>Action</th>
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
                            <td>
                                <a href="{{ route('permissions.editUser', $user) }}" class="btn btn-sm btn-primary">Manage Access</a>
                            </td>
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
