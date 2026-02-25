@extends('layouts.client.app')
@section('title', 'Card Payment')

{{-- STYLES --}}
@section('styles')
    <style>
        .card-element-container {
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 1rem;
            background: #f8fafc;
        }
        .card-element-container.StripeElement--focus {
            border-color: #3475db;
            box-shadow: 0 0 0 1px #3475db;
        }
        .card-element-container.StripeElement--invalid {
            border-color: #dc3545;
        }
    </style>
@endsection

{{-- CONTENTS --}}
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Card Payment</h4>
                            <p class="text-muted mb-0">Booking Reference: {{ $reference }}</p>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="alert alert-info">
                                    <i class="ti ti-info-circle me-2"></i>
                                    <strong>Test Mode:</strong> Use test card <code>4242424242424242</code> with any future expiry date and any 3-digit CVV.
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3">Payment Details</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Booking Reference:</span>
                                    <span class="fw-medium">{{ $reference }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Amount to Pay:</span>
                                    <span class="fw-medium h5 text-success">₱{{ number_format($amount, 2) }}</span>
                                </div>
                            </div>

                            <form id="payment-form">
                                @csrf
                                <input type="hidden" id="client_secret" value="{{ $client_secret }}">
                                <input type="hidden" id="stripe_key" value="{{ $stripe_key }}">
                                <input type="hidden" id="booking_reference" value="{{ $reference }}">
                                
                                <div class="mb-3">
                                    <label class="form-label">Card Information</label>
                                    <div id="card-element" class="card-element-container"></div>
                                    <div id="card-errors" class="text-danger mt-2 small"></div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" id="submit-payment" class="btn btn-primary btn-lg">
                                        <span id="submit-text">Pay ₱{{ number_format($amount, 2) }}</span>
                                        <span id="loading-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 text-center">
                                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-2"></i> Cancel Payment
                                </a>
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
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function() {
            const stripeKey = $('#stripe_key').val();
            const clientSecret = $('#client_secret').val();
            const bookingReference = $('#booking_reference').val();
            
            // Initialize Stripe
            const stripe = Stripe(stripeKey);
            
            // Create card element
            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#32325d',
                        fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#dc3545'
                    }
                }
            });
            
            cardElement.mount('#card-element');
            
            // Handle form submission
            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-payment');
            const submitText = document.getElementById('submit-text');
            const loadingSpinner = document.getElementById('loading-spinner');
            
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                
                // Disable submit button
                submitButton.disabled = true;
                submitText.textContent = 'Processing...';
                loadingSpinner.classList.remove('d-none');
                
                try {
                    // Confirm card payment with Stripe
                    const { paymentIntent, error } = await stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: cardElement,
                        }
                    });
                    
                    if (error) {
                        throw error;
                    }
                    
                    if (paymentIntent.status === 'succeeded') {
                        // Payment successful
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful!',
                            text: 'Your payment has been processed successfully.',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                        }).then(() => {
                            // Redirect to success page
                            window.location.href = '{{ route("client.payment.success", ["reference" => ":reference"]) }}'.replace(':reference', bookingReference);
                        });
                    } else {
                        throw new Error('Payment not succeeded. Status: ' + paymentIntent.status);
                    }
                    
                } catch (error) {
                    console.error('Payment error:', error);
                    
                    // Show error message
                    $('#card-errors').text(error.message || 'Payment failed. Please try again.');
                    
                    // Re-enable submit button
                    submitButton.disabled = false;
                    submitText.textContent = `Pay ₱{{ number_format($amount, 2) }}`;
                    loadingSpinner.classList.add('d-none');
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: error.message || 'Payment failed. Please try again.',
                        confirmButtonColor: '#3475db'
                    });
                }
            });
            
            // Handle card errors
            cardElement.on('change', (event) => {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        });
    </script>
@endsection