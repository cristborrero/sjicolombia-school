<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id', 'user_id', 'gateway',
        'gateway_transaction_id', 'gateway_reference',
        'amount_cop', 'payment_method', 'status',
        'raw_webhook_payload', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount_cop' => 'decimal:2',
            'raw_webhook_payload' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'APPROVED';
    }

    public function isPending(): bool
    {
        return $this->status === 'PENDING';
    }
}
