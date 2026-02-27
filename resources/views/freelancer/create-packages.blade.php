@extends('layouts.freelancer.app')
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
                                        <label class="form-label">Select Category</label>
                                        <select class="form-select" name="category_id" id="categorySelect" required>
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

                                    <!-- ==== Start: Time Customization Control ==== -->
                                    <div class="col-12 mb-3">
                                        <label class="form-label d-block">Allow Time Customization</label>
                                        <div class="btn-group w-100 mb-1" role="group" aria-label="Time Customization Toggle">
                                            <input type="radio" class="btn-check" name="allow_time_customization" id="timeCustomizationYes" value="1" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="timeCustomizationYes">
                                                <i class="ti ti-clock-edit me-1"></i> Yes, clients can customize duration
                                            </label>

                                            <input type="radio" class="btn-check" name="allow_time_customization" id="timeCustomizationNo" value="0" checked autocomplete="off">
                                            <label class="btn btn-outline-primary" for="timeCustomizationNo">
                                                <i class="ti ti-clock me-1"></i> No, fixed duration only
                                            </label>
                                        </div>
                                        <div class="invalid-feedback">Please select if time customization is allowed.</div>
                                        <small class="text-muted">
                                            <i class="ti ti-info-circle me-1"></i>
                                            When enabled, clients can choose their own duration during booking. When disabled, you must specify a fixed duration.
                                        </small>
                                    </div>
                                    <!-- ==== End: Time Customization Control ==== -->

                                    <!-- ==== Start: Duration Field with Conditional Visibility ==== -->
                                    <div class="col-12 mb-3" id="durationField">
                                        <label class="form-label">Duration (hours) <span class="text-danger" id="durationRequired">*</span></label>
                                        <input type="number" class="form-control" name="duration" id="durationInput" placeholder="Enter duration in hours" min="1" max="24">
                                        <div class="invalid-feedback">Please enter valid duration (1-24 hours).</div>
                                        <small class="text-muted" id="durationHelpText">Fixed duration for this package.</small>
                                    </div>
                                    <!-- ==== End: Duration Field with Conditional Visibility ==== -->

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Maximum Edited Photos</label>
                                        <input type="number" class="form-control" name="maximum_edited_photos" placeholder="Enter maximum edited photos" min="1" max="1000" required>
                                        <div class="invalid-feedback">Please enter valid number (1-1000).</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Coverage Scope</label>
                                        <input type="text" class="form-control" name="coverage_scope" placeholder="Enter coverage scope">
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
                                            <input type="radio" class="btn-check" name="online_gallery" id="galleryYes" value="1" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="galleryYes">
                                                <i class="ti ti-check me-1"></i> Yes, include online gallery
                                            </label>
                                            <input type="radio" class="btn-check" name="online_gallery" id="galleryNo" value="0" checked autocomplete="off">
                                            <label class="btn btn-outline-primary" for="galleryNo">
                                                <i class="ti ti-x me-1"></i> No, exclude online gallery
                                            </label>
                                        </div>
                                        <small class="text-muted">Online gallery allows clients to view and download photos online.</small>
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
            // Initialize inclusions counter
            let inclusionCount = 1;
            const maxInclusions = 50;
            
            // Update counter display
            function updateCounter() {
                $('#inclusionCounter').text(`${inclusionCount} of ${maxInclusions} inclusions added`);
            }
            
            // Add new inclusion field
            $(document).on('click', '.add-inclusion-btn', function() {
                if (inclusionCount >= maxInclusions) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Maximum Reached',
                        text: `Maximum of ${maxInclusions} inclusions allowed.`,
                        confirmButtonColor: '#6C757D'
                    });
                    return;
                }
                
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
                inclusionCount++;
                updateCounter();
                
                // Enable remove button for all fields except first
                $('.remove-inclusion-btn').prop('disabled', false);
            });
            
            // Remove inclusion field
            $(document).on('click', '.remove-inclusion-btn', function() {
                if (inclusionCount <= 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Minimum Required',
                        text: 'At least one inclusion is required.',
                        confirmButtonColor: '#6C757D'
                    });
                    return;
                }
                
                $(this).closest('.inclusion-field').remove();
                inclusionCount--;
                updateCounter();
                
                // Disable remove button if only one field remains
                if (inclusionCount === 1) {
                    $('.remove-inclusion-btn').prop('disabled', true);
                }
            });

            // ==== Start: Time Customization Toggle Logic ====
            function toggleDurationField() {
                const allowCustomization = $('input[name="allow_time_customization"]:checked').val();
                const durationField = $('#durationField');
                const durationInput = $('#durationInput');
                const durationRequired = $('#durationRequired');
                const durationHelpText = $('#durationHelpText');
                
                if (allowCustomization === '1') {
                    // Time customization is ALLOWED - hide duration field, remove required
                    durationField.fadeOut(300);
                    durationInput.prop('required', false);
                    durationInput.val(''); // Clear any existing value
                    durationRequired.hide();
                    durationHelpText.text('Clients can choose their preferred duration during booking.');
                } else {
                    // Time customization is NOT allowed - show duration field, make it required
                    durationField.fadeIn(300);
                    durationInput.prop('required', true);
                    durationRequired.show();
                    durationHelpText.text('Fixed duration for this package.');
                }
            }

            // Trigger on time customization radio change
            $('input[name="allow_time_customization"]').on('change', function() {
                toggleDurationField();
                
                // Trigger Bootstrap validation update if needed
                durationInput.removeClass('is-invalid');
            });

            // Initial check on page load (default is "No" - value 0, so duration should be visible)
            toggleDurationField();
            // ==== End: Time Customization Toggle Logic ====
            
            // Form submission with AJAX
            $('#createPackageForm').on('submit', function(e) {
                e.preventDefault();
                
                // Collect form data as object
                const formData = {
                    category_id: $('#categorySelect').val(),
                    package_name: $('input[name="package_name"]').val(),
                    package_description: $('textarea[name="package_description"]').val(),
                    // ==== Start: Include allow_time_customization ==== //
                    allow_time_customization: $('input[name="allow_time_customization"]:checked').val(),
                    // ==== End: Include allow_time_customization ==== //
                    duration: $('input[name="duration"]').val(),
                    maximum_edited_photos: $('input[name="maximum_edited_photos"]').val(),
                    coverage_scope: $('input[name="coverage_scope"]').val(),
                    package_price: $('input[name="package_price"]').val(),
                    status: $('select[name="status"]').val(),
                    online_gallery: $('input[name="online_gallery"]:checked').val(),
                    package_inclusions: []
                };
                
                // Debug: Log the values
                console.log('Form data:', formData);
                
                // Collect inclusions as array
                $('input[name="package_inclusions[]"]').each(function() {
                    if ($(this).val().trim() !== '') {
                        formData.package_inclusions.push($(this).val().trim());
                    }
                });
                
                // Validate at least one inclusion
                if (formData.package_inclusions.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please enter at least one package inclusion.',
                        confirmButtonColor: '#DC3545'
                    });
                    return;
                }

                // ==== Start: Validate duration based on time customization ====
                const allowCustomization = formData.allow_time_customization;
                
                // If time customization is NOT allowed, duration is required
                if (allowCustomization === '0' && (!formData.duration || formData.duration === '')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Duration is required when time customization is not allowed.',
                        confirmButtonColor: '#DC3545'
                    });
                    
                    // Highlight the duration field
                    $('#durationInput').addClass('is-invalid');
                    
                    // Re-enable submit button
                    const submitBtn = $(this).find('button[type="submit"]');
                    submitBtn.prop('disabled', false).html('Create Package');
                    return false;
                }
                
                // If time customization is allowed, ensure duration is not sent
                if (allowCustomization === '1') {
                    delete formData.duration;
                }
                // ==== End: Validate duration based on time customization ====
                
                // Show loading state
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true).html('<i class="ti ti-loader me-2"></i>Creating...');
                
                // Send AJAX request
                $.ajax({
                    url: "{{ route('freelancer.packages.store') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = "{{ route('freelancer.packages.index') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to create package.',
                                timer: 1500,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while creating the package.';
                        
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('<br>');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error!',
                            html: errorMessage,
                            confirmButtonColor: '#DC3545'
                        });
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });
            
            // Bootstrap validation
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        });
    </script>
@endsection