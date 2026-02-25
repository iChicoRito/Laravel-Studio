@extends('layouts.client.app')
@section('title', 'My Bookings')

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    {{-- TABLE --}}
                    <div data-table data-table-rows-per-page="10" class="card">
                        <div class="card-header">
                            <h4 class="card-title">List of My Bookings</h4>
                        </div>

                        <div class="card-header border-light justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="app-search">
                                    <input data-table-search type="search" class="form-control" placeholder="Search...">
                                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-select table-hover table-bordered w-100 mb-0">
                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                    <tr class="text-uppercase fs-xxs">
                                        <th data-table-sort>Booking ID</th>
                                        <th data-table-sort>Provider</th>
                                        <th data-table-sort>Category</th>
                                        <th data-table-sort>Package</th>
                                        <th data-table-sort>Event Date</th>
                                        <th data-table-sort>Status</th>
                                        <th data-table-sort>Payment</th>
                                        <th data-table-sort>Total Amount</th>
                                        <th class="text-center" style="width: 1%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr data-booking-id="{{ $booking->id }}">
                                            <td>
                                                <span class="fw-medium">{{ $booking->booking_reference }}</span>
                                                <small class="text-muted d-block">{{ ucfirst($booking->booking_type) }}</small>
                                            </td>
                                            <td>
                                                @if($booking->booking_type === 'studio')
                                                    {{ $booking->provider->studio_name ?? ($booking->provider->studio_name ?? 'Studio') }}
                                                @else
                                                    {{ $booking->provider->brand_name ?? ($booking->provider->brand_name ?? 'Freelancer') }}
                                                @endif
                                            </td>
                                            <td>{{ $booking->category->category_name ?? 'N/A' }}</td>
                                            <td>
                                                @if($booking->packages->count() > 0)
                                                    {{ $booking->packages->first()->package_name }}
                                                    <small class="text-muted d-block">₱{{ number_format($booking->packages->first()->package_price, 2) }}</small>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <p class="mb-1">{{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}</p>
                                                        <p class="mb-0 fs-xxs">
                                                            <span class="text-muted">{{ $booking->start_time }} - {{ $booking->end_time }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $statusBadge = [
                                                        'pending' => 'badge-soft-warning',
                                                        'confirmed' => 'badge-soft-success',
                                                        'in_progress' => 'badge-soft-info',
                                                        'completed' => 'badge-soft-secondary',
                                                        'cancelled' => 'badge-soft-danger'
                                                    ][$booking->status] ?? 'badge-soft-secondary';
                                                @endphp
                                                <span class="badge {{ $statusBadge }} fs-8 px-2 w-100 text-uppercase">{{ str_replace('_', ' ', $booking->status) }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $paymentBadge = [
                                                        'pending' => 'badge-soft-warning',
                                                        'partially_paid' => 'badge-soft-info',
                                                        'paid' => 'badge-soft-success',
                                                        'failed' => 'badge-soft-danger',
                                                        'refunded' => 'badge-soft-secondary',
                                                        'cancelled' => 'badge-soft-danger'
                                                    ][$booking->payment_status] ?? 'badge-soft-secondary';
                                                    
                                                    $totalPaid = $booking->payments->where('status', 'succeeded')->sum('amount');
                                                    $paymentProgress = $booking->total_amount > 0 ? round(($totalPaid / $booking->total_amount) * 100) : 0;
                                                @endphp
                                                <span class="badge {{ $paymentBadge }} fs-8 px-2 w-100 text-uppercase">{{ str_replace('_', ' ', $booking->payment_status) }}</span>
                                                <small class="text-muted d-block mt-1 text-center">
                                                    ₱{{ number_format($totalPaid, 2) }} / ₱{{ number_format($booking->total_amount, 2) }}
                                                </small>
                                                @if($booking->payment_status === 'partially_paid')
                                                <div class="progress mt-1" style="height: 3px;">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $paymentProgress }}%;" 
                                                        aria-valuenow="{{ $paymentProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-semibold">₱{{ number_format($booking->total_amount, 2) }}</span>
                                                <small class="text-muted d-block">
                                                    @if($booking->payment_type === 'downpayment')
                                                        30% downpayment
                                                    @else
                                                        Full payment
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm view-booking-btn" 
                                                            data-booking-id="{{ $booking->id }}" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#bookingModal"
                                                            title="View Details">
                                                        <i class="ti ti-eye fs-lg"></i>
                                                    </button>
                                                    
                                                    <!-- Pay Balance Button - Show for confirmed/in_progress bookings that are partially paid -->
                                                    @if(in_array($booking->status, ['confirmed', 'in_progress']) && in_array($booking->payment_status, ['pending', 'partially_paid']))
                                                        @php
                                                            $totalPaid = $booking->payments->where('status', 'succeeded')->sum('amount');
                                                            $hasRemaining = ($booking->total_amount - $totalPaid) > 0;
                                                        @endphp
                                                        @if($hasRemaining)
                                                        <button class="btn btn-sm pay-balance-btn" 
                                                                data-booking-id="{{ $booking->id }}"
                                                                data-booking-reference="{{ $booking->booking_reference }}"
                                                                title="Pay Remaining Balance">
                                                            <i class="ti ti-credit-card fs-lg"></i>
                                                        </button>
                                                        @endif
                                                    @endif
                                                    
                                                    @if($booking->status === 'pending')
                                                    <button class="btn btn-sm cancel-booking-btn" 
                                                            data-booking-id="{{ $booking->id }}"
                                                            data-booking-reference="{{ $booking->booking_reference }}"
                                                            title="Cancel Booking">
                                                        <i class="ti ti-x fs-lg"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i data-lucide="calendar-x" class="fs-20 mb-2"></i>
                                                    <p class="mb-0">No current bookings found</p>
                                                    <small class="mt-1">You don't have any active bookings at the moment.</small>
                                                    <div class="mt-3">
                                                        <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-sm">
                                                            <i class="ti ti-search me-1"></i> Browse Services
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div data-table-pagination-info="bookings"></div>
                                <div data-table-pagination></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- BOOKING DETAILS MODAL --}}
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="bookingModalLabel">
                        Booking Details - <span id="bookingReference">Loading...</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="bookingModalBody">
                        <div class="text-center py-5">
                            <div class="loading-spinner" style="width: 3rem; height: 3rem; margin: 0 auto;"></div>
                            <p class="mt-3">Loading booking details...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- BALANCE PAYMENT MODAL --}}
    <div class="modal fade" id="balancePaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        <i class="ti ti-credit-card me-2"></i>Pay Remaining Balance
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="balancePaymentModalBody">
                        <div class="text-center py-4">
                            <div class="loading-spinner" style="width: 2.5rem; height: 2.5rem; margin: 0 auto;"></div>
                            <p class="mt-3 text-muted">Loading payment details...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="proceedBalancePayment" style="background-color: #3475db; border-color: #3475db;">
                        <i class="ti ti-credit-card me-1"></i> Proceed to Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            let currentBookingId = null;
            
            // View booking details
            $(document).on('click', '.view-booking-btn', function() {
                currentBookingId = $(this).data('booking-id');
                loadBookingDetails(currentBookingId);
            });

            // Cancel booking
            $(document).on('click', '.cancel-booking-btn', function() {
                const bookingId = $(this).data('booking-id');
                const bookingRef = $(this).data('booking-reference');
                
                Swal.fire({
                    title: 'Cancel Booking',
                    html: `<p>Are you sure you want to cancel booking <strong>${bookingRef}</strong>?</p>
                          <p class="text-danger small">Note: Bookings can only be cancelled at least 24 hours before the event date.</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, cancel booking',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        cancelBooking(bookingId);
                    }
                });
            });

            // Pay Balance button click handler
            $(document).on('click', '.pay-balance-btn', function() {
                const bookingId = $(this).data('booking-id');
                const bookingRef = $(this).data('booking-reference');
                
                // Load payment details and show modal
                loadPaymentDetailsForModal(bookingId, bookingRef);
            });

            // Load payment details for modal
            function loadPaymentDetailsForModal(bookingId, bookingRef) {
                $.ajax({
                    url: '{{ route("client.booking.payment.details", ":id") }}'.replace(':id', bookingId),
                    type: 'GET',
                    beforeSend: function() {
                        // Show loading state in modal
                        $('#balancePaymentModalBody').html(`
                            <div class="text-center py-4">
                                <div class="loading-spinner" style="width: 2.5rem; height: 2.5rem; margin: 0 auto;"></div>
                                <p class="mt-3 text-muted">Loading payment details...</p>
                            </div>
                        `);
                        
                        // Disable proceed button
                        $('#proceedBalancePayment').prop('disabled', true);
                        
                        // Show modal with loading
                        $('#balancePaymentModal').modal('show');
                    },
                    success: function(response) {
                        if (response.success) {
                            renderBalancePaymentModal(response, bookingRef);
                        } else {
                            // Hide modal and show error
                            $('#balancePaymentModal').modal('hide');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#3475db'
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#balancePaymentModal').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load payment details. Please try again.',
                            confirmButtonColor: '#3475db'
                        });
                    }
                });
            }

            // Render balance payment modal content
            function renderBalancePaymentModal(data, bookingRef) {
                const booking = data.booking;
                const remainingBalance = parseFloat(booking.remaining_balance).toFixed(2);
                const bookingId = booking.id;
                
                let modalContent = `
                    <div class="text-start">
                        <div class="alert alert-info mb-3 d-flex align-items-center">
                            <i class="ti ti-info-circle me-2 fs-16"></i>
                            <div>
                                <strong>Booking:</strong> ${bookingRef}<br>
                                <strong>Status:</strong> <span class="badge bg-info-subtle text-info">${booking.booking_status.replace('_', ' ').toUpperCase()}</span>
                            </div>
                        </div>
                        
                        <div class="bg-light p-3 rounded mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Amount:</span>
                                <span class="fw-semibold">₱${parseFloat(booking.total_amount).toFixed(2)}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Amount Paid:</span>
                                <span class="fw-medium text-success">₱${parseFloat(booking.total_paid).toFixed(2)}</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="fw-semibold">Remaining Balance:</span>
                                <span class="fw-bold text-danger">₱${remainingBalance}</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-medium">Payment Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" id="modalBalanceAmount" 
                                    value="${remainingBalance}" min="1" max="${remainingBalance}" step="0.01">
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="ti ti-info-circle me-1"></i>You can pay the full remaining balance or a partial amount.
                            </small>
                        </div>
                `;
                
                if (data.has_pending_payment) {
                    modalContent += `
                        <div class="alert alert-warning mt-3">
                            <i class="ti ti-clock me-2"></i>
                            You have a pending payment for this booking. Please complete it or wait for it to expire.
                        </div>
                    `;
                }
                
                modalContent += `</div>`;
                
                $('#balancePaymentModalBody').html(modalContent);
                
                // Store booking data for proceed button
                $('#proceedBalancePayment').data('booking-id', bookingId);
                $('#proceedBalancePayment').data('booking-ref', bookingRef);
                $('#proceedBalancePayment').data('remaining-balance', remainingBalance);
                
                // Enable proceed button
                $('#proceedBalancePayment').prop('disabled', data.has_pending_payment);
                
                // Reinitialize icons
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }

            // Proceed button click handler
            $('#proceedBalancePayment').on('click', function() {
                const bookingId = $(this).data('booking-id');
                const bookingRef = $(this).data('booking-ref');
                const remainingBalance = $(this).data('remaining-balance');
                const amount = $('#modalBalanceAmount').val();
                
                // Validate amount
                if (!amount || amount <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please enter a valid amount',
                        confirmButtonColor: '#3475db'
                    });
                    return;
                }
                
                if (parseFloat(amount) > parseFloat(remainingBalance)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Amount cannot exceed remaining balance',
                        confirmButtonColor: '#3475db'
                    });
                    return;
                }
                
                // Close modal and proceed with payment
                $('#balancePaymentModal').modal('hide');
                initializeBalancePayment(bookingId, amount);
            });

            // Load payment details for balance payment
            function loadPaymentDetails(bookingId, bookingRef) {
                $.ajax({
                    url: '{{ route("client.booking.payment.details", ":id") }}'.replace(':id', bookingId),
                    type: 'GET',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Loading...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        Swal.close();
                        
                        if (response.success) {
                            showBalancePaymentModal(response, bookingRef);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#3475db'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load payment details. Please try again.',
                            confirmButtonColor: '#3475db'
                        });
                    }
                });
            }

            // Show balance payment modal
            function showBalancePaymentModal(data, bookingRef) {
                const booking = data.booking;
                const remainingBalance = parseFloat(booking.remaining_balance).toFixed(2);
                const bookingId = booking.id; // Store booking ID
                
                Swal.fire({
                    title: 'Pay Remaining Balance',
                    html: `
                        <div class="text-start">
                            <div class="alert alert-info mb-3">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Booking:</strong> ${bookingRef}<br>
                                <strong>Status:</strong> ${booking.booking_status.replace('_', ' ').toUpperCase()}
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Amount:</span>
                                    <span class="fw-semibold">₱${parseFloat(booking.total_amount).toFixed(2)}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Amount Paid:</span>
                                    <span class="fw-medium text-success">₱${parseFloat(booking.total_paid).toFixed(2)}</span>
                                </div>
                                <div class="d-flex justify-content-between pt-2 border-top">
                                    <span class="fw-semibold">Remaining Balance:</span>
                                    <span class="fw-bold text-danger">₱${remainingBalance}</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium">Payment Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" class="form-control" id="balanceAmount" 
                                        value="${remainingBalance}" min="1" max="${remainingBalance}" step="0.01">
                                </div>
                                <small class="text-muted">You can pay the full remaining balance or a partial amount.</small>
                            </div>
                            
                            ${data.has_pending_payment ? `
                                <div class="alert alert-warning">
                                    <i class="ti ti-clock me-2"></i>
                                    You have a pending payment for this booking. Please complete it or wait for it to expire.
                                </div>
                            ` : ''}
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Proceed to Payment',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3475db',
                    cancelButtonColor: '#6c757d',
                    preConfirm: () => {
                        const amount = $('#balanceAmount').val();
                        
                        if (!amount || amount <= 0) {
                            Swal.showValidationMessage('Please enter a valid amount');
                            return false;
                        }
                        
                        if (parseFloat(amount) > parseFloat(remainingBalance)) {
                            Swal.showValidationMessage('Amount cannot exceed remaining balance');
                            return false;
                        }
                        
                        return { 
                            amount: amount,
                            bookingId: bookingId 
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Pass both bookingId and amount
                        initializeBalancePayment(result.value.bookingId, result.value.amount);
                    }
                });
            }

            // Initialize balance payment
            function initializeBalancePayment(bookingId, amount) {
                $.ajax({
                    url: '{{ route("client.booking.balance.payment", ":id") }}'.replace(':id', bookingId),
                    type: 'POST',
                    data: {
                        amount: amount,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            proceedWithBalancePayment(bookingId, response.payment.id, response.booking_reference, response.amount);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#3475db'
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Failed to initialize payment. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message,
                            confirmButtonColor: '#3475db'
                        });
                    }
                });
            }

            // Proceed with balance payment using existing payment method
            function proceedWithBalancePayment(bookingId, paymentId, bookingRef, amount) {
                $.ajax({
                    url: '{{ route("client.payments.initialize") }}',
                    type: 'POST',
                    data: {
                        booking_id: bookingId,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Redirecting to Payment...',
                            text: 'Please wait while we prepare your payment',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success && response.redirect_url) {
                            // Redirect to Stripe checkout
                            window.location.href = response.redirect_url;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Payment Failed',
                                text: response.message || 'Failed to initialize payment',
                                confirmButtonColor: '#3475db'
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Failed to initialize payment. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message,
                            confirmButtonColor: '#3475db'
                        });
                    }
                });
            }

            // Reset modal when hidden
            $('#balancePaymentModal').on('hidden.bs.modal', function () {
                $('#balancePaymentModalBody').html(`
                    <div class="text-center py-4">
                        <div class="loading-spinner" style="width: 2.5rem; height: 2.5rem; margin: 0 auto;"></div>
                        <p class="mt-3 text-muted">Loading payment details...</p>
                    </div>
                `);
                $('#proceedBalancePayment').prop('disabled', true);
                $('#proceedBalancePayment').removeData('booking-id');
                $('#proceedBalancePayment').removeData('booking-ref');
                $('#proceedBalancePayment').removeData('remaining-balance');
            });

            // Load booking details
            function loadBookingDetails(bookingId) {
                $.ajax({
                    url: '{{ route("client.booking.details", ":id") }}'.replace(':id', bookingId),
                    type: 'GET',
                    beforeSend: function() {
                        $('#bookingModalBody').html(`
                            <div class="text-center py-5">
                                <div class="loading-spinner" style="width: 3rem; height: 3rem; margin: 0 auto;"></div>
                                <p class="mt-3">Loading booking details...</p>
                            </div>
                        `);
                    },
                    success: function(response) {
                        if (response.success) {
                            renderBookingDetails(response);
                        } else {
                            showError('Error loading booking details: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        showError('Error loading booking details. Please try again.');
                    }
                });
            }

            // Render booking details
            function renderBookingDetails(data) {
                const booking = data.booking;
                const provider = data.provider;
                const providerType = data.provider_type;
                const category = data.category;
                const packages = data.packages;
                const payments = data.payments;
                const assignedPhotographers = data.assignedPhotographers;
                const paymentSummary = data.payment_summary;

                let packagesHtml = '';
                if (packages && packages.length > 0) {
                    packages.forEach(pkg => {
                        let inclusions = '';
                        if (pkg.package_inclusions && Array.isArray(pkg.package_inclusions)) {
                            inclusions = pkg.package_inclusions.map(inc => `<li>${inc}</li>`).join('');
                        }
                        
                        packagesHtml += `
                            <div class="card border mb-3">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-2">${pkg.package_name}</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Price:</span>
                                        <span class="fw-semibold">₱${parseFloat(pkg.package_price).toFixed(2)}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Duration:</span>
                                        <span>${pkg.duration} hours</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Photos:</span>
                                        <span>${pkg.maximum_edited_photos} edited photos</span>
                                    </div>
                                    ${pkg.coverage_scope ? `
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Coverage:</span>
                                            <span>${pkg.coverage_scope}</span>
                                        </div>
                                    ` : ''}
                                    ${inclusions ? `
                                        <div class="mt-3">
                                            <small class="text-muted d-block mb-1">Inclusions:</small>
                                            <ul class="mb-0 ps-3">${inclusions}</ul>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    });
                }

                let assignedPhotographersHtml = '';
                if (assignedPhotographers && assignedPhotographers.length > 0) {
                    assignedPhotographers.forEach(assignment => {
                        const photographer = assignment.photographer;
                        const studioPhotographer = assignment.studio_photographer;
                        const initials = (photographer.first_name.charAt(0) + photographer.last_name.charAt(0)).toUpperCase();
                        
                        assignedPhotographersHtml += `
                            <div class="d-flex align-items-center mb-2 p-2 border rounded">
                                <div class="avatar-xl me-2">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle me-2">${initials}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">${photographer.first_name} ${photographer.last_name}</h6>
                                    <small class="text-muted">${studioPhotographer ? studioPhotographer.position : 'Photographer'}</small>
                                    ${studioPhotographer?.specialization ? `<small class="d-block text-muted">Specialization: ${studioPhotographer.specialization}</small>` : ''}
                                </div>
                                <span class="badge ${getStatusBadgeClass(assignment.status)}">${assignment.status}</span>
                            </div>
                        `;
                    });
                } else {
                    assignedPhotographersHtml = `
                        <div class="text-center py-3 border rounded">
                            <i data-lucide="users" class="fs-20 text-muted mb-2"></i>
                            <p class="mb-0 text-muted">No photographers assigned yet</p>
                        </div>
                    `;
                }

                let paymentHistoryHtml = '';
                if (payments && payments.length > 0) {
                    payments.forEach(payment => {
                        paymentHistoryHtml += `
                            <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                <div>
                                    <span class="fw-medium">${payment.payment_reference}</span>
                                    <small class="d-block text-muted">${payment.payment_method || 'Card'}</small>
                                </div>
                                <div class="text-end">
                                    <span class="fw-semibold">₱${parseFloat(payment.amount).toFixed(2)}</span>
                                    <small class="d-block ${payment.status === 'succeeded' ? 'text-success' : 'text-warning'}">
                                        ${payment.status}
                                    </small>
                                    ${payment.paid_at ? `<small class="d-block text-muted">${new Date(payment.paid_at).toLocaleDateString()}</small>` : ''}
                                </div>
                            </div>
                        `;
                    });
                }

                const modalContent = `
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-none mb-4">
                                <div class="card-body p-0">
                                    <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                        Booking Information
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="receipt-text" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Booking Reference</label>
                                                    <p class="mb-0 fw-semibold">${booking.booking_reference}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="calendar" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Event Date & Time</label>
                                                    <p class="mb-0 fw-medium">${new Date(booking.event_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                                                    <small class="text-muted">${booking.start_time} - ${booking.end_time}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="map-pin" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Event Location</label>
                                                    <p class="mb-0 fw-medium">${booking.location_type === 'in-studio' ? 'In-Studio' : 'On-Location'}</p>
                                                    ${booking.venue_name || booking.street ? `
                                                        <small class="text-muted">
                                                            ${booking.venue_name ? booking.venue_name + ', ' : ''}
                                                            ${booking.street ? booking.street + ', ' : ''}
                                                            ${booking.barangay ? 'Brgy. ' + booking.barangay + ', ' : ''}
                                                            ${booking.city ? booking.city + ', ' : ''}
                                                            ${booking.province ? booking.province : ''}
                                                        </small>
                                                    ` : ''}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light-primary rounded-circle p-2">
                                                        <i data-lucide="layers" class="fs-20 text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <label class="text-muted small mb-1">Service Category</label>
                                                    <p class="mb-0 fw-medium">${category ? category.category_name : 'N/A'}</p>
                                                </div>
                                            </div>
                                        </div>

                                        ${booking.special_requests ? `
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light-primary rounded-circle p-2">
                                                            <i data-lucide="message-square" class="fs-20 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <label class="text-muted small mb-1">Special Requests</label>
                                                        <p class="mb-0 fw-medium">${booking.special_requests}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-none mb-4">
                                <div class="card-body p-0">
                                    <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                        Service Provider
                                    </h6>
                                    <div class="d-flex align-items-center p-3 border rounded">
                                        ${provider ? `
                                            <div class="avatar-xl me-3">
                                                <img src="${provider && (providerType === 'studio' ? (provider.studio_logo ? '{{ asset("storage/") }}/' + provider.studio_logo : '{{ asset("assets/images/sellers/7.png") }}') : (provider.brand_logo ? '{{ asset("storage/") }}/' + provider.brand_logo : '{{ asset("assets/images/sellers/3.png") }}')) || '{{ asset("assets/images/sellers/7.png") }}'}" 
                                                     class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" alt="Provider Logo">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold">
                                                    ${providerType === 'studio' ? provider.studio_name : provider.brand_name}
                                                </h6>
                                                <small class="text-muted">
                                                    ${provider.contact_number ? provider.contact_number + ' • ' : ''}
                                                    ${provider.contact_email || provider.studio_email || ''}
                                                </small>
                                            </div>
                                        ` : `
                                            <div class="text-center w-100">
                                                <small class="text-muted">Provider information not available</small>
                                            </div>
                                        `}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-none mb-4">
                                <div class="card-body p-0">
                                    <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                        Payment Information
                                    </h6>
                                    <div class="bg-light p-3 rounded mb-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Total Amount:</span>
                                            <span class="fw-semibold">₱${parseFloat(paymentSummary.total_amount).toFixed(2)}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Down Payment:</span>
                                            <span class="fw-medium">₱${parseFloat(paymentSummary.down_payment).toFixed(2)}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Amount Paid:</span>
                                            <span class="fw-medium text-success">₱${parseFloat(paymentSummary.total_paid).toFixed(2)}</span>
                                        </div>
                                        <div class="d-flex justify-content-between pt-2 border-top">
                                            <span class="fw-semibold">Remaining Balance:</span>
                                            <span class="fw-bold ${paymentSummary.remaining_balance > 0 ? 'text-danger' : 'text-success'}">
                                                ₱${parseFloat(paymentSummary.remaining_balance).toFixed(2)}
                                            </span>
                                        </div>
                                    </div>

                                    ${paymentHistoryHtml ? `
                                        <div class="mt-3">
                                            <h6 class="fw-semibold mb-2">Payment History</h6>
                                            ${paymentHistoryHtml}
                                        </div>
                                    ` : ''}
                                </div>
                            </div>

                            <div class="card border-0 shadow-none mb-4">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="card-title mb-0 fw-semibold text-uppercase small text-primary">
                                            Packages
                                        </h6>
                                    </div>
                                    ${packagesHtml || '<p class="text-muted">No package information available</p>'}
                                </div>
                            </div>

                            <div class="card border-0 shadow-none">
                                <div class="card-body p-0">
                                    <h6 class="card-title mb-3 fw-semibold text-uppercase small text-primary">
                                        Assigned Photographers
                                    </h6>
                                    <div id="assignedPhotographersList">
                                        ${assignedPhotographersHtml}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-light border">
                                <div class="d-flex align-items-center">
                                    <i data-lucide="info" class="fs-20 text-primary me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Booking Status: <span class="${getStatusTextClass(booking.status)}">${booking.status.replace('_', ' ').toUpperCase()}</span></h6>
                                        <p class="mb-0 small text-muted">
                                            Payment Status: <span class="${getPaymentStatusTextClass(booking.payment_status)}">${booking.payment_status.replace('_', ' ').toUpperCase()}</span> | 
                                            Payment Type: ${booking.payment_type === 'downpayment' ? '30% Down Payment' : 'Full Payment'}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#bookingReference').text(booking.booking_reference);
                $('#bookingModalBody').html(modalContent);
                loadIcons();
            }

            // Cancel booking function
            function cancelBooking(bookingId) {
                $.ajax({
                    url: '{{ route("client.booking.cancel", ":id") }}'.replace(':id', bookingId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Cancelling...',
                            text: 'Please wait while we process your cancellation',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Booking Cancelled',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Cancellation Failed',
                                text: response.message,
                                confirmButtonColor: '#3475db'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while cancelling the booking. Please try again.',
                            confirmButtonColor: '#3475db'
                        });
                    }
                });
            }

            // Helper functions
            function getStatusBadgeClass(status) {
                const badgeClasses = {
                    'assigned': 'badge-soft-info',
                    'confirmed': 'badge-soft-success',
                    'completed': 'badge-soft-secondary',
                    'cancelled': 'badge-soft-danger'
                };
                return badgeClasses[status] || 'badge-soft-secondary';
            }

            function getStatusTextClass(status) {
                const textClasses = {
                    'pending': 'text-warning',
                    'confirmed': 'text-success',
                    'in_progress': 'text-info',
                    'completed': 'text-secondary',
                    'cancelled': 'text-danger'
                };
                return textClasses[status] || 'text-secondary';
            }

            function getPaymentStatusTextClass(status) {
                const textClasses = {
                    'pending': 'text-warning',
                    'partially_paid': 'text-info',
                    'paid': 'text-success',
                    'failed': 'text-danger',
                    'refunded': 'text-secondary',
                    'cancelled': 'text-danger'
                };
                return textClasses[status] || 'text-secondary';
            }

            function showError(message) {
                $('#bookingModalBody').html(`
                    <div class="text-center py-5">
                        <i data-lucide="alert-circle" class="fs-20 text-danger mb-3"></i>
                        <p class="text-danger">${message}</p>
                        <button class="btn btn-sm btn-primary mt-2" onclick="loadBookingDetails(${currentBookingId})">
                            <i data-lucide="refresh-cw" class="me-1"></i> Retry
                        </button>
                    </div>
                `);
                loadIcons();
            }

            function loadIcons() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }

            // Initialize icons
            loadIcons();
        });
    </script>
@endsection