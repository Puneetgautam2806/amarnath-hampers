@extends('backoffice.master_layout')

@section('title', 'Create User')

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

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Main Form Card -->
            <div class="col-xl-8 col-lg-7">
                <div class="card mb-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Create User</h4>
                    </div>
                    <div class="card-body">
                        <!-- Section 1: Account Profile -->
                        <div class="form-section-title">Account Profile</div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label" for="name">User Name</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Please Provide User Name" required value="{{ old('name') }}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email Address</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" id="email" class="form-control" name="email" placeholder="Please Provide your Email" required value="{{ old('email') }}"/>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Security & Password -->
                        <div class="form-section-title mt-6">Security & Credentials</div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Classification & Status -->
                        <div class="form-section-title mt-6">Classification & Options</div>
                        
                        <div class="row mb-6">
                            <div class="col-md-6">
                                <label class="form-label" for="usertype">User Type / Role</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-shield"></i></span>
                                    <select class="form-select" name="usertype" id="usertype" required>
                                        <option value="">Select User Type</option>
                                        <option value="admin" {{ old('usertype') === 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="developer" {{ old('usertype') === 'developer' ? 'selected' : '' }}>Developer</option>
                                        <option value="manager" {{ old('usertype') === 'manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="staff" {{ old('usertype') === 'staff' ? 'selected' : '' }}>Staff</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block mb-3">Status</label>
                                <div class="d-flex gap-4 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status1" value="1" {{ old('status', '1') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status1">Active</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status2" value="2" {{ old('status') === '2' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status2">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-top">
                            <button type="submit" class="btn btn-primary me-2">Create User</button>
                            <a href="{{ route('users.manage') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guidance & Helper Column -->
            <div class="col-xl-4 col-lg-5">
                <div class="card guide-card mb-6">
                    <div class="card-header">
                        <h5 class="guide-title mb-0">
                            <i class="bx bx-help-circle text-primary"></i>
                            Security & Role Guide
                        </h5>
                    </div>
                    <div class="card-body pt-4">
                        <p class="text-muted mb-4 small">Configure system accounts securely. Follow instructions below to optimize system role classification.</p>
                        
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2 small text-uppercase text-secondary">Role Privileges</h6>
                            <div class="d-flex flex-column gap-3">
                                <div class="p-3 rounded bg-light border-start border-danger border-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <strong class="small fw-bold text-dark">Developer Account</strong>
                                        <span class="badge bg-label-danger px-2 py-0">Superuser</span>
                                    </div>
                                    <span class="small text-muted d-block" style="font-size: 0.76rem;">Developer account with complete bypass credentials for all route permissions and full system features.</span>
                                </div>
                                <div class="p-3 rounded bg-light border-start border-primary border-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <strong class="small fw-bold text-dark">Admin Account</strong>
                                        <span class="badge bg-label-primary px-2 py-0">Full Access</span>
                                    </div>
                                    <span class="small text-muted d-block" style="font-size: 0.76rem;">Can configure portal schemas, manage users, and adjust database overrides.</span>
                                </div>
                                <div class="p-3 rounded bg-light border-start border-info border-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <strong class="small fw-bold text-dark">Manager Account</strong>
                                        <span class="badge bg-label-info px-2 py-0">Curation</span>
                                    </div>
                                    <span class="small text-muted d-block" style="font-size: 0.76rem;">Can build and adjust dynamic menus and assign specific access privileges.</span>
                                </div>
                                <div class="p-3 rounded bg-light border-start border-warning border-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <strong class="small fw-bold text-dark">Staff Account</strong>
                                        <span class="badge bg-label-warning px-2 py-0">Operational</span>
                                    </div>
                                    <span class="small text-muted d-block" style="font-size: 0.76rem;">Access is restricted to frontoffice view dashboards and specific allowed pathways.</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-top">
                            <h6 class="fw-bold mb-2 small text-uppercase text-secondary">Password Requirements</h6>
                            <ul class="ps-3 mb-0 small text-muted d-flex flex-column gap-2" style="font-size: 0.8rem;">
                                <li><i class="bx bx-check-circle text-success me-1"></i> Minimum 8 alphanumeric characters</li>
                                <li><i class="bx bx-check-circle text-success me-1"></i> Contain at least one capital letter</li>
                                <li><i class="bx bx-check-circle text-success me-1"></i> Unique relative to username/email</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection