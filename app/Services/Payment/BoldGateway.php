<?php

namespace App\Services\Payment;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BoldGateway implements PaymentGatewayInterface
{
    private string $apiKey;
    private string $secretKey;
    private string $baseUrl;
    private bool $sandbox;

    public function __construct()
    {
        $this->apiKey = config('payments.bold.api_key');
        $this->secretKey = config('payments.bold.secret_key');
        $this->baseUrl = config('payments.bold.base_url');
        $this->sandbox = config('payments.bold.sandbox', true);
    }

    public function createCheckoutSession(Enrollment $enrollment): array
    {
        $reference = 'SJI-' . $enrollment->id . '-' . time();

        $response = Http::withHeaders([
            'Authorization' => "x-api-key {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/online/link/v1", [
            'amount_type' => 'CLOSE',
            'amount' => [
                'currency' => 'COP',
                'total_amount' => (int) ($enrollment->course->price_cop * 100), // Bold uses cents
            ],
            'payment_methods' => ['PSE', 'NEQUI', 'CREDIT_CARD', 'DEBIT_CARD', 'BANCOLOMBIA_TRANSFER'],
            'description' => "Matrícula: {$enrollment->course->title}",
            'order_id' => $reference,
        ]);

        if ($response->failed()) {
            Log::error('Bold checkout creation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException('Failed to create Bold checkout session');
        }

        $data = $response->json();

        return [
            'url' => $data['payload']['url'] ?? $data['url'] ?? '',
            'reference' => $reference,
        ];
    }

    public function handleWebhook(Request $request): array
    {
        $payload = $request->all();

        return [
            'status' => strtoupper($payload['status'] ?? 'PENDING'),
            'transaction_id' => $payload['transaction_id'] ?? null,
            'payment_method' => $payload['payment_method'] ?? null,
        ];
    }

    public function verifySignature(Request $request): bool
    {
        $signature = $request->header('x-bold-signature', '');
        $payload = $request->getContent();
        $expected = hash_hmac('sha256', $payload, $this->secretKey);

        return hash_equals($expected, $signature);
    }

    public function getIdentifier(): string
    {
        return 'bold';
    }
}
