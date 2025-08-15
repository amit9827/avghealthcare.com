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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('featured_image')->nullable();
            $table->text('benefit_image')->nullable();
            $table->text('banner_image')->nullable();
            $table->text('description')->nullable();

            $table->longtext('long_description')->nullable();
            $table->longtext('ingredients')->nullable();
            $table->string('ingredients_tags')->nullable();
            $table->longtext('benefits')->nullable();
            $table->string('benefits_tags')->nullable();



            $table->string('sku')->nullable()->unique();
            $table->decimal('min_price', 10, 2)->nullable();
            $table->decimal('max_price', 10, 2)->nullable();
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('sale_start_date')->nullable();
            $table->string('sale_end_date')->nullable();
            $table->boolean('onsale')->default(false)->nullable();
            $table->boolean('visibility')->default(false)->nullable();
            $table->boolean('featured')->default(false)->nullable();
            $table->string('product_type')->nullable();
            $table->string('slug')->nullable();

            $table->integer('stock_quantity')->nullable();
            $table->string('stock_status')->default('instock'); // e.g., instock, outofstock
            $table->integer('rating_count')->nullable();
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->unsignedBigInteger('total_sales')->default(0)->nullable();
            $table->string('tax_status')->nullable(); // e.g., taxable
            $table->string('tax_class')->nullable();
            $table->boolean('is_starred')->default(0)->nullable();
            $table->string('weight')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->integer('priority')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();






            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

/*

php artisan migrate --path=database/migrations/2025_08_13_144454_create_products_table.php

*/
