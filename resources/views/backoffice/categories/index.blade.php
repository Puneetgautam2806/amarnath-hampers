@extends('backoffice.master_layout')

@section('title', 'Category Manager')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Categories Management</h4>
            <span class="text-muted small">Organize your hampers and other products in standard dynamic categories</span>
        </div>
        <button type="button" class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal" style="border-radius: 10px; font-weight: 600;">
            <i class="bx bx-plus me-1"></i> Add Category
        </button>
    </div>

    <!-- Category Table Card -->
    <div class="card border-0" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
        <div class="card-header border-bottom py-4">
            <h5 class="mb-0 text-dark fw-bold">All Product Categories</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="font-weight: 700; color: #566a7f;">Sort Order</th>
                        <th style="font-weight: 700; color: #566a7f;">Category Name</th>
                        <th style="font-weight: 700; color: #566a7f;">Slug</th>
                        <th style="font-weight: 700; color: #566a7f;">Products Count</th>
                        <th style="font-weight: 700; color: #566a7f;">Status</th>
                        <th style="font-weight: 700; color: #566a7f; text-align: right; padding-right: 24px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($categories as $cat)
                        <tr>
                            <td><span class="badge bg-label-secondary px-3 py-2 fw-semibold" style="border-radius: 6px;">{{ $cat->orders }}</span></td>
                            <td><strong class="text-dark fw-semibold">{{ $cat->name }}</strong></td>
                            <td><code>{{ $cat->slug }}</code></td>
                            <td>
                                <span class="badge bg-label-primary px-3 py-2 fw-semibold" style="border-radius: 6px;">
                                    {{ $cat->products_count }} {{ Str::plural('product', $cat->products_count) }}
                                </span>
                            </td>
                            <td>
                                @if ($cat->status == 1)
                                    <span class="badge bg-label-success px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-check me-1"></i> Active</span>
                                @else
                                    <span class="badge bg-label-danger px-3 py-2 fw-semibold" style="border-radius: 6px;"><i class="bx bx-x me-1"></i> Inactive</span>
                                @endif
                            </td>
                            <td style="text-align: right; padding-right: 24px;">
                                <div class="d-inline-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" style="border-radius: 8px;"
                                        data-bs-toggle="modal" data-bs-target="#editCategoryModal" 
                                        data-id="{{ $cat->id }}" 
                                        data-name="{{ $cat->name }}" 
                                        data-orders="{{ $cat->orders }}" 
                                        data-status="{{ $cat->status }}"
                                        title="Edit Category">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category? All products under it will have their category unassigned.')" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" style="border-radius: 8px;" title="Delete Category">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bx bx-category text-muted d-block mb-3" style="font-size: 48px;"></i>
                                <span class="text-muted">No Categories Found. Let's create your first category!</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Add Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-bottom py-3">
                <h5 class="modal-title text-dark fw-bold" id="exampleModalLabel1">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold">Category Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Gift Hampers, Chocolate Platters" required style="border-radius: 8px;">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold">Sort Order</label>
                            <input type="number" name="orders" class="form-control" placeholder="0" value="0" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold">Status *</label>
                            <select name="status" class="form-select" required style="border-radius: 8px;">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px;">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Category -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-bottom py-3">
                <h5 class="modal-title text-dark fw-bold">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold">Category Name *</label>
                        <input type="text" name="name" id="editName" class="form-control" required style="border-radius: 8px;">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold">Sort Order</label>
                            <input type="number" name="orders" id="editOrders" class="form-control" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-semibold">Status *</label>
                            <select name="status" id="editStatus" class="form-select" required style="border-radius: 8px;">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editCategoryModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var orders = button.getAttribute('data-orders');
            var status = button.getAttribute('data-status');

            var form = document.getElementById('editCategoryForm');
            form.action = "{{ url('backoffice/categories') }}/" + id;

            document.getElementById('editName').value = name;
            document.getElementById('editOrders').value = orders;
            document.getElementById('editStatus').value = status;
        });
    });
</script>
@endsection
