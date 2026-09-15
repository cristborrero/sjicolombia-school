<?php

namespace App\Services\Payment;

use Illuminate\Support\Manager;

class PaymentManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return $this->config->get('payments.default', 'bold');
    }

    protected function createBoldDriver(): PaymentGatewayInterface
    {
        return new BoldGateway();
    }

    protected function createEpaycoDriver(): PaymentGatewayInterface
    {
        return new EpaycoGateway();
    }
}
