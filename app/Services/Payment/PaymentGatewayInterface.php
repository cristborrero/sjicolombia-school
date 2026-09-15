<?php

namespace App\Services\Payment;

use App\Models\Enrollment;
use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    /**
     * Create a checkout session/link for the given enrollment.
     *
     * @return array{url: string, reference: string}
     */
    public function createCheckoutSession(Enrollment $enrollment): array;

    /**
     * Process an incoming webhook from the payment gateway.
     *
     * @return array{status: string, transaction_id: string|null, payment_method: string|null}
     */
    public function handleWebhook(Request $request): array;

    /**
     * Verify the cryptographic signature of the webhook request.
     */
    public function verifySignature(Request $request): bool;

    /**
     * Get the gateway identifier.
     */
    public function getIdentifier(): string;
}
