@extends('layouts.client.app')
@section('title', 'Verifying Payment')

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center min-vh-70">
                <div class="col-lg-6 col-md-8">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h3 class="text-primary mb-3">Verifying Payment</h3>
                                <p class="text-muted mb-0">{{ $message ?? 'Please wait while we verify your payment...' }}</p>
                            </div>
                            
                            <div class="card border mb-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Booking Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Booking Reference:</p>
                                            <p class="fw-medium mb-3">{{ $booking->booking_reference }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Amount:</p>
                                            <p class="fw-medium mb-3">₱{{ number_format($payment->amount, 2) }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Status:</p>
                                            <p class="fw-medium mb-3">
                                                <span class="badge bg-{{ $status === 'pending' ? 'warning' : ($status === 'checking' ? 'info' : 'secondary') }}">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </p>
                                        </div>
                                        @if(isset($payment->payment_details['payment_method']))
                                        <div class="col-md-6">
                                            <p class="text-muted small mb-1">Payment Method:</p>
                                            <p class="fw-medium mb-3">{{ ucfirst(str_replace('_', ' ', $payment->payment_details['payment_method'])) }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                This may take a few moments. Please don't close this page.
                            </div>
                            
                            @if($status === 'pending' && isset($retry_url))
                            <div class="mb-3">
                                <a href="{{ $retry_url }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="ti ti-external-link me-2"></i> Open Payment Page
                                </a>
                            </div>
                            @endif
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-center">
                                <button onclick="location.reload()" class="btn btn-primary">
                                    <i class="ti ti-refresh me-2"></i> Check Again
                                </button>
                                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-home me-2"></i> Back to Dashboard
                                </a>
                            </div>
                            
                            <div class="mt-4">
                                <p class="text-muted small">
                                    If payment isn't verified within 5 minutes, please 
                                    <a href="mailto:support@snapstudio.com" class="text-primary">contact support</a> 
                                    with your booking reference.
                                </p>
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
            // Auto-refresh after 5 seconds if still checking
            if ('{{ $status }}' === 'checking' || '{{ $status }}' === 'pending') {
                setTimeout(function() {
                    location.reload();
                }, 5000); // 5 seconds
            }
            
            // Show SweetAlert for certain statuses
            @if($status === 'pending')
            Swal.fire({
                icon: 'info',
                title: 'Payment Pending',
                text: 'Your payment is still being processed. This page will refresh automatically.',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
            @endif
            
            @if(isset($error))
            Swal.fire({
                icon: 'error',
                title: 'Verification Error',
                text: '{{ $error }}',
                confirmButtonColor: '#3475db'
            });
            @endif
        });
    </script>
@endsection