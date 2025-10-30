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
        Schema::create('customer_reviews', function (Blueprint $table) {
            $table->id();
            // Assuming product_id refers to a product in another table
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('name')->nullable();
            $table->text('message')->nullable(); // fixed typo 'messsage' and changed to text for longer reviews
            $table->unsignedTinyInteger('star_rating')->nullable(); // better for numeric rating (1–5)
            $table->date('review_date')->nullable(); // clearer and proper type for dates
            $table->boolean('verified_buyer')->default(false);
            $table->boolean('approved')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_reviews');
    }
};


/*

php artisan migrate --path=database/migrations/2025_10_10_064401_create_customer_reviews_table.php

*/
