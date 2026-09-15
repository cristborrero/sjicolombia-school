<?php

namespace App\Services\Payment;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EpaycoGateway implements PaymentGatewayInterface
{
    private string $publicKey;
    private string $privateKey;
    private bool $test;

    public function __construct()
    {
        $this->publicKey = config('payments.epayco.public_key');
        $this->privateKey = config('payments.epayco.private_key');
        $this->test = config('payments.epayco.test', true);
    }

    public function createCheckoutSession(Enrollment $enrollment): array
    {
        $reference = 'SJI-' . $enrollment->id . '-' . time();

        // ePayco uses a client-side checkout widget.
        // We return the configuration data needed to initialize it.
        return [
            'url' => '', // ePayco checkout is client-side, no redirect URL from API
            'reference' => $reference,
            'epayco_config' => [
                'key' => $this->publicKey,
                'test' => $this->test,
                'name' => $enrollment->course->title,
                'description' => "Matrícula: {$enrollment->course->title}",
                'invoice' => $reference,
                'currency' => 'cop',
                'amount' => (string) $enrollment->course->price_cop,
                'tax_base' => '0',
                'tax' => '0',
                'country' => 'co',
                'lang' => 'es',
                'external' => 'false',
                'response' => route('payments.epayco.response'),
                'confirmation' => route('payments.epayco.webhook'),
                'name_billing' => $enrollment->user->name,
                'email_billing' => $enrollment->user->email,
            ],
        ];
    }

    public function handleWebhook(Request $request): array
    {
        $payload = $request->all();

        // ePayco transaction statuses:
        // 1 = Accepted, 2 = Rejected, 3 = Pending, 4 = Failed
        $statusMap = [
            '1' => 'APPROVED',
            '2' => 'DECLINED',
            '3' => 'PENDING',
            '4' => 'ERROR',
        ];

        $epaycoStatus = (string) ($payload['x_cod_transaction_state'] ?? '3');

        return [
            'status' => $statusMap[$epaycoStatus] ?? 'PENDING',
            'transaction_id' => $payload['x_transaction_id'] ?? null,
            'payment_method' => $payload['x_franchise'] ?? null,
        ];
    }

    public function verifySignature(Request $request): bool
    {
        $payload = $request->all();

        $signature = $payload['x_signature'] ?? '';

        // ePayco signature: SHA256(p_cust_id_cliente ^ p_key ^ x_ref_payco ^ x_transaction_id ^ x_amount ^ x_currency_code)
        $expected = hash(
            'sha256',
            $this->publicKey
            . '^' . $this->privateKey
            . '^' . ($payload['x_ref_payco'] ?? '')
            . '^' . ($payload['x_transaction_id'] ?? '')
            . '^' . ($payload['x_amount'] ?? '')
            . '^' . ($payload['x_currency_code'] ?? '')
        );

        return hash_equals($expected, $signature);
    }

    public function getIdentifier(): string
    {
        return 'epayco';
    }
}
