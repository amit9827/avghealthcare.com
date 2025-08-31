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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('featured_image')->nullable();
            $table->text('description')->nullable();

            $table->longtext('long_description')->nullable();
            $table->string('page_tags')->nullable();
            $table->string('slug')->nullable();


            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('created_by')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};


/*

php artisan migrate --path=database/migrations/2025_08_29_144542_create_pages_table.php
*/
