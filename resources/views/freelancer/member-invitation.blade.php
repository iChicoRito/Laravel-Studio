@extends('layouts.freelancer.app')
@section('title', 'Studio Invitations')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    {{-- ALERT MESSAGES --}}
                    <div id="alertContainer"></div>
                    
                    {{-- TABLE --}}
                    <div data-table data-table-rows-per-page="5" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Studio Invitations</h4>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input data-table-search type="search" class="form-control" placeholder="Search studio or owner...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th data-table-sort>Studio</th>
                                        <th data-table-sort>Owner</th>
                                        <th data-table-sort>Invitation Date</th>
                                        <th data-table-sort>Status</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invitations as $invitation)
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'approved' => 'success',
                                                'rejected' => 'danger',
                                                'cancelled' => 'danger'
                                            ];
                                            
                                            $statusTexts = [
                                                'pending' => 'Waiting for your response',
                                                'approved' => 'You accepted the invitation',
                                                'rejected' => 'You declined the invitation',
                                                'cancelled' => 'Cancelled by owner'
                                            ];
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($invitation->studio && $invitation->studio->studio_logo)
                                                        <img src="/storage/{{ $invitation->studio->studio_logo }}" 
                                                             class="rounded-circle me-3" 
                                                             style="width: 40px; height: 40px; object-fit: cover;" 
                                                             alt="{{ $invitation->studio->studio_name }}">
                                                    @else
                                                        <div class="rounded-circle bg-light-primary d-flex align-items-center justify-content-center me-3" 
                                                             style="width: 40px; height: 40px;">
                                                            <i data-lucide="building" class="fs-16 text-primary"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h5 class="mb-1">
                                                            {{ $invitation->studio->studio_name ?? 'Unknown Studio' }}
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="fw-medium">Location:</span>
                                                            <span class="text-muted">
                                                                @if($invitation->studio && $invitation->studio->location)
                                                                    {{ $invitation->studio->location->municipality }}, {{ $invitation->studio->location->province }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($invitation->inviter && $invitation->inviter->profile_picture)
                                                        <img src="/storage/{{ $invitation->inviter->profile_picture }}" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;" alt="{{ $invitation->inviter->full_name }}">
                                                    @endif
                                                    <div>
                                                        <h5 class="mb-1">
                                                            {{ $invitation->inviter->full_name ?? 'Unknown Owner' }}
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="fw-medium">Email:</span>
                                                            <span class="text-muted">{{ $invitation->inviter->email ?? 'N/A' }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-1">
                                                            {{ $invitation->invited_at->format('M d, Y') }}
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="text-muted">{{ $invitation->invited_at->format('h:i A') }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <span class="badge badge-soft-{{ $statusColors[$invitation->status] }} p-1">
                                                                {{ strtoupper($invitation->status) }}
                                                            </span>
                                                        </h5>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="text-muted">{{ $statusTexts[$invitation->status] }}</span>
                                                            @if($invitation->responded_at)
                                                                <br>
                                                                <small>Responded: {{ $invitation->responded_at->format('M d, Y') }}</small>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button type="button" class="btn btn-sm view-invitation-btn" data-invitation-id="{{ $invitation->id }}">
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
    
    {{-- INVITATION DETAILS MODAL --}}
    <div class="modal fade" id="invitationDetailsModal" tabindex="-1" aria-labelledby="invitationDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invitationDetailsModalLabel">Invitation Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="invitationDetailsContent">
                    <!-- Content loaded via AJAX -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading invitation details...</p>
                    </div>
                </div>
                <div class="modal-footer" id="invitationModalFooter"></div>
            </div>
        </div>
    </div>

    {{-- REJECT INVITATION MODAL --}}
    <div class="modal fade" id="rejectInvitationModal" tabindex="-1" aria-labelledby="rejectInvitationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="rejectInvitationModalLabel">Decline Invitation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectInvitationForm">
                    @csrf
                    <input type="hidden" name="invitation_id" id="rejectInvitationId">
                    
                    <div class="modal-body">
                        <p class="mb-4">You are about to decline the invitation from <strong id="rejectStudioName">[Studio Name]</strong>.</p>
                        
                        <div class="mb-4">
                            <label for="rejection_reason" class="form-label">Reason for Declining (Optional)</label>
                            <textarea name="rejection_reason" 
                                      id="rejection_reason" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Optional: Please provide a reason for declining this invitation..."></textarea>
                            <div class="form-text mt-2">
                                This will be sent to the studio owner.
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="rejectInvitationBtn">Decline Invitation</button>
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
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            let currentInvitationId = null;
            let currentStudioName = null;

            // Function to show alert
            function showAlert(type, message) {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('#alertContainer').html(alertHtml);
                
                // Auto dismiss after 5 seconds
                setTimeout(() => {
                    $('.alert').alert('close');
                }, 5000);
            }

            // View invitation details
            $(document).on('click', '.view-invitation-btn', function() {
                const invitationId = $(this).data('invitation-id');
                
                // Show loading state
                $('#invitationDetailsContent').html(`
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading invitation details...</p>
                    </div>
                `);
                
                // Clear previous footer buttons
                $('#invitationModalFooter').html('<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>');
                
                $('#invitationDetailsModal').modal('show');
                
                // Load invitation details via AJAX
                $.ajax({
                    url: '{{ route("freelancer.invitation.details", ":id") }}'.replace(':id', invitationId),
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const invitation = response.data;
                            
                            const detailsHtml = `
                                <div class="container-fluid">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary fw-semibold mb-3">Invitation Details</h5>
                                            <div class="mb-4">
                                                <h6 class="fw-semibold mb-2">Studio Information</h6>
                                                <div class="d-flex align-items-center mb-3">
                                                    ${invitation.studio.studio_logo ? 
                                                        `<img src="/storage/${invitation.studio.studio_logo}" 
                                                            class="rounded-circle me-3" 
                                                            style="width: 60px; height: 60px; object-fit: cover;" 
                                                            alt="${invitation.studio.studio_name}">` :
                                                        `<div class="rounded-circle bg-light-primary d-flex align-items-center justify-content-center me-3" 
                                                            style="width: 60px; height: 60px;">
                                                            <i data-lucide="building" class="fs-20 text-primary"></i>
                                                        </div>`
                                                    }
                                                    <div>
                                                        <h5 class="mb-1 fw-bold">${invitation.studio.studio_name}</h5>
                                                        <p class="text-muted mb-0">
                                                            <i class="ti ti-map-pin me-1"></i>
                                                            ${invitation.studio.location ? invitation.studio.location.municipality + ', ' + invitation.studio.location.province : 'Location not specified'}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <h6 class="fw-semibold mb-2">Invited By</h6>
                                                <div class="d-flex align-items-center mb-3">
                                                    ${invitation.inviter_profile_picture ? 
                                                        `<img src="/storage/${invitation.inviter_profile_picture}" 
                                                            class="rounded-circle me-3" 
                                                            style="width: 60px; height: 60px; object-fit: cover;" 
                                                            alt="${invitation.inviter_name}">` :
                                                        `<div class="rounded-circle bg-light-secondary d-flex align-items-center justify-content-center me-3" 
                                                            style="width: 60px; height: 60px;">
                                                            <i data-lucide="user" class="fs-20 text-secondary"></i>
                                                        </div>`
                                                    }
                                                    <div>
                                                        <h5 class="mb-1 fw-bold">${invitation.inviter_name}</h5>
                                                        <p class="text-muted mb-0">
                                                            <i class="ti ti-mail me-1"></i>
                                                            ${invitation.inviter_email}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                                    <h6 class="fw-semibold mb-2">Invitation Message</h6>
                                                    <div class="card bg-light">
                                                        <div class="card-body">
                                                            <p class="mb-0">${invitation.invitation_message}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <h6 class="fw-semibold mb-2">Invitation Status</h6>
                                                            <p>
                                                                <span class="badge badge-soft-${invitation.status === 'pending' ? 'warning' : invitation.status === 'approved' ? 'success' : 'danger'} p-1">
                                                                    ${invitation.status.toUpperCase()}
                                                                </span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <h6 class="fw-semibold mb-2">Invitation Date</h6>
                                                            <p class="mb-0">
                                                                ${new Date(invitation.invited_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}
                                                                <br>
                                                                <small class="text-muted">${new Date(invitation.invited_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}</small>
                                                            </p>
                                                        </div>
                                                        ${invitation.responded_at ? `
                                                            <div class="col-12">
                                                                <h6 class="fw-semibold mb-2">Response Date</h6>
                                                                <p class="mb-0">
                                                                    ${new Date(invitation.responded_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}
                                                                    <br>
                                                                    <small class="text-muted">${new Date(invitation.responded_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}</small>
                                                                </p>
                                                            </div>
                                                        ` : ''}
                                                    </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            $('#invitationDetailsContent').html(detailsHtml);
                            
                            // Add Accept button to modal footer if invitation is pending
                            if (invitation.status === 'pending') {
                                const footerHtml = `
                                    <button type="button" class="btn btn-soft-danger me-2 reject-invitation-modal-btn" data-invitation-id="${invitationId}" data-studio-name="${invitation.studio.studio_name}">
                                        Decline
                                    </button>
                                    <button type="button" class="btn btn-primary accept-invitation-modal-btn" data-invitation-id="${invitationId}" data-studio-name="${invitation.studio.studio_name}">
                                        Accept Invitation
                                    </button>
                                `;
                                $('#invitationModalFooter').html(footerHtml);
                            } else {
                                $('#invitationModalFooter').html('<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>');
                            }
                            
                            // Initialize Lucide icons
                            if (typeof lucide !== 'undefined') {
                                lucide.createIcons();
                            }
                        } else {
                            $('#invitationDetailsContent').html(`
                                <div class="text-center py-5">
                                    <i class="ti ti-alert-circle fs-48 text-danger mb-3"></i>
                                    <h5>Error Loading Details</h5>
                                    <p class="text-muted">${response.message}</p>
                                </div>
                            `);
                        }
                    },
                    error: function(xhr) {
                        $('#invitationDetailsContent').html(`
                            <div class="text-center py-5">
                                <i class="ti ti-alert-circle fs-48 text-danger mb-3"></i>
                                <h5>Error Loading Details</h5>
                                <p class="text-muted">Unable to load invitation details. Please try again.</p>
                            </div>
                        `);
                    }
                });
            });

            // Accept invitation from modal
            $(document).on('click', '.accept-invitation-modal-btn', function() {
                const invitationId = $(this).data('invitation-id');
                const studioName = $(this).data('studio-name');
                
                Swal.fire({
                    icon: 'question',
                    title: 'Accept Invitation?',
                    html: `<div class="text-center">
                        <i class="ti ti-check-circle fs-48 text-primary mb-3"></i>
                        <p class="text-muted">Are you sure you want to accept the invitation from <strong>${studioName}</strong>?</p>
                        <p class="text-muted small">You will become a member of this studio.</p>
                    </div>`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Accept',
                    confirmButtonColor: '#3475db',
                    cancelButtonText: 'Cancel',
                    cancelButtonColor: '#6C757D',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("freelancer.invitation.accept", ":id") }}'.replace(':id', invitationId),
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#invitationDetailsModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Invitation Accepted!',
                                        html: `<div class="text-center">
                                            <i class="ti ti-check-circle fs-48 text-primary mb-3"></i>
                                            <p class="text-muted">You have successfully accepted the invitation from <strong>${studioName}</strong>.</p>
                                            <p class="text-muted small">You are now a member of this studio.</p>
                                        </div>`,
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Operation Failed',
                                    html: `<div class="text-center">
                                        <i class="ti ti-alert-circle fs-48 text-danger mb-3"></i>
                                        <h5 class="fw-bold">Operation Failed</h5>
                                        <p class="text-muted">${xhr.responseJSON?.message || 'Please try again.'}</p>
                                    </div>`,
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#DC3545',
                                });
                            }
                        });
                    }
                });
            });

            // Decline invitation from modal
            $(document).on('click', '.reject-invitation-modal-btn', function() {
                currentInvitationId = $(this).data('invitation-id');
                currentStudioName = $(this).data('studio-name');
                
                $('#rejectInvitationId').val(currentInvitationId);
                $('#rejectStudioName').text(currentStudioName);
                
                // Clear previous input
                $('#rejection_reason').val('');
                
                // Close details modal and open reject modal
                $('#invitationDetailsModal').modal('hide');
                $('#rejectInvitationModal').modal('show');
            });

            // Open reject invitation modal
            $(document).on('click', '.reject-invitation-btn', function() {
                currentInvitationId = $(this).data('invitation-id');
                currentStudioName = $(this).data('studio-name');
                
                $('#rejectInvitationId').val(currentInvitationId);
                $('#rejectStudioName').text(currentStudioName);
                
                // Clear previous input
                $('#rejection_reason').val('');
                
                $('#rejectInvitationModal').modal('show');
            });

            // Handle reject invitation form submission
            $('#rejectInvitationForm').on('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = $('#rejectInvitationBtn');
                const originalText = submitBtn.html();
                
                // Disable button and show loading
                submitBtn.prop('disabled', true);
                submitBtn.html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Declining...
                `);
                
                $.ajax({
                    url: '{{ route("freelancer.invitation.reject", ":id") }}'.replace(':id', currentInvitationId),
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            // Close modal
                            $('#rejectInvitationModal').modal('hide');
                            
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Invitation Declined',
                                html: `<div class="text-center">
                                    <i class="ti ti-check-circle fs-48 text-primary mb-3"></i>
                                    <p class="text-muted">Invitation from <strong>${currentStudioName}</strong> has been declined.</p>
                                </div>`,
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            showAlert('danger', 'Invitation not found or already responded.');
                        } else {
                            showAlert('danger', 'Failed to decline invitation. Please try again.');
                        }
                    },
                    complete: function() {
                        // Re-enable button
                        submitBtn.prop('disabled', false);
                        submitBtn.html(originalText);
                    }
                });
            });

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection