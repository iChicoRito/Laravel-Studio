@extends('layouts.client.app')
@section('title', 'Payment Error')

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <div class="avatar avatar-lg bg-soft-danger rounded-circle mx-auto mb-3">
                                    <i class="ti ti-alert-circle fs-2 text-danger"></i>
                                </div>
                                <h3 class="text-danger mb-3">Payment Error</h3>
                                <p class="text-muted mb-0">{{ $message ?? 'An error occurred during payment processing.' }}</p>
                                
                                @isset($reference)
                                <div class="alert alert-light mt-3">
                                    <p class="mb-0 small">Reference: <code>{{ $reference }}</code></p>
                                </div>
                                @endisset
                            </div>
                            
                            @if(isset($contact_support) && $contact_support)
                            <div class="alert alert-warning">
                                <i class="ti ti-info-circle me-2"></i>
                                Please contact support with your booking reference.
                            </div>
                            @endif
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-center mt-4">
                                <a href="{{ route('client.dashboard') }}" class="btn btn-primary">
                                    <i class="ti ti-home me-2"></i> Back to Dashboard
                                </a>
                                <a href="mailto:support@snapstudio.com" class="btn btn-outline-primary">
                                    <i class="ti ti-mail me-2"></i> Contact Support
                                </a>
                            </div>
                            
                            <div class="mt-4">
                                <p class="text-muted small">
                                    If you believe this is an error, please save your booking reference and contact support.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection