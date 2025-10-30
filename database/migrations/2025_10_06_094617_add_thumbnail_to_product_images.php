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
        Schema::table('products', function (Blueprint $table) {
            //

            $table->string('featured_thumbnail500')->nullable();
            $table->string('featured_thumbnail300')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            //
        });
    }
};

/*

php artisan migrate --path=database/migrations/2025_10_06_094617_add_thumbnail_to_product_images.php

*/
