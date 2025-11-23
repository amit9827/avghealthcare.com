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
        //

        Schema::table('orders', function (Blueprint $table) {
            //

            $table->string('basket_discount')->nullable();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

/*

php artisan migrate --path=database/migrations/2025_11_23_175853_add-basket-discount-table-orders.php

*/
