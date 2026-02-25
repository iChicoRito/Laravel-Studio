<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymongoService
{
    protected $secretKey;
    protected $publicKey;
    protected $baseUrl;
    protected $isTestMode;

    public function __construct()
    {
        $this->secretKey = config('services.paymongo.secret_key');
        $this->publicKey = config('services.paymongo.public_key');
        $this->baseUrl = config('services.paymongo.base_url', 'https://api.paymongo.com/v1');
        $this->isTestMode = config('services.paymongo.mode', 'test') === 'test';
    }

    /**
     * Create a checkout session with proper redirect URLs
     */
    public function createCheckoutSession($amount, $bookingReference, $currency = 'PHP', $description = 'Booking Payment')
    {
        try {
            // Your custom success URL with booking reference
            $successUrl = route('client.payment.verify', ['reference' => $bookingReference]);
            $failedUrl = route('client.payment.failed', ['reference' => $bookingReference]);
            
            $data = [
                'data' => [
                    'attributes' => [
                        'cancel_url' => $failedUrl,
                        'success_url' => $successUrl,
                        'line_items' => [[
                            'amount' => $amount * 100, // Convert to centavos
                            'currency' => $currency,
                            'name' => $description,
                            'quantity' => 1,
                        ]],
                        'description' => $description,
                        'reference_number' => $bookingReference,
                        'payment_method_types' => $this->getAvailablePaymentMethods(),
                    ],
                ],
            ];

            Log::info('Creating checkout session', [
                'data' => $data,
                'mode' => $this->isTestMode ? 'test' : 'live',
            ]);

            $response = Http::withBasicAuth($this->secretKey, '')
                ->post($this->baseUrl . '/checkout_sessions', $data);

            if ($response->successful()) {
                $responseData = $response->json()['data'];
                
                Log::info('Paymongo Checkout Session Created', [
                    'booking_reference' => $bookingReference,
                    'session_id' => $responseData['id'],
                    'checkout_url' => $responseData['attributes']['checkout_url'],
                    'payment_methods' => $data['data']['attributes']['payment_method_types'],
                ]);

                return $responseData;
            }

            Log::error('Paymongo Checkout Session Failed', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Paymongo Service Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Create a simple payment intent for testing (cards only in test mode)
     */
    public function createPaymentIntent($amount, $bookingReference, $currency = 'PHP', $description = 'Booking Payment')
    {
        try {
            $data = [
                'data' => [
                    'attributes' => [
                        'amount' => $amount * 100,
                        'currency' => $currency,
                        'payment_method_allowed' => ['card'],
                        'payment_method_options' => [
                            'card' => [
                                'request_three_d_secure' => 'any',
                            ],
                        ],
                        'description' => $description,
                        'statement_descriptor' => 'SNAPSTUDIO',
                        'metadata' => [
                            'booking_reference' => $bookingReference,
                        ],
                    ],
                ],
            ];

            Log::info('Creating payment intent', [
                'amount' => $amount,
                'reference' => $bookingReference,
                'mode' => $this->isTestMode ? 'test' : 'live',
            ]);

            $response = Http::withBasicAuth($this->secretKey, '')
                ->post($this->baseUrl . '/payment_intents', $data);

            if ($response->successful()) {
                $responseData = $response->json()['data'];
                
                Log::info('Payment Intent Created', [
                    'intent_id' => $responseData['id'],
                    'client_key' => $responseData['attributes']['client_key'],
                    'booking_reference' => $bookingReference,
                ]);

                return $responseData;
            }

            Log::error('Payment Intent Failed', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Payment Intent Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get available payment methods for current mode
     */
    public function getAvailablePaymentMethods()
    {
        // For test mode, ONLY specify card
        // Do NOT specify gcash, grab_pay, paymaya in test mode
        if ($this->isTestMode) {
            return ['card']; // Only card works in test mode
        }

        // For live mode, you can specify all methods
        return ['card', 'gcash', 'grab_pay', 'paymaya'];
    }

    /**
     * Retrieve checkout session
     */
    public function retrieveCheckoutSession($sessionId)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->get($this->baseUrl . "/checkout_sessions/{$sessionId}");

            if ($response->successful()) {
                return $response->json()['data'];
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Paymongo Retrieve Session Failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Create a payment link with redirect URLs
     */
    public function createPaymentLinkWithRedirect($amount, $bookingReference, $currency = 'PHP', $description = 'Booking Payment')
    {
        try {
            // Your custom success URL with booking reference - direct to verify page
            $successUrl = route('client.payment.verify', ['reference' => $bookingReference]);
            $failedUrl = route('client.payment.failed', ['reference' => $bookingReference]);
            
            $data = [
                'data' => [
                    'attributes' => [
                        'amount' => $amount * 100,
                        'currency' => $currency,
                        'description' => $description,
                        'remarks' => 'Booking: ' . $bookingReference,
                        // Set redirect URLs to YOUR Laravel routes
                        'redirect' => [
                            'success' => $successUrl,
                            'failed' => $failedUrl,
                            'checkout_url' => null
                        ],
                    ],
                ],
            ];

            $response = Http::withBasicAuth($this->secretKey, '')
                ->post($this->baseUrl . '/links', $data);

            if ($response->successful()) {
                $responseData = $response->json()['data'];
                
                Log::info('Payment Link with Redirect Created', [
                    'booking_reference' => $bookingReference,
                    'link_id' => $responseData['id'],
                    'success_url' => $successUrl,
                    'failed_url' => $failedUrl,
                ]);

                return $responseData;
            }

            Log::error('Paymongo Link Creation Failed', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Paymongo Service Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Check payment link status
     */
    public function checkPaymentLinkStatus($linkId)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->get($this->baseUrl . "/links/{$linkId}");

            if ($response->successful()) {
                $data = $response->json()['data'];
                
                Log::info('Payment Link Status Checked', [
                    'link_id' => $linkId,
                    'status' => $data['attributes']['status'],
                    'amount_paid' => $data['attributes']['amount_paid'] ?? 0,
                ]);

                return $data;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Paymongo Check Status Failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Test if Paymongo API is working
     */
    public function testConnection()
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post($this->baseUrl . '/links', [
                    'data' => [
                        'attributes' => [
                            'amount' => 100,
                            'currency' => 'PHP',
                            'description' => 'Test Connection',
                        ],
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json()['data'];
                return [
                    'success' => true,
                    'message' => 'Paymongo API is working!',
                    'mode' => $this->isTestMode ? 'Test Mode' : 'Live Mode',
                    'test_payment_link' => $data['attributes']['checkout_url'],
                    'note' => $this->isTestMode ? 
                        'Test mode: Only certain payment methods are available. Use test cards.' : 
                        'Live mode: All configured payment methods should be available.',
                ];
            }

            $errorData = $response->json();
            return [
                'success' => false,
                'message' => 'Paymongo API test failed',
                'error' => $errorData['errors'][0]['detail'] ?? 'Unknown error',
                'mode' => $this->isTestMode ? 'Test Mode' : 'Live Mode',
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
                'mode' => $this->isTestMode ? 'Test Mode' : 'Live Mode',
            ];
        }
    }
}