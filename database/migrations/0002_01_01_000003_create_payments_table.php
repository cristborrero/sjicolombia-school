<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('gateway'); // bold | epayco
            $table->string('gateway_transaction_id')->nullable()->unique();
            $table->string('gateway_reference')->nullable()->unique();
            $table->decimal('amount_cop', 12, 2);
            $table->string('payment_method')->nullable(); // PSE, NEQUI, CARD, BANCOLOMBIA
            $table->string('status')->default('PENDING'); // PENDING, APPROVED, DECLINED, ERROR
            $table->json('raw_webhook_payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
