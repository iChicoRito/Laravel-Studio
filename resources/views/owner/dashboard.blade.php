@extends('layouts.owner.app')
@section('title', 'Studio Owner Dashboard')

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">              
            <div class="page-title-head d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="fs-xl fw-bold m-0">Dashboard</h4>
                    @if($studio)
                        <p class="text-muted mt-1">{{ $studio->studio_name }}</p>
                    @endif
                </div>
            </div>          

            <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">
                <!-- Total Earnings Card -->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar fs-60 avatar-img-size flex-shrink-0 me-3">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                                        <i class="ti ti-credit-card"></i>
                                    </span>
                                </div>
                                <div class="text-start">
                                    <h3 class="mb-2 fw-normal">₱<span data-target="{{ $totalEarnings }}">{{ number_format($totalEarnings, 2) }}</span></h3>
                                    <p class="mb-0 text-muted"><span>Total Earnings</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Bookings Card -->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar fs-60 avatar-img-size flex-shrink-0 me-3">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-24">
                                        <i class="ti ti-calendar-time"></i>
                                    </span>
                                </div>
                                <div class="text-start">
                                    <h3 class="mb-2 fw-normal"><span data-target="{{ $totalBookings }}">{{ $totalBookings }}</span></h3>
                                    <p class="mb-0 text-muted"><span>Active Bookings</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Bookings Card -->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar fs-60 avatar-img-size flex-shrink-0 me-3">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-24">
                                        <i class="ti ti-checklist"></i>
                                    </span>
                                </div>
                                <div class="text-start">
                                    <h3 class="mb-2 fw-normal"><span data-target="{{ $completedBookings }}">{{ $completedBookings }}</span></h3>
                                    <p class="mb-0 text-muted"><span>Completed Bookings</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Studio Photographers Card -->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar fs-60 avatar-img-size flex-shrink-0 me-3">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-24">
                                        <i class="ti ti-users"></i>
                                    </span>
                                </div>
                                <div class="text-start">
                                    <h3 class="mb-2 fw-normal"><span data-target="{{ $totalPhotographers }}">{{ $totalPhotographers }}</span></h3>
                                    <p class="mb-0 text-muted"><span>Studio Photographers</span></p>
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
            // Initialize counter animation for statistics
            $('[data-target]').each(function() {
                var $this = $(this);
                var target = parseFloat($this.data('target'));
                
                // Skip animation if target is 0
                if (target === 0) {
                    return;
                }

                // For earnings, handle decimal values
                if ($this.parent().is('h3') && $this.parent().text().includes('₱')) {
                    $this.prop('Counter', 0).animate({
                        Counter: target
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function(now) {
                            $this.text(number_format(now, 2));
                        }
                    });
                } else {
                    // For integer values
                    $this.prop('Counter', 0).animate({
                        Counter: target
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function(now) {
                            $this.text(Math.ceil(now));
                        }
                    });
                }
            });
        });

        // Helper function to format numbers
        function number_format(number, decimals) {
            return parseFloat(number).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    </script>
@endsection