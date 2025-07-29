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
        Schema::create('home_about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('image'); // File path for the main image
            $table->string('image_webp'); // File path for the WebP version of the image
            $table->string('image_attribute')->nullable(); // Additional image attributes if needed
            $table->text('description'); // Description text
            $table->string('title_2')->nullable(); // Additional title if needed (nullable)
            $table->text('description_2')->nullable(); // Additional description text if needed (nullable)

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
        Schema::dropIfExists('home_about_us');
    }
};
