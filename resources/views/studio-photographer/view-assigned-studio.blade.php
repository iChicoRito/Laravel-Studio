@extends('layouts.studio-photographer.app')
@section('title', 'View Registered Studios')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    <div data-table data-table-rows-per-page="5" class="card">
                        <div class="card-header">
                            <h5 class="card-title">Your assigned studios</h5>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input data-table-search type="search" class="form-control" placeholder="Search schedules...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold">
                                    <i class="ti ti-filter me-1"></i>Filter By:
                                </span>
                                <div class="app-filter">
                                    <select data-table-filter="status" class="me-0 form-select form-control">
                                        <option value="">All Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="app-filter">
                                    <select data-table-filter="position" class="me-0 form-select form-control">
                                        <option value="">All Positions</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position }}">{{ $position }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th data-table-sort>Studio Name</th>
                                        <th data-table-sort>Studio Type</th>
                                        <th data-table-sort>Role</th>
                                        <th data-table-sort data-column="position">Position</th>
                                        <th data-table-sort data-column="specialization">Specialization</th>
                                        <th data-table-sort data-column="status">Status</th>
                                        <th data-table-sort>Assigned Date</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($assignedStudios as $assignment)
                                        @php
                                            $studio = $assignment->studio;
                                            $owner = $assignment->owner;
                                            $specializationService = $assignment->specializationService;
                                            $statusClass = $assignment->status === 'active' ? 'badge-soft-success' : 'badge-soft-danger';
                                            $statusText = strtoupper($assignment->status);
                                        @endphp
                                        
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="avatar-lg me-1">
                                                        <img src="{{ $studio->studio_logo ? asset('storage/' . $studio->studio_logo) : asset('assets/uploads/profile_placeholder.jpg') }}" 
                                                            alt="{{ $studio->studio_name }}" 
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <a href="#" class="link-reset studio-name" data-studio-id="{{ $studio->id }}">
                                                                {{ $studio->studio_name }}
                                                            </a>
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="fw-medium">Studio Owner:</span>
                                                            <span class="text-muted">{{ $owner->first_name }} {{ $owner->last_name }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $studio->studio_type)) }}</td>
                                            <td>Studio Photographer</td>
                                            <td>{{ $assignment->position ?? 'N/A' }}</td>
                                            <td>{{ $assignment->specialization_display ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge {{ $statusClass }} fs-8 px-1 w-100">{{ $statusText }}</span>
                                            </td>
                                            <td>{{ $assignment->created_at->format('F d, Y') }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="#" class="btn btn-sm view-studio-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#studioModal"
                                                    data-studio-id="{{ $studio->id }}">
                                                        <i class="ti ti-eye fs-lg"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ti ti-building fs-32 mb-2"></i>
                                                    <p class="mb-0">No studios assigned yet.</p>
                                                    <small>You will appear here once a studio owner assigns you to their studio.</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div data-table-pagination-info="studios"></div>
                                <div data-table-pagination></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="studioModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Studio Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <!-- Loading State -->
                <div id="modalLoading" class="modal-body p-5 text-center" style="display: none;">
                    <div class="d-flex justify-content-center align-items-center flex-column py-5">
                        <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h5 class="text-muted">
                            <i class="ti ti-loader me-2"></i>
                            Loading studio information...
                        </h5>
                    </div>
                </div>                
                <div id="modalContent" class="modal-body p-4" style="display: none;">
                    <!-- Content will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            // Store modal HTML template with all icons
            const modalTemplate = `
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-lg-8">
                        <div class="d-flex align-items-center flex-column flex-md-row">
                            <div class="flex-shrink-0 mb-3 mb-md-0">
                                <img src="" class="rounded-circle studio-logo" style="width: 80px; height: 80px; object-fit: cover;" alt="Studio Logo">
                            </div>
                            <div class="flex-grow-1 ms-md-4 text-center text-md-start">
                                <h2 class="mb-1 h3 studio-name"></h2>
                                <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2 flex-wrap verification-badge">
                                </div>
                                <p class="text-muted mb-0 location-info">
                                    <i class="ti ti-map-pin me-1"></i>
                                    <span class="location-text"></span> | Established: <span class="year-established"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <!-- STUDIO IDENTIFICATION -->
                        <div class="row g-2 mb-4">
                            <h5 class="card-title text-primary">STUDIO IDENTIFICATION INFORMATION</h5>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-building fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Studio Name</label>
                                        <p class="mb-0 fw-medium studio-name-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-briefcase fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Studio Type</label>
                                        <p class="mb-0 fw-medium studio-type-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-calendar fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Year Established</label>
                                        <p class="mb-0 fw-medium year-established-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-file-text fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Studio Description</label>
                                        <p class="mb-0 fw-medium studio-description-field"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- OWNER INFORMATION -->
                        <div class="row g-2 mb-4">
                            <h5 class="card-title text-primary">STUDIO OWNER INFORMATION</h5>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-user fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Owner Name</label>
                                        <p class="mb-0 fw-medium owner-name-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-mail fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Email Address</label>
                                        <p class="mb-0 fw-medium owner-email-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-phone fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Mobile Number</label>
                                        <p class="mb-0 fw-medium owner-mobile-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-user-star fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">User Role</label>
                                        <p class="mb-0 fw-medium">Studio Owner</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CONTACT INFORMATION -->
                        <div class="row g-2 mb-4">
                            <h5 class="card-title text-primary">STUDIO CONTACT INFORMATION</h5>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-phone fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Contact Number</label>
                                        <p class="mb-0 fw-medium contact-number-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-mail fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Studio Email</label>
                                        <p class="mb-0 fw-medium studio-email-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-brand-facebook fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Facebook</label>
                                        <p class="mb-0 fw-medium facebook-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-brand-instagram fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Instagram</label>
                                        <p class="mb-0 fw-medium instagram-field"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LOCATION -->
                        <div class="row g-2 mb-4">
                            <h5 class="card-title text-primary">STUDIO LOCATION INFORMATION</h5>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-map fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Province</label>
                                        <p class="mb-0 fw-medium province-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-map-pin fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Municipality</label>
                                        <p class="mb-0 fw-medium municipality-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-navigation fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Barangay</label>
                                        <p class="mb-0 fw-medium barangay-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-hash fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">ZIP Code</label>
                                        <p class="mb-0 fw-medium zip-code-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-home fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Street Address</label>
                                        <p class="mb-0 fw-medium street-field"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SERVICE & BUSINESS -->
                        <div class="row g-2 mb-4">
                            <h5 class="card-title text-primary">SERVICE AND BUSINESS INFORMATION</h5>
                            <div class="col-12 mb-3">
                                <label class="text-muted small mb-1">Service Categories</label>
                                <div class="list-group services-list">
                                    <!-- Services will be dynamically added here -->
                                </div>
                            </div>
                        </div>

                        <!-- OPERATING INFORMATION -->
                        <div class="row g-2 mb-4">
                            <h5 class="card-title text-primary">OPERATING INFORMATION</h5>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-calendar-event fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Operating Days</label>
                                        <p class="mb-0 fw-medium operating-days-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-clock fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Operating Hours</label>
                                        <p class="mb-0 fw-medium operating-hours-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-users fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Maximum Clients Per Day</label>
                                        <p class="mb-0 fw-medium max-clients-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-alert-circle fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Advance Booking Requirement</label>
                                        <p class="mb-0 fw-medium advance-booking-field"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VERIFICATION DOCUMENTS -->
                        <div class="row g-2">
                            <h5 class="card-title text-primary">VERIFICATION DOCUMENTS</h5>
                            <div class="col-12">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-file-check fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Business Permit</label>
                                        <p class="mb-0 fw-medium business-permit-field"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-id fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <label class="text-muted small mb-1">Valid ID (Owner)</label>
                                        <p class="mb-0 fw-medium owner-id-field"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Handle view studio button click
            $(document).on('click', '.view-studio-btn', function(e) {
                e.preventDefault();
                const studioId = $(this).data('studio-id');
                const button = $(this);
                
                // Show modal immediately with loading state
                $('#studioModal').modal('show');
                
                // Show loading, hide content
                $('#modalLoading').show();
                $('#modalContent').hide().empty();
                
                // Set modal title to show loading
                $('.modal-title').html('Loading Studio Information...');
                
                // Fetch studio details via AJAX
                $.ajax({
                    url: '/studio-photographer/studio/' + studioId + '/details',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Load data into modal
                        loadStudioModal(response);
                        
                        // Hide loading, show content
                        $('#modalLoading').hide();
                        $('#modalContent').show();
                    },
                    error: function(xhr) {
                        // Hide loading
                        $('#modalLoading').hide();
                        
                        // Show error message in modal
                        $('#modalContent').html(`
                            <div class="text-center py-5">
                                <div class="text-danger mb-3">
                                    <i class="ti ti-alert-triangle fs-48"></i>
                                </div>
                                <h5 class="text-danger">Failed to Load Information</h5>
                                <p class="text-muted mb-4">Unable to load studio details. Please try again.</p>
                                <button class="btn btn-primary" onclick="location.reload()">
                                    <i class="ti ti-refresh me-1"></i> Reload Page
                                </button>
                            </div>
                        `).show();
                        
                        // Also show toast notification
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to load studio information. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#3475db',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Reset modal when closed
            $('#studioModal').on('hidden.bs.modal', function () {
                // Reset to initial state
                $('#modalLoading').hide();
                $('#modalContent').hide().empty();
                $('.modal-title').html('Studio Information');
            });

            // Load studio data into modal
            function loadStudioModal(studio) {
                if (!studio) return;
                
                // Set modal title
                $('.modal-title').html(`Studio Information - ${studio.name}`);
                
                // Insert template if not already present
                if ($('#modalContent').is(':empty')) {
                    $('#modalContent').html(modalTemplate);
                }
                
                // Update studio header
                $('.studio-logo').attr('src', studio.logo).attr('alt', studio.name);
                $('.studio-name').text(studio.name);
                $('.location-text').text(`${studio.municipality}, ${studio.province}`);
                $('.year-established').text(studio.year_established);
                
                // Update verification badge
                let badgeClass = 'badge-soft-success';
                if (studio.verification_status === 'Pending') {
                    badgeClass = 'badge-soft-warning';
                } else if (studio.verification_status !== 'Verified') {
                    badgeClass = 'badge-soft-danger';
                }
                $('.verification-badge').html(
                    `<span class="badge ${badgeClass} p-1">${studio.verification_status}</span>`
                );
                
                // Update studio identification
                $('.studio-name-field').text(studio.name);
                $('.studio-type-field').text(studio.type);
                $('.year-established-field').text(studio.year_established);
                $('.studio-description-field').text(studio.description);
                
                // Update owner information
                $('.owner-name-field').text(studio.owner_name);
                $('.owner-email-field').text(studio.owner_email);
                $('.owner-mobile-field').text(studio.owner_mobile);
                
                // Update contact information
                $('.contact-number-field').text(studio.contact_number);
                $('.studio-email-field').text(studio.studio_email);
                $('.facebook-field').html(studio.facebook_url ? 
                    `<a href="${studio.facebook_url}" target="_blank" class="text-primary text-decoration-none">${studio.facebook_url}</a>` : 
                    'N/A');
                $('.instagram-field').html(studio.instagram_url ? 
                    `<a href="${studio.instagram_url}" target="_blank" class="text-primary text-decoration-none">${studio.instagram_url}</a>` : 
                    'N/A');
                
                // Update location information
                $('.province-field').text(studio.province);
                $('.municipality-field').text(studio.municipality);
                $('.barangay-field').text(studio.barangay);
                $('.zip-code-field').text(studio.zip_code);
                $('.street-field').text(studio.street);
                
                // Update services list
                const servicesList = $('.services-list');
                servicesList.empty();

                if (studio.services_by_category && Object.keys(studio.services_by_category).length > 0) {
                    Object.entries(studio.services_by_category).forEach(([categoryName, services]) => {
                        servicesList.append(`
                            <div class="list-group-item">
                                <div class="d-flex align-items-start">
                                    <i class="ti ti-check text-success me-2 mt-1"></i>
                                    <div class="w-100">
                                        <h5 class="mb-2 fw-semibold">${categoryName}</h5>
                                        ${services.map(service => {
                                            let serviceName = service;
                                            if (typeof service === 'string' && service.startsWith('[') && service.endsWith(']')) {
                                                try {
                                                    const parsed = JSON.parse(service);
                                                    serviceName = Array.isArray(parsed) ? parsed.join(', ') : service;
                                                } catch (e) {}
                                            }
                                            return `<p class="text-muted mb-1">${serviceName}</p>`;
                                        }).join('')}
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                } else if (studio.services && Array.isArray(studio.services) && studio.services.length > 0) {
                    servicesList.append(`
                        <div class="list-group-item">
                            <div class="d-flex align-items-start">
                                <i class="ti ti-check text-success me-2 mt-1"></i>
                                <div class="w-100">
                                    <h5 class="mb-2 fw-semibold">Assigned Services</h5>
                                    ${studio.services.map(service => {
                                        let serviceName = service;
                                        if (typeof service === 'string' && service.startsWith('[') && service.endsWith(']')) {
                                            try {
                                                const parsed = JSON.parse(service);
                                                serviceName = Array.isArray(parsed) ? parsed.join(', ') : service;
                                            } catch (e) {}
                                        }
                                        return `<p class="text-muted mb-1">${serviceName}</p>`;
                                    }).join('')}
                                </div>
                            </div>
                        </div>
                    `);
                } else {
                    servicesList.html(`
                        <div class="list-group-item">
                            <div class="text-center text-muted py-3">
                                <i class="ti ti-info-circle fs-20 mb-2"></i>
                                <p class="mb-0">No services found</p>
                            </div>
                        </div>
                    `);
                }
                
                // Update operating information
                $('.operating-days-field').text(studio.operating_days);
                $('.operating-hours-field').text(`${studio.start_time} - ${studio.end_time}`);
                $('.max-clients-field').text(studio.max_clients_per_day);
                $('.advance-booking-field').text(`${studio.advance_booking_days} day(s) before event`);
                
                // Update verification documents
                $('.business-permit-field').html(studio.business_permit ? 
                    `<a href="${studio.business_permit}" target="_blank" class="text-primary text-decoration-none">View Business Permit</a>` : 
                    'No document uploaded');
                $('.owner-id-field').html(studio.owner_id_document ? 
                    `<a href="${studio.owner_id_document}" target="_blank" class="text-primary text-decoration-none">View ID Document</a>` : 
                    'No document uploaded');
            }
            
            // [Rest of your existing table filtering and pagination code remains the same...]
            
            // Table filtering (existing code)
            $(document).on('change', '[data-table-filter]', function() {
                const filterType = $(this).data('table-filter');
                const filterValue = $(this).val().toLowerCase();
                
                $('tbody tr').each(function() {
                    const row = $(this);
                    let showRow = true;
                    
                    const searchValue = $('[data-table-search]').val().toLowerCase();
                    if (searchValue) {
                        const rowText = row.text().toLowerCase();
                        if (!rowText.includes(searchValue)) {
                            showRow = false;
                        }
                    }
                    
                    if (filterValue && showRow) {
                        if (filterType === 'status') {
                            const statusText = row.find('td:nth-child(6)').text().toLowerCase();
                            if (!statusText.includes(filterValue.toLowerCase())) {
                                showRow = false;
                            }
                        } else if (filterType === 'position') {
                            const positionText = row.find('td:nth-child(4)').text().toLowerCase();
                            if (positionText !== filterValue.toLowerCase()) {
                                showRow = false;
                            }
                        } else if (filterType === 'specialization') {
                            const specializationText = row.find('td:nth-child(5)').text().toLowerCase();
                            if (specializationText !== filterValue.toLowerCase()) {
                                showRow = false;
                            }
                        }
                    }
                    
                    row.toggle(showRow);
                });
                
                updatePaginationInfo();
            });
            
            // Search functionality (existing code)
            $(document).on('keyup', '[data-table-search]', function() {
                const searchValue = $(this).val().toLowerCase();
                
                $('tbody tr').each(function() {
                    const row = $(this);
                    const rowText = row.text().toLowerCase();
                    const showRow = !searchValue || rowText.includes(searchValue);
                    row.toggle(showRow);
                });
                
                updatePaginationInfo();
            });
            
            // Update pagination info (existing code)
            function updatePaginationInfo() {
                const visibleRows = $('tbody tr:visible').length;
                const totalRows = $('tbody tr').length;
                $('[data-table-pagination-info="studios"]').text(`Showing ${visibleRows} of ${totalRows} studio(s)`);
            }
            
            // Initialize SweetAlert defaults (existing code)
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary me-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            });
            
            // Initialize table functions
            updatePaginationInfo();
        });
    </script>
@endsection