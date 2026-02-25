@extends('layouts.owner.app')
@section('title', 'Payment Successful')

@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row justify-content-center mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="ti ti-circle-check text-success" style="font-size: 80px;"></i>
                            </div>
                            
                            <h2 class="mb-3">Payment Successful!</h2>
                            
                            <p class="text-muted mb-4">
                                Thank you for subscribing to <strong>{{ $plan->name ?? 'our plan' }}</strong>.
                                Your subscription is now active.
                            </p>
                            
                            <div class="card bg-light mb-4 mx-auto" style="max-width: 400px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subscription Reference:</span>
                                        <strong>{{ $subscription->subscription_reference }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Amount Paid:</span>
                                        <strong>₱{{ number_format($subscription->amount_paid, 2) }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Valid Until:</span>
                                        <strong>{{ $subscription->end_date->format('M d, Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('owner.dashboard') }}" class="btn btn-primary">
                                    <i class="ti ti-home me-2"></i>Go to Dashboard
                                </a>
                                <a href="{{ route('owner.subscription.index') }}" class="btn btn-outline-primary">
                                    <i class="ti ti-credit-card me-2"></i>View Plans
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection