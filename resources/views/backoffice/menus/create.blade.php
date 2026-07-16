@extends('backoffice.master_layout')

@section('title', 'Create Menu')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
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

    <form action="{{ route('menus.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Left Side: Main Form Card -->
            <div class="col-xl-8 col-lg-7">
                <div class="card mb-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Create Menu</h4>
                    </div>
                    <div class="card-body">
                        
                        <!-- Section 1: Basic Information -->
                        <div class="form-section-title">Menu Identity</div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label" for="menu_name">Menu Name</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-rename"></i></span>
                                    <input type="text" class="form-control" id="menu_name" name="menu_name" value="{{ old('menu_name') }}" placeholder="e.g. Menu Builder" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="category">Category</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-folder"></i></span>
                                    <input type="text" class="form-control" id="category" name="category" placeholder="e.g. Common" value="{{ old('category', 'Common') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label" for="path">Path / Route URL</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-link"></i></span>
                                    <input type="text" class="form-control" id="path" name="path" placeholder="e.g. menus/manage" value="{{ old('path') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="icon">Icon Class (Boxicons)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-smile"></i></span>
                                    <input type="text" class="form-control" id="icon" name="icon" placeholder="e.g. bx-cog" value="{{ old('icon') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Hierarchy & Sorting -->
                        <div class="form-section-title mt-6">Hierarchy & Layout</div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label d-block mb-3">Menu Level Type</label>
                                <div class="d-flex gap-4 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_parent" id="is_parent_1" value="1" {{ old('is_parent', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_parent_1">Parent Menu</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_parent" id="is_parent_2" value="2" {{ old('is_parent') == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_parent_2">Sub Menu</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="parent_id">Belongs to Parent</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-subdirectory-right"></i></span>
                                    <select class="form-select" id="parent_id" name="parent_id">
                                        <option value="">Select parent menu</option>
                                        @foreach ($parentMenus as $parentMenu)
                                            <option value="{{ $parentMenu->id }}" {{ old('parent_id') == $parentMenu->id ? 'selected' : '' }}>
                                                {{ $parentMenu->menu_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label" for="orders">Order (Position Index)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-sort-alt-2"></i></span>
                                    <input type="number" min="1" class="form-control" id="orders" name="orders" value="{{ old('orders', 1) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block mb-3">Status</label>
                                <div class="d-flex gap-4 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_1" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_1">Active</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_2" value="2" {{ old('status') == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_2">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Permissions -->
                        <div class="form-section-title mt-6">Role Scope Access</div>

                        <div class="mb-6">
                            <label class="form-label d-block mb-2">Check All Allowed Roles</label>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="role_admin" name="permissions[]" value="admin" {{ in_array('admin', old('permissions', ['admin']), true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_admin">Admin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="role_manager" name="permissions[]" value="manager" {{ in_array('manager', old('permissions', []), true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_manager">Manager</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="role_staff" name="permissions[]" value="staff" {{ in_array('staff', old('permissions', []), true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_staff">Staff</label>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-top">
                            <button type="submit" class="btn btn-primary me-2">Save Menu</button>
                            <a href="{{ route('menus.manage') }}" class="btn btn-outline-secondary">Back to Manage</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Interactive Help & Icon Directory -->
            <div class="col-xl-4 col-lg-5">
                <div class="card guide-card mb-6">
                    <div class="card-header">
                        <h5 class="guide-title mb-0">
                            <i class="bx bx-info-circle text-primary"></i>
                            Menu Reference Guide
                        </h5>
                    </div>
                    <div class="card-body pt-4">
                        <p class="text-muted mb-4 small">Build functional and structured pathways for backoffice access. Hover or click to inspect recommended details.</p>
                        
                        <!-- Boxicon Catalog -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2 small text-uppercase text-secondary">Recommended Icons</h6>
                            <p class="text-muted mb-2" style="font-size: 0.76rem;">Select and type standard icon values in the form field:</p>
                            
                            <div class="d-flex flex-wrap gap-2">
                                <span class="icon-badge" onclick="document.getElementById('icon').value = 'bx-home-circle'"><i class="bx bx-home-circle"></i> bx-home-circle</span>
                                <span class="icon-badge" onclick="document.getElementById('icon').value = 'bx-user'"><i class="bx bx-user"></i> bx-user</span>
                                <span class="icon-badge" onclick="document.getElementById('icon').value = 'bx-cog'"><i class="bx bx-cog"></i> bx-cog</span>
                                <span class="icon-badge" onclick="document.getElementById('icon').value = 'bx-shield'"><i class="bx bx-shield"></i> bx-shield</span>
                                <span class="icon-badge" onclick="document.getElementById('icon').value = 'bx-bar-chart-alt-2'"><i class="bx bx-bar-chart-alt-2"></i> bx-bar-chart</span>
                                <span class="icon-badge" onclick="document.getElementById('icon').value = 'bx-grid-alt'"><i class="bx bx-grid-alt"></i> bx-grid-alt</span>
                                <span class="icon-badge" onclick="document.getElementById('icon').value = 'bx-list-ul'"><i class="bx bx-list-ul"></i> bx-list-ul</span>
                                <span class="icon-badge" onclick="document.getElementById('icon').value = 'bx-cabinet'"><i class="bx bx-cabinet"></i> bx-cabinet</span>
                            </div>
                        </div>

                        <!-- Path Details -->
                        <div class="pt-3 border-top mb-4">
                            <h6 class="fw-bold mb-2 small text-uppercase text-secondary">Path Structure Routing</h6>
                            <ul class="ps-3 mb-0 small text-muted d-flex flex-column gap-2" style="font-size: 0.8rem;">
                                <li><strong>Parent Path</strong>: Set to <code>#</code> if this menu only serves as a folder toggle for sub-menus.</li>
                                <li><strong>Direct Link</strong>: Provide route syntax (e.g. <code>users/manage</code>) corresponding to your system routes.</li>
                            </ul>
                        </div>

                        <!-- Nested Hierarchy Representation -->
                        <div class="pt-3 border-top">
                            <h6 class="fw-bold mb-2 small text-uppercase text-secondary">Hierarchy Guide</h6>
                            <div class="p-3 bg-light rounded text-dark font-monospace" style="font-size: 0.74rem; line-height: 1.5;">
                                📁 Parent (e.g., System Menu)<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;└── 📄 Sub (e.g., User Management)<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;└── 📄 Sub (e.g., Access Controls)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
