@extends('layouts.admin.app')
@section('title', 'Categories')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    {{-- TABLE --}}
                    <div data-table data-table-rows-per-page="10" class="card">
                        <div class="card-header">
                            <h4 class="card-title">List of Categories</h4>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input data-table-search type="search" class="form-control" placeholder="Search...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                                <button class="btn btn-danger d-none">Delete</button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th data-table-sort>Category</th>
                                        <th data-table-sort>Description</th>
                                        <th data-table-sort>Status</th>
                                        <th data-table-sort>Date Created</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->description ?: 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-soft-{{ $category->status == 'active' ? 'success' : 'danger' }} fs-8 px-1 w-100">
                                                {{ strtoupper($category->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $category->created_at->format('F d, Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <button class="btn btn-sm edit-category-btn" data-id="{{ $category->id }}" data-name="{{ $category->category_name }}" data-description="{{ $category->description }}" data-status="{{ $category->status }}" data-bs-toggle="modal" data-bs-target="#editCategoryModal">
                                                    <i class="ti ti-edit fs-lg"></i>
                                                </button>
                                                <button class="btn btn-sm delete-category" data-id="{{ $category->id }}">
                                                    <i class="ti ti-trash fs-lg"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div data-table-pagination-info="categories"></div>
                                <div data-table-pagination></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editCategoryModalLabel">Edit Category</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCategoryForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" id="editCategoryId" name="category_id">
                                
                                <div class="form-group mb-3">
                                    <label class="form-label" for="editCategoryName">Category Name *</label>
                                    <input type="text" class="form-control" id="editCategoryName" name="category_name" placeholder="Edit Category Name" required>
                                    <div class="invalid-feedback" id="editCategoryNameError"></div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="editCategoryDescription">Category Description</label>
                                    <textarea class="form-control" id="editCategoryDescription" name="description" placeholder="Edit Category Description" rows="3"></textarea>
                                    <div class="invalid-feedback" id="editCategoryDescriptionError"></div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="editCategoryStatus">Status *</label>
                                    <select class="form-select" id="editCategoryStatus" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback" id="editCategoryStatusError"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateCategoryBtn">
                            <span id="updateBtnText">Update Category</span>
                            <span id="updateSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            // Edit button click handler
            $(document).on('click', '.edit-category-btn', function() {
                var categoryId = $(this).data('id');
                var categoryName = $(this).data('name');
                var categoryDescription = $(this).data('description');
                var categoryStatus = $(this).data('status');
                
                // Set form values
                $('#editCategoryId').val(categoryId);
                $('#editCategoryName').val(categoryName);
                $('#editCategoryDescription').val(categoryDescription);
                $('#editCategoryStatus').val(categoryStatus);
                
                // Reset validation
                $('#editCategoryForm .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();
            });

            // Edit form submission
            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();
                
                var categoryId = $('#editCategoryId').val();
                
                // Reset validation
                $('#editCategoryForm .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();
                
                // Show loading state
                $('#updateCategoryBtn').prop('disabled', true);
                $('#updateBtnText').addClass('d-none');
                $('#updateSpinner').removeClass('d-none');
                
                // Get form data
                var formData = new FormData(this);
                
                // Make AJAX request
                $.ajax({
                    url: "{{ url('admin/categories') }}/" + categoryId,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: response.message,
                                showConfirmButton: false,
                                timerProgressBar: true,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON?.errors;
                        
                        if (errors) {
                            if (errors.category_name) {
                                $('#editCategoryName').addClass('is-invalid');
                                $('#editCategoryNameError').text(errors.category_name[0]).show();
                            }
                            if (errors.description) {
                                $('#editCategoryDescription').addClass('is-invalid');
                                $('#editCategoryDescriptionError').text(errors.description[0]).show();
                            }
                            if (errors.status) {
                                $('#editCategoryStatus').addClass('is-invalid');
                                $('#editCategoryStatusError').text(errors.status[0]).show();
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Failed to update category.',
                                showConfirmButton: false,
                                timerProgressBar: true,
                                timer: 1500
                            });
                        }
                    },
                    complete: function() {
                        $('#updateCategoryBtn').prop('disabled', false);
                        $('#updateBtnText').removeClass('d-none');
                        $('#updateSpinner').addClass('d-none');
                    }
                });
            });

            // Delete category with SweetAlert2
            $(document).on('click', '.delete-category', function() {
                var categoryId = $(this).data('id');
                var button = $(this);
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6C757D',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/categories') }}/" + categoryId,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            beforeSend: function() {
                                button.prop('disabled', true);
                                button.html('<i class="ti ti-loader fs-lg"></i>');
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timerProgressBar: true,
                                        timer: 1500
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Failed to delete category.',
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                    timer: 1500
                                });
                            },
                            complete: function() {
                                button.prop('disabled', false);
                                button.html('<i class="ti ti-trash fs-lg"></i>');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection