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
        Schema::create('shopping_carts', function (Blueprint $table) {

            $table->id();

            $table->string('session_id')->nullable();
            $table->bigInteger('customer_id')->nullable();

            $table->bigInteger('product_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->decimal('total_amount',10,2)->nullable();
            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_carts');
    }


};

/*

php artisan migrate --path=database/migrations/2025_08_20_111240_create_shopping_carts_table.php

*/
