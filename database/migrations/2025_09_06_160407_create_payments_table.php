<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id'); // link to your orders table
            $table->string('payment_type'); // e.g., 'PhonePe', 'COD', 'Card'
            $table->string('transaction_id')->nullable(); // txnId for online payments
            $table->string('status')->nullable(); // COMPLETED, PENDING, FAILED
            $table->bigInteger('amount')->nullable(); // amount in paisa/ smallest unit
            $table->json('payment_details')->nullable(); // full JSON for reference
            $table->string('payment_mode')->nullable(); // e.g., UPI, Account, Cash

            $table->timestamps();
     });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

/*

php artisan migrate --path=database/migrations/2025_09_06_160407_create_payments_table.php
*/
