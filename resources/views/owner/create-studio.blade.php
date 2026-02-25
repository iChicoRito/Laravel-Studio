@extends('layouts.owner.app')
@section('title', 'Studio Registration')

{{-- CONTENT --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">                  
            <div class="row mt-3">
                <div class="col-12">
                    @php
                        $user = Auth::user();
                        $studioCount = \App\Models\StudioOwner\StudiosModel::where('user_id', $user->id)->count();
                        
                        // Get all studio IDs owned by this user
                        $userStudioIds = \App\Models\StudioOwner\StudiosModel::where('user_id', $user->id)->pluck('id')->toArray();
                        
                        // Check if ANY of the user's studios have an active subscription
                        $activeSubscription = null;
                        $subscriptionPlan = null;
                        $maxStudios = null;
                        
                        if (!empty($userStudioIds)) {
                            // Get the most recent active subscription from any of the user's studios
                            $activeSubscription = \App\Models\StudioPlanModel::whereIn('studio_id', $userStudioIds)
                                ->with('plan')
                                ->where('status', 'active')
                                ->where('payment_status', 'paid')
                                ->where('end_date', '>=', now()->toDateString())
                                ->latest()
                                ->first();
                                
                            if ($activeSubscription && $activeSubscription->plan) {
                                $subscriptionPlan = $activeSubscription->plan;
                                $maxStudios = $subscriptionPlan->max_studios;
                            }
                        }
                        
                        \Log::info('Studio Registration Check', [
                            'user_id' => $user->id,
                            'studio_count' => $studioCount,
                            'user_studio_ids' => $userStudioIds,
                            'has_subscription' => $activeSubscription ? true : false,
                            'max_studios' => $maxStudios
                        ]);
                    @endphp

                    @if($studioCount >= 1)
                        @if(!$activeSubscription)
                            {{-- ==================== No subscription - Block registration ==================== --}}
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="ti ti-alert-triangle fs-24 text-danger"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="alert-heading text-danger">Subscription Required!</h5>
                                        <p class="mb-2">You already have <strong>{{ $studioCount }} registered studio(s)</strong>. To register another studio, you need an active subscription plan. Without a subscription, you cannot register additional studios.</p>
                                        <div>
                                            <a href="{{ route('owner.subscription.index') }}" class="btn btn-danger">
                                                <i class="ti ti-crown me-1"></i>View Subscription Plans
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Disable the form if no subscription --}}
                            <style>
                                #studioRegistrationForm input:not([readonly]):not([disabled]),
                                #studioRegistrationForm select:not([disabled]),
                                #studioRegistrationForm textarea:not([disabled]),
                                #studioRegistrationForm button[type="submit"] {
                                    pointer-events: none;
                                    opacity: 0.6;
                                    background-color: #f8f9fa;
                                }
                                #studioRegistrationForm button[type="submit"] {
                                    display: none;
                                }
                            </style>
                            
                        @elseif($activeSubscription)
                            @php
                                $canRegister = $maxStudios === null || $studioCount < $maxStudios;
                                $remainingStudios = $maxStudios !== null ? max(0, $maxStudios - $studioCount) : 'unlimited';
                                
                                \Log::info('Subscription Details', [
                                    'plan_name' => $subscriptionPlan->name ?? 'Unknown',
                                    'max_studios' => $maxStudios,
                                    'can_register' => $canRegister,
                                    'remaining' => $remainingStudios
                                ]);
                            @endphp
                            
                            @if(!$canRegister)
                                {{-- ==================== At plan limit ==================== --}}
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="ti ti-alert-circle fs-24 text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="alert-heading text-warning">Studio Limit Reached!</h5>
                                            <p class="mb-2">
                                                Your <strong>{{ ucfirst($subscriptionPlan->name) }}</strong> plan allows up to 
                                                <strong>{{ $maxStudios }} studio(s)</strong>. You have already registered 
                                                <strong>{{ $studioCount }} studio(s)</strong>.
                                            </p>
                                            <p class="mb-0">
                                                To register more studios, please upgrade your subscription plan.
                                            </p>
                                            <div class="mt-3">
                                                <a href="{{ route('owner.subscription.index') }}" class="btn btn-warning">
                                                    <i class="ti ti-crown me-1"></i>Upgrade Plan
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Disable the form --}}
                                <style>
                                    #studioRegistrationForm input:not([readonly]):not([disabled]),
                                    #studioRegistrationForm select:not([disabled]),
                                    #studioRegistrationForm textarea:not([disabled]),
                                    #studioRegistrationForm button[type="submit"] {
                                        pointer-events: none;
                                        opacity: 0.6;
                                        background-color: #f8f9fa;
                                    }
                                    #studioRegistrationForm button[type="submit"] {
                                        display: none;
                                    }
                                </style>
                                
                            @else
                                {{-- ==================== Can register - Show info ==================== --}}
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="ti ti-circle-check fs-24 text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="alert-heading text-success">Subscription Active</h5>
                                            <p class="mb-2">
                                                You have an active <strong>{{ ucfirst($subscriptionPlan->name) }}</strong> subscription.
                                            </p>
                                            <p class="mb-0">
                                                @if($maxStudios !== null)
                                                    You can register up to <strong>{{ $maxStudios }} studio(s)</strong>. 
                                                    Remaining slots: <strong>{{ $remainingStudios }}</strong>
                                                @else
                                                    You can register unlimited studios with your current plan.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                    <div class="card">
                        <div class="card-header card-title">
                            <h4 class="card-title">Register your Studio</h4>
                            </div>
                        <div class="card-body">

                            <form id="studioRegistrationForm" action="{{ route('owner.studio.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">
                                    <h4 class="card-title text-primary mb-3">Studio Identification Information</h4>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Studio Name</label>
                                        <input type="text" class="form-control" placeholder="Enter your studio name" name="studio_name" required>
                                        <div class="invalid-feedback">
                                            Please enter your studio name.
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Studio Type</label>
                                        <select class="form-select" name="studio_type" required>
                                            <option value="" selected disabled hidden>Choose a studio type</option>
                                            <option value="photography_studio">Photography Studio</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose a studio type.
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Year Established</label>
                                        <input type="number" class="form-control" name="year_established" placeholder="Enter your year established" required>
                                        <div class="invalid-feedback">
                                            Please enter your year established.
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Studio Description</label>
                                        <textarea class="form-control" name="studio_description" rows="5" placeholder="Enter your studio description" required></textarea>
                                        <div class="invalid-feedback">
                                            Please enter your studio description.
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-semibold">Studio Logo</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="studioLogo" name="studio_logo" accept=".jpg,.jpeg,.png" required>
                                        </div>
                                        <div class="form-text">Upload a clear copy of your studio logo.</div>
                                        <div class="invalid-feedback">
                                            Please upload a valid studio logo.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="card-title text-primary mb-3">Studio Contact Information</h4>
                                    
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Enter studio contact number" name="contact_number" required>
                                        <div class="invalid-feedback">
                                            Please enter studio contact number.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Studio Email</label>
                                        <input type="email" class="form-control" placeholder="Enter studio email address" name="studio_email" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid studio email.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label class="form-label">Facebook URL <span class="text-muted">(Optional)</span></label>
                                        <input type="url" class="form-control" placeholder="https://facebook.com/yourpage" name="facebook_url">
                                        <div class="invalid-feedback">
                                            Please enter a valid Facebook URL.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label class="form-label">Instagram URL <span class="text-muted">(Optional)</span></label>
                                        <input type="url" class="form-control" placeholder="https://instagram.com/yourprofile" name="instagram_url">
                                        <div class="invalid-feedback">
                                            Please enter a valid Instagram URL.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label class="form-label">Website URL <span class="text-muted">(Optional)</span></label>
                                        <input type="url" class="form-control" placeholder="https://yourwebsite.com" name="website_url">
                                        <div class="invalid-feedback">
                                            Please enter a valid website URL.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="card-title text-primary mb-3">Owner Information</h4>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-semibold">Owner Profile Picture</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="ownerProfilePhoto" name="owner_profile_photo" accept=".jpg,.jpeg,.png">
                                        </div>
                                        <div class="form-text">Upload a profile picture for the owner (optional). Max size: 3MB</div>
                                        <div class="invalid-feedback">
                                            Please upload a valid image file.
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Owner Name</label>
                                        <input type="text" class="form-control" placeholder="Enter your owner name" name="owner_name" 
                                            value="{{ $user->first_name . ' ' . $user->last_name }}" readonly required>
                                        <div class="invalid-feedback">
                                            Please enter your owner name.
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" placeholder="Enter your email address" name="owner_email" 
                                            value="{{ $user->email }}" readonly required>
                                        <div class="invalid-feedback">
                                            Please enter your email address.
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="tel" class="form-control" placeholder="Enter your mobile number" name="owner_mobile_number" 
                                            value="{{ $user->mobile_number }}" readonly required>
                                        <div class="invalid-feedback">
                                            Please enter your mobile number.
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">User Role</label>
                                        <input type="text" class="form-control" placeholder="Studio Owner" name="user_role" value="Studio Owner" disabled readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="card-title text-primary mb-3">Location Information</h4>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Province</label>
                                        <input type="text" class="form-control" placeholder="Enter your province" name="province" value="Cavite" readonly disabled required>
                                        <input type="hidden" name="province" value="Cavite">
                                        <small>cannot be changed</small>
                                        <div class="invalid-feedback">
                                            Please enter your province.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Municipality</label>
                                        <select class="form-control" id="municipalitySelect" name="municipality" required>
                                            <option value="">Select your municipality</option>
                                            @foreach($municipalities as $municipality)
                                                <option value="{{ $municipality }}">{{ $municipality }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select your municipality.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Barangay</label>
                                        <select class="form-control" id="barangaySelect" name="barangay" required disabled>
                                            <option value="">Select municipality first</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select your barangay.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">ZIP Code</label>
                                        <input type="text" class="form-control" id="zipCodeInput" placeholder="ZIP code will auto-fill" name="zip_code_display" readonly required>
                                        <div class="invalid-feedback">
                                            Please wait for the ZIP code to load or select a valid municipality.
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">Street Address</label>
                                        <input type="text" class="form-control" placeholder="Enter your street address" name="street" required>
                                        <div class="invalid-feedback">
                                            Please enter your street address.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="card-title text-primary mb-3">Service Information</h4>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Service Categories</label>
                                        <select class="form-control" name="service_categories[]" multiple required>
                                            <option value="" disabled>Select service categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple categories</small>
                                        <div class="invalid-feedback">
                                            Please select at least one service category.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Starting Price (PHP)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" class="form-control" placeholder="Enter your starting price" name="starting_price" step="0.01" min="0" required>
                                            <div class="invalid-feedback">
                                                Please enter your starting price.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Downpayment Percentage (%)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" placeholder="Enter downpayment percentage" name="downpayment_percentage" step="0.01" min="0" max="100" value="30">
                                            <span class="input-group-text">%</span>
                                            <div class="invalid-feedback">
                                                Please enter a valid percentage between 0 and 100.
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Default is 30%. This will be required as downpayment for bookings.</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="card-title text-primary mb-3">Operating Schedule</h4>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Operating Days</label>
                                        <div class="btn-group w-100 mb-1" role="group" aria-label="Weekday toggle button group" id="operatingDaysGroup">
                                            <input type="checkbox" class="btn-check" id="btnMonday" name="operating_days[]" value="monday" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btnMonday">Monday</label>

                                            <input type="checkbox" class="btn-check" id="btnTuesday" name="operating_days[]" value="tuesday" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btnTuesday">Tuesday</label>

                                            <input type="checkbox" class="btn-check" id="btnWednesday" name="operating_days[]" value="wednesday" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btnWednesday">Wednesday</label>

                                            <input type="checkbox" class="btn-check" id="btnThursday" name="operating_days[]" value="thursday" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btnThursday">Thursday</label>

                                            <input type="checkbox" class="btn-check" id="btnFriday" name="operating_days[]" value="friday" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btnFriday">Friday</label>

                                            <input type="checkbox" class="btn-check" id="btnSaturday" name="operating_days[]" value="saturday" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btnSaturday">Saturday</label>

                                            <input type="checkbox" class="btn-check" id="btnSunday" name="operating_days[]" value="sunday" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btnSunday">Sunday</label>
                                        </div>
                                        <div class="invalid-feedback operating-days-error" style="display: none;">
                                            Please select at least one operating day.
                                        </div>
                                        <small class="form-text text-muted">Select all days your studio will be open for business</small>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="startTime">Start Time</label>
                                        <input type="time" class="form-control" id="startTime" name="start_time" required>
                                        <div class="invalid-feedback">
                                            Please enter the start time.
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label" for="endTime">End Time</label>
                                        <input type="time" class="form-control" id="endTime" name="end_time" required>
                                        <div class="invalid-feedback">
                                            Please enter the end time.
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">Maximum Client per Day</label>
                                        <div class="input-group" data-touchspin="">
                                            <button type="button" class="btn btn-light floating" data-minus=""><i class="ti ti-minus"></i></button>
                                            <input type="number" class="form-control form-control-sm border-0" value="1" max="100" name="max_clients_per_day" required>
                                            <button type="button" class="btn btn-light floating" data-plus=""><i class="ti ti-plus"></i></button>
                                        </div>
                                        <div class="invalid-feedback">
                                            Please enter the maximum client per day.
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">Advance Booking</label>
                                        <input type="number" class="form-control" placeholder="Enter the advance booking days" max="30" name="advance_booking_days" required>
                                        <small class="form-text text-muted">The minimum number of days before the studio can be reserved</small>
                                        <div class="invalid-feedback">
                                            Please enter the advance booking days.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="card-title text-primary mb-1">Verification Documents</h4>
                                    <p class="text-muted mb-3">Please upload the required documents for verification. Maximum file size: 3MB per file. Supported formats: PDF, JPG, PNG.</p>
                                    
                                    <div class="col-12 mb-3">                                            
                                        <!-- Business Permit -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Business Permit/DTI/SEC Registration</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="businessPermit" name="business_permit" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </div>
                                            <div class="form-text">Upload a clear copy of your business registration document</div>
                                            <div class="invalid-feedback">
                                                Please upload your business permit or registration document.
                                            </div>
                                        </div>
                                        
                                        <!-- Valid ID -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Valid Government ID (Owner)</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="ownerId" name="owner_id_document" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </div>
                                            <div class="form-text">Upload a clear copy of any valid government ID (Passport, Driver's License, UMID, etc.)</div>
                                            <div class="invalid-feedback">
                                                Please upload a valid government ID.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary">Submit Form</button>
                                    </div>
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
            // Initialize Choices for service categories only
            function initializeChoices() {
                if (typeof Choices !== 'undefined') {
                    // Service Categories (multi-select)
                    const serviceCategoriesSelect = document.querySelector('select[name="service_categories[]"]');
                    if (serviceCategoriesSelect) {
                        new Choices(serviceCategoriesSelect, {
                            removeItemButton: true,
                            searchEnabled: true,
                            placeholder: true,
                            placeholderValue: 'Select service categories',
                            shouldSort: false
                        });
                    }
                }
            }
            
            initializeChoices();

            // Dynamic location handling
            $('#municipalitySelect').on('change', function() {
                const municipality = $(this).val();
                const barangaySelect = $('#barangaySelect');
                const zipCodeInput = $('#zipCodeInput');
                
                // Reset validation
                $(this).removeClass('is-invalid');
                $(this).closest('.mb-3').find('.invalid-feedback').hide();
                barangaySelect.removeClass('is-invalid');
                barangaySelect.closest('.mb-3').find('.invalid-feedback').hide();
                zipCodeInput.removeClass('is-invalid');
                zipCodeInput.closest('.mb-3').find('.invalid-feedback').hide();
                
                if (!municipality) {
                    barangaySelect.prop('disabled', true).html('<option value="">Select municipality first</option>');
                    zipCodeInput.val('');
                    return;
                }
                
                // Show loading
                barangaySelect.prop('disabled', true).html('<option value="">Loading barangays...</option>');
                zipCodeInput.val('Loading...');
                
                // Fetch barangays and zip code
                $.ajax({
                    url: '{{ route("owner.studio.get-barangays", ["municipality" => "__MUNICIPALITY__"]) }}'.replace('__MUNICIPALITY__', municipality),
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Populate barangay dropdown
                        let barangayOptions = '<option value="">Select barangay</option>';
                        if (response.barangays && response.barangays.length > 0) {
                            response.barangays.forEach(barangay => {
                                barangayOptions += `<option value="${barangay}">${barangay}</option>`;
                            });
                        } else {
                            barangayOptions = '<option value="">No barangays found for this municipality</option>';
                            barangaySelect.prop('disabled', true);
                        }
                        
                        barangaySelect.html(barangayOptions).prop('disabled', false);
                        
                        // Set zip code
                        if (response.zip_code) {
                            zipCodeInput.val(response.zip_code);
                            // Create a hidden input for zip_code to ensure it's submitted
                            if (!$('#hiddenZipCode').length) {
                                $('#zipCodeInput').after(`<input type="hidden" id="hiddenZipCode" name="zip_code" value="${response.zip_code}">`);
                            } else {
                                $('#hiddenZipCode').val(response.zip_code);
                            }
                        } else {
                            zipCodeInput.val('');
                            $('#hiddenZipCode').remove();
                        }
                    },
                    error: function() {
                        barangaySelect.html('<option value="">Error loading barangays</option>').prop('disabled', true);
                        zipCodeInput.val('');
                        $('#hiddenZipCode').remove();
                    }
                });
            });

            // Create hidden input for zip_code on page load if there's already a value
            const initialZipCode = $('#zipCodeInput').val();
            if (initialZipCode && initialZipCode !== '') {
                $('#zipCodeInput').after(`<input type="hidden" id="hiddenZipCode" name="zip_code" value="${initialZipCode}">`);
            }

            // Function to validate operating days
            function validateOperatingDays() {
                const checkedDays = $('#operatingDaysGroup input[type="checkbox"]:checked');
                const errorElement = $('.operating-days-error');
                const operatingDaysGroup = $('#operatingDaysGroup');
                
                if (checkedDays.length === 0) {
                    operatingDaysGroup.addClass('border border-danger rounded');
                    errorElement.show();
                    return false;
                } else {
                    operatingDaysGroup.removeClass('border border-danger rounded');
                    errorElement.hide();
                    return true;
                }
            }

            // Validate operating days when checkboxes change
            $('#operatingDaysGroup input[type="checkbox"]').on('change', function() {
                validateOperatingDays();
            });

            // AJAX Form Submission
            $('#studioRegistrationForm').on('submit', function(e) {
                e.preventDefault();
                
                // Validate operating days before submission
                if (!validateOperatingDays()) {
                    // Scroll to operating days section
                    $('html, body').animate({
                        scrollTop: $('#operatingDaysGroup').offset().top - 100
                    }, 500);
                    return;
                }
                
                // Validate other required fields before submission
                if (!validateForm()) {
                    return;
                }
                
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const originalText = submitBtn.html();
                
                // Show loading state
                submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...'
                );
                
                // Prepare form data
                const formData = new FormData(this);
                
                // Get selected service categories (multi-select)
                const serviceCategoriesSelect = document.querySelector('select[name="service_categories[]"]');
                if (serviceCategoriesSelect && serviceCategoriesSelect.choices) {
                    const selectedCategories = serviceCategoriesSelect.choices.getValue(true);
                    // Clear existing values and add new ones
                    formData.delete('service_categories[]');
                    selectedCategories.forEach(value => {
                        formData.append('service_categories[]', value);
                    });
                }
                
                // Get selected operating days from checkboxes
                const selectedOperatingDays = [];
                $('#operatingDaysGroup input[type="checkbox"]:checked').each(function() {
                    selectedOperatingDays.push($(this).val());
                });
                
                // Clear existing operating days values and add new ones from checkboxes
                formData.delete('operating_days[]');
                selectedOperatingDays.forEach(value => {
                    formData.append('operating_days[]', value);
                });
                
                // Ensure barangay value is included
                const barangayValue = $('#barangaySelect').val();
                if (barangayValue) {
                    formData.set('barangay', barangayValue);
                }
                
                // Ensure zip_code value is included (use hidden input value)
                const zipCodeValue = $('#hiddenZipCode').val() || $('#zipCodeInput').val();
                if (zipCodeValue) {
                    formData.set('zip_code', zipCodeValue);
                }
                
                // AJAX request
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 1500,
                                timerProgressBar: true
                            }).then(() => {
                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred. Please try again.';
                        let errors = {};
                        
                        if (xhr.status === 422) {
                            // Validation errors
                            errors = xhr.responseJSON.errors;
                            errorMessage = 'Please fix the following errors:';
                            
                            // Clear previous error messages
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').hide();
                            $('.border-danger').removeClass('border border-danger rounded');
                            
                            // Show field errors
                            $.each(errors, function(field, messages) {
                                // Handle array fields
                                const fieldName = field.replace(/\.\d+/, '').replace('[]', '');
                                
                                if (fieldName === 'operating_days') {
                                    // Special handling for operating days
                                    $('#operatingDaysGroup').addClass('border border-danger rounded');
                                    $('.operating-days-error').text(messages.join(', ')).show();
                                } else {
                                    const input = $(`[name="${fieldName}"], [name="${fieldName}[]"]`);
                                    
                                    if (input.length) {
                                        input.addClass('is-invalid');
                                        const feedback = input.closest('.mb-3').find('.invalid-feedback');
                                        if (feedback.length) {
                                            feedback.text(messages.join(', ')).show();
                                        } else {
                                            // Create feedback element if it doesn't exist
                                            input.closest('.mb-3').append(`<div class="invalid-feedback">${messages.join(', ')}</div>`);
                                        }
                                    }
                                }
                            });
                            
                            // Scroll to first error
                            const firstError = $('.is-invalid, .border-danger').first();
                            if (firstError.length) {
                                $('html, body').animate({
                                    scrollTop: firstError.offset().top - 100
                                }, 500);
                            }
                        } else if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        // Show error SweetAlert only if not field validation errors
                        if (Object.keys(errors).length === 0) {
                            Swal.fire({
                                title: 'Error!',
                                html: errorMessage,
                                icon: 'error',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                timerProgressBar: true,
                                timer: 1500
                            });
                        }
                    },
                    complete: function() {
                        // Restore button state
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });
            
            // Form validation function
            function validateForm() {
                let isValid = true;
                
                // Clear previous validation
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();
                $('#operatingDaysGroup').removeClass('border border-danger rounded');
                $('.operating-days-error').hide();
                
                // Validate operating days
                if (!validateOperatingDays()) {
                    isValid = false;
                }
                
                // Check municipality
                const municipality = $('#municipalitySelect').val();
                if (!municipality) {
                    $('#municipalitySelect').addClass('is-invalid');
                    $('#municipalitySelect').closest('.mb-3').find('.invalid-feedback').show();
                    isValid = false;
                }
                
                // Check barangay
                const barangay = $('#barangaySelect').val();
                if (!barangay || barangay === '') {
                    $('#barangaySelect').addClass('is-invalid');
                    $('#barangaySelect').closest('.mb-3').find('.invalid-feedback').show();
                    isValid = false;
                }
                
                // Check zip code
                const zipCode = $('#hiddenZipCode').val() || $('#zipCodeInput').val();
                if (!zipCode || zipCode === '' || zipCode === 'Loading...') {
                    $('#zipCodeInput').addClass('is-invalid');
                    $('#zipCodeInput').closest('.mb-3').find('.invalid-feedback').show();
                    isValid = false;
                }
                
                if (!isValid) {
                    // Scroll to first error
                    const firstError = $('.is-invalid, .border-danger').first();
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                    
                    Swal.fire({
                        title: 'Validation Error!',
                        text: 'Please fill in all required fields.',
                        icon: 'error',
                        confirmButtonColor: '#DC3545',
                        confirmButtonText: 'OK'
                    });
                }
                
                return isValid;
            }
            
            // Remove invalid class on input change
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).closest('.mb-3').find('.invalid-feedback').hide();
            });
            
            // Remove border on operating days checkbox change
            $('#operatingDaysGroup input[type="checkbox"]').on('change', function() {
                $('#operatingDaysGroup').removeClass('border border-danger rounded');
                $('.operating-days-error').hide();
            });

            // Check if form should be disabled
            @if(($studioCount >= 1 && !$activeSubscription) || (isset($canRegister) && !$canRegister))
                // Disable form submission
                $('#studioRegistrationForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Subscription Required!',
                        html: 'You need an active subscription plan to register additional studios.',
                        icon: 'warning',
                        confirmButtonColor: '#3475db',
                        confirmButtonText: 'View Plans',
                        showCancelButton: true,
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("owner.subscription.index") }}';
                        }
                    });
                });
                
                // Disable all interactive elements
                $('#studioRegistrationForm input:not([readonly]):not([disabled]), ' +
                '#studioRegistrationForm select:not([disabled]), ' +
                '#studioRegistrationForm textarea:not([disabled]), ' +
                '#studioRegistrationForm button[type="submit"]').prop('disabled', true);
            @endif
            
            // Bootstrap validation
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            // Custom validation for operating days
                            const checkedDays = $('#operatingDaysGroup input[type="checkbox"]:checked');
                            if (checkedDays.length === 0) {
                                event.preventDefault();
                                event.stopPropagation();
                                $('#operatingDaysGroup').addClass('border border-danger rounded');
                                $('.operating-days-error').show();
                            }
                            
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