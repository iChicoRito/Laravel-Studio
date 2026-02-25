@extends('layouts.admin.app')
@section('title', 'View Locations')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    {{-- TABLE --}}
                    <div data-table data-table-rows-per-page="10" class="card">
                        <div class="card-header">
                            <h4 class="card-title">List of Locations</h4>
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
                                        <th data-table-sort>Province</th>
                                        <th data-table-sort>Municipality</th>
                                        <th data-table-sort>Barangay</th>
                                        <th data-table-sort>ZIP Code</th>
                                        <th data-table-sort>Status</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($locations as $location)
                                        <tr data-id="{{ $location->id }}">
                                            <td>{{ ucfirst($location->province) }}</td>
                                            <td>{{ $location->municipality }}</td>
                                            <td>
                                                @if(is_array($location->barangay) && count($location->barangay) > 0)
                                                    {{ $location->barangay[0] }}
                                                    @if(count($location->barangay) > 1)
                                                        <span class="text-muted">+{{ count($location->barangay) - 1 }} more</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Multiple Barangay</span>
                                                @endif
                                            </td>
                                            <td>{{ $location->zip_code }}</td>
                                            <td>
                                                @if($location->status == 'active')
                                                    <span class="badge badge-soft-success fs-8 w-100">ACTIVE</span>
                                                @else
                                                    <span class="badge badge-soft-danger fs-8 w-100">INACTIVE</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button type="button" class="btn btn-sm view-barangay-btn" 
                                                            data-id="{{ $location->id }}"
                                                            data-municipality="{{ $location->municipality }}"
                                                            data-zipcode="{{ $location->zip_code }}"
                                                            data-status="{{ $location->status }}"
                                                            data-barangays="{{ htmlspecialchars(json_encode($location->barangay), ENT_QUOTES, 'UTF-8') }}">
                                                        <i class="ti ti-eye fs-lg"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm delete-location-btn" data-id="{{ $location->id }}">
                                                        <i class="ti ti-trash fs-lg"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ti ti-inbox fs-1"></i>
                                                    <p class="mt-2 mb-0">No locations found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div data-table-pagination-info="locations"></div>
                                <div data-table-pagination></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- VIEW MODAL --}}
    <div class="modal fade" id="viewBarangayModal" tabindex="-1" aria-labelledby="viewBarangayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewBarangayModalLabel">
                        <span id="Municipality"></span> - <span id="ZipCode"></span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="card-title text-primary mb-3 fs-4" id="viewCategoryName"></h5>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-2">
                                <strong>Province:</strong> Cavite
                            </div>
                            <div class="mb-2">
                                <strong>Municipality:</strong> <span id="modalMunicipality"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <strong>ZIP Code:</strong> <span id="modalZipCode"></span>
                            </div>
                            <div class="mb-2">
                                <strong>Status:</strong> <span id="modalStatus"></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4 class="mb-3 text-primary">Barangay List:</h4>
                    <ul class="list-group border-0" id="viewBarangayList">
                        <!-- Barangays will be populated here -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-soft-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            // View barangay modal
            $(document).on('click', '.view-barangay-btn', function() {
                const locationId = $(this).data('id');
                const $row = $(this).closest('tr');
                const municipality = $row.find('td:nth-child(2)').text();
                const zipCode = $row.find('td:nth-child(4)').text();
                const statusText = $row.find('td:nth-child(5) .badge').text().trim();
                
                // Show loading
                $('#viewBarangayList').html(`
                    <li class="list-group-item border-0 text-center">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Loading barangays...
                    </li>
                `);
                
                // Fetch location details via AJAX
                $.ajax({
                    url: "/admin/location/" + locationId,
                    type: "GET",
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            
                            // Populate modal
                            $('#Municipality').text(data.municipality);
                            $('#ZipCode').text(data.zip_code);
                            $('#modalMunicipality').text(data.municipality);
                            $('#modalZipCode').text(data.zip_code);
                            $('#modalStatus').html(data.status === 'active' ? 
                                '<span class="badge badge-soft-success fs-8">ACTIVE</span>' : 
                                '<span class="badge badge-soft-danger fs-8">INACTIVE</span>');
                            
                            // Populate barangay list
                            $('#viewBarangayList').empty();
                            
                            if (data.barangays && data.barangays.length > 0) {
                                data.barangays.forEach((barangay, index) => {
                                    $('#viewBarangayList').append(`
                                        <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-0">
                                            <div>
                                                <i class="ti ti-check text-success me-1 align-middle fs-xl"></i>
                                               ${barangay}
                                            </div>
                                        </li>
                                    `);
                                });
                            } else {
                                $('#viewBarangayList').html(`
                                    <li class="list-group-item border-0 text-center text-muted">
                                        No barangays found
                                    </li>
                                `);
                            }
                            
                            $('#viewBarangayModal').modal('show');
                        }
                    },
                    error: function() {
                        $('#viewBarangayList').html(`
                            <li class="list-group-item border-0 text-center text-danger">
                                Failed to load barangays
                            </li>
                        `);
                        $('#viewBarangayModal').modal('show');
                    }
                });
            });

            // Delete location
            $(document).on('click', '.delete-location-btn', function() {
                const locationId = $(this).data('id');
                const $row = $(this).closest('tr');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This location will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6C757D',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/location/" + locationId,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Remove row from table
                                    $row.fadeOut(300, function() {
                                        $(this).remove();
                                        
                                        // Check if table is empty
                                        if ($('tbody tr').not(':has(td[colspan])').length === 0) {
                                            $('tbody').html(`
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="ti ti-inbox fs-1"></i>
                                                            <p class="mt-2 mb-0">No locations found</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `);
                                        }
                                    });
                                    
                                    // Show success message
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        confirmButtonColor: '#007BFF',
                                        timer: 2000,
                                        timerProgressBar: true
                                    });
                                } else {
                                    throw new Error(response.message);
                                }
                            },
                            error: function(xhr) {
                                let errorMessage = 'Failed to delete location. Please try again.';
                                
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: errorMessage,
                                    confirmButtonColor: '#DC3545'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection