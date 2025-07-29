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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image'); // File path for the main service image
            $table->string('image_webp'); // File path for the WebP version of the main service image
            $table->string('image_attribute')->nullable(); // Additional attributes for the main service image (nullable)
            $table->string('icon')->nullable(); // File path for the service icon (nullable)
            $table->string('icon_webp')->nullable(); // File path for the WebP version of the service icon (nullable)
            $table->string('icon_attribute')->nullable(); // Additional attributes for the service icon (nullable)
            $table->integer('sort_order')->default(0); // Sort order for displaying services
            $table->tinyInteger('status')->default(1); // 1: Active, 0: Inactive

            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
