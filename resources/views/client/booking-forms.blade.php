@extends('layouts.client.app')
@section('title', 'Booking Form')

{{-- STYLES --}}
@section('styles')
    <style>
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .calendar-day {
            position: relative;
            text-align: center;
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .calendar-day:hover:not(.past):not(.unavailable) {
            background: #e7f1ff;
            border-color: #3475db;
        }
        
        .calendar-day.today {
            background: #3475db;
            color: white;
            border-color: #3475db;
        }
        
        .calendar-day.past {
            background: #f8f9fa;
            color: #adb5bd;
            cursor: not-allowed;
        }
        
        .calendar-day.unavailable {
            background: #fee;
            color: #dc3545;
            cursor: not-allowed;
        }
        
        .calendar-day.empty {
            background: transparent;
            border: none;
        }
        
        .availability-dot {
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }
        
        .availability-dot.available {
            background: #28a745;
        }
        
        .availability-dot.unavailable {
            background: #dc3545;
        }

        #locationType:disabled {
            background-color: #f8f9fa;
            opacity: 0.8;
            cursor: not-allowed;
        }

        .location-type-note {
            color: #6c757d;
            font-style: italic;
        }
    </style>
@endsection

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header card-title">
                            <h4 class="card-title">Booking Form</h4>
                            <p class="text-muted mb-0">Booking for
                                {{ $type === 'studio' ? $provider->studio_name : $provider->brand_name }}</p>
                        </div>
                        <div class="card-body">
                            <form id="bookingForm" class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" id="bookingType" value="{{ $type }}">
                                <input type="hidden" id="providerId" value="{{ $id }}">
                                <input type="hidden" id="operatingDays" value="{{ json_encode($operatingDays) }}">
                                @if($type === 'studio')
                                <input type="hidden" id="downpaymentPercentage" value="{{ $downpaymentPercentage }}">
                                @endif

                                {{-- CLIENT INFORMATION --}}
                                <h4 class="card-title text-primary mb-3">Client Information</h4>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="fullName"
                                                value="{{ $user->first_name . ' ' . $user->last_name }}"
                                                placeholder="Enter your full name" required>
                                            <div class="invalid-feedback">
                                                Please enter your full name.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Contact Number</label>
                                            <input type="tel" class="form-control" id="contactNumber"
                                                value="{{ $user->mobile_number }}" placeholder="Enter your contact number"
                                                required>
                                            <div class="invalid-feedback">
                                                Please enter a valid contact number.
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email"
                                                value="{{ $user->email }}" placeholder="Enter your email address" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid email address.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SERVICE AND PACKAGES SELECTION --}}
                                <h4 class="card-title text-primary mb-3">Service and Packages Selection</h4>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Service Category</label>
                                    <div class="form-select-wrapper">
                                        <select class="form-select" id="serviceCategory" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select a service category.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-medium">Select Package</label>
                                    <div id="packagesContainer">
                                        <div class="alert alert-warning">
                                            <i class="ti ti-warning-circle me-2"></i> Please select a category first to view available packages.
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mt-2">
                                        Please select a package.
                                    </div>
                                </div>

                                {{-- EVENT DATE & TIME --}}
                                <h4 class="card-title text-primary mb-3">Event Date & Time</h4>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Event Date</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="eventDate" name="event_date"
                                                    min="{{ date('Y-m-d') }}"
                                                    max="{{ date('Y-m-d', strtotime('+60 days')) }}"
                                                    placeholder="Select event date" required>
                                                <button class="btn btn-outline-primary" type="button" id="checkDateBtn">
                                                    <i class="ti ti-calendar me-1"></i> Check Availability
                                                </button>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please select a valid event date.
                                            </div>
                                            <small class="text-muted mt-1 d-block" id="closedDayNote" style="display:none !important;"></small>
                                            <small class="text-muted mt-1" id="dateAvailabilityStatus">
                                                <span id="dateStatusIcon" class="me-1"></span>
                                                <span id="dateStatusText">Select a date to check availability</span>
                                            </small>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Start Time</label>
                                            <input type="time" class="form-control" id="startTime" name="start_time"
                                                value="08:00" placeholder="Enter start time" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">End Time</label>
                                            <input type="time" class="form-control" id="endTime" name="end_time"
                                                value="18:00" placeholder="Enter end time" required>
                                        </div>
                                    </div>

                                    {{-- Calendar Modal --}}
                                    <div class="modal fade" id="calendarModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Select Available Date</h5>
                                                    <button type="button" class="btn btn-default btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="availabilityCalendar"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- PAYMENT TYPE --}}
                                <h4 class="card-title text-primary mb-3">Payment Type</h4>
                                <div class="mb-4">
                                    <div class="btn-group w-100" role="group" aria-label="Payment type selection">
                                        @if($type === 'studio')
                                            <input class="btn-check" type="radio" name="payment_type" id="payment_type_downpayment" value="downpayment" checked>
                                            <label class="btn btn-outline-primary" for="payment_type_downpayment">
                                                <i class="ti ti-percentage me-1"></i> {{ $downpaymentPercentage }}% Downpayment
                                            </label>
                                        @else
                                            {{-- For freelancer, default to 30% if no column exists --}}
                                            <input class="btn-check" type="radio" name="payment_type" id="payment_type_downpayment" value="downpayment" checked>
                                            <label class="btn btn-outline-primary" for="payment_type_downpayment">
                                                <i class="ti ti-percentage me-1"></i> 30% Downpayment
                                            </label>
                                        @endif
                                        
                                        <input class="btn-check" type="radio" name="payment_type" id="payment_type_full" value="full_payment">
                                        <label class="btn btn-outline-primary" for="payment_type_full">
                                            <i class="ti ti-discount-2 me-1"></i> Full Payment (5% OFF)
                                        </label>
                                    </div>
                                </div>

                                {{-- EVENT LOCATION --}}
                                <h4 class="card-title text-primary mb-3">Event Location</h4>
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Location Type</label>
                                            <select class="form-select" id="locationType" name="location_type" required>
                                                <option value="">Select Location Type</option>
                                                @if ($type === 'studio')
                                                    <option value="in-studio">In-Studio</option>
                                                @endif
                                                <option value="on-location">On-Location</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid location type.
                                            </div>
                                            <small class="text-muted location-type-note">
                                                <i class="ti ti-info-circle me-1"></i> Location type is automatically determined by your selected package.
                                            </small>
                                        </div>

                                        <div id="locationDetails" style="display: none;">
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Venue Name</label>
                                                <input type="text" class="form-control" id="venueName" name="venue_name" 
                                                    placeholder="Enter venue name (e.g., Hotel, Resort, Event Hall)">
                                            </div>
                                            
                                            <div class="col-12 mb-3">
                                                <label class="form-label">City/Municipality</label>
                                                <select class="form-select" id="city" name="city" required>
                                                    <option value="">Select City/Municipality</option>
                                                    @foreach($municipalities as $municipality)
                                                        <option value="{{ $municipality }}">{{ $municipality }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Barangay</label>
                                                <select class="form-select" id="barangay" name="barangay" required disabled>
                                                    <option value="">Select Barangay</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Street / Building / Unit No.</label>
                                                <input type="text" class="form-control" id="street" name="street" 
                                                    placeholder="Enter street name, building, unit number (optional)">
                                            </div>
                                            
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Province</label>
                                                <input type="text" class="form-control" id="province" name="province" 
                                                    value="Cavite" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SPECIAL REQUESTS --}}
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Special Requests / Notes</label>
                                    <textarea class="form-control" rows="3" id="specialRequests" name="special_requests"
                                        placeholder="Enter special requests or notes..."></textarea>
                                </div>

                                {{-- TERMS & CONDITIONS --}}
                                <div class="mb-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="termsCheck"
                                            name="terms_agree" required>
                                        <label class="form-check-label" for="termsCheck">
                                            I agree to the <a href="#" class="text-primary">Booking Terms and
                                                Conditions</a>
                                        </label>
                                        <div class="invalid-feedback">
                                            You must agree to the terms and conditions.
                                        </div>
                                    </div>
                                </div>

                                {{-- SUBMIT BUTTON --}}
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-primary w-100" id="submitBookingBtn">
                                            <span id="submitText">Proceed to Summary</span>
                                            <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none"
                                                role="status" aria-hidden="true"></span>
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

    {{-- BOOKING SUMMARY MODAL --}}
    <div class="modal fade" id="bookingSummaryModal" tabindex="-1" aria-labelledby="bookingSummaryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="bookingSummaryModalLabel">Booking Summary</h4>
                    <button type="button" class="btn btn-default btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- BOOKING SUMMARY --}}
                    <div class="mb-4">
                        <div class="mb-3">
                            <h5 class="text-primary mb-2">Client Information</h5>
                            <p class="text-muted small mb-1">Full Name:</p>
                            <p class="fw-medium mb-2" id="summaryFullName"></p>

                            <p class="text-muted small mb-1">Contact Number:</p>
                            <p class="fw-medium mb-2" id="summaryContactNumber"></p>

                            <p class="text-muted small mb-1">Email Address:</p>
                            <p class="fw-medium mb-2" id="summaryEmailAddress"></p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h5 class="text-primary mb-2">Booking Details</h5>
                            <p class="text-muted small mb-1">Selected Package:</p>
                            <p class="fw-medium mb-2" id="summaryPackage"></p>

                            <p class="text-muted small mb-1">Package Inclusions:</p>
                            <ul class="mb-2" id="summaryInclusions"></ul>

                            <p class="text-muted small mb-1">Event Date:</p>
                            <p class="fw-medium mb-2" id="summaryDate"></p>

                            <p class="text-muted small mb-1">Event Time:</p>
                            <p class="fw-medium mb-2" id="summaryTime"></p>

                            <p class="text-muted small mb-1">Location Type:</p>
                            <p class="fw-medium mb-2" id="summaryLocationType"></p>

                            <div id="summaryLocationDetails"></div>
                        </div>
                    </div>

                    <hr>

                    {{-- PRICE BREAKDOWN --}}
                    <div class="mb-3">
                        <h5 class="text-primary mb-2">Price Breakdown</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Package Price:</span>
                            <span class="fw-medium" id="packagePrice">₱0</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2" id="downPaymentRow">
                            <span id="downPaymentLabel">Down Payment (30%):</span>
                            <span class="fw-medium" id="downPayment">₱0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="remainingBalanceRow">
                            <span>Remaining Balance:</span>
                            <span class="fw-medium" id="remainingBalance">₱0</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold">Total Amount:</span>
                            <span class="fw-semibold h5 text-success" id="totalAmount">₱0</span>
                        </div>
                    </div>

                    {{-- NEXT STEP --}}
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary btn-lg" id="proceedToPaymentBtn">
                            <i class="ti ti-credit-card me-2"></i>Proceed to Payment
                        </button>
                    </div>

                    <p class="text-muted small text-center mt-3">
                        <i class="ti ti-info-circle me-1"></i>You'll review all details before payment
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- PAYMENT MODAL --}}
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Complete Payment</h5>
                    <button type="button" class="btn btn-default btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="paymentContainer">
                        {{-- Payment form will be loaded here --}}
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
            // Initialize variables
            let selectedPackageId = null;
            let bookingData = null;
            let bookingId = null;

            // ========== Operating Days Enforcement ==========
            const operatingDays = JSON.parse($('#operatingDays').val() || '[]');

            /**
             * Map day name to JS getDay() index (0 = Sunday, 6 = Saturday)
             */
            const dayNameToIndex = {
                'sunday': 0, 'monday': 1, 'tuesday': 2, 'wednesday': 3,
                'thursday': 4, 'friday': 5, 'saturday': 6
            };

            /**
             * Get array of operating day indices from operating days array
             */
            const operatingDayIndices = operatingDays
                .map(d => dayNameToIndex[d.toLowerCase()])
                .filter(d => d !== undefined);

            /**
             * Check if a date string falls on an operating day
             */
            function isOperatingDay(dateString) {
                if (!dateString) return false;
                const parts = dateString.split('-');
                // Use explicit constructor to avoid timezone shift
                const date = new Date(parts[0], parts[1] - 1, parts[2]);
                return operatingDayIndices.includes(date.getDay());
            }

            /**
             * Format operating days for readable display
             */
            function formatOperatingDays() {
                if (!operatingDays.length) return 'No operating schedule set';
                return operatingDays.map(d => d.charAt(0).toUpperCase() + d.slice(1)).join(', ');
            }

            // Debug function to check available categories and packages
            function debugFreelancerPackages() {
                const type = $('#bookingType').val();
                const providerId = $('#providerId').val();
                
                console.log('Debug Info:', {
                    type: type,
                    providerId: providerId,
                    categories: $('#serviceCategory').html()
                });
                
                if (type === 'freelancer') {
                    $.ajax({
                        url: '{{ route("client.bookings.packages") }}',
                        type: 'POST',
                        data: {
                            type: type,
                            provider_id: providerId,
                            category_id: 1,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Debug Package Response:', response);
                        }
                    });
                }
            }

            // Handle payment option selection
            $('input[name="payment_type"]').on('change', function() {
                const paymentType = $(this).val();
                
                if (selectedPackageId) {
                    const packageRadio = $(`.package-radio[value="${selectedPackageId}"]`);
                    if (packageRadio.length) {
                        const packageData = packageRadio.data('package');
                        getBookingSummaryWithPaymentType(packageData, paymentType);
                    }
                }
            });

            // Initialize the checked state on page load
            $('input[name="payment_type"]:checked').trigger('change');

            // Load packages when category is selected
            $('#serviceCategory').on('change', function() {
                // Reset location type when category changes
                $('#locationType').val('').prop('disabled', false);
                $('#locationType').closest('.col-12').find('.badge.badge-soft-info').remove();
                $('#locationDetails').hide();
                
                const categoryId = $(this).val();
                const type = $('#bookingType').val();
                const providerId = $('#providerId').val();
                
                if (!categoryId) {
                    $('#packagesContainer').html(`
                        <div class="alert alert-warning">
                            <i class="ti ti-warning-circle me-2"></i> Please select a category first to view available packages.
                        </div>
                    `);
                    return;
                }
                
                // Show loading
                $('#packagesContainer').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-2 text-muted">Loading packages...</span>
                    </div>
                `);
                
                $.ajax({
                    url: '{{ route("client.bookings.packages") }}',
                    type: 'POST',
                    data: {
                        type: type,
                        provider_id: providerId,
                        category_id: categoryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Packages response:', response);
                        
                        if (response.success && response.packages && response.packages.length > 0) {
                            let packagesHtml = '<div class="row g-3">';
                            
                            response.packages.forEach(function(package, index) {
                                // FIXED: Ensure package data is properly stringified for the data-package attribute
                                const packageJson = JSON.stringify(package)
                                    .replace(/"/g, '&quot;') // Escape quotes for HTML attribute
                                    .replace(/'/g, "&#39;"); // Escape single quotes
                                
                                const durationText = package.duration === 1 ? '1 Hour' : `${package.duration} Hours`;
                                const priceText = `₱${parseFloat(package.package_price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                                
                                // Parse inclusions safely
                                let inclusions = [];
                                if (package.package_inclusions) {
                                    try {
                                        if (typeof package.package_inclusions === 'string') {
                                            // Handle the specific format from your database
                                            let cleanedStr = package.package_inclusions;
                                            // Remove outer quotes if they exist
                                            if (cleanedStr.startsWith('"') && cleanedStr.endsWith('"')) {
                                                cleanedStr = cleanedStr.slice(1, -1);
                                            }
                                            // Split by comma if it's a comma-separated string
                                            if (cleanedStr.includes(',')) {
                                                inclusions = cleanedStr.split(',').map(item => item.trim());
                                            } else {
                                                // Try JSON parse
                                                try {
                                                    const parsed = JSON.parse(cleanedStr);
                                                    if (Array.isArray(parsed)) {
                                                        inclusions = parsed;
                                                    } else {
                                                        inclusions = [parsed];
                                                    }
                                                } catch (e) {
                                                    // If all else fails, use as single item
                                                    inclusions = [cleanedStr];
                                                }
                                            }
                                        } else if (Array.isArray(package.package_inclusions)) {
                                            inclusions = package.package_inclusions;
                                        }
                                    } catch (e) {
                                        console.warn('Error parsing inclusions:', e);
                                    }
                                }
                                
                                const isStudio = $('#bookingType').val() === 'studio';
                                
                                // Location badge HTML
                                const locationBadge = package.package_location === 'On-Location' 
                                    ? '<span class="badge badge-soft-info"><i class="ti ti-map-pin me-1"></i> On-Location</span>'
                                    : '<span class="badge badge-soft-primary"><i class="ti ti-building me-1"></i> In-Studio</span>';
                                
                                packagesHtml += `
                                    <div class="col-md-6 col-xl-4">
                                        <input type="radio" class="btn-check package-radio" 
                                            name="package" value="${package.id}" 
                                            id="package${package.id}" 
                                            data-package='${packageJson}'
                                            style="display: none;">
                                        
                                        <label class="card border h-100 package-card" for="package${package.id}" style="cursor: pointer;">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title fw-bold mb-0">${package.package_name}</h6>
                                                    <span class="text-success fw-bold">${priceText}</span>
                                                </div>
                                                
                                                <p class="text-muted small mb-3">${package.package_description ? package.package_description.substring(0, 80) + (package.package_description.length > 80 ? '...' : '') : 'No description available.'}</p>
                                                
                                                <!-- Location type display in package card -->
                                                <div class="d-flex align-items-center mb-2">
                                                    ${locationBadge}
                                                </div>
                                                
                                                <div class="d-flex align-items-center mb-2">
                                                    ${package.online_gallery ? 
                                                        `<span class="p-1 badge badge-soft-success">
                                                            <i class="ti ti-photo me-1"></i> Online Gallery: Included
                                                        </span>` : 
                                                        `<span class="p-1 badge badge-soft-warning">
                                                            <i class="ti ti-photo-off me-1"></i> Online Gallery: Not Included
                                                        </span>`
                                                    }
                                                </div>
                                                
                                                ${isStudio ? `
                                                    <div class="d-flex align-items-center mb-3">
                                                        <span class="p-1 badge badge-soft-primary">
                                                            <i class="ti ti-users me-1"></i>
                                                            Photographers: ${package.photographer_count || 1}
                                                            ${(package.photographer_count || 1) > 1 ? 'photographers' : 'photographer'}
                                                        </span>
                                                    </div>
                                                ` : ''}
                                                
                                                <div class="col">
                                                    <small class="text-muted d-block mb-2"><i class="ti ti-checklist me-1"></i> Package Includes:</small>
                                                    <ul class="list-unstyled small mb-0">
                                                        ${package.duration ? `
                                                            <li class="mb-1">
                                                                <i class="ti ti-clock text-primary me-2"></i> 
                                                                ${package.duration} ${package.duration > 1 ? 'hours' : 'hour'} coverage
                                                            </li>
                                                        ` : ''}
                                                        
                                                        ${package.maximum_edited_photos ? `
                                                            <li class="mb-1">
                                                                <i class="ti ti-camera text-primary me-2"></i> 
                                                                ${package.maximum_edited_photos} edited photos
                                                            </li>
                                                        ` : ''}
                                                        
                                                        ${inclusions.map(inclusion => `
                                                            <li class="mb-1">
                                                                <i class="ti ti-check text-success me-2"></i> 
                                                                ${inclusion}
                                                            </li>
                                                        `).join('')}
                                                        
                                                        ${package.coverage_scope ? `
                                                            <li class="mb-1">
                                                                <i class="ti ti-map-pin text-primary me-2"></i> 
                                                                Coverage: ${package.coverage_scope}
                                                            </li>
                                                        ` : ''}
                                                    </ul>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                `;
                            });
                            
                            packagesHtml += '</div>';
                            $('#packagesContainer').html(packagesHtml);
                            
                            selectedPackageId = null;
                            
                            $('<style>')
                                .prop('type', 'text/css')
                                .html(`
                                    .btn-check:checked + .package-card {
                                        border-color: #3475db !important;
                                    }
                                `)
                                .appendTo('head');
                            
                        } else {
                            let message = 'No packages available for this service/category.';
                            if (response.message) {
                                message = response.message;
                            }
                            
                            $('#packagesContainer').html(`
                                <div class="alert alert-warning">
                                    <i class="ti ti-package-off me-2"></i> ${message}
                                </div>
                            `);
                        }
                    },
                    error: function(xhr) {
                        console.error('Packages AJAX error:', xhr);
                        
                        $('#packagesContainer').html(`
                            <div class="alert alert-danger">
                                <i class="ti ti-alert-circle me-2"></i> Failed to load packages. Please try again.
                            </div>
                        `);
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Loading Error',
                            text: 'Failed to load packages. Please try again.',
                            confirmButtonColor: '#3475db'
                        });
                    }
                });
            });
            
            // Handle package selection
            $(document).on('change', '.package-radio', function() {
                selectedPackageId = $(this).val();
                
                // SAFELY get package data with error handling
                let packageData;
                try {
                    const dataAttr = $(this).attr('data-package');
                    if (!dataAttr || dataAttr === 'undefined' || dataAttr === 'null') {
                        console.error('Package data attribute is missing or invalid');
                        Swal.fire({
                            icon: 'error',
                            title: 'Package Data Error',
                            text: 'Unable to load package details. Please try again.',
                            confirmButtonColor: '#3475db'
                        });
                        return;
                    }
                    
                    packageData = JSON.parse(dataAttr);
                    console.log('Selected package data:', packageData);
                    
                } catch (e) {
                    console.error('Error parsing package data:', e);
                    console.log('Raw data attribute:', $(this).attr('data-package'));
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Package Data Error',
                        text: 'Unable to parse package details. Please refresh and try again.',
                        confirmButtonColor: '#3475db'
                    });
                    return;
                }
                
                const paymentType = $('input[name="payment_type"]:checked').val();
                
                // AUTO-POPULATE LOCATION TYPE BASED ON SELECTED PACKAGE
                if (packageData && packageData.package_location) {
                    const packageLocation = packageData.package_location;
                    console.log('Package location:', packageLocation);
                    
                    // Set the location type dropdown value
                    if (packageLocation === 'In-Studio') {
                        $('#locationType').val('in-studio');
                        console.log('Set location type to: in-studio');
                    } else if (packageLocation === 'On-Location') {
                        $('#locationType').val('on-location');
                        console.log('Set location type to: on-location');
                    } else {
                        console.warn('Unknown package_location value:', packageLocation);
                        $('#locationType').val('');
                    }
                    
                    // Remove any existing badge first
                    $('#locationType').closest('.col-12').find('.badge.badge-soft-info').remove();
                    
                    // Disable the location type dropdown since it's now automatically populated
                    $('#locationType').prop('disabled', true);
                    
                    // Add a visual indicator that this is auto-populated
                    $('#locationType').closest('.col-12').find('.form-label').append(
                        '<span class="badge badge-soft-info ms-2" style="font-size: 0.65rem;">' +
                        '<i class="ti ti-info-circle me-1"></i>Auto-set by package</span>'
                    );
                    
                    // Trigger change event to update location details visibility
                    $('#locationType').trigger('change');
                } else {
                    console.warn('Package data missing package_location:', packageData);
                    // Reset location type if package doesn't have location info
                    $('#locationType').val('').prop('disabled', false);
                    $('#locationType').closest('.col-12').find('.badge.badge-soft-info').remove();
                }
                
                getBookingSummaryWithPaymentType(packageData, paymentType);
            });
            
            // Toggle location details based on location type
            $('#locationType').on('change', function() {
                if ($(this).val() === 'on-location') {
                    $('#locationDetails').show();
                    $('#venueName').prop('required', true);
                    $('#city').prop('required', true);
                    $('#barangay').prop('required', true);
                } else {
                    $('#locationDetails').hide();
                    $('#venueName').prop('required', false);
                    $('#city').prop('required', false);
                    $('#barangay').prop('required', false);
                    $('#city').val('').trigger('change');
                    $('#barangay').prop('disabled', true).html('<option value="">Select Barangay</option>');
                }
            });
            
            // Check date availability
            $('#checkDateBtn').on('click', function() {
                const selectedDate = $('#eventDate').val();
                const startTime    = $('#startTime').val();
                const endTime      = $('#endTime').val();
                const type         = $('#bookingType').val();
                const providerId   = $('#providerId').val();

                if (!selectedDate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Date Selected',
                        text: 'Please select a date first.',
                        confirmButtonColor: '#3475db'
                    });
                    return;
                }

                if (!startTime || !endTime) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Time Required',
                        text: 'Please enter both start time and end time before checking availability.',
                        confirmButtonColor: '#3475db'
                    });
                    return;
                }

                // Show checking status
                $('#dateStatusIcon').html('<i class="ti ti-clock text-info"></i>');
                $('#dateStatusText').text('Checking availability...');

                $.ajax({
                    url: '{{ route("client.bookings.check-availability") }}',
                    type: 'POST',
                    data: {
                        type:        type,
                        provider_id: providerId,
                        date:        selectedDate,
                        start_time:  startTime,
                        end_time:    endTime,
                        _token:      '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success && response.available) {
                            $('#dateStatusIcon').html('<i class="ti ti-circle-check text-success"></i>');
                            $('#dateStatusText').html(`
                                <span class="text-success fw-medium">Available</span> 
                                <span class="text-muted">(${response.existing_bookings}/${response.max_bookings} bookings)</span>
                            `);
                            $('#submitBookingBtn').prop('disabled', false);
                        } else {
                            $('#dateStatusIcon').html('<i class="ti ti-circle-x text-danger"></i>');
                            $('#dateStatusText').html(`
                                <span class="text-danger fw-medium">${response.message || 'Not Available'}</span>
                            `);
                            $('#submitBookingBtn').prop('disabled', true);

                            Swal.fire({
                                icon: 'warning',
                                title: 'Not Available',
                                text: response.message || 'This time slot is not available.',
                                confirmButtonColor: '#3475db'
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#dateStatusIcon').html('<i class="ti ti-alert-circle text-danger"></i>');
                        $('#dateStatusText').html('<span class="text-danger fw-medium">Error checking availability</span>');
                        $('#submitBookingBtn').prop('disabled', true);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to check availability. Please try again.',
                            confirmButtonColor: '#3475db'
                        });
                    }
                });
            });

            // Auto-check when date or time changes
            $('#eventDate, #startTime, #endTime').on('change', function() {
                const selectedDate = $('#eventDate').val();
                const startTime    = $('#startTime').val();
                const endTime      = $('#endTime').val();

                if (!selectedDate) {
                    $('#dateStatusIcon').empty();
                    $('#dateStatusText').text('Select a date to check availability');
                    $('#closedDayNote').hide();
                    $('#submitBookingBtn').prop('disabled', false);
                    return;
                }

                // Block non-operating days immediately without server call
                if (!isOperatingDay(selectedDate)) {
                    const parts   = selectedDate.split('-');
                    const dayName = new Date(parts[0], parts[1] - 1, parts[2])
                        .toLocaleDateString('en-US', { weekday: 'long' });

                    $('#dateStatusIcon').html('<i class="ti ti-circle-x text-danger"></i>');
                    $('#dateStatusText').html(
                        `<span class="text-danger fw-medium">${dayName} is not an operating day</span>`
                    );
                    $('#closedDayNote').text('Operating days: ' + formatOperatingDays()).show();
                    $('#submitBookingBtn').prop('disabled', true);
                    return;
                }

                // Only auto-check if all three fields are filled
                if (selectedDate && startTime && endTime) {
                    $('#closedDayNote').hide();
                    $('#checkDateBtn').trigger('click');
                } else {
                    $('#dateStatusIcon').html('<i class="ti ti-info-circle text-info"></i>');
                    $('#dateStatusText').html('<span class="text-muted">Please fill in start and end time to check availability</span>');
                }
            });
            
            // View calendar modal
            $('#viewCalendarBtn').on('click', function() {
                generateAvailabilityCalendar();
                $('#calendarModal').modal('show');
            });
            
            // Submit booking button
            $('#submitBookingBtn').on('click', function() {
                if (!validateBookingForm()) return;
                
                bookingData = {
                    type: $('#bookingType').val(),
                    provider_id: $('#providerId').val(),
                    category_id: $('#serviceCategory').val(),
                    package_id: selectedPackageId,
                    event_date: $('#eventDate').val(),
                    start_time: $('#startTime').val(),
                    end_time: $('#endTime').val(),
                    location_type: $('#locationType').val(), // This is now auto-populated from package
                    venue_name: $('#venueName').val(),
                    street: $('#street').val(),
                    barangay: $('#barangay').val(),
                    city: $('#city').val(),
                    special_requests: $('#specialRequests').val(),
                    full_name: $('#fullName').val(),
                    contact_number: $('#contactNumber').val(),
                    email: $('#email').val(),
                    payment_type: $('input[name="payment_type"]:checked').val(),
                    _token: '{{ csrf_token() }}'
                };
                
                showBookingSummary();
            });
            
            // Proceed to payment
            $('#proceedToPaymentBtn').on('click', function() {
                processBooking();
            });

            // City/Municipality change handler - Load Barangays
            $(document).on('change', '#city', function() {
                const municipality = $(this).val();
                const barangaySelect = $('#barangay');
                
                if (!municipality) {
                    barangaySelect.prop('disabled', true).html('<option value="">Select Barangay</option>');
                    return;
                }
                
                barangaySelect.prop('disabled', true).html('<option value="">Loading barangays...</option>');
                
                $.ajax({
                    url: '{{ route("client.locations.barangays") }}',
                    type: 'POST',
                    data: {
                        municipality: municipality,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success && response.barangays && response.barangays.length > 0) {
                            let options = '<option value="">Select Barangay</option>';
                            const sortedBarangays = response.barangays.sort();
                            sortedBarangays.forEach(function(barangay) {
                                options += `<option value="${barangay}">${barangay}</option>`;
                            });
                            barangaySelect.html(options).prop('disabled', false);
                        } else {
                            barangaySelect.html('<option value="">No barangays available</option>').prop('disabled', true);
                            Swal.fire({
                                icon: 'warning',
                                title: 'No Barangays Found',
                                text: 'No barangay data available for this municipality.',
                                confirmButtonColor: '#3475db'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Barangay load error:', xhr);
                        barangaySelect.html('<option value="">Error loading barangays</option>').prop('disabled', true);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load barangays. Please try again.',
                            confirmButtonColor: '#3475db'
                        });
                    }
                });
            });
            
            // ========== Functions ==========

            function getBookingSummaryWithPaymentType(packageData, paymentType) {
                // ADDED: Better validation
                if (!packageData) {
                    console.error('Package data is null or undefined');
                    return;
                }
                
                if (!packageData.id) {
                    console.error('Package ID is missing from package data:', packageData);
                    return;
                }
                
                console.log('Getting summary for package:', packageData.id, 'Payment type:', paymentType);
                
                $.ajax({
                    url: '{{ route("client.bookings.summary") }}',
                    type: 'POST',
                    data: {
                        package_id: packageData.id,
                        type: $('#bookingType').val(),
                        payment_type: paymentType,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Summary response:', response);
                        
                        if (response.success) {
                            window.bookingSummary = response.summary;
                            
                            if ($('#bookingSummaryModal').hasClass('show')) {
                                updateSummaryPriceDisplay(response.summary);
                            }
                            
                            // Update the downpayment label text if needed
                            const isStudio = $('#bookingType').val() === 'studio';
                            if (isStudio && response.summary.downpayment_percentage) {
                                const downpaymentLabel = $('label[for="payment_type_downpayment"]');
                                if (downpaymentLabel.length) {
                                    downpaymentLabel.html(`
                                        <i class="ti ti-percentage me-1"></i> ${response.summary.downpayment_percentage}% Downpayment
                                    `);
                                }
                            }
                        } else {
                            console.error('Summary response error:', response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error('Summary AJAX error:', xhr);
                        console.error('Summary error response:', xhr.responseJSON);
                    }
                });
            }

            function validateBookingForm() {
                const form = document.getElementById('bookingForm');
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return false;
                }
                
                const dateStatusText = $('#dateStatusText').text().toLowerCase();
                if (dateStatusText.includes('fully booked') || 
                    dateStatusText.includes('not available') || 
                    dateStatusText.includes('error') ||
                    dateStatusText.includes('not an operating day')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Date Not Available',
                        text: 'Please select an available date before proceeding.',
                        confirmButtonColor: '#3475db'
                    });
                    return false;
                }
                
                if ($('#dateStatusText').text() === 'Select a date to check availability') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Date Not Checked',
                        text: 'Please check the availability of your selected date first.',
                        confirmButtonColor: '#3475db'
                    });
                    return false;
                }
                
                if (!selectedPackageId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Package Required',
                        text: 'Please select a package.',
                        confirmButtonColor: '#3475db'
                    });
                    return false;
                }
                
                // MODIFIED: Location type validation - check if it's set (should be auto-populated)
                const locationType = $('#locationType').val();
                if (!locationType) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Location Type Error',
                        text: 'Please select a package first to determine location type.',
                        confirmButtonColor: '#3475db'
                    });
                    return false;
                }
                
                const paymentType = $('input[name="payment_type"]:checked').val();
                if (!paymentType) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Payment Type Required',
                        text: 'Please select a payment type.',
                        confirmButtonColor: '#3475db'
                    });
                    return false;
                }
                
                if ($('#locationType').val() === 'on-location') {
                    if (!$('#city').val()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'City/Municipality Required',
                            text: 'Please select a city/municipality.',
                            confirmButtonColor: '#3475db'
                        });
                        return false;
                    }
                    
                    if (!$('#barangay').val()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Barangay Required',
                            text: 'Please select a barangay.',
                            confirmButtonColor: '#3475db'
                        });
                        return false;
                    }
                }
                
                return true;
            }
            
            function getBookingSummary(packageData) {
                $.ajax({
                    url: '{{ route("client.bookings.summary") }}',
                    type: 'POST',
                    data: {
                        package_id: packageData.id,
                        type: $('#bookingType').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            window.bookingSummary = response.summary;
                        }
                    },
                    error: function(xhr) {
                        console.error('Summary error:', xhr);
                    }
                });
            }
            
            function showBookingSummary() {
                $('#summaryFullName').text(bookingData.full_name);
                $('#summaryContactNumber').text(bookingData.contact_number);
                $('#summaryEmailAddress').text(bookingData.email);
                
                const packageName = $(`.package-radio[value="${selectedPackageId}"]`).data('package').package_name;
                $('#summaryPackage').text(packageName);
                
                const eventDate = new Date(bookingData.event_date);
                $('#summaryDate').text(eventDate.toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                }));
                
                $('#summaryTime').text(
                    formatTime(bookingData.start_time) + ' - ' + formatTime(bookingData.end_time)
                );
                
                // MODIFIED: Show location type based on package
                const locationTypeDisplay = bookingData.location_type === 'in-studio' ? 'In-Studio' : 'On-Location';
                $('#summaryLocationType').text(locationTypeDisplay);
                
                if (bookingData.location_type === 'on-location') {
                    let locationText = '';
                    if (bookingData.venue_name) locationText += `<strong>${bookingData.venue_name}</strong><br>`;
                    if (bookingData.street) locationText += bookingData.street + ', ';
                    if (bookingData.barangay) locationText += 'Brgy. ' + bookingData.barangay + ', ';
                    if (bookingData.city) locationText += bookingData.city + ', ';
                    locationText += 'Cavite';
                    
                    $('#summaryLocationDetails').html(`
                        <p class="text-muted small mb-1 mt-2">Location Details:</p>
                        <p class="fw-medium mb-2">${locationText}</p>
                    `).show();
                } else {
                    $('#summaryLocationDetails').hide();
                }
                
                // ADDED: Show package location badge in summary
                const package = $(`.package-radio[value="${selectedPackageId}"]`).data('package');
                const locationBadge = package.package_location === 'On-Location'
                    ? '<span class="badge badge-soft-info"><i class="ti ti-map-pin me-1"></i> On-Location Package</span>'
                    : '<span class="badge badge-soft-primary"><i class="ti ti-building me-1"></i> In-Studio Package</span>';
                
                $('#summaryPackage').after(`
                    <p class="text-muted small mb-1">Package Location:</p>
                    <p class="fw-medium mb-2" id="summaryPackageLocation">${locationBadge}</p>
                `);
                
                if (window.bookingSummary) {
                    $('#packagePrice').text('₱' + window.bookingSummary.package_price);
                    $('#downPayment').text('₱' + window.bookingSummary.down_payment);
                    $('#remainingBalance').text('₱' + window.bookingSummary.remaining_balance);
                    $('#totalAmount').text('₱' + window.bookingSummary.total_amount);
                    
                    const downpaymentPercentage = window.bookingSummary.downpayment_percentage || 30;
                    $('#downPaymentLabel').text(`Down Payment (${downpaymentPercentage}%):`);
                    
                    if (window.bookingSummary.payment_type === 'full_payment') {
                        $('#downPaymentRow').hide();
                        $('#remainingBalanceRow').hide();
                    } else {
                        $('#downPaymentRow').show();
                        $('#remainingBalanceRow').show();
                    }
                    
                    const galleryHtml = `
                        <p class="text-muted small mb-1 mt-2">Online Gallery:</p>
                        <p class="fw-medium mb-2">
                            <span class="badge badge-soft-${window.bookingSummary.online_gallery ? 'success' : 'warning'}">
                                <i class="${window.bookingSummary.online_gallery ? 'ti ti-photo' : 'ti ti-photo-off'} me-1"></i>
                                ${window.bookingSummary.gallery_status || (window.bookingSummary.online_gallery ? 'Included' : 'Not Included')}
                            </span>
                        </p>
                    `;
                    
                    $('#summaryPackage').after(galleryHtml);
                    
                    const isStudio = $('#bookingType').val() === 'studio';
                    if (isStudio && window.bookingSummary.photographer_count !== undefined) {
                        const photographerHtml = `
                            <p class="text-muted small mb-1">Assigned Photographers:</p>
                            <p class="fw-medium mb-2">
                                <span class="badge badge-soft-primary">
                                    <i class="ti ti-users me-1"></i>
                                    ${window.bookingSummary.photographer_text || (window.bookingSummary.photographer_count + ' photographer' + (window.bookingSummary.photographer_count > 1 ? 's' : ''))}
                                </span>
                            </p>
                        `;
                        $('#summaryPackage').after(photographerHtml);
                    }
                    
                    let inclusionsHtml = '';
                    if (window.bookingSummary.inclusions && Array.isArray(window.bookingSummary.inclusions)) {
                        window.bookingSummary.inclusions.forEach(function(inclusion) {
                            inclusionsHtml += `<li><i class="ti ti-check text-success me-2"></i>${inclusion}</li>`;
                        });
                    }
                    $('#summaryInclusions').html(inclusionsHtml);
                }
                
                $('#bookingSummaryModal').modal('show');
            }
            
            function processBooking() {
                $('#proceedToPaymentBtn').prop('disabled', true);
                $('#proceedToPaymentBtn').html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Processing...
                `);
                
                if (!bookingData.payment_type) {
                    bookingData.payment_type = $('input[name="payment_type"]:checked').val();
                }
                
                $.ajax({
                    url: '{{ route("client.bookings.store") }}',
                    type: 'POST',
                    data: bookingData,
                    success: function(response) {
                        if (response.success) {
                            bookingId = response.booking.id;
                            initializePayment();
                        } else {
                            showError('Failed to create booking: ' + response.message);
                            resetPaymentButton();
                        }
                    },
                    error: function(xhr) {
                        console.error('Booking store error:', xhr);
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMessages = [];
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                errorMessages.push(messages.join(', '));
                            });
                            showError('Validation errors: ' + errorMessages.join('; '));
                        } else {
                            showError('Booking creation failed. Please try again.');
                        }
                        resetPaymentButton();
                    }
                });
            }
            
            function initializePayment() {
                Swal.fire({
                    title: 'Confirm Payment',
                    text: 'Are you sure you want to proceed to payment?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Proceed to Payment',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3475db',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        proceedWithPayment();
                    } else {
                        resetPaymentButton();
                    }
                });
            }

            function proceedWithPayment() {
                $('#proceedToPaymentBtn').prop('disabled', true);
                $('#proceedToPaymentBtn').html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Creating payment link...
                `);
                
                $.ajax({
                    url: '{{ route("client.payments.initialize") }}',
                    type: 'POST',
                    data: {
                        booking_id: bookingId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.type === 'payment_intent') {
                                window.location.href = response.redirect_url;
                            } else if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            } else {
                                showError('No redirect URL provided');
                                resetPaymentButton();
                            }
                        } else {
                            showError('Payment initialization failed: ' + (response.message || 'Unknown error'));
                            resetPaymentButton();
                        }
                    },
                    error: function(xhr) {
                        console.error('Payment init error:', xhr);
                        showError('Payment initialization failed. Please try again.');
                        resetPaymentButton();
                    }
                });
            }
            
            function generateAvailabilityCalendar() {
                const calendarEl = document.getElementById('availabilityCalendar');
                const today = new Date();
                
                getCalendarAvailability(today.getFullYear(), today.getMonth() + 1).then(availabilityData => {
                    let calendarHtml = `
                        <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                            <button class="btn btn-sm btn-outline-secondary" id="prevMonth"><i class="ti ti-chevron-left"></i></button>
                            <h6 class="mb-0" id="currentMonth">${today.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</h6>
                            <button class="btn btn-sm btn-outline-secondary" id="nextMonth"><i class="ti ti-chevron-right"></i></button>
                        </div>
                        <div class="calendar-grid" id="calendarGrid">
                    `;
                    
                    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    days.forEach(day => {
                        calendarHtml += `<div class="calendar-day-header">${day}</div>`;
                    });
                    
                    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    
                    for (let i = 0; i < firstDay.getDay(); i++) {
                        calendarHtml += `<div class="calendar-day empty"></div>`;
                    }
                    
                    for (let day = 1; day <= lastDay.getDate(); day++) {
                        const date = new Date(today.getFullYear(), today.getMonth(), day);
                        const dateString = date.toISOString().split('T')[0];
                        const isToday = date.toDateString() === today.toDateString();
                        const isPast = date < today;
                        
                        const dateAvailability = availabilityData[dateString];
                        const isAvailable = dateAvailability ? dateAvailability.available : true;
                        const isFullyBooked = dateAvailability ? dateAvailability.fully_booked : false;
                        const isNotOperating = dateAvailability ? dateAvailability.not_operating : !isOperatingDay(dateString);
                        
                        let dateClass = 'calendar-day';
                        if (isToday) dateClass += ' today';
                        if (isPast) dateClass += ' past';
                        if (!isAvailable || isFullyBooked || isNotOperating) dateClass += ' unavailable';
                        if (isFullyBooked) dateClass += ' fully-booked';
                        
                        calendarHtml += `
                            <div class="${dateClass}" data-date="${dateString}" 
                                title="${isNotOperating ? 'Closed' : (isFullyBooked ? 'Fully Booked' : (isAvailable ? 'Available' : 'Not Available'))}">
                                ${day}
                                ${isFullyBooked ? '<div class="availability-dot unavailable"></div>' : (isAvailable && !isNotOperating ? '<div class="availability-dot available"></div>' : '')}
                            </div>
                        `;
                    }
                    
                    calendarHtml += '</div>';
                    calendarEl.innerHTML = calendarHtml;
                    
                    $('.calendar-day:not(.past):not(.unavailable):not(.fully-booked)').on('click', function() {
                        const selectedDate = $(this).data('date');
                        $('#eventDate').val(selectedDate);
                        $('#calendarModal').modal('hide');
                        $('#eventDate').trigger('change');
                    });
                    
                    $('<style>')
                        .prop('type', 'text/css')
                        .html('.calendar-day.fully-booked { background: #fee; border-color: #dc3545; color: #dc3545; cursor: not-allowed; }')
                        .appendTo('head');
                });
            }

            function getCalendarAvailability(year, month) {
                const type = $('#bookingType').val();
                const providerId = $('#providerId').val();
                
                return $.ajax({
                    url: '{{ route("client.bookings.calendar-availability") }}',
                    type: 'POST',
                    data: {
                        type: type,
                        provider_id: providerId,
                        year: year,
                        month: month,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        return response.availability || {};
                    },
                    error: function() {
                        return {};
                    }
                });
            }
            
            function formatTime(timeString) {
                const [hours, minutes] = timeString.split(':');
                const hour = parseInt(hours);
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const formattedHour = hour % 12 || 12;
                return `${formattedHour}:${minutes} ${ampm}`;
            }
            
            function showError(message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message,
                    confirmButtonColor: '#3475db'
                });
            }
            
            function resetPaymentButton() {
                $('#proceedToPaymentBtn').prop('disabled', false);
                $('#proceedToPaymentBtn').html(`
                    <i class="ti ti-credit-card me-2"></i>Proceed to Payment
                `);
            }

            function updateSummaryPriceDisplay(summary) {
                $('#packagePrice').text('₱' + summary.package_price);
                $('#downPayment').text('₱' + summary.down_payment);
                $('#remainingBalance').text('₱' + summary.remaining_balance);
                $('#totalAmount').text('₱' + summary.total_amount);
                
                // Update down payment label with dynamic percentage
                const downpaymentPercentage = summary.downpayment_percentage || 30;
                $('#downPaymentLabel').text(`Down Payment (${downpaymentPercentage}%):`);
                
                // Show/hide rows based on payment type
                if (summary.payment_type === 'full_payment') {
                    $('#downPaymentRow').hide();
                    $('#remainingBalanceRow').hide();
                } else {
                    $('#downPaymentRow').show();
                    $('#remainingBalanceRow').show();
                }
                
                const paymentTypeText = summary.payment_type === 'downpayment' 
                    ? `${downpaymentPercentage}% Downpayment`
                    : 'Full Payment';
                
                $('#summaryPaymentType').remove();
                $('#summaryPackage').after(`
                    <p class="text-muted small mb-1">Payment Type:</p>
                    <p class="fw-medium mb-2" id="summaryPaymentType">${paymentTypeText}</p>
                `);
            }
        });
    </script>
@endsection