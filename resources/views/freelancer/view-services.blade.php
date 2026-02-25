@extends('layouts.freelancer.app')
@section('title', 'View Services')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    {{-- TABLE --}}
                    <div data-table data-table-rows-per-page="5" class="card">
                        <div class="card-header">
                            <h4 class="card-title">List of Services</h4>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input data-table-search type="search" class="form-control" placeholder="Search services...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold">
                                    <i class="ti ti-filter me-1"></i>Filter By:
                                </span>
                                <div class="app-filter">
                                    <select data-table-filter="category" class="me-0 form-select form-control">
                                        <option value="">All Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="servicesTable"
                                class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th data-table-sort data-column="category">Category</th>
                                        <th data-table-sort>Services</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="servicesTableBody">
                                    @foreach($services as $service)
                                        <tr data-id="{{ $service->id }}">
                                            <td data-column="category">{{ $service->category_name }}</td>
                                            <td>
                                                @php
                                                    $serviceNames = is_array($service->services_name) 
                                                        ? $service->services_name 
                                                        : json_decode($service->services_name, true);
                                                    $displayServices = array_slice($serviceNames, 0, 3);
                                                @endphp
                                                {{ implode(', ', $displayServices) }}
                                                @if(count($serviceNames) > 3) ... @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm btn-eye-service" 
                                                            data-id="{{ $service->id }}"
                                                            data-services='@json($serviceNames)'
                                                            data-category="{{ $service->category_name }}">
                                                        <i class="ti ti-eye fs-lg"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-delete-service" 
                                                            data-id="{{ $service->id }}">
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
                                <div data-table-pagination-info="services"></div>
                                <div data-table-pagination></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- VIEW MODAL --}}
    <div class="modal fade" id="viewServiceModal" tabindex="-1" aria-labelledby="viewServiceModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewServiceModalLabel">
                        Service Details
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="card-title text-primary mb-2 fs-4" id="viewCategoryName">
                        <span class="placeholder-glow" id="categoryNamePlaceholder">
                            <span class="placeholder col-6"></span>
                        </span>
                    </h5>
                    
                    <div class="mb-3">
                        <ul class="list-group border-0" id="viewServiceList">
                            {{-- Dynamic content will be inserted here via JavaScript --}}
                            <li class="list-group-item placeholder-glow">
                                <span class="placeholder col-11"></span>
                            </li>
                            <li class="list-group-item placeholder-glow">
                                <span class="placeholder col-9"></span>
                            </li>
                            <li class="list-group-item placeholder-glow">
                                <span class="placeholder col-10"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            // View service details (NO AJAX VERSION - using data attributes)
            $(document).on('click', '.btn-eye-service', function() {
                const category = $(this).data('category');
                const services = $(this).data('services');
                
                // Update modal with actual data
                $('#viewCategoryName').html(`
                    ${escapeHtml(category)}
                `);
                
                // Update service list
                $('#viewServiceList').empty();
                if (Array.isArray(services) && services.length > 0) {
                    services.forEach((serviceName, index) => {
                        $('#viewServiceList').append(`
                            <li class="list-group-item d-flex align-items-start">
                                <div class="me-2 mt-1">
                                    <i class="ti ti-check text-success fs-lg"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">${escapeHtml(serviceName)}</div>
                                </div>
                            </li>
                        `);
                    });
                } else {
                    $('#viewServiceList').html(`
                        <li class="list-group-item text-center text-muted py-4">
                            <i class="ti ti-info-circle fs-xxl mb-2"></i>
                            <p class="mb-0">No services found</p>
                        </li>
                    `);
                }
                
                // Show edit button with link
                const serviceId = $(this).data('id');
                $('#editServiceBtn')
                    .show()
                    .off('click')
                    .on('click', function() {
                        window.location.href = `/freelancer/services/${serviceId}/edit`;
                    });
                
                // Show modal
                $('#viewServiceModal').modal('show');
            });
            
            // Delete service
            $(document).on('click', '.btn-delete-service', function() {
                const serviceId = $(this).data('id');
                const row = $(this).closest('tr');
                
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
                            url: `/freelancer/services/${serviceId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Remove row from table
                                    row.fadeOut(300, function() {
                                        $(this).remove();
                                    });
                                    
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        confirmButtonColor: '#007BFF',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to delete service. Please try again.',
                                    confirmButtonColor: '#DC3545',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
            
            // Escape HTML
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        });
    </script>
@endsection