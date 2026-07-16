@extends('backoffice.master_layout')

@section('title', 'Manage User Access')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header pb-2">
            <h4 class="mb-1">Permissions: {{ $selectedUser->name }}</h4>
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-premium-role text-capitalize">{{ $selectedUser->usertype }}</span>
                <span class="text-muted small">Allow or deny specific modules for this user. Leave both unchecked to use role default.</span>
            </div>
        </div>
        <div class="card-body mt-2">
            <form action="{{ route('permissions.updateUser', $selectedUser) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Menu Name</th>
                                <th>Path / Slug</th>
                                <th>Type</th>
                                <th>Role Default</th>
                                <th class="text-center" style="width: 100px;">Allow</th>
                                <th class="text-center" style="width: 100px;">Deny</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                @php
                                    $override = $overrides[$menu->id] ?? null;
                                    $roleDefault = empty($menu->permissions) || in_array($selectedUser->usertype, explode(',', (string) $menu->permissions), true);
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $menu->menu_name }}</strong>
                                    </td>
                                    <td class="text-muted small font-monospace">{{ $menu->path }}</td>
                                    <td>
                                        @if((int) $menu->is_parent === 1)
                                            <span class="badge bg-label-primary">Parent</span>
                                        @else
                                            <span class="badge bg-label-info">Sub Menu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($roleDefault)
                                            <span class="badge bg-label-success">Allowed</span>
                                        @else
                                            <span class="badge bg-label-secondary text-muted">Denied</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check d-inline-block">
                                            <input type="checkbox" class="form-check-input" name="allowed[]" value="{{ $menu->id }}" {{ (int) $override === 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check d-inline-block">
                                            <input type="checkbox" class="form-check-input" name="denied[]" value="{{ $menu->id }}" {{ (int) $override === 2 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pt-4 border-top mt-4">
                    <button type="submit" class="btn btn-primary me-2">Save Permissions</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">Back to Manage</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
