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
        Schema::table('categories', function (Blueprint $table) {
            //
            $table->boolean('brand_featured')->default(false)->nullable()->default(0);
            $table->string('brand_image_path')->nullable();
            $table->integer('brand_priority')->nullable()->default(0);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
};

/*

php artisan migrate --path=database/migrations/2025_09_27_064247_add_package_image_to_category.php

*/
