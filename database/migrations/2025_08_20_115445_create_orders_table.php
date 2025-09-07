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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->string('shopping_cart_session_id')->nullable();
            $table->decimal('total_amount',10,2)->nullable();
            $table->string('order_status')->nullable();
            $table->string('dispatch_status')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('txn_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};


/*

php artisan migrate --path=database/migrations/2025_08_20_115445_create_orders_table.php

*/
