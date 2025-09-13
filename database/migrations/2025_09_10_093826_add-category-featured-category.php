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
            $table->boolean('visibility')->default(false)->nullable();
            $table->boolean('featured')->default(false)->nullable();


            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category', function (Blueprint $table) {
            //
        });
    }
};


/*

php artisan migrate --path=database/migrations/2025_09_10_093826_add-category-featured-category.php

*/
