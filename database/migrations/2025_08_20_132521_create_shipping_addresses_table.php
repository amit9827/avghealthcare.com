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
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->string('session_id')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('town')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('state')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_addresses');
    }
};


/*

php artisan migrate --path=database/migrations/2025_08_20_132521_create_shipping_addresses_table.php

*/
