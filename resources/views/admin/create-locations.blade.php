@extends('layouts.admin.app')
@section('title', 'Create Locations')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-title">
                            <h4 class="card-title">Create Location</h4>
                        </div>
                        <div class="card-body">
                            <form id="createLocationForm" class="needs-validation" novalidate>
                                @csrf
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-group mb-3">
                                            <label for="province" class="form-label">Province</label>
                                            <input type="text" class="form-control" id="province" name="province" readonly value="Cavite" placeholder="Cavite">
                                            <div class="invalid-feedback" id="provinceError">
                                                Please enter a valid province name.
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label">Municipality</label>
                                            <input type="text" class="form-control" id="municipality" name="municipality" placeholder="Enter municipality" required>
                                            <div class="invalid-feedback" id="municipalityError">
                                                Please enter a valid municipality.
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Barangay</label>                                        
                                            <div id="barangayContainer">
                                                <div class="input-group barangay-field mb-2">
                                                    <input type="text" class="form-control barangay-input" name="barangay[]" placeholder="Enter barangay" required>
                                                    <button class="btn btn-default add-barangay-btn" type="button">
                                                        <i class="ti ti-plus"></i>
                                                    </button>
                                                    <button class="btn btn-default remove-barangay-btn" type="button" disabled>
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="text-muted">You can add multiple barangay at once per municipality</small>
                                            <div class="invalid-feedback" id="barangayError">
                                                Please enter at least one barangay.
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="zipCode" class="form-label">ZIP Code</label>
                                            <input type="text" class="form-control" id="zipCode" name="zip_code" placeholder="Enter zip code" pattern="[0-9]{4}" maxlength="4" required>
                                            <div class="invalid-feedback" id="zipCodeError">
                                                Please enter a valid 4-digit zip code.
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="locationStatus" class="form-label">Status</label>
                                            <select class="form-select" id="locationStatus" name="status" required>
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
                                            <span id="submitText">Create Location</span>
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

    <!-- Modal for Viewing Barangays -->
    <div class="modal fade" id="viewBarangayModal" tabindex="-1" aria-labelledby="viewBarangayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewBarangayModalLabel">Barangay Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 id="modalMunicipality"></h6>
                    <ul class="list-group" id="barangayList">
                        <!-- Barangay list will be populated here -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize validation
            const form = $('#createLocationForm');
            const barangayContainer = $('#barangayContainer');

            // Barangay field management
            function updateBarangayButtons() {
                const barangayFields = $('.barangay-field');
                barangayFields.each(function(index) {
                    const removeBtn = $(this).find('.remove-barangay-btn');
                    removeBtn.prop('disabled', barangayFields.length <= 1);
                });
            }

            // Add barangay field
            $(document).on('click', '.add-barangay-btn', function() {
                const newField = `
                    <div class="input-group barangay-field mb-2">
                        <input type="text" class="form-control barangay-input" name="barangay[]" placeholder="Enter barangay" required>
                        <button class="btn btn-default add-barangay-btn" type="button">
                            <i class="ti ti-plus"></i>
                        </button>
                        <button class="btn btn-default remove-barangay-btn" type="button">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                `;
                barangayContainer.append(newField);
                updateBarangayButtons();
            });

            // Remove barangay field
            $(document).on('click', '.remove-barangay-btn', function() {
                if ($('.barangay-field').length > 1) {
                    $(this).closest('.barangay-field').remove();
                    updateBarangayButtons();
                }
            });

            // Form validation
            form.on('submit', function(e) {
                e.preventDefault();
                
                // Validate at least one barangay has value
                let hasBarangayValue = false;
                $('.barangay-input').each(function() {
                    if ($(this).val().trim() !== '') {
                        hasBarangayValue = true;
                    }
                });

                if (!hasBarangayValue) {
                    $('#barangayError').show();
                    return;
                }
                $('#barangayError').hide();

                // Validate form
                if (!form[0].checkValidity()) {
                    e.stopPropagation();
                    form.addClass('was-validated');
                    return;
                }

                // Collect barangay values
                const barangays = [];
                $('.barangay-input').each(function() {
                    const value = $(this).val().trim();
                    if (value !== '') {
                        barangays.push(value);
                    }
                });

                // Prepare form data
                const formData = {
                    province: 'cavite',
                    municipality: $('#municipality').val(),
                    barangay: barangays,
                    zip_code: $('#zipCode').val(),
                    status: $('#locationStatus').val(),
                    _token: $('input[name="_token"]').val()
                };

                // Show loading state
                $('#submitBtn').prop('disabled', true);
                $('#submitText').addClass('d-none');
                $('#loadingSpinner').removeClass('d-none');

                // AJAX request
                $.ajax({
                    url: "{{ route('admin.location.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Show success alert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                confirmButtonColor: '#007BFF',
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                // Reset form
                                form[0].reset();
                                form.removeClass('was-validated');
                                
                                // Reset barangay fields to one
                                $('.barangay-field').not(':first').remove();
                                $('.barangay-input:first').val('');
                                updateBarangayButtons();
                                
                                // Redirect to view page
                                window.location.href = "{{ route('admin.location.index') }}";
                            });
                        } else {
                            throw new Error(response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to create location. Please try again.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors)[0][0];
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonColor: '#DC3545'
                        });
                    },
                    complete: function() {
                        // Reset button state
                        $('#submitBtn').prop('disabled', false);
                        $('#submitText').removeClass('d-none');
                        $('#loadingSpinner').addClass('d-none');
                    }
                });
            });

            // ZIP Code validation
            $('#zipCode').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
            });

            // Initialize
            updateBarangayButtons();
        });
    </script>
@endsection