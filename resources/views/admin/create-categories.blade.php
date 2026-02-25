@extends('layouts.admin.app')
@section('title', 'Create Categories')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-title">
                            <h4 class="card-title">Create Service Categories</h4>
                        </div>
                        <div class="card-body">
                            <form id="createCategoryForm" class="needs-validation" novalidate>
                                @csrf
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-group mb-2">
                                            <label for="categoryName" class="form-label">Category Name *</label>
                                            <input type="text" class="form-control" id="categoryName" name="category_name" placeholder="Enter Category Name" required>
                                            <div class="invalid-feedback" id="categoryNameError">
                                                Please enter a valid category name.
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="categoryDescription" class="form-label">Category Description</label>
                                            <textarea class="form-control" id="categoryDescription" name="description" rows="3" placeholder="Enter category description"></textarea>
                                            <div class="invalid-feedback" id="descriptionError">
                                                Please enter a valid category description.
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="categoryStatus" class="form-label">Status *</label>
                                            <select class="form-select" id="categoryStatus" name="status" required>
                                                <option value="">Select Status</option>
                                                <option value="active" selected>Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <div class="invalid-feedback" id="statusError">
                                                Please select a valid status.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                            <span id="submitText">Create Category</span>
                                            <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize form validation
            var form = document.getElementById('createCategoryForm');
            
            // AJAX form submission
            $('#createCategoryForm').on('submit', function(e) {
                e.preventDefault();
                
                // Reset validation errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();
                
                // Show loading state
                $('#submitBtn').prop('disabled', true);
                $('#submitText').addClass('d-none');
                $('#loadingSpinner').removeClass('d-none');
                
                // Get form data
                var formData = new FormData(this);
                
                // Make AJAX request
                $.ajax({
                    url: "{{ route('admin.categories.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Show success alert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                confirmButtonColor: '#007BFF',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reset form
                                    $('#createCategoryForm')[0].reset();
                                    // Redirect to categories list or stay on page
                                    window.location.href = "{{ route('admin.categories.index') }}";
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        
                        // Display validation errors
                        if (errors) {
                            if (errors.category_name) {
                                $('#categoryName').addClass('is-invalid');
                                $('#categoryNameError').text(errors.category_name[0]).show();
                            }
                            if (errors.description) {
                                $('#categoryDescription').addClass('is-invalid');
                                $('#descriptionError').text(errors.description[0]).show();
                            }
                            if (errors.status) {
                                $('#categoryStatus').addClass('is-invalid');
                                $('#statusError').text(errors.status[0]).show();
                            }
                        } else {
                            // Show generic error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON.message || 'An error occurred. Please try again.',
                                confirmButtonColor: '#DC3545',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    complete: function() {
                        // Reset button state
                        $('#submitBtn').prop('disabled', false);
                        $('#submitText').removeClass('d-none');
                        $('#loadingSpinner').addClass('d-none');
                    }
                });
            });

            // Bootstrap validation
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    </script>
@endsection