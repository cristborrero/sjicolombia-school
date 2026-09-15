<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Payment\PaymentGatewayInterface;
use App\Services\Payment\PaymentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle Bold.co webhook notifications.
     */
    public function boldWebhook(Request $request)
    {
        $gateway = app(PaymentManager::class)->driver('bold');

        return $this->processWebhook($request, $gateway, 'bold');
    }

    /**
     * Handle ePayco webhook (confirmation) notifications.
     */
    public function epaycoWebhook(Request $request)
    {
        $gateway = app(PaymentManager::class)->driver('epayco');

        return $this->processWebhook($request, $gateway, 'epayco');
    }

    /**
     * Handle ePayco redirect response page.
     */
    public function epaycoResponse(Request $request)
    {
        $refPayco = $request->input('ref_payco');

        if ($refPayco) {
            $payment = Payment::where('gateway_transaction_id', $refPayco)->first();

            if ($payment && $payment->isApproved()) {
                return redirect()->route('payments.success');
            }
        }

        return redirect()->route('payments.failed');
    }

    /**
     * Common webhook processing logic.
     */
    private function processWebhook(Request $request, PaymentGatewayInterface $gateway, string $gatewayName): \Illuminate\Http\Response
    {
        Log::info("Webhook received: {$gatewayName}", [
            'payload' => $request->all(),
        ]);

        // Verify webhook signature
        if (! $gateway->verifySignature($request)) {
            Log::warning("Invalid webhook signature: {$gatewayName}");

            return response('Invalid signature', 401);
        }

        // Parse webhook data
        $data = $gateway->handleWebhook($request);

        // Find the payment by reference
        $reference = $request->input('order_id')       // Bold
            ?? $request->input('x_id_invoice')          // ePayco
            ?? $request->input('x_extra1')              // ePayco alternate
            ?? null;

        $payment = Payment::where('gateway', $gatewayName)
            ->where(function ($query) use ($reference, $data) {
                $query->where('gateway_reference', $reference)
                    ->orWhere('gateway_transaction_id', $data['transaction_id']);
            })
            ->first();

        if (! $payment) {
            Log::warning("Payment not found for webhook: {$gatewayName}", [
                'reference' => $reference,
                'transaction_id' => $data['transaction_id'],
            ]);

            return response('Payment not found', 404);
        }

        // Update payment
        $payment->update([
            'status' => $data['status'],
            'gateway_transaction_id' => $data['transaction_id'] ?? $payment->gateway_transaction_id,
            'payment_method' => $data['payment_method'] ?? $payment->payment_method,
            'raw_webhook_payload' => $request->all(),
            'paid_at' => $data['status'] === 'APPROVED' ? now() : null,
        ]);

        // If payment approved, activate enrollment
        if ($data['status'] === 'APPROVED') {
            $payment->enrollment->markAsActive();

            Log::info("Enrollment activated via {$gatewayName}", [
                'enrollment_id' => $payment->enrollment_id,
                'payment_id' => $payment->id,
            ]);
        }

        return response('OK', 200);
    }
}
