@extends('layouts.owner.app')
@section('title', 'Payment Failed')

@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row justify-content-center mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="ti ti-circle-x text-danger" style="font-size: 80px;"></i>
                            </div>
                            
                            <h2 class="mb-3">Payment Failed</h2>
                            
                            <p class="text-muted mb-4">
                                {{ $error ?? 'Your payment could not be processed. Please try again.' }}
                            </p>
                            
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('owner.subscription.index') }}" class="btn btn-primary">
                                    <i class="ti ti-credit-card me-2"></i>Try Again
                                </a>
                                <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-home me-2"></i>Go to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection