@extends('layouts.owner.app')
@section('title', 'Create Packages')

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-title d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Create Packages</h4>
                        </div>
                        <div class="card-body">
                            <form id="createPackageForm" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Select Studio</label>
                                        <select class="form-select" name="studio_id" required>
                                            <option value="">Select Studio</option>
                                            @foreach($studios as $studio)
                                                <option value="{{ $studio->id }}">{{ $studio->studio_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a studio.</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Select Category</label>
                                        <select class="form-select" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a category.</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Package Name</label>
                                        <input type="text" class="form-control" name="package_name" placeholder="Enter package name" required>
                                        <div class="invalid-feedback">Please enter package name.</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Package Description</label>
                                        <textarea class="form-control" name="package_description" rows="3" placeholder="Enter package description" required></textarea>
                                        <div class="invalid-feedback">Please enter package description.</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Package Inclusion</label>                                        
                                        <div id="inclusionsContainer">
                                            <div class="input-group mb-2 inclusion-field">
                                                <input type="text" class="form-control" name="package_inclusions[]" placeholder="Enter inclusion" required>
                                                <button class="btn btn-default add-inclusion-btn" type="button">
                                                    <i class="ti ti-plus"></i>
                                                </button>
                                                <button class="btn btn-default remove-inclusion-btn" type="button" disabled>
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <small id="inclusionCounter">1 of 50 inclusions added</small>
                                        <div class="invalid-feedback">
                                            Please enter at least one package inclusion.
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Duration (hours)</label>
                                        <input type="number" class="form-control" name="duration" placeholder="Enter duration in hours" min="1" max="24" required>
                                        <div class="invalid-feedback">Please enter valid duration (1-24 hours).</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Maximum Edited Photos</label>
                                        <input type="number" class="form-control" name="maximum_edited_photos" placeholder="Enter maximum edited photos" min="1" max="1000" required>
                                        <div class="invalid-feedback">Please enter valid number (1-1000).</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Location <span class="text-danger">*</span></label>
                                        <select class="form-select" name="package_location" id="packageLocation" required>
                                            <option value="">Select Location</option>
                                            <option value="In-Studio">In-Studio</option>
                                            <option value="On-Location">On-Location</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a location type.</div>
                                        <small class="text-muted">Choose whether the photo session takes place at the studio or at an external location.</small>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Coverage Scope</label>
                                        <input type="text" class="form-control" name="coverage_scope" placeholder="Enter coverage scope (e.g., Metro Manila, Luzon)">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Package Price (PHP)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">PHP</span>
                                            <input type="number" class="form-control" name="package_price" placeholder="00.00" step="0.01" min="0" required>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid package price.</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label d-block">Online Gallery</label>
                                        <div class="btn-group w-100 mb-1" role="group" aria-label="Online Gallery Toggle">
                                            <input type="radio" class="btn-check" name="online_gallery" id="galleryYes" value="1" required>
                                            <label class="btn btn-outline-primary" for="galleryYes">
                                                <i class="ti ti-check me-1"></i> Yes, include online gallery
                                            </label>

                                            <input type="radio" class="btn-check" name="online_gallery" id="galleryNo" value="0" checked required>
                                            <label class="btn btn-outline-primary" for="galleryNo">
                                                <i class="ti ti-x me-1"></i> No, exclude online gallery
                                            </label>
                                        </div>
                                        <div class="invalid-feedback">Please select if online gallery is included.</div>
                                        <small class="text-muted">Online gallery allows clients to view and download photos online.</small>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Number of Photographers</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti ti-camera"></i>
                                            </span>
                                            <input type="number" class="form-control" name="photographer_count" 
                                                placeholder="Enter number of photographers" 
                                                min="0" max="10" step="1" value="1" required>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid number of photographers (0-10).</div>
                                        <small class="text-muted">Maximum of 10 photographers can be assigned to this package.</small>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <div class="invalid-feedback">Please select status.</div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Create Package</button>
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
            // Package inclusions repeater functionality
            let inclusionCount = 1;
            const maxInclusions = 50;
            
            // Add inclusion field
            $(document).on('click', '.add-inclusion-btn', function() {
                if (inclusionCount >= maxInclusions) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limit Reached',
                        text: `Maximum ${maxInclusions} inclusions allowed.`,
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                
                inclusionCount++;
                const newField = `
                    <div class="input-group mb-2 inclusion-field">
                        <input type="text" class="form-control" name="package_inclusions[]" placeholder="Enter inclusion" required>
                        <button class="btn btn-default add-inclusion-btn" type="button">
                            <i class="ti ti-plus"></i>
                        </button>
                        <button class="btn btn-default remove-inclusion-btn" type="button">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                `;
                
                $('#inclusionsContainer').append(newField);
                updateInclusionCounter();
                updateRemoveButtons();
            });
            
            // Remove inclusion field
            $(document).on('click', '.remove-inclusion-btn', function() {
                if (inclusionCount <= 1) return;
                
                $(this).closest('.inclusion-field').remove();
                inclusionCount--;
                updateInclusionCounter();
                updateRemoveButtons();
            });
            
            // Update inclusion counter
            function updateInclusionCounter() {
                $('#inclusionCounter').text(`${inclusionCount} of ${maxInclusions} inclusions added`);
            }
            
            // Update remove buttons state
            function updateRemoveButtons() {
                $('.remove-inclusion-btn').prop('disabled', inclusionCount <= 1);
            }
            
            // Initialize
            updateRemoveButtons();
            
            // Handle form submission - MODIFIED SECTION
            $('#createPackageForm').submit(function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(this);
                
                // Get all inclusion values as array
                const inclusions = [];
                $('input[name="package_inclusions[]"]').each(function() {
                    const value = $(this).val().trim();
                    if (value) {
                        inclusions.push(value);
                    }
                });
                
                // Remove existing inclusions from form data and add as comma-separated string
                formData.delete('package_inclusions[]');
                formData.append('package_inclusions', inclusions.join(','));
                
                // ========== ENSURE ONLINE GALLERY VALUE IS PROPERLY SET ==========
                // Radio buttons already send correct values (1 or 0)
                // No additional handling needed
                
                // Show loading state
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true).html('<i class="ti ti-loader me-1"></i> Creating...');
                
                // Submit via AJAX
                $.ajax({
                    url: "{{ route('owner.packages.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            });

                            setTimeout(() => {
                                $('#createPackageForm')[0].reset();
                                
                                // Reset inclusions repeater to single field
                                $('#inclusionsContainer').html(`
                                    <div class="input-group mb-2 inclusion-field">
                                        <input type="text" class="form-control" name="package_inclusions[]" placeholder="Enter inclusion" required>
                                        <button class="btn btn-default add-inclusion-btn" type="button">
                                            <i class="ti ti-plus"></i>
                                        </button>
                                        <button class="btn btn-default remove-inclusion-btn" type="button" disabled>
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                `);
                                inclusionCount = 1;
                                updateInclusionCounter();
                                updateRemoveButtons();
                                
                                // Uncheck all first
                                $('input[name="online_gallery"]').prop('checked', false);
                                // Set default checked to "No" (value 0)
                                $('#galleryNo').prop('checked', true);
                                
                                window.location.href = "{{ route('owner.packages.index') }}";
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            
                            for (let field in errors) {
                                let fieldName = field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                                errorMessages += errors[field].join('<br>') + '<br>';
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorMessages,
                                confirmButtonColor: '#3475db',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to create package. Please try again.',
                                confirmButtonColor: '#3475db',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            function toggleCoverageScope() {
                const selectedLocation = $('#packageLocation').val();
                const coverageScopeField = $('input[name="coverage_scope"]').closest('.col-12.mb-3');
                const coverageScopeLabel = coverageScopeField.find('label');
                const coverageScopeInput = coverageScopeField.find('input');
                
                if (selectedLocation === 'On-Location') {
                    // Show coverage scope field, make it required
                    coverageScopeField.fadeIn(300);
                    coverageScopeLabel.html('Coverage Scope <span class="text-danger">*</span>');
                    coverageScopeInput.prop('required', true);
                    coverageScopeInput.prop('placeholder', 'Enter coverage scope (e.g., Metro Manila, Luzon)');
                    coverageScopeField.find('.invalid-feedback').text('Please enter coverage scope for on-location sessions.');
                } else if (selectedLocation === 'In-Studio') {
                    // Hide coverage scope field, remove required
                    coverageScopeField.fadeOut(300);
                    coverageScopeInput.prop('required', false);
                    coverageScopeInput.val(''); // Clear the value
                } else {
                    // No selection - hide field
                    coverageScopeField.fadeOut(300);
                    coverageScopeInput.prop('required', false);
                    coverageScopeInput.val('');
                }
            }

            // Trigger on location change
            $('#packageLocation').on('change', function() {
                toggleCoverageScope();
            });

            // Initial check on page load
            toggleCoverageScope();

            // Bootstrap form validation
            (function() {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();
        });
    </script>
@endsection