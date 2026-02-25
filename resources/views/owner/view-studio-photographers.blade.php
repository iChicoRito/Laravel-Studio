@extends('layouts.owner.app')
@section('title', 'Registered Studio Photographers')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    {{-- TABLE --}}
                    <div data-table data-table-rows-per-page="5" class="card">
                        <div class="card-header">
                            <h5 class="card-title">Registered Studio Photographers</h5>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input data-table-search type="search" class="form-control" placeholder="Search photographers...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold">
                                    <i class="ti ti-filter me-1"></i>Filter By:
                                </span>
                                <div class="app-filter">
                                    <select data-table-filter="studio" class="me-2 form-select form-control">
                                        <option value="">All Studios</option>
                                        @foreach($studios as $studio)
                                            <option value="{{ $studio->id }}">{{ $studio->studio_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="app-filter">
                                    <select data-table-filter="status" class="me-0 form-select form-control">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th data-table-sort>Full Name</th>
                                        <th data-table-sort>Email Address</th>
                                        <th data-table-sort>Contact</th>
                                        <th data-table-sort>Role</th>
                                        <th data-table-sort data-column="status">Status</th>
                                        <th data-table-sort>Date Registered</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($photographers as $photographer)
                                        @php
                                            $user = $photographer->photographer;
                                            $studio = $photographer->studio;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <a href="javascript:void(0)" class="link-reset view-photographer" data-id="{{ $photographer->id }}">
                                                                {{ $user->first_name }} {{ $user->last_name }}
                                                            </a>
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="fw-medium">UUID:</span>
                                                            <span class="text-muted">{{ $user->uuid }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->mobile_number }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <a href="javascript:void(0)" class="link-reset">
                                                                {{ $photographer->position }}
                                                            </a>
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="text-muted">Studio Photographer</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-{{ $photographer->status === 'active' ? 'success' : 'danger' }} w-100">
                                                    {{ strtoupper($photographer->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $photographer->created_at->format('F d, Y') }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button type="button" class="btn btn-sm view-photographer-btn" data-id="{{ $photographer->id }}">
                                                        <i class="ti ti-eye fs-lg"></i>
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
                                <div data-table-pagination-info="users"></div>
                                <div data-table-pagination></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="photographerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="photographerModalLabel">
                        Photographer Profile - Juan Miguel Santos
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row align-items-center mb-4">
                        <div class="col-12 col-lg-8">
                            <div class="d-flex align-items-center flex-column flex-md-row">
                                <div class="flex-shrink-0 mb-3 mb-md-0">
                                    <img src="https://via.placeholder.com/80" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="Photographer Profile Photo">
                                </div>
                                
                                <div class="flex-grow-1 ms-md-4 text-center text-md-start">
                                    <h2 class="mb-1 h3">Juan Miguel Santos</h2>
                                    <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2 flex-wrap">
                                        <span class="badge badge-soft-success p-1">Verified</span>
                                        <span class="badge badge-soft-primary ms-2 p-1">Lead Photographer</span>
                                    </div>
                                    
                                    <p class="text-muted mb-0">
                                        <i class="ti ti-map-pin me-1"></i>
                                        General Trias, Cavite | Joined: 2023
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="row g-2 mb-3">
                                <h5 class="card-title text-primary">PHOTOGRAPHER IDENTIFICATION INFORMATION</h5>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i data-lucide="user" class="fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Full Name</label>
                                            <p class="mb-0 fw-medium">Juan Miguel Santos</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i data-lucide="briefcase" class="fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Position</label>
                                            <p class="mb-0 fw-medium">Lead Photographer</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i data-lucide="calendar" class="fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Years of Experience</label>
                                            <p class="mb-0 fw-medium">7 Years</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i data-lucide="file-text" class="fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Status</label>
                                            <p class="mb-0 fw-medium">Active</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <h5 class="card-title text-primary">CONTACT INFORMATION</h5>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i data-lucide="mail" class="fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Email Address</label>
                                            <p class="mb-0 fw-medium">juan.santos@photographer.ph</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i data-lucide="phone" class="fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Mobile Number</label>
                                            <p class="mb-0 fw-medium">+63 917 123 4567</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <h5 class="card-title text-primary">SPECIALIZATION & SKILLS</h5>
                                <div class="col-12 mb-3">
                                    <label class="text-muted small mb-1">Specializations</label>
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-start">
                                                <i class="ti ti-check text-success me-2 mt-1"></i>
                                                <div>
                                                    <h5 class="mb-1 fw-semibold">Wedding Photography</h5>
                                                    <p class="text-muted mb-0">Candid & editorial style</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-start">
                                                <i class="ti ti-check text-success me-2 mt-1"></i>
                                                <div>
                                                    <h5 class="mb-1 fw-semibold">Portrait Photography</h5>
                                                    <p class="text-muted mb-0">Studio & outdoor sessions</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-start">
                                                <i class="ti ti-check text-success me-2 mt-1"></i>
                                                <div>
                                                    <h5 class="mb-1 fw-semibold">Event Coverage</h5>
                                                    <p class="text-muted mb-0">Corporate & debut events</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <h5 class="card-title text-primary">PROFESSIONAL INFORMATION</h5>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light-primary rounded-circle p-2">
                                                <i data-lucide="users" class="fs-20 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <label class="text-muted small mb-1">Associated Studio</label>
                                            <p class="mb-0 fw-medium">Lumière Photography Studio</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            // Simple search functionality
            $('[data-table-search]').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                
                $('tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.indexOf(searchText) > -1);
                });
            });
            
            // Simple filter by studio
            $('[data-table-filter="studio"]').on('change', function() {
                const studioId = $(this).val();
                
                $('tbody tr').each(function() {
                    if (!studioId) {
                        $(this).show();
                        return;
                    }
                    
                    // Get studio ID from data attribute
                    const rowStudioId = $(this).find('.studio-id').data('id');
                    $(this).toggle(!rowStudioId || rowStudioId == studioId);
                });
            });
            
            // Simple filter by status
            $('[data-table-filter="status"]').on('change', function() {
                const status = $(this).val().toLowerCase();
                
                $('tbody tr').each(function() {
                    if (!status) {
                        $(this).show();
                        return;
                    }
                    
                    const rowStatus = $(this).find('.badge').text().toLowerCase();
                    $(this).toggle(rowStatus.includes(status));
                });
            });

            // Handle photographer view
            $(document).on('click', '.view-photographer-btn, .view-photographer', function() {
                const photographerId = $(this).data('id');
                
                // Show loading
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Load photographer details via AJAX
                $.ajax({
                    url: "{{ route('owner.studio-photographers.show', ['id' => '__ID__']) }}".replace('__ID__', photographerId),
                    method: 'GET',
                    success: function(response) {
                        Swal.close();
                        
                        if (response.success) {
                            const photographer = response.data;
                            const user = photographer.photographer;
                            const studio = photographer.studio;
                            const services = photographer.services;
                            const categoryName = response.category_name || 'Not specified';
                            
                            // Build services HTML (for backward compatibility)
                            let servicesHtml = '';
                            if (services && services.length > 0) {
                                services.forEach(service => {
                                    // Get service name(s)
                                    let serviceNames = '';
                                    if (typeof service.service_name === 'string') {
                                        try {
                                            const parsed = JSON.parse(service.service_name);
                                            serviceNames = Array.isArray(parsed) ? parsed.join(', ') : service.service_name;
                                        } catch (e) {
                                            serviceNames = service.service_name;
                                        }
                                    } else if (Array.isArray(service.service_name)) {
                                        serviceNames = service.service_name.join(', ');
                                    } else {
                                        serviceNames = 'No service name';
                                    }
                                    
                                    servicesHtml += `
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-start">
                                                <i class="ti ti-check text-success me-2 mt-1"></i>
                                                <div>
                                                    <h5 class="mb-1 fw-semibold">${serviceNames}</h5>
                                                    <p class="text-muted mb-0">${service.category?.category_name || 'N/A'}</p>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                });
                            } else {
                                servicesHtml = '<div class="text-muted">No services assigned</div>';
                            }
                            
                            // Show modal with details
                            const modalHtml = `
                                <div class="modal fade" id="photographerDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-semibold">
                                                    Photographer Profile - ${user.first_name} ${user.last_name}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row align-items-center mb-4">
                                                    <div class="col-12 col-lg-8">
                                                        <div class="d-flex align-items-center flex-column flex-md-row">
                                                            <div class="flex-shrink-0 mb-3 mb-md-0">
                                                                <img src="${user.profile_photo ? '/storage/profile-photos/' + user.profile_photo : 'https://via.placeholder.com/80'}" 
                                                                    class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" 
                                                                    alt="Photographer Profile Photo">
                                                            </div>
                                                            
                                                            <div class="flex-grow-1 ms-md-4 text-center text-md-start">
                                                                <h2 class="mb-1 h3">${user.first_name} ${user.last_name}</h2>
                                                                <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2 flex-wrap">
                                                                    <span class="badge badge-soft-${user.status === 'active' ? 'success' : 'danger'} p-1">
                                                                        ${user.status === 'active' ? 'Active' : 'Inactive'}
                                                                    </span>
                                                                    <span class="badge badge-soft-primary ms-2 p-1">${photographer.position}</span>
                                                                </div>
                                                                
                                                                <p class="text-muted mb-0">
                                                                    <i class="ti ti-map-pin me-1"></i>
                                                                    ${studio ? studio.studio_name : 'N/A'} | Joined: ${new Date(photographer.created_at).getFullYear()}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="row g-2 mb-3">
                                                            <h5 class="card-title text-primary">PHOTOGRAPHER INFORMATION</h5>
                                                            <div class="col-12 col-md-6">
                                                                <div class="d-flex align-items-start">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="bg-light-primary rounded-circle p-2">
                                                                            <i data-lucide="user" class="fs-20 text-primary"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <label class="text-muted small mb-1">Full Name</label>
                                                                        <p class="mb-0 fw-medium">${user.first_name} ${user.middle_name ? user.middle_name + ' ' : ''}${user.last_name}</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <div class="d-flex align-items-start">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="bg-light-primary rounded-circle p-2">
                                                                            <i data-lucide="briefcase" class="fs-20 text-primary"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <label class="text-muted small mb-1">Position</label>
                                                                        <p class="mb-0 fw-medium">${photographer.position}</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <div class="d-flex align-items-start">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="bg-light-primary rounded-circle p-2">
                                                                            <i data-lucide="calendar" class="fs-20 text-primary"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <label class="text-muted small mb-1">Years of Experience</label>
                                                                        <p class="mb-0 fw-medium">${photographer.years_of_experience} Years</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <div class="d-flex align-items-start">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="bg-light-primary rounded-circle p-2">
                                                                            <i data-lucide="file-text" class="fs-20 text-primary"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <label class="text-muted small mb-1">Status</label>
                                                                        <p class="mb-0 fw-medium">${photographer.status}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row g-2 mb-3">
                                                            <h5 class="card-title text-primary">CONTACT INFORMATION</h5>
                                                            <div class="col-12 col-md-6">
                                                                <div class="d-flex align-items-start">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="bg-light-primary rounded-circle p-2">
                                                                            <i data-lucide="mail" class="fs-20 text-primary"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <label class="text-muted small mb-1">Email Address</label>
                                                                        <p class="mb-0 fw-medium">${user.email}</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <div class="d-flex align-items-start">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="bg-light-primary rounded-circle p-2">
                                                                            <i data-lucide="phone" class="fs-20 text-primary"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <label class="text-muted small mb-1">Mobile Number</label>
                                                                        <p class="mb-0 fw-medium">${user.mobile_number}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row g-2 mb-3">
                                                            <h5 class="card-title text-primary">SPECIALIZATION</h5>
                                                            <div class="col-12 mb-3">
                                                                <label class="text-muted small mb-1">Primary Specialization</label>
                                                                <div class="list-group">
                                                                    <div class="list-group-item">
                                                                        <div class="d-flex align-items-start">
                                                                            <i class="ti ti-check text-success me-2 mt-1"></i>
                                                                            <div>
                                                                                <h5 class="mb-1 fw-semibold">${categoryName}</h5>
                                                                                <p class="text-muted mb-0">Primary Specialization</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row g-2 mb-3">
                                                            <h5 class="card-title text-primary">PROFESSIONAL INFORMATION</h5>
                                                            <div class="col-12 col-md-6">
                                                                <div class="d-flex align-items-start">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="bg-light-primary rounded-circle p-2">
                                                                            <i data-lucide="users" class="fs-20 text-primary"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <label class="text-muted small mb-1">Associated Studio</label>
                                                                        <p class="mb-0 fw-medium">${studio ? studio.studio_name : 'N/A'}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            // Remove existing modal if any
                            $('#photographerDetailModal').remove();
                            
                            // Append and show modal
                            $('body').append(modalHtml);
                            $('#photographerDetailModal').modal('show');
                            
                            // Initialize Lucide icons in modal
                            if (window.lucide) {
                                lucide.createIcons();
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to load photographer details'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading photographer details:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load photographer details'
                        });
                    }
                });
            });
        });
    </script>
@endsection